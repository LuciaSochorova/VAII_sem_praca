<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Recipe;


class RecipeController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $id = $this->request()->getValue("id");

        /* TODO nahradiť načítaním z DB*/
        $recipe = new Recipe();
        $recipe->setId($id);
        $recipe->setTitle("Dáky názov receptu");
        $recipe->setDescription("Dáky popis receptu jfanrif iahfan ipjuhae hhufajpeuifapiuefiajfeiuhfa p fhppurvhrhvapfhrfuhap ihufrahfp afhpuiafhpaufhurhfuaf hurf haf purhfuhfua fuaf ");
        $recipe->setImage(null);
        $recipe->setNotes(null);
        $recipe->setPortions(4);
        $recipe->setMinutes(17);
        return $this->html(
            [
                'recipe' => $recipe
            ]
        );

    }

    public function add(): Response {
        return $this->html();
    }
}