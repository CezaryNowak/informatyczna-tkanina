<?php

class Index
{
	private array | null $titles;
	private array | null $categoriesDistinct;
	private array | null $categories;
	private array | null $newestWallpapers;
	private array | null $biggestWallpapers;

	/**
	 * Index constructor.
	 *
	 * @param $titles
	 * Distinct wallpapers title from database.
	 * @param $categoriesDistinct
	 * Distinct categories name from database.
	 * @param $categories
	 * Parameters of categories from database.
	 * @param $newestWallpapers
	 * 10 newest by index wallpapers.
	 * @param $biggestWallpapers
	 * 10 biggest width*height wallpapers
	 */
	function __construct(array | null $titles, array | null $categoriesDistinct, array | null $categories, array | null $newestWallpapers, array | null $biggestWallpapers)
	{
		$this->titles = $titles;
		$this->categoriesDistinct = $categoriesDistinct;
		$this->categories = $categories;
		$this->newestWallpapers = $newestWallpapers;
		$this->biggestWallpapers = $biggestWallpapers;
	}

	/**
	 * Returns count of existing categories in database to meta-tag.
	 */
	function categoryCount()
	{
		$count = 0;
		for ($i = 0; $i < count($this->categories); $i++)
		{
			$count += $this->categories[$i]['count'];
		}
		return $count;
	}

	/**
	 * Echo all category names from database to meta-tag.
	 */
	function echoCategories(): void
	{
		for ($i = 0; $i < count($this->categories); $i++)
		{
			if ($i > 0)
				echo ", ";
			echo $this->categories[$i]['category'];
		}
	}

	/**
	 * Echo all categories names and wallpapers titles to meta-tag.
	 */
	function echoMetaNames(): void
	{
		if (!empty($this->titles))
			foreach ($this->titles as $title)
				echo ", ".$title['title'];
		if (!empty($this->categoriesDistinct))
			foreach ($this->categoriesDistinct as $cate)
				echo ", ".$cate['category'];
	}

	/**
	 * Echo up to 10 of the newest images.
	 */
	function echoNewestWalls(): void
	{
		foreach ($this->newestWallpapers as $paper)
		{
			echo '<div class="p-4"><a href="tapeta.php?id='.$paper['id'].'">';
			if (!array_key_exists('image', $paper) || $paper['image'] == '' || !file_exists("wallpapers/miniatures/".$paper['image']))
			{
				echo '<img  class="img-thumbnail miniatureImage"  src="wallpapers/miniatures/notFound.png" alt="Brak">';
			}
			else
			{
				echo '<img class="img-thumbnail miniatureImage"  alt="'.$paper['description'].'" src="wallpapers/miniatures/'.$paper['image'].'" title="'.$paper['title'].' " >';
			}
			echo '</a></div>';
		}
	}

	/**
	 * Echo up to 10 of the biggest (resolution-wise) images.
	 */
	function echoBiggestWalls(): void
	{
		foreach ($this->biggestWallpapers as $paper)
		{
			echo '<div class="p-4"><a href="tapeta.php?id='.$paper['id'].'">';
			if (!array_key_exists('image', $paper) || $paper['image'] == '' || !file_exists("wallpapers/miniatures/".$paper['image']))
			{
				echo '<img class="img-thumbnail miniatureImage"  src="wallpapers/miniatures/notFound.png" alt="Brak">';
			}
			else
			{
				echo '<img class="img-thumbnail miniatureImage" alt="'.$paper['description'].'" src="wallpapers/miniatures/'.$paper['image'].'" title="'.$paper['title'].' " >';
			}
			echo '</a></div>';
		}
	}
}

$titles = setData("SELECT DISTINCT title FROM wallpapers");
$categoriesDistinct = setData("SELECT DISTINCT category FROM categories");
$categories = getCategory(NULL, NULL, TRUE);
$newestWallpapers = setData('SELECT id, title, image, description FROM wallpapers ORDER BY id desc LIMIT 10');
$biggestWallpapers = setData('SELECT id, title, image, description FROM wallpapers ORDER BY width*height desc LIMIT 10');
$index = new Index($titles, $categoriesDistinct, $categories, $newestWallpapers, $biggestWallpapers);
$titles = NULL;
$categoriesDistinct = NULL;
$categories = NULL;