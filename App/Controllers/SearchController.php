<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Recipe_ingredient;

class SearchController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $ingrs = $this->app->getRequest()->getValue("ingredients");
        $time = $this->app->getRequest()->getValue("time");
        $args = [];
        if (isset($time)) {
            $time = (int)$time > 0 ? (int)$time : null;
        }
        $recipes = [];
        if (isset($ingrs)) {
            $ingrs = urldecode($ingrs);
            $ingrs = explode(',', $ingrs);
            $ingredients = [];

            foreach ($ingrs as $ingr) {
                $all = Ingredient::getAll("`name`=?", [$ingr]);
                if (count($all) > 0) {
                    $ingredients[] = $all[0];
                }
            }
            $recipeIds = [];
            foreach ($ingredients as $index => $id) {
                $recipeIngredients = Recipe_ingredient::getAll("`ingredient_id` = ?", [$id->getId()]);
                $currentRecipeIds = array_map(function ($item) {
                    return $item->getRecipeId();
                }, $recipeIngredients);
                if ($index == 0) {
                    $recipeIds = $currentRecipeIds;
                } else {
                    $recipeIds = array_intersect($recipeIds, $currentRecipeIds);
                }

            }

            foreach ($recipeIds as $recipeId) {
                $recipe = Recipe::getOne($recipeId);
                if (isset($time)) {
                    if ($recipe->getMinutes() <= $time) {
                        $recipes[] = $recipe;
                    }
                } else {
                    $recipes[] = $recipe;
                }

            }

            $args['ingredients'] = $ingredients;

        }
        $args['recipes'] = $recipes;
        if (isset($time)) {
            $args['time'] = $time;
        }
        return $this->html($args);
    }
}