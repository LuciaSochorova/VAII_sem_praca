<?php
$layout = 'auth';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<div class="form_container">
    <div class="text-center text-danger mb-3">
        <?= @$data['message'] ?>
    </div>
    <form>
        <h2 class="text-center mb-4">Registrácia</h2>
        <div class="mb-3">
            <label for="email">Emailová adresa</label>
            <input type="email" class="form-control" id="email" placeholder="Zadajte email" required>
        </div>

        <div class="mb-2">
            <label for="password">Heslo</label>
            <input type="password" class="form-control" id="password" placeholder="Zadajte heslo" required>
        </div>
        <div class="mb-3">
            <label for="confirmPassword">Potvrdte heslo</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Zopakujte heslo" required>
        </div>
        <button type="submit" class="btn btn-dark">Registrovať sa</button>
        <div class="text-center mt-3">
            <a href="<?= \App\Config\Configuration::LOGIN_URL ?>">Už máte účet? Prihláste sa</a>
        </div>
    </form>
</div>