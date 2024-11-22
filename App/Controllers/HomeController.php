<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
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


        $recipe1 = new Recipe();
        $recipe1->setId(1);
        $recipe1->setTitle('Špagety Carbonara');
        $recipe1->setDescription('Tradičné talianske cestoviny so slaninou, vajcom a syrom.');
        $recipe1->setMinutes(25);
        $recipe1->setPortions(4);
        $recipe1->setImage('public/images/empty_plate.jpg');
        $recipe1->setNotes('Použite čerstvé vajcia a kvalitný syr Pecorino Romano.');
        $recipes[] = $recipe1;


        $recipe2 = new Recipe();
        $recipe2->setId(2);
        $recipe2->setTitle('Kurací stroganov');
        $recipe2->setDescription('Krémová omáčka s kuracím mäsom, šampiňónmi a cibuľou.');
        $recipe2->setMinutes(40);
        $recipe2->setPortions(3);
        $recipe2->setImage('public/images/empty_plate.jpg');
        $recipe2->setNotes('Podávajte s ryžou alebo cestovinami.');
        $recipes[] = $recipe2;


        $recipe3 = new Recipe();
        $recipe3->setId(3);
        $recipe3->setTitle('Cuketové placky');
        $recipe3->setDescription('Chrumkavé placky z nastrúhanej cukety, vajec a múky.');
        $recipe3->setMinutes(30);
        $recipe3->setPortions(2);
        $recipe3->setImage('public/images/empty_plate.jpg');
        $recipe3->setNotes('Pridajte kôpor pre extra chuť.');
        $recipes[] = $recipe3;


        $recipe4 = new Recipe();
        $recipe4->setId(4);
        $recipe4->setTitle('Jablkový koláč');
        $recipe4->setDescription('Klasický dezert s jablkami, škoricou a chrumkavou krustou.');
        $recipe4->setMinutes(60);
        $recipe4->setPortions(8);
        $recipe4->setImage('public/images/empty_plate.jpg');
        $recipe4->setNotes('Podávajte s vanilkovou zmrzlinou.');
        $recipes[] = $recipe4;


        $recipe5 = new Recipe();
        $recipe5->setId(5);
        $recipe5->setTitle('Tekvicová polievka');
        $recipe5->setDescription('Krémová polievka z pečenej tekvice s krutónmi.');
        $recipe5->setMinutes(50);
        $recipe5->setPortions(4);
        $recipe5->setImage('public/images/empty_plate.jpg');
        $recipe5->setNotes('Dochutíme štipkou muškátového orieška.');
        $recipes[] = $recipe5;


        return $this->html(['recipes' => $recipes]);
    }


}
