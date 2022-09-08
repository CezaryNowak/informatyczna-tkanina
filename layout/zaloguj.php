<?php

require_once setDefaultPath('controllers/layout/zalogujController.php');
?>
<div class="modal fade" id="loginPopup">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post">
            <div class="modal-header text-center bg-primary text-white">
                <h3 class="modal-title w-100" id="staticBackdropLabel">Witaj Adminie!</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-outline mb-4">
                    <label class="form-label" for="username"><b>Login</b></label>
                    <input class="form-control form-control-lg" type="text" placeholder="Podaj Login" name="username"
                           required autocomplete="username">
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label" for="password"><b>Hasło</b></label>
                    <input class="form-control form-control-lg" type="password" placeholder="Podaj Hasło"
                           name="password" required autocomplete="current-password">
                </div>
							<?php keepLoginPopup(); ?>
            </div>
            <div class="modal-footer" style="background-color: #508bfc;">
                <button type="button" class="btn btn-danger me-auto" data-bs-dismiss="modal">ZAMKNIJ</button>
                <button type="submit" name="login" class="btn btn-success">ZALOGUJ</button>
            </div>
        </form>
    </div>
</div>