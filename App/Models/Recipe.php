<?php

namespace App\Models;

use App\Core\Model;
use App\Helpers\RecipeCategory;
use Exception;
use stdClass;

class Recipe extends Model
{
    protected ?int $id = null;
    protected int $author_id;
    protected string $title;
    protected string $description;
    protected int $minutes;
    protected int $portions;
    protected ?string $image;
    protected ?string $category;
    protected ?string $notes;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @throws Exception
     */
    public static function fromJson(stdClass $json): Recipe
    {
        $recipe = new Recipe();
        $recipe->id = property_exists($json, 'id') ? filter_var($json->id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1], 'flags' => FILTER_NULL_ON_FAILURE,]) : null;
        $recipe->author_id = property_exists($json, 'author_id') ? (filter_var($json->author_id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1], 'flags' => FILTER_NULL_ON_FAILURE,]) ?? throw new Exception()): throw new Exception();
        $recipe->title = property_exists($json, 'title') ? trim(strip_tags($json->title)): throw new Exception();
        $recipe->description = property_exists($json, 'description') ? trim(strip_tags($json->description)) : throw new Exception();
        $recipe->minutes = property_exists($json, 'minutes') ? (filter_var($json->minutes, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1], 'flags' => FILTER_NULL_ON_FAILURE,]) ?? throw new Exception()) : throw new Exception();
        $recipe->portions = property_exists($json, 'portions') ? (filter_var($json->portions, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1], 'flags' => FILTER_NULL_ON_FAILURE,]) ?? throw new Exception()) : throw new Exception();
        $recipe->image = property_exists($json, 'image') && !empty(trim(strip_tags($json->image)) ) ? trim(strip_tags($json->image)) : null;
        $recipe->category = property_exists($json, 'category') ? RecipeCategory::tryFrom($json->category)->value : null;
        $recipe->notes = property_exists($json, 'notes') && !empty(trim(strip_tags($json->notes))) ? trim(strip_tags($json->notes)) : null;
        if (empty($recipe->title) || empty($recipe->description)) {
            throw new Exception();
        }

        return $recipe;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getMinutes(): int
    {
        return $this->minutes;
    }

    public function setMinutes(int $minutes): void
    {
        $this->minutes = $minutes;
    }

    public function getPortions(): int
    {
        return $this->portions;
    }

    public function setPortions(int $portions): void
    {
        $this->portions = $portions;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    public function setAuthorId(int $author_id): void
    {
        $this->author_id = $author_id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }


}