<?php
namespace App\Controllers;

use \PDO; // importiamo le classi 'PDO' e 'Post'


class HomeController extends Controller
{
   
    protected $conn;
 

    public function __construct(PDO $conn){ 
         // ereditiamo il costruttore della classe madre (Controller) per ottenere il valore di $this->device che può essere 'desktop' oppure 'mobile'
        parent::__construct(); 
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->page = 'home'; 
        $this->grid = 'container-fluid';
    }


    
//====================================================================================================== 
//========== FRONT PAGE ========================= FRONT PAGE ===========================================
//======================================================================================================     

/*******************|
*       HOME        |
********************/
public function home(){
  
   // $files=['navbar-home', 'cover', 'portfolio', 'skills', 'contact', 'footer'];
    $files=[
        $this->device.'.navbar-home',
        $this->device.'.cover',
        'portfolio',
        'skills', 
        'contact',
        $this->device.'.footer'
        ];
    $this->content = View('home', $files);
}

} // chiude classe HomeController

