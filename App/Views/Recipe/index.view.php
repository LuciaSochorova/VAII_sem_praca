<?php
/** @var Array $data */
?>

<div class="container mt-5 recipe_view">

    <div class="mb-3">
        <h1 class="text-center"><?= $data['recipe']->getTitle() ?></h1>
        <p class="text-center text-muted"><?= $data['recipe']->getDescription() ?> </p>
        <img src="<?= $data['recipe']->getImage() ?? "public/images/empty_plate.jpg" ?> " class="mx-auto d-block recipe_image" alt="Obrázok receptu">
    </div>

    <div class="text-center mb-2">
        <button class="btn btn-dark"><i class="bi bi-box2-heart"></i>
            Uložiť
        </button>
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
            <h3 class="mb-3">Ingrediencie</h3>
            <table class="table">

                <tr class="table-dark">
                    <th>Ingrediencia</th>
                    <th>Množstvo</th>
                </tr>

                <tr>
                    <td>Múka</td>
                    <td>200g</td>
                </tr>
                <tr>
                    <td>Vajcia</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Cukor</td>
                    <td>100g</td>
                </tr>


            </table>
        </div>
        <div class="col-md-6">
            <h3 class="mb-2">Postup</h3>
            <ol>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Duis et dictum enim.</li>
                <li>Nulla eleifend, eros vel bibendum aliquam, odio tellus vulputate urna, quis aliquam leo arcu quis
                    diam.
                </li>
                <li>In vel augue elit. Vestibulum a risus at nunc ultricies rhoncus.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Duis et dictum enim.</li>
                <li>Nulla eleifend, eros vel bibendum aliquam, odio tellus vulputate urna, quis aliquam leo arcu quis
                    diam.
                </li>
                <li>In vel augue elit. Vestibulum a risus at nunc ultricies rhoncus.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Duis et dictum enim.</li>
                <li>Nulla eleifend, eros vel bibendum aliquam, odio tellus vulputate urna, quis aliquam leo arcu quis
                    diam.
                </li>
                <li>In vel augue elit. Vestibulum a risus at nunc ultricies rhoncus.</li>

            </ol>
        </div>
    </div>

    <div class="col text-center mb-4">
        <?php
        if (!is_null($data['recipe']->getNotes())):
            ?>
            <h5>Poznámky</h5>
            <p><?= $data['recipe']->getNotes() ?> </p>
        <?php endif; ?>
    </div>

</div>