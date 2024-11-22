<?php
/** @var \App\Core\LinkGenerator $link */
/** @var \App\Models\Recipe $recipe */
?>

<div class="card mb-4">
    <a href="<?= $link->url("recipe.index", ["id" => $recipe->getId()]) ?>">
        <img src="<?= $recipe->getImage() ?>" class="card-img-top"
             alt="Obrázok receptu">
    </a>
    <div class="card-body">
        <h5 class="card-title">
            <a
                    href="<?= $link->url("recipe.index", ["id" => $recipe->getId()]) ?>"><?= $recipe->getTitle() ?>
            </a>
        </h5>
        <p class="card-text"><?= $recipe->getDescription() ?></p>
    </div>
</div>
