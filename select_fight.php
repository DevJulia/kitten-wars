<?php include('parts/header.php'); ?>

<div class="container">
    <h1 class="text-center py-4">C'est l'heure du dudududu-duel</h1>
    
    <form action="start_fight.php" method="post" >
    
		<div class="row">
			<div class="col-6">
				<h2 class="text-center py-2">Chaton 1</h2>
				<div class="d-flex justify-content-around">
					<label>Saisissez le nom du combattant</label>
					<?php if (isset($_POST['fromKitten']) && !empty($_POST['fromKitten'])) {
						$kitten = htmlspecialchars($_POST['fromKitten']);
					?> 	
						<input type="text" class="autocomplete" name="chaton1" value="<?php echo $kitten; ?>"/>
					<?php } else { ?>
						<input type="text" class="autocomplete" name="chaton1"/>
					<?php }	?>

				</div>
			</div>

			<div class="col-6">
				<h2 class="text-center py-2">Chaton 2</h2>
				<div class="d-flex justify-content-around">
					<label>Saisissez le nom du combattant</label>
					<input type="text" class="autocomplete" name="chaton2"/>
				</div>
			</div>
		</div>
	
		<div class="text-center py-5">
			<input type="submit" class="btn btn-lg btn-danger" value="Lancer le combat">
		</div>
		
	</form>
</div>

<?php include('parts/footer.php'); ?>
