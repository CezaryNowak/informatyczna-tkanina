<?php

//delete wallpaper
if (isset($_POST['delete']))
{
	$id = filter_input(INPUT_POST, 'delete');
	if ($id > 0)
	{
		$image = getWallpaper($id, 'id', FALSE);
		$image = $image['image'];
		if (file_exists("../wallpapers/$image"))
			unlink("../wallpapers/$image");
		if (file_exists("../wallpapers/display/$image"))
			unlink("../wallpapers/display/$image");
		if (file_exists("../wallpapers/full/$image"))
			unlink("../wallpapers/full/$image");
		if (file_exists("../wallpapers/miniatures/$image"))
			unlink("../wallpapers/miniatures/$image");
		if (!file_exists($image) && deleteWallpaper($id))
		{
			$_SESSION['messageShow'] = "Pomyślnie usunięto tapetę!";
			$_POST['delete'] = NULL;
			header("Location: listaTapet.php");
		}
		else
		{
			echo '<script> alert("Błąd usunięcia!")</script>';
		}
	}
	else
	{
		echo '<script> alert("Id jest niepoprawne!"); alert("Id:'.$id.'");</script>';
	}
}

class WallList
{
	private array | null $wallpapers;
	private int | null $numberPages;
	private int | null $p;

	/**
	 * WallList constructor.
	 *
	 * @param $wallpapers
	 * Wallpapers detail form database
	 * Sets up: int of how many pages there should be
	 * and int of which page is currently on.
	 */
	function __construct(array | null $wallpapers)
	{
		$this->wallpapers = $wallpapers;
		$this->numberPages = ceil(count($this->wallpapers) / 10);
		if ($this->numberPages > 1)
		{
			if (isset($_GET['p']))
			{
				$this->p = htmlentities($_GET['p']);
			}
			else
			{
				$this->p = 1;
			}
			if ($this->p == 1)
			{
				$this->wallpapers = array_slice($this->wallpapers, 0, 10);
			}
			if ($this->p > 1)
			{
				$this->wallpapers = array_slice($this->wallpapers, $this->p * 10 - 10, 10);
			}
		}
	}

	/**
	 * Echo wallpapers details in table.
	 */
	function echoTableWalls(): void
	{
		if (!empty($this->wallpapers))
		{
			foreach ($this->wallpapers as $paper)
			{
				echo "
            <tr>
            <td>".$paper['id']."</td>
            <td><a class='bg-primary rounded btn' href='../tapeta.php?id=".$paper['id']."'><div>".$paper['title']."</div></a></td>
            <td>".$paper['date']."</td><td>".$paper['category']."</td> <td><a href='edytujTapete.php?id=".$paper['id']."'><button class='btn btn-warning' >Edytuj</button></a></td>
            <td><form method='post'><button type='submit' class='btn btn-danger' name='delete' value='".$paper['id']."'>USUŃ</button></form></td>
            </tr>";
			}
		}
		else
		{
			echo "<h1 class='text-danger'>Brak tapet!</h1>";
		}
	}

	/**
	 * If there should be more than one page then echo pagination.
	 */
	function pagination(): void
	{
		if ($this->numberPages > 1)
		{
			echo '
            <div class="pt-2 d-flex justify-content-center">
            <ul class="pagination">';
			if ($this->p > 1)
			{
				echo '<li class="page-item"><a class="page-link" href="listaTapet.php?p='.($this->p - 1).'"><span aria-hidden="true">&laquo;</span></a></li>';
			}
			for ($i = 1; $i <= $this->numberPages; $i++)
			{

				if ($this->p == $i)
				{
					echo '<li class="page-item"><a class="page-link active">'.$i.'</a></li>';
				}
				else
				{
					echo '<li class="page-item"><a class="page-link" href="listaTapet.php?p='.$i.'">'.$i.'</a></li>';
				}
			}
			if ($this->p < $this->numberPages)
			{
				echo '<li class="page-item"><a class="page-link" href="listaTapet.php?p='.($this->p + 1).'"><span aria-hidden="true">&raquo;</span></a></li>';
			}
			echo "</ul></div>";
		}
	}
}

$listWall = new WallList(setData('SELECT * FROM wallpapers ORDER BY id'));