<?php

namespace Helpers;

class Message
{
    public const COLOR_INFO    = 'alert-info';
    public const COLOR_SUCCESS = 'alert-success';
    public const COLOR_ERROR   = 'alert-error';

    private string $message;
    private string $color;
    private string $title;

    public function __construct(
        string $message,
        string $color = self::COLOR_INFO,
        string $title = 'Information'
    ) {
        $this->message = $message;
        $this->color   = $color;
        $this->title   = $title;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
