<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Il mio sito e blog personale che parla di programmazione">
    <meta name="author" content="Daniele Manzi"> -->
    <!-- FAVICON -->
    <link rel="icon" href="/img/favicon.ico">
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
     <!-- CSS -->
    <link rel="stylesheet" href="/css/<?=$this->style?>.css">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <!-- DEVICON -->
    <!-- <link rel="stylesheet" href="https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css"> -->
    <!-- PRETTYPRINT -->
    <!-- <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?lang=css&amp;skin=sunburst"></script> -->
    <title>Il mio sito</title>
  </head>
  <body>
  <div id='box-sign'><h6 id='sign'>DANIELE MANZI</h6></div>
    <div class="<?=$this->grid?>">
      <?=$this->content?>
    </div>
    <!-- Da eliminare  -->
  <!-- <script src="/js/jquery.js"></script>   -->
  <!-- Mobile NO | Desktop NO -->
  <!-- <script src="/js/tether.js"></script>    -->
   <!-- Mobile NO -->
  <!-- <script src="/js/bootstrap.min.js"></script>   -->
  <script src="/js/<?=$this->script?>.js"></script> 
  </body>
</html>