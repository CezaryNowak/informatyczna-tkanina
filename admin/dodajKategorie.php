<?php

session_start();
if (isset($_SESSION['logged_id']) && isset($_SESSION['logged_login']))
{
	require_once "../lib/functions.php";
	require_once "../data/dataFunctions.php";
	require_once "../controllers/admin/dodajKategorieController.php";
	require_once "../layout/defaultHead.php";
	?>
    <title>Dodaj kategorie</title>
    <meta name="description" content="Strona dodająca kategorie"/>
	<?php
	require_once "../layout/header.php";
	?>
    <main class="d-flex justify-content-center">
        <form method="post" class="d-grid justify-content-center border border-primary rounded bg-primary">
            <h1 class="p-4 text-white"><b>DODAJ NOWĄ KATEGORIE</b></h1>
            <div class="p-5 bg-lighterBlue">
                <div class="form-outline mb-4">
                    <label class="form-label" for="name"><b>Nazwa kategorii</b></label>
                    <input class="form-control" placeholder="Podaj nazwę" type="text" value="<?php echoFr(); ?>"
                           name="name">
                </div>
							<?php echoEr(); ?>
                <div class='d-flex justify-content-between'>
                    <a class=" btn btn-warning" href="./listaKategorii.php"> ANULUJ</a>
                    <button class="btn btn-success" type="submit" name="addCate" value="DODAJ KATEGORIE">DODAJ
                        KATEGORIE
                    </button>
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