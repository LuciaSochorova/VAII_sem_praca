<?php
/** @var Array $data */
/** @var Recipe $recipe */
/** @var \App\Core\LinkGenerator $link */
use App\Models\Recipe;

?>


<div class="container mt-5">

    <div class="row mt-5 row-cols-1 row-cols-md-2 row-cols-xl-3">

        <?php

        foreach ($data['recipes'] as $recipe) { ?>
            <div class="col">
                <div class="card mb-4">
                    <a href="<?= $link->url("recipe.index", ["id" => $recipe->getId()]) ?>">
                    <img src="<?= $recipe->getImage() ?? "public/images/empty_plate.jpg" ?>" class="card-img-top"
                         alt="Obrázok receptu">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a
                                    href="<?= $link->url("recipe.index", ["id" => $recipe->getId()]) ?>"><?= $recipe->getTitle() ?>
                            </a>
                        </h5>
                        <p class="card-text"><?= $recipe->getDescription() ?></p>
                        <p class="card-text"><?= $recipe->getMinutes() ?> minút</p>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <a role="button" class="btn btn-warning text-center h-100 w-100 btn-lg" href="<?= $link->url("recipe.edit", ["id" => $recipe->getId()]) ?>" ><i class="bi bi-pencil-fill"></i></a>
                            </div>
                            <div class="col">
                                <a role="button" class="btn btn-danger text-center btn-lg w-100 h-100" href="<?= $link->url("recipe.delete", ["id" => $recipe->getId()]) ?>" >
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

    <footer class="footer">
        <ul class="pagination justify-content-center">
            <?php if ($data["currentPage"] > 1) {?>
                <li class="page-item"><a class="page-link" href="<?= $link->url("recipe.manage", ["page" => $data["currentPage"] - 1]) ?>">Predchádzajúca</a></li>
            <?php }
            if (!is_null($data["nextPage"])) {?>
            <li class="page-item"><a class="page-link" href="<?= $link->url("recipe.manage", ["page" => $data["nextPage"]]) ?>">Ďalej</a></li>
            <?php } ?>


        </ul>
    </footer>

</div>



