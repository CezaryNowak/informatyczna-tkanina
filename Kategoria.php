<?php

session_start();
require_once "lib/functions.php";
require_once "data/dataFunctions.php";
require_once "controllers/kategoriaController.php";
require_once "layout/defaultHead.php";
?>
    <title><?php $walls->echoTitle() ?></title>
    <meta name="description"
          content="Strona zawierająca <?= $walls->countWallpapers(); ?> tapet na komputery, tapet na komórki <?php $walls->echoDesc(); ?>">
    <meta name="keywords"
          content="tapeta, tapeta na komórkę, tapeta na telefon, tapeta na komputer, tapeta na laptopa, tapeta na tableta,<?php $walls->echoKeywords(); ?>">
<?php
require_once "layout/header.php";
?>
    <main class="pt-0">
        <div class="dropdown d-flex justify-content-center dropdown-center">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                Pokaż rozdzielczość od:
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item active">
									<?php $walls->echoResolutionsList(); ?>
            </div>
        </div>
        <h1 class='text-white text-center p-5'>
					<?php $walls->echoH1(); ?></h1>
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-center">
							<?php $walls->echoWalls(); ?>
            </div>
        </div>
			<?php $walls->pagination(); ?>
    </main>
<?php require 'layout/footer.php'; ?>