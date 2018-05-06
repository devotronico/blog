<?php
namespace App\Models;
use \PDO;

/*
* 
*
*/

class Comment
{
    
    protected $conn;


    public function __construct(PDO $conn){
        
        $this->conn = $conn;
        //var_dump($this->conn);
       // $posts =  $this->conn->query('SELECT * FROM posts')->fetchAll(PDO::FETCH_OBJ); // prendiamo tutti i post dal database
    }
    



/***********************|
*           ALL         |
************************/    
    public function all(int $postid){
        
      
        $result = [];
        $sql = 'SELECT * FROM postscomments WHERE post_id = :postid ORDER BY datecreated DESC';
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(':postid', $postid, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
      
    }





/***********************|
*           SAVE        |
************************/ 
public function save(array $data=[]){
    
    $sql = 'INSERT INTO postscomments (post_id, comment, datecreated, email, username ) VALUES (:post_id, :comment, :datecreated, :email, :username)';
    $stm = $this->conn->prepare($sql); 
    $stm->execute([ 
        'post_id'=> $data['post_id'], 
        'comment'=>$data['comment'], 
        'datecreated'=>date('Y-m-d H:i:s'), 
        'email'=>$_SESSION['email'], //   $_SESSION['email'] = $user['user_email'];
        'username'=>$_SESSION['name']
        ]); 
    
    return $stm->rowCount();
    }


    public function deleteAll(int $postid){
       // cancelliamo tutti i commenti relativi al post appena cancellato
       $sql = 'DELETE FROM postscomments WHERE post_id = :id'; //
       $stm = $this->conn->prepare($sql); 
       $stm->bindParam(':id', $postid, PDO::PARAM_INT); 
       $stm->execute(); 
    }


// cancelliamo solo il commento che ha il suo id univoco
    public function deleteOne(int $commentid){
        $sql = 'DELETE FROM postscomments WHERE id = :id'; 
        $stm = $this->conn->prepare($sql); 
        $stm->bindParam(':id', $commentid, PDO::PARAM_INT); 
        $stm->execute(); 
     }


    }




