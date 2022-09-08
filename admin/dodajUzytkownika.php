<?php

session_start();
if ($_SESSION['logged_id']==1 && $_SESSION['logged_login']=="admin")
{
	require_once "../lib/functions.php";
	require_once "../data/dataFunctions.php";
	require_once "../controllers/admin/dodajUzytkownikaController.php";
	require_once "../layout/defaultHead.php";
	?>
    <title>Dodaj użytkownika</title>
    <meta name="description" content="Strona dodająca użytkownika"/>
	<?php
	require_once "../layout/header.php";
	?>
    <main class="d-flex justify-content-center">
        <form method="post" class="d-grid justify-content-center border border-primary rounded bg-primary">
            <h1 class="p-3 text-white">DODAJ NOWEGO UŻYTKOWNIKA</h1>
            <div class="p-3 bg-lighterBlue">
                <div class="form-outline mb-4">
                    <label class="form-label" for="username"><b>Login</b></label>
                    <input class="form-control" type="text" value="<?php echoFrNick(); ?>" placeholder="Podaj Login"
                           name="username" required>
                </div>
							<?php echoErNick(); ?>
                <div class="form-outline mb-4">
                    <label class="form-label" for="email"><b>Email</b></label>
                    <input class="form-control" type="text" value="<?php echoFrEmail(); ?>" placeholder="Podaj Email"
                           name="email" required>
                </div>
							<?php echoErEmail(); ?>
                <div class="form-outline mb-4">
                    <label class="form-label" for="password"><b>Hasło</b></label>
                    <input class="form-control" type="password" value="<?php echoFrPass(); ?>" placeholder="Podaj Hasło"
                           name="password" required>
                </div>
							<?php echoErPass(); ?>
                <div class="form-outline mb-4">
                    <label class="form-label" for="passwordConfirm"><b>Potwierdź hasło</b></label>
                    <input class="form-control" type="password" value="<?php echoFrPassConf(); ?>"
                           placeholder="Podaj ponownie Hasło" name="passwordConfirm" required>
                </div>
							<?php echoErPassConf(); ?>
                <div class='d-flex justify-content-between'>
                    <a class="btn btn-warning" href="./listaUzytkownikow.php">ANULUJ</a>
                    <button class="btn btn-success" type="submit" name="newUsr">DODAJ UŻYTKOWNIKA</button>
                </div>
            </div>
        </form>
    </main>
	<?php
	require '../layout/footer.php';
}
else
{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
} ?>