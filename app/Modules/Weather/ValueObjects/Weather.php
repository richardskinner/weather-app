<?php

namespace App\Modules\Weather\ValueObjects;

use DateTime;
use Illuminate\Contracts\Support\Arrayable;

class Weather implements Arrayable
{
    private false|DateTime $dateTime;

    public function __construct(
        string $dateTime,
        private string $title,
        private string $description
    )
    {
        $this->dateTime = DateTime::createFromFormat('U', $dateTime);
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function toArray()
    {
        return [
            'dateTime' => $this->dateTime->format('Y-m-d H:i:s'),
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}