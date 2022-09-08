<?php

session_start();
if (isset($_SESSION['logged_id']) && isset($_SESSION['logged_login']))
{
	require_once "../lib/functions.php";
	require_once "../data/dataFunctions.php";
	require_once "../controllers/admin/listaTapetController.php";
	require_once "../layout/defaultHead.php";
	?>
    <title>Lista tapet</title>
    <meta name="description" content="Strona zawierająca listę tapet">
	<?php
	require_once "../layout/header.php";
	?>
    <main class="d-grid text-white justify-content-center">
        <div class="d-grid bg-dark btn">
            <a href="dodajTapete.php" class="btn btn-outline-light">
                DODAJ NOWĄ TAPETĘ
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-striped text-center">
                <tr>
                    <td><b>id</b></td>
                    <td><b>Tytuł</b></td>
                    <td><b>Data dodania</b></td>
                    <td><b>Kategoria</b></td>
                    <td><b>Edytuj</b></td>
                    <td><b>Usuń</b></td>
                </tr>
							<?php $listWall->echoTableWalls(); ?>
            </table>
        </div>
			<?php $listWall->pagination(); ?>
    </main>
	<?php
	require "../layout/footer.php";
}
else
{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
}
?>