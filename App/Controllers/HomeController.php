<?php

namespace App\Controllers;

use App\Core\AControllerBase;
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
    public function index(): Response
    {
        $recipes = [];
        $whereClause = NULL;
        $whereParams = [];
        $type = $this->request()->getValue('type');
        if (isset($type)) {
            $type = RecipeCategory::tryFrom($type)->value;
            $whereClause = "`category` = ?";
            $whereParams[] = $type;
        }

        $time = (int) $this->request()->getValue('time');
        if (isset($time)) {
            if ($time > 0) {
                if (!is_null($whereClause)) {
                    $whereClause .= " AND";
                }
                $whereClause .= " `minutes` <= ?";
                $whereParams[] = $time;

            }
        }
        $recipes = Recipe::getAll(whereClause: $whereClause, whereParams: $whereParams, orderBy: "RAND()", limit: 20);


        return $this->html(['recipes' => $recipes]);
    }


}
