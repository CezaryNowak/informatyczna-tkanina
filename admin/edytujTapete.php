<?php

session_start();
if (isset($_SESSION['logged_id']) && isset($_SESSION['logged_login']))
{
	require_once "../lib/functions.php";
	require_once "../data/dataFunctions.php";
	require_once "../controllers/admin/edytujTapeteController.php";
	require_once "../layout/defaultHead.php";
	?>
    <title>Edytuj Tapete</title>
    <meta name="description" content="Strona edytująca">
	<?php
	require_once "../layout/header.php";
	?>
    <main>
        <div class="d-flex text-white gap-5 flex-wrap justify-content-center">
            <form method="post" class="d-grid justify-content-center" name="changeWallpaperForm"
                  enctype="multipart/form-data">
                <h1>Dotychczasowy obraz:</h1>
							<?php $edit->showWall(); ?>
                <input class="form-control" name="changeImage" type="file" accept="image/*" required>
							<?php $edit->echoImgErr(); ?>
                <button class='btn btn-primary' type="submit" value="true" name="changeWallpaper">ZMIEŃ OBRAZ</button>
            </form>
            <form method="post" name="changeDetailsForm">
                <div class="bg-primary rounded p-2">
                    <input class="form-control" type="text" name="newTitle" placeholder="Podaj tytuł"
                           value="<?php $edit->echoTitleVal(); ?>" required>
									<?php $edit->echoTitleErr(); ?>
                </div>
                <div class="border border-4 border-info rounded">
                    <div class="bg-primary d-flex justify-content-between align-items-end border-bottom border-info p-1">
                        <h3>Kategoria:</h3>
                        <div>
                            <select class="form-select" name="category" size="1">
															<?php $edit->echoCategoriesSelect(); ?>
                            </select>
                        </div>
											<?php $edit->echoCatErr(); ?>
                    </div>
                    <div class="border-bottom border-info">
                        <h3 class="bg-primary p-1">Główne parametry:</h3>
                        <div class="p-1">
                            Rozdzielczość: <?php $edit->echoResolution(); ?><br>
                            Rozmiar: <?= $edit->getSize(); ?><br>
                            Data dodania: <?= $edit->getDate(); ?>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-center bg-primary">Opis</h3>
                        <div>
                            <textarea class="form-control" type="text" placeholder="Podaj opis" name="description"
                                      required><?php $edit->echoDesc(); ?></textarea>
													<?php $edit->echoDescErr(); ?>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-success" type="submit" value="true" name="changeWallpaperDetails">ZMIEŃ
                        SPECYFIKACJE
                    </button>
                </div>

            </form>
        </div>

    </main>
    <a href="../tapeta.php?id=<?= $edit->getId(); ?>" class="d-grid btn btn-warning">ANULUJ</a>

	<?php
	require "../layout/footer.php";
}
else
{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
} ?>