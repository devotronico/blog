<?php
namespace App\Models;

use App\Models\Email;
use \PDO;

/*
 * In questa classe facciamo l autenticazione
 */

class Auth extends Validate
{
    public function getMessage()
    {
        return $this->message;
    }

    public function signup()
    {
        $email = $this->validateEmailSignup();
        $password = $this->validatePassSignup();

        if (empty($this->message)) {

            $this->storeData($email, $password);
        }

        // $this->conn = null; // Chiude PDO connection
    }

    public function signin()
    {

        $email = $this->isEmailStored(); 
        $password = $this->validatePassSignin(); // in
        //if ( !empty($email) && !empty($password) ) {  // se email e password sono corretti 
        if ( !is_null($email) && !is_null($password) ) {  // se email e password sono corretti 
        if ( !isset($_SESSION['id']) ) { // se $_SESSION['id'] non è settato vuol dire che l'account non è stato confermato
            $hash = $this->hash; // non è necessario validare questa hash perchè è presa dal database col metodo 'isEmailStored'
            $Email = new Email($email, $hash);
            $Email->send();
            return $email; // ritorniamo email per inserirla nel messaggio che ci avvisa che ci è stata invita un Mail al nostro indirizzo
        }
    }
        $this->conn = null; // Chiude PDO connection
    }


    public function storeData($email, $password)
    {
        $name = 'Daniele';
        $password= password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        $hash = md5(rand(0, 1000)); //$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
        $date = date('Y-m-d H:i:s');
        $status = 0;

        // Prepare an insert statement
        $sql = "INSERT INTO users (user_name, user_email, user_pass, user_registered, user_activation_key, user_status) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bindParam(1, $name, PDO::PARAM_STR, 12);
            $stmt->bindParam(2, $email, PDO::PARAM_STR, 12);
            $stmt->bindParam(3, $password, PDO::PARAM_STR, 60);
            $stmt->bindParam(4, $date, PDO::PARAM_STR, 12);
            $stmt->bindParam(5, $hash, PDO::PARAM_STR, 12);
            $stmt->bindParam(6, $status, PDO::PARAM_INT);

            if ($stmt->execute()) { //  Tentiamo di eseguire lo statement
                //Se riusciamo a salvare i dati nel database senza errori allora inviamo un email all'utente per attivare l'account
                // $Email = new Email;
                // $Email->send($email, $hash);
                $Email = new Email($email, $hash);
                $Email->send();
            } else {
                $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
            }
        }
        $stmt = null; // Close statement
    }


/***************************************************************************|
 * SIGNUP GROUP                                                             |
 * VERIFICA DOPO ATTIVAZIONE DA MAIL PER FARE IL SIGNUP                     |
 * Quando clicchiamo sul link di conferma presente nell'email               |
 * verremo indirizzati sul nostro sito dove si attiva questo metodo         |
 * Il link contiene le variabili/parametri $_GET['email'] e $_GET['hash']   |
 * che se corrispondo a quelli memorizzati nel database col metodo signup   |
 * il sistema ci confermerà l'account settando la colonna user_status del   |
 * databse da '0' a '1'                                                     |
 ***************************************************************************/
    public function signupEmailActivation()
    {
        // verifichiamo dalla url che abbiamo ricevuto dalla Mail per la verifica se abbiamo la variabile email e hash
        if (isset($_GET['email']) && !empty($_GET['email']) and isset($_GET['hash']) && !empty($_GET['hash'])) {
          
            $email = $this->isEmailStored();   //   $email = $_GET['email'];
            $hash = $this->hash; // la hash passata dal URL col $_GET viene validata nel costruttore della classe 'Validate'
            //$hash = $this->hashUrlValidate($_GET['hash']); // validiamo questa hash perchè è presa dal URL col $_GET

            $sql = "SELECT * FROM users WHERE user_email= :email AND user_activation_key= :hash AND user_status= 0";

            if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement della Select
            {
                $stmt->bindParam(':email', $email, PDO::PARAM_STR, 32);
                $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
                if ($stmt->execute()) // Tentiamo di eseguire lo statement
                {
                    if ($stmt->rowCount() == 1) { // se nel database cè una corrispondenza con i parametri passati dal link dell'email
                        $user = [];
                        $user = $stmt->fetch(PDO::FETCH_ASSOC); //  PDO::FETCH_OBJ
                        $_SESSION['id'] = $user['ID'];

                        $sql = "UPDATE users SET user_status = 1 WHERE user_email = :email"; //  attiviamo l' account {set user_status ='1'}
                        if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
                        {
                            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 32);

                            $this->message = $stmt->execute() ? '' : "Qualcosa è andato storto. Per favore prova più tardi.";

                        } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";}
                    } 
                    else 
                    {
                        $this->message = 'questa account è già stato attivato';
                    }

                } else { $this->message = "Questo account è già stato registrato oppure l' URL non è valido";}
            } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";}
            $stmt = null; // Chiude stmt connection
            $this->conn = null; // Chiude PDO connection

        } else { $this->message = "I parametri non sono stati passati!";}
    }






/***********************************************************************************************************|
 * PASSWORD RESET GROUP                                                                                     |
 * PASS-PARAM                                                                                               |
 * Verifica dopo attivazione da Mail per fare resettare/cambiare/creare la password                         |
 * Controlla i parametri email e hash passati come parametri dell'URL se sono corrispondenti nel database   |
 * Controlla anche se è un account già registrato: 'user_status= 1'                                         |
 * Questo metodo si attiva solo quando riceviamo un email dal sistema per il recupero password              |
 ***********************************************************************************************************/
public function passParam()
{
    // verifichiamo dalla url che abbiamo ricevuto dalla Mail per la verifica se abbiamo la variabile email e hash
    if (isset($_GET['email']) && !empty($_GET['email']) and isset($_GET['hash']) && !empty($_GET['hash'])) {
       
        $email = $this->isEmailStored();   //   $email = $_GET['email'];
        $hash = $this->hash; // la hash passata dal URL col $_GET viene validata nel costruttore della classe 'Validate'

        $sql = "SELECT * FROM users WHERE user_email= :email AND user_activation_key= :hash AND user_status= 1";

        if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement della Select
        {
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 32);
            $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
            if ($stmt->execute()) // Tentiamo di eseguire lo statement
            {
                if ($stmt->rowCount() == 1) { // se nel database cè una corrispondenza con i parametri passati dal link dell'email
                    return true;
                } 
                else 
                {
                    $this->message = 'Questo account non esiste';
                }

            } else { $this->message = "Questo account non esiste oppure l' URL non è valido";}
        } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";}
        $stmt = null; // Chiude stmt connection
        $this->conn = null; // Chiude PDO connection

    } else { $this->message = "I parametri non sono stati passati";}
}




/***********************************************************************************************|
 * PASSWORD RESET GROUP                                                                         |
 * PASS-CHECK                                                                                   |
 * Dopo aver inserito la mail nel campo input e premuto il bottone si attiverà questo metodo    |
 * Dopo la validazione dell' email e ottenuto l'hash corrispondete dal database                 |
 * il sistema ci invierà una mail per creare una nuova password                                 |
 * La mail conterrà un link con la rotta '/auth/password/new/'                                  |
 ***********************************************************************************************/
    public function passCheck() {
        $email = $this->isEmailStored(); // l'email non è vuota | ha una forma valida | è presente nel database
        $hash = $this->hash; // non è necessario validare questa hash perchè è presa dal database col metodo 'isEmailStored' 
        if ( !is_null($email) && !is_null($hash) ) {  // se email e password sono corretti 
          
            $Email = new Email($email, $hash, 'newpass');
            $Email->send();
        }
    }

/***********************************************************************************************|
 * PASSWORD RESET GROUP                                                                         |
 * PASS-NEW                                                                                     |
 ***********************************************************************************************/

 
    public function passNew() {

        $email = $this->isEmailStored();
        if ( $this->hash !== $_GET['hash'] )
        {
            $this->message = "Questo account non esiste oppure l' URL non è valido";
        }
       // $hash = $this->hash; // validiamo questa hash perchè è presa dal URL col $_GET    
    }


/***********************************************************************************************|
 * PASSWORD RESET GROUP                                                                         |
 * PASS-SAVE                                                                                    |
 ***********************************************************************************************/
public function passSave() {

    $email = $this->isEmailStored();
   // $hash = $this->hashUrlValidate($_GET['hash']); // validiamo questa hash perchè è presa dal URL col $_GET
    $password = $this->validatePassSignup();
    if ( !is_null($password) )
    {
        $password_conf =  $this->password_conf;

        if ($password === $password_conf) { 
        
        //   if ( !is_null($email) && !is_null($password) ) {

                $sql = "SELECT ID FROM users WHERE user_email = :email";
                if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
                { 
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR, 32);
                    if ($stmt->execute()) // Tentiamo di eseguire lo statement
                    {
                        // se è uguale a 1 vuol dire che questa email è già stata registrata e possiamo procedere con la validazione
                        if ($stmt->rowCount() == 1)
                        {
                            $user = [];
                            $user = $stmt->fetch(PDO::FETCH_ASSOC); //  PDO::FETCH_OBJ
                           // $_SESSION['id'] = $user['ID'];
                            $password= password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                            $sql = "UPDATE users SET user_pass = :password WHERE user_email = :email"; 
                            if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
                            {
                                $stmt->bindParam(':email', $email, PDO::PARAM_STR, 32);
                                $stmt->bindParam(':password', $password, PDO::PARAM_STR, 60);    
                                if ($stmt->execute())  //  Tentiamo di eseguire lo statement
                                {
                                    return $user['ID'];
                                }
                                else
                                {
                                    $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
                                }
                            }
                        }
                        else
                        { 
                            $this->message = "Un account con l' email <strong>$email</strong> non esiste";
                        }
                    } else {  $this->message = "Qualcosa è andato storto. Per favore prova più tardi."; }   
                } else {  $this->message = "Qualcosa è andato storto. Per favore prova più tardi."; }   
      
        } else { $this->message .= "Le due password devono essere uguali"; } 
    }   
}


} // Chiude la classe Auth
