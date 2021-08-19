<?php

namespace EgrnXml2CsvConv\Record;

final class Owner
{
    private ?string $personName = null;

    private ?string $organizationName = null;

    public function getPersonName(): ?string
    {
        return $this->personName;
    }

    public function setPersonName(?string $personName): self
    {
        $this->personName = $personName;

        return $this;
    }

    public function getOrganizationName(): ?string
    {
        return $this->organizationName;
    }

    public function setOrganizationName(?string $organizationName): self
    {
        $this->organizationName = $organizationName;

        return $this;
    }
}
