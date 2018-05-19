<?php
namespace App\Controllers;

//use \PDO; // importiamo le classi 'PDO' e 'Post'
use App\Models\Post;
use App\Models\Comment;
use App\Models\Image;
use \PDO; // importiamo le classi 'PDO' e 'Post'


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

        //$posts = $this->Post->all(); // prendiamo tutti i post dal database 
     
        $totalPosts = $this->Post->totalPosts(); // ottiene il numero totale di posts
        if ( empty($totalPosts ) ) { 

            //$files=['navbar-blog', 'post.all'];
           // $this->content = View('blog', $files, compact('posts')); 
            $files=['navbar-blog', 'post.empty'];
            $this->content = View('blog', $files);

         } else {
            $posts = $this->Post->all(); // prendiamo tutti i post dal database 
            $files=['navbar-blog', 'post.all', $this->device.'.pagination'];
            $page = 1;
            $this->content = View('blog', $files, compact('posts', 'page', 'totalPosts')); 
         }
       
      //  $files=['navbar-blog', 'post.all', $this->device.'.pagination'];
       // $page = 1;
      //  $this->content = View('blog', $files, compact('posts', 'page', 'totalPosts'));  

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




   // $files=['navbar-blog', 'post.all', $this->device.'.pagination'];
  //  $this->content = View('blog', $files, compact('posts', 'page', 'totalPosts'));  
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
        $Image = new Image(300, 200, 1000000, 'posts', $_FILES); // (int $max_width, int $max_height, int $max_size, string $folder, array $data )

        if ( empty( $Image->getMessage()) )
        {
            $imageName = $Image->getNewImageName();
            $this->Post->save($_POST, $imageName); // salviamo il post creato nel database 
        }
    }
    else 
    {
        $this->Post->save($_POST);  //echo json_encode($_POST);
    }
    $this->Post->countPosts(1);
   
    redirect("/posts"); // redirect è una funzione che fa il redirect nella home
   
    }

/*******************************************************************************************************************************************|
* EDIT      metodo = GET    path =  post/id/edit                                                                                            |                                          
* Per avere accesso a questo metodo bisogna essere amministratore/proprietario di questo sito/blog                                          |
* Quando si fa il login viene assegnato il proprio numero id corrispondente alla propria email alla variabile globale $_SESSION['user_id']  | 
* Quindi se $_SESSION['user_id'] è uguale a 1 allora possiamo accedere a questo metodo.                                                     |
* Il controllo su $_SESSION['user_id'] si trova nel template 'app\views\view-blog\post.single.tpl.php'                                      |                                                          
********************************************************************************************************************************************/
public function edit($postid){

    $post = $this->Post->find($postid); // prendiamo tutti i post dal database 
    $files=['navbar-blog', 'post.edit'];
    $this->content = View('blog', $files, compact('post')); // con la funzione helpers/View ritorniamo il template con i post all' interno
   
}

/***********************************************************************************************|
* UPDATE    metodo = POST    path = post/update                                                 |
* aggiorniamo/modifichiamo i dati del post (titolo, immagine, messaggio)                        |
* l'id lo otteniamo tramite il tag input che è type=hidden quindi è compreso nel array $_POST   | 
************************************************************************************************/
public function update(){

    try {    

        $result = $this->Post->store($_POST); // salviamo il post creato nel database 
        redirect("/posts"); // redirect è una funzione che fa il redirect nella home

    } catch ( PDOException $e ) {
        
        return $e->getMessage();
    }

}



    
/*******************************************************************************************************************************************|
* DELETE         metodo = GET    path =  post/id/delete                                                                                     |                                              
* Per avere accesso a questo metodo bisogna essere amministratore/proprietario di questo sito/blog                                          |
* Quando si fa il login viene assegnato il proprio numero id corrispondente alla propria email alla variabile globale $_SESSION['user_id']  | 
* Quindi se $_SESSION['user_id'] è uguale a 1 allora possiamo accedere a questo metodo.                                                     |
* Il controllo su $_SESSION['user_id'] si trova nel template 'app\views\view-blog\post.single.tpl.php'                                      |                                                          
********************************************************************************************************************************************/
    public function delete($id){
      
            try {    

                $result = $this->Post->deleteOne((int)$id); // cancelliamo il post creato dal database 
                $this->Post->countPosts(-1);
                $comment = new Comment($this->conn); // istanziamo la classe Comment
                $comment->deleteAll((int)$id);


                redirect("/posts"); // redirect è una funzione che fa il redirect nella home

            } catch ( PDOException $e ) {
                
                return $e->getMessage();
            }
    }





/***********************************************************************************************************|
* SAVE-COMMENT      metodo = POST    path = post/id/comment                                                 |                                                                                      
* Salviamo il commento relativo a un determinato id di un post che passiamo come argomento a questo metodo  |
* Oltre al commento salviamo anche l'id del post nella colonna post_id della tabella 'comments'             |
************************************************************************************************************/
public function saveComment($postid) {

  
    $postid = (int)$postid;
        
    $comment = new Comment($this->conn);
    $_POST['post_id'] = $postid;
    $comment->save($_POST); 
    
    $this->Post->countPosts(1);
    $this->Post->totalComments($postid, 1);

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

    $comment = new Comment($this->conn); // istanziamo la classe Comment

    $postid = $comment->getPostId($commentid);
  
    $this->Post->totalComments($postid, -1);
    $comments =  $comment->deleteOne($commentid); // prendiamo solo il commento che ha il suo id univoco
    redirect("/posts"); 
}    

} // chiude classe PostController

