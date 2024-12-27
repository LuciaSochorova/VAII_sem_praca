<?php
/** @var Array $data */

/** @var \App\Core\IAuthenticator $auth */

use App\Models\Role;

?>


<div class="container mt-5">

    <div class="mb-3">
        <h1 class="text-center">Upraviť recept</h1>
    </div>


    <?php
    require "recipeForm.view.php";
    ?>

    <?php
    if ($auth->isLogged() && $auth->getLoggedUserContext()["role"] == Role::ADMIN && !is_null($data["recipe"]->getReported())) : ?>
        <div class="text-center mb-3">
            <button id="unReportButton" class="btn btn-outline-dark">Označiť ako OK</button>
        </div>
    <?php
    endif;
    ?>


</div>
