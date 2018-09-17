<?php include('parts/header.php'); ?>

<section class="container">
    <h1>Recherchat miaouw!</h1>
    <form action="recherche.php" method="post">

        <div class="form-row">
            <div class="form-group col-md-3 mr-5">
                <label>Nom</label>
                <input type="text" class="form-control" name="catName">
            </div>
            <div class="form-group col-md-3">
                <label>Date de création</label>
                <input type="text" class="form-control" id="datepicker" name="creationDate">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4 mr-3">
	             <p>
					<label for="cuteness">Mignonnitude</label>
					<input type="hidden" name="cuteness_from" id="cuteness_from" value="0" />
					<input type="hidden" name="cuteness_to" id="cuteness_to" value="100" />
					<input type="text" id="cuteness" readonly style="border:0; color:#f6931f; font-weight:bold;">
				</p>
				<div id="sliderCuteness"></div>   
            </div>
            
            <div class="form-group col-md-4 ml-4">         
                <p>
					<label for="power">Puissance</label>
					<input type="hidden" name="power_from" id="power_from" value="0" />
					<input type="hidden" name="power_to" id="power_to" value="100" />
					<input type="text" id="power" readonly style="border:0; color:#f6931f; font-weight:bold;">
				</p>
				<div id="sliderPower"></div>
            </div>
            
        </div>

        <input type="submit" value="Rechercher" id="searchBtn" />
        <button id ="reset">Réinitialiser</button>
    </form>
</section>


<section class="container">

    <div class="row">
        <div class="col-6">Nombre de chatons par page :
            <div class="ml-3 form-check form-check-inline">
                <input class="form-check-input" type="radio" name="nbPerPage" value="8" checked>
                <label class="form-check-label">8</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="nbPerPage" value="16">
                <label class="form-check-label">16</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="nbPerPage" value="32">
                <label class="form-check-label">32</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="nbPerPage" value="all">
                <label class="form-check-label">Tous</label>
            </div>
        </div>
        <div class="col-6">Tri des résultats : 
            <select name="sortResults">
                <option value="alphabetical">Ordre alphabétique</option>
                <option value="new">Nouveau</option>
                <option value="strongest">Les plus forts</option>
            </select>
        
        </div>
    </div>
    
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

	<form  action="start_fight.php" method="post" class="row" id="list-cat">
	</form>



</section>

<?php include('parts/footer.php'); ?>
