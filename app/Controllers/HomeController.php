<?php
namespace App\Controllers;

use \PDO; // importiamo le classi 'PDO' e 'Post'
use App\Models\Email;

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

/***********************************************|
* HOME  metodo = GET    route = home            |        
*************************************************/
public function home(){
  
    $photo =  $this->device.'.photo';
    $files=[
       
        $this->device.'.navbar-home',
        $this->device.'.cover',
        $this->device.'.portfolio',
        $this->device.'.skills', 
        $this->device.'.contact',
        $this->device.'.footer'
        ];
    $this->content = View('home', $files, compact('photo'));
}


/***********************************************************|
* DOWNLOAD      metodo = GET    route = home/id/download    |
************************************************************/
public function download(){
  
    $dir = 'public/download/';
  
    $filename = 'testFile.zip';
   // $fn = (isset($_GET['filename']) ? $_GET['filename'] : false);
    
    // controlliamo che ci siano caratteri validi nel nome del file
    if (!preg_match('/^[a-z0-9]+\.[a-z]{2,3}$/i',$filename)) {
        $filename = false;
      }else{
       $file = $dir . $filename;  
      }
    
    // verifico che il file esista
    if (!file_exists($file))
    {
      // se non esiste stampo un errore
      echo "Il file NON esiste!";
    }else{
        echo "Il file esiste!";
    
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-disposition: attachment; filename=$file");
    header("Content-Transfer-Encoding: binary");
    //header("Contant-type: application/txt");
    readfile("download/testFile.txt");
    //redirect("");
    header("index.php"); //redirect("/posts");
    }
 }


 public function contact() {
 

    $Email = Email::toMe($_POST);
    $Email->send();

    $message = "Grazie per averci contattato, risponderemo il prima possibile";
    $photo = $this->device.'.photo';
    $files=[
        $this->device.'.navbar-home',
        $this->device.'.cover',
        $this->device.'.portfolio',
        $this->device.'.skills', 
        $this->device.'.contact',
        $this->device.'.footer'
        ];
    $this->content = View('home', $files, compact('photo', 'message'));  // ritorniamo il template con il form per fare la registrazione
    //redirect("/");
 }





} // chiude classe HomeController

