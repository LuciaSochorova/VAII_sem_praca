<?php

namespace App\Models;

use App\Core\Model;

class Ingredient extends Model
{
    protected ?int $id = null;
    protected string $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }



}