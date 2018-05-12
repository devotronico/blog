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



function dateFormatted($dateOld){

 $temp = preg_split("/[-\s:]/", $dateOld);

 $temp[2] = ltrim($temp[2], '0' );

 switch($temp[1]){
     case '01': $temp[1]  = 'gennaio'; break;
     case '02': $temp[1]  = 'febbraio'; break;
     case '03': $temp[1]  = 'marzo'; break;
     case '04': $temp[1]  = 'aprile'; break;
     case '05': $temp[1]  = 'maggio'; break;
     case '06': $temp[1]  = 'giugno'; break;
     case '07': $temp[1]  = 'luglio'; break;
     case '08': $temp[1]  = 'agosto'; break;
     case '09': $temp[1]  = 'settembre'; break;
     case '10': $temp[1]  = 'ottobre'; break;
     case '11': $temp[1]  = 'novembre'; break;
     case '12': $temp[1]  = 'dicembre'; break;

 }

  $dateNew = $temp[2].' '.$temp[1].' '.$temp[0].' , '.$temp[3].':'.$temp[4];

  return  $dateNew;
}


function truncate_words($text, $limit) {
  $words = preg_split("([\s])", $text, $limit + 1, PREG_SPLIT_NO_EMPTY);
  if ( count($words) > $limit ) {
      array_pop($words);
      $text = implode(' ', $words);
      //$text = $text . $ellipsis;
  }
  return $text;
}

 // echo '<pre>', print_r($res) ,'</pre>';

//  function truncate_words($text, $limit, $ellipsis = '...') {
//   $words = preg_split("([\s])", $text, $limit + 1, PREG_SPLIT_NO_EMPTY);
//   if ( count($words) > $limit ) {
//       array_pop($words);
//       $text = implode(' ', $words);
//       $text = $text . $ellipsis;
//   }
//   return $text;
// }