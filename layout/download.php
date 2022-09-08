<?php

/**
 * Sets requested file to download.
 *
 * @param $file
 */
function downloadWallpaper($file = NULL): void
{
	$filepath = "../wallpapers/full/".$file;
	if (file_exists($filepath))
	{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: '.filesize($filepath));
		flush(); // Flush system output buffer
		readfile($filepath);
		die();
	}
	else
	{
		header("Location: ../index.php");
	}
}

if (isset($_REQUEST["file"]))
{
	downloadWallpaper($_REQUEST["file"]);
}
else
{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
}
