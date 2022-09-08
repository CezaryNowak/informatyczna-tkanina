<?php

//delete account
if (isset($_POST['passe']) && isset($_POST['deleteAcc']))
{
	$id = $_SESSION['logged_id'];
	if ($id > 0)
	{
		if ($id == 1)
		{
			$_SESSION['e_deleteAcc'] = "Nie możesz usunąć głównego admina!";
		}
		else
		{
			$admin = getUser($id);
			if (empty($admin))
			{
				echo '<script> alert("Id jest niepoprawne!"); </script>';
			}
			else
			{
				$pass = filter_input(INPUT_POST, 'passe');
				if (password_verify($pass, $admin['password']))
				{
					if (deleteUser($id))
					{
						unset($_POST['delete']);
						unset($_SESSION['e_deleteAcc']);
						header("Location: logout.php");
						die();
					}
					else
					{
						echo '<script> alert("Błąd usunięcia!")</script>';
					}
				}
				else
				{
					$_SESSION['e_deleteAcc'] = "NIEPOPRAWNE HASŁO";
				}
			}
		}
	}
	else
	{
		echo '<script> alert("Id jest niepoprawne!"); </script>';
	}
}
//change password
if (isset($_POST['currentPass']) && isset($_POST['changePass']))
{
	$id = $_SESSION['logged_id'];
	if ($id > 0)
	{
		if ($id == 1)
		{
			$_SESSION['e_adminCh'] = "Nie możesz zmienić hasła głównego admina!";
		}
		else
		{
			$admin = getUser($id);
			if (empty($admin))
			{
				echo '<script> alert("Id jest niepoprawne!"); </script>';
			}
			else
			{
				$changePasswordFlag = TRUE;
				$pass = filter_input(INPUT_POST, 'currentPass');
				$pass1 = filter_input(INPUT_POST, 'password');
				$pass2 = filter_input(INPUT_POST, 'newPassConf');
				//new password
				if (strlen($pass1) < 7 || strlen($pass1) > 20)
				{
					$changePasswordFlag = FALSE;
					$_SESSION['e_newPass'] = "Długość hasła powinna wynosić od 7 do 20 znaków!";
				}
				//confirm new password
				if ($pass1 != $pass2)
				{
					$changePasswordFlag = FALSE;
					$_SESSION['e_newPassConf'] = "Hasła nie są takie same!";
				}
				//old password
				if (!password_verify($pass, $admin['password']))
				{
					$changePasswordFlag = FALSE;
					$_SESSION['e_pass'] = "Hasło nie jest poprawne!";
				}
				//if success
				if ($changePasswordFlag === TRUE)
				{
					$hash = password_hash($pass1, PASSWORD_DEFAULT);
					if (setUser($hash, $id))
					{
						$_SESSION['messageShow'] = "Pomyślnie zmieniono hasło!";
						header("Location: listaUzytkownikow.php");
						die();
					}
					else
					{
						echo '<script> alert("Błąd Zmiany!")</script>';
					}
				}
			}
		}
	}
	else
	{
		echo '<script> alert("Id jest niepoprawne!"); </script>';
	}
}

class UserList
{
	private array $admins;

	/**
	 * UserList constructor.
	 *
	 * @param $admins
	 * Details about users (without password) from database.
	 */
	function __construct(array | null $admins)
	{
		$this->admins = $admins;
	}

	/**
	 * Echo admins parameters in table.
	 */
	function echoAdmins(): void
	{
		if (!empty($this->admins))
		{
			foreach ($this->admins as $admin)
			{
				echo "
                <tr>
                <td>".$admin['id']."</td>
                <td>".$admin['date']."</td>
                <td>".$admin['nick']."</td>
                <td>".$admin['email']."</td>
            </tr>";
			}
		}
		else
		{
			echo "
            </table>
            <h1 class='text-danger text-center bg-dark'>Brak użykowników!</h1>";
		}
	}

	//errors

	/**
	 * Echo error if typed password is incorrect in change password popup.
	 */
	function echoNickeError(): void
	{
		if (isset($_SESSION['e_deleteAcc']))
		{
			echo '<div class="text-danger text-center">'.$_SESSION['e_deleteAcc'].'</div>
                              <script type="module">
                              import * as bootstrap from "bootstrap"
                              let deleteModal = new bootstrap.Modal(document.getElementById("deleteAccPopup"), {});
                              document.onreadystatechange = function () {
                              deleteModal.show();
                              };
                              </script>';
			unset($_SESSION['e_deleteAcc']);
		}
	}

	/**
	 * Echo error if typed password is incorrect in change password popup.
	 */
	function echoPassError(): void
	{
		if (isset($_SESSION['e_pass']))
		{
			echo '<div class="text-danger">'.$_SESSION['e_pass'].'</div>
                        <script type="module">
                        import * as bootstrap from "bootstrap"
                        let changeModal = new bootstrap.Modal(document.getElementById("changePassPopup"), {});
                        document.onreadystatechange = function () {
                        changeModal.show();
                                      };
                        </script>';
			unset($_SESSION['e_pass']);
		}
	}

	/**
	 * Echo error if new password does not meets requirements.
	 */
	function echoNewPassError(): void
	{
		if (isset($_SESSION['e_newPass']))
		{
			echo '<div class="text-danger">'.$_SESSION['e_newPass'].'</div>';
			echo '<script type="module">
                        import * as bootstrap from "bootstrap"
                        let myModal = new bootstrap.Modal(document.getElementById("changePassPopup"), {});
                        document.onreadystatechange = function () {
                        myModal.show();
                                      };
                        </script>';
			unset($_SESSION['e_newPass']);
		}
	}

	/**
	 * Echo error if confirmation password is not same as new password.
	 */
	function echoConfPassError(): void
	{
		if (isset($_SESSION['e_newPassConf']))
		{
			echo '<div class="text-danger">'.$_SESSION['e_newPassConf'].'</div>';
			echo '<script type="module">
                            import * as bootstrap from "bootstrap"
                            let myModal = new bootstrap.Modal(document.getElementById("changePassPopup"), {});
                            document.onreadystatechange = function () {
                            myModal.show();
                                          };
                            </script>';
			unset($_SESSION['e_newPassConf']);
		}
	}

	/**
	 * Echo error if first admin wants to delete it.
	 */
	function echoAError(): void
	{
		if (isset($_SESSION['e_adminCh']))
		{
			echo '<div class="text-danger">'.$_SESSION['e_adminCh'].'</div>';
			echo '<script type="module">
                        import * as bootstrap from "bootstrap"
                        let myModal = new bootstrap.Modal(document.getElementById("changePassPopup"), {});
                        document.onreadystatechange = function () {
                         myModal.show();
                                      };
                                  </script>';
			unset($_SESSION['e_adminCh']);
		}
	}

	/**
	 * Returns true if main admin is logged and false if not.
	 */
	function isMainAdmin(): bool
	{
		return ($_SESSION['logged_id']==1 && $_SESSION['logged_login']=="admin")? true: false;
	}

	/**
	 * Echo button to add new user if main admin is logged.
	 */
	function echoAddButton(): void
	{
		echo ($this->isMainAdmin())? '<a href="dodajUzytkownika.php" class="btn btn-success">DODAJ NOWEGO UŻYTKOWNIKA</a>':"";
	}
}
	

$listUser = new UserList(setData('SELECT id,nick,email,date FROM admins ORDER BY id'));
