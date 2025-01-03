<?php
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */
use App\Models\RecipeIngredient;
use App\Models\Step;

?>

<div class="container mt-5 recipe_view">

    <div class="mb-3">
        <h1 class="text-center"><?= $data['recipe']->getTitle() ?></h1>
        <p class="text-center text-muted"><?= $data['recipe']->getDescription() ?> </p>
        <img src="<?= $data['recipe']->getImage() ?? "public/images/empty_plate.jpg" ?> "
             class="mx-auto d-block recipe_image" alt="Obrázok receptu">
    </div>

    <div class="row mb-4">
        <div class="col-md-6 text-center">
            <h5>Čas prípravy</h5>
            <p><?= $data['recipe']->getMinutes() ?> minút</p>
        </div>
        <div class="col-md-6 text-center">
            <h5>Počet porcií</h5>
            <p><?= $data['recipe']->getPortions() ?> </p>
        </div>
    </div>

    <div class="row justify-content-between my-4">
        <div class="col-md-6 ">
            <h3 class="mb-3 text-center">Ingrediencie</h3>
            <table class="table">

                <tr class="table-dark">
                    <th>Ingrediencia</th>
                    <th>Množstvo</th>
                </tr>

                <?php
                /** @var RecipeIngredient $ingredient */
                foreach ($data['ingredients'] as $ingredient) { ?>
                    <tr>
                        <td><?= $ingredient->getName() ?></td>
                        <td><?= $ingredient->getAmount() ?></td>
                    </tr>
                    <?php
                }
                ?>

            </table>
        </div>
        <div class="col-md-6">
            <h3 class="mb-2 text-center">Postup</h3>
            <ol>
                <?php
                /** @var Step $step */
                foreach ($data['steps'] as $step) { ?>
                    <li><?= $step->getText() ?></li>
                    <?php
                }
                ?>
            </ol>
        </div>
    </div>

    <div class="text-center mb-5">
        <?php
        if (!is_null($data['recipe']->getNotes())):
            ?>
            <h5>Poznámky</h5>
            <p><?= $data['recipe']->getNotes() ?> </p>
        <?php endif; ?>
    </div>

    <div class="text-center mb-3">
        <?php

        if (!is_null($data['recipe']->getReported())) {
            ?>
            <span class="badge bg-warning">Nahlásené</span>
        <?php } elseif ($auth->isLogged()) { ?>
            <a  class="btn btn-link" href="<?= $link->url("recipe.report", ["id" => $data['recipe']->getId()]) ?>">Nahlásiť</a>

        <?php } ?>
    </div>

</div>
