<?php
namespace App\Models;
use \PDO;



class Comment
{
    protected $conn;

    public function __construct(PDO $conn){
        
        $this->conn = $conn;
    }


/*******************************************************************************************************************************************************************|
* ALL                                                                                                                                                               |
* La colonna 'post_id' della tabella 'postscomments' è uguale/collegato alla colonna 'id' della tabella posts                                                       |
* Quindi per ottenere tutti i commenti relativi a un singolo post dobbiamo passare come argomento a questo metodo l' id del post che                                |
* ricaviamo dal url.                                                                                                                                                |
* Oltre ai commenti ci occorrono anche i dati della tabella 'users'(user_image, user_name, user_email) per avere le info sull' autore che ha scritto il commento.   |
* La colonna 'user_id' di 'postscomments' è collegata alla colonna ID di users                                                                                      |
* Quindi per ottenere contemporaneamente i dati dalle tabelle 'postscomments' e 'users' facciamo una 'Inner Join'                                                   |
********************************************************************************************************************************************************************/    
    public function all(int $postid){
        $sql = 'SELECT * FROM postscomments INNER JOIN users WHERE postscomments.user_id = users.ID AND postscomments.post_id = :postid ORDER BY datecreated DESC';
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(':postid', $postid, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
    }




/***************************************************************************************************************************|
* SAVE   url = /post/:id/comment                                                                                            |
* Salviamo un commento nella tabella 'postscomments'                                                                        |
* il valore della colonna 'post_id' lo prendiamo dal URL ':id',                                                             |
* 'post_id' ci serve per relazionare questo commento a un determinato post cioè il post in cui l'utente va a commentare.    |
* 'user_id' ci serve per relazionare questo commento a un determinato uente cioè all'autore che ha scritto questo commento. |
* 'datecreated' è la data di creazione del commento e la otteniamo con la funzione date.                                    |
****************************************************************************************************************************/ 
public function save(array $data=[]){
    
    $sql = 'INSERT INTO postscomments (post_id, user_id, comment, datecreated) VALUES (:post_id, :user_id, :comment, :datecreated)';
    $stm = $this->conn->prepare($sql); 
    $stm->execute([ 
        'post_id'=> $data['post_id'], 
        'user_id'=> $_SESSION['user_id'], 
        'comment'=>$data['comment'], 
        'datecreated'=>date('Y-m-d H:i:s'), 
        ]); 
    
    return $stm->rowCount();
    }

/*******************************************************************************************************************|
* SAVE   url = "/post/:id/delete"                                                                                   |
* Se l'utente è l'amministratore può cancellare un post,                                                            |
* e di conseguenza verranno cancellati anche tutti i commenti relativi al post cancellato.                          |
* questo viene fatto ottenendo dall URL :id che consente una relazione tra le tabelle posts e postscomments tramite |
* i loro rispettivi campi/colonne 'id'(posts) e 'post_id'(postscomments)                                            |
********************************************************************************************************************/ 
    public function deleteAll(int $postid){
       $sql = 'DELETE FROM postscomments WHERE post_id = :id';
       $stm = $this->conn->prepare($sql); 
       $stm->bindParam(':id', $postid, PDO::PARAM_INT); 
       $stm->execute(); 
    }


/***************************************************************************************************************************|
* SAVE   url = '/comment/:id/delete'                                                                                        |
* Se l'utente è l'amministratore può cancellare qualsiasi commento, uno alla volta, tramite l'id univoco del commento       |
* che otteniamo dal URL                                                                                                     |
****************************************************************************************************************************/ 
    public function deleteOne(int $commentid){
        $sql = 'DELETE FROM postscomments WHERE id = :id'; 
        $stm = $this->conn->prepare($sql); 
        $stm->bindParam(':id', $commentid, PDO::PARAM_INT); 
        $stm->execute(); 
     }


    }




