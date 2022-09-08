<?php

session_start();
if (isset($_SESSION['logged_id']) && isset($_SESSION['logged_login']))
{
	require_once "../lib/functions.php";
	require_once "../data/dataFunctions.php";
	require_once "../controllers/admin/listaUzytkownikowController.php";
	require_once "../layout/defaultHead.php";
	?>
    <title>Lista Użytkowników</title>
    <meta name="description" content="Strona zawierająca listę użytkowników"/>
	<?php
	require_once "../layout/header.php";
	?>
    <div class="modal fade" id="deleteAccPopup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="post">
                <div class="modal-header text-center bg-primary text-white">
                    <h3 class="modal-title w-100" id="staticBackdropLabel">Usuń konto</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 style="text-align: center;">CZY JESTEŚ PEWIEN?</h2>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="passe"><b>Hasło</b></label>
                        <input class="form-control form-control-lg" type="password" placeholder="Podaj Hasło"
                               name="passe" required autocomplete="current-password">
                    </div>
									<?php $listUser->echoNickeError(); ?>
                </div>
                <div class="modal-footer" style="background-color: #508bfc;">
                    <button type="button" class="btn btn-warning me-auto" data-bs-dismiss="modal">ANULUJ</button>
                    <button type="submit" name="deleteAcc" class="btn btn-success">POTWIERDŹ</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="changePassPopup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="post">
                <div class="modal-header text-center bg-primary text-white">
                    <h3 class="modal-title w-100" id="staticBackdropLabel">Zmień Hasło</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="passe">Bieżące hasło</label>
                        <input class="form-control form-control-lg" type="password" placeholder="Podaj bieżące hasło"
                               name="currentPass" required autocomplete="current-password">
											<?php $listUser->echoPassError(); ?>
                        <label class="form-label" for="passe">Nowe hasło</label>
                        <input class="form-control form-control-lg" type="password" placeholder="Podaj nowe hasło"
                               name="password" required>
											<?php $listUser->echoNewPassError(); ?>
                        <label class="form-label" for="passe">Potwierdź nowe hasło</label>
                        <input class="form-control form-control-lg" type="password"
                               placeholder="Podaj ponownie nowe hasło" name="newPassConf" required>
											<?php $listUser->echoConfPassError(); ?>
											<?php $listUser->echoAError() ?>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #508bfc;">
                    <button type="button" class="btn btn-warning me-auto" data-bs-dismiss="modal">ANULUJ</button>
                    <button type="submit" name="changePass" class="btn btn-success">POTWIERDŹ</button>
                </div>
            </form>
        </div>
    </div>
    <main class="d-grid text-white justify-content-center">
                            <?php $listUser->echoAddButton();?>
        <button class="btn btn-warning" data-bs-toggle='modal' data-bs-target='#changePassPopup'>ZMIEŃ HASŁO</button>
        <button class="btn btn-danger" data-bs-toggle='modal' data-bs-target='#deleteAccPopup'>USUŃ SWOJE KONTO</button>
        <div class="table-responsive">
            <table class="table table-dark table-striped text-center">
                <tr>
                    <td><b>id</b></td>
                    <td><b>Data dodania</b></td>
                    <td><b>Login</b></td>
                    <td><b>Email</b></td>
                </tr>
							<?php $listUser->echoAdmins(); ?>
            </table>
        </div>
    </main>
	<?php
	require "../layout/footer.php";
}
else
{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
} ?>