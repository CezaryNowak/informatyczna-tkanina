<?php

/**
 * @var array $categories
 * Gets all categories
 */
$categories = getCategory(NULL, NULL, TRUE);
$id = 0;
//Checks if $id is correct
if (isset($_GET['id']))
{
	$id = htmlentities($_GET['id']);
	if (!is_numeric($id) === TRUE || !$id > 0)
	{
		$id = 0;
	}
}
//Echo category names in dropdown
foreach ($categories as $cat)
{
	if ($cat['id'] == $id)
	{
		echo '
        <a class="fw-bold list-group-item d-flex justify-content-between active align-items-center dropdown-item">'.$cat['category'].'
        <span class="badge bg-lighterBlue rounded-pill">'.$cat['count'].'</span></a>';
	}
	else
	{
		echo '<a class="fw-bold list-group-item d-flex justify-content-between align-items-center dropdown-item p-1" href="'."kategoria.php".'?id='.$cat['id'].'">'.$cat['category'].'<span class="badge bg-primary rounded-pill">'.$cat['count'].'</span> </a>';
	}
}
/**
 * Echo message that disappears
 * if message is set.
 */
function disappearingMessage(): void
{
	if (isset($_SESSION['messageShow']))
	{
		echo "<div id='messageAppear' ><div class='position-fixed top-0 start-50 translate-middle-x alert alert-info' role='alert'>".$_SESSION['messageShow']."</div></div>";
		unset($_SESSION['messageShow']);
	}
}
