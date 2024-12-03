<?php

namespace App\Models;

class RecipeIngredient
{
    private string $name;
    private string $amount;

    public function __construct(string $name, string $amount) {
        $this->name = $name;
        $this->amount = $amount;
    }



    public function getName(): string
    {
        return $this->name;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }



}