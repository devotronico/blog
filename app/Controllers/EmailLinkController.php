<?php
namespace App\Controllers;

use \PDO; 
use App\Models\Urlvalidate;

class EmailLinkController extends Controller
{
    public function __construct(PDO $conn){ 
        parent::__construct(); 
        $this->conn = $conn; 
    }


/*******************************************************************************************************************************|
* PASSWORD NEW      metodo = GET    route = auth/password/new                                                                   |
* Cliccando sul link/bottone all'interno della Mail attiveremo la rotta '/auth/password/new' seguita dai parametri email, hash  |                |                            
* il metodo 'passNew' controlla se i parametri {email, hash} passati attraverso il link siano validi                            |
* Se sono validi ci mostrerà un form dove andremo a impostare una nuova password.                                               |
* Se non sono validi non ci mostrerà un messaggio di errore e non ci consetirà di creare una nuova password                     |                                                            
********************************************************************************************************************************/
public function passwordNew(){
    $this->page = 'newpass';
    $Password = new Urlvalidate($this->conn, $_GET);

    if ( empty( $Password->getMessage()) )
    {
        $files=[$this->device.'.navbar-auth', 'pass.new'];   // mostra il form         
        $this->content = View($this->device, 'auth', $files );  // ritorniamo il template views\view-auth\verify.tpl.php
    }
    else
    {
        $message = $Password->getMessage();
        $files=[$this->device.'.navbar-auth', 'pass.error'];            
        $this->content = View($this->device, 'auth', $files, compact( 'message')); 
    }  
 }





} // chiude la classe EmailLinkController
