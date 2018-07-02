<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Image;
//use App\Models\Auth;
use \PDO;

class PostController extends Controller
{
    protected $Post ;
    protected $meta;
    private $bytes = 1000000;
    public function __construct(PDO $conn) { 
  
        parent::__construct(); 
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->Post = new Post($conn);  // creiamo qui un istanza della classe 'Post' e gli passiamo la connessione al database
    }



/***************************************************************************************|
* SHOW      metodo = GET    path = post/id                                              |
* questa classe mostrerà un solo post e mostrerà tutti i commenti legati a questo post  |
****************************************************************************************/
    public function postSingle($postid){ 
        $this->Post->checkImageExists($postid);
        $this->page = 'post';
        $post = $this->Post->find($postid); // prendiamo il post con un determinato id dal database 
      
      //  if ( !empty($post) ) {
        $comment = new Comment($this->conn); // istanziamo la classe Comment
        $comments =  $comment->all($postid); // prendiamo tutti i commenti che hanno lo stesso id del post
        $files=[$this->device.'.navbar-blog', 'post.single'];
        $this->content = View($this->device, 'blog', $files, compact('post', 'comments'));  
        $files=['meta'];
        //echo '<pre>', print_r($files) ,'</pre>';
        $this->meta = View($this->device, 'blog', $files, compact('post')); 
       // } else {
      //      redirect("/blog/");
      //  }
    }


/***************************************************|
* CREATE        metodo = GET    path = post/create  |                           
* Visualizza il form per creare un nuovo post       |
****************************************************/
    public function create(){

        $this->page = 'create';
        $acceptFileType=".jpg, .jpeg, .png";
        $bytes = $this->bytes;
        $megabytes = $bytes * 0.000001;
        $files=[$this->device.'.navbar-blog', 'post.create'];
        $link="create";
        $this->content = View($this->device, 'blog', $files, compact('link', 'acceptFileType', 'bytes', 'megabytes'));
    }


/***********************************************|
* SAVE      metodo = POST    path = post/save   |
* Salviamo un post nel database                 |
************************************************/
    public function savePost(){


    if ( $_FILES['file']['error'] === 4 ) 
    {
        $this->Post->save($_POST);  //echo json_encode($_POST);
        $this->Post->countPosts(1);
        redirect("/blog/");
    }
    else
    {
        $Image = new Image('wFixed', 600, 10, $this->bytes, 'posts', $_FILES);

        if ( empty( $Image->getMessage()) )
        {
            $imageName = $Image->getNewImageName();
            $this->Post->save($_POST, $imageName); 
            $this->Post->countPosts(1);
            redirect("/blog/");
        } else {
            $message = 'Si è verificato un errore<br>'.$Image->getMessage();
            //$uri ='/post/create';
            //redirect($uri, $message);
            $link="create";
            $this->page = 'create';
            $megabytes = $this->bytes * 0.000001;
            $files=[$this->device.'.navbar-blog', 'post.create'];
           
            $this->content = View($this->device, 'blog', $files, compact('link', 'message', 'megabytes'));
        }
    }
    }

/*******************************************************************************************************************************************|
* EDIT POST     metodo = GET    route = post/id/edit                                                                                        |                                          
* Per avere accesso a questo metodo bisogna avere il campo 'user_type' uguale a 'administrator' nella tabella 'users'                       |
* Al login $_SESSION['user_type'] prende il valore del campo 'user_type' e se è uguale a 'administrator' si può accedere a questo metodo    |                                                      |
* Il controllo su $_SESSION['user_type'] si trova nel template 'app\views\view-blog\post.single.tpl.php'                                    |                                                           
********************************************************************************************************************************************/
public function editPost($postid) {
    $this->page = 'edit';
    $post = $this->Post->edit($postid); 
    $bytes = $this->bytes;
    $megabytes = $bytes * 0.000001;
    $acceptFileType=".jpg, .jpeg, .png";
    $files=[$this->device.'.navbar-blog', 'post.edit'];
    $this->content = View($this->device, 'blog', $files, compact('post', 'bytes', 'megabytes', 'acceptFileType'));
}

/***********************************************************************************************|
* UPDATE POST       metodo = POST    route = post/update                                        |
* aggiorniamo/modifichiamo i dati del post (titolo, immagine, messaggio)                        |
* l'id lo otteniamo tramite il tag input che è type=hidden quindi è compreso nel array $_POST   | 
************************************************************************************************/
public function updatePost($postid) {

    if ( $_FILES['file']['error'] === 4  ) 
    {
        // immagine non caricata
        $this->Post->update($postid, $_POST);
        redirect("/blog/"); 
    }
    else
    {
        $Image = new Image('wFixed', 600, 10, $this->bytes, 'posts', $_FILES);

        if ( empty( $Image->getMessage()) ) {
            // immagine  caricata
            $imageName = !is_null($Image->getNewImageName()) ? $Image->getNewImageName() : '';
            $this->Post->deletePostImage($postid);
            $res = $this->Post->update($postid, $_POST, $imageName);
            echo $res;
            if ( !empty( $res )) {
                redirect("/blog/"); 
            } else {
                $message = 'Si è verificato un errore<br>'.$this->Post->getMessage();
                $uri ='/post/'.$postid.'/edit';
                redirect($uri, $message);
            }
        }
        else 
        {
            $message = 'Si è verificato un errore<br>'.$Image->getMessage();
            $uri ='/post/'.$postid.'/edit';
            redirect($uri, $message);
        }
    }

/*
    try {    
        $r = $this->Post->update($postid, $_POST); 
   
        redirect("/blog/"); 

    } catch ( PDOException $e ) {
        
        return $e->getMessage();
    }
    */
}



    
/*******************************************************************************************************************************************|
* DELETE        metodo = GET    route = post/id/delete                                                                                      |                                              
* Per avere accesso a questo metodo bisogna avere il campo 'user_type' uguale a 'administrator' nella tabella 'users'                       |
* Al login $_SESSION['user_type'] prende il valore del campo 'user_type' e se è uguale a 'administrator' si può accedere a questo metodo    |                                                      |
* Il controllo su $_SESSION['user_type'] si trova nel template 'app\views\view-blog\post.single.tpl.php'                                    |                                                          
********************************************************************************************************************************************/
    public function delete($postid){
      
        try {    

            $this->Post->deletePost((int)$postid); 
            $this->Post->countPosts(-1);
            $Comment = new Comment($this->conn); 
            $Comment->deleteAll((int)$postid);

            redirect("/blog/"); 

        } catch ( PDOException $e ) {
            
            return $e->getMessage();
        }
    }



/***********************************************************************************************************|
* SAVE COMMENT      metodo = POST    route = post/id/comment                                                |                                                                                      
* Salviamo il commento relativo a un determinato id di un post che passiamo come argomento a questo metodo  |
* Oltre al commento salviamo anche l'id del post nella colonna post_id della tabella 'comments'             |
************************************************************************************************************/
public function saveComment($postid) {

    $postid = (int)$postid;
        
    $Comment = new Comment($this->conn);
    $_POST['post_id'] = $postid;
    $Comment->save($_POST); 
 
    $Comment->userNumComments(1);
    $Comment->postNumComments(1, $postid);

    redirect('/post/'.$postid); 
}

/***********************************************************************************************************************************************|
* DELETE SINGLE COMMENT          metodo = GET    path = comment/id/delete                                                                       |
* Questo metodo consente la cancellazione di un singolo commento                                                                                |             
* Per avere accesso a questo metodo bisogna essere amministratore o contributore del sito/blog                                                  |
* Quando si fa il login viene inizializzato $_SESSION['user_type']                                                                              |
* Se $_SESSION['user_type'] è uguale a 'administrator' o 'contributor' allora possiamo accedere a questo metodo.                                |
* Se $_SESSION['user_type'] è uguale a 'administrator' si può cancellare qualsiasi commento                                                     |
* Se $_SESSION['user_type'] è uguale a 'contributor' si può cancellare solo i commenti relativi ai post che ha creato l'utente 'contributor'    |                                                                                           
************************************************************************************************************************************************/
public function deleteComment($commentid){

    $Comment = new Comment($this->conn); // istanziamo la classe Comment

    $postid = $Comment->getId('post_id', $commentid);
    $userid = $Comment->getId('user_id', $commentid);
   
    $Comment->userNumComments(-1, $userid);
    $Comment->postNumComments(-1, $postid);

    $Comment->deleteOne($commentid); // prendiamo solo il commento che ha il suo id univoco
    
    redirect('/post/'.$postid); 
}    

} // chiude classe PostController

