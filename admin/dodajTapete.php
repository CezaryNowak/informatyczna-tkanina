<?php

session_start();
if (isset($_SESSION['logged_id']) && isset($_SESSION['logged_login']))
{
	require_once "../lib/functions.php";
	require_once "../data/dataFunctions.php";
	require_once "../controllers/admin/dodajTapeteController.php";
	require_once "../layout/defaultHead.php";
	?>
    <title>Dodaj Tapete</title>
    <meta name="description" content="Strona dodająca tapetę"/>
	<?php
	require_once "../layout/header.php";
	?>
    <main class="d-flex justify-content-center">
        <form method="post" class="d-grid justify-content-center border border-primary rounded bg-primary"
              enctype="multipart/form-data">
            <h1 class="p-3 text-white">DODAJ NOWĄ TAPETE</h1>
            <div class="p-3 bg-lighterBlue">
                <div class="form-outline mb-4">
                    <label class="form-label" for="title"><b>Tytuł</b></label>
                    <input class="form-control" type="text" value="<?php $add->echoFrTitle(); ?>"
                           placeholder="Podaj Tytuł" name="title" required>
                </div>
							<?php $add->echoErTitle(); ?>
                <div class="form-outline mb-4">
                    <label class="form-label" for="category"><b>Kategoria</b></label>
                    <select class="form-select" name="category" size="1">
											<?php $add->echoCatOptions(); ?>
                    </select>
									<?php $add->echoCatEr(); ?>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="description"><b>Opis</b></label>
                        <textarea class="form-control" type="text" placeholder="Podaj opis" name="description"
                                  required><?php $add->echoFrDesc(); ?></textarea>
                    </div>
									<?php $add->echoErDesc(); ?>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="file"><b>Plik</b></label><br>
                        <input class="form-control" name="image" type="file" accept="image/*" required>
                    </div>
									<?php $add->echoErImg(); ?>
                    <div class='d-flex justify-content-between'>
                        <a class="btn btn-warning" href="./listaTapet.php">ANULUJ</a>
                        <button class="btn btn-success" type="submit" name="newWall">DODAJ</button>

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