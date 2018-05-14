<!DOCTYPE html>
<html lang="it">
  <head>
    <!-- Required meta tags always come first -->
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
     <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script> -->
    <!-- PRETTYPRINT -->
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?lang=css&amp;skin=sunburst"></script>
    <title>Il mio sito</title>
  </head>
  <body>
  <div id='box-sign'><h6 id='sign'>DANIELE MANZI</h6></div>
    <div class="<?=$this->grid?>">
      <?=$this->content?>
    </div>
  <script src="/js/jquery.js" ></script>
  <script src="/js/tether.js" ></script>
  <script src="/js/bootstrap.min.js"></script>  
  <!-- <script src="/js/script.js"></script>   -->
  <script src="/js/<?=$this->script?>.js"></script> 
  <!-- FONTAWESOME -->
  <!-- <script>FontAwesomeConfig = { searchPseudoElements: true };</script> -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
  </body>
</html>