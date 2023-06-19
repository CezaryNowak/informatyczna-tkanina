<?php

include_once "data/setupData.php";
/**
 * Gets array of users from database.
 *
 * @param $value
 *   User of which value of column.
 * @param $inData
 *   Which column to compare.
 */
function getUser(string $value, string $inData = 'id'): array | null | bool
{
	$query = "SELECT * FROM admins WHERE $inData = :param";
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('param', $value);
	$stmt->execute();
	return $stmt->fetch();
}

/**
 * Adds new user to database.
 *
 * @param $nick
 *   Nick of new user.
 * @param $email
 *   Email of new user.
 * @param $pass
 *   Password of new user.
 */
function addUser(string $nick, string $email, string $pass): bool
{
	$query = "INSERT INTO admins(id, nick, email, password, date) VALUES (null, :nick, :email, :pass, current_date())";
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('nick', $nick);
	$stmt->bindParam('email', $email);
	$stmt->bindParam('pass', $pass);
	return $stmt->execute();
}

/**
 * Sets new password for user in database.
 *
 * @param $pass
 *   New password;
 * @param $id
 *   Which user.
 */
function setUser(string $pass, int $id): bool
{
	$query = "UPDATE admins SET password=:pass WHERE id=:id";
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('pass', $pass);
	$stmt->bindParam('id', $id);
	return $stmt->execute();
}

/**
 * Deletes user form database.
 *
 * @param $id
 *   Which user.
 */
function deleteUser(int $id): bool
{
	$query = 'DELETE FROM admins WHERE id = :idVal';
	$stmt = $GLOBALS['pdo']->prepare($query);
	$stmt->bindParam('idVal', $id);
	return $stmt->execute();
}
