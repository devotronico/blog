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
* La colonna 'post_id' della tabella 'Comments' è uguale/collegato alla colonna 'id' della tabella posts                                                       |
* Quindi per ottenere tutti i commenti relativi a un singolo post dobbiamo passare come argomento a questo metodo l' id del post che                                |
* ricaviamo dal url.                                                                                                                                                |
* Oltre ai commenti ci occorrono anche i dati della tabella 'users'(user_image, user_name, user_email) per avere le info sull' autore che ha scritto il commento.   |
* La colonna 'user_id' di 'Comments' è collegata alla colonna ID di users                                                                                      |
* Quindi per ottenere contemporaneamente i dati dalle tabelle 'Comments' e 'users' facciamo una 'Inner Join'                                                   |
********************************************************************************************************************************************************************/    
    public function all(int $postid){
        $sql = 'SELECT * FROM Comments INNER JOIN users WHERE Comments.user_id = users.ID AND Comments.post_id = :postid ORDER BY c_datecreated DESC';
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(':postid', $postid, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function total(int $postid){
        $sql = 'SELECT * FROM Comments WHERE post_id = postid';
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(':postid', $postid, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
    }


/***************************************************************************************************************************|
* SAVE   url = /post/:id/comment                                                                                            |
* Salviamo un commento nella tabella 'Comments'                                                                        |
* il valore della colonna 'post_id' lo prendiamo dal URL ':id',                                                             |
* 'post_id' ci serve per relazionare questo commento a un determinato post cioè il post in cui l'utente va a commentare.    |
* 'user_id' ci serve per relazionare questo commento a un determinato uente cioè all'autore che ha scritto questo commento. |
* 'c_datecreated' è la data di creazione del commento e la otteniamo con la funzione date.                                    |
****************************************************************************************************************************/ 
public function save(array $data=[]){
    
    $c_datecreated = date('Y-m-d H:i:s');
    $c_dateformatted = dateFormatted($c_datecreated);
    $sql = 'INSERT INTO Comments (post_id, user_id, comment, c_datecreated, c_dateformatted) VALUES (:post_id, :user_id, :comment, :c_datecreated, :c_dateformatted)';
    $stm = $this->conn->prepare($sql); 
    $stm->execute([ 
        'post_id'=> $data['post_id'], 
        'user_id'=> $_SESSION['user_id'], 
        'comment'=>$data['comment'], 
        'c_datecreated'=>$c_datecreated,
        'c_dateformatted'=>$c_dateformatted,
        ]); 
    
    return $stm->rowCount();
    }

/*******************************************************************************************************************|
* SAVE   url = "/post/:id/delete"                                                                                   |
* Se l'utente è l'amministratore può cancellare un post,                                                            |
* e di conseguenza verranno cancellati anche tutti i commenti relativi al post cancellato.                          |
* questo viene fatto ottenendo dall URL :id che consente una relazione tra le tabelle posts e Comments tramite |
* i loro rispettivi campi/colonne 'id'(posts) e 'post_id'(Comments)                                            |
********************************************************************************************************************/ 
    public function deleteAll(int $postid){

       $sql = 'DELETE FROM Comments WHERE post_id = :id';
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

        $sql = 'DELETE FROM Comments WHERE comment_ID = :id'; 
        $stm = $this->conn->prepare($sql); 
        $stm->bindParam(':id', $commentid, PDO::PARAM_INT); 
        $stm->execute(); 
     }


/***********************************************************************************************************************************|
* GET POST ID                                                                                                                       |
* Con l'id della tabella Comments ci andiamo a prendere il valore del campo post_id che è relativo all'id della tabella posts  |                                                                                                  
************************************************************************************************************************************/ 
     public function getPostId(int $commentid){

        $sql = 'SELECT post_id FROM Comments WHERE comment_ID = :id';
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(':id', $commentid, PDO::PARAM_INT);
        $stm->execute();
        $res= $stm->fetch(PDO::FETCH_ASSOC);
        $post_id = (int)$res['post_id'];
        return $post_id;
    }



    }




