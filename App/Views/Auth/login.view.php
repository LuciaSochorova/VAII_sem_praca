<?php

$layout = 'auth';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<div class="form_container">
    <div class="text-center text-danger mb-3">
        <?= @$data['message'] ?>
    </div>
    <form class="form-signin" method="post" action="<?= $link->url("login") ?>">
        <h2 class="text-center mb-4">Prihlásenie</h2>
        <div class="form-group">
            <label for="email" class="form-label">Emailová adresa</label>
            <input type="email" class="form-control" id="email" name = "login" placeholder="Zadajte email" required>
        </div>
        <div class="mt-3 form-group">
            <label for="password" class="form-label">Heslo</label>
            <input type="password" class="form-control" id= "password" name="password" placeholder="Zadajte heslo" required>
        </div>
        <button type="submit" name = "submit" class="btn btn-dark mt-4">Prihlásiť sa</button>
        <div class="text-center mt-3">
            <a href="#">Zabudli ste heslo?</a>
        </div>
        <div class="text-center mt-2">
            <a href="<?= $link->url("signin")?>">Nemáte účet? Zaregistrujte sa</a>
        </div>
    </form>

</div>