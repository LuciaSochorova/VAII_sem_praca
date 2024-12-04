<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\EmptyResponse;
use App\Core\Responses\Response;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Recipe_ingredient;
use App\Models\RecipeIngredient;
use App\Models\Step;
use Exception;
use JsonException;

class RecipeApiController extends AControllerBase
{

    /**
     * @inheritDoc
     * @throws HTTPException
     */
    public function index(): Response
    {
        throw new HTTPException(501, "Not implemented");
    }

    /**
     * @throws HTTPException
     * @throws JsonException
     */
    public function saveRecipe(): Response
    {
        $json = $this->app->getRequest()->getRawBodyJSON();

        if (
            is_object($json)
            && property_exists($json, 'recipe')
            && property_exists($json, 'ingredients')
            && property_exists($json, 'steps')
        ) {
            //$json->recipe->author_id = $this->app->getAuth()->getLoggedUserId();
            $json->recipe->author_id = 1; //TODO vymazať
            $ingredients = [];
            $steps = [];
            try {
                $recipe = Recipe::fromJson($json->recipe);
                foreach ($json->ingredients as $ingredient) {
                    $ingredients[] = RecipeIngredient::fromJson($ingredient);
                }

                foreach ($json->steps as $step) {
                    $text = trim(strip_tags($step));
                    if (!empty($text)) {
                        $steps[] = $text;
                    }
                }
                if (empty($steps)) {
                    throw new Exception();
                }

            } catch (Exception $e) {
                throw new HTTPException(400, "Invalid recipe format");
            }

            $recipe->save();
            $recipeId = $recipe->getId();
            foreach ($steps as $index => $stepText) {
                $step = new Step();
                $step->setText($stepText);
                $step->setRecipeId($recipeId);
                $step->setOrder($index + 1);
                $step->save();
            }

            foreach ($ingredients as $ingredient) {
                $existing = Ingredient::getAll("name = ?", [$ingredient->getName()]);
                $ingredientId = 0;
                if (empty($existing)) {
                    $newIngredient = new Ingredient();
                    $newIngredient->setName($ingredient->getName());
                    $newIngredient->save();
                    $ingredientId = $newIngredient->getId();
                } else {
                    $ingredientId = $existing[0]->getId();
                }
                $recipeIngredient = new Recipe_ingredient();
                $recipeIngredient->setRecipeId($recipeId);
                $recipeIngredient->setIngredientId($ingredientId);
                $recipeIngredient->setAmount($ingredient->getAmount());
                $recipeIngredient->save();
            }

            return new EmptyResponse();
        }

        throw new HTTPException(400, 'Bad message structure');
    }

    /**
     * @throws HTTPException
     * @throws JsonException
     */
    public function updateRecipe(): Response
    {
        $recipeId = (int)$this->app->getRequest()->getValue("id");
        $oldRecipe = Recipe::getOne($recipeId);

        $json = $this->app->getRequest()->getRawBodyJSON();

        if (
            is_object($json)
            && property_exists($json, 'recipe')
            && property_exists($json, 'ingredients')
            && property_exists($json, 'steps')
        ) {
            $json->recipe->author_id = $oldRecipe->getAuthorId();
            $ingredients = [];
            $steps = [];
            try {
                $newRecipe = Recipe::fromJson($json->recipe);
                foreach ($json->ingredients as $ingredient) {
                    $ingredients[] = RecipeIngredient::fromJson($ingredient);
                }

                foreach ($json->steps as $step) {
                    $text = trim(strip_tags($step));
                    if (!empty($text)) {
                        $steps[] = $text;
                    }
                }
                if (empty($steps)) {
                    throw new Exception();
                }

            } catch (Exception $e) {
                throw new HTTPException(400, "Invalid recipe format");
            }

            $oldRecipe->setTitle($newRecipe->getTitle());
            $oldRecipe->setDescription($newRecipe->getDescription());
            $oldRecipe->setMinutes($newRecipe->getMinutes());
            $oldRecipe->setNotes($newRecipe->getNotes());
            $oldRecipe->setPortions($newRecipe->getPortions());
            $oldRecipe->setCategory($newRecipe->getCategory());
            $oldRecipe->setImage($newRecipe->getImage());



            foreach ($ingredients as $ingredient) {
                $existingIngredient = Ingredient::getAll("name = ?", [$ingredient->getName()]);
                if (empty($existingIngredient)) {
                    $newIngredient = new Ingredient();
                    $newIngredient->setName($ingredient->getName());
                    $newIngredient->save();
                    $newIngredientId = $newIngredient->getId();
                    $newRecipeIngredient = new Recipe_ingredient();
                    $newRecipeIngredient->setRecipeId($recipeId);
                    $newRecipeIngredient->setIngredientId($newIngredientId);
                    $newRecipeIngredient->setAmount($ingredient->getAmount());
                    $newRecipeIngredient->save();
                } else {
                    $ingredientId = $existingIngredient[0]->getId();
                    $oldRecipeIngredient = Recipe_ingredient::getAll("recipe_id = ? AND ingredient_id = ?", [$recipeId, $ingredientId]);
                    if (empty($oldRecipeIngredient)) {
                        $newRecipeIngredient = new Recipe_ingredient();
                        $newRecipeIngredient->setRecipeId($recipeId);
                        $newRecipeIngredient->setIngredientId($ingredientId);
                        $newRecipeIngredient->setAmount($ingredient->getAmount());
                        $newRecipeIngredient->save();
                    } else {
                        $oldRecipeIngredient = $oldRecipeIngredient[0];
                        $oldRecipeIngredient->setAmount($ingredient->getAmount());
                        $oldRecipeIngredient->save();
                    }
                }
            }

            foreach ($steps as $index => $step) {
                $existingStep = Step::getAll("`recipe_id` = ? AND `text` = ? AND `order` = ?",[$recipeId, $step, $index + 1]);
                if (empty($existingStep )) {
                    $newStep = new Step();
                    $newStep ->setOrder($index + 1);
                    $newStep->setText($step);
                    $newStep->setRecipeId($recipeId);
                    foreach (Step::getAll("recipe_id = ? AND `order` = ?",[$recipeId, $index + 1]) as $oldStep) {
                        $oldStep->delete();
                    }
                    $newStep->save();
                }
            }

            $oldRecipe->save();
        }
        return new EmptyResponse();
    }
}