<?php

if (isset($_SESSION['logged_id']) && isset($_SESSION['logged_login']))
{
	?>
    <div class='text-center bg-dark py-2 text-white'>
        <h1>Witaj <?= $_SESSION['logged_login'] ?> !</h1>
        <h1>Menu administracyjne </h1>
        <div class='btn-group' role='group'>
            <a class='btn btn-outline-light' href='<?= setDefaultPath("admin/listaTapet.php") ?>'>TAPETY</a>
            <a class='btn btn-outline-light' href='<?= setDefaultPath("admin/listaKategorii.php") ?>'>KATEGORIE</a>
            <a class='btn btn-outline-light' href='<?= setDefaultPath("admin/listaUzytkownikow.php") ?>'>UŻYTKOWNICY</a>
        </div>
    </div>
<?php } ?>