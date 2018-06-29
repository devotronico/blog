<?php
namespace App\Controllers;

use \PDO; 
use App\Models\Signin;


class SigninController extends Controller
{
    
    public function __construct(PDO $conn){ 
        parent::__construct(); 
        $this->conn = $conn; 
    }


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
    $Signin = new Signin($this->conn, $_POST);
   
    
    if ( empty( $Signin->getMessage()) )
    {
        $email = $Signin->login(); 
        if ( empty( $Signin->getMessage()) )
        {
            if (isset($_SESSION['user_id'])): 
            
                $message = "Login riuscito";   
                $files=[$this->device.'.navbar-auth', 'signin.message'];
                $this->content = View($this->device, 'auth', $files, compact( 'message' )); // [a]   
            else:   
            
                $files=[$this->device.'.navbar-auth', 'signin.message'];
                $this->content = View($this->device, 'auth', $files, compact( 'email' )); // [a]   
            endif;
        }
        else 
        {

            $message = $Signin->getMessage(); 
            $files=[$this->device.'.navbar-auth', 'signin.form'];
            $link="signin";
            $this->content = View($this->device, 'auth', $files, compact('link', 'message')); // [c]  
        }
    }
    else
    {
        $message = $Signin->getMessage(); 
        $files=[$this->device.'.navbar-auth', 'signin.form'];
        $link="signin";
        $this->content = View($this->device, 'auth', $files, compact('link', 'message')); // [c]  
    }  

}

/***************************************************************************************************|
* LOGOUT    metodo = GET    route = auth/logout                                                     |
* distruggiamo l'id della sessione e il valore di $_SESSION["user_id"] e $_SESSION["user_type"]     |
* e distruggiamo il COOKIE                                                                          |
****************************************************************************************************/
public function logout(){
    if (session_status() == PHP_SESSION_ACTIVE) { session_destroy();  session_unset(); }
    //setcookie("user_id", null);
    setcookie("user_id", null, time()-3600, '/');
    redirect("/blog/");
}


} // CHIUDE LA CLASSE
