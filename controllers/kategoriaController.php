<?php

class URLParams
{
	/**
	 * Sets all modifiers to link.
	 *
	 * @var $params
	 */
	private string | null $params = NULL;

	/**
	 * valueParam function of URLParams class.
	 * Returns value of collected url modifiers.
	 *
	 * @param $var
	 * Gets modifier.
	 * @param $pager
	 * If it will be in pagination set value to include pages.
	 */
	function valueParam(null | string $var = NULL, bool $pager = FALSE): string | null
	{
		$value = &$this->params;
		if (!$var == NULL && !$pager)
		{
			if ($value == NULL)
				$value = $var;
			else
				$value .= "&".$var;
		}
		if (!$value == NULL && $pager)
		{
			$value = "&".$value;
		}
		return $value;
	}
}

class WallpapersQuery
{
	private array | null $params = NULL;
	private array | null $paramsValue = NULL;
	private string $query = "SELECT * FROM wallpapers";
	// resolution values
	private array | null $paramsRes = NULL;
	private array | null $paramsValueRes = NULL;
	private string $queryRes = "SELECT DISTINCT CONCAT(width,'x',height) as 'resolution',width*height as'number',width,height FROM wallpapers";

	/**
	 * setQuery function of WallpapersQuery class.
	 *
	 * @param $tParam
	 * What column in database to compare.
	 * @param $tParamValue
	 * With which value compare.
	 * @param $tQuery
	 * How query should look.
	 * @param $resQuery
	 * Get the value to resolution menu?
	 */
	function setQuery(null | string $tParam = NULL, null | string $tParamValue = NULL, null | string $tQuery = NULL, bool $resQuery = FALSE): void
	{
		if (!$resQuery)
		{
			$params = &$this->params;
			$paramsValue = &$this->paramsValue;
			$query = &$this->query;
		}
		else
		{
			$params = &$this->paramsRes;
			$paramsValue = &$this->paramsValueRes;
			$query = &$this->queryRes;
		}
		if (!$tParam == NULL && !$tParamValue == NULL)
		{
			if ($params == NULL && $paramsValue == NULL)
			{
				$query .= " WHERE ".$tQuery." ";
			}
			else
			{
				$query .= ' AND '.$tQuery." ";
			}
			$params[] = $tParam;
			$paramsValue[] = $tParamValue;
		}
		if ($tParam == NULL && $tParamValue == NULL && !$tQuery == NULL)
		{
			$this->query .= $tQuery;
		}
	}

	/**
	 * Returns array of filtered wallpapers or their resolutions
	 *
	 * @param $resolutions
	 * Get resolutions?
	 */
	function execute(bool $resolutions = FALSE): array | null
	{
		if (!$resolutions)
		{
			$params = &$this->params;
			$paramsValue = &$this->paramsValue;
			$query = $this->query;
		}
		else
		{
			$params = &$this->paramsRes;
			$paramsValue = &$this->paramsValueRes;
			$query = $this->queryRes." ORDER BY width";
		}
		if (!$params == NULL)
		{
			return getFilteredWallpapers($query, (array)$params, (array)$paramsValue);
		}
		else
		{
			return setData($query);
		}
	}
}

class Category
{
	/**
	 * @var WallpapersQuery
	 * instance of WallpapersQuery to filter wallpapers.
	 */
	private WallpapersQuery $sql;
	/**
	 * @var URLParams
	 * instance of URLParams to properly set up address in pagination.
	 */
	private URLParams $value;
	private array | null | bool $category;
	private array | null $wallpapers;
	private int | null $id;
	private int | null $p; //page
	private int | null $width;
	private int | null $height;
	private string | null $resolution;
	private int $howManyPages;
	private array $resolutionList;

	/**
	 * Category constructor.
	 *
	 * @param $resolution
	 * Current resolution to be shown or higher.
	 * @param $id
	 * ID of current category.
	 */
	function __construct(null | string $resolution, null | int $id)
	{
		$this->value = new URLParams(); //get filters to link
		$this->sql = new WallpapersQuery(); //get filters to sql
		//resolution
		$this->resolution = $resolution;
		$this->width = NULL;
		$this->height = NULL;
		if ($resolution > 0)
		{
			$wallpaper = getWallpaper($resolution, 'width*height', FALSE);
			if (!empty($wallpaper))
			{
				$this->width = $wallpaper['width'];
				$this->height = $wallpaper['height'];
				$this->sql->setQuery(":resolution", $this->resolution, "width*height >= :resolution");
				$this->value->valueParam("resolution=".$this->resolution);
			}
		}
		//category
		$this->id = $id;
		if ($id > 0 || $id == NULL)
		{
			$this->category = getCategory($this->id, 'id');
			if (!empty($this->category))
			{
				$this->sql->setQuery(":category", $this->category['category'], "category = :category");
				$this->sql->setQuery(":category", $this->category['category'], "category = :category", TRUE);
				$this->value->valueParam("id=".$this->id);
			}
			else
			{
				$this->category = setData("SELECT DISTINCT category FROM categories");
			}
		}
		else
		{
			$this->category = setData("SELECT DISTINCT category FROM categories");
		}
		//set wallpapers
		$this->wallpapers = $this->sql->execute();
		//set resolution list
		$this->resolutionList = $this->sql->execute(TRUE);
		//how many pages
		$this->howManyPages = ceil(count($this->wallpapers) / 20);
		if ($this->howManyPages > 1)
		{
			if (isset($_GET['p']))
			{
				$this->p = htmlentities($_GET['p']);
				if (!is_numeric($this->p) === TRUE || $this->p < 0 | !$this->howManyPages >= $this->p)
				{
					$this->p = NULL;
				}
			}
			else
			{
				$this->p = 1;
			}
			if ($this->p == 1)
			{
				$this->wallpapers = array_slice($this->wallpapers, 0, 20);
			}
			if ($this->p > 1)
			{
				$this->wallpapers = array_slice($this->wallpapers, $this->p * 20 - 20, 20);
			}
		}
	}

	/**
	 * Echo title of current category.
	 */
	function echoTitle(): void
	{
		//head
		if ($this->id == NULL)
		{
			echo 'Wszystkie tapety';
		}
		else
		{
			echo 'Tapety z kategorii '.$this->category['category'];
		}
	}

	/**
	 * Returns count of wallpapers array.
	 */
	function countWallpapers(): int
	{
		return count($this->wallpapers);
	}

	/**
	 * Echo category name or names to meta-tag.
	 */
	function echoDesc(): void
	{
		if (!$this->id == NULL)
		{
			echo 'z kategorii '.$this->category['category'];
		}
		else
		{
			echo 'z takich kategorii jak: ';
			for ($i = 0; $i < count($this->category); $i++)
			{
				if (!$i == 0)
					echo ", ";
				echo $this->category[$i]['category'];
			}
		}
	}

	/**
	 * Echo category name or names to meta-tag and titles of shown wallpapers.
	 */
	function echoKeywords(): void
	{
		if (!empty($this->wallpapers))
			foreach ($this->wallpapers as $title)
				echo ", ".$title['title'];
		if (!$this->id == NULL)
			echo ", ".$this->category['category'];
		else
		{
			for ($i = 0; $i < count($this->category); $i++)
			{
				if (!$i == 0)
					echo ", ";
				echo $this->category[$i]['category'];
			}
			$this->category = NULL;
		}
	}

	/**
	 * Echo options of resolutions menu.
	 */
	function echoResolutionsList(): void
	{
		if (!$this->width == NULL && !$this->height == NULL)
			echo ''.$this->width."x", $this->height.'';
		else
			echo 'WSZYSTKIE </a>';
		$stringId = NULL;
		if (!$this->id == NULL)
			$stringId = "&id=".$this->id;
		else if ($this->resolution == NULL && !$this->id == NULL)
			$stringId = "?id=".$this->id;
		
		if (!$this->width == NULL && !$this->height == NULL){
			echo "<a class='dropdown-item' type='button' href='kategoria.php";
			echo (!$this->id == NULL) ? "?id=".$this->id : "";
			echo "'>WSZYSTKIE</a>";
				}
		for ($i = 0; $i < count($this->resolutionList); $i++)
		{
			if (!($this->resolutionList[$i]['number'] == $this->resolution))
				echo "<a class='dropdown-item' type='button' href='kategoria.php?resolution=".$this->resolutionList[$i]['width'] * $this->resolutionList[$i]['height'].$stringId."'>".$this->resolutionList[$i]['resolution']."</a>";
		}
	}

	/**
	 * Echo before wallpapers what is shown.
	 */
	function echoH1(): void
	{
		if (isset($this->category))
			echo "Kategoria: ".$this->category['category'];
		else
		{
			echo "Wszystkie tapety";
		}
	}

	/**
	 * Echo wallpapers from wallpapers array.
	 */
	function echoWalls(): void
	{
		if (count($this->wallpapers) <= 0)
		{
			echo '<h1 class="text-danger text-center py-5">BRAK TAPET!</h1><br><br><br><br><br><br><br><br>';
		}
		else
		{
			foreach ($this->wallpapers as $paper)
			{
				echo '<div class="p-4"> <a href="tapeta.php?id='.$paper['id'].'">';
				if (!array_key_exists('image', $paper) || $paper['image'] == '' || !file_exists("wallpapers/miniatures/".$paper['image']))
				{
					echo '<img class="img-thumbnail miniatureImage" src="wallpapers/miniatures/notFound.png" alt="Brak">';
				}
				else
				{
					echo '<img class="img-thumbnail miniatureImage" alt="'.$paper['description'].'" src="wallpapers/miniatures/'.$paper['image'].'" title="'.$paper['title'].' " >';
				}
				echo '</a></div>';
			}
		}
	}

	/**
	 * Echo pagination if number of pages < 1.
	 */
	function pagination(): void
	{
		if ($this->howManyPages > 1)
		{
			$this->value->valueParam(NULL, TRUE);
			echo '
         <div class="pt-2 d-flex justify-content-center">
         <ul class="pagination">';
			if ($this->p > 1)
			{
				echo '<li class="page-item"><a class="page-link" href="kategoria.php?p='.($this->p - 1).$this->value->valueParam().'"><span aria-hidden="true">&laquo;</span></a></li>';
			}
			for ($i = 1; $i <= $this->howManyPages; $i++)
			{

				if ($this->p == $i)
				{
					echo '<li class="page-item"><a class="page-link active">'.$i.'</a></li>';
				}
				else
				{
					echo '<li class="page-item"><a class="page-link" href="kategoria.php?p='.$i.$this->value->valueParam().'">'.$i.'</a></li>';
				}
			}
			if ($this->p < $this->howManyPages)
			{
				echo ' <li class="page-item"><a class="page-link"  href="kategoria.php?p='.($this->p + 1).$this->value->valueParam().'"><span aria-hidden="true">&raquo;</span></a><li>';
			}
			echo "</ul></div>";
		}
	}
}

$resolution = NULL;
if (isset($_GET['resolution']))
{
	$resolution = htmlentities($_GET['resolution']);
}
$id = NULL;
if (isset($_GET['id']))
	$id = htmlentities($_GET['id']);
$walls = new Category($resolution, $id);