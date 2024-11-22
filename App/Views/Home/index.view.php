<?php
/** @var \App\Core\LinkGenerator $link */

/** @var Array $data */


?>

<div class="container mt-5">

    <div class="row mb-3 filter bg-secondary-subtle">
        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
            <label for="filterType">Typ jedla:</label>
            <select class="form-control " id="filterType">
                <option value="all">Všetky</option>
                <option value="slane">Slané</option>
                <option value="sladke">Sladké</option>
            </select>
        </div>
        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
            <label for="filterTime">Čas prípravy:</label>
            <select class="form-control" id="filterTime">
                <option value="all">Všetky</option>
                <option value="15">Do 15 minút</option>
                <option value="30">Do 30 minút</option>
                <option value="60">Do 1 hodiny</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <button class="btn btn-dark">Ďaľšie inšpirácie</button>
        </div>
    </div>


    <div class="row mt-5 row-cols-1 row-cols-md-2 row-cols-xl-3">

        <?php
        foreach ($data['recipes'] as $recipe) { ?>
            <div class="col">
                <?php
                require "App/Views/Recipe/recipeCard.view.php";
                ?>
            </div>
        <?php } ?>

    </div>

</div>
