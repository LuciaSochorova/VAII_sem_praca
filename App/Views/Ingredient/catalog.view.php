<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
?>

<div class="container mt-5">
    <h1 class="text-center">Ingrediencie</h1>

    <?php
    $letters = range('a', 'z');
    //todo other
    ?>


    <nav>
        <ul class="pagination justify-content-center d-flex flex-wrap">
            <?php foreach ($letters as $letter) {
                $currentLetter = $data["letter"] ?? "a";
                ?>
                <li class="page-item <?= $letter === $currentLetter ? 'active' : ''; ?>">
                    <a class="page-link"
                       href="<?= $link->url("ingredient.catalog", ["letter" => $letter]) ?>"><?= $letter ?></a>
                </li>
            <?php } ?>
            <li class="page-item <?= "*" === $currentLetter ? 'active' : ''; ?>">
                <a class="page-link"
                   href="<?= $link->url("ingredient.catalog", ["letter" => "*"]) ?>">ostatné</a>
            </li>
        </ul>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-12 align-self-center text-center" id="ingredientList">
            <?php
            foreach ($data["ingredients"] as $ingredient) { ?>
                <div class="d-flex align-items-center mb-3 ingredient-div">
                    <input type="text" class="form-control me-3" value="<?= $ingredient->getName() ?>" disabled>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-primary edit-btn">Upraviť</button>
                        <button type="button" class="btn btn-sm btn-primary save-btn" data-ingredientId="<?= $ingredient->getId() ?>" hidden>Uložiť</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-ingredientName="<?= $ingredient->getName() ?>"
                                data-ingredientId="<?= $ingredient->getId() ?>" class="btn btn-sm btn-danger">Vymazať
                        </button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vymazať ingredienciu</h5>
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


