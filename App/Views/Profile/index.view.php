<?php
/** @var Array $data */

/** @var \App\Core\LinkGenerator $link */

use App\Models\Role;

?>

<div class="container mt-5 ">

    <div class="row justify-content-center">
        <div id="profileCol" class="col-lg-6 col-12 align-self-center ">

            <div class="card">
                <div class="card-header text-center">
                    <h2>Profil</h2>
                </div>

                <div class="card-body ">
                    <div class="mb-4">
                        <label for="email" class="form-label">E-mailová adresa</label>
                        <input type="email" id="email" class="form-control" value="<?= $data["email"] ?>" readonly
                               disabled>
                    </div>

                    <div class="mb-4">
                        <h4>Zmena hesla</h4>
                        <form id="changePasswordForm">
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Súčasné heslo</label>
                                <input type="password" id="currentPassword" name="currentPassword" class="form-control"
                                       placeholder="Zadajte súčasné heslo" required>
                            </div>
                            <div>
                                <label for="newPassword" class="form-label">Nové heslo</label>
                                <input type="password" id="newPassword" class="form-control" name="newPassword"
                                       pattern=".{6,}"
                                       placeholder="Zadajte nové heslo" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Potvrdenie nového hesla</label>
                                <input type="password" id="confirmPassword" class="form-control" name="confirmPassword"
                                       placeholder="Potvrďte nové heslo" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Zmeniť heslo</button>
                        </form>
                    </div>
                    <?php
                    if ($data["role"] !== Role::ADMIN) { ?>
                        <div class="mb-4">
                            <h4>Vymazanie účtu</h4>
                            <p class="text-danger">Vymazaním účtu stratíte všetky svoje dáta. Táto akcia je
                                nevratná.</p>
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                Vymazať účet
                            </button>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vymazať profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ste si istý, že chcete vymazať svoj účet? Vymazaním účtu stratíte všetky svoje dáta.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nie</button>
                <a class="btn btn-danger" href="<?= $link->url("profile.delete") ?>" >Áno, vymazať!</a>
            </div>
        </div>
    </div>
</div>
