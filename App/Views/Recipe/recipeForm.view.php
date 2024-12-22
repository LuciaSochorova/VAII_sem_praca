<?php
/** @var Array $data */

use App\Helpers\RecipeCategory; ?>


<form id="recipeForm" class="my-4 d-flex flex-column align-items-center w-100"
      data-id=<?= @$data["recipe"]?->getId() ?? 0 ?>>
    <div class="text-center d-flex flex-column align-items-center w-50">
        <label for="recipeTitle" class="form-label bold">Názov</label>
        <input type="text" id="recipeTitle" class="form-control" placeholder="Napíš názov receptu"
               value="<?= @$data['recipe']?->getTitle() ?>" required>
    </div>
    <div class="mb-3 d-flex flex-column align-items-center w-75">
        <label for="recipeDescription" class="form-label">Popis</label>
        <textarea id="recipeDescription" class="form-control" rows="3" placeholder="Napíš stručný popis receptu"
                  required><?= @$data["recipe"]?->getDescription() ?></textarea>
    </div>

    <div class="mb-3 d-flex flex-column align-items-center w-75">
        <label for="recipeImage" class="form-label">Obrázok receptu</label>
        <?php if (@$data['recipe']?->getImage()): ?>
            <div>Pôvodný súbor: <?= $data['recipe']->getImage() ?? "recept nemá vlastný obrázok" ?></div>
        <?php endif; ?>
        <input class="form-control" type="file" id="recipeImage">
    </div>

    <div class="row mb-3 gx-2 w-75 align-items-end">
        <div class="col">
            <label for="recipePortions" class="form-label">Počet porcií</label>
            <input type="number" min="1" oninput="validity.valid||(value='');" class="form-control"
                   id="recipePortions" placeholder="Počet porcií" aria-label="Počet porcií"
                   value="<?= @$data['recipe']?->getPortions() ?>" required>
        </div>
        <div class="col">
            <label for="recipeMinutes" class="form-label">Dĺžka prípravy v minútach</label>
            <input type="number" min="1" oninput="validity.valid||(value='');" class="form-control"
                   id="recipeMinutes" placeholder="Čas prípravy" aria-label="Čas prípravy"
                   value="<?= @$data['recipe']?->getMinutes() ?>" required>
        </div>
        <div class="col">
            <label for="categoryOfFood" class="form-label">Typ jedla</label>
            <select class="form-control " id="categoryOfFood">
                <option value="" <?= @$data["recipe"]?->getCategory() === null ? "selected" : "" ?>>neurčené</option>
                <option <?= @$data["recipe"]?->getCategory() === RecipeCategory::Slane->value ? "selected" : "" ?>
                        value=<?= RecipeCategory::Slane->value ?>><?= RecipeCategory::Slane->value ?></option>
                <option
                    <?= @$data["recipe"]?->getCategory() === RecipeCategory::Sladke->value ? "selected" : "" ?>value=<?= RecipeCategory::Sladke->value ?>><?= RecipeCategory::Sladke->value ?></option>
            </select>
        </div>
    </div>


    <div class="mb-3 d-flex flex-column align-items-center w-75 " id="ingredientsDiv">
        <label class="form-label">Ingrediencie</label>
        <table class="table">
            <thead class="table-dark">
            <tr>
                <th scope="col">Ingrediancia</th>
                <th scope="col">Množstvo</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody id="ingredientsTableBody">
            <?php
            $ingredients = $data['ingredients'] ?? [];
            foreach ($ingredients as $ingredient) { ?>
                <tr class="recipeIngredient">
                    <td class="w-50"><?= $ingredient->getName() ?></td>
                    <td class="w-25"><?= $ingredient->getAmount() ?></td>
                    <td class="text-center">
                        <button class="btn btn-outline-danger btn-sm" type="button">Odstrániť</button>
                    </td>
                </tr>

                <?php
            }
            ?>
            </tbody>
        </table>

        <div class="input-group">
            <input type="text" class="form-control w-25" list="ingredientsOptions" id="newRecipeIngredient"
                   placeholder="Názov ingrediencie" name="newRecipeIngredientChoice">
            <datalist id="ingredientsOptions">

            </datalist>
            <input type="text" class="form-control" id="ingredientAmount" placeholder="Množstvo" aria-label="Množstvo">
            <button class="btn btn-dark" type="button" id="addIngredientButton">Pridať</button>
        </div>


    </div>


    <div class="mb-3 d-flex flex-column align-items-center w-75">
        <label class="form-label">Kroky postupu</label>
        <ol class="list-group list-group-numbered w-100" id="stepList">
            <?php
            $steps = $data['steps'] ?? [];
            foreach ($steps as $step) { ?>
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <textarea class="form-control mx-3" rows="2"><?= $step->getText() ?></textarea>
                    <button type="button" class="btn btn-sm btn-danger">Odstrániť</button>
                </li>
                <?php
            }
            ?>
        </ol>

        <div class="input-group my-2 ">
            <textarea id="newStep" class="form-control" rows="2" placeholder="Zadajte nový krok"></textarea>
            <button type="button" id="addStepButton" class="btn btn-primary">Pridať krok</button>
        </div>
    </div>


    <div class="mb-3 d-flex flex-column align-items-center w-75">
        <label for="recipeNotes" class="form-label">Poznámky</label>
        <textarea id="recipeNotes" class="form-control" rows="2" placeholder="Poznámky ku receptu"><?= @$data["recipe"]?->getNotes() ?></textarea>
    </div>


    <div class="mb-2 d-flex flex-column align-items-center w-50">
        <button type="button" class="btn btn-success w-100" id=saveRecipe>Uložiť recept</button>
    </div>

</form>
