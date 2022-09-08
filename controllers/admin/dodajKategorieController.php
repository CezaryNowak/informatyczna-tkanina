<?php

//add category
if (isset($_POST['name']) && isset($_POST['addCate']))
{
	$isOk = TRUE;
	$name = $_POST['name'];
	$name = htmlentities($name, ENT_QUOTES, "UTF-8");
	$name = trim($name);
	$categories = getCategory($name);
	if (strlen($name) < 3 || strlen($name) > 21)
	{
		$isOk = FALSE;
		$_SESSION['e_name'] = "Nazwa kategorii może zawierać od 3 do 21 znaków!";
	}
	if (!empty($categories))
	{
		$isOk = FALSE;
		$_SESSION['e_name'] = "TAKA KATEGORIA JUŻ ISTNIEJE";
	}
	$_SESSION['fr_name'] = $name;
	if ($isOk)
	{

		$name = strtolower($name);
		$name[0] = strtoupper($name[0]);
		if (addCategory($name))
		{
			$_SESSION['messageShow'] = "Pomyślnie dodano nową kategorie!";
			unset($_SESSION["fr_name"]);
			header("Location: listaKategorii.php");
			die();
		}
	}
}
/**
 * Echo temporally saved value of category name.
 */
function echoFr(): void
{
	if (isset($_SESSION["fr_name"]))
	{
		echo $_SESSION["fr_name"];
		unset($_SESSION["fr_name"]);
	}
}

/**
 * Echo error if category name does not meet requirements.
 */
function echoEr(): void
{
	if (isset($_SESSION["e_name"]))
	{
		echo '<div class="text-danger text-center bg-dark">'.$_SESSION['e_name'].'</div>';
		unset($_SESSION['e_name']);
	}
}
