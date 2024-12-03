<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Recipe_ingredient;
use App\Models\RecipeIngredient;
use App\Models\Step;


class RecipeController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $id = (int) $this->request()->getValue("id");

        $recipe = Recipe::getOne($id);
        if (is_null($recipe)) {
            throw new HTTPException(404);
        }

        $steps = Step::getAll(whereClause: "recipe_id = ?", whereParams: [$id], orderBy: "`order`");

        $ingredients = [];
        foreach (Recipe_ingredient::getAll("recipe_id = ?", [$id]) as $recipe_ingredient) {
            $ingredient = Ingredient::getOne($recipe_ingredient->getIngredientId());
            $ingredients[] = new RecipeIngredient( $ingredient->getName(),$recipe_ingredient->getAmount());
        }




        return $this->html(
            [
                'recipe' => $recipe,
                'steps' => $steps,
                'ingredients' => $ingredients
            ]
        );

    }

    public function add(): Response {
        return $this->html();
    }
}