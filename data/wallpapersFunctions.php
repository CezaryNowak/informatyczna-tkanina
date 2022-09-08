<?php

include_once setDefaultPath("data/setupData.php");
/**
 * Updates category of wallpaper in database.
 *
 * @param $id
 *   Index of wallpaper.
 * @param $cat
 *   New name.
 */
function updateWallCategory(int $id, string $cat): bool
{
	$query = "UPDATE wallpapers SET category=:cat WHERE id=:id";
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('cat', $cat);
	$stmt->bindParam('id', $id);
	return $stmt->execute();
}

/**
 * Adds new wallpaper in database.
 *
 * @param $title
 *   Title for new wallpaper.
 * @param $description
 *   Description for new wallpaper.
 * @param $category
 *   Category for new wallpaper.
 * @param $image
 *   Image name of new wallpaper.
 * @param $size
 *   Size of new image.
 * @param $width
 *   Width of new image.
 * @param $height
 *   Height of new image.
 */
function addWallpaper(string $title, string $description, string $category, string $image, int $size, int $width, int $height): bool
{
	$query = "INSERT INTO wallpapers(id, title, description, category, image, size, width, height, date) 
    VALUES (null, :title, :description, :category, :image, :size, :width, :height, current_date())";
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('title', $title);
	$stmt->bindParam('description', $description);
	$stmt->bindParam('category', $category);
	$stmt->bindParam('image', $image);
	$stmt->bindParam('size', $size);
	$stmt->bindParam('width', $width);
	$stmt->bindParam('height', $height);
	return $stmt->execute();
}

/**
 * Updates parameters of wallpaper in database.
 *
 * @param $id
 *   Id of wallpaper.
 * @param $title
 *   New title for wallpaper.
 * @param $description
 *   New description for wallpaper.
 * @param $category
 *   New category for wallpaper.
 */
function updateWallpaperParams(int $id, string $title, string $description, string $category): bool
{
	$query = "UPDATE wallpapers SET title=:title,description=:description,category=:category WHERE id=:id";
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('id', $id);
	$stmt->bindParam('title', $title);
	$stmt->bindParam('description', $description);
	$stmt->bindParam('category', $category);
	return $stmt->execute();
}

/**
 * Updates name of image file of wallpaper in database.
 *
 * @param $id
 *   Id of wallpaper.
 * @param $image
 *   New image for wallpaper.
 * @param $size
 *   Size of new image.
 * @param $width
 *   Width of new image.
 * @param $height
 *   Height of new image.
 */
function updateWallpaperImage(int $id, string $image, int $size, int $width, int $height): bool
{
	$query = "UPDATE wallpapers SET image=:image,size=:size,width=:width,height=:height WHERE id=:id";
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('id', $id);
	$stmt->bindParam('image', $image);
	$stmt->bindParam('size', $size);
	$stmt->bindParam('width', $width);
	$stmt->bindParam('height', $height);
	return $stmt->execute();
}

/**
 * Deletes wallpaper from database.
 *
 * @param $id
 *   ID of wallpaper.
 */
function deleteWallpaper(int $id = NULL): bool
{
	$sql = 'DELETE FROM `wallpapers` WHERE id = :idValue';
	$stmt = $GLOBALS['pdo']->prepare($sql);
	$stmt->bindParam('idValue', $id);
	return $stmt->execute();
}

/**
 * Gets specified wallpapers info from database.
 *
 * @param $paramV
 *   Wanted value of column.
 * @param $inData
 *   Which column to compare.
 * @param $many
 *   Fetch all or one.
 */
function getWallpaper(string $paramV, string $inData = 'id', bool $many = TRUE): array | null
{
	$query = "SELECT * FROM wallpapers WHERE $inData = :param";
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('param', $paramV);
	$stmt->execute();
	if ($many === TRUE)
		return $stmt->fetchAll();
	else
		return $stmt->fetch();
}

/**
 * Gets wallpapers with many specified conditions from database.
 *
 * @param $query
 *   Wanted query.
 * @param $params
 *   Array of columns to compare.
 * @param $paramsValue
 *   Array of values to compare with columns.
 */
function getFilteredWallpapers(string $query, array $params, array $paramsValue): array | null
{
	if (!$params == NULL || !count($params) == count($paramsValue))
	{
		$result = $GLOBALS['pdo']->prepare($query);
		for ($i = 0; $i < count($params); $i++)
		{
			$result->bindParam($params[$i], $paramsValue[$i]);
		}
		$result->execute();
		return $result->fetchAll();
	}
	else
		return NULL;
}
