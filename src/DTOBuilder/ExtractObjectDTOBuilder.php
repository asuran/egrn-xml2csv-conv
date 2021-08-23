<?php

namespace EgrnXml2CsvConv\DTOBuilder;

use EgrnXml2CsvConv\Record\ExtractObjectDTO;
use EgrnXml2CsvConv\Record\Owner;
use EgrnXml2CsvConv\Record\OwnerRegistrationPair;
use EgrnXml2CsvConv\Record\Registration;
use EgrnXml2CsvConv\Util\Util;

final class ExtractObjectDTOBuilder
{
    /**
     * @throws \Exception
     */
    public static function build(array $data): ExtractObjectDTO
    {
        $extractObjectDTO = new ExtractObjectDTO();

        if (isset($data['ReestrExtract']['ExtractObjectRight']['ExtractObject']) === false) {
            if (isset($data['ReestrExtract']['NoticelObj']['NoticeObj']['ObjectInfo'])) {
                $cadastralNumber = self::parseCadastralNumber($data['ReestrExtract']['NoticelObj']['NoticeObj']['ObjectInfo']);
                $extractObjectDTO->setCadastralNumber($cadastralNumber);
            }

            return $extractObjectDTO;
        }

        $extractObjectData = $data['ReestrExtract']['ExtractObjectRight']['ExtractObject'];

        $extractObjectDTO
            ->setCadastralNumber($extractObjectData['ObjectDesc']['CadastralNumber'] ?? null)
            ->setAssignationCodeText($extractObjectData['ObjectDesc']['Assignation_Code_Text'] ?? null)
            ->setArea($extractObjectData['ObjectDesc']['Area']['Area'] ?? null)
            ->setObjectContent($extractObjectData['ObjectDesc']['Address']['Content'] ?? null)
            ->setExplication($extractObjectData['ObjectDesc']['FloorPlan_No']['Explication'] ?? null);

        $registrationsData = self::normalizeRegistrations($extractObjectData['Registration']);
        $ownersData = self::normalizeOwners($extractObjectData['Owner']);

        foreach ($registrationsData as $number => $registrationData) {

            $pair = new OwnerRegistrationPair();
            $pair->setRegistration(
                (new Registration())
                    ->setRegNumber($registrationData['RegNumber'] ?? null)
                    ->setShareText($registrationData['ShareText'] ?? null)
                    ->setRegDate($registrationData['RegDate'] ?? null)
                    ->setEndDate($registrationData['EndDate'] ?? null)
            );

            foreach ($ownersData[$number] as $ownerData) {
                $pair->addOwner(
                    (new Owner())
                        ->setPersonName($ownerData['Person']['Content'] ?? null)
                        ->setOrganizationName($ownerData['Organization']['Name'] ?? $ownerData['Governance']['Name'] ?? null)
                );
            }

            $extractObjectDTO->addOrderRegistrationPairs($pair);
        }

        return $extractObjectDTO;
    }

    private static function normalizeRegistrations(array $registrationsData): array
    {
        $sequentialArray = [];
        if (Util::isSequentialArray($registrationsData) === false) {
            $sequentialArray[0] = $registrationsData;
        } else {
            $sequentialArray = $registrationsData;
        }

        $normalizedRegistrationsData = [];
        foreach ($sequentialArray as $registration) {
            $normalizedRegistrationsData[(int)$registration['@attributes']['RegistrNumber']] = $registration;
        }

        return $normalizedRegistrationsData;
    }

    private static function normalizeOwners(array $ownersData): array
    {
        $sequentialArray = [];
        if (Util::isSequentialArray($ownersData) === false) {
            $sequentialArray[0] = $ownersData;
        } else {
            $sequentialArray = $ownersData;
        }

        $normalizedOwnersData = [];
        foreach ($sequentialArray as $owner) {
            $normalizedOwnersData[(int)$owner['@attributes']['OwnerNumber']][] = $owner;
        }

        return $normalizedOwnersData;
    }

    /**
     * @param string $objectInfo
     * @return string
     * @throws \Exception
     */
    private static function parseCadastralNumber(string $objectInfo): string
    {
        $matches = [];
        $pregMatchResult = preg_match('/\d{2}:\d{2}:\d{1,7}:\d{1,}/', $objectInfo, $matches);

        if ($pregMatchResult === 0 || count($matches) !== 1) {
            throw new \Exception('Can not parse cadastral number');
        }

        return reset($matches);
    }
}
