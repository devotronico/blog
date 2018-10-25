<h1>EMAIL</h1>
<?php


$to = "dmanzi83@hotmail.it";
$subject = "Prova email";
$message = "Hello world!";
$headers = "From: dmanzi83@gmail.com" . "\r\n";
if ( mail($to, $subject, $message, $headers) ):
echo ("Invio email riuscito!"); 
else:
echo ('Invio email fallito!');
endif;  