<?php
namespace App\Controllers;

use \PDO; // importiamo le classi 'PDO' e 'Post'
use App\Models\Post;
use App\Models\Comment;



class PostController extends Controller
{
   
    protected $Post ;
    protected $conn;
    //protected $test;

    public function __construct(PDO $conn){ 
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->Post = new Post($conn);  // creiamo qui un istanza della classe 'Post' e gli passiamo la connessione al database
        $this->page = 'blog';
    }



/*******************|
*       GETPOSTS    |
********************/
    public function getPosts(){

        $posts = $this->Post->all(); // prendiamo tutti i post dal database 

        $files=['navbar-blog', 'post.all'];
        $this->content = View('blog', $files, compact('posts'));  // ritorniamo il template con il form per fare il Login

        // compact('posts') serve a passare $posts a questa funzione per inserirli nel template
        //  $this->content = View('posts', compact('posts')); // con la funzione helpers/View ritorniamo il template con i post all' interno
    }
    

/***************************************************************************************|
*       SHOW                                                                            |
* questa classe mostrerà un solo post e mostrerà tutti i commenti legati a questo post  |
****************************************************************************************/
    public function postSingle($postid){ 
      
        $post =  $this->Post->find($postid); // prendiamo il post con un determinato id dal database 
        $comment = new Comment($this->conn); // istanziamo la classe Comment
        $comments =  $comment->all($postid); // prendiamo tutti i commenti che hanno lo stesso id del post


        $files=['navbar-blog', 'post.single'];
        $this->content = View('blog', $files, compact('post','comments'));  // usando la funzione View ritorniamo il template con i post all' interno
      
    }







/***********************************************|
*       CREATE                                  |     
* Visualizza il form per scrivere un nuovo post |
************************************************/
    public function create(){
        $files=['navbar-blog', 'post.create'];
        $this->content = View('blog', $files );
    }



/*******************|
*       SAVE        |
********************/
    public function savePost(){

        $this->Post->save($_POST); // salviamo il post creato nel database 
        redirect("/posts"); // redirect è una funzione che fa il redirect nella home
        //echo json_encode($_POST);
       
    
    }



/*******************|
*       STORE       |
********************/
    public function store(string $id){

        try {    

            $result = $this->Post->store($_POST); // salviamo il post creato nel database 
            redirect("/posts"); // redirect è una funzione che fa il redirect nella home

        } catch ( PDOException $e ) {
            
            return $e->getMessage();
        }
    
    }

/***************************************************************************************************************************************|
* EDIT                                                                                                                                  |
* Per avere accesso a questo metodo bisogna essere amministratore/proprietario di questo sito/blog                                      |
* Quando si fa il login viene assegnato il proprio numero id corrispondente alla propria email alla variabile globale $_SESSION['id']   | 
* Quindi se $_SESSION['id'] è uguale a 1 allora possiamo accedere a questo metodo.                                                      |
* Il controllo su $_SESSION['id'] si trova nel template 'app\views\view-blog\post.single.tpl.php'                                       |                                                          |
****************************************************************************************************************************************/
public function edit($postid){

    $post = $this->Post->find($postid); // prendiamo tutti i post dal database 
    $files=['navbar-blog', 'post.edit'];
    $this->content = View('blog', $files, compact('post')); // con la funzione helpers/View ritorniamo il template con i post all' interno
   
}

    
/***************************************************************************************************************************************|
* DELETE                                                                                                                                |
* Per avere accesso a questo metodo bisogna essere amministratore/proprietario di questo sito/blog                                      |
* Quando si fa il login viene assegnato il proprio numero id corrispondente alla propria email alla variabile globale $_SESSION['id']   | 
* Quindi se $_SESSION['id'] è uguale a 1 allora possiamo accedere a questo metodo.                                                      |
* Il controllo su $_SESSION['id'] si trova nel template 'app\views\view-blog\post.single.tpl.php'                                       |                                                          |
****************************************************************************************************************************************/
    public function delete($id){
      
            try {    

                $result = $this->Post->deleteOne((int)$id); // salviamo il post creato nel database 

                $comment = new Comment($this->conn); // istanziamo la classe Comment
                $comment->deleteAll((int)$id);


                redirect("/posts"); // redirect è una funzione che fa il redirect nella home

            } catch ( PDOException $e ) {
                
                return $e->getMessage();
            }
    }


/***************************************************************************************************************************************|
* DELETE SINGLE COMMENT                                                                                                                               |
* Per avere accesso a questo metodo bisogna essere amministratore/proprietario di questo sito/blog                                      |
* Quando si fa il login viene assegnato il proprio numero id corrispondente alla propria email alla variabile globale $_SESSION['id']   | 
* Quindi se $_SESSION['id'] è uguale a 1 allora possiamo accedere a questo metodo.                                                      |
* Il controllo su $_SESSION['id'] si trova nel template 'app\views\view-blog\post.single.tpl.php'                                       |                                                          |
****************************************************************************************************************************************/
public function deleteComment($commentid){


    $comment = new Comment($this->conn); // istanziamo la classe Comment
    $comments =  $comment->deleteOne($commentid); // prendiamo solo il commento che ha il suo id univoco

    redirect("/posts"); // redirect è una funzione che fa il redirect nella home
}    



/***********************|
*       SAVE-COMMENT    |
************************/
    public function saveComment($postid) {

        $comment = new Comment($this->conn);
        $_POST['post_id'] = (int) $postid;
        $comment->save($_POST); // salviamo il post creato nel database 
        redirect('/post/'.$postid); // redirect è una funzione che fa il redirect nella home
    }

    

} // chiude classe PostController

