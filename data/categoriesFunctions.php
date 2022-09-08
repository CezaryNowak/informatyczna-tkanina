<?php

include_once setDefaultPath("data/setupData.php");
/**
 * Adds new category to database.
 *
 * @param $name
 *   Name of new category.
 */
function addCategory(string $name): bool
{
	$query = "INSERT INTO categories values (null,:name,current_date())";
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('name', $name);
	return $stmt->execute();
}

/**
 * Gets categories from database.
 *
 * @param $value
 *   Wanted value of column.
 * @param $column
 *   Wanted column to compare.
 * @param $withCount
 *   Categories with count of how many wallpapers.
 */
function getCategory(string $value = NULL, string | null $column = 'category', bool $withCount = FALSE): array | null | bool
{
	if ($withCount === FALSE)
	{
		$query = "SELECT * FROM categories WHERE $column = :param";
	}
	else
	{
		$query = "SELECT categories.id, categories.category,categories.date, COUNT(title) as 'count' FROM categories
              LEFT JOIN wallpapers ON categories.category=wallpapers.category GROUP BY id";
	}
	$stmt = $GLOBALS['pdo']->prepare($query);
	if ($withCount === FALSE)
	{
		$stmt->bindParam('param', $value);
	}
	$stmt->execute();
	if ($withCount === FALSE)
	{
		return $stmt->fetch();
	}
	else
		return $stmt->fetchAll();
}

/**
 * Updates name of category in database.
 *
 * @param $id
 *   Wanted category of specific id to change its name.
 * @param $name
 *   New name for category.
 */
function updateCategory(int $id, string $name): bool
{
	$query = "UPDATE categories SET category=:name WHERE id=:id";
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('name', $name);
	$stmt->bindParam('id', $id);
	return $stmt->execute();
}

/**
 * Deletes category from database.
 *
 * @param $id
 *   Which one category.
 */
function deleteCategory(int $id): bool
{
	$sql = 'DELETE FROM `categories` WHERE id = :idValue';
	$stmt = $GLOBALS['pdo']->prepare($sql);
	$stmt->bindParam('idValue', $id);
	return $stmt->execute();
}
