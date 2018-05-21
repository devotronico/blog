<?php
namespace App\Models;
require 'vendor/autoload.php'; //Load Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
  // Import PHPMailer classes {PHPMailer\PHPMailer\PHPMailer e PHPMailer\PHPMailer\Exception}into the global namespace  
    // These must be at the top of your script, not inside a function
  
class Email{

    private $email; 
    private $name;
    private $hash;
    private $site;
    private $link;
    private $subject;

    private $titleTpl; 
    private $infoTpl;
    private $buttonTpl;

    public function __construct($email, $hash, $name='nuovo utente', $type='verify'){
        $this->email = $email;
        $this->hash = $hash;
        $this->name = $name;
        $this->site = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']; // https://www.danielemanzi.it/ ||| http://localhost:3000/
        if ( $type === 'verify' ){

            $route = '/auth/signup/verify/';
            $this->subject = 'Registrazione';
            $this->titleTpl =  'Verifica il tuo indirizzo email'; 
            $this->infoTpl = 'Per iniziare ad usare il tuo account devi confermare l\'indirizzo email';
            $this->buttonTpl = 'Verifica indirizzo email';
        } else {

            $route = '/auth/password/new/';
            $this->subject = 'Nuova password';
            $this->titleTpl = 'Crea una nuova password'; 
            $this->infoTpl = 'Per creare una nuova password clicca sul bottone nuova password';
            $this->buttonTpl = 'Nuova password';
        }
      
    
        $this->link = $this->site.$route."?email=".$email."&hash=".$hash; //http://localhost:3000/auth/verify/?email=dmanzi83@hotmail.it&hash=a597e50502f5ff68e3e25b9114205d4a

    }

/***************************|
*    EMAIL INVIO            |
****************************/  
public function send(){

   // require 'vendor/autoload.php'; //Load Composer's autoloader
    
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try { //Server settings
    
    //  MAILTRAP SMTP
        $mail->SMTPDebug = 0;                                   // Enable verbose debug output
        $mail->isSMTP();                                        // Set mailer to use SMTP
        $mail->Host = 'smtp.mailtrap.io';                       //smtp.gmail.com  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                 // Enable SMTP authentication
        $mail->Username = 'b34b7169adb122';                     // dmanzi83@gmail.com // SMTP username
        $mail->Password = '8d0c925142f07b';                     // DMbr0l1@XIX83.google  // SMTP password
        $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;    
    
    /*
    //  GMAIL SMTP
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'dmanzi83@gmail.com';               // SMTP username
        $mail->Password = 'DMbr0l1@XIX83.google';             // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
    */
        //Recipients
        $mail->setFrom('dmanzi83@gmail.com', 'Daniele');
        $mail->addAddress($this->email, $this->name);                       // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
    
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $this->subject;// Crea una nuova password // Benvenuto in danielemanzi.it // Account su danielemanzi.it cancellato
        $body = require_once 'app\views\view-auth\email.tpl.php'; //
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);
        $mail->send();
        //echo 'Invio email riuscito!';
    } catch (Exception $e) {
        echo 'Invio email fallito! Error: ', $mail->ErrorInfo;
    }
    
    }
    


// Titolo-> Verifica il tuo indirizzo email | Crea una nuova password
// Info-> Per iniziare ad usare il tuo account devi confermare l'indirizzo email | Per creare una nuova password clicca sul bottone nuova password
// bottone-> Verifica indirizzo email | Creare nuova password

// note.1-> Se non sei stato tu ad ad iscriverti, ignora questa email. L' account verrÃ  chiuso
// note.2-> Se il bottone non funziona copia il link qui sotto e incollalo nel URL del tuo browser

}



