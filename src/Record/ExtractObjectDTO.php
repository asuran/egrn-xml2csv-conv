<?php

namespace EgrnXml2CsvConv\Record;

final class ExtractObjectDTO
{
    private ?string $cadastralNumber = null;

    private ?string $assignationCodeText = null;

    private ?string $area = null;

    /**
     * @var OwnerRegistrationPair[]
     */
    private array $orderRegistrationPairs = [];

    public function getCadastralNumber(): ?string
    {
        return $this->cadastralNumber;
    }

    public function setCadastralNumber(?string $cadastralNumber): self
    {
        $this->cadastralNumber = $cadastralNumber;

        return $this;
    }

    public function getAssignationCodeText(): ?string
    {
        return $this->assignationCodeText;
    }

    public function setAssignationCodeText(?string $assignationCodeText): self
    {
        $this->assignationCodeText = $assignationCodeText;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(?string $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * @return OwnerRegistrationPair[]
     */
    public function getOrderRegistrationPairs(): array
    {
        return $this->orderRegistrationPairs;
    }

    public function addOrderRegistrationPairs(OwnerRegistrationPair $ownerRegistrationPair): self
    {
        $this->orderRegistrationPairs[] = $ownerRegistrationPair;

        return $this;
    }
}
