<?php
namespace App\Models;
use \PDO;

/*
* In questa classe ritorniamo le SELECT al database
*
*/

class Post
{
    protected $conn;

    public function __construct(PDO $conn){
        
        $this->conn = $conn;
        //var_dump($this->conn);
       // $posts =  $this->conn->query('SELECT * FROM posts')->fetchAll(PDO::FETCH_OBJ); // prendiamo tutti i post dal database
    }
    




    
    public function all(){
        
       // $stm = $this->conn->query('SELECT * FROM posts')->fetchAll(PDO::FETCH_OBJ); // prendiamo tutti i post dal database
        $result = [];
         // prendiamo dal tutti i post dal più vecchio al più recente 
        $stm = $this->conn->query('SELECT * FROM posts ORDER BY datecreated DESC');
        if ( $stm ){
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
        }
        return $result;
    }






    public function find($id){
        $result = [];

        $sql = 'SELECT * FROM posts WHERE id = :id';
      
        $stm = $this->conn->prepare($sql); 

        $stm->execute(['id'=>$id]); 

        if ( $stm ){
            $result = $stm->fetch(PDO::FETCH_OBJ);
        }
       // var_dump($result);
        return $result;
     }
    





public function save(array $data=[], string $image){

$sql = 'INSERT INTO posts (title, image, message, datecreated, email, username ) VALUES (:title, :image, :message, :datecreated, :email, :username)';
$stm = $this->conn->prepare($sql); 
$stm->execute([ 
    'title'=> $data['title'], 
    'image'=> $image, 
    'message'=>$data['message'], 
    'datecreated'=>date('Y-m-d H:i:s'), 
    'email'=>$_SESSION['email'], //  'email'=>$data['email']
    'username'=>$_SESSION['name'],
]); 

return $stm->rowCount();
}



     public function store(array $data=[]){
        
        $sql = 'UPDATE posts SET title = :title, message = :message, email = :email  WHERE id = :id';
        $stm = $this->conn->prepare($sql); 
        $stm->execute([ 
            'id' => $data['id'],
            'title'=> $data['title'], 
            'message'=>$data['message'],  
            'email'=>$data['email'] 
            ]); 
     
            return $stm->rowCount();
     }




     public function deleteOne(int $id){
        // cancelliamo il post
        
        $sql = 'DELETE FROM posts WHERE id = :id';
        $stm = $this->conn->prepare($sql); 
        $stm->bindParam(':id', $id, PDO::PARAM_INT); // gli diciamo che deve essere di tipo integer 
        $stm->execute(); 


        // // cancelliamo tutti i commenti relativi al post appena cancellato
        // $sql = 'DELETE FROM postscomments WHERE post_id = :id'; //
        // $stm = $this->conn->prepare($sql); 
        // $stm->bindParam(':id', $id, PDO::PARAM_INT); 
        // $stm->execute(); 

     
        return $stm->rowCount();
     }
 



}

?>