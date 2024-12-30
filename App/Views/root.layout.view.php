<?php

/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */

/** @var \App\Core\LinkGenerator $link */

use App\Config\Configuration;
use App\Models\Role;

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= Configuration::APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css/styl.css">
    <script src="public/js/script.js" type="module" defer></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $link->url("home.index") ?>">Receptárik</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $link->url("search.index") ?>">Vyhľadávanie</a>
                </li>


                <?php if ($auth->isLogged()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $link->url("recipe.add") ?>">Pridať recept</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $link->url("recipe.manage") ?>">Spravovať recepty</a>
                    </li>

                    <?php if ($auth->getLoggedUserContext()["role"] == Role::ADMIN) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $link->url("ingredient.catalog") ?>">Spravovať ingrediencie</a>
                        </li>
                    <?php } ?>


                    <li class="nav-item">
                        <a class="nav-link" href="<?= $link->url("profile.index") ?>">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $link->url("auth.logout") ?>">Odhlásiť</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Configuration::LOGIN_URL ?>">Prihlásenie</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $link->url("auth.signin") ?>">Registrácia</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>
</body>
</html>
