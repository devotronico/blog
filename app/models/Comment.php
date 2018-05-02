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
        
        $sql = 'INSERT INTO postscomments (post_id, comment, datecreated, email ) VALUES (:post_id, :comment, :datecreated, :email)';
        $stm = $this->conn->prepare($sql); 
        $stm->execute([ 
            'post_id'=> $data['post_id'], 
            'comment'=>$data['comment'], 
            'datecreated'=>date('Y-m-d H:i:s'), 
            'email'=>$data['email'] 
            ]); 
     
        return $stm->rowCount();
     }






    }




/*  
    public function delete(int $id){

        $sql = 'DELETE FROM posts WHERE id = :id';
        $stm = $this->conn->prepare($sql); 
        $stm = bindParam(':id', $id, PDO::PARAM_INT); // gli diciamo che deve essere di tipo integer 
        $stm->execute(); 

        return $stm->rowCount();
    }
*/

    /*
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
    */



/*
     public function store(array $data=[]){
        
        $sql = 'UPDATE posts SET title = :title, text = :text, email = :email  WHERE id = :id';
        $stm = $this->conn->prepare($sql); 
        $stm->execute([ 
            'id' => $data['id'],
            'title'=> $data=['title'], 
            'text'=>$data=['text'],  
            'email'=>$data=['email'] 
            ]); 
     
            return $stm->rowCount();
     }

*/
/*


 */


