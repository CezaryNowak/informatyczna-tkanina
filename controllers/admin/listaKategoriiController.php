<?php

//edit category
if (isset($_POST['update']) && isset($_POST['newCatName']))
{
	$name = $_POST['newCatName'];
	$name = htmlentities($name, ENT_QUOTES, "UTF-8");
	$name = trim($name);
	$id = $_POST['update'];
	if (strlen($name) < 3 || strlen($name) > 21)
	{
		$isOk = FALSE;
		$_SESSION['e_cateUp'] = "Nazwa kategorii może zawierać od 3 do 21 znaków!";
	}
	else
	{
		$category = getCategory($name);
		if (!empty($category))
		{
			$_SESSION['e_cateUp'] = "TAKA KATEGORIA JUŻ ISTNIEJE";
		}
		else
		{
			$name = htmlentities($name, ENT_QUOTES, "UTF-8");
			$name = trim($name);
			$name = strtolower($name);
			$name[0] = strtoupper($name[0]);
			$oldName = getCategory($id, 'id');
			$papers = getWallpaper($oldName['category'], 'category');
			if (updateCategory($id, $name))
			{
				if (!empty($papers))
				{
					foreach ($papers as $paper)
					{
						updateWallCategory($paper['id'], $name);
					}
				}
				$_SESSION['messageShow'] = "Pomyślnie zaktualizowano kategorie!";
				unset($_SESSION["e_cateUp"]);
				header("Location: listaKategorii.php");
				die();
			}
		}
	}
}
//delete category
if (isset($_POST['delete']))
{
	$id = filter_input(INPUT_POST, 'delete');
	if ($id > 0)
	{
		$category = getCategory($id, 'id');
		$wallpapers = getWallpaper($category['category'], 'category') ?? NULL;
		if (empty($wallpapers))
		{
			if (deleteCategory($id))
			{
				$_SESSION['messageShow'] = "Pomyślnie usunięto kategorie!";
				$_POST['delete'] = NULL;
				header("Location: listaKategorii.php");
			}
			else
			{
				$_SESSION['e_delete'] = "Błąd usunięcia";
			}
		}
		else
		{
			$_SESSION['e_delete'] = "Kategoria jest powiązana z tapetami! Usuń najpierw tapety z daną kategoria!";
		}
	}
	else
	{
		$_SESSION['e_delete'] = "Id jest niepoprawne!";
	}
}

class CategoryList
{
	private array | null $categories;

	/**
	 * CategoryList constructor.
	 *
	 * @param $categories
	 * Details of wallpapers from database.
	 */
	function __construct(array | null $categories)
	{
		$this->categories = $categories;
	}

	/**
	 * Echo error if category cannot be deleted.
	 */
	function echoDeleteError(): void
	{
		if (isset($_SESSION['e_delete']))
		{
			echo '<div class="bg-dark text-center text-danger">'.$_SESSION['e_delete'].'</div>';
			unset($_SESSION['e_delete']);
		}
	}

	/**
	 * Echo categories details in table.
	 */
	function echoTable(): void
	{
		if (!empty($this->categories))
		{
			$i = 0;
			foreach ($this->categories as $category)
			{
				echo "
                    <tr>
                    <td>".$category['id']."</td>
                    <td>".$category['date']."</td>
                    <td>".$category['count']."</td>
                    <td>".$category['category']."</td>
                    <td><button class='btn btn-warning' type='button' data-bs-toggle='collapse' data-bs-target='#EditCategoryForm$i' aria-expanded='false' aria-controls='EditCategoryForm$i'>Edytuj</button></td>
                    <td><form name='deleteForm' method='post'><button type='submit' name='delete' class='btn btn-danger' value='".$category['id']."'>USUŃ</button></form></td>
                    </tr>
                    <tr>
                    <td colspan='6'>
                     <div class='accordion accordion' id='accordionFlushExample'>
                        <div class='accordion-item'>
                            <div id='EditCategoryForm$i' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample'>
                                <div class='accordion-body'>
                                    <form method='post' id='updateForm$i'>
                                        <input type='text' value='".$category['category']."' name='newCatName' form='updateForm$i'> <button type='submit' name='update' class='btn btn-success' value='".$category['id']."'>Potwierdź</button>
                                        <button class='btn btn-warning' type='button' data-bs-toggle='collapse' data-bs-target='#EditCategoryForm$i' aria-expanded='false' aria-controls='EditCategoryForm$i'>Anuluj</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                     </div>
                    </td>
                    </tr>";
				$i++;
			}
		}
		else
		{
			echo "<h1 class='text-danger bg-dark'>Brak kategorii!</h1>";
		}
	}

	/**
	 * Echo error of new category name.
	 */
	function echoEditError(): void
	{
		if (isset($_SESSION["e_cateUp"]))
		{
			echo '<div class="text-danger bg-dark text-center">'.$_SESSION['e_cateUp'].'</div>';
			$_SESSION["e_cateUp"] = NULL;
			unset($_SESSION['e_cateUp']);
		}
	}
}

$listCats = new CategoryList(getCategory(NULL, NULL, TRUE));