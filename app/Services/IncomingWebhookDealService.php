<?php

namespace App\Services;

use App\Models\B24DocField;
use App\Models\B24Documents;
use App\Models\B24Status;
use App\Models\B24UserField;
use App\Models\User;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IncomingWebhookDealService
{
    protected ServiceBuilder $serviceBuilder;
    protected SettingsService $settingsService;

    public function __construct(ServiceBuilder $serviceBuilder, SettingsService $settingsService)
    {
        $this->serviceBuilder = $serviceBuilder;
        $this->settingsService = $settingsService;
    }

    public function isRequestFromWebhook(array $data, array $dealData): bool
    {
        $event = $data['event'];
        $domain = $data['auth']['domain'];
        $applicationToken = $data['auth']['application_token'];
//        $bitrixWebhookDomain = env('BITRIX_WEBHOOK_DOMAIN');
//        $bitrixWebhookDealToken = env('BITRIX_WEBHOOK_DEAL_TOKEN');
        $bitrixWebhookDomain = $this->settingsService->getValueByCode('BITRIX_WEBHOOK_DOMAIN');
        $bitrixWebhookDealToken = $this->settingsService->getValueByCode('BITRIX_WEBHOOK_DEAL_TOKEN');
        //проверить пароль, если нету, то все Ок, если есть пароль, то ничё не делаем
        if ($event !== 'ONCRMDEALUPDATE' || $domain !== $bitrixWebhookDomain || $applicationToken !== $bitrixWebhookDealToken || !$dealData['isUserCreateAccount']) {
            return false;
        }
        return true;
    }

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

    private function updateAuthData(int $dealId, string $phone, string $password): void
    {
        $fields = B24UserField::whereIn('site_field', ['userLogin', 'userPassword'])
            ->pluck('uf_crm_code', 'site_field')->toArray();

        $userLogin = $fields['userLogin']; // userLogin - код поля в б24 'UF_CRM_1708511589360'
        $userPassword = $fields['userPassword']; // userPassword - код поля в б24 'UF_CRM_1708511607581'

        $this->serviceBuilder->getCRMScope()->deal()->update($dealId, [
            $userLogin => $phone,
            $userPassword => $password,
        ]);

//        $this->serviceBuilder->getCRMScope()->deal()->update($dealId, [
//            'UF_CRM_1708511589360' => $phone,
//            'UF_CRM_1708511607581' => $password,
//        ]);
    }

    public function getDealData(int $dealId): array
    {
        $userFields = B24UserField::all();
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
                    $result['userStatus'] = $dealData[$field->uf_crm_code] ? : 0;
                    break;
                case 'userContractAmount':
                    $result['userContractAmount'] = $dealData[$field->uf_crm_code] ? : 0;
                    break;
                default:
                    $result[$field->site_field] = $dealData[$field->uf_crm_code];
                    break;
            }
        }
        $userDocuments = $this->getDocuments($dealData);
        return array_merge($result, $userDocuments) ?? [];
    }

    /*
        public function getDealData(int $dealId): array
        {
            $dealData = iterator_to_array($this->serviceBuilder->getCRMScope()->deal()->get($dealId)->deal()->getIterator());
            return [
                'contactId' => $dealData['CONTACT_ID'], //Айди контакта
                'isUserCreateAccount' => isset($dealData['UF_CRM_1708511654449']), //Создать лк клиенту
                'userLogin' => $dealData['UF_CRM_1708511589360'], //Логин лк клиента
                'userPassword' => $dealData['UF_CRM_1708511607581'], //Пароль лк клиента
                'userStatus' => $dealData['UF_CRM_1709533755311'] == null ? 0 : $dealData['UF_CRM_1709533755311'], //Статус для лк клиента
                'userContractAmount' => $dealData['UF_CRM_1725026451112'] == '' ? 0 : $dealData['UF_CRM_1725026451112'], //Сумма договора
                'userMessageFromB24' => $dealData['UF_CRM_1708511318200'], //Сообщение клиенту от компании
                'userLinkToCourt' => $dealData['UF_CRM_1708511472339'], //Ссылка на дело в суде
                'userLastAuthDate' => $dealData['UF_CRM_1715524078722'], //Дата последней авторизации (МСК)
            ];
        }
     */

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
        return [
            'name' => $contactFullName,
            'email' => $email,
            'phone' => $phone,
            'b24_status' => $b24Status->id,
            'role' => $b24Status->name === 'Должник' ? 'blocked' : 'user',
            'sum_contract' => $dealData['userContractAmount'],
            'link_to_court' => $dealData['userLinkToCourt'],
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
        $path = 'logs/log.txt';
        Log::info('createOrUpdateUser:', $dealData);
        Storage::put($path, json_encode($dealData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $documents = $this->prepareDocumentsData($dealData);

        Storage::put($path, json_encode($documents, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $userData = $this->getCommonUserData($dealData);
        $user = User::where('id_b24', $dealId)->first();
        if (!$user) {
            $password = $this->generatePassword();
            $b24Documents = B24Documents::create($documents);
            $newUserData = array_merge($userData, [
                'password' => Hash::make($password),
                'is_first_auth' => true,
                'is_registered_myself' => $dealData['dkp_spouse'],
                'documents_id' => $b24Documents->id,
                'link_to_court' => $dealData['userLinkToCourt'],
                'contact_id' => $dealData['contactId'],
                'id_b24' => $dealId,
            ]);
            $newUser = User::create($newUserData);
            $this->updateAuthData($dealId, $userData['phone'], $password);

            return $newUser;
        } else {
            $b24documentsId = B24Documents::find($user->documents_id);
            $b24documentsId->update($documents);

            $updatedUserData = array_merge($userData, [
                'password' => Hash::make($dealData['userPassword'])
            ]);

            return $user->update($updatedUserData);
        }
    }
}
