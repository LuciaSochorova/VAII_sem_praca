<?php
/** @var LinkGenerator $link */

/** @var Array $data */

use App\Core\LinkGenerator;


?>

<div class="container mt-5">

    <form method="get" action="<?= $link->url("index") ?>">
        <div class="row mb-3 filter bg-secondary-subtle">
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                <label for="filterType">Typ jedla:</label>
                <select class="form-control" id="filterType" name="type">
                    <option value="">Všetky</option>
                    <option value="0" <?= isset($data["type"]) && @$data["type"] === 0 ? "selected" : "" ?>>Slané</option>
                    <option value="1" <?= isset($data["type"]) && @$data["type"] === 1 ? "selected" : "" ?>>Sladké</option>
                </select>
            </div>
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                <label for="filterTime">Čas prípravy:</label>
                <select class="form-control" id="filterTime" name="time">
                    <option value="">Všetky</option>
                    <option value="15" <?= isset($data["time"]) && @$data["time"] === 15 ? "selected" : "" ?>>Do 15 minút</option>
                    <option value="30" <?= isset($data["time"]) && @$data["time"] === 30 ? "selected" : "" ?>>Do 30 minút</option>
                    <option value="60" <?= isset($data["time"]) && @$data["time"] === 60 ? "selected" : "" ?>>Do 1 hodiny</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-dark">Ďaľšie inšpirácie</button>
            </div>
        </div>
    </form>



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
