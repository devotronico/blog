<?php
namespace App\Models;


use \PDO;


class EmailLink
{
    private $conn;
    private $message;
    private $email;
    private $hash; 

    public function __construct(PDO $conn, array $data = [])
    {

        $this->conn = $conn;

        $this->email = isset($data['email'])? $this->isEmailStored($this->validateEmail($data['email'])): $this->message .= "Il parametro email è vuoto"; // route = auth/password/check

        $this->hash = isset($data['hash'])? $this->isHashStored($this->hashUrlValidate($data['hash'])): $this->message .= "Il parametro hash è vuoto";    
    }


/***************************************************************************************************************|
 * GET MESSAGE                                                                                                  |
 * Ritorna eventuali messaggi errori da utilizzare se un determinata richiesta dell'utente è andata a buon fine |                                               
 ***************************************************************************************************************/
public function getMessage()
{
    return $this->message;
}




/***************************************************************************************************************************|
 * Email ACTIVATION      [set cookie]    SIGNUP                                                                             |
 * Quando  nell'email clicchiamo sul link di conferma per attivare l'account presente verremo indirizzati di nuovo sul sito |
 * Il link contiene le variabili/parametri $_GET['email'] e $_GET['hash']                                                   |
 * Dopo aver validato la email e la hash che sono stati passati dall'url col metodo GET                                     |
 * Controlliamo se corrispondo ai valori presenti nella tabella 'users' del database                                        |
 * Se sono uguali allora settiamo le variabili globali SESSION e COOKIE                                                     |
 * Poi facciamo un controllo sul campo 'user_status'                                                                        |
 * Se il valore di 'user_status' è uguale a 0:                                                                              |
 *  cambiamo il suo valore in 1. il valore 1 sta a indicare che la registrazione al sito è completa.                        |
 * Se il valore di 'user_status' è uguale a 1:                                                                              |
 *  lasciamo il suo valore in 1. vuol dire che questo account era già stato attivato precedentemente                        |                                                    
 ***************************************************************************************************************************/
public function accountActivation()
{
    if (empty($this->message)) {
      
        $sql = "SELECT ID, user_type, user_name, user_activation_key, user_status FROM users WHERE user_email = :email";

        if ($stmt = $this->conn->prepare($sql)) 
        {
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
            if ($stmt->execute()) 
            {
                if ($stmt->rowCount() == 1) { 
                 
                    $user = $stmt->fetch(PDO::FETCH_ASSOC); 
                    if ( $user['user_activation_key'] === $this->hash ) {
                        die ( $user['user_activation_key'].'  '.$this->hash );
                        $_SESSION['user_id'] = $user['ID'];
                        $_SESSION['user_type'] = $user['user_type'];
                        $_SESSION['user_name'] = $user['user_name'];
                        setcookie("user_id", $user['ID'], time()+3600, '/');

                        if ( $user['user_status'] == 0 ) {

                            $sql = "UPDATE users SET user_status = 1 WHERE user_email = :email";
                            if ($stmt = $this->conn->prepare($sql)) 
                            {
                                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
                           
                                $this->message = $stmt->execute() ? '' : "Qualcosa è andato storto. Per favore prova più tardi.";

                            } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";}
                        }
                        else {  $this->message = 'Questo account è già stato attivato';}

                    } else { $this->message = "Il parametro hash è errato";} 

                } else { $this->message = "Il parametro email è errato";} 
            } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";}
        } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";}
        $stmt = null;
        $this->conn = null; 
    }
}




/***************************************************************************************************************************|
 * EMAIL LINK                                  PASSWORD                                                                     |
 * Quando  nell'email clicchiamo sul link di conferma per attivare l'account presente verremo indirizzati di nuovo sul sito |
 * Il link contiene le variabili/parametri $_GET['email'] e $_GET['hash']                                                   |
 * Dopo aver validato la email e la hash che sono stati passati dall'url col metodo GET                                     |
 * Controlliamo se corrispondo ai valori presenti nella tabella 'users' del database                                        |
 * Se sono uguali allora facciamo un controllo sul campo 'user_status'                                                      |
 * Se il valore di 'user_status' è uguale a 0:                                                                              |
 *  cambiamo il suo valore in 1. il valore 1 sta a indicare che la registrazione al sito è completa.                        |
 * Se il valore di 'user_status' è uguale a 1:                                                                              |
 *  lasciamo il suo valore in 1. vuol dire che questo account era già stato attivato precedentemente                        |                                                    
 ***************************************************************************************************************************/
public function linkNewPass()
{
    if (!empty($this->message)) {exit;}
      
        $email = $this->email;  
        $hash = $this->hash; 

        $sql = "SELECT user_activation_key, user_status FROM users WHERE user_email = :email";

        if ($stmt = $this->conn->prepare($sql)) 
        {
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
          
            if ($stmt->execute()) 
            {
                if ($stmt->rowCount() == 1) 
                { 
                    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

                    if ( $user['user_activation_key'] === $this->hash ) 
                    {
                        if ( $user['user_status'] == 0 ) {

                            $sql = "UPDATE users SET user_status = 1 WHERE user_email = :email";
                            if ($stmt = $this->conn->prepare($sql)) 
                            {
                                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
                
                                $this->message .= $stmt->execute() ? '' : "Qualcosa è andato storto. Per favore prova più tardi.";

                            } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
                        } // else { $this->message .= '';}
                    } else { $this->message = "Il parametro hash è errato";}        
                } else { $this->message = "Il parametro email è errato";} 
            } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
        } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
        $stmt = null;
        $this->conn = null; 
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

    /*******************************************************************************************************|
     * IS EMAIL STORED                                                                                      |
     * Controlla se l'email è già presente nel database                                                     |
     * Se lo è, allora la ritorna e viene prelevato anche il valore dell' hash corrispondete a questa email |
     *******************************************************************************************************/
    private function isEmailStored($email) 
    {
        if ( $email ) {

                $sql = "SELECT user_activation_key FROM users WHERE user_email = :email";

                if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
                { 
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR, 32);
                    if ($stmt->execute()) // Tentiamo di eseguire lo statement
                    {
                        if ($stmt->rowCount() == 1) {
                            $user = [];
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                           
                            $this->hash = $user['user_activation_key']; 
                          
                            return $email; 

                        } else {
                            $this->message .= "L' email <strong>".$email."</strong> non è stata ancora registrata.<br>";
                        }

                    } else {
                        $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";
                    }
                } else {
                    $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";
                }
                $stmt = null; 
                //$conn = null; 
            } else {
                $this->message .= "il campo email non può essere lasciato vuoto";
            }
        }




    /***************************************************************************************************|
     * HASH URL VALIDATE                                                                                |
     * Controlla se sono validi i caratteri che compongono l' hash che otteniamo dall' url [metodo GET] |                                  
     ***************************************************************************************************/
    private function hashUrlValidate($hash)
    {
        if (preg_match('/^[a-f0-9]{32}$/', $hash)) {
            return $hash;
        } else {
            $this->message .= "il parametro hash non è valido";
        }
    }


    /*******************************************************************************************************|
     * IS HASH STORED                                                                                       |
     * Controlla se l' hash è già presente nel database                                                     |
     * Se lo è, allora la ritorna                                                                           |
     *******************************************************************************************************/
    private function isHashStored($hash) 
    {
        if ( $hash ) {

                $sql = "SELECT user_activation_key FROM users WHERE user_activation_key = :hash";

                if ($stmt = $this->conn->prepare($sql)) 
                { 
                    $stmt->bindParam(':hash', $hash, PDO::PARAM_STR, 32);
                    if ($stmt->execute()) 
                    {
                        if ($stmt->rowCount() == 1) {

                            $user = [];
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            $stmt = null; 
                            return $user['user_activation_key']; 
                        } else {
                            $this->message .= "Questa hash <strong>".$hash."</strong> non è presente nel database.<br>";
                        }

                    } else {
                        $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";
                    }
                } else {
                    $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";
                }
                $stmt = null;
            } else {
                $this->message .= "il parametro hash è vuoto";
            }
        }


} // Chiude la classe EmailLink
