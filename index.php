<?php include('parts/header.php'); ?>
   
    <!-- PRESENTATION DU JEU -->
    <section class="container">
        <div class="row">
            <h1 class="mx-auto py-3">Le jeu absolument cha(t)leur</h1>
            <div class="col-8">
               <h2>Des chatons pas beaux</h2>
                Sous leurs airs de boules de poils parfaitement sphériques se cachent de vrais petits monstres... Nos chatons ne sont pas des anges et nous les avons réunis dans cette arène pour qu'ils nous laissent en paix. Le principe est simple, le chatoooon le plus chanceux se verra décerner le titre de <strong>PACHAT</strong>. A vous d'enregistrer vos chatons et de les balancer dans l'arène.
            </div>
            <div class="col-4">
                <h2>Règles du duel</h2>
                <ol>
                    <li>Comparaison points de puissance</li>
                    <li>Comparaison points de mignonnitude</li>
                    <li>Tu as de la chatte ou pas</li>
                    <li><strong>HUMILIATION</strong></li>
                </ol>
            </div>
        </div>
    </section>
    
    
    
    <!-- LISTE DES MEILLEURS CHATS -->
    <section class="container list-pachat">
        <h2 class="text-center">Pachat du moment</h2>
        
        <div class="d-flex justify-content-center">
        
        <!-- On récupère les meilleurs chats en score -->
            <?php $req = $bdd -> query('SELECT * FROM kitten WHERE balance = ( SELECT MAX(balance) FROM kitten ) LIMIT 3');
            while ($kitten = $req -> fetch()) { ?>
            
            <div class="pachat px-5">
                
                <!-- Avatar du chat + son nom cliquables -->
                <a href="chat.php?id=<?php echo $kitten['id']; ?>">
                    <img class="crown_img" src="images/crown.png" />
                    <div class="avatar" style="background-image: url(images/kitten/<?php echo $kitten['avatar']; ?>)" ></div>
                    <h3 class="text-center"> <?php echo $kitten['name']; ?> </h3> 
                </a>
                    <?php if (isset($kitten['quote'])) { ?>
                        
                <p class="text-center">"<?php echo $kitten['quote']; ?>"</p>    
                    <?php } else { ?>
                <p class="text-center"> &nbsp; </p>
                    <?php } ?> 
                    
				<form action="select_fight.php" method="post" class="text-center py-2">
					<input type="hidden" name="fromKitten" value="<?php echo $kitten['name']; ?>" />
					<input type="submit" class="btn btn-lg btn-block btn-primary" value="Affronter le pachat">
				</form>

            </div>     
            
            <?php }
            $req -> closeCursor(); ?>
        
        </div>
    </section>
    
<!-- BOOTSTRAP MODAL si sélection > 2 chats -->    
	<button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#infoSelectCat">
	</button>
	<div class="modal fade" id="infoSelectCat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title">Attention</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<p>Pour lancer un combat, vous ne pouvez sélectionner que 2 chatons au maximum.</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Ok j'ai compris</button>
		  </div>
		</div>
	  </div>
	</div>

    <!-- LISTE DES COMBATTANTS -->
    <section class="container">
        <h2 class="text-center">Nos combattants</h2>
        
        <!-- RECHERCHE SIMPLE PAR PSEUDO -->        
        <form class="form_search">
            <input class="form-control mr-sm-2" type="search" name="catName" placeholder="Tapez un nom de chat">
            <button class="btn btn-secondary my-2 my-sm-0" id="searchBtn">Rechercher</button>
        </form>
       
        <!-- AFFICHAGE DE LA LISTE DES CHATS VIA AJAX -->    
        <form  action="start_fight.php" method="post" class="row" id="list-cat">
        </form>

        

        
    </section>

<?php include('parts/footer.php') ?>
