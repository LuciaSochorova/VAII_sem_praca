<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Recipe_ingredient;
use App\Models\RecipeIngredient;
use App\Models\Role;
use App\Models\Step;


class RecipeController extends AControllerBase
{
    /**
     * @throws HTTPException
     */
    public function authorize(string $action)
    {
        switch ($action) {
            case "index":
                return true;
            default:
                if ($this->app->getAuth()->isLogged()) {
                    return true;
                } else {
                    throw new HTTPException(401);
                }

        }
    }


    /**
     * @inheritDoc
     * @throws HTTPException
     */
    public function index(): Response
    {
        $id = (int)$this->request()->getValue("id");
        $recipe = Recipe::getOne($id);
        return $this->getRecipeDetails($recipe);

    }

    public function add(): Response
    {
        return $this->html();
    }

    /**
     * @throws HTTPException
     */
    public function edit(): Response
    {
        $id = (int)$this->request()->getValue("id");
        $recipe = Recipe::getOne($id);
        if ($recipe->getAuthorId() !== $this->app->getAuth()->getLoggedUserId()) {
            if ($this->app->getAuth()->getLoggedUserContext()["role"] !== Role::ADMIN) {
                throw new HTTPException(403);
            }
        }
        return $this->getRecipeDetails($recipe);
    }

    /**
     * @throws HTTPException
     * @throws \Exception
     */
    public function delete(): Response
    {
        $id = (int)$this->app->getRequest()->getValue("id");
        $recipe = Recipe::getOne($id);
        if ($recipe->getAuthorId() !== $this->app->getAuth()->getLoggedUserId()) {
            if ($this->app->getAuth()->getLoggedUserContext()["role"] !== Role::ADMIN) {
                throw new HTTPException(403);
            }
        }
        if (isset($recipe)) {
            $recipe->delete();
            return $this->redirect($this->url("recipe.manage"));
        } else {
            throw new HTTPException(404);
        }

    }

    /**
     * @throws HTTPException
     */
    public function manage(): Response
    {
        $number = 18;
        $page = $this->app->getRequest()->getValue("page") ?? 1;
        if ($page < 1) {
            throw new HTTPException(400);
        }
        $whereClause = "`author_id`=?";
        $whereParams[] = $this->app->getAuth()->getLoggedUserId();
        if ($this->app->getAuth()->getLoggedUserContext()["role"] == Role::ADMIN) {
            $whereClause = "";
            $whereParams = [];
        }
        $recipes = Recipe::getAll(whereClause: $whereClause,whereParams: $whereParams,limit: $number + 1, offset: ($page - 1) * ($number));
        $message = "";
        if (empty($recipes)) {
            $message = "Nezdielali ste zatiaľ žiadny recept.";
        }
        $nextPage = null;
        if (!empty($recipes[$number])) {
            unset($recipes[$number]);
            $nextPage = $page + 1;
        }

        return $this->html(
            [
                'recipes' => $recipes,
                'currentPage' => $page,
                'nextPage' => $nextPage,
                'message' => $message
            ]
        );
    }

    /**
     * @return ViewResponse
     * @throws HTTPException
     */
    private function getRecipeDetails(Recipe $recipe): ViewResponse
    {

        if (is_null($recipe)) {
            throw new HTTPException(404);
        }

        $steps = Step::getAll(whereClause: "recipe_id = ?", whereParams: [$recipe->getId()], orderBy: "`order`");

        $ingredients = [];
        foreach (Recipe_ingredient::getAll("recipe_id = ?", [$recipe->getId()]) as $recipe_ingredient) {
            $ingredient = Ingredient::getOne($recipe_ingredient->getIngredientId());
            $ingredients[] = new RecipeIngredient($ingredient->getName(), $recipe_ingredient->getAmount());
        }

        return $this->html(
            [
                'recipe' => $recipe,
                'steps' => $steps,
                'ingredients' => $ingredients
            ]
        );
    }

}