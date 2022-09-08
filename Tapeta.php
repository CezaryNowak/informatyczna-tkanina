<?php

session_start();
require_once "lib/functions.php";
require_once "data/dataFunctions.php";
require_once "controllers/tapetaController.php";
require_once "layout/defaultHead.php";
?>
    <title><?= $wallpaper->getTitle(); ?></title>
    <meta name="description" content="<?= $wallpaper->getDesc(); ?>">
    <meta name="keywords"
          content="tapeta, tapeta na komórkę, tapeta na telefon, tapeta na komputer, tapeta na laptopa, tapeta na tableta,<?= $wallpaper->getCategory().', '.$wallpaper->getTitle(); ?>">
<?php
require_once "layout/header.php";
?>
    <main>
        <div class="d-flex text-white gap-5 flex-wrap justify-content-center">
            <div class="d-grid justify-content-center">
							<?php
							$wallpaper->echoButton();
							$wallpaper->echoWall();
							?>
                <a class='btn btn-primary' href='tapeta.php?id=<?= $wallpaper->getId(); ?>&download=true'>POBIERZ</a>
            </div>
            <div>
                <h2 class="bg-primary rounded p-2 text-center"><?= $wallpaper->getTitle() ?></h2>
                <div class="border border-4 border-info rounded">
                    <div class="bg-primary d-flex justify-content-between border-bottom border-info p-1">
                        <h3>Kategoria:

                            <a class="link-info" href="kategoria.php?id=<?= $wallpaper->getIdCat() ?>">
															<?= $wallpaper->getCategory(); ?>
                            </a>
                        </h3>
                    </div>
                    <div class="border-bottom border-info">
                        <h3 class="bg-primary p-1">Główne parametry:</h3>
                        <div class="p-1">Rozdzielczość: <?= $wallpaper->getWidth()."x".$wallpaper->getHeight(); ?><br>Rozmiar: <?= $wallpaper->getSize(); ?>
                            <br> Data dodania: <?= $wallpaper->getDate(); ?></div>
                    </div>
                    <div>
                        <h3 class="text-center bg-primary">Opis</h3>
                        <div class="p-1"><?= $wallpaper->getDesc(); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php require 'layout/footer.php'; ?>