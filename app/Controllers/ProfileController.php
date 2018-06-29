<?php
namespace App\Controllers;

use \PDO; 
use App\Models\Profile;
use App\Models\Image;


class ProfileController extends Controller
{
    protected $bytes = 500000;
    public function __construct(PDO $conn){ 
        parent::__construct(); 
        $this->conn = $conn; 
    }
  
    /***************************************************************************************************************************************|
    * PROFILE       metodo = POST   route = auth/id/profile                                                                                 |
    * Se si clicca sul link nome di un utente si viene indirizzati alla pagina di profilo dell'utente dove vengono visualizzati alcune info |                     
    * Prese dalle tabelle 'users' 'posts' 'comments' relative a quel utente                                                                 |
    * Se l'utente ha il campo 'user_type' come 'administrator' allora può cambiare l'user_type degli altri utenti dalla pagina del profilo  |
    ****************************************************************************************************************************************/
    public function profile($id) {   
        $this->page = 'profile';
        $Profile = new Profile($this->conn); 
        $data = $Profile->profile($id); 
   
        if ( isset($_SESSION['user_id']) &&  $data->ID === $_SESSION['user_id'] ) {

            $link="profile";
            $acceptFileType=".jpg, .jpeg, .png";
            $bytes = $this->bytes;
            $megabytes = $bytes * 0.000001;
            $files=[$this->device.'.navbar-auth', 'profile.user'];
            $this->content = View($this->device, 'auth', $files, compact( 'data', 'link', 'bytes', 'megabytes', 'acceptFileType')); 
        }
        else
        {
            $files=[$this->device.'.navbar-auth', 'profile'];
            $this->content = View($this->device, 'auth', $files, compact( 'data', 'link' )); 
        }
    }



    /***************************************************************************************************************|
    * SET USER TYPE     metodo = GET    route = profile/id/setUsertype                                               |                                                                                        
    ****************************************************************************************************************/
    public function setUsertype($id, $usertype) { 
        $Profile = new Profile($this->conn); 
        $Profile->modUserType($id, $usertype); 
        $this->profile($id);    
    }
    /***************************************************************************************************************|
    * SET ADMINISTRATOR     metodo = GET    route = auth/id/administrator                                           |                                                                                        
    ****************************************************************************************************************/
    // public function setAdministrator($id) { 
    //     $Profile = new Profile($this->conn); 
    //     $Profile->modUserType($id, 'administrator'); 
    //     $this->profile($id);    
    // }
    /***************************************************************************************************************|
    * SET CONTRIBUTOR       metodo = GET    route = auth/id/contributor                                             |                                                                                        
    ****************************************************************************************************************/
    // public function setContributor($id) {
    //     $Profile = new Profile($this->conn); 
    //     $Profile->modUserType($id, 'contributor');   
    //     $this->profile($id); 
    // }
    /***************************************************************************************************************|
    * SET READER     metodo = GET   route = auth/id/reader                                                          |                                                                                        
    ****************************************************************************************************************/
    // public function setReader($id) {  
    //     $Profile = new Profile($this->conn); 
    //     $Profile->modUserType($id, 'reader');   
    //     $this->profile($id);     
    // }
    /***************************************************************************************************************|
    * SET BANNED     metodo = GET   route = auth/id/banned                                                          |                                                                                        
    ****************************************************************************************************************/
    // public function setBanned($id) {  
    //     $Profile = new Profile($this->conn); 
    //     $Profile->modUserType($id, 'banned');   
    //     $this->profile($id);     
    // }

    /***************************************************************************************************************|
    * SET AVATAR     metodo = POST   route = auth/:id/image                                                         |                                                                                        
    ****************************************************************************************************************/
    public function setAvatar($id){ 

        $Profile = new Profile($this->conn); 
        $Profile->deleteAvatar($id); // cancelliamo l'immagine

        $Image = new Image('fixed', 92, 92, $this->bytes, 'auth', $_FILES); // creiamo una nuova immagine

        $imageName = !is_null($Image->getNewImageName()) ? $Image->getNewImageName() : 'default.jpg'; // otteniamo il nuovo nome dell'immagine

        $Profile->storeAvatar($id, $imageName); // salviamo il nuovo nome dell'immagine nel database

     
        if (  empty( $Profile->getMessage()) && empty( $Image->getMessage()) ) {

            $this->profile($id);   
        } else {

            $message = 'Si è verificato un errore<br>';
            $message .= $Profile->getMessage();
            $message .= $Image->getMessage();
            
            $uri ='/auth/'.$_SESSION['user_id'].'/profile';

            redirect($uri, $message);
        }
    }
    


} // chiude classe ProfileController
