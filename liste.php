<?php try {
    $bdd = new PDO('mysql:host=localhost;dbname=kitten_wars;charset=utf8', 'root', '');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
} 

$term = $_GET['term'];

$requete = $bdd->prepare('SELECT * FROM kitten WHERE name LIKE :term'); 

$requete->execute(array('term' => $term.'%'));

$array = array(); 

while($donnee = $requete->fetch()) 
{
    array_push($array, $donnee['name']); //
}

echo json_encode($array);


?>