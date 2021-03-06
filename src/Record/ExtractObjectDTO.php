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

    public function getObjectContent(): ?string
    {
        return $this->objectcontent;
    }

    public function setObjectContent(?string $objectcontent): self
    {
        $this->objectcontent = $objectcontent;

        return $this;
    }

    public function getExplication(): ?string
    {
        return $this->explication;
    }

    public function setExplication(?string $explication): self
    {
        $this->explication = $explication;

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
