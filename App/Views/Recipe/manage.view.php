<?php
/** @var Array $data */
/** @var Recipe $recipe */
/** @var LinkGenerator $link */

/** @var IAuthenticator $auth */

use App\Core\IAuthenticator;
use App\Core\LinkGenerator;
use App\Helpers\Role;
use App\Models\Recipe;

?>


<div class="container mt-5" id="recipeAdministrationPage">
    <p class="text-danger"><?= $data["message"] ?></p>
    <?php
    if ($auth->getLoggedUserContext()["role"] == Role::ADMIN) { ?>
        <div class="text-center mb-3">
            <?php
            if (is_null(@$data["onlyReported"])) { ?>
                <a class="btn btn-secondary" href="<?= $link->url("recipe.manage", ["onlyReported" => true]) ?>">Zobraziť len
                    nahlásené</a>
                <?php
            } else { ?>
                <a class="btn btn-secondary" href="<?= $link->url("recipe.manage") ?>">Zobraziť všetko</a>
            <?php } ?>
        </div> <?php
    }
    ?>
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
                                <a class="btn btn-warning text-center h-100 w-100 btn-lg"
                                   href="<?= $link->url("recipe.edit", ["id" => $recipe->getId()]) ?>"><i
                                            class="bi bi-pencil-fill"></i></a>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-danger text-center btn-lg w-100 h-100" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-recipeName="<?= $recipe->getTitle() ?>" data-recipeId="<?=$recipe->getId()?>">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

    <footer class="footer">
        <ul class="pagination justify-content-center">
            <?php if ($data["currentPage"] > 1) {
                $params = ["page" => $data["currentPage"] - 1];
                if (!is_null(@$data["onlyReported"])) {
                    $params["onlyReported"] = "true";
                }
                
                ?>
                <li class="page-item"><a class="page-link"
                                         href="<?= $link->url("recipe.manage", $params) ?>">Predchádzajúca</a>
                </li>
            <?php }
            if (!is_null($data["nextPage"])) {
                $params = [$data["nextPage"]];
                if (!is_null(@$data["onlyReported"])) {
                    $params["onlyReported"] = "true";
                }
                ?>
                <li class="page-item">
                    <a class="page-link"
                                         href="<?= $link->url("recipe.manage", $params) ?>">Ďalej</a>
                </li>
            <?php } ?>


        </ul>
    </footer>

</div>


<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vymazať recept</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nie, zavrieť.</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Áno, vymazať!</button>
            </div>
        </div>
    </div>
</div>
