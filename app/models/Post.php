<?php
namespace App\Models;
use \PDO;


class Post
{
    protected $conn;

    public function __construct(PDO $conn){
        
        $this->conn = $conn;
    }
    


    
/*******************************************************************************************************|
* ALL                                                                                                   |
* Facciamo una JOIN tra posts e users per ottenere tutti i posts con i dati dell' autore del post       |
* dalla tabella posts prendiamo [post_ID, title, datecreated, message]                                       |
* dalla tabella users prendiamo [user_email, user_name]                                                 |
* la relazione tra le tabelle posts e users è il campo posts.user_id e users.ID                         |
* in questo modo per ogni post abbiamo accesso ai dati dell'utente che ha scritto quel determinato post |                                              |
********************************************************************************************************/
    public function all(){
    
        $sql = 'SELECT * FROM posts INNER JOIN users WHERE posts.user_id = users.ID ORDER BY posts.datecreated DESC LIMIT 0, 2';

        $stm = $this->conn->query( $sql);
        if ( $stm ){

            $res = $stm->fetchAll(PDO::FETCH_OBJ);

            return $res;
        }
    }



        
/*******************************************************************************************************|
* PAGE POSTS                                                                                            |
* Facciamo una JOIN tra posts e users per ottenere tutti i posts con i dati dell' autore del post       |
* dalla tabella posts prendiamo [post_ID, title, datecreated, message]                                  |
* dalla tabella users prendiamo [user_email, user_name]                                                 |
* la relazione tra le tabelle posts e users è il campo posts.user_id e users.ID                         |
* in questo modo per ogni post abbiamo accesso ai dati dell'utente che ha scritto quel determinato post |                                              |
********************************************************************************************************/
public function pagePosts($postStart){
  
    //$sql = "SELECT * FROM posts INNER JOIN users WHERE posts.user_id = users.ID ORDER BY posts.datecreated DESC LIMIT $postStart, 2";
    $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.ID ORDER BY posts.datecreated DESC LIMIT $postStart, 2";


    $stm = $this->conn->query( $sql);
    if ( $stm ){

        $res = $stm->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }
}


/*******************************************************************************************************|
* TOTAL POSTS                                                                                           |
* questo metodo verrà richiamato solo per la pagina posts/blog per creare la paginazione                |
* Otteniamo il numero totale in assoluto di tutti i post presenti nella tabella 'posts'                 |
* Lo scopo è quello di calcolare il numero di pagine per i post                                         |
* es se abbiamo 30 post e vogliamo che vengano visualizzati 3 post ogni pagina                          |
* allora faremo 30post / 3 che ci darà 10 pagine. in questo modo potremo fare la paginazione            |
********************************************************************************************************/
public function totalPosts(){
    
    $sql = 'SELECT COUNT(*) FROM posts';
    if ($res = $this->conn->query($sql)) {
        $rows= $res->fetchColumn();
        return $rows;
    }
}




/***************************************************************************************|
* FIND !                                                                                |
****************************************************************************************/
    public function find($postid){
        
        $sql = 'SELECT * FROM posts INNER JOIN users WHERE posts.user_id = users.ID AND posts.post_ID = :postid ORDER BY posts.datecreated DESC';
      
        $stm = $this->conn->prepare($sql); 

        $stm->execute(['postid'=>$postid]); 

        if ( $stm ){
            $result = $stm->fetch(PDO::FETCH_OBJ);
        }
        return $result;
     }
    


/***************************************************************************************|
* EDIT                                                                                  |
****************************************************************************************/
public function edit($postid){
        
    $sql = 'SELECT * FROM posts WHERE post_ID = :postid LIMIT 1';
    $stm = $this->conn->prepare($sql); 
    $stm->bindParam(':postid', $postid, PDO::PARAM_INT);
    $stm->execute(); 
    if ( $stm ) {
        $result = $stm->fetch(PDO::FETCH_OBJ);
        return $result;
    }
 }


/***************************************************************************************|
* UPDATE                                                                                |
* Modifica un post creato in precedenza                                                 |
****************************************************************************************/
public function update(int $postid, array $data=[]){
        
    $messtruncate = truncate_words($data['message'], 10, '[...]'); 
    $sql = 'UPDATE posts SET title = :title, message = :message, messtruncate = :messtruncate WHERE post_ID = :id';
    $stm = $this->conn->prepare($sql); 
    $stm->bindParam(':title',$data['title'], PDO::PARAM_STR, 255);
    $stm->bindParam(':message',$data['message'], PDO::PARAM_STR);
    $stm->bindParam(':messtruncate', $messtruncate, PDO::PARAM_STR, 255);
    $stm->bindParam(':id', $postid, PDO::PARAM_INT);
    $stm->execute();
   // return $stm->rowCount();
 }


/***************************************************************************************|
* SAVE                                                                                  |
* Salviamo nel database 
****************************************************************************************/
public function save(array $data=[], string $image=''){

$messtruncate = truncate_words($data['message'], 10, '[...]'); 
$datecreated = date('Y-m-d H:i:s');
$dateformatted = dateFormatted($datecreated);
$sql = 'INSERT INTO posts (user_id, title, image, message, messtruncate, datecreated, dateformatted) VALUES (:user_id, :title, :image, :message, :messtruncate, :datecreated, :dateformatted)';
$stm = $this->conn->prepare($sql); 
$stm->execute([ 
    'user_id'=> $_SESSION['user_id'],
    'title'=> $data['title'], 
    'image'=> $image, 
    'message'=>$data['message'], 
    'messtruncate'=>$messtruncate, 
    'datecreated'=>$datecreated,
    'dateformatted'=>$dateformatted,
]); 

return $stm->rowCount();
}




/*******************************************************************************************************************|
* COUNT-POSTS                                                                                                       |
* questo metodo incrementa o decrementa il numero dei post del campo 'user_num_posts' della tabella users           |                          
* a seconda se il secondo argomento passato sia 1 oppure -1                                                         |
* Avendo l'id 'users', per prima cosa faccimo una SELECT per ottenere il valore/numero del campo 'user_num_posts'   |
* quindi modifichiamo il valore del campo 'user_num_posts' e lo aggiorniamo/salviamo nel database con 'UPDATE'      |
********************************************************************************************************************/
public function countPosts(int $sign){
        
    $sql = "SELECT user_num_posts FROM users WHERE ID = :id";
    $stm = $this->conn->prepare($sql); 
    $stm->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stm->execute();
    if ( $stm ){
        if ($res = $stm->fetch(PDO::FETCH_OBJ)) {
            $num = (int)$res->user_num_posts;
            $num+= $sign;
            $sql = 'UPDATE users SET user_num_posts = :user_num_posts WHERE ID = :id';
            $stm = $this->conn->prepare($sql); 
            $stm->execute([ 
                'id'=>$_SESSION['user_id'],
                'user_num_posts'=> $num,   
            ]); 
        }
    }
 }  

/***************************************************************************************|
* DELETE-ONE                                                                            |
* cancelliamo un post                                                                   |
****************************************************************************************/
     public function deletePost(int $postid){
        
        $sql = 'DELETE FROM posts WHERE post_ID = :id';
        $stm = $this->conn->prepare($sql); 
        $stm->bindParam(':id', $postid, PDO::PARAM_INT); 
        $stm->execute(); 
     }
 



}

?>