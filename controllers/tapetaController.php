<?php

class Wallpaper
{
	private int $id;
	private array $paper;
	private array $category;

	/**
	 * Wallpaper constructor.
	 *
	 * @param $id
	 * ID of current wallpaper.
	 * @param $paper
	 * Details of current wallpaper.
	 * @param $category
	 * Details of current wallpapers' category.
	 */
	function __construct(int $id, array $paper, array $category)
	{
		$this->id = $id;
		$this->paper = $paper;
		$this->category = $category;
	}

	/**
	 * Sends $image path to download.php.
	 */
	function download(): void
	{
		if (isset($_GET['download']))
		{
			header('Location: ./layout/download.php?file='.urlencode($this->paper['image']));
			die();
		}
	}

	/**
	 * Returns title of wallpaper.
	 */
	function getTitle(): string
	{
		return $this->paper['title'];
	}

	/**
	 * Returns ID of wallpaper.
	 */
	function getId(): int
	{
		return $this->id;
	}

	/**
	 * Returns ID of category.
	 */
	function getIdCat(): int
	{
		return $this->category['id'];
	}

	/**
	 * Returns description of wallpaper.
	 */
	function getDesc(): string
	{
		return $this->paper['description'];
	}

	/**
	 * Returns category of wallpaper.
	 */
	function getCategory(): string
	{
		return $this->paper['category'];
	}

	/**
	 * Returns width of wallpaper.
	 */
	function getWidth(): int
	{
		return $this->paper['width'];
	}

	/**
	 * Returns height of wallpaper.
	 */
	function getHeight(): int
	{
		return $this->paper['height'];
	}

	/**
	 * Returns size of wallpaper.
	 */
	function getSize(): string
	{
		return humanFileSize($this->paper['size']);
	}

	/**
	 * Returns date of wallpaper.
	 */
	function getDate(): string
	{
		return $this->paper['date'];
	}

	/**
	 * Echo button to edit wallpaper if logged in.
	 */
	function echoButton(): void
	{
		if (isset($_SESSION['logged_id']) && isset($_SESSION['logged_login']))
		{
			echo " <div class='d-grid bg-dark btn'><a class='btn btn-outline-light'  href='admin/edytujTapete.php?id=".$this->id."'>Edytuj</a></div>";
		}
	}

	/**
	 * Echo wallpaper image if it exists.
	 * Sets up title, alt and path to image.
	 */
	function echoWall(): void
	{
		if (empty($this->paper) || $this->paper['image'] == '' || !file_exists("wallpapers/display/".$this->paper['image']))
		{
			echo '<img class="imageDisplay img-fluid img-thumbnail" src="wallpapers/display/notFound.png" alt="Brak">';
		}
		else
		{
			echo '<img class="imageDisplay img-fluid img-thumbnail " alt="'.$this->paper['description'].'" src="wallpapers/display/'.$this->paper['image'].'" title="'.$this->paper['title'].' " >';
		}
	}
}

$wallpaper = NULL;
if (isset($_GET['id']) && is_numeric($_GET['id']) === TRUE && $_GET['id'] > 0)
{
	$paper = getWallpaper($_GET['id'], 'id', FALSE);
	if (empty($paper))
	{
		header('Location: index.php');
		$_SESSION['messageShow'] = "Tapeta nie istnieje";
		die();
	}
	$category = getCategory($paper['category']);
	if ($category == NULL)
	{
		$category['id'] = 0;
	}
	$wallpaper = new Wallpaper($_GET['id'], $paper, $category);
	$wallpaper->download();
}
else
{
	header('Location: index.php');
	die();
}