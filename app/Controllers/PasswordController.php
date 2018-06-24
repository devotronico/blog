<?php
namespace App\Controllers;

use \PDO; 
use App\Models\Password;
use App\Models\EmailLink;


class PasswordController extends Controller
{
    public function __construct(PDO $conn){ 
        parent::__construct(); 
        $this->conn = $conn; 
    }


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
    $Password = new Password($this->conn, $_POST);
    $Password->sendEmail(); 
 
    if ( empty( $Password->getMessage()) )
    {
        $message = "Ti abbiamo mandato una email al tuo indirizzo di posta <strong>".$_POST['email']."</strong>. Per favore segui le istruzioni contenute nell'email per creare una nuova password. Se l'email non ti arriva, controlla la tua cartella spam o prova a ripetere la procedura di cambio password";
        $files=[$this->device.'.navbar-auth', 'pass.message']; 
        $this->content = View($this->device, 'auth', $files, compact( 'message'));  // ritorniamo il template con il form per fare la registrazione
    }
    else
    {
        $message = $Password->getMessage(); // redirect("/auth/signup/store?message=\$message");
        $files=[$this->device.'.navbar-auth', 'pass.form']; 
        $this->content = View($this->device, 'auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    }  
 }


/***************************************************************************************************************************************|
* PASSWORD NEW      metodo = GET    route = auth/password/new                                                                           |
* Cliccando sul link/bottone all'interno della nostra Mail attiveremo la rotta '/auth/password/new' seguita dai parametri email, hash   |                |                            
* il metodo 'passNew' controlla se i parametri {email, hash} passati attraverso il link siano validi                                    |
* Se sono validi ci mostrerà un form dove andremo a impostare una nuova password.                                                       |
* Se non sono validi non ci mostrerà un messaggio di errore e non ci consetirà di creare una nuova password                             |                                                            
****************************************************************************************************************************************/

public function passwordNew(){
    $this->page = 'newpass';
    $EmailLink = new EmailLink($this->conn, $_GET);
    $EmailLink->linkNewPass();
    if ( empty( $EmailLink->getMessage()) )
    {
        $files=[$this->device.'.navbar-auth', 'pass.new'];    
        $this->content = View($this->device, 'auth', $files );  
    }
    else
    {
        $message = $EmailLink->getMessage();
        $files=[$this->device.'.navbar-auth', 'pass.error'];            
        $this->content = View($this->device, 'auth', $files, compact( 'message')); 
    }  
 }

/*
public function passwordNew(){
    $this->page = 'newpass';
    $Password = new Password($this->conn, $_GET);
    $Password->emailLink();
    if ( empty( $Password->getMessage()) )
    {
        $files=[$this->device.'.navbar-auth', 'pass.new'];    
        $this->content = View($this->device, 'auth', $files );  
    }
    else
    {
        $message = $Password->getMessage();
        $files=[$this->device.'.navbar-auth', 'pass.error'];            
        $this->content = View($this->device, 'auth', $files, compact( 'message')); 
    }  
 }
*/

/***********************************************************************************************************|
* PASSWORD SAVE      metodo = POST    route = auth/password/save    [set cookie]                            |                                                                                                                                                         
************************************************************************************************************/
public function passwordSave(){
    $this->page = 'newpass';
    $Password = new Password($this->conn, $_POST);
  
    if (  empty( $Password->getMessage()) )
    {    
        $files=[$this->device.'.navbar-auth', 'pass.success'];            
        $this->content = View($this->device, 'auth', $files);  
    }
    else
    {
        $message = $Password->getMessage();
        $files=[$this->device.'.navbar-auth', 'pass.new'];            
        $this->content = View($this->device, 'auth', $files, compact( 'message')); 
    }  
}


}
