<?php include('parts/header.php'); ?>

	<div class="container">
        
        <h1 class="pb-2">Créer votre chaton</h1>
        
		<div class = "py-3">
			<input type="radio" name="createMode" value="custom" checked>
			<label class="mr-4">Création personnalisée</label>

			<input type="radio" name="createMode" value="random">
			<label>Création aléatoire</label>
		</div>
        
	<?php if ( empty($_POST) ) { ?>   
  		
   		<!-- FORMULAIRE DE CREATION PERSONNALISE -->
    	<form action="creer_chaton.php" method="post" enctype="multipart/form-data" id="formCustom">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" name="name" placeholder="Nom du chaton" required>
            </div>
            <div class="form-group">
                <label for="cuteness">Mignonnitude</label>
                <input type="text" class="form-control" name="cuteness" placeholder="Points de mignonnitude" required>
                <small class="form-text text-muted">Entrez un nombre entier entre 0 et 100</small>
            </div>
            <div class="form-group">
                <label for="power">Puissance</label>
                <input type="text" class="form-control" name="power" placeholder="Points de puissance" required>
                <small class="form-text text-muted">Entrez un nombre entier entre 0 et 100</small>
            </div>
			<div class="form-group">
                <label for="name">Citation</label>
                <input type="text" class="form-control optional" name="quote" placeholder="Sa citation favorite" >
            </div>
            <div class="form-group">
                <label>Photo de la bête</label>
                <input type="file" name="avatar" class="form-control-file optional">
            </div>
            <button type="submit" class="btn btn-primary" id="custSubmitBtn">Envoyer le formulaire</button>
		</form>
   		
		<!-- FORMULAIRE DE CREATION ALEATOIRE -->
		<form action="creer_chaton.php" method="post" enctype="multipart/form-data" id="formRandom">
			<div class="form-group">
				<label for="name">Nom</label>
				<input type="text" class="form-control" name="name" placeholder="Nom du chaton" required>
				<input id="text" name="cuteness" type="hidden" value="random">
				<input id="text" name="power" type="hidden" value="random">
			</div>
			<button type="submit" class="btn btn-primary">Envoyer le formulaire</button>
		</form>
   
    		
    <?php }
		
		if ( isset($_POST) && !empty($_POST)) {
			
		$req_str = "INSERT INTO kitten VALUES (NULL,";
	
		if (isset($_POST['name']) && !empty($_POST['name'])) {
			$name = htmlspecialchars($_POST['name']);

			//On vérifie que le nom rentré ne comporte que des chiffres et des lettres
			if (preg_match('/^[éàèça-zA-Z0-9 ]+$/', $name))
			{
				//Vérification si le chat existe déjà
				$req = $bdd -> prepare('SELECT count(*) AS total FROM kitten WHERE name = :name');
				$req -> bindValue('name', $name, PDO::PARAM_STR);
				$req -> execute();
				$result = $req -> fetch();
				$req -> closeCursor();
				
				if ($result['total'] != 0) { 
					
					echo "il existe déjà un chaton à ce nom";
					
				} else {
					$req_str .= "'" .$name. "',";	
				}
			}
		} 
			
		if (isset($_POST['cuteness']) && !empty($_POST['cuteness'])) {
			$cuteness = htmlspecialchars($_POST['cuteness']);
			
			//On vérifie que c'est un entier entre 0 et 100
			if (ctype_digit($cuteness)) {
				$cuteness = (int)$cuteness;	
				if ($cuteness <= 100 && $cuteness >= 0) {
					$req_str .= "'" .$cuteness. "',";
				}
			}
			
			//Traitement si choix création aléatoire
			if ($cuteness == "random") {
				$cuteness = rand(0,100);
				$req_str .= "'" .$cuteness. "',";
			}
		}
			
		if (isset($_POST['power']) && !empty($_POST['power'])) {
			$power = htmlspecialchars($_POST['power']);
			
			//On vérifie que c'est un entier entre 0 et 100
			if (ctype_digit($power)) {
				$power = (int)$power;	
				if ($power <= 100 && $power >= 0) {
					$req_str .= "'" .$power. "',";
				}
			} 
			
			//Traitement si choix création aléatoire
			if ($power == "random") {
				$power = rand(0,100);
				$req_str .= "'" .$power. "',";
			}
		}
			
		$req_str .= "'0', NOW(),";
		
		if (isset($_FILES['avatar']) AND $_FILES['avatar']['error'] == 0) {
			if ($_FILES['avatar']['size'] <= 1000000) {
				$infosfichier = pathinfo($_FILES['avatar']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg','JPG','jpeg','JPEG','gif','GIF','PNG','png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
					$req_str .= "'" . $name . '.' . $infosfichier['extension'] . "',";
                }
			}
		} else {
			$req_str .= "'default.jpg',";	
		}
						
		if (isset($_POST['quote']) && !empty($_POST['quote'])) {
			$quote = htmlspecialchars($_POST['quote']);
			$quote = str_replace("'", "\'", $quote);
			$req_str .= "'" .$quote. "')";
		} else {
			$req_str .= "NULL)";
		}
			
		try {
			$req = $bdd -> query($req_str);	
			if (stristr($req_str, 'default.jpg') == FALSE) {
				move_uploaded_file($_FILES['avatar']['tmp_name'], 'images/kitten/' . $name . '.' . $infosfichier['extension']);	
			} ?>
			<!--- Bloc affiché quand chat créé -->
			<div>
				<h3>Le chaton a été créé avec succès!</h3>	
				<a href="creer_chaton.php">
					<button class="btn btn-primary">En créer un autre</button>
				</a>
			</div>
			
		<?php } catch (PDOException $e) {
			echo "Échec : " . $e->getMessage();
		}		
	}

	?>
     
   </div>

<?php include('parts/footer.php'); ?>