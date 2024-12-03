<?php

namespace App\Models;

use App\Core\Model;

class Step extends Model
{
    protected ?int $id = null;

    protected int $recipe_id;

    protected string $text;

    protected int $order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getRecipeId(): int
    {
        return $this->recipe_id;
    }

    public function setRecipeId(int $recipe_id): void
    {
        $this->recipe_id = $recipe_id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }




}