<!DOCTYPE HTML>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/jquery-ui-dist/jquery-ui.min.css" >
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/jquery-ui-dist/jquery-ui.min.js"></script>
    <script src="node_modules/jquery-ui-dist/datepicker-fr.js"></script>
    <script src="node_modules/jquery-validation/dist/jquery.validate.js"></script>
    

    <title>Kitten Wars - Jeu en ligne kawaii</title>
</head>


<body>

       
       <header>
        <div class="container">

            <div class="banner"></div>

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="main-nav">
                <a class="navbar-brand" href="index.php">Kitten Wars</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a href="select_fight.php" class="nav-link">Lancer un combat</a>
                        </li>
					    <li class="nav-item">
                            <a href="view_fights.php" class="nav-link">Historique des combats</a>
                        </li>
                        <li class="nav-item">
                            <a href="recherche.php" class="nav-link">Recherchat</a>
                        </li>
                        <li class="nav-item">
                            <a href="creer_chaton.php" class="nav-link">Créer un chaton</a>
                        </li>
                    </ul>
                </div>
            </nav>

        </div>
    </header>
    
           
<?php try {
    $bdd = new PDO('mysql:host=localhost;dbname=kitten_wars;charset=utf8', 'root', '');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
} ?>