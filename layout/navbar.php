<nav class="navbar navbar-expand-lg navbar-dark text-white bg-primary">
    <div class="container-fluid">
        <div class="nav-item btn-primary dropdown">
            <a class="btn dropdown-toggle bg-lighterBlue border-lighterBlue py-4 nav-link  navbar-brand" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
                KATEGORIE
            </a>
            <div class="dropdown-menu">
                <div class="list-group">
									<?php
									require_once setDefaultPath('controllers/layout/navbarController.php');
									?></div>
            </div>
        </div>
        <div class="nav-item">
            <a class="text-white border-lighterBlue bg-lighterBlue py-4 btn"
               href="<?php echo setDefaultPath("kategoria.php"); ?>">WSZYSTKIE TAPETY</a>
        </div>
    </div>

</nav>
<?php disappearingMessage(); ?>