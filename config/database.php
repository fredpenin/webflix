<?php

try {
	$db = new PDO('mysql:host=localhost;dbname=webflix;charset=utf8', 'root', '', [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // Active les erreurs SQL,
		// On récupère tous les résultats en tableau associatif
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	]);
} catch(Exception $e) {
	echo $e->getMessage();
	// // Redirection en PHP vers Google avec le message d'erreur concerné
    // header('Location: https://www.google.fr/search?q='.$e->getMessage());
    echo 'Ca va mal là, ça va mal!!!!!';
    die('stop'); // Arrête le script si la base de données n'est pas dispo
}


?>