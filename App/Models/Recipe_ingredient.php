<?php

namespace App\Models;

use App\Core\Model;

class Recipe_ingredient extends Model
{
    protected ?int $id = null;

    protected int $recipe_id;
    protected int $ingredient_id;
    protected string $amount;

    public function getRecipeId(): int
    {
        return $this->recipe_id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setRecipeId(int $recipe_id): void
    {
        $this->recipe_id = $recipe_id;
    }

    public function getIngredientId(): int
    {
        return $this->ingredient_id;
    }

    public function setIngredientId(int $ingredient_id): void
    {
        $this->ingredient_id = $ingredient_id;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }


}