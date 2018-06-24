<?php
namespace App\Models;

use App\Models\Email;
use \PDO;


class Signin
{
    private $conn;
    private $email;
    private $password;
    private $message;

    public function __construct(PDO $conn, array $data = [])
    {

        $this->conn = $conn;

        $this->email = isset($data['email'])? $this->validateEmail($data['email']): null; 

        $this->password = isset($data['password'])? $this->validatePass($data['password']): null; 
    }



    public function getMessage()
    {
        return $this->message;
    }

    /***************************************************************************************************************************************|
     * LOGIN   [set cookie]                                                                                                                 |
     * dopo aver precedentemente validato l'email e la password controlliamo se entrambi i valori esistono nel database                     |                                                                                           |
     * Utilizzando solo l'email per fare la query estraiamo il valore della password dal database                                           |                                              |
     * se l'email è presente nel database confrontiamo la password che abbiamo inserito nel form con quella nel database                    |
     * se le password sono uguali facciamo un altro controllo sul campo 'user_status'                                                       |
     * Se 'user_status' è uguale a 1:                                                                                                       |
     *  vuol dire che abbiamo già attivato l'account precedentemente dall'email che il sistema ci ha inviato al momento della registrazione |
     * Se 'user_status' è uguale a 0:                                                                                                       |
     *  allora  non potremo loggarci e il sistema ci invierà una mail per attivare il l'account                                             |
     ***************************************************************************************************************************************/
    public function login() 
    {
        $email = $this->email;
        $sql = "SELECT ID, user_type, user_name, user_pass, user_activation_key, user_status FROM users WHERE user_email = :email";

        if ($stmt = $this->conn->prepare($sql)) 
        { 
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 32);
            if ($stmt->execute()) 
            {
                if ($stmt->rowCount() == 1) {
                    
                    $user = [];
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (password_verify($this->password, $user['user_pass'])) {

                        if ( $user['user_status'] == 1 ) {

                            $_SESSION['user_id'] = $user['ID'];
                            $_SESSION['user_type'] = $user['user_type'];
                            $_SESSION['user_name'] = $user['user_name'];
                            setcookie("user_id", $user['ID'], time()+3600, '/');

                        } else {
                            $Email = Email::verify($email, $user['user_activation_key']);
                            $Email->send();
                            return $email; // ritorniamo email per i
                        }

                    } else {
                        $this->message .= "La password inserita non corrisponde all' email <strong>$email</strong>.<br>";
                    }
                } else {
                    $this->message .= "All' email <strong>$email</strong> non risulta associato nessun account.<br>";
                }
            } else {
                $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
            }
        } else {
            $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
        }
        $stmt = null; 
        $this->conn = null; // Chiude connessione PDO
    }

/*****************************************VALIDAZIONI*******************************************************************************/

    /***************************************************************************************************|
     * VALIDATE EMAIL BASE                                                                              |
     * fa una prima validificazione del 'email                                                          |
     * Controlla: che non sia vuota e che abbia caratteri validi                                        |
     * FILTER_SANITIZE_EMAIL                                                                            |
     * Rimuove tutti i caratteri eccetto le lettere, i numeri e i caratteri !#$%&'*+-/=?^_`{|}~@.[]     |
     * Non sono considerate valide le email con i caratteri "\<>                                        |
     * ma lascia le virgolette singole ['] perciò non è sufficiente.                                    |
     * Se l'email contiene il carattere '/' verrà ritenuta valida ma il carattere '/' verrà rimosso     |
     * HTML5 non considera valide le email con i caratteri:                                             |
     *  prima e dopo la chiocciola  @()[]:<>\"                                                          |
     *  prima della chiocciola      @()[]:<>\"                                                          |
     *  dopo la chiocciola          @$%&'*+/=?^_`{|}~()[]:<>\"                                          |
     ***************************************************************************************************/
    private function validateEmail($email)
    {
        $email = trim($email);

        if ( empty($email) ) {
            $this->message .= "Il campo email è vuoto.<br>";
        } 
        else 
        {
        
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if ($email === false) {
                $this->message .= "<strong>".$email."</strong> non è un email valida.<br>";
            }
            else{
                return $email;
            }
        }
    }  

    /********************************|
     * VALIDATION PASSWORD           |
    *********************************/
    private function validatePass($password)
    {
        $PASSWORD_LENGTH = 8; 
        $password = trim($password);

        if (empty($password)) {
            $this->message = "Il campo password è vuoto.<br>";
        } else if (strlen($password) < $PASSWORD_LENGTH) {
            $this->message = "La password deve avere almeno " . $PASSWORD_LENGTH . " caratteri.<br>";
        } else {
            return $password;
        }
    }


} // Chiude la classe Signin







