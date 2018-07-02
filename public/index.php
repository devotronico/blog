<?php
if (!isset($_SESSION)) { session_start(); } 
session_regenerate_id(true);

//print( 1 <=> 1);print("<br/>");
//phpinfo();

//die($_SERVER['DOCUMENT_ROOT']); // = C:\xampp\htdocs\blog\public | /web/htdocs/www.danielemanzi.it/home/

//echo '<pre>', print_r($_SESSION) ,'</pre>'; 
//echo '<pre>', print_r($_COOKIE) ,'</pre>'; 
/*
if (session_status() == PHP_SESSION_DISABLED) {  echo '<br> PHP_SESSION_DISABLED <br>';} // si disabilita nel file php.ini session.auto_start = "0"
if (session_status() == PHP_SESSION_NONE )    {  echo '<br> PHP_SESSION_NONE  <br>'   ;} // session_start() NON inizializzato
if (session_status() == PHP_SESSION_ACTIVE)   {  echo '<br> PHP_SESSION_ACTIVE <br>'  ;} // session_start() inizializzato
echo session_id();
*/


//var_dump($_SERVER['DOCUMENT_ROOT']); // C:\xampp\htdocs\blog\public


// die (__DIR__); //= C:\xampp\htdocs\blog\public
// __DIR__ restituisce l'intero path/percorso in cui viene richiamata la costante-magica __DIR__ 
// __DIR__   è uguale a dirname(__FILE__)   è uguale a alla funzione getcwd()


//die (dirname(__DIR__)); //= C:\xampp\htdocs\blog
// dirname selezione la cartella genitore di una path/percorso es. dirname("/folder1/folder2/folder3") restituisce "/folder1/folder2/"


// Considerato che come punto di ingresso abbiamo la sottoCartella 'blog\public'
// Con la funzione chdir(dirname(__DIR__)) ci posiziona nella cartella superiore 'blog' {dirname(__DIR__) = C:\xampp\htdocs\blog}
// In questo modo se vogliamo accedere al file index.tpl.php scriviamo 'layout/index.tpl.php' invece di '../layout/index.tpl.php';
chdir(dirname(__DIR__)); // setta questa cartella(public) come quella predefinita per fare il require dei file



//die (__DIR__.'/../core/bootstrap.php'); // C:\xampp\htdocs\blog\public/../core/bootstrap.php
require 'core/bootstrap.php'; // qui i vengono caricati tutte le classi e anche le funzioni
//require __DIR__.'/../core/bootstrap.php'; // qui i vengono caricati tutte le classi e anche le funzioni


// prende i valori del database richiesti per fare la connessione
$databaseConfig = require 'config/database.php';
//$data = require __DIR__.'/../config/database.php';



// $appConfig è un array
$appConfig = require 'config/app.config.php';


try{

    $pdoConn = App\DB\DbFactory::Create($databaseConfig); // $data è l'array che contiene il driver grazie al quale costruiremo il dsn


    $conn = $pdoConn->getConn(); // otteniamo la connessione al database

    

    //ROTTE


    $router  = new Router($conn);

    //$router->loadRoutes($appConfig['routes']);
    $router->loadRoutes($appConfig);

    // dispatch chiama un metodo della classe PostController  //la classe PostController viene istanziata nella classe Router
   
    $controller = $router->dispatch(); 
  
    $controller->display();


} catch (\PDOException $e) {
    echo $e->getMessage();
} catch (\Exception $e){
    echo $e->getMessage();
}
 
