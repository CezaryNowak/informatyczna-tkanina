<?php

$GLOBALS['pdo'] = require "setupData.php";
/**
 * Gets data without variables.
 *
 * @param $request
 *   Sql query.
 * @param $one
 *   Fetch all or just one.
 */
function setData(string $request = NULL, bool $one = FALSE): array | null
{
	$result = $GLOBALS['pdo']->prepare($request);
	$result->execute();
	if (!$one)
		return $result->fetchAll();
	else
		return $result->fetch();
}

include_once "data/adminsFunctions.php";
include_once "data/categoriesFunctions.php";
include_once "data/wallpapersFunctions.php";
