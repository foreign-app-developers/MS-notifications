<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\DBAL\Types\NotificationTypes;
use Symfony\Component\Serializer\Annotation\Groups;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
#[ORM\Table(name:"Notifications")]

class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type:"NotificationTypes")]
    #[DoctrineAssert\EnumType(entity: NotificationTypes::class)]
    private $type = null;
    #[ORM\Column]
    private ?bool $isHistory = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?bool $isReaded = null;
    #[ORM\Column]
    private ?bool $isSent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $moment = null;

    #[ORM\Column(length: 255)]
    private ?string $from_val = null;

    #[ORM\Column(type: "json")]
    private ?array $to_val = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,nullable: true)]
    private ?\DateTimeInterface $timeToSend = null;

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

    public function isIsReaded(): ?bool
    {
        return $this->isReaded;
    }

    public function setIsReaded(bool $isReaded): static
    {
        $this->isReaded = $isReaded;

        return $this;
    }
    public function setIsSent(bool $isSent): static
    {
        $this->isSent = $isSent;

        return $this;
    }

    public function getMoment(): ?\DateTimeInterface
    {
        return $this->moment;
    }

    public function setMoment(\DateTimeInterface $moment): static
    {
        $this->moment = $moment;

        return $this;
    }

    public function getFromVal(): ?string
    {
        return $this->from_val;
    }

    public function setFromVal(string $from_val): static
    {
        $this->from_val = $from_val;

        return $this;
    }

    public function getToVal(): ?array
    {
        return $this->to_val;
    }


    public function setToVal(array $to_val): static
    {
        $this->to_val = $to_val;

        return $this;
    }

    public function getTimeToSend(): ?\DateTimeInterface
    {
        return $this->timeToSend;
    }

    public function setTimeToSend(\DateTimeInterface $timeToSend): static
    {
        $this->timeToSend = $timeToSend;

        return $this;
    }
    public function setIsHistory(bool $isHistory): static
    {
        $this->isHistory = $isHistory;

        return $this;
    }
    public function isIsHistory(): ?bool
    {
        return $this->isHistory;
    }
    public function isIsSent(): ?bool
    {
        return $this->isSent;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'isHistory' => $this->isHistory,
            'content' => $this->content,
            'title' => $this->title,
            'isReaded' => $this->isReaded,
            'isSent' => $this->isSent,
            'moment' => $this->moment ? $this->moment->format('Y-m-d H:i:s') : null,
            'from_val' => $this->from_val,
            'to_val' => $this->to_val,
            'timeToSend' => $this->timeToSend ? $this->timeToSend->format('Y-m-d H:i:s') : null,
        ];
    }
}
