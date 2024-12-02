<?php
/** @var Array $data */
?>

<div class="container mt-5">

    <div class="mb-3">
        <h1 class="text-center">Pridajte nový recept</h1>
    </div>


    <form id="recipeForm" class="mt-4 d-flex flex-column align-items-center w-100">
        <div class="text-center d-flex flex-column align-items-center w-50">
            <label for="recipeName" class="form-label bold">Názov</label>
            <input type="text" id="recipeName" class="form-control" placeholder="Napíš názov receptu" required>
        </div>
        <div class="mb-3 d-flex flex-column align-items-center w-75">
            <label for="recipeDescription" class="form-label">Popis</label>
            <textarea id="recipeDescription" class="form-control" rows="3" placeholder="Napíš stručný popis receptu"
                      required></textarea>
        </div>

        <div class="mb-3 d-flex flex-column align-items-center w-75">
            <label for="recipeImage" class="form-label">Obrázok receptu</label>
            <input class="form-control" type="file" id="recipeImage">
        </div>

        <div class="row mb-3 gx-2 w-75 align-items-end">
            <div class="col">
                <label for="recipePortions" class="form-label">Počet porcií</label>
                <input type="number" min="1" oninput="validity.valid||(value='');" class="form-control"
                       id="recipePortions" placeholder="Počet porcií" aria-label="Počet porcií" required>
            </div>
            <div class="col">
                <label for="recipeMinutes" class="form-label">Dĺžka prípravy v minútach</label>
                <input type="number" min="1" oninput="validity.valid||(value='');" class="form-control"
                       id="recipeMinutes" placeholder="Čas prípravy" aria-label="Čas prípravy" required>
            </div>
        </div>


        <div class="mb-3 d-flex flex-column align-items-center w-75">
            <label class="form-label">Ingrediencie</label>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th scope="col">Ingrediancia</th>
                    <th scope="col">Množstvo</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id = "ingredientsTableBody">

                </tbody>
            </table>

            <div class="input-group">
                <input type ="text" class="form-control w-25" list="ingredientsOptions" id="newRecipeIngredient" placeholder="Názov ingrediencie">
                <datalist id="ingredientsOptions">
                    <!-- TODO <option value="ing">-->
                </datalist>
                <input type="text" class="form-control" id ="ingredientAmount" placeholder="Množstvo" aria-label="Množstvo" >
                <button class="btn btn-dark" type="button" id="addIngredientButton">Pridať</button>
            </div>


        </div>


        <div class="mb-3 d-flex flex-column align-items-center w-75">
            <label class="form-label">Kroky postupu</label>
            <ol class="list-group list-group-numbered w-100" id="stepList"></ol>

            <div class="input-group my-2 ">
                <textarea id="newStep" class="form-control" rows="2" placeholder="Zadajte nový krok"></textarea>
                <button type="button" id="addStepButton" class="btn btn-primary">Pridať krok</button>
            </div>
        </div>


        <div class="mb-3 d-flex flex-column align-items-center w-75">
            <label for="recipeNotes" class="form-label">Poznámky</label>
            <textarea id="recipeNotes" class="form-control" rows="2" placeholder="Poznámky ku receptu"></textarea>
        </div>


        <div class="mb-2 d-flex flex-column align-items-center w-50">
            <button type="submit" class="btn btn-success w-100">Uložiť recept</button>
        </div>
    </form>


</div>


