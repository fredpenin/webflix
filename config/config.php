<?php

// Ce fichier contiendra nos variables "globales" pour notre site.
// Titre du site, titre de la page, page courate, ...

$siteName = 'WebFlix';

//page courante et titre de la balise title
//$CurrentPageTitle = (empty($currentPageTitle)) ? null : $CurrentPageTitle;
// Si SCRIPT_FILENAME (cf. var_dump($_SERVER) ) vaut /home/toto/fichier.php, $page renverra 'fichier'
$CurrentPageUrl = basename($_SERVER['SCRIPT_FILENAME'], '.php');