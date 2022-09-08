<?php

//add user
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['newUsr']))
{
	$createUserFlag = TRUE;
	$checkNick = TRUE; //
	$name = $_POST['username'];
	$_SESSION["fr_nick"] = $name;
	//Login validation
	if (strlen($name) < 4 || strlen($name) > 16)
	{
		$createUserFlag = FALSE;
		$checkNick = FALSE;
		$_SESSION['e_nick'] = "Dlugość loginu powinna wynosić od 4 do 16 znaków!";
		unset($_SESSION["fr_nick"]);
	}
	if (!ctype_alnum($name))
	{
		$createUserFlag = FALSE;
		$checkNick = FALSE;
		$_SESSION['e_nick'] = "Login może składać się tylko z liter (bez polskich znaków) i cyfr!";
		unset($_SESSION["fr_nick"]);
	}
	if ($checkNick)
	{
		if (!empty(getUser($name, 'nick')))
		{
			$createUserFlag = FALSE;
			$_SESSION['e_nick'] = "Taki login już istnieje";
		}
	}
	//Email validation
	$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	if (empty($email))
	{
		$createUserFlag = FALSE;
		$_SESSION['e_email'] = "Email jest niepoprawny";
	}
	else
	{
		$_SESSION['fr_email'] = $email;
		if (!empty(getUser($email, 'email')))
		{
			$createUserFlag = FALSE;
			$_SESSION['e_email'] = "Taki email już jest w użyciu!";
		}
	}
	//Password validation
	$pass1 = filter_input(INPUT_POST, 'password');
	$pass2 = filter_input(INPUT_POST, 'passwordConfirm');
	if (strlen($pass1) < 7 || strlen($pass1) > 20)
	{
		$createUserFlag = FALSE;
		$_SESSION['e_pass'] = "Dlugość hasła powinna wynosić od 7 do 20 znaków!";
	}
	else
	{
		$_SESSION["fr_pass"] = $pass1;
	}
	if ($pass1 != $pass2)
	{
		$createUserFlag = FALSE;
		$_SESSION['e_passConf'] = "Hasła nie są takie same!";
	}
	else
	{
		$_SESSION["fr_passConf"] = $pass2;
	}
	//If nothing wrong create new user
	if ($createUserFlag)
	{
		$hash = password_hash($pass1, PASSWORD_DEFAULT);
		if (addUser($name, $email, $hash))
		{
			$_SESSION['messageShow'] = "Pomyślnie dodano nowego użytkownika!";
			unset($_SESSION["fr_passConf"]);
			unset($_SESSION["fr_pass"]);
			unset($_SESSION["fr_email"]);
			unset($_SESSION["fr_nick"]);
			header("Location: listaUzytkownikow.php");
			die();
		}
	}
}
/**
 * Echo temporally saved value of username.
 */
function echoFrNick(): void
{
	if (isset($_SESSION["fr_nick"]))
	{
		echo $_SESSION["fr_nick"];
		unset($_SESSION["fr_nick"]);
	}
}

/**
 * Shows error if username does not meets requirements.
 */
function echoErNick(): void
{
	if (isset($_SESSION["e_nick"]))
	{
		echo '<div class="text-danger text-center bg-dark">'.$_SESSION["e_nick"].'</div>';
		unset($_SESSION['e_nick']);
	}
}

/**
 * Echo temporally saved value of email.
 */
function echoFrEmail(): void
{
	if (isset($_SESSION["fr_email"]))
	{
		echo $_SESSION["fr_email"];
		unset($_SESSION["fr_email"]);
	}
}

/**
 * Shows error if email has wrong syntax.
 */
function echoErEmail(): void
{

	if (isset($_SESSION["e_email"]))
	{
		echo '<div class="text-danger text-center bg-dark">'.$_SESSION['e_email'].'</div>';
		unset($_SESSION['e_email']);
	}
}

/**
 * Echo temporally saved value of password.
 */
function echoFrPass(): void
{
	if (isset($_SESSION["fr_pass"]))
	{
		echo $_SESSION["fr_pass"];
		unset($_SESSION["fr_pass"]);
	}
}

/**
 * Shows error if password does not meet requirements.
 */
function echoErPass(): void
{

	if (isset($_SESSION["e_pass"]))
	{
		echo '<div class="text-danger text-center bg-dark">'.$_SESSION['e_pass'].'</div>';
		unset($_SESSION['e_pass']);
	}
}

/**
 * Echo temporally saved value of confirmed password.
 */
function echoFrPassConf(): void
{
	if (isset($_SESSION["fr_passConf"]))
	{
		echo $_SESSION["fr_passConf"];
		unset($_SESSION["fr_passConf"]);
	}
}

/**
 * Shows error if passwords are not same.
 */
function echoErPassConf(): void
{
	if (isset($_SESSION["e_passConf"]))
	{
		echo '<div class="text-danger text-center bg-dark">'.$_SESSION['e_passConf'].'</div>';
		unset($_SESSION['e_passConf']);
	}
}
