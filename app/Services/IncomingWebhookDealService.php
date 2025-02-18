<?php

namespace App\Services;

use App\Events\UpdateAuthDataEvent;
use App\Models\B24DocField;
use App\Models\B24Documents;
use App\Models\B24Status;
use App\Models\B24UserField;
use App\Models\User;
use Bitrix24\SDK\Services\ServiceBuilder;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Random\RandomException;

class IncomingWebhookDealService
{
    protected ServiceBuilder $serviceBuilder;
    protected SettingsService $settingsService;

    public function __construct()
    {
        $this->serviceBuilder = app(ServiceBuilder::class);
        $this->settingsService = app(SettingsService::class);
    }

    public function isRequestFromWebhook(array $data, array $dealData): bool
    {
        $event = $data['event'];
        $domain = $data['auth']['domain'];
        $applicationToken = $data['auth']['application_token'];
        $bitrixWebhookDomain = $this->settingsService->getValueByCode('BITRIX_WEBHOOK_DOMAIN');
        $bitrixWebhookDealToken = $this->settingsService->getValueByCode('BITRIX_WEBHOOK_DEAL_TOKEN');
        if ($event !== 'ONCRMDEALUPDATE' || $domain !== $bitrixWebhookDomain || $applicationToken !== $bitrixWebhookDealToken || !$dealData['isUserCreateAccount']) {
            return false;
        }
        return true;
    }

    /**
     * @throws RandomException
     */
    private function generatePassword(int $length = 8): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $index = random_int(0, strlen($alphabet) - 1);
            $password .= $alphabet[$index];
        }

        return $password;
    }

    /**
     * @throws Exception
     */
    public function getDealData(int $dealId): array
    {
        Log::info('Начало получения данных по сделке', [
            'deal_id' => $dealId,
        ]);

        try {
            $userFields = B24UserField::all();
            Log::info('Получены поля пользователя', [
                'userFields_count' => $userFields->count(),
            ]);

            $dealData = iterator_to_array(
                $this->serviceBuilder->getCRMScope()->deal()->get($dealId)->deal()->getIterator()
            );

            $result = [];
            foreach ($userFields as $field) {
                switch ($field->site_field) {
                    case 'contactId':
                        $result['contactId'] = $dealData['CONTACT_ID'];
                        break;
                    case 'isUserCreateAccount':
                        $result['isUserCreateAccount'] = isset($dealData[$field->uf_crm_code]) && $dealData[$field->uf_crm_code] !== '';
                        break;
                    case 'userStatus':
                        $result['userStatus'] = $dealData[$field->uf_crm_code] ?: 0;
                        break;
                    case 'userContractAmount':
                        $result['userContractAmount'] = $dealData[$field->uf_crm_code] ?: 0;
                        break;
                    default:
                        $result[$field->site_field] = $dealData[$field->uf_crm_code];
                        break;
                }

                if ($field->site_field !== 'userPassword') {
                    Log::info('Обработано поле', [
                        'field' => $field->site_field,
                        'value' => $result[$field->site_field] ?? null,
                    ]);
                }
            }

            $userDocuments = $this->getDocuments($dealData);
            Log::info('Получены документы пользователя', [
                'documents_count' => count($userDocuments),
            ]);

            $finalResult = array_merge($result, $userDocuments);
            $finalResultCopy = [];
            foreach ($finalResult as $key => $value) {
                if ($key !== 'userPassword') {
                    $finalResultCopy[$key] = $value;
                }
            }
            Log::info('Формирование итоговых данных по сделке', [
                'finalResult' => $finalResultCopy,
            ]);

            return $finalResult;
        } catch (Exception $e) {
            Log::error('Ошибка при получении данных по сделке', [
                'deal_id' => $dealId,
                'error_message' => $e->getMessage(),
            ]);

            throw new Exception('Ошибка при получении данных по сделке: ' . $e->getMessage());
        }
    }

    private function getDocuments(array $dealData): array
    {
        $docFields = B24DocField::all();
        $documents = [];
        foreach ($docFields as $field) {
            $documents[$field->site_field] = isset($dealData[$field->uf_crm_code]);
        }

        return $documents;
    }

    private function getContactData(int $contactId): array
    {
        return iterator_to_array($this->serviceBuilder->getCRMScope()->contact()->get($contactId)->contact()->getIterator());
    }

    private function getValueByType(array $contactData, string $type): string
    {
        $key = strtoupper($type);

        if (
            isset($contactData[$key][0]['VALUE']) &&
            is_array($contactData[$key]) &&
            is_array($contactData[$key][0])
        ) {
            return $contactData[$key][0]['VALUE'];
        }

        return '';
    }

    private function getEmail(array $contactData): string
    {
        return $this->getValueByType($contactData, 'EMAIL');
    }

    private function getPhone(array $contactData): string
    {
        return $this->getValueByType($contactData, 'PHONE');
    }

    private function getContactFullName(array $contactData): string
    {
        $contactName = $contactData['NAME'];
        $contactSecondName = $contactData['SECOND_NAME'];
        $contactLastName = $contactData['LAST_NAME'];

        return trim(
            ($contactName ?? ' ') .
            ($contactSecondName ?? ' ') .
            ($contactLastName ?? '')
        );
    }

    private function getCommonUserData(array $dealData): array
    {
        $contactData = $this->getContactData($dealData['contactId']);
        $contactFullName = $this->getContactFullName($contactData);
        $email = $this->getEmail($contactData);
        $phone = $this->getPhone($contactData);

        $b24Status = B24Status::where('b24_status_id', $dealData['userStatus'])->first();

        if (!$b24Status) {
            return [
                'error' => 'Запись с указанным статусом(b24_statuses) не найдена ' . $dealData['userStatus'],
            ];
        }

        return [
            'name' => $contactFullName,
            'email' => $email,
            'phone' => $phone,
            'b24_status' => $b24Status->id,
            'role' => $b24Status->name === 'Должник' ? 'blocked' : 'user',
            'sum_contract' => $dealData['userContractAmount'],
            'link_to_court' => $dealData['userLinkToCourt'],
            'message_from_b24' => $dealData['userMessageFromB24'],
        ];
    }

    private function prepareDocumentsData(array $dealData): array
    {
        return [
            'passport_all_pages' => $dealData['passport_all_pages'],
            'scan_inn' => $dealData['scan_inn'],
            'snils' => $dealData['snils'],
            'marriage_certificate' => $dealData['marriage_certificate'],
            'passport_spouse' => $dealData['passport_spouse'],
            'snils_spouse' => $dealData['snils_spouse'],
            'divorce_certificate' => $dealData['divorce_certificate'],
            'ndfl' => $dealData['ndfl'],
            'childrens_birth_certificate' => $dealData['childrens_birth_certificate'],
            'extract_egrn' => $dealData['extract_egrn'],
            'scan_pts' => $dealData['scan_pts'],
            'sts' => $dealData['sts'],
            'pts_spouse' => $dealData['pts_spouse'],
            'sts_spouse' => $dealData['sts_spouse'],
            'dkp' => $dealData['dkp'],
            'dkp_spouse' => $dealData['dkp_spouse'],
            'other' => $dealData['other'],
        ];
    }

    public function createOrUpdateUser($dealId, $dealData)
    {
        /* todo использовать listener и event-ы */
        $dealDataCopy = [];
        foreach ($dealData as $key => $value) {
            if ($key !== 'userPassword') {
                $dealDataCopy[$key] = $value;
            }
        }
        Log::info('Начало процесса создания или обновления пользователя', [
            'deal_id' => $dealId,
            'deal_data' => $dealDataCopy,
        ]);

        $documents = $this->prepareDocumentsData($dealData);
        Log::info('Подготовлены данные документов', [
            'documents' => $documents,
        ]);

        $userData = $this->getCommonUserData($dealData);
        Log::info('Получены общие данные пользователя', [
            'user_data' => $userData,
        ]);

        if (isset($userData['error'])) {
            Log::error('Ошибка получения данных пользователя', [
                'error' => $userData['error'],
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An internal server error has occurred.',
            ], 500);
        }

        $user = User::where('id_b24', $dealId)->first();
        if (!$user) {
            Log::info('Пользователь не найден, создается новый', [
                'deal_id' => $dealId,
            ]);

            $password = $this->generatePassword();
            $b24Documents = B24Documents::create($documents);
            $newUserData = array_merge($userData, [
                'password' => Hash::make($password),
                'is_first_auth' => false,
                'is_registered_myself' => false,
                'documents_id' => $b24Documents->id,
                'link_to_court' => $dealData['userLinkToCourt'],
                'contact_id' => $dealData['contactId'],
                'id_b24' => $dealId,
            ]);
            $newUser = User::create($newUserData);
            event(new UpdateAuthDataEvent($dealId, $userData['phone'], $password));

            $newUserDataCopy = [];
            foreach ($newUserData as $key => $value) {
                if ($key !== 'userPassword') {
                    $newUserDataCopy[$key] = $value;
                }
            }
            Log::info('Новый пользователь создан', [
                'new_user_data' => $newUserDataCopy,
            ]);

            return $newUser;
        } else {
            Log::info('Пользователь найден, обновление данных', [
                'user_id' => $user->id,
                'deal_id' => $dealId,
            ]);

            $b24documentsId = B24Documents::find($user->documents_id);
            if ($b24documentsId) {
                $b24documentsId->update($documents);
                Log::info('Документы обновлены', [
                    'documents_id' => $b24documentsId->id,
                    'updated_data' => $documents,
                ]);
            } else {
                Log::warning('Документы не найдены для обновления', [
                    'user_id' => $user->id,
                    'documents_id' => $user->documents_id,
                ]);
            }

            unset($userData['email']);
            Log::info('Данные пользователя обновлены', [
                'updated_user_data' => $userData,
            ]);

            return $user->update(array_merge($userData, [
                'password' => $dealData['userPassword'],
            ]));
        }
    }

    public function validateRequestData(array $data): bool
    {
        return array_key_exists('data', $data) &&
            array_key_exists('FIELDS', $data['data']) &&
            array_key_exists('ID', $data['data']['FIELDS']);
    }
}
