<?php

namespace EgrnXml2CsvConv\Record;

final class OwnerRegistrationPair
{
    /** @var Owner[]  */
    private array $owners;

    private ?Registration $registration = null;

    /**
     * @return Owner[]
     */
    public function getOwners(): array
    {
        return $this->owners;
    }

    public function addOwner(Owner $owner): self
    {
        $this->owners[] = $owner;

        return $this;
    }

    public function getRegistration(): Registration
    {
        return $this->registration;
    }

    public function setRegistration(Registration $registration): self
    {
        $this->registration = $registration;

        return $this;
    }
}
