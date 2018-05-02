<?php
namespace App\Controllers;
use \PDO; // importiamo le classi 'PDO' e 'Post'
use App\Models\Post;
use App\Models\Comment;
use App\Models\Auth;


class PostController
{
    protected $layout = 'layout/index.tpl.php'; // percorso del layout completo
    protected $content = 'Broli Manzi'; // $content viene chiamato nel template 'layout/index.tpl.php'
    protected $conn;
    protected $Post;
    protected $style;
    protected $grid = 'container';
    

    public function __construct(PDO $conn){ 

        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
       
        $this->Post = new Post($conn);  // creiamo qui un istanza della classe 'Post' e gli passiamo la connessione al database
       // $this->Auth = new Auth($conn, $_POST);  // creiamo qui un istanza della classe 'Auth' e gli passiamo la connessione al database
       //$this->Auth = new Auth($this->conn, $_POST);
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
            $this->style = 'mobile'; 
        } else {
            $this->style = 'desktop';      
        }
    }


/***************************************************************************|
* DISPLAY                                                                   |
* la variabile 'layout' contiene il file 'layout/index.tpl.php' che mostra  |
* il layout completo che è sempre uguale per ogni pagina del sito.          |
* All' interno del file 'layout/index.tpl.php' cè la variabile 'content'    | 
* che contiene un template diverso in base alla rotta che c'è nel browser   |
****************************************************************************/
    public function display(){
        require $this->layout;   
    }
    
   
//====================================================================================================== 
//========== FRONT PAGE ========================= FRONT PAGE ===========================================
//======================================================================================================     

/*******************|
*       HOME        |
********************/
public function home(){

        $this->grid = 'container-fluid';
        $this->content = View('signup', compact('message')); // ritorniamo il template con il form per fare la registrazione
        $files=['navbar-home', 'cover', 'portfolio', 'skills', 'form', 'footer'];
        $this->content = View('home', $files);
}

//====================================================================================================== 
//========== AUTHENTICATION ========================= AUTHENTICATION ===================================
//====================================================================================================== 

/*******************************************************************************************************|
* SIGNUP GROUP                                                                                          | 
********************************************************************************************************/

/*******************************************************************|
* SIGNUP FORM  [ route='auth/signup/form' => method=signupForm ]    |
* Se si clicca sul link signup che sta nella Navbar carica il       |
* template del Form per fare la registrazione                       |
* Al submit del form attiviamo il metodo 'signupStore'              |
********************************************************************/
public function signupForm(){ // 
 
    $message = isset($_GET['message']) ? $_GET['message'] : '';

    $files=['navbar-auth', 'signup.form'];
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
}

/***********************************************************************************************|
* SIGNUP STORE    [  route='auth/signup/store' => method='signupStore' ]                        |
* Con il submit del form con il metodo POST                                                     |
* se i dati del form {email e password} sono validi si salvano nel database                     | 
* e il sistema invierà una Mail all'utente con un link che contiene i parametri email e hash    |                                    
************************************************************************************************/
public function signupStore(){ // 
    $Auth = new Auth($this->conn, $_POST);  // creiamo qui un istanza della classe 'Auth' e gli passiamo la connessione al database
    // come argomento del metodo signup($_POST) della classe Auth passiamo i dati che sono un array di chiavi valori {$_POST['email'], $_POST['password'] }
    $Auth->signup(); 

   // preleviamo dalla classe Auth la variabile $message - se non cè - allora la 
   //registrazione ha avuto successo e verrà visualizzato il messaggio che
   // ci avvisa che ci ci è stata inviata una mail per confermare l'account
    if (  empty( $Auth->getMessage()) )
    {
        $message =  "Abbiamo mandato una email di attivazione a <strong>".$_POST['user_email']."</strong>. Per favore segui le istruzioni contenute nell'email per attivare il tuo account. Se l'email non ti arriva, controlla la tua cartella spam o prova a collegarti ancora per inviare un'altra email di attivazione.";
        $files=['navbar-auth', 'signup.success'];
        $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    }
    else
    {
        $message = $Auth->getMessage(); // redirect("/auth/signup/store?message=$message");
        $files=['navbar-auth', 'signup.form'];
        $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    }  
}


/***********************************************************************************************|
* SIGNUP VERIFY    [  route='auth/signup/verify'=> method='signupVerify' ]                      |                                                              
* Quando all'interno della Mail clicchiamo il link verremo indirizzati di nuovo sul sito per    |
* verificare se i parametri del link siano validi e se l'account non era già stato attivato.    |
* Se è andato tutto bene verremo loggati                                                        |
************************************************************************************************/
public function signupVerify() {  
    $Auth = new Auth($this->conn, $_GET);
    $Auth->signupEmailActivation(); 
 
    $message = !empty( $Auth->getMessage()) ? $Auth->getMessage() : "Registrazione avvenuta con successo!";

    $files=['navbar-auth', 'signup.verify'];            
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template views\view-auth\verify.tpl.php
}




/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++| 
* SIGNIN GROUP                                                                                         | 
*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++/



/*******************************************************************|
* SIGNIN FORM  [ route='auth/signin/form' => method='signinForm' ]  |                          
* Se si clicca sul link signin che sta nella Navbar                 |
* Carica il template del Form per fare il Login                     |
********************************************************************/
public function signinForm(){    
    $message = isset($_GET['message']) ? $_GET['message'] : '';
    $files=['navbar-auth', 'signin.form'];
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare il Login
}


/***********************************************************************|
* SIGNIN ACCESS [ route='auth/signin/access' => method='signinAccess' ] |     
************************************************************************/
public function signinAccess(){  //    
$Auth = new Auth($this->conn, $_POST);
// come argomento del metodo signin($_POST) della classe Auth passiamo i dati che sono un array di chiavi valori {$_POST['email'], $_POST['password'] }
$email = $Auth->signin(); 
   
// preleviamo dalla classe Auth la variabile $message - se non cè - allora 
// il login ha avuto successo e verrà visualizzato il messaggio che ce lo confermerà
if (  empty( $Auth->getMessage()) )
{
    if (isset($_SESSION['id'])): 
        $message = "Login effettuato con Successo!";   
        $files=['navbar-auth', 'signin.success'];
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    else:   
        $files=['navbar-auth', 'signin.success'];
        $this->content = View('auth', $files, compact('email'));  // ritorniamo il template con il form per fare la registrazione
    endif;
}
else
{
    $message = $Auth->getMessage();
    $files=['navbar-auth', 'signin.form'];
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
}  


}

/***************************************************|
* PAGE VERIFY MESSAGE                               |
* Se si clicca sul link signin che sta nella Navbar |
* Carica il template del Form per fare il Login     |
****************************************************/
/*
public function authMessage(){
    $message = isset($_GET['message']) ? $_GET['message'] : '';
    $files=['navbar-auth', 'message'];            
    $this->content = View('auth', $files, compact('message'));  // ritorniamo il template views\view-auth\verify.tpl.php
}
*/

/*******************|
*       LOGOUT      |
********************/
public function authLogout(){

    unset($_SESSION["id"]);
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    redirect("/posts");
}


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++| 
* PASSWORD RESET GROUP                                                                                 | 
*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++/
/***************************************************************************************************************************************|
* Al momento del login se l'utente non ricorda la password cliccando sul link del form 'password dimenticata?' si attiverà la rotta     |
* '/auth/password/form' che attiva il metodo 'passwordForm' di questa classe il quale ci mostrerà il template del form dove bisogna     |
*  inserire solo l'email e premere il bottone che ci indirizzerà verso la rotta '/auth/password/check' che attiverà il methodo          |
* 'passwordCheck' nel quale verrà verificato se l'email è già registrata nel database, Se è già registrata nel database il sistema ci   |
*  invierà una email con l'hash corrispondete all'interno di un link che attiverà la rotta '/auth/password/new' che ci mostrerà un form |
*  dove andremo a impostare una nuova password.                                                                                         |
* 'auth/password/lost'  |   'auth/password/new'  |   'auth/password/check'  |   'auth/password/save'                                    |
****************************************************************************************************************************************/

/***********************************************************************************************************************************|
* PASSWOR FORM                                                                                                                      |
* Dal form del login se l'utente non ricorda la password cliccando sul link del form 'password dimenticata?' si attiverà la rotta   |
* '/auth/password/lost' che attiva il metodo 'passwordLost' di questa classe il quale ci mostrerà il template del form dove bisogna |
* inserire solo l'email e premere il bottone [metodo POST]                                                                          |
************************************************************************************************************************************/
public function passwordForm(){
    $files=['navbar-auth', 'pass.form'];            
    $this->content = View('auth', $files);  // template del form per inserimento della email
}

/***************************************************************************************************************************************|
* PASSWORD CHECK
* la rotta '/auth/password/check' attiverà il methodo 'passCheck' nel quale verrà verificato se l'email è già registrata nel database,  |         
* Se è già registrata nel database il sistema ci invierà una Mail                                                                       |
* con all'interno un link dove saranno passati la nostra email e hash corrispondente che abbiamo prelevato dal database                 |
****************************************************************************************************************************************/
public function passwordCheck(){

    $Auth = new Auth($this->conn, $_POST);
    $Auth->passCheck(); 
 
    if ( empty( $Auth->getMessage()) )
    {
        $message = "Abbiamo mandato una email di attivazione a <strong>".$_POST['user_email']."</strong>. Per favore segui le istruzioni contenute nell'email per attivare il tuo account. Se l'email non ti arriva, controlla la tua cartella spam o prova a collegarti ancora per inviare un'altra email di attivazione.";
        $files=['navbar-auth', 'pass.message']; 
        $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    }
    else
    {
        $message = $Auth->getMessage(); // redirect("/auth/signup/store?message=$message");
        $files=['navbar-auth', 'pass.form']; 
        $this->content = View('auth', $files, compact('message'));  // ritorniamo il template con il form per fare la registrazione
    }  

 }


/***********************************************************************************************************|
* PASSWORD NEW                                                                                              |
* Cliccando sul link/bottone all'interno della Mail attiveremo la rotta '/auth/password/new'                |                            
* il metodo 'passNew' controlla se i parametri {email, hash} passati attraverso il link siano validi        |
* Se sono validi ci mostrerà un form dove andremo a impostare una nuova password.                           |
* Se non sono validi non ci mostrerà un messaggio di errore e non ci consetirà di creare una nuova password |                                                              |
************************************************************************************************************/
 public function passwordNew(){
    $Auth = new Auth($this->conn, $_GET);
    $Auth->passNew(); 


    if ( empty( $Auth->getMessage()) )
    {
        $files=['navbar-auth', 'pass.new'];   // mostra il form         
        $this->content = View('auth', $files );  // ritorniamo il template views\view-auth\verify.tpl.php
    }
    else
    {
        $message = $Auth->getMessage();
        $files=['navbar-auth', 'pass.error'];            
        $this->content = View('auth', $files, compact('message')); 
    }  
 }


/***********************************************************************************************************|
* PASSWORD SAVE                                                                                             |                                                          
************************************************************************************************************/
public function passwordSave(){

    $Auth = new Auth($this->conn, $_POST);
    $id = $Auth->passSave(); 
  
    if (  empty( $Auth->getMessage()) )
    {    
        $_SESSION['id'] = $id;
        $files=['navbar-auth', 'pass.success'];            
        $this->content = View('auth', $files);  
    }
    else
    {
        $message = $Auth->getMessage();
        $files=['navbar-auth', 'pass.new'];            
        $this->content = View('auth', $files, compact('message')); 
    }  


}


//====================================================================================================== 
//========== BLOG ========================= BLOG =======================================================
//====================================================================================================== 

/*******************|
*       GETPOSTS    |
********************/
    public function getPosts(){

        $posts = $this->Post->all(); // prendiamo tutti i post dal database 

        $files=['navbar-blog', 'posts'];
        $this->content = View('blog', $files, compact('posts'));  // ritorniamo il template con il form per fare il Login

        // compact('posts') serve a passare $posts a questa funzione per inserirli nel template
        //  $this->content = View('posts', compact('posts')); // con la funzione helpers/View ritorniamo il template con i post all' interno
    }
    

/***********************************************|
*       SHOW                                    |
* questa classe mostrerà un solo post e         |
* mostrerà tutti i commenti legati a questo post|
************************************************/
    public function show($postid){
      
        $post =  $this->Post->find($postid); // prendiamo il post con un determinato id dal database 
        $comment = new Comment($this->conn); // istanziamo la classe Comment
        $comments =  $comment->all($postid); // prendiamo tutti i commenti che hanno lo stesso id del post


        $files=['navbar-blog', 'post'];
        $this->content = View('blog', $files, compact('post','comments'));  // usando la funzione View ritorniamo il template con i post all' interno
      
    }



/*******************|
*       EDIT        |
********************/
public function edit($postid){

    $post = $this->Post->find($postid); // prendiamo tutti i post dal database 
    $this->content = View('editPost', compact('post')); // con la funzione helpers/View ritorniamo il template con i post all' interno
   
}



/***********************************************|
*       CREATE                                  |     
* Visualizza il form per scrivere un nuovo post |
************************************************/
    public function create(){

        $this->content = View('create'); // ritorniamo il template con il form per creare un nuovo post
    
    }



/*******************|
*       SAVE        |
********************/
    public function save(){

        $this->Post->save($_POST); // salviamo il post creato nel database 
        redirect("/"); // redirect è una funzione che fa il redirect nella home
        //echo json_encode($_POST);
       
    
    }



/*******************|
*       STORE       |
********************/
    public function store(string $id){

        try {    

            $result = $this->Post->store($_POST); // salviamo il post creato nel database 
            redirect("/"); // redirect è una funzione che fa il redirect nella home

        } catch ( PDOException $e ) {
            
            return $e->getMessage();
        }
    
    }



/*******************|
*       DELETE      |
********************/
    public function delete($id){

        try {    

            $result = $this->Post->delete((int)$id); // salviamo il post creato nel database 
            redirect("/"); // redirect è una funzione che fa il redirect nella home

        } catch ( PDOException $e ) {
            
            return $e->getMessage();
        }
        
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

