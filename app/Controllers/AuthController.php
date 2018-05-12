<?php
namespace App\Controllers;

use \PDO; // importiamo le classi 'PDO' e 'Post'
use App\Models\Auth;
use App\Models\Image;


class AuthController extends Controller
{
   
    protected $conn;
   // protected $Auth;  // [!]
  

    public function __construct(PDO $conn){ 
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->page = 'auth';
       // $this->Auth = new $class($this->conn); // [!]
    }
  



public function profile($id) {

    
    $sql = 'SELECT * FROM users INNER JOIN posts INNER JOIN postscomments WHERE users.ID = :id AND posts.user_id = users.ID AND postscomments.user_id = users.ID ';

    if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
    {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) // Tentiamo di eseguire lo statement
        {
            if ( $stmt ){

                $data = $stmt->fetch(PDO::FETCH_OBJ);
            }
        }
    }

    $message = 'pagina del profilo';
    $files=['navbar-auth', 'profile'];
    $this->content = View('auth', $files, compact('message', 'data'));  // ritorniamo il template con il form per fare la registrazione
}


//====================================================================================================== 
//========== SIGNUP GROUP  ========================= SIGNUP GROUP  ===================================
//====================================================================================================== 

/***********************************************************************************************************|
* SIGNUP FORM  [ route='auth/signup/form' => method=signupForm ]                                            |
* Se si clicca sul link signup che sta nella Navbar carica il template del Form per fare la registrazione   |                     
* Al submit del form attiviamo il metodo 'signupStore'                                                      |
************************************************************************************************************/
public function signupForm(){ 
 
    $message = isset($_GET['message']) ? $_GET['message'] : '';

    $files=['navbar-auth', 'signup.form'];
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
}

/***********************************************************************************************|
* SIGNUP STORE    [  route='auth/signup/store' => method='signupStore' ]                        |
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
* SIGNUP VERIFY    [  route='auth/signup/verify'=> method='signupVerify' ]                      |                                                              
* Quando all'interno della Mail clicchiamo il link verremo indirizzati di nuovo sul sito per    |
* verificare se i parametri del link siano validi e se l'account non era già stato attivato.    |
* Se è andato tutto bene verremo loggati                                                        |
************************************************************************************************/
public function signupVerify() {  
    $Auth = new Auth($this->conn, $_GET);
    $Auth->signupEmailActivation(); // in questo metodo otteniamo anche le  $_SESSION user_id, email;
 
    $message = !empty( $Auth->getMessage()) ? $Auth->getMessage() : "Registrazione avvenuta con successo!";

    $files=['navbar-auth', 'signup.verify'];            
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template views\view-auth\verify.tpl.php
}







//====================================================================================================== 
//========== SIGNIN GROUP  ========================= SIGNIN GROUP  =====================================
//====================================================================================================== 

/***************************************************************************************************|
* SIGNIN FORM  [ route='auth/signin/form' => method='signinForm' ]                                  |                          
* Se si clicca sul link signin che sta nella Navbar Carica il template del Form per fare il Login   |
*****************************************************************************************************/
public function signinForm(){    
    $message = isset($_GET['message']) ? $_GET['message'] : '';
    $files=['navbar-auth', 'signin.form'];
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare il Login
}


/***********************************************************************|
* SIGNIN ACCESS [ route='auth/signin/access' => method='signinAccess' ] |     
************************************************************************/
public function signinAccess(){  //    
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


/*******************|
*       LOGOUT      |
********************/
public function authLogout(){
    if (session_status() == PHP_SESSION_ACTIVE) { session_destroy(); }
    // unset($_SESSION["user_id"]);
    // unset($_SESSION["email"]);
    // session_abort();
    // session_destroy(); 
  //  $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
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
