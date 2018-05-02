<?php
namespace App\Controllers;

use \PDO; // importiamo le classi 'PDO' e 'Post'




class HomeController extends Controller
{
   
    protected $conn;
 

    public function __construct(PDO $conn){ 
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->page = 'home'; 
    }


    
//====================================================================================================== 
//========== FRONT PAGE ========================= FRONT PAGE ===========================================
//======================================================================================================     

/*******************|
*       HOME        |
********************/
public function home(){
    $this->grid = 'container-fluid';
    $this->content = View('signup', compact('message')); // ritorniamo il template con il form per fare la registrazione
    $files=['navbar-home', 'cover', 'portfolio', 'skills', 'form', 'footer'];
    $this->content = View('home', $files);
}


} // chiude classe HomeController

