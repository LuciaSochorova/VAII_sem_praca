<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Ingredient;
use App\Models\Role;

class IngredientController extends AControllerBase
{
    public function authorize(string $action)
    {
        return $this->app->getAuth()->isLogged() && $this->app->getAuth()->getLoggedUserContext()["role"] == Role::ADMIN;
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
     */
    public function catalog(): Response
    {
        $letter = $this->app->getRequest()->getValue("letter") ?? "a";
        $letter = trim($letter);
        if (strlen($letter) > 1) {
            throw new HTTPException(400);
        }
        $letter = $letter[0];
        if (!ctype_alpha($letter) && $letter != "*") {
            throw new HTTPException(400);
        }

        if ($letter == "*") {
            $ingredients = Ingredient::getAll(whereClause:  "`name` REGEXP '^[^a-zá-ž]'");
        } else {
            $letterParam = $letter."%";

            $ingredients = Ingredient::getAll(whereClause:  "`name` COLLATE utf8mb4_general_ci LIKE ?", whereParams: [$letterParam]);
        }


        return $this->html(
            ["ingredients" => $ingredients,
                "letter" => $letter]
        );
    }

}