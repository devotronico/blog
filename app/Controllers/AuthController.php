<?php
namespace App\Controllers;

use \PDO; // importiamo le classi 'PDO' e 'Post'
use App\Models\Auth;
use App\Models\Image;


class AuthController extends Controller
{

    public function __construct(PDO $conn){ 
        parent::__construct(); 
        $this->conn = $conn; 
        $this->page = 'auth';
    }
  

//====================================================================================================== 
//========== PROFILE =================================== PROFILE =======================================
//====================================================================================================== 
/***************************************************************************************************************************************|
* PROFILE       metodo = POST   route = auth/id/profile                                                                                 |
* Se si clicca sul link nome di un utente si viene indirizzati alla pagina di profilo dell'utente dove vengono visualizzati alcune info |                     
* Prese dalle tabelle 'users' 'posts' 'comments' relative a quel utente                                                                 |
* Se l'utente ha il campo 'user_type' come 'administrator' allora può cambiare l'user_type degli altri utenti dalla pagina del profilo  |
****************************************************************************************************************************************/
    public function profile($id) {   

        $Auth = new Auth($this->conn); 
        $data = $Auth->profile($id); 
        $user = $Auth->getUserType();
        //$message = 'pagina del profilo';
        $files=['navbar-auth', 'profile'];
        $this->content = View('auth', $files, compact( 'data', 'user')); // 'message',
    }

/***************************************************************************************************************|
* SET ADMINISTRATOR     metodo = GET    route = auth/id/administrator                                           |                                                                                        
****************************************************************************************************************/
    public function setAdministrator($id) { 
        $Auth = new Auth($this->conn); 
        $Auth->modUserType($id, 'administrator'); 
        $this->profile($id);    
    }
/***************************************************************************************************************|
* SET CONTRIBUTOR       metodo = GET    route = auth/id/contributor                                             |                                                                                        
****************************************************************************************************************/
    public function setContributor($id) {
        $Auth = new Auth($this->conn); 
        $Auth->modUserType($id, 'contributor');   
        $this->profile($id); 
    }
/***************************************************************************************************************|
* SET READER     metodo = GET   route = auth/id/reader                                                           |                                                                                        
****************************************************************************************************************/
    public function setReader($id) {  
        $Auth = new Auth($this->conn); 
        $Auth->modUserType($id, 'reader');   
        $this->profile($id);     
    }

/***************************************************************************************************************|
* SET AVATAR     metodo = POST   route = auth/:id/image                                                         |                                                                                        
****************************************************************************************************************/
    public function setAvatar($id){ 

        $Auth = new Auth($this->conn); 
        $Auth->deleteAvatar($id); // cancelliamo l'immagine

        $Image = new Image(80, 80, 100000, 'auth', $_FILES); // creiamo una nuova immagine

        $imageName = !is_null($Image->getNewImageName()) ? $Image->getNewImageName() : 'default.jpg'; // otteniamo il nuovo nome dell'immagine

        $Auth->storeAvatar($id, $imageName); // salviamo il nuovo nome dell'immagine nel database

     
        if (  empty( $Auth->getMessage()) && empty( $Image->getMessage()) ) {

            $data = $Auth->profile($id); 
            $user = $Auth->getUserType();
            $files=['navbar-auth', 'profile'];
            $this->content = View('auth', $files, compact( 'data', 'user')); 
        } else {

            $message = 'Si è verificato un errore';
            $message .= $Auth->getMessage();
            $message .= $Image->getMessage();
            $data = $Auth->profile($id); 
            $user = $Auth->getUserType();
            $files=['navbar-auth', 'profile'];
            $this->content = View('auth', $files, compact('message', 'data', 'user')); 
        }
        


    }
    

//====================================================================================================== 
//========== SIGNUP GROUP  ========================= SIGNUP GROUP  ===================================
//====================================================================================================== 

/***********************************************************************************************************|
* SIGNUP FORM       metodo = GET   route = auth/signup/form                                                 |
* Se si clicca sul link signup che sta nella Navbar carica il template del Form per fare la registrazione   |                     
* Al submit del form attiviamo il metodo 'signupStore'                                                      |
************************************************************************************************************/
public function signupForm(){ 
 
    $message = isset($_GET['message']) ? $_GET['message'] : '';

    $files=['navbar-auth', 'signup.form'];
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
}

/***********************************************************************************************|
* SIGNUP STORE      metodo = POST    route = auth/signup/store                                  |
* Con il submit del form con il metodo POST                                                     |
* se i dati del form {email e password} sono validi si salvano nel database                     | 
* e il sistema invierà una Mail all'utente con un link che contiene i parametri email e hash    |                                    
************************************************************************************************/

    // come argomento del metodo signup($_POST) della classe Auth passiamo i dati che sono un array di chiavi valori {$_POST['email'], $_POST['password'] }
 // preleviamo dalla classe Auth la variabile $message - se non cè - allora la 
   //registrazione ha avuto successo e verrà visualizzato il messaggio che
   // ci avvisa che ci ci è stata inviata una mail per confermare l'account
public function signupStore(){ // 

    $Image = new Image(80, 80, 100000, 'auth', $_FILES); // (int $max_width, int $max_height, int $max_size, string $folder, array $data )

    $Auth = new Auth($this->conn, $_POST);  
      
    $imageName = !is_null($Image->getNewImageName()) ? $Image->getNewImageName() : 'default.jpg';
    $Auth->signup($imageName); 
  
    if (  empty( $Auth->getMessage()) &&  empty( $Image->getMessage()) )
    {
    
        $message =  "Abbiamo mandato una email di attivazione a <strong>".$_POST['user_email']."</strong>. Per favore segui le istruzioni contenute nell'email per attivare il tuo account. Se l'email non ti arriva, controlla la tua cartella spam o prova a collegarti ancora per inviare un'altra email di attivazione.";
        $files=['navbar-auth', 'signup.success'];
        $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    }
    else
    {
        $imgMessage = !empty( $Image->getMessage()) ? $Image->getMessage() : '';
        $message = $Auth->getMessage(); // redirect("/auth/signup/store?message=$message");
        $files=['navbar-auth', 'signup.form'];
        $this->content = View('auth', $files, compact('imgMessage','message'));  // ritorniamo il template con il form per fare la registrazione
    }  
}


/***********************************************************************************************|
* SIGNUP VERIFY     metodo = GET   route = auth/signup/verify                                   |                                                              
* Quando all'interno della Mail clicchiamo il link verremo indirizzati di nuovo sul sito per    |
* verificare se i parametri del link siano validi e se l'account non era già stato attivato.    |
* Se è andato tutto bene verremo loggati                                                        |
************************************************************************************************/
public function signupVerify() {  
    $Auth = new Auth($this->conn, $_GET);
    $Auth->signupEmailActivation(); // in questo metodo otteniamo anche le  $_SESSION user_id, user_type, user_name;
 
    $message = !empty( $Auth->getMessage()) ? $Auth->getMessage() : "Complimenti ".$_SESSION['user_name']." la tua registrazione è avvenuta con successo!";

    $files=['navbar-auth', 'signup.verify'];            
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template views\view-auth\verify.tpl.php
}







//====================================================================================================== 
//========== SIGNIN GROUP  ========================= SIGNIN GROUP  =====================================
//====================================================================================================== 

/***************************************************************************************************|
* SIGNIN FORM       metodo = GET      route = auth/signin/form                                                        
* Se si clicca sul link signin che sta nella Navbar Carica il template del Form per fare il Login   |
*****************************************************************************************************/
public function signinForm(){    
    $message = isset($_GET['message']) ? $_GET['message'] : '';
    $files=['navbar-auth', 'signin.form'];
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare il Login
}


/***************************************************************|
* SIGNIN ACCESS     metodo = POST    route = auth/signin/access |     
****************************************************************/
public function signinAccess() {  //    
$Auth = new Auth($this->conn, $_POST);
// come argomento del metodo signin($_POST) della classe Auth passiamo i dati che sono un array di chiavi valori {$_POST['email'], $_POST['password'] }
$email = $Auth->signin(); 
   
// preleviamo dalla classe Auth la variabile $message - se non cè - allora 
// il login ha avuto successo e verrà visualizzato il messaggio che ce lo confermerà
if (  empty( $Auth->getMessage()) )
{
    if (isset($_SESSION['user_id'])): 
        $message = "Login effettuato con Successo!";   
        $files=['navbar-auth', 'signin.success'];
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    else:   
        $files=['navbar-auth', 'signin.success'];
        $this->content = View('auth', $files, compact('email'));  // ritorniamo il template con il form per fare la registrazione
    endif;
}
else
{
    $message = $Auth->getMessage();
    $files=['navbar-auth', 'signin.form'];
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
}  

}



/***************************************************************************************************|
* LOGOUT    metodo = GET    route = auth/logout                                                     |
* distruggiamo il l'id della sessione e il valore di $_SESSION["user_id"] e $_SESSION["user_type"]  |
****************************************************************************************************/
public function logout(){
    if (session_status() == PHP_SESSION_ACTIVE) { session_destroy();  session_unset(); }
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
* PASSWOR FORM                                                                                                                      |
* Dal form del login se l'utente non ricorda la password cliccando sul link del form 'password dimenticata?' si attiverà la rotta   |
* '/auth/password/lost' che attiva il metodo 'passwordLost' di questa classe il quale ci mostrerà il template del form dove bisogna |
* inserire solo l'email e premere il bottone [metodo POST]                                                                          |
************************************************************************************************************************************/
public function passwordForm(){
    $files=['navbar-auth', 'pass.form'];            
    $this->content = View('auth', $files);  // template del form per inserimento della email
}

/***************************************************************************************************************************************|
* PASSWORD CHECK
* la rotta '/auth/password/check' attiverà il methodo 'passCheck' nel quale verrà verificato se l'email è già registrata nel database,  |         
* Se è già registrata nel database il sistema ci invierà una Mail                                                                       |
* con all'interno un link dove saranno passati la nostra email e hash corrispondente che abbiamo prelevato dal database                 |
****************************************************************************************************************************************/
public function passwordCheck(){

    $Auth = new Auth($this->conn, $_POST);
    $Auth->passCheck(); 
 
    if ( empty( $Auth->getMessage()) )
    {
        $message = "Abbiamo mandato una email di attivazione a <strong>".$_POST['user_email']."</strong>. Per favore segui le istruzioni contenute nell'email per attivare il tuo account. Se l'email non ti arriva, controlla la tua cartella spam o prova a collegarti ancora per inviare un'altra email di attivazione.";
        $files=['navbar-auth', 'pass.message']; 
        $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    }
    else
    {
        $message = $Auth->getMessage(); // redirect("/auth/signup/store?message=$message");
        $files=['navbar-auth', 'pass.form']; 
        $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    }  

 }


/***********************************************************************************************************|
* PASSWORD NEW                                                                                              |
* Cliccando sul link/bottone all'interno della Mail attiveremo la rotta '/auth/password/new'                |                            
* il metodo 'passNew' controlla se i parametri {email, hash} passati attraverso il link siano validi        |
* Se sono validi ci mostrerà un form dove andremo a impostare una nuova password.                           |
* Se non sono validi non ci mostrerà un messaggio di errore e non ci consetirà di creare una nuova password |                                                              |
************************************************************************************************************/
 public function passwordNew(){
    $Auth = new Auth($this->conn, $_GET);
    $Auth->passNew(); 


    if ( empty( $Auth->getMessage()) )
    {
        $files=['navbar-auth', 'pass.new'];   // mostra il form         
        $this->content = View('auth', $files );  // ritorniamo il template views\view-auth\verify.tpl.php
    }
    else
    {
        $message = $Auth->getMessage();
        $files=['navbar-auth', 'pass.error'];            
        $this->content = View('auth', $files, compact('message')); 
    }  
 }


/***********************************************************************************************************|
* PASSWORD SAVE                                                                                             |                                                          
************************************************************************************************************/
public function passwordSave(){

    $Auth = new Auth($this->conn, $_POST);
    $Auth->passSave(); // in questo metodo otteniamo anche le  $_SESSION user_id, email, name;
  
    if (  empty( $Auth->getMessage()) )
    {    
       
        $files=['navbar-auth', 'pass.success'];            
        $this->content = View('auth', $files);  
    }
    else
    {
        $message = $Auth->getMessage();
        $files=['navbar-auth', 'pass.new'];            
        $this->content = View('auth', $files, compact('message')); 
    }  
}


}
