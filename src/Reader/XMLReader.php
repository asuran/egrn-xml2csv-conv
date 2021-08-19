<?php

namespace EgrnXml2CsvConv\Reader;

final class XMLReader
{

    /**
     * @throws \JsonException
     */
    public static function readXML(string $filepath): array
    {
        $xmlString = file_get_contents($filepath);

        $simpleXMLElement = simplexml_load_string($xmlString);
        $json = json_encode($simpleXMLElement, JSON_THROW_ON_ERROR);

        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }
}
