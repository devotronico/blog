<?php

/*
* PDO
* il dsn non lo ritorniamo  
* il dsn lo costruiamo noi con la classe DbFactory in base al 'driver'
* esempio di dsn con database di tipo mysql 
* 'dsn' => 'mysql:host=localhost;dbname=blog;charset=utf8',
*
*
* PDO::ATTR_DEFAULT_FETCH_MODE | è il modo in cui gestire gli dati di tipo oggetto
* PDO::ATTR_ERRMODE | è il modo in cui gestire gli errori
*/


$host = $_SERVER['SERVER_NAME']; 

if ( $host === 'localhost' )   {   

    return[
        'driver' => 'mysql',  // In base al driver nella classe factory costruiremo il tipo di connessione(mysql,sqlite,mssql,oracle)
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'blog',  
        //'dsn' =>'mysql:host=localhost;dbname=freeblog;charset=utf8',
        'options' => [
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        ]
    ];
}
else
{
    return[
        'driver' => 'mysql',  // In base al driver nella classe factory costruiremo il tipo di connessione(mysql,sqlite,mssql,oracle)
        'host' => '',
        'user' => '', 
        'password' => '',
        'database' => '',  
          //'dsn' =>'mysql:host=localhost;dbname=freeblog;charset=utf8',
          'options' => [
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        ]
    ];
}



