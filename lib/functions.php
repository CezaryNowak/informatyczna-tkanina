<?php

/**
 * Creates random string.
 *
 * @param int $n
 *   How many characters should it create.
 *
 * @return string
 */
function randomString(int $n): string
{
	$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$str = '';
	for ($i = 0; $i < $n; $i++)
	{
		$index = rand(0, strlen($chars) - 1);
		$str .= $chars[$index];
	}
	return $str;
}

/**
 * Replace bytes to higher unit of bytes.
 *
 * @param int $bytes
 *   Bytes file size to change.
 * @param int $decimals $cssFile
 *   Set precision.
 *
 * @returns string
 */
function humanFileSize(int $bytes, int $decimals = 2): string
{
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor))." ".@$sz[$factor]."B";
}

/**
 * Checks if folders used to store wallpapers exist and if not creates them.
 *
 * @return void
 */
function mkWallpapersDir(): void
{
	if (!is_dir('../wallpapers'))
	{
		mkdir("../wallpapers");
	}
	if (!is_dir('../wallpapers/full'))
	{
		mkdir("../wallpapers/full");
	}
	if (!is_dir('../wallpapers/display'))
	{
		mkdir("../wallpapers/display");
	}
	if (!is_dir('../wallpapers/miniatures'))
	{
		mkdir("../wallpapers/miniatures");
	}
}

/**
 * Creates scaled images from main image.
 *
 * @param string $filename
 * @param string|null $fileExt
 *
 * @return void
 */
function scaleImages(string $filename, string $fileExt = NULL): void
{
	if ($fileExt == NULL)
	{
		$fileExt = explode('.', $filename);
		$fileExt = strtolower(end($fileExt));
	}
	$image = NULL;
	if ($fileExt == 'png')
		$image = imagecreatefrompng("../wallpapers/full/$filename");
	if ($fileExt == 'gif')
		$image = imagecreatefromgif("../wallpapers/full/$filename");
	if ($fileExt == 'jpg' || $fileExt == 'jpeg')
		$image = imagecreatefromjpeg("../wallpapers/full/$filename");
	$imgDisplay = imagescale($image, 600, 400);
	$imgMiniature = imagescale($image, 300, 200);
	if ($fileExt == 'png')
	{
		imagepng($imgMiniature, "../wallpapers/miniatures/$filename");
		imagepng($imgDisplay, "../wallpapers/display/$filename");
	}
	if ($fileExt == 'gif')
	{
		imagegif($imgMiniature, "../wallpapers/miniatures/$filename");
		imagegif($imgDisplay, "../wallpapers/display/$filename");
	}
	if ($fileExt == 'jpg' || $fileExt == 'jpeg')
	{
		imagejpeg($imgMiniature, "../wallpapers/miniatures/$filename");
		imagejpeg($imgDisplay, "../wallpapers/display/$filename");
	}
}
