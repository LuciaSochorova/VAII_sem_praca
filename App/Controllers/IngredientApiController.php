<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\EmptyResponse;
use App\Core\Responses\Response;
use App\Models\Ingredient;
use App\Models\Recipe_ingredient;
use App\Models\RecipeIngredient;
use App\Models\Role;

class IngredientApiController extends AControllerBase
{
    public function authorize(string $action)
    {
        if ($action == "deleteIngredient" || $action == "changeIngredient") {
            return $this->app->getAuth()->isLogged() && $this->app->getAuth()->getLoggedUserContext()["role"] == Role::ADMIN;
        }
        return true;

    }


    /**
     * @inheritDoc
     * @throws HTTPException
     */
    public function index(): Response
    {
        throw new HTTPException(501, "Not implemented");
    }

    public function getIngredients(): Response
    {
        $param = $this->app->getRequest()->getValue("param");
        $ingredients = Ingredient::getAll(whereClause: "`name` LIKE ?", whereParams: [$param . "%"], orderBy: "`name`");
        return $this->json($ingredients);
    }

    /**
     * @throws HTTPException
     */
    public function deleteIngredient(): Response
    {
        $id = (int)$this->app->getRequest()->getValue("id");
        $ingredient = Ingredient::getOne($id);
        if ($ingredient != null) {
            $ingredient->delete();
            return new EmptyResponse();
        }
        throw new HTTPException(404);
    }

    /**
     * @throws HTTPException
     * @throws \JsonException
     */
    public function changeIngredient(): Response
    {
        $id = (int)$this->app->getRequest()->getValue("id");
        $json = $this->app->getRequest()->getRawBodyJSON();
        $newName = property_exists($json, "name") ? $json->name : throw new HTTPException(400);
        $newName = mb_strtolower(trim(strip_tags($newName)));
        if (empty($newName)) {
            throw new HTTPException(400);
        }
        $another = Ingredient::getAll(whereClause: "`name` = ?", whereParams: [$newName]);
        $ingredient = Ingredient::getOne($id) ?? throw new HTTPException(404);
        if (empty($another)) {
            $ingredient->setName($newName);
            $ingredient->save();
            return $this->json($ingredient);
        } else {
            $recipeIngredients = Recipe_ingredient::getAll(whereClause: "`ingredient_id` = ?", whereParams: [$id]);
            foreach ($recipeIngredients as $recipeIngredient) {
                $recipeIngredient->setIngredientId($another[0]->getId());
                $recipeIngredient->save();
            }
            $ingredient->delete();
            return new EmptyResponse();
        }
    }
}