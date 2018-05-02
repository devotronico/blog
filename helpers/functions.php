<?php


function View($view, array $files=[], array $data=[]){
   
  extract($data); // estraiamo tutti i dati sui post per inserirli nel template
  ob_start(); // catturiamo tutto nel buffer
  foreach ( $files as $file ) {require 'app/views/view-'.$view.'/'.$file.'.tpl.php';}// i post andranno in questo file di template
  $output =  ob_get_contents(); // qui verrà catturato tutto il contenuto del file 'post.tpl.php'
  ob_end_clean(); // liberiamo la memoria | meglio disattivare altrimenti non ritorna $data
  return $output; // ritorniamo il tutto per farlo recuperare nel metodo 'Process'
}


function redirect($uri ='/'){
  header('Location:'.$uri);
  exit;
}


