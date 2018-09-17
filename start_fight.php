<?php include('parts/header.php'); ?>

<div class="container">

	<h1 class ="text-center">Fight!</h1>

<?php 

	if (isset($_POST['chaton1']) && !empty($_POST['chaton1']) && isset($_POST['chaton2']) && !empty($_POST['chaton2']) ) {
		
		//Vérification si les chats sont présents en BDD
		$nomChaton1 = htmlspecialchars($_POST['chaton1']);
		$nomChaton2 = htmlspecialchars($_POST['chaton2']);
		
		$req = $bdd -> prepare('SELECT * FROM kitten WHERE name = :name');
		$req -> bindValue('name', $nomChaton1, PDO::PARAM_STR);
		$req -> execute();
		
		$req2 = $bdd -> prepare('SELECT * FROM kitten WHERE name = :name');
		$req2 -> bindValue('name', $nomChaton2, PDO::PARAM_STR);
		$req2 -> execute();
		
		$kitten1 = $req -> fetch();
		$kitten2 = $req2 -> fetch();
		
		$req -> closeCursor();
		$req2 -> closeCursor();
		
		if ( ($kitten1 == false) && ($kitten2 == true) )  {
			echo "Le chaton " . $nomChaton1 ." n'existe pas.";
		} else if ( ($kitten1 == true) && ($kitten2 == false) ) {
			echo "Le chaton " . $nomChaton2 ." n'existe pas.";
		} else if ( ($kitten1 == false) && ($kitten2 == false) ) {
			echo "Les chatons " . $nomChaton1 ." et " . $nomChaton2 ." n'existent pas.";
		} else {	
			//Vérification que les chats sont différents
			if ($nomChaton1 == $nomChaton2) {
				echo "Veuillez sélectionner des chats différents";
			} else {
			//Les chats existent et sont différents, on peut lancer le combat	
			?>	
			
			
			
			<p>Les chatons <?php echo $kitten1['name']; ?> et <?php echo $kitten2['name']; ?> sont prêts à combattre.</p>
			<div class="text-center">
				<button class="btn btn-primary btn-lg" id="showFight">Cliquez pour commencer</button>
			</div>
			
			<div class = "text-center m-5 p-4 border border-info d-none" id="stepsFight">
				<ul class="list-group list-group-flush">
			<?php 	
			
				echo "<li class='list-group-item font-italic'>";
				
			$kitten1['power'] += rand(-10 , 10);
			$kitten2['cuteness'] += rand(-10, 10);
				echo $kitten1['name'] ." [".$kitten1['power'] ."] contre " . $kitten2['name'] . " [" . $kitten2['cuteness'] . "]";
				echo "</li>";
				echo "<li class='list-group-item'>";
			if ($kitten1['power'] > $kitten2['cuteness']) {
				$victory1 = 1;
				$victory2 = 0;
				echo $kitten1['name'] . " gagne la première manche !"; 
			} else if ($kitten1['power'] < $kitten2['cuteness']) {
				$victory2 = 1;
				$victory1 = 0;
				echo $kitten2['name'] . " gagne la première manche !"; 
			} else if ($kitten1['power'] == $kitten2['cuteness']) {
				$victory1 = 0;
				$victory2 = 0;
				echo "Egalité!";
			}
				echo "</li>";
				
				echo "<li class='list-group-item font-italic'>";
				
			$kitten1['cuteness'] += rand(-10, 10);
			$kitten2['power'] += rand(-10, 10);
				echo $kitten1['name'] ." [".$kitten1['cuteness'] ."] contre " . $kitten2['name'] . " [" . $kitten2['power'] . "]";
				echo "</li>";
				echo "<li class='list-group-item'>";
			if ($kitten1['cuteness'] > $kitten2['power']) {
				$victory1++;
				echo $kitten1['name'] . " gagne la deuxième manche !"; 
			} else if ($kitten1['cuteness'] < $kitten2['power']) {
				$victory2++;
				echo $kitten2['name'] . " gagne la deuxième manche !"; 
			} else if ($kitten1['cuteness'] == $kitten2['power']) {
				echo "Egalité!";
			}	
				echo "</li>";
				
				echo "<li class='list-group-item pt-4 font-weight-bold'>";
			
			if ($victory1 > $victory2) {
				$winner = $kitten1;
				$looser = $kitten2;
			} else if ($victory2 > $victory1) {
				$winner = $kitten2;
				$looser = $kitten1;
			} else if ($victory1 == $victory2) {
				$winner = rand(1,2);
				if ($winner == 1) {
					$winner = $kitten1;
					$looser = $kitten2;
				} else {
					$winner = $kitten2;
					$looser = $kitten1;
				}
			}
				$req = $bdd -> prepare('UPDATE kitten SET balance = balance + 1 WHERE name= :name');
				$req -> bindValue('name', $winner['name'], PDO::PARAM_STR);
				$req -> execute();
				$req -> closeCursor();
				
				$req = $bdd -> prepare('UPDATE kitten SET balance = balance - 1 WHERE name= :name');
				$req -> bindValue('name', $looser['name'], PDO::PARAM_STR);
				$req -> execute();
				$req -> closeCursor();
				
				$req = $bdd -> prepare("INSERT INTO fights (winner_id, loser_id, fight_date) VALUES ( :winner, :looser, NOW())");
				$req -> bindValue('winner', $winner['id'], PDO::PARAM_INT);
				$req -> bindValue('looser', $looser['id'], PDO::PARAM_INT);
				$req -> execute();
				$req -> closeCursor();
				
				echo $winner['name'] . " a gagné le combat !";
				echo "</li>";
				
			?>
				</ul>
			</div>
				
						
				
			<?php }
		}
			
	} else {
		echo "Vous n'avez pas sélectionné tous les combattants, veuillez réessayer";	
	}
	
?>

</div>

<?php include('parts/footer.php'); ?>
