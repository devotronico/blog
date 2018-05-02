<?php
//error_reporting(E_ALL); // E_ALL mostra tutti gli errori | in produzione passare 0 al parametro e utilizzare le eccezioni
//ini_set('display_errors', 1);

require_once 'db/DBPDO.php';       // carica il file dove sta la classe DBPDO

require_once 'db/DbFactory.php';       // carica il file dove sta la classe DBFactory

require_once 'app/Controllers/Controller.php'; 

require_once 'app/Controllers/HomeController.php'; //

require_once 'app/Controllers/PostController.php'; // 

require_once 'app/Controllers/AuthController.php'; // 

require_once 'app/models/Validate.php'; // In Validitation vengono fatte le validitazioni ai parametri passati ne forms per le autenticazioni

require_once 'app/models/Auth.php'; // In Auth vengono eseguite le autenticazioni



require_once 'app/models/Email.php';  // Email si occupa di tutto ciò che riguarda l'invio di email per fare le autenticazioni

require_once 'app/models/Post.php'; // In Post si fanno le query al database

require_once 'app/models/Comment.php'; // In Post si fanno le query al database

require_once 'helpers/functions.php'; // ci sono tutte le funzioni

require_once 'core/Router.php'; // cè l array di tutte le rotte


/*
require_once __DIR__.'/../db/DBPDO.php';       // carica il file dove sta la classe DBPDO

require_once __DIR__.'/../db/DbFactory.php';       // carica il file dove sta la classe DBFactory

require_once __DIR__.'/../app/Controllers/PostController.php'; // è uguale a  'C:\xampp\htdocs\blog\public\..\app\Controllers\classe.php''

require_once __DIR__.'/../app/models/Auth.php'; // In Auth vengono eseguite le autenticazioni

require_once __DIR__.'/../app/models/Validate.php'; // In Validitation vengono fatte le validitazioni ai parametri passati ne forms per le autenticazioni

require_once __DIR__.'/../app/models/Post.php'; // In Post si fanno le query al database

require_once __DIR__.'/../app/models/Comment.php'; // In Post si fanno le query al database

require_once __DIR__.'/../helpers/functions.php'; // ci sono tutte le funzioni

require_once __DIR__.'/../core/Router.php'; // cè l array di tutte le rotte
*/