<?php
namespace App\Models;

use \PDO;

class Validate
{
    protected $conn;
    protected $name;
    protected $email;
    protected $password;
    protected $password_conf;
    protected $hash; // bisogna validare anche l'hash
    protected $message;

    public function __construct(PDO $conn, array $data = [])
    {

        $this->conn = $conn;

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->email = $data['email'];
               // $this->hash = $data['hash']; // da controllare se viene passato anche con POST
                $this->hash = preg_match('/^[a-f0-9]{32}$/', $data['hash'])? $data['hash'] : '';
                break;
            case 'POST':
                $this->name = isset($data['user_name'])? $data['user_name']: ''; 
                $this->email = isset($data['user_email'])? $data['user_email']: ''; 
                $this->password = isset($data['user_pass'])? $data['user_pass']: ''; 
                $this->password_conf = isset($data['user_pass_confirm'])? $data['user_pass_confirm']: '';
                break;
        }
    }


    public function validateUsername() {

        if ( empty($this->name) ) 
        {  
            $name = explode('@', $this->email); // es. spezziamo l'email nel punto del simbolo '@'
            return $this->name = $name[0];
           // return $this->name
        }

    }


    public function hashUrlValidate($hash)
    {
        //validiamo l'hash che viene passata attraverso il metodo GET dall URL 
        if (preg_match('/^[a-f0-9]{32}$/', $hash)) {
            return $hash;
        }
    }




/***************************************************************|
 * VALIDATE EMAIL BASE                                          |
 * fa una prima validificazione del 'email                      |
 * Controlla: che non sia vuota e che abbia caratteri validi    |
 ****************************************************************/
public function validateEmail()
{
    $this->email = trim($this->email);

    if (empty($this->email)) {
        $this->message .= "Il campo <strong>email</strong> è vuoto.<br>";
    } 
    else 
    {
        /* FILTER_SANITIZE_EMAIL
        Rimuove tutti i caratteri eccetto le lettere, i numeri e !#$%&'*+-/=?^_`{|}~@.[]
        ma lascia le virgolette singole ['] perciò non è sufficiente.*/
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        if ($this->email === false) {
            $this->message .= "<strong>".$this->email."</strong> non è un email valida.<br>";
        }
        else{
            return $this->email;
        }
    }
}  


/****************************************************************|
 * VALIDATE EMAIL SIGNUP                                         |
 * valida l'email per i metodi signup e signin della classe Auth |
 ****************************************************************/
    public function validateEmailSignup()
    {
        if ( !is_null($this->validateEmail()) ) {
            $this->email = $this->validateEmail();

            $sql = "SELECT user_email FROM users WHERE user_email = :email"; // Creiamo uno Statement di tipo Select

            if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
            { // Colleghiamo la variabile $email al parametro email dello statement che abbiamo preparato sopra
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
                if ($stmt->execute()) // Tentiamo di eseguire lo statement
                {
                    // Il metodo rowCount restituisce il numero di righe in cui è presente la variabile $email
                    if ($stmt->rowCount() == 1) // se è uguale a 1 vuol dire che questa email è già stata registrata
                    {
                        $this->message .= "Un utente con l' email <strong>".$this->email."</strong> è già stato registrato.<br>";
                    } else // se è uguale a 0
                    {
                        $stmt = null; // Chiudi lo statement
                        return $this->email; // otteniamo l'email per memorizzarla nel database
                    }
                } else {
                    $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
                }
            }
            $stmt = null; // Close statement
        }
    }

/*******************************************************************************************************|
 * IS EMAIL STORED                                                                                      |
 * Controlla se l'email è già presente nel database                                                     |
 * Se lo è, allora la ritorna e viene prelevato anche il valore dell' hash corrispondete a questa email |
 *******************************************************************************************************/
    public function isEmailStored() // check if email is stored //  isEmailStored     isEmailExists
    {
        if ( !is_null($this->validateEmail()) ) {
            $this->email = $this->validateEmail();   
                //$sql = "SELECT user_email FROM users WHERE user_email = :email AND user_activation_key= :hash AND user_status= 0"; // Creiamo uno Statement di tipo Select
                $sql = "SELECT user_activation_key FROM users WHERE user_email = :email";

                if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
                { // Colleghiamo la variabile $email al parametro email dello statement che abbiamo preparato sopra
                    $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
                    if ($stmt->execute()) // Tentiamo di eseguire lo statement
                    {
                        // se è uguale a 1 vuol dire che questa email è già stata registrata e possiamo procedere con la validazione
                        if ($stmt->rowCount() == 1) {
                            $user = [];
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            // otteniamo l'hash dal database perchè può servirci nel caso l'utente non abbia ancora confermato l'account
                            $this->hash = $user['user_activation_key']; // [!]
                            $stmt = null; // Chiudi lo statement [!]
                            return $this->email; // otteniamo l'email per poter accedere al nostro account [!]

                        } else {
                            $this->message .= "L' email <strong>".$this->email."</strong> non è stata ancora registrata.<br>";
                        }

                    } else {
                        $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
                    }
                } else {
                    $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
                }
                $stmt = null; // Close statement
            } 
        }






      
    
/********************************|
 * VALIDATION PASSWORD SIGNUP    |
*********************************/
    public function validatePassSignup()
    {
        $PASSWORD_LENGTH = 8;

        $this->password = trim($this->password);

        if (empty($this->password)) {
            $this->message .= "Il campo <strong>password</strong> è vuoto.<br>";
        } else if (strlen($this->password) < $PASSWORD_LENGTH) {
            $this->message .= "La <strong>password</strong> deve avere almeno " . $PASSWORD_LENGTH . " caratteri.<br>";
        } else {
            return $this->password;
        }
    }

/********************************|
 * VALIDATION PASSWORD SIGNIN    |
*********************************/
    public function validatePassSignin() {

        if ( !is_null($this->validatePassSignup()) ) {
        $password =  $this->validatePassSignup();
    
        $sql = "SELECT * FROM users WHERE user_email=:email";

        if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
        {
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 12);
            if ($stmt->execute()) // Tentiamo di eseguire lo statement
            {
                if ($stmt->rowCount() == 1) // se
                {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (password_verify($password, $user['user_pass'])) // controlliamo se la password è uguale a quella nel database
                    {  
                        if ($user['user_status'] == 1) {
                            $_SESSION['id'] = $user['ID']; // ($user['user_status']);
                            $_SESSION['email'] = $user['user_email'];
                            $_SESSION['name'] = $user['user_name'];
                            return $password;
                            // if ( array_key_exists('setcookie', $_POST) && $_POST['setcookie'] == '1')  {
                            //     setcookie('id', $_SESSION['id'], time()+60*60*24*365);   // }
                        } else {
                            // Se proviamo a fare il login senza aver prima confermato l' account cliccando
                            // sul link all'interno dell'email che il sistema ci ha inviato dopo il durante la fase di registrazione
                            // Allora il sistema ci avvisa che dobbiamo prima confermare l'account e quindi ci invia un'altra email
                            // con il link di attivazione dell'account
                           // $this->message = "Prima di loggarti ti chiediamo di confermare la tua iscrizione.<br>Un link di conferma è stato mandato alla tua casella di posta <strong>$this->email</strong>,<br>per verificare il tuo account clicca sul link che trovi nella mail che ti abbiamo inviato!";
                        }
                        return $password;
                    } else { $this->message .= "Questa <strong>password</strong> è errata, riprova.";}
                } else { $this->message .= "La tua <strong>password</strong> non combacia con l' <strong>email</strong>.";}
            }
        }
    }
}









} // Chiude la classe Validate






/***********************************************************************************************************|
 * VALIDATE EMAIL e HASH                                                                                    |
 * Controlla i parametri email e hash passati come parametri dell'URL se sono corrispondenti nel database   |
 * Questo metodo si attiva solo quando riceviamo un email dal sistema:                                      |
 * Alla creazione di un account nuovo e al recupero password                                                | 
 ***********************************************************************************************************/
/*
public function validateEmailParam()
{
    if ( !is_null($this->validateEmail()) ) {
        $this->email = $this->validateEmail();   
            //$sql = "SELECT user_email FROM users WHERE user_email = :email AND user_activation_key= :hash AND user_status= 0"; // Creiamo uno Statement di tipo Select
            $sql = "SELECT user_activation_key FROM users WHERE user_email = :email";

            if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
            { // Colleghiamo la variabile $email al parametro email dello statement che abbiamo preparato sopra
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
                if ($stmt->execute()) // Tentiamo di eseguire lo statement
                {
                    // se è uguale a 1 vuol dire che questa email è già stata registrata e possiamo procedere con la validazione
                    if ($stmt->rowCount() == 1) {
                        $user = [];
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                       
                        if ( $this->hash == $user['user_activation_key'] ) // controlliamo se l'hash il parametro hash è uguale all'hash del database 
                        {
                            $stmt = null; // Chiudi lo statement
                            return $this->email; // otteniamo l'email per poter accedere al nostro account
  
                        }
                        else
                        {
                            $this->message = "I parametri dell' URL sono errati. Non puoi proseguire";     
                        }

                    } else {
                        $this->message .= "L' email <strong>".$this->email."</strong> non è stata ancora registrata.<br>";
                    }

                } else {
                    $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
                }
            } else {
                $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
            }
            $stmt = null; // Close statement
        } 
    }
*/