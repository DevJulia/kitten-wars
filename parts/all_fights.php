<?php try {
    $bdd = new PDO('mysql:host=localhost;dbname=kitten_wars;charset=utf8', 'root', '');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
} 


	$req = $bdd -> prepare('SELECT * FROM fights ORDER BY fight_date DESC');
	$req -> execute();
	



	while ($fight = $req -> fetch()) { ?>
	
		<div class="col-4">
		
		<h4 class="pt-4 pb-2">
		<?php 
			$newDate = date("j/m/Y à H:i", strtotime($fight['fight_date']));
			echo "Le " . $newDate; ?>
		</h4>
		
		<?php 
		
		$req2 = $bdd -> prepare('SELECT id, name FROM kitten WHERE id = :id');
		$req2 -> bindValue('id', $fight['winner_id']);
		$req2 -> execute();
		$winner = $req2 -> fetch();
		$req2 -> closeCursor();
		
		$req2 = $bdd -> prepare('SELECT id, name FROM kitten WHERE id = :id');
		$req2 -> bindValue('id', $fight['loser_id']);
		$req2 -> execute();
		$looser = $req2 -> fetch();
		$req2 -> closeCursor();
									  
		?>
		
			<p>Gagnant : <?php if ($fight['winner_id'] == -1) { echo "Chat supprimé"; }
				else { ?>
				<a href="chat.php?id=<?php echo $winner['id'] ?>"><?php echo $winner['name'] ?></a>
				<?php } ?>
			</p>							  
			<p>Perdant :  <?php if ($fight['loser_id'] == -1) { echo "Chat supprimé"; }
				else { ?>
				<a href="chat.php?id=<?php echo $looser['id'] ?>"><?php echo $looser['name'] ?></a>
				<?php } ?>
			</p>								 
		</div>
		
	<?php }

	$req -> closeCursor();
	

?>