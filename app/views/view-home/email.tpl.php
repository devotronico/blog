<?php
    $errorMessage = '';  
    $successMessage = '';
    if ( isset($_POST['submit']) )
    {    
        if ( !$_POST['nome'] ) {  $errorMessage .= 'il campo <b>nome</b> è vuoto!<br>';  }

        if ( !$_POST['cognome'] ) { $errorMessage .= 'il campo <b>cognome</b> è vuoto!<br>'; }

        if ( !$_POST['tel'] ) { $errorMessage .= 'il campo <b>telefono</b> è vuoto!<br>'; }

        if ( !$_POST['email'] ) { $errorMessage .= 'il campo <b>email</b> è vuoto!<br>'; }

        if ( !$_POST['testo'] ) { $errorMessage .= 'il campo <b>descrivi il lavoro</b> è vuoto!<br>'; }
      
        if ( $errorMessage != '' )
        {
            $errorMessage = "<div id='error'>" . $errorMessage . "</div>";     
        }
        else
        {
            $nome = $_POST['nome'] .' '. $_POST['cognome'];
            $emailTo = 'dmanzi83@hotmail.it';
            $subject = "lavoro";
            //$content = $_POST['nome']." ".$_POST['cognome']. "\r\n" .$_POST['testo'];
            $content = $_POST['testo'];
            $headers = "From: " . $nome . " <" . $_POST['email'] . ">\r\n";
            $headers .= "Reply-To: " .  $_POST['email'] . "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            if ( mail( $emailTo, $subject, $content, $headers ) )
            {
                $successMessage = "<div id='success'>email inviata con successo</div>"; 
            }
            else
            {
                $errorMessage = "<div id='error'>email NON inviata riprova più tardi</div>";
            }
            header('Location: index.php');
            exit;
        }
    }
?>