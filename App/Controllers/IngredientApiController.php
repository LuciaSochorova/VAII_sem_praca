<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Models\Ingredient;

class IngredientApiController extends AControllerBase
{

    /**
     * @inheritDoc
     * @throws HTTPException
     */
    public function index(): Response
    {
        throw new HTTPException(501, "Not implemented");
    }

    public function getIngredients(): Response {
        $query = $this->app->getRequest()->getValue("query");
        $ingredients = Ingredient::getAll(whereClause: "`name` LIKE ?", whereParams: [$query . "%"],orderBy: "`name`");
        return $this->json($ingredients);
    }
}