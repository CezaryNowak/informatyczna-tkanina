</head>
<?php require_once "layout/zaloguj.php"; ?>

<body>
<header class="py-3 text-center">
    <div class="d-flex px-1 justify-content-between align-items-center">
        <a href=<?php echo "index.php"; ?>><img class="img-fluid"
                                                                src="<?= "images_content/logo.png" ?>"
                                                                alt="InformatycznaTkanina"></a>
			<?php require_once 'controllers/layout/headerController.php'; ?>
    </div>
</header>
<?php
require_once "layout/navbar.php";
if (isset($_SESSION["logged_id"]))
{
	require_once "admin/adminNavbar.php";
}
?>