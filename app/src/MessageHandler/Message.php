<?php

namespace App\MessageHandler;

class Message
{
    private array $to;
    private string $title;
    private string $content;
    private string $type;
    public function __construct(string $title, string $content, array $to, string $type)
    {
        $this->title = $title;
        $this->content = $content;
        $this->to=$to;
        $this->type=$type;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


}