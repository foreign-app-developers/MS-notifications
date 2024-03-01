<?php

namespace App\Entity;


use App\Repository\UserRequisiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\DBAL\Types\NotificationTypes;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;


#[ORM\Entity(repositoryClass: UserRequisiteRepository::class)]
class UserRequisite
{
    #[ORM\Id]
    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $userId = null;
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $requisite = null;

    #[ORM\Column(type:"NotificationTypes")]
    #[DoctrineAssert\EnumType(entity: NotificationTypes::class)]
    private ?string $type = null;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getRequisite(): ?string
    {
        return $this->requisite;
    }

    public function setRequisite(string $requisite): static
    {
        $this->requisite = $requisite;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }


    public function setType(string $type): static
    {
        NotificationTypes::assertValidChoice($type);
        $this->type = $type;
        return $this;
    }
}
