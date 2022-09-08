<?php

session_start();
require_once "lib/functions.php";
require_once "data/dataFunctions.php";
require_once "controllers/indexController.php";
require_once "layout/defaultHead.php";
?>
    <title>Informatyczna Tkanina</title>
    <meta name="description"
          content="Strona zawierająca <?= $index->categoryCount(); ?> tapet na komputery, tapet na komórki z różych kategorii: <?php $index->echoCategories(); ?>">
    <meta name="keywords"
          content="tapeta, tapeta na komórkę, tapeta na telefon, tapeta na komputer, tapeta na laptopa, tapeta na tableta <?php $index->echoMetaNames(); ?>">
<?php
require_once "layout/header.php";
?>
    <main class="pt-0">
        <h1 class="text-white text-center p-3">Najnowsze tapety</h1>
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-center">
							<?php $index->echoNewestWalls(); ?>
            </div>
        </div>
        <h1 class="text-white text-center p-3">Tapety o największej rozdzielczości</h1>
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-center">
							<?php $index->echoBiggestWalls(); ?>
            </div>
        </div>
    </main>
<?php require 'layout/footer.php'; ?>