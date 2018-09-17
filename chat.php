<?php include('parts/header.php'); ?>
   
    <?php if (isset($_GET['id']) OR isset($_POST['id'])) {
        
		if (isset($_GET['id'])) {
			 $id = htmlspecialchars($_GET['id']);	
		} else {
			 $id = htmlspecialchars($_POST['id']);	
		}	
			
		//GESTION DE LA MODIFICATION DU CHAT
		$req_str = "UPDATE kitten SET ";
			
		if (isset($_POST['cuteness']) && !empty($_POST['cuteness'])) {
			$cuteness = htmlspecialchars($_POST['cuteness']);
			
			//On vérifie que c'est un entier entre 0 et 100
			if (ctype_digit($cuteness)) {
				$cuteness = (int)$cuteness;	
				if ($cuteness <= 100 && $cuteness >= 0) {
					$req_str .= "cuteness = " .$cuteness ;
				}
			}
		}
			
		if (isset($_POST['power']) && !empty($_POST['power'])) {
			$power = htmlspecialchars($_POST['power']);
			
			//On vérifie que c'est un entier entre 0 et 100
			if (ctype_digit($power)) {
				$power = (int)$power;	
				if ($power <= 100 && $power >= 0) {
					$req_str .= ", power = " .$power ;
				}
			} 
		}
			
		if (isset($_FILES['avatar']) AND $_FILES['avatar']['error'] == 0) {
			if ($_FILES['avatar']['size'] <= 1000000) {
				$infosfichier = pathinfo($_FILES['avatar']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg','JPG','jpeg','JPEG','gif','GIF','PNG','png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
					$req_str .= ", avatar = '" . $id . '.' . $infosfichier['extension'] ."'";
					move_uploaded_file($_FILES['avatar']['tmp_name'], 'images/kitten/' . $id . '.' . $infosfichier['extension']);	
                }
			}
		} 
			
		$req_str .= " WHERE id = " . $id;
			
		try {
			$req = $bdd -> query($req_str);	
			} catch (PDOException $e) {
			echo "Échec : " . $e->getMessage();
		}


        $req = $bdd -> prepare('SELECT * FROM kitten WHERE id = :id');
        $req -> execute(array('id' => $id));
        $kitten = $req -> fetch();
        $req -> closeCursor();
				
		// SI AUCUN CHAT NE CORRESPOND A L'ID ALORS ON AFFICHE LE MESSAGE
    
		if ($kitten == false) {
			echo "Ce chaton a quitté l'arène :'(";
		} else {
    ?>
    
    <div class="container" id="cat-profile">
       
        <div class="row">
        	<div class="col">
        		<h1>Profil du chaton <?php echo $kitten['name'] ?></h1> 
        	</div>
        	<div class="col text-right">
        		<ul class="none-list font-italic">
        			<li><a id="editCat-btn" href="javascript:void(0);">Modifier le chaton</a></li>
        			<li><a id="deleteCat-btn" href="javascript:void(0);" data-toggle="modal" data-target="#confirmModal">Supprimer le chaton</a></li>
        		</ul>
        	</div>
        </div>
        
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title">Confirmer la suppression</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<p>Etes-vous certain de vouloir supprimer ce chaton?</p>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
				<button type="button" class="btn btn-primary" id="validateDel" data-kitten="<?php echo $kitten['id']; ?>">Confirmer</button>
			  </div>
			</div>
		  </div>
		</div>
        
		<img src="images/kitten/<?php echo $kitten['avatar']; ?>" class="rounded mx-auto d-block" alt="avatar" height="400">      
       	
       	<form id="editCat-form" action="chat.php" method="post" enctype="multipart/form-data">
       		<input type="hidden" name="id" value="<?php echo $kitten['id']; ?>" >
       		
			<div class="detailed_stats">
				<div class="text-center">
					<input type="file" name="avatar">
				</div>
				
				<h2>Caractéristiques</h2>
				<ul>
					<li class="py-2">Points de mignonnitude : 
						<span class="attr_cats"><?php echo $kitten['cuteness']; ?> </span>
						<input type="number" name="cuteness" value="<?php echo $kitten['cuteness']; ?>">
					</li>
					<li class="py-2">Points de puissance de miaulement : 
						<span class="attr_cats"><?php echo $kitten['power']; ?> </span>
						<input type="number" name="power" value="<?php echo $kitten['power']; ?>">
					</li>
				</ul>    
				<div class="text-center">
					<input type="button" class="btn btn-secondary" value="Annuler" id="cancel_modif">
					<input type="submit" class="btn btn-primary" value="Enregistrer les modifications">	
				</div>
			</div>
  
		</form>
        
        <div>
            <h2>Historique des combats</h2>
            
            <?php 
				$req = $bdd -> prepare("SELECT count(*) AS total FROM fights WHERE winner_id = :id");
				$req -> bindValue('id', $kitten['id']);
				$req -> execute();
				$victories = $req -> fetch(); 
				$req -> closeCursor();
			
				$req2 = $bdd -> prepare("SELECT count(*) AS total FROM fights WHERE loser_id = :id");
				$req2 -> bindValue('id', $kitten['id']);
				$req2 -> execute();
				$defeats = $req2 -> fetch(); 
				$req2 -> closeCursor();				
			?>
            
            <ul>
                <li class="py-2">Nombre de combats : <?php echo $victories['total'] + $defeats['total']  ?></li>
                <li class="py-2">Victoires : <?php echo $victories['total']  ?></li>
                <li class="py-2">Défaites : <?php echo  $defeats['total']  ?></li>
            </ul>   
        </div>  
        
		<form action="select_fight.php" method="post" class="text-center py-5">
			<input type="hidden" name="fromKitten" value="<?php echo $kitten['name']; ?>" />
			<input type="submit" class="btn btn-lg btn-danger" value="Lancer le combat">
		</form>
   
   <?php } 
	} ?>
   
    </div>
    

<?php include('parts/footer.php'); ?>