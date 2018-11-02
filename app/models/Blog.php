<?php
namespace App\Models;
use \PDO;


class Blog
{
    private $conn;
    private $message;

    public function __construct(PDO $conn){
        
        $this->conn = $conn;
    }
    

    public function getMessage()
    {
        return $this->message;
    }


    /***************************************************************************************|
     * LOGIN WITH COOKIE                                                                    |
     * Quando dalla home passiamo alla pagina del blog                                      |
     * se abbiamo il COOKIE allora viene fatto un login automatico.                         |
     * ci andiamo a prendere dalla tabella 'users' solo il valore del campo 'user_type'     |            
    ****************************************************************************************/
    public function loginWithCookie() {       

        $sql = 'SELECT ID, user_type, user_name FROM users WHERE ID = :id LIMIT 1';
        
        if ($stmt = $this->conn->prepare($sql)) 
        {
            $stmt->bindParam(':id', $_COOKIE['user_id'], PDO::PARAM_INT);
            if ($stmt->execute()) 
            {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['user_id'] = $user['ID']; 
                    $_SESSION['user_type'] = $user['user_type'];
                    $_SESSION['user_name'] = $user['user_name'];
            }
        }
    }

 
/*******************************************************************************************************|
* PAGE POSTS                                                                                            |
* Facciamo una JOIN tra posts e users per ottenere tutti i posts con i dati dell' autore del post       |
* dalla tabella posts prendiamo [post_ID, title, datecreated, message]                                  |
* dalla tabella users prendiamo [user_email, user_name]                                                 |
* la relazione tra le tabelle posts e users è il campo posts.user_id e users.ID                         |
* in questo modo per ogni post abbiamo accesso ai dati dell'utente che ha scritto quel determinato post |                                              
********************************************************************************************************/
public function pagePosts($postStart, $postForPage){
  
    $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.ID ORDER BY posts.datecreated DESC LIMIT $postStart, $postForPage";

    $stm = $this->conn->query($sql);
    if ( $stm ){

        $res = $stm->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }
}

/*******************************************************************************************************|
* PAGE POSTS [modificare la descrizione]                                                                |                          
* Facciamo una JOIN tra posts e users per ottenere tutti i posts con i dati dell' autore del post       |
* dalla tabella posts prendiamo [post_ID, title, datecreated, message]                                  |
* dalla tabella users prendiamo [user_email, user_name]                                                 |
* la relazione tra le tabelle posts e users è il campo posts.user_id e users.ID                         |
* in questo modo per ogni post abbiamo accesso ai dati dell'utente che ha scritto quel determinato post |                                              
********************************************************************************************************/
public function postsByDate($month, $year){
  

switch ( $month ) {

    case 'gennaio'  : $month = '01'; break;
    case 'febbraio' : $month = '02'; break;
    case 'marzo'    : $month = '03'; break;
    case 'aprile'   : $month = '04'; break;
    case 'maggio'   : $month = '05'; break;
    case 'giugno'   : $month = '06'; break;
    case 'luglio'   : $month = '07'; break;
    case 'agosto'   : $month = '08'; break;
    case 'settembre': $month = '09'; break;
    case 'ottobre'  : $month = '10'; break;
    case 'novembre' : $month = '11'; break;
    case 'dicembre' : $month = '12'; break;
}



    $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.ID WHERE MONTH(posts.datecreated) = $month AND YEAR(posts.datecreated) = $year ORDER BY posts.datecreated DESC";

 //   $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.ID WHERE DATENAME(month, $month) AS DatePartString; ORDER BY posts.datecreated DESC";

   
    $stm = $this->conn->query($sql);
    if ( $stm ){

        $res = $stm->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }
}



/*******************************************************************************************************|
* GET DATES                                                                                             |
* questo metodo verrà richiamato solo per la pagina posts/blog per creare la paginazione                |
* Otteniamo il numero totale in assoluto di tutti i post presenti nella tabella 'posts'                 |
* Lo scopo è quello di calcolare il numero di pagine per i post                                         |
* es se abbiamo 30 post e vogliamo che vengano visualizzati 3 post ogni pagina                          |
* allora faremo 30post / 3 che ci darà 10 pagine. in questo modo potremo fare la paginazione            |
********************************************************************************************************/
public function getDates(){
    
    $sql = 'SELECT dateformatted FROM posts';
    if ($stm = $this->conn->query($sql)) {
        $dates = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $dates;
    }
}



/*******************************************************************************************************|
* TOTAL POSTS                                                                                           |
* questo metodo verrà richiamato solo per la pagina posts/blog per creare la paginazione                |
* Otteniamo il numero totale in assoluto di tutti i post presenti nella tabella 'posts'                 |
* Lo scopo è quello di calcolare il numero di pagine per i post                                         |
* es. se abbiamo 30 post e vogliamo che vengano visualizzati 3 post ogni pagina                         |
* allora faremo 30post / 3 che ci darà 10 pagine. in questo modo potremo fare la paginazione            |
********************************************************************************************************/
public function totalPosts(){
    
    $sql = 'SELECT COUNT(*) FROM posts';
    if ($res = $this->conn->query($sql)) {
        $rows= $res->fetchColumn();
        return $rows;
    }
}



} // chiude classe Blog

?>