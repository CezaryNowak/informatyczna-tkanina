<?php

class AddWall
{
	private array $categories;

	/**
	 * AddWall constructor.
	 *
	 * @param $categories
	 * Sets up array of names of categories.
	 */
	function __construct(array $categories)
	{
		$this->categories = $categories;
	}

	/**
	 * Gets all input, verifies it and adds new user to database or shows error.
	 */
	function addWallpaper(): void
	{
		if (isset($_POST['newWall']) && isset($_POST['title']))
		{
			$addWallFlag = TRUE;
			//title
			$title = filter_input(INPUT_POST, 'title') ?? NULL;
			if ($title == NULL)
			{
				$addWallFlag = FALSE;
				$_SESSION["e_title"] = "Podaj Tytuł!";
			}
			else
			{
				if (strlen($title) < 3 || strlen($title) > 100)
				{
					$addWallFlag = FALSE;
					$_SESSION['e_title'] = "Tytuł może zawierać od 3 do 100 znaków!";
				}
				else
				{
					$title = htmlentities($title, ENT_QUOTES, "UTF-8");
					$title = trim($title);
				}
				$_SESSION["fr_title"] = $title;
			}
			//category
			$cate = filter_input(INPUT_POST, 'category') ?? NULL;
			if ($cate == NULL)
			{
				$addWallFlag = FALSE;
				$_SESSION["e_cate"] = "Wybierz kategorie!";
			}
			else
			{
				//array of categories name to compare
				$catList = NULL;
				foreach ($this->categories as $cat)
				{
					$catList[] = $cat['category'];
				}
				if (!in_array($cate, $catList))
				{
					$addWallFlag = FALSE;
					$_SESSION["e_cate"] = "Nie ma takiej kategorii";
				}
				else
				{
					$_SESSION["fr_cate"] = $cate;
				}
			}
			//description
			$desc = filter_input(INPUT_POST, 'description');
			$desc = htmlentities($desc, ENT_QUOTES, "UTF-8");
			$desc = trim($desc);
			if (strlen($desc) < 4 || strlen($desc) > 1000)
			{
				$addWallFlag = FALSE;
				$_SESSION['e_desc'] = "Dlugość opisu powinna wynosić od 4 do 1000 znaków!";
			}
			$_SESSION['fr_desc'] = $desc;
			//file
			$file = $_FILES['image'] ?? NULL;
			$filename = randomString(10); //set random name
			$fileExt = NULL;
			if (!$file)
			{
				$addWallFlag = FALSE;
				$_SESSION['e_image'] = "Brak pliku!";
			}
			else
			{
				$allowedExt = array('png', 'jpg', 'gif', 'jpeg'); //Accepted extensions of file
				$fileExt = explode('.', $file['name']);
				$fileExt = strtolower(end($fileExt));
				if (!in_array($fileExt, $allowedExt))
				{
					$addWallFlag = FALSE;
					$_SESSION['e_image'] = "Plik nie jest obrazem!";
				}
				$filename .= ".$fileExt";
			}
			//if success
			if ($addWallFlag)
			{
				mkWallpapersDir();
				$i = 2;
				while (file_exists("../wallpapers/full/$filename"))
				{
					$filename = randomString(2 + $i);
					if ($i < 10)
						$i -= rand(1, 12);
					$i++;
				}
				if (!file_exists("../wallpapers/$filename"))
				{
					move_uploaded_file($file['tmp_name'], "../wallpapers/full/$filename");
					$imageInfo = getimagesize("../wallpapers/full/$filename");
					scaleImages($filename, $fileExt);
					if (addWallpaper($title, $desc, $cate, $filename, $file['size'], $imageInfo[0], $imageInfo[1]))
					{
						$_SESSION['messageShow'] = "Pomyślnie dodano nową tapetę!";
						unset($_SESSION['fr_desc']);
						unset($_SESSION['fr_cate']);
						unset($_SESSION['fr_title']);
						header("Location: listaTapet.php");
						die();
					}
				}
				else
				{
					$_SESSION['e_image'] = "Błąd pliku";
				}
			}
		}
	}

	/**
	 * Echo temporally saved value of wallpaper title.
	 */
	function echoFrTitle(): void
	{
		if (isset($_SESSION["fr_title"]))
		{
			echo $_SESSION["fr_title"];
			unset($_SESSION["fr_title"]);
		}
	}

	/**
	 * Shows error if title does not meet requirements.
	 */
	function echoErTitle(): void
	{
		if (isset($_SESSION["e_title"]))
		{
			echo '<div class="text-danger text-center bg-dark">'.$_SESSION["e_title"].'</div>';
			unset($_SESSION['e_title']);
		}
	}

	/**
	 * Shows current categories options and
	 * echo temporally saved value of wallpaper category.
	 */
	function echoCatOptions(): void
	{
		if (isset($_SESSION['fr_cate']))
		{
			foreach ($this->categories as $cat)
				if ($_SESSION['fr_cate'] == $cat['category'])
					echo "<option value='".$cat['category']."'selected>".$cat['category']."</option>";
				else echo "<option value='".$cat['category']."'>".$cat['category']."</option>";
			unset($_SESSION['fr_cate']);
		}
		else
		{
			echo ' <option value="" disabled selected hidden>Wybierz kategorie</option></div>';
			foreach ($this->categories as $cat)
				echo "<option value='".$cat['category']."'>".$cat['category']."</option>";
		}
	}

	/**
	 * Shows error if category does not exist.
	 */
	function echoCatEr(): void
	{
		if (isset($_SESSION["e_cate"]))
		{
			echo '<div class="text-danger text-center bg-dark">'.$_SESSION["e_cate"].'</div>';
			unset($_SESSION['e_cate']);
		}
	}

	/**
	 * Echo temporally saved value of wallpaper description.
	 */
	function echoFrDesc(): void
	{
		if (isset($_SESSION["fr_desc"]))
		{
			echo $_SESSION["fr_desc"];
			unset($_SESSION["fr_desc"]);
		}
	}

	/**
	 * Shows error if description does not meet requirements.
	 */
	function echoErDesc(): void
	{
		if (isset($_SESSION["e_desc"]))
		{
			echo '<div class="text-danger text-center bg-dark">'.$_SESSION["e_desc"].'</div>';
			unset($_SESSION['e_desc']);
		}
	}

	/**
	 * Shows error if something is wrong with image.
	 */
	function echoErImg(): void
	{
		if (isset($_SESSION["e_image"]))
		{
			echo '<div class="text-danger text-center bg-dark">'.$_SESSION["e_image"].'</div>';
			unset($_SESSION['e_image']);
		}
	}
}

$add = new AddWall(setData("SELECT category FROM categories"));
$add->addWallpaper();