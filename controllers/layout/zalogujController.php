<?php

if (isset($_POST['username']) && isset($_POST['login']))
{
	$name = filter_input(INPUT_POST, 'username');
	$name = htmlentities($name, ENT_QUOTES, "UTF-8");
	$pass = filter_input(INPUT_POST, 'password');
	$admin = getUser($name, 'nick');
	if (!empty($admin) && password_verify($pass, $admin['password']))
	{
		$_SESSION['logged_id'] = $admin['id'];
		$_SESSION['logged_login'] = $admin['nick'];
		$_SESSION['messageShow'] = "Pomyślnie zalogowano";
		unset($_SESSION['e_nickname']);
		header('Location: index.php');
		die();
	}
	else
	{
		$_SESSION['e_nickname'] = "NIEPOPRAWNY LOGIN LUB HASŁO";
	}
}
/**
 * If something is incorrect it keeps login popup form disappearing.
 */
function keepLoginPopup(): void
{
	if (isset($_SESSION['e_nickname']))
	{
		echo '<div class="text-danger text-center">'.$_SESSION['e_nickname'].'</div>
                <script type="module">
                import * as bootstrap from "bootstrap"
                let myModal = new bootstrap.Modal(document.getElementById("loginPopup"), {});
                document.onreadystatechange = function () {
                myModal.show();
                };
                </script>';
		unset($_SESSION['e_nickname']);
	}
}
