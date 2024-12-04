<?php

namespace App\Models;

use Exception;
use stdClass;

class RecipeIngredient
{
    private string $name;
    private string $amount;

    public function __construct(string $name, string $amount) {
        $this->name = $name;
        $this->amount = $amount;
    }


    /**
     * @throws Exception
     */
    static public function fromJson(stdClass $json): RecipeIngredient {
        $name = property_exists($json, 'name') ? trim(strip_tags($json->name))  : throw new Exception();
        $amount = property_exists($json, 'amount') ? trim(strip_tags($json->amount)) : throw new Exception();

        if (empty($name) || empty($amount)) {
            throw new Exception();
        }

        return new RecipeIngredient(mb_strtolower($name), $amount);
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