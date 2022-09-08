<?php

class EditWall
{
	private array $paper;
	private int $id;
	private null | array $categories;

	/**
	 * EditWall constructor.
	 *
	 * @param $paper
	 * Details of currently modified wallpaper.
	 * @param $id
	 * ID of current wallpaper.
	 * @param $categories
	 * All names of categories.
	 */
	function __construct(int $id, array $paper, null | array $categories)
	{
		$this->id = $id;
		$this->paper = $paper;
		$this->categories = $categories;
	}

	/**
	 * Checks image file and updates it or shows error.
	 */
	function editImage(): void
	{
		if (isset($_FILES['changeImage']) && isset($_POST['changeWallpaper']))
		{
			$file = $_FILES['changeImage'];
			$addWallFlag = TRUE;
			$fileExt = NULL;
			$filename = randomString(10); //set random name
			if (!$file == NULL)
			{
				$allowedExt = array('png', 'jpg', 'gif', 'jpeg'); //Accepted extensions of file
				$fileExt = explode('.', $file['name']);
				$fileExt = strtolower(end($fileExt));
				if (!in_array($fileExt, $allowedExt))
				{
					$addWallFlag = FALSE;
					$_SESSION['e_newImage'] = "Plik nie jest obrazem!";
				}
				$filename .= ".$fileExt";
			}
			if ($addWallFlag)
			{
				if (file_exists("../wallpapers/".$this->paper['image']))
				{
					$oldImage = "../wallpapers/".$this->paper['image'];
					unlink($oldImage);
				}
				if (file_exists("../wallpapers/full/".$this->paper['image']))
				{
					$oldImage = "../wallpapers/full/".$this->paper['image'];
					unlink($oldImage);
				}
				if (file_exists("../wallpapers/display/".$this->paper['image']))
				{
					$oldImage = "../wallpapers/display/".$this->paper['image'];
					unlink($oldImage);
				}
				if (file_exists("../wallpapers/miniatures/".$this->paper['image']))
				{
					$oldImage = "../wallpapers/miniatures/".$this->paper['image'];
					unlink($oldImage);
				}
				mkWallpapersDir();
				$i = 2;
				while (file_exists("../wallpapers/full/$filename"))
				{
					$filename = randomString(2 + $i);
					if ($i < 10)
						$i -= rand(1, 12);
					$i++;
				}
				if (!file_exists("../wallpapers/full/$filename"))
				{
					move_uploaded_file($file['tmp_name'], "../wallpapers/full/$filename");
					$imageInfo = getimagesize("../wallpapers/full/$filename");
					scaleImages($filename, $fileExt);
				}
				if (updateWallpaperImage($this->id, $filename, $file['size'], $imageInfo[0], $imageInfo[1]))
				{
					$_SESSION['messageShow'] = "Pomyślnie zmieniono obraz tapety!";
					header("Location: ../tapeta.php?id=".$this->paper['id']);
					die();
				}
			}
		}
	}

	/**
	 * Checks text input values and updates it or shows error.
	 */
	function editDetails(): void
	{
		if (isset($_POST['changeWallpaperDetails']) && isset($_POST['newTitle']))
		{
			$addWallFlag = TRUE;
			$title = filter_input(INPUT_POST, 'newTitle');
			$title = htmlentities($title, ENT_QUOTES, "UTF-8");
			$title = trim($title);
			$cate = filter_input(INPUT_POST, 'category');
			$desc = filter_input(INPUT_POST, 'description');
			$desc = htmlentities($desc, ENT_QUOTES, "UTF-8");
			$desc = trim($desc);
			//title
			if (!$title)
			{
				$addWallFlag = FALSE;
				$_SESSION["e_newTitle"] = "Podaj Tytuł!";
			}
			else
			{
				if (strlen($title) < 3 || strlen($title) > 100)
				{
					$addWallFlag = FALSE;
					$_SESSION['e_newTitle'] = "Tytuł może zawierać od 3 do 100 znaków!";
				}
				else
				{
					$title = trim($title);
				}
				$_SESSION["fr_newTitle"] = $title;
			}
			$categories = setData("SELECT category FROM categories");
			//category
			if (!$cate)
			{
				$addWallFlag = FALSE;
				$_SESSION["e_newCate"] = "Wybierz kategorie!";
			}
			else
			{
				//array of categories name to compare
				$catList = NULL;
				foreach ($categories as $cat)
				{
					$catList[] = $cat['category'];
				}
				if (!in_array($cate, $catList))
				{
					$addWallFlag = FALSE;
					$_SESSION["e_newCate"] = "Nie ma takiej kategorii";
				}
				else
				{
					$_SESSION["fr_newCate"] = $cate;
				}
			}
			//description
			if (strlen($desc) < 4 || strlen($desc) > 1000)
			{
				$addWallFlag = FALSE;
				$_SESSION['e_newDesc'] = "Dlugość opisu powinna wynosić od 4 do 1000 znaków!";
			}
			$_SESSION['fr_newDesc'] = $desc;
			//if success
			if ($addWallFlag === TRUE)
			{
				if (updateWallpaperParams($this->id, $title, $desc, $cate))
				{
					unset($_SESSION['fr_newDesc']);
					unset($_SESSION['fr_newCate']);
					unset($_SESSION['fr_newTitle']);
					$_SESSION['messageShow'] = "Pomyślnie zmodyfikowano detale tapety!";
					header("Location: ../tapeta.php?id=".$this->paper['id']);
					die();
				}
			}
		}
	}

	/**
	 * Shows current image of wallpaper.
	 */
	function showWall(): void
	{
		if (empty($this->paper) || $this->paper['image'] == '' || !file_exists("../wallpapers/display/".$this->paper['image']))
		{
			echo '<img class="imageDisplay img-fluid img-thumbnail" src="../wallpapers/display/notFound.png" alt="Brak">';
		}
		else
		{
			echo '<img class="imageDisplay img-fluid img-thumbnail" src="../wallpapers/display/'.$this->paper['image'].'" title="'.$this->paper['title'].' " >';
		}
	}

	/**
	 * Shows error if something is wrong with new image.
	 */
	function echoImgErr(): void
	{
		if (isset($_SESSION["e_newImage"]))
		{
			echo '<div class="text-danger text-center bg-dark">'.$_SESSION["e_newImage"].'</div>';
			unset($_SESSION['e_newImage']);
		}
	}

	/**
	 * Echo current title to input value or temporally saved value of wallpaper title.
	 */
	function echoTitleVal(): void
	{
		if (isset($_SESSION["fr_newTitle"]))
		{
			echo $_SESSION["fr_newTitle"];
			unset($_SESSION["fr_newTitle"]);
		}
		else echo $this->paper['title'];
	}

	/**
	 * Shows error if new title does not meet requirements.
	 */
	function echoTitleErr(): void
	{
		if (isset($_SESSION["e_newTitle"]))
		{
			echo '<div class="text-danger text-center bg-dark">'.$_SESSION["e_newTitle"].'</div>';
			unset($_SESSION['e_newTitle']);
		}
	}

	/**
	 * Shows current categories options and
	 * echo current category value or temporally saved value of wallpaper category.
	 */
	function echoCategoriesSelect(): void
	{
		echo "yes";
		if (isset($_SESSION['fr_newCate']))
		{
			foreach ($this->categories as $cat)
				if ($_SESSION['fr_newCate'] == $cat['category'])
					echo "<option class='optionCategory' value='".$cat['category']."'selected>".$cat['category']."</option>";
				else echo "<option class='optionCategory' value='".$cat['category']."'>".$cat['category']."</option>";
			unset($_SESSION['fr_newCate']);
		}
		else
		{
			if (!in_array($this->paper['category'], $this->categories))
			{
				echo ' <option value="" disabled selected hidden>Wybierz kategorie</option>';
			}
			foreach ($this->categories as $cat)
				if ($this->paper['category'] == $cat['category'])
					echo "<option class='optionCategory' value='".$cat['category']."'selected>".$cat['category']."</option>";
				else echo "<option class='optionCategory' value='".$cat['category']."'>".$cat['category']."</option>";
		}
	}

	/**
	 * Shows error if category does not exist.
	 */
	function echoCatErr(): void
	{
		if (isset($_SESSION["e_newCate"]))
		{
			echo '<div class="text-danger text-center bg-dark">'.$_SESSION["e_newCate"].'</div>';
			unset($_SESSION['e_newCate']);
		}
	}

	/**
	 * Echo resolution of wallpaper (width x height).
	 */
	function echoResolution(): void
	{
		echo $this->paper['width'].'x'.$this->paper['height'];
	}

	/**
	 * Return size of current image of wallpaper.
	 */
	function getSize(): string
	{
		return humanFileSize($this->paper['size']);
	}

	/**
	 * Return date when was wallpaper added.
	 */
	function getDate(): string
	{
		return $this->paper['date'];
	}

	/**
	 * Return wallpaper ID.
	 */
	function getId(): int
	{
		return $this->id;
	}

	/**
	 * Echo current value or temporally value of description.
	 */
	function echoDesc(): void
	{
		if (isset($_SESSION["fr_newDesc"]))
		{
			echo $_SESSION["fr_newDesc"];
			unset($_SESSION["fr_newDesc"]);
		}
		else echo $this->paper['description'];
	}

	/**
	 * Shows error when new description does not meet requirements.
	 */
	function echoDescErr(): void
	{
		if (isset($_SESSION["e_newDesc"]))
		{
			echo '<div class="text-danger text-center bg-dark">'.$_SESSION["e_newDesc"].'</div>';
			unset($_SESSION['e_newDesc']);
		}
	}
}

$edit = NULL;
if (isset($_GET['id']) && $_GET['id'] > 0)
{
	$paper = getWallpaper($_GET['id'], 'id', FALSE);
	if (empty($paper))
	{
		header('Refresh:0; Location: index.php');
		$_SESSION['messageShow'] = "Tapeta nie istnieje";
		die();
	}
	$categories = setData("SELECT category FROM categories");
	$edit = new EditWall($_GET['id'], $paper, $categories);
	$edit->editDetails();
	$edit->editImage();
}
else
{
	echo "header('index.php')";
	die();
}


