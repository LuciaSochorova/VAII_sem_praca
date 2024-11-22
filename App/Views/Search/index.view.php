<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
?>

<div class="container mt-5">
    <div>
        <div class="mb-3 d-flex gap-2 flex-wrap" id="selectedItems">
            <button type="button" class="btn btn-secondary">Ingrediencia<i class = "bi bi-x"></i>
            </button>

        </div>


        <div class="row row-cols-1 row-cols-md-2 filter bg-secondary-subtle">
            <div class="col d-flex flex-column align-items-center justify-content-center">
                <label for="searchInput">
                    Vyhladávanie ingrediencií
                </label>
                <input type="text" class="form-control" id="searchInput" placeholder="Začnite písať...">
                <div id="suggestionsBox" class="d-none"></div>
            </div>

            <div class="col d-flex flex-column align-items-center justify-content-center">
                <label for="filterTime">Čas prípravy:</label>
                <select class="form-control" id="filterTime">
                    <option value="all">Všetky</option>
                    <option value="15">Do 15 minút</option>
                    <option value="30">Do 30 minút</option>
                    <option value="60">Do 1 hodiny</option>
                </select>
            </div>

        </div>

        <div class="d-flex justify-content-center mt-3">
            <button class="btn btn-dark search_btn">Vyhľadať</button>
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