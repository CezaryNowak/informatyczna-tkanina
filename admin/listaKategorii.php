<?php

session_start();
if (isset($_SESSION['logged_id']) && isset($_SESSION['logged_login']))
{
	require_once "../lib/functions.php";
	require_once "../data/dataFunctions.php";
	require_once "../controllers/admin/listaKategoriiController.php";
	require_once "../layout/defaultHead.php";
	?>
    <title>Lista kategorii</title>
    <meta name="description" content="Strona zawierająca kategorie"/>
	<?php
	require_once "../layout/header.php";
	?>
    <main class="d-grid text-white justify-content-center">
        <div class="d-grid bg-dark btn">
            <a href="dodajKategorie.php" class="btn btn-outline-light">
                DODAJ NOWĄ KATEGORIE
            </a>
        </div>
			<?php $listCats->echoDeleteError() ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped text-center">
                <tr>
                    <td><b>id</b></td>
                    <td><b>Data dodania</b></td>
                    <td><b>Ilość tapet</b></td>
                    <td><b>Nazwa kategorii</b></td>
                    <td><b>Edytuj</b></td>
                    <td><b>Usuń</b></td>
                </tr>
							<?php $listCats->echoTable() ?>
            </table>
					<?php $listCats->echoEditError() ?>
        </div>
    </main>
	<?php
	require "../layout/footer.php";
}
else
{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
} ?>