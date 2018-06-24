<?php
namespace App\Controllers;

use \PDO; 
use App\Models\Signup;
use App\Models\Image;
use App\Models\EmailLink;


class SignupController extends Controller
{
    protected $bytes = 500000;
    public function __construct(PDO $conn){ 
        parent::__construct(); 
        $this->conn = $conn; 
    }

/***********************************************************************************************************|
* SIGNUP FORM       metodo = GET   route = auth/signup/form                                                 |
* Se si clicca sul link signup che sta nella Navbar carica il template del Form per fare la registrazione   |   
* la variabile page ci servirà per caricare il file css per questo form                                     |
* Al submit del form attiviamo il metodo 'signupStore'                                                      |
************************************************************************************************************/
public function signupForm(){ 
 
    $this->page = 'signup';
    $link="signup";
    $acceptFileType=".jpg, .jpeg, .png";
    $bytes = $this->bytes;
    $megabytes = $bytes * 0.000001;
    $files=[$this->device.'.navbar-auth', 'signup.form'];
    $this->content = View($this->device,'auth', $files, compact('link', 'acceptFileType', 'bytes', 'megabytes')); 
}

/***************************************************************************************************************************************************|
* SIGNUP STORE      metodo = POST    route = auth/signup/store                                                                                      |
* Il sistema per consentire la registrazione controlla prima se l'immaggine che inseriamo nel form rispetti i requisiti richiesti                   |
* se non viene inserita nessuna immagine il sistema ci assegnerà un immagine di default                                                             |
* se l'inserimento dell'immagine ha avuto successo verrà salvato una copia dell'immagine nella cartella public/img/auth                             |
* a questo punto il sistema può procedere per verificare i restanti dati da noi inseriti nel form. Se sono validi allora li salverà nel database    | 
* Se non si sono verificati errori fino a questo punto il sistema ci invierà una Mail con un link che contiene i parametri email e hash             |                                    
****************************************************************************************************************************************************/

public function signupStore(){ 
   
    $this->page = 'signup';
  
    $Image = new Image('fixed', 92, 92, $this->bytes, 'auth', $_FILES); // (int $max_width, int $max_height, int $max_size, string $folder, array $data )

    if ( empty( $Image->getMessage()) ) {
      
        $imageName = !is_null($Image->getNewImageName()) ? $Image->getNewImageName() : 'default.jpg';
    
        $Signup = new Signup($this->conn, $_POST); 

        $Signup->storeData($imageName); 
       
        if (  empty( $Signup->getMessage()) ) 
        {  
            $message = "Abbiamo mandato una email di attivazione a <strong>".$_POST['email']."</strong><br>Per favore segui le istruzioni contenute nell'email per attivare il tuo account. Se l'email non ti arriva, controlla la tua cartella spam o prova a collegarti ancora per inviare un'altra email di attivazione.";
            $files=[$this->device.'.navbar-auth', 'signup.success'];
            $this->content = View($this->device, 'auth', $files, compact('message')); 
        } 
        else 
        { 
            $link="signup";
            $message = $Signup->getMessage();
            $acceptFileType=".jpg, .jpeg, .png";
            $bytes = $this->bytes;
            $megabytes = $bytes * 0.000001;
            $files=[$this->device.'.navbar-auth', 'signup.form'];
            $this->content = View($this->device, 'auth', $files, compact('link', 'message', 'acceptFileType', 'bytes', 'megabytes'));  
        }
    } 
    else 
    {  
        $link="signup";
        $message = $Image->getMessage();
        $acceptFileType=".jpg, .jpeg, .png";
        $bytes = $this->bytes;
        $megabytes = $bytes * 0.000001;
        $files=[$this->device.'.navbar-auth', 'signup.form'];
        $this->content = View($this->device, 'auth', $files, compact('link', 'message', 'acceptFileType', 'bytes', 'megabytes'));  
    }
  
}

/***********************************************************************************************|
* SIGNUP VERIFY     metodo = GET   route = auth/signup/verify    COOKIE                         |                                                              
* Quando all'interno della Mail clicchiamo il link verremo indirizzati di nuovo sul sito per    |
* verificare se i parametri del link siano validi e se l'account non era già stato attivato.    |
* Se è andato tutto bene verremo loggati                                                        |
************************************************************************************************/

public function signupVerify() {  
    $this->page = 'signup';
    $EmailLink = new EmailLink($this->conn, $_GET);
    $EmailLink->accountActivation();
 
    $message = !empty( $EmailLink->getMessage()) ? $EmailLink->getMessage() : "Complimenti <strong>".$_SESSION['user_name']."</strong> la tua registrazione è avvenuta con successo!";

    $files=[$this->device.'.navbar-auth', 'signup.verify'];            
    $this->content = View($this->device, 'auth', $files, compact('message')); 
}



} // chiude SignupController
