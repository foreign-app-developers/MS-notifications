<?php

namespace App\Entity;

use App\DBAL\Types\NotificationTypes;
use App\Repository\PeriodNotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

#[ORM\Entity(repositoryClass: PeriodNotificationRepository::class)]
class PeriodNotification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type:"NotificationTypes")]
    #[DoctrineAssert\EnumType(entity: NotificationTypes::class)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $fromVal = null;

    #[ORM\Column(type: "integer")]
    private ?int $toVal = null;

    #[ORM\Column(length: 255)]
    private ?string $whenSend = null;

    #[ORM\Column]
    private ?bool $isHistory = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getFromVal(): ?string
    {
        return $this->fromVal;
    }

    public function setFromVal(string $fromVal): static
    {
        $this->fromVal = $fromVal;

        return $this;
    }

    public function getToVal(): int
    {
        return $this->toVal;
    }

    public function setToVal(int $toVal): static
    {
        $this->toVal = $toVal;

        return $this;
    }

    public function getWhenSend(): ?string
    {
        return $this->whenSend;
    }

    public function setWhenSend(string $whenSend): static
    {
        $this->whenSend = $whenSend;

        return $this;
    }

    public function isIsHistory(): ?bool
    {
        return $this->isHistory;
    }

    public function setIsHistory(bool $isHistory): static
    {
        $this->isHistory = $isHistory;

        return $this;
    }
}
