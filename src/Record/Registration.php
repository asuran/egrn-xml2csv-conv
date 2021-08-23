<?php

namespace EgrnXml2CsvConv\Record;

final class Registration
{
    private ?string $regNumber = null;

    private ?string $regDate = null;

    private ?string $endDate = null;

    private ?string $shareText = null;

    public function getRegNumber(): ?string
    {
        return $this->regNumber;
    }

    public function setRegNumber(?string $regNumber): self
    {
        $this->regNumber = $regNumber;

        return $this;
    }

    public function getRegDate(): ?string
    {
        return $this->regDate;
    }

    public function setRegDate(?string $regDate): self
    {
        $this->regDate = $regDate;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getRegistrationName(): ?string
    {
        return $this->registrationName;
    }

    public function setRegistrationName(?string $registrationName): self
    {
        $this->registrationName = $registrationName;

        return $this;
    }

    public function getShareText(): ?string
    {
        return $this->shareText;
    }

    public function setShareText(?string $shareText): self
    {
        $this->shareText = $shareText;

        return $this;
    }
}
