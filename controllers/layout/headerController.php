<?php

if (!isset($_SESSION["logged_id"]))
{
	echo "<a class='btn btn-primary p-3 ' data-bs-toggle='modal' data-bs-target='#loginPopup'>ZALOGUJ</a>";
}
else
{
	echo "<a class='btn btn-danger p-3' href='admin/logout.php'>WYLOGUJ</a>";
}
