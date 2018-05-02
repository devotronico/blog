<?php
session_start();
if ( isset($_SESSION['id']) ) { echo 'session id è uguale a '.$_SESSION['id']; } else { echo 'sessione assente'; } echo '<br>';

 //$email = 'dmanzi83@hotmail.it';
 //$hash = '0123456789';

// $link0 = "http://localhost:3000/auth/verify/?email=$email&hash=$hash";


// $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].""; // 

// $link = $actual_link."auth/verify/?email=".$email."&hash=".$hash;


//$site = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']; // 
//$link = $site."auth/verify/?email=".$email."&hash=".$hash;
//die($link);


// [1] Examples for:  https://(www.)example.com/subFolder/yourfile.php?var=blabla#555
// [2] Examples for: http://localhost:3000/
//die($_SERVER['SERVER_NAME']);    //🡺 [1] ||| [2] localhost
//die($_SERVER["DOCUMENT_ROOT"]);  //🡺 [1] /home/user/public_html ||| [2]  C:\xampp\htdocs\blog\public
//die($_SERVER["SERVER_ADDR"]);    //🡺 [1] 143.34.112.23 |||  [2] Undefined index: SERVER_ADDR in C:\xampp\htdocs\blog\public\index.php
//die($_SERVER["SERVER_PORT"]);    //🡺 [1] 80(or 443 etc..) |||   [2] 3000
//die($_SERVER["REQUEST_SCHEME"]); //🡺 [1] https |||   [2] Undefined index: REQUEST_SCHEME in C:\xampp\htdocs\blog\public\index.php                



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
$data = require 'config/database.php';
//$data = require __DIR__.'/../config/database.php';

// $appConfig è un array
$appConfig = require 'config/app.config.php';
//$appConfig = require __DIR__.'/../config/app.config.php';

try{

    $pdoConn = App\DB\DbFactory::Create($data); // $data è l'array che contiene il driver grazie al quale costruiremo il dsn


    $conn = $pdoConn->getConn(); // otteniamo la connessione al database


    //ROTTE


    $router  = new Router($conn);

    $router->loadRoutes($appConfig['routes']);


    // dispatch chiama un metodo della classe PostController 
    //la classe PostController viene istanziata nella classe Router
    $controller = $router->dispatch(); 
  
    $controller->display();


} catch (\PDOException $e) {
    echo $e->getMessage();
} catch (\Exception $e){
       echo $e->getMessage();
}
 
/*



*/