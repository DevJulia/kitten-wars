<?php try {
    $bdd = new PDO('mysql:host=localhost;dbname=kitten_wars;charset=utf8', 'root', '');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
} 

if (isset($_POST['cat'])) {
	$catId = htmlspecialchars($_POST['cat']);

	$req = $bdd -> prepare('SELECT * FROM kitten WHERE id = :catId');
	$req -> bindValue('catId', $catId, PDO::PARAM_INT);
	$req -> execute();

	$kitten = $req -> fetch();
	$req -> closeCursor();
	
	if ($kitten == false) {
		echo "Le chat sélectionné n'existe pas";
	} else {
		$req = $bdd -> prepare('DELETE FROM kitten WHERE id = :catId');
		$req -> bindValue('catId', $catId, PDO::PARAM_INT);
		$req -> execute();
		$req -> closeCursor();
		
		$req = $bdd -> prepare('UPDATE fights SET winner_id = -1 WHERE winner_id = :catId OR loser_id = :catId');
		$req -> bindValue('catId', $catId, PDO::PARAM_INT);
		$req -> execute();
		$req -> closeCursor();
		
		$req = $bdd -> prepare('UPDATE fights SET loser_id = -1 WHERE winner_id = :catId OR loser_id = :catId');
		$req -> bindValue('catId', $catId, PDO::PARAM_INT);
		$req -> execute();
		$req -> closeCursor();
		
		$req = $bdd -> query('DELETE FROM fights WHERE winner_id = -1 AND loser_id = -1');
		$req -> closeCursor();
		
		if ($kitten['avatar'] != "default.jpg") {
			$images_dir = opendir("../images/kitten");
			$path = "../images/kitten/" . $kitten['avatar'];
			unlink($path);
			closedir($images_dir);	
		}
		
		echo "Le chat " . $kitten['name']. " a été supprimé";	
	}

} else {
	echo "Veuillez sélectionner un chat à supprimer en allant sur son profil";
}

?>