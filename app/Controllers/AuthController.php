<?php
namespace App\Controllers;

use \PDO; 
use App\Models\Auth;
use App\Models\Image;


class AuthController extends Controller
{
    protected $bytes = 500000;
    public function __construct(PDO $conn){ 
        parent::__construct(); 
        $this->conn = $conn; 
    }


//====================================================================================================== 
//========== SIGNUP GROUP  ========================= SIGNUP GROUP  =====================================
//====================================================================================================== 

/***********************************************************************************************************|
* SIGNUP FORM       metodo = GET   route = auth/signup/form                                                 |
* Se si clicca sul link signup che sta nella Navbar carica il template del Form per fare la registrazione   |                     
* Al submit del form attiviamo il metodo 'signupStore'                                                      |
************************************************************************************************************/
public function signupForm(){ 
 
    $this->page = 'signup';
    $megabytes = $this->bytes * 0.000001;
    $files=[$this->device.'.navbar-auth', 'signup.form'];
    $link="signup";
    $this->content = View($this->device,'auth', $files, compact('link','megabytes')); 
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
    $megabytes = $this->bytes * 0.000001;
    $Image = new Image('fixed', 92, 92, $this->bytes, 'auth', $_FILES); // (int $max_width, int $max_height, int $max_size, string $folder, array $data )

    if ( empty( $Image->getMessage()) ) {

        $imageName = !is_null($Image->getNewImageName()) ? $Image->getNewImageName() : 'default.jpg';

        $Auth = new Auth($this->conn, $_POST);  
        $Auth->signup($imageName); 

        if (  empty( $Auth->getMessage()) ) {

            $message = "Abbiamo mandato una email di attivazione a <strong>".$_POST['user_email']."</strong>. Per favore segui le istruzioni contenute nell'email per attivare il tuo account. Se l'email non ti arriva, controlla la tua cartella spam o prova a collegarti ancora per inviare un'altra email di attivazione.";
            $files=[$this->device.'.navbar-auth', 'signup.success'];
            $this->content = View($this->device, 'auth', $files, compact('message')); 
        } else {

            $message = $Auth->getMessage(); 
            $files=[$this->device.'.navbar-auth', 'signup.form'];
            $link="signup";
            $this->content = View($this->device, 'auth', $files, compact('link', 'megabytes', 'message')); 
        }
    } else {

        $imgMessage = $Image->getMessage();
        $files=[$this->device.'.navbar-auth', 'signup.form'];
        $link="signup";
        $this->content = View($this->device, 'auth', $files, compact('link','megabytes', 'imgMessage'));  
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
    $Auth = new Auth($this->conn, $_GET);
    $Auth->signupEmailActivation(); // in questo metodo otteniamo anche le  $_SESSION user_id, user_type, user_name;
 
    $message = !empty( $Auth->getMessage()) ? $Auth->getMessage() : "Complimenti ".$_SESSION['user_name']." la tua registrazione è avvenuta con successo!";

    $files=[$this->device.'.navbar-auth', 'signup.verify'];            
    $this->content = View($this->device, 'auth', $files, compact('message'));  // ritorniamo il template views\view-auth\verify.tpl.php
}


//====================================================================================================== 
//========== SIGNIN GROUP  ========================= SIGNIN GROUP  =====================================
//====================================================================================================== 

/***************************************************************************************************|
* SIGNIN FORM       metodo = GET      route = auth/signin/form                                      |                  
* Se si clicca sul link signin che sta nella Navbar Carica il template del Form per fare il Login   |
*****************************************************************************************************/
public function signinForm(){    
    $this->page = 'signin';
    $files=[$this->device.'.navbar-auth', 'signin.form'];
    $link="signin";
    $this->content = View($this->device, 'auth', $files, compact('link'));  // ritorniamo il template con il form per fare il Login
}

/***************************************************************************************************************************|
* SIGNIN ACCESS     metodo = POST    route = auth/signin/access       $_COOKIE                                                      | 
* In questo metodo vengono controllate la email e la password che abbiamo inserito nel form del login                       |
* Se sono correte allora verremo indirizzati in una pagina che ci da il benvenuto [a]                                       |
* Altrimenti se l'email e la password sono errate resteremo nella pagina del login con un messaggio di errore [b]           | 
* Se proviamo a fare il login senza aver prima attivato l'account dalla mail che ci ha inviato il sistema durante la fase   | 
* di registrazione allora il sistema ci invierà un'altra mail chiedendoci di attivare l'account [c]                         |    
****************************************************************************************************************************/
public function signinAccess() { 
    $this->page = 'signin'; 
    $Auth = new Auth($this->conn, $_POST);
    $email = $Auth->signin(); 
    
    if (  empty( $Auth->getMessage()) )
    {
        if (isset($_SESSION['user_id'])): 
            setcookie("user_id", $_SESSION['user_id'], time()+3600, '/');
            $message = "Login riuscito";   
            $files=[$this->device.'.navbar-auth', 'signin.message'];
            $this->content = View($this->device, 'auth', $files, compact( 'message')); // [a]   
        else:   
            $files=[$this->device.'.navbar-auth', 'signin.message'];
            $this->content = View($this->device, 'auth', $files, compact('email'));  // [b]  
        endif;
    }
    else
    {
        $message = $Auth->getMessage(); 
        $files=[$this->device.'.navbar-auth', 'signin.form'];
        $link="signin";
        $this->content = View($this->device, 'auth', $files, compact('link', 'message')); // [c]  
    }  

}

/***************************************************************************************************|
* LOGOUT    metodo = GET    route = auth/logout                                                     |
* distruggiamo il l'id della sessione e il valore di $_SESSION["user_id"] e $_SESSION["user_type"]  |
****************************************************************************************************/
public function logout(){
    if (session_status() == PHP_SESSION_ACTIVE) { session_destroy();  session_unset(); }
    //setcookie("user_id", null);
    setcookie("user_id", null, time()-3600, '/');
    redirect("/posts");
}


//====================================================================================================================== 
//========== PASSWORD RESET GROUP  ========================= PASSWORD RESET GROUP  =====================================
//====================================================================================================================== 

/***************************************************************************************************************************************|
* Al momento del login se l'utente non ricorda la password cliccando sul link del form 'password dimenticata?' si attiverà la rotta     |
* '/auth/password/form' che attiva il metodo 'passwordForm' di questa classe il quale ci mostrerà il template del form dove bisogna     |
*  inserire solo l'email e premere il bottone che ci indirizzerà verso la rotta '/auth/password/check' che attiverà il methodo          |
* 'passwordCheck' nel quale verrà verificato se l'email è già registrata nel database, Se è già registrata nel database il sistema ci   |
*  invierà una email con l'hash corrispondete all'interno di un link che attiverà la rotta '/auth/password/new' che ci mostrerà un form |
*  dove andremo a impostare una nuova password.                                                                                         |
* 'auth/password/lost'  |   'auth/password/new'  |   'auth/password/check'  |   'auth/password/save'                                    |
****************************************************************************************************************************************/

/***********************************************************************************************************************************|
* PASSWOR FORM      metodo = GET    route = auth/password/form                                                                      |                                                                                                                    
* Dal form del login se l'utente non ricorda la password cliccando sul link del form 'password dimenticata?' si attiverà la rotta   |
* '/auth/password/lost' che attiva il metodo 'passwordForm' di questa classe il quale ci mostrerà il template del form dove bisogna |
* inserire solo l'email e premere il bottone [metodo POST]                                                                          |
************************************************************************************************************************************/
public function passwordForm(){
    $this->page = 'newpass';
    $files=[$this->device.'.navbar-auth', 'pass.form'];            
    $this->content = View($this->device, 'auth', $files);  
}

/***************************************************************************************************************************************|
* PASSWORD CHECK         metodo = POST    route = auth/password/check                                                                   |
* la rotta '/auth/password/check' attiverà il methodo 'passCheck' nel quale verrà verificato se l'email è già registrata nel database,  |         
* Se è già registrata nel database il sistema ci invierà una Mail                                                                       |
* con all'interno un link dove saranno passati la nostra email e hash corrispondente che abbiamo prelevato dal database                 |
****************************************************************************************************************************************/
public function passwordCheck(){

    $this->page = 'newpass';
    $Auth = new Auth($this->conn, $_POST);
    $Auth->passCheck(); 
 
    if ( empty( $Auth->getMessage()) )
    {
        $message = "Ti abbiamo mandato una email al tuo indirizzo di posta <strong>".$_POST['user_email']."</strong>. Per favore segui le istruzioni contenute nell'email per creare una nuova password. Se l'email non ti arriva, controlla la tua cartella spam o prova a ripetere la procedura di cambio password";
        $files=[$this->device.'.navbar-auth', 'pass.message']; 
        $this->content = View($this->device, 'auth', $files, compact( 'message'));  // ritorniamo il template con il form per fare la registrazione
    }
    else
    {
        $message = $Auth->getMessage(); // redirect("/auth/signup/store?message=\$message");
        $files=[$this->device.'.navbar-auth', 'pass.form']; 
        $this->content = View($this->device, 'auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    }  
 }


/***********************************************************************************************************|
* PASSWORD NEW      metodo = GET    route = auth/password/new                                               |
* Cliccando sul link/bottone all'interno della Mail attiveremo la rotta '/auth/password/new'                |                            
* il metodo 'passNew' controlla se i parametri {email, hash} passati attraverso il link siano validi        |
* Se sono validi ci mostrerà un form dove andremo a impostare una nuova password.                           |
* Se non sono validi non ci mostrerà un messaggio di errore e non ci consetirà di creare una nuova password |                                                            
************************************************************************************************************/
 public function passwordNew(){
    $this->page = 'newpass';
    $Auth = new Auth($this->conn, $_GET);
    $Auth->passNew(); 

    if ( empty( $Auth->getMessage()) )
    {
        $files=[$this->device.'.navbar-auth', 'pass.new'];   // mostra il form         
        $this->content = View($this->device, 'auth', $files );  // ritorniamo il template views\view-auth\verify.tpl.php
    }
    else
    {
        $message = $Auth->getMessage();
        $files=[$this->device.'.navbar-auth', 'pass.error'];            
        $this->content = View($this->device, 'auth', $files, compact( 'message')); 
    }  
 }


/***********************************************************************************************************|
* PASSWORD SAVE      metodo = POST    route = auth/password/save                                            |                                                                                                                                                         
************************************************************************************************************/
public function passwordSave(){
    $this->page = 'newpass';
    $Auth = new Auth($this->conn, $_POST);
    $Auth->passSave(); // in questo metodo otteniamo anche le  $_SESSION user_id, email, name;
  
    if (  empty( $Auth->getMessage()) )
    {    
       
        $files=[$this->device.'.navbar-auth', 'pass.success'];            
        $this->content = View($this->device, 'auth', $files);  
    }
    else
    {
        $message = $Auth->getMessage();
        $files=[$this->device.'.navbar-auth', 'pass.new'];            
        $this->content = View($this->device, 'auth', $files, compact( 'message')); 
    }  
}


}
