<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Image;
use \PDO;

class PostController extends Controller
{
    protected $Post ;
  
    public function __construct(PDO $conn){ 
  
        parent::__construct(); 
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->Post = new Post($conn);  // creiamo qui un istanza della classe 'Post' e gli passiamo la connessione al database
        $this->page = 'blog';
    }



/***************************************************|
* GETPOSTS          metodo = GET    path = posts    |
* Otteniamo tutti i post                            |
****************************************************/
    public function getPosts(){
     
        $totalPosts = $this->Post->totalPosts(); 
        if ( empty($totalPosts ) ) { 

            $files=['navbar-blog', 'post.empty'];
            $this->content = View('blog', $files);

         } else {
            $posts = $this->Post->all(); // prendiamo tutti i post dal database 
            $files=['navbar-blog', 'post.all', $this->device.'.pagination'];
            $page = 1;
            $this->content = View('blog', $files, compact('posts', 'page', 'totalPosts')); 
         }
    }

 

/***********************************************************|
* GETPOSTS          metodo = GET    path = posts/page/id    |
* Otteniamo tutti i post di una pagina                      |             
************************************************************/
public function getPostsPage($page){ 
  
    $totalPosts = $this->Post->totalPosts();
 
    if ( empty($totalPosts ) ) { 

        $files=['navbar-blog', 'post.empty'];
        $this->content = View('blog', $files, compact('posts')); 

     } else {
          
        for ($i=0, $postStart=-2; $i<$page; $postStart+=2, $i++);
        $posts = $this->Post->pagePosts($postStart); // prendiamo tutti i post dal database 
        $files=['navbar-blog', 'post.all', $this->device.'.pagination'];
        $this->content = View('blog', $files, compact('posts', 'page', 'totalPosts')); 
     }
}
    

/***************************************************************************************|
* SHOW      metodo = GET    path = post/id                                              |
* questa classe mostrerà un solo post e mostrerà tutti i commenti legati a questo post  |
****************************************************************************************/
    public function postSingle($postid){ 
      
        $post =  $this->Post->find($postid); // prendiamo il post con un determinato id dal database 
        $comment = new Comment($this->conn); // istanziamo la classe Comment
        $comments =  $comment->all($postid); // prendiamo tutti i commenti che hanno lo stesso id del post


        $files=['navbar-blog', 'post.single'];
        $this->content = View('blog', $files, compact('post','comments'));  // usando la funzione View ritorniamo il template con i post all' interno
      
    }



/***************************************************|
* CREATE        metodo = GET    path = post/create  |                           
* Visualizza il form per creare un nuovo post       |
****************************************************/
    public function create(){
        $files=['navbar-blog', 'post.create'];
        $this->content = View('blog', $files );
    }



/***********************************************|
* SAVE      metodo = POST    path = post/save   |
* Salviamo un post nel database                 |
************************************************/
    public function savePost(){

    if ( !$_FILES['file']['error']  ||  is_uploaded_file($_FILES['file']['tmp_name'])    )  {
        $Image = new Image(300, 200, 1000000, 'posts', $_FILES);

        if ( empty( $Image->getMessage()) )
        {
            $imageName = $Image->getNewImageName();
            $this->Post->save($_POST, $imageName); 
        }
    }
    else 
    {
        $this->Post->save($_POST);  //echo json_encode($_POST);
    }
    $this->Post->countPosts(1);
   
    redirect("/posts");
   
    }

/*******************************************************************************************************************************************|
* EDIT POST     metodo = GET    route = post/id/edit                                                                                        |                                          
* Per avere accesso a questo metodo bisogna avere il campo 'user_type' uguale a 'administrator' nella tabella 'users'                       |
* Al login $_SESSION['user_type'] prende il valore del campo 'user_type' e se è uguale a 'administrator' si può accedere a questo metodo    |                                                      |
* Il controllo su $_SESSION['user_type'] si trova nel template 'app\views\view-blog\post.single.tpl.php'                                    |                                                           
********************************************************************************************************************************************/
public function editPost($postid){

    $post = $this->Post->edit($postid); 
    $files=['navbar-blog', 'post.edit'];
    $this->content = View('blog', $files, compact('post'));
}

/***********************************************************************************************|
* UPDATE POST       metodo = POST    route = post/update                                        |
* aggiorniamo/modifichiamo i dati del post (titolo, immagine, messaggio)                        |
* l'id lo otteniamo tramite il tag input che è type=hidden quindi è compreso nel array $_POST   | 
************************************************************************************************/
public function updatePost($postid){

    try {    
       // var_dump($_POST);
        $r = $this->Post->update($postid, $_POST); 
      //  var_dump($r);
        redirect("/posts"); 

    } catch ( PDOException $e ) {
        
        return $e->getMessage();
    }

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

            redirect("/posts"); 

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

/*******************************************************************************************************************************************|
* DELETE SINGLE COMMENT          metodo = GET    path = comment/id/delete                                                                   |             
* Per avere accesso a questo metodo bisogna essere amministratore/proprietario di questo sito/blog                                          |
* Quando si fa il login viene assegnato il proprio numero id corrispondente alla propria email alla variabile globale $_SESSION['user_id']  | 
* Quindi se $_SESSION['user_id'] è uguale a 1 allora possiamo accedere a questo metodo.                                                     |
* Il controllo su $_SESSION['user_id'] si trova nel template 'app\views\view-blog\post.single.tpl.php'                                      |                                                        
********************************************************************************************************************************************/
public function deleteComment($commentid){

    $Comment = new Comment($this->conn); // istanziamo la classe Comment

    $postid = $Comment->getId('post_id', $commentid);
    $userid = $Comment->getId('user_id', $commentid);
   
  
    $Comment->userNumComments(-1, $userid);
    $Comment->postNumComments(-1, $postid);

    $Comment->deleteOne($commentid); // prendiamo solo il commento che ha il suo id univoco
    redirect("/posts"); 
}    

} // chiude classe PostController

