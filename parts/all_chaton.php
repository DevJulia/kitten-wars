<?php try {
    $bdd = new PDO('mysql:host=localhost;dbname=kitten_wars;charset=utf8', 'root', '');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
} 
?>

 <?php 
    
	if (isset($_POST['page'])) {
		$offset = (int) $_POST['page'];
		$offset = 8 * ($offset - 1);	
	}

    //CONSTRUCTION DE LA RECHERCHE
    $req_str = "SELECT * FROM kitten WHERE 1";
    

    if (isset($_POST['catName']) && !empty($_POST['catName'])) {
        $name = htmlspecialchars($_POST['catName']);
        $req_str = $req_str . " AND name LIKE '%" . $name . "%'";    
    } 

    if (isset($_POST['creationDate']) && !empty($_POST['creationDate'])) {
        $date = htmlspecialchars($_POST['creationDate']);
        list ($jour, $mois, $annee) = sscanf($date, "%d/%d/%d");
        $date = $annee . '-' . $mois . '-' . $jour;
        $req_str = $req_str . " AND created_at BETWEEN '" . $date . "' AND '". $date ." 23:59:59'";
    }

	if (isset($_POST['power_from']) && !empty($_POST['power_from'])
	    && isset($_POST['power_to']) && !empty($_POST['power_to'])) {
        $power_from = htmlspecialchars($_POST['power_from']);
		$power_to = htmlspecialchars($_POST['power_to']);
		$req_str = $req_str . " AND power BETWEEN " .$power_from. " AND " .$power_to;
    }

	if (isset($_POST['cuteness_from']) && !empty($_POST['cuteness_from'])
	    && isset($_POST['cuteness_to']) && !empty($_POST['cuteness_to'])) {
        $cuteness_from = htmlspecialchars($_POST['cuteness_from']);
		$cuteness_to = htmlspecialchars($_POST['cuteness_to']);
		$req_str = $req_str . " AND cuteness BETWEEN " .$cuteness_from. " AND " .$cuteness_to;
    }
 

	// CALCUL DU NOMBRE DE PAGES TOTAL EN FONCTION DE LA RECHERCHE
	$req = $bdd -> query($req_str);
	$kitten = $req -> fetchAll(); 
    $req -> closeCursor();
	$total = count($kitten);


	// AFFICHAGE EN FONCTION DES PARAMETRES SELECTIONNES
	// tri
	if (isset($_POST['sortResults']) && !empty($_POST['sortResults'])) {
		$sortOption = htmlspecialchars($_POST['sortResults']);
		if ($sortOption == "alphabetical") {
			$req_str = $req_str . " ORDER BY name ";	
		} else if ($sortOption == "new") {
			$req_str = $req_str . " ORDER BY created_at DESC ";
		} else if ($sortOption == "strongest") {
			$req_str .= " ORDER BY balance DESC ";
		}
	} else {
		$req_str = $req_str . " ORDER BY name ";	
	}

	//nombre de résultats affichés
	if (isset($_POST['nbPerPage']) && !empty($_POST['nbPerPage'])) {
		$nbPerPage = htmlspecialchars($_POST['nbPerPage']);
		if ($nbPerPage == "8") {
			$req_str .= "LIMIT " .$offset . ", 8";	
			$total_pages = ceil($total / 8);
		} else if ($nbPerPage == "16") {
			$req_str .= "LIMIT " .$offset . ", 16";
			$total_pages = ceil($total / 16);
		} else if ($nbPerPage == "32") {
			$req_str .= "LIMIT " .$offset . ", 32";
			$total_pages = ceil($total / 32);
		} else if ($nbPerPage == "all") {
			$total_pages = 1;	
		}
	} else {
		$req_str .= "LIMIT " .$offset . ", 8";	
		$total_pages = ceil($total / 8);
	}

	
    $req = $bdd -> query($req_str);
    $kitten = $req -> fetchAll(); 
    $req -> closeCursor();


    if (count($kitten) == 0) { ?>
        <div>
        Aucun résultat 
        </div>
    <?php } else {
        foreach($kitten as $row) { ?>
            <div class="col-3 cat-info">

                <!-- avatar + nom du chat cliquables -->   
                <a class="kitten_info" href="chat.php?id=<?php echo $row['id']; ?>">

                    <input type="checkbox" class="select-kitten" value="<?php echo $row['name']; ?>" >
                    <input type="hidden" name="chaton1" value="">
                    <input type="hidden" name="chaton2" value="">

                    <div class="avatar" style="background-image: url(images/kitten/<?php echo $row['avatar']; ?>)"> </div>
                    <!-- attributs du chat seulement affichés lors d'un hover -->
                    <div class="attributes">
                        <div>
                            <ul>
                                <li>Mignonnitude : <?php echo $row['cuteness'] ?></li>
                                <li>Puissance : <?php echo $row['power'] ?></li>
                                <li>Balance : <?php echo $row['balance'] ?></li>
                            </ul>
                        </div>
                    </div>
                    <h3 class="text-center"> <?php echo $row['name']; ?> </h3>
                </a>

                    <?php if (isset($row['quote'])) { ?>
                <p class="text-center">"<?php echo $row['quote']; ?>"</p>    
                    <?php } else { ?>
                <p class="text-center"> &nbsp; </p>
                    <?php } ?>
                    
            </div> 
        <?php }
    } ?>
       
       
	   <div class="text-center col-12">
            <input type="submit" class="btn btn-lg btn-danger" id="startFight" value="Lancer le combat">
       </div>
       
        <!-- PAGINATION -->
	<?php if ($total_pages > 1) { ?>
    <nav class="col-12">

        <ul class="pagination justify-content-end" data-count="<?php echo $total_pages ?>">
            <li class="page-item">
                <a class="page-link" href="javascript:void(0);" data-page="previous">Précédent</a>
            </li>

        <?php 

        //Création de la pagination 
        for ($nb_pages = 1; $nb_pages <= $total_pages; $nb_pages++) { ?>
 
            <li class="page-item">
                <a class="page-link" href="javascript:void(0);" data-page="<?php echo $nb_pages; ?>"> <?php echo $nb_pages; ?> </a>
            </li>

        <?php } ?>  

            <li class="page-item">
                <a class="page-link" href="javascript:void(0);" data-page="next" >Suivant</a>
            </li>
        </ul>
    </nav>
	<?php } ?>

