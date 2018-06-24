<?php
namespace App\Controllers;

use \PDO; // importiamo la classe 'PDO' 
use App\Models\Email;

class HomeController extends Controller
{
   
    protected $conn;
 
    public function __construct(PDO $conn){ 
         // ereditiamo il costruttore della classe madre (Controller) per ottenere il valore di $this->device che può essere 'desktop' oppure 'mobile'
        parent::__construct(); 
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->page = 'home'; 
     //   $this->grid = 'container-fluid';
    }


//====================================================================================================== 
//========== FRONT PAGE ========================= FRONT PAGE ===========================================
//======================================================================================================     

/***********************************************|
* HOME  metodo = GET    route = home            |        
*************************************************/
public function home(){
  
    $photo = $this->device.'.photo';
    $files=[
       
        $this->device.'.navbar-home',
        $this->device.'.cover',
        $this->device.'.portfolio',
        $this->device.'.skills', 
        $this->device.'.contact',
        $this->device.'.footer'
        ];
    
    $this->content = View($this->device,'home', $files, compact('photo'));
}


public function contact() {
 
   // $Email = Email::toMe($_POST);
   // $Email->send();

    $message = "Grazie per averci contattato, risponderemo il prima possibile";
    $photo = $this->device.'.photo';
    $files=[
       
        $this->device.'.navbar-home',
        $this->device.'.message',
        $this->device.'.cover',
        $this->device.'.portfolio',
        $this->device.'.skills', 
        $this->device.'.contact',
        $this->device.'.footer'
        ];

    $this->content = View($this->device, 'home', $files, compact('photo', 'message'));  
 }


/***********************************************************|
* DOWNLOAD      metodo = GET    route = home/id/download    |
************************************************************/
public function download(){
  
    $dir = 'public/download/';
  
   // $filename = 'testFile.zip'; // Ninja_Bit.zip
    $filename = 'NinjaBit.zip'; // 
   // $fn = (isset($_GET['filename']) ? $_GET['filename'] : false);
    
    // controlliamo che ci siano caratteri validi nel nome del file
    if (!preg_match('/^[a-zA-Z0-9]+\.[a-z]{2,3}$/i',$filename)) {
        $filename = false; die('errore');
      }else{
       $file = $dir . $filename;  
      }
    
    if (!file_exists($file))
    {
    
      echo "Il file NON esiste!";
    }else{
      //  echo "Il file esiste!";
    
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;

/*
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-disposition: attachment; filename=$file");
    header("Content-Transfer-Encoding: binary");
    //header("Contant-type: application/txt");
    readfile("download/testFile.txt");
    //redirect("");
    header("index.php"); //redirect("/posts");
    */
    }
 }








} // chiude classe HomeController

