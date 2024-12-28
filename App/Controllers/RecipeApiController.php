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
use App\Models\Role;
use App\Models\Step;
use Exception;
use JsonException;

class RecipeApiController extends AControllerBase
{

    public function authorize($action): bool
    {

        if ($this->app->getAuth()->isLogged()) {
            if ($action == "unReport" && $this->app->getAuth()->getLoggedUserContext()["role"] != Role::ADMIN) {
                throw new HTTPException(403);
            }
            return true;
        } else {
            throw new HTTPException(401);
        }

    }

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
            $json->recipe->author_id = $this->app->getAuth()->getLoggedUserId();
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
        if ($this->app->getAuth()->getLoggedUserContext()["role"] != Role::ADMIN ) {
            if ($this->app->getAuth()->getLoggedUserId() != $oldRecipe->getAuthorId()) {
                throw new HTTPException(403);
            }
        }

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


            $oldRecipeIngredients = Recipe_ingredient::getAll("recipe_id = ?", [$recipeId]);
            foreach ($oldRecipeIngredients as $recipeIngredient) {
                $recipeIngredient->delete();
            }

            foreach ($ingredients as $ingredient) {
                $existingIngredient = Ingredient::getAll("name = ?", [$ingredient->getName()]);
                if (empty($existingIngredient)) {
                    $newIngredient = new Ingredient();
                    $newIngredient->setName($ingredient->getName());
                    $newIngredient->save();
                    $ingredientId = $newIngredient->getId();
                } else {
                    $ingredientId = $existingIngredient[0]->getId();
                }
                $newRecipeIngredient = new Recipe_ingredient();
                $newRecipeIngredient->setRecipeId($recipeId);
                $newRecipeIngredient->setIngredientId($ingredientId);
                $newRecipeIngredient->setAmount($ingredient->getAmount());
                try {
                    $newRecipeIngredient->save();
                } catch (Exception $e) {
                    $recipeIngredients = Recipe_ingredient::getAll("recipe_id = ?", [$recipeId]);
                    foreach ($recipeIngredients as $recipeIngredient) {
                        $recipeIngredient->delete();
                    }
                    foreach ($oldRecipeIngredients as $recipeIngredient) {
                        $originalRP = new Recipe_ingredient();
                        $originalRP->setId($recipeIngredient->getId());
                        $originalRP->setRecipeId($recipeId);
                        $originalRP->setIngredientId($recipeIngredient->getIngredientId());
                        $originalRP->setAmount($recipeIngredient->getAmount());
                        $originalRP->save();
                    }
                    throw new HTTPException(409);
                }
            }

            $existingSteps = Step::getAll("`recipe_id` = ?", [$recipeId], "`order`");
            $eStepsCount = count($existingSteps);
            $nStepCount = 0;
            foreach ($steps as $index => $step) {
                if ($index < $eStepsCount) {
                    $newStep = $existingSteps[$index];
                } else {
                    $newStep = new Step();
                    $newStep->setOrder($index + 1);
                    $newStep->setRecipeId($recipeId);
                }
                $newStep->setText($step);
                $newStep->save();
                $nStepCount++;
            }
            if ($nStepCount < $eStepsCount) {
                for ($i = $nStepCount; $i < $eStepsCount; $i++) {
                    $existingSteps[$i]->delete();
                }
            }

            $oldRecipe->save();
        }
        return new EmptyResponse();
    }

    public function unReport(): Response {
        $id = (int)$this->app->getRequest()->getValue("id");
        $recipe = Recipe::getOne($id);
        if (isset($recipe)) {
            $recipe->setReported(null);
            $recipe->save();
            return new EmptyResponse();
        } else {
            throw new HTTPException(404);
        }
    }

}