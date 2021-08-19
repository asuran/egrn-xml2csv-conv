<?php

namespace EgrnXml2CsvConv\RowBuilder;

use EgrnXml2CsvConv\Record\ExtractObjectDTO;

final class RowBuilder
{
    private const EMPTY_PLACEHOLDER = '-';

    /**
     * @param ExtractObjectDTO $extractObjectDTO
     * @return iterable|string[]
     */
    public static function build(ExtractObjectDTO $extractObjectDTO): iterable
    {
        $row = [
            'Номер помещения' => $extractObjectDTO->getCadastralNumber(),
            'Назначение помещения (жилое/нежилое)' => $extractObjectDTO->getAssignationCodeText(),
            'S, кв.м' => $extractObjectDTO->getArea(),
        ];

        foreach ($extractObjectDTO->getOrderRegistrationPairs() as $pair) {

            foreach ($pair->getOwners() as $owner) {
                $row['ФИО собственника'] = $owner->getPersonName() ?? self::EMPTY_PLACEHOLDER;
                $row['Наименование организации собственника'] = $owner->getOrganizationName() ?? self::EMPTY_PLACEHOLDER;

                $row['Доля в праве на помещение'] = $pair->getRegistration()->getShareText() ?? self::EMPTY_PLACEHOLDER;
                $row['Номер регистрации права собственности'] = $pair->getRegistration()->getRegNumber() ?? self::EMPTY_PLACEHOLDER;
                $row['Дата регистрации права собственности'] = $pair->getRegistration()->getRegDate() ?? self::EMPTY_PLACEHOLDER;
                $row['Дата прекращения права'] = $pair->getRegistration()->getEndDate() ?? self::EMPTY_PLACEHOLDER;

                if (self::isRowNotEmpty($row)) {
                    yield $row;
                }
            }
        }
    }

    private static function isRowNotEmpty(array $row): bool
    {
        foreach ($row as $column) {
            if ($column !== self::EMPTY_PLACEHOLDER) {
                return true;
            }
        }

        return false;
    }
}