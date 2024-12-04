<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Helpers\RecipeCategory;
use App\Models\Recipe;


/**
 * Class HomeController
 * Example class of a controller
 * @package App\Controllers
 */
class HomeController extends AControllerBase
{
    /**
     * @throws HTTPException
     */
    public function index(): Response
    {
        $whereClause = NULL;
        $whereParams = [];

        $typeInt = $this->request()->getValue('type');
        if (isset($typeInt)) {
            $typeInt = filter_var($this->request()->getValue('type'), FILTER_VALIDATE_INT, [ "options" => ["min_range" => 0],"flags" => FILTER_NULL_ON_FAILURE]);
            if ($typeInt !== NULL && $typeInt < count(RecipeCategory::cases())) {
                $type = RecipeCategory::cases()[$typeInt];
            } else {
                throw new HTTPException(400);
            }
        }

        if (isset($type)) {
            $whereClause = "category = ?";
            $whereParams[] = $type->value;
        }

        $time = $this->request()->getValue('time');
        if (isset($time)) {
            $time = (int)$time;
            if ($time > 0) {
                if (!is_null($whereClause)) {
                    $whereClause .= " AND ";
                }
                $whereClause .= "minutes <= ?";
                $whereParams[] = $time;

            } else {
                throw new HTTPException(400);
            }
        }
        $recipes = Recipe::getAll(whereClause: $whereClause, whereParams: $whereParams, orderBy: "RAND()", limit: 20);


        return $this->html(['recipes' => $recipes]);
    }


}
