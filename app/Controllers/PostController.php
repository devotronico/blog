<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Image;
use \PDO;

class PostController extends Controller
{
    protected $Post ;
  
    public function __construct(PDO $conn) { 
  
        parent::__construct(); 
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->Post = new Post($conn);  // creiamo qui un istanza della classe 'Post' e gli passiamo la connessione al database
       
    }

/*******************************************************************************************************************|
* GETPOSTS          metodo = GET    path = posts/page/id                                                            |
* Otteniamo tutti i post di una pagina                                                                              |     
* Se ci sono i post allora viene caricato anche il template della paginazione                                       |   
* Spiegazione Paginazione                                                                                           |
* 'page' è la il numero della pagina in cui ci troviamo                                                             |
* 'postForPage' è il numero di post che ci sono per ogni pagina                                                     |
* 'postStart' è uguale al numero precedente del primo post della pagina in cui ci troviamo                          |
* Se ci troviamo nella pagina 3 {'currentPage'=3} e abbiamo deciso che ogni pagina deve avere 2 post{'postForPage'=2}      |
* allora il primo post della terza pagina deve essere il post numero 4{'postStart'=4}                               |
* 1  2  3 pagine {'currentPage'}                                                                                           |
* 12 34 56 il numero dei post che visualizza se abbiamo impostato {'postForPage'=2}                                 |
* 0  2  4 sono i valori che ci servono per cominciare a contare i post da visualizzare {'postStart'}                |
********************************************************************************************************************/
public function getPosts($currentPage=1){ 
   
    $totalPosts = $this->Post->totalPosts();
    $link="posts";
    if ( empty($totalPosts ) ) { 
        $this->page = 'empty';
        $files=[$this->device.'.navbar-blog', 'post.empty'];
        $this->content = View('blog', $files, compact('link', 'page')); 

     } else {
        $this->page = 'blog';
        $postForPage = 3;  
        for ($i=0, $postStart=-$postForPage; $i<$currentPage; $postStart+=$postForPage, $i++);
        $posts = $this->Post->pagePosts($postStart, $postForPage); 
        $files=[$this->device.'.navbar-blog', 'post.all', $this->device.'.pagination'];
        $this->content = View('blog', $files, compact('link', 'posts', 'currentPage', 'totalPosts', 'postForPage')); 
     }
}
    

/***************************************************************************************|
* SHOW      metodo = GET    path = post/id                                              |
* questa classe mostrerà un solo post e mostrerà tutti i commenti legati a questo post  |
****************************************************************************************/
    public function postSingle($postid){ 
        $this->page = 'post';
        $post =  $this->Post->find($postid); // prendiamo il post con un determinato id dal database 
        $comment = new Comment($this->conn); // istanziamo la classe Comment
        $comments =  $comment->all($postid); // prendiamo tutti i commenti che hanno lo stesso id del post

        $files=[$this->device.'.navbar-blog', 'post.single'];
        $this->content = View('blog', $files, compact('post','comments'));  // usando la funzione View ritorniamo il template con i post all' interno
    }


/***************************************************|
* CREATE        metodo = GET    path = post/create  |                           
* Visualizza il form per creare un nuovo post       |
****************************************************/
    public function create(){
        $this->page = 'create';
        $bytes = 1000000;
        $megabytes = $bytes * 0.000001;
        $files=[$this->device.'.navbar-blog', 'post.create'];
        $link="create";
        $this->content = View('blog', $files, compact('link', 'megabytes')); 
    }


/***********************************************|
* SAVE      metodo = POST    path = post/save   |
* Salviamo un post nel database                 |
************************************************/
    public function savePost(){

    if ( !$_FILES['file']['error']  ||  is_uploaded_file($_FILES['file']['tmp_name']) )  {

        $bytes = 1000000;
        $Image = new Image('wFixed', 600, 10, $bytes, 'posts', $_FILES);

        if ( empty( $Image->getMessage()) )
        {
            $imageName = $Image->getNewImageName();
            $this->Post->save($_POST, $imageName); 
        } else {

            die ($Auth->getMessage());
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
public function editPost($postid) {
    $this->page = 'edit';
    $post = $this->Post->edit($postid); 
    $files=[$this->device.'.navbar-blog', 'post.edit'];
    $this->content = View('blog', $files, compact('post'));
}

/***********************************************************************************************|
* UPDATE POST       metodo = POST    route = post/update                                        |
* aggiorniamo/modifichiamo i dati del post (titolo, immagine, messaggio)                        |
* l'id lo otteniamo tramite il tag input che è type=hidden quindi è compreso nel array $_POST   | 
************************************************************************************************/
public function updatePost($postid) {

    try {    
        $r = $this->Post->update($postid, $_POST); 
   
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

