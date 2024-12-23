<?php

namespace App\Services;

use Bitrix24\SDK\Services\ServiceBuilder;

class IncomingWebhookDealService
{
    protected ServiceBuilder $serviceBuilder;

    public function __construct(ServiceBuilder $serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }

    public function isRequestFromWebhook(array $data): bool
    {
        $event = $data['event'];
        $domain = $data['auth']['domain'];
        $applicationToken = $data['auth']['application_token'];
        if ($event !== 'ONCRMDEALUPDATE' || $domain !== 'b24-aiahsd.bitrix24.ru' || $applicationToken !== 'wquq6wp27009fcunwc0392fue9czyfii' || !isset($dealData['isUserCreateAccount'])) {
            return false;
        }
        return true;
    }

    public function generatePassword(int $length = 8): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $index = random_int(0, strlen($alphabet) - 1);
            $password .= $alphabet[$index];
        }

        return $password;
    }

    public function updateAuthData(int $dealId, string $phone, string $password): void
    {
        $this->serviceBuilder->getCRMScope()->deal()->update($dealId, [
            'UF_CRM_1708511589360' => $phone,
            'UF_CRM_1708511607581' => $password,
        ]);
    }

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

    public function getDocuments(array $dealData): array
    {
        return [
            'passport_all_pages' => isset($dealData['UF_CRM_1708509490009']),
            'scan_inn' => isset($dealData['UF_CRM_1708509740365']),
            'snils' => isset($dealData['UF_CRM_1708510606993']),
            'marriage_certificate' => isset($dealData['UF_CRM_1708510636060']),
            'passport_spouse' => isset($dealData['UF_CRM_1708510675413']),
            'snils_spouse' => isset($dealData['UF_CRM_1708510724402']),
            'divorce_certificate' => isset($dealData['UF_CRM_1708510771069']),
            'ndfl' => isset($dealData['UF_CRM_1708510936813']),
            'childrens_birth_certificate' => isset($dealData['UF_CRM_1708510989101']),
            'extract_egrn' => isset($dealData['UF_CRM_1708511092399']),
            'scan_pts' => isset($dealData['UF_CRM_1708511164599']),
            'sts' => isset($dealData['UF_CRM_1708511175692']),
            'pts_spouse' => isset($dealData['UF_CRM_1708511204032']),
            'sts_spouse' => isset($dealData['UF_CRM_1708511215650']),
            'dkp' => isset($dealData['UF_CRM_1708511237220']),
            'dkp_spouse' => isset($dealData['UF_CRM_1708511248493']),
            'other' => isset($dealData['UF_CRM_1708511269272']),
        ];
    }

    public function getContactData(int $contactId): array
    {
        return iterator_to_array($this->serviceBuilder->getCRMScope()->contact()->get($contactId)->contact()->getIterator());
    }

    public function getEmail(array $contactData): string
    {
        if (isset($contactData["EMAIL"][0]["VALUE"]) && is_array($contactData["EMAIL"]) && is_array($contactData["EMAIL"][0])) {
            return $contactData["EMAIL"][0]["VALUE"];
        }
        return '';
    }

    public function getPhone(array $contactData): string
    {
        if (isset($contactData["PHONE"][0]["VALUE"]) && is_array($contactData["PHONE"]) && is_array($contactData["PHONE"][0])) {
            return $contactData["PHONE"][0]["VALUE"];
        }
        return '';
    }

    public function getContactFullName(array $contactData): string
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
}
