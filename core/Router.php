<?php

//use App\Controllers;

class Router
{
    protected $conn;

    protected $routes = [

        'GET'=>[],
        'POST'=>[],
    ];

  
    
    public function __construct(\PDO $conn){ 

        $this->conn = $conn; 

    }
    


    public function loadRoutes(array $routes){
        // inizializziamo l'array $routes con i dati presi dal file 'config/app.config.php'
        $this->routes = $routes;
    }


/*
    public function getRoutes(array $routes=[]){

        return $this->routes;
    }
*/


    // questo metodo ci da GET/POST e la Path es. 'post/2'
    public function dispatch(){ 
    // LEGGIAMO l URL   
    // $_SERVER['REQUEST_URI'] è la stringa dopo il nome di dominio, es. da 'sito.it/pag?nome=max' ottiene solo '/pag?nome=max'   
    // Con parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)  in 'sito.it/pag?nome=max' ottiene solo '/pag' 
    // quindi dobbiamo eliminare le variabili se ci sono  
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // elimina il nome di dominio e le variabili dall 'indirizzo del sito

    $uri = trim($uri, '/'); // elimina il carattere speciale '/' all'inizio e alla fine della stringa | es. '/post/2' diventa 'post/2'



    $method = $_SERVER['REQUEST_METHOD']; // ottiene se ci sono il metodo POST o GET

    return $this->processQueue($uri, $method);
    }



    
    protected function processQueue($uri, $method='GET'){

        $routes = $this->routes[$method]; // GET o POST


        // Cicla tutti gli Indici di GET oppure di POST
        // E viene controllato se la rotta esiste
        foreach ( $routes as $route => $callback ) { 
        // $route = post/:id
        // $callback = App\Controllers\HomeController@home, App\Controllers\PostController@getPosts, App\Controllers\PostController@create,
        // $callback è il valore di $route    
        //Se $method è uguale a 'GET'  $route può essere le seguenti chiavi: "", posts, post/create, post/:id, post/:postid/edit
        //Se $method è uguale a 'POST' $route può essere le seguenti chiavi: post/save, post/:id/store, post/:id/delete, post/:id/comment

  
      
        $hasPlaceholder = false;
        if ( substr($route, 0, 1) == '#' ) {

            $route = substr( $route, 1 );
            $hasPlaceholder = !$hasPlaceholder;
       
        }
         

        if ( $hasPlaceholder) {

        // fa l escape ai caratteri come ':' in questo modo '\:'
        // I caratteri speciali per le espressioni regolari sono . + * ? [ ^ ] $ ( ) { } = ! < > | :
        // Es. la stringa 'post/:id' diventa 'post/\:id'
        $route = preg_quote($route); 
     
          
        /* CONTROLLIAMO SE LE ROTTA HA UN PLACEHOLDER COME ':' SEGUITO DA UNA SERIE DI CARATTERI */
        // argomento 1 = Pattern di ricerca --------------> '/\\\:[a-zA-Z0-9\_\-]+/'
        // argomento 2 = La stringa che verrà sostituita -> '([a-zA-Z0-9\-\_]+)'
        // argomento 3 = Stringa da modificare -----------> 'post/\:id'
        // preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', 'post/\:id');  diventa  'post/([a-zA-Z0-9\-\_]+)'
        // La corrispondenza '\:id' in 'post/\:id' viene sostituita da '([a-zA-Z0-9\-\_]+) quindi diventa 'post/([a-zA-Z0-9\-\_]+)
        // se una parte della stringa nella varibile $route è riconosciuta dal primo argomento verrà sostituita dal secondo argomento
        // Es. Il primo argomento '/\\\:[a-zA-Z0-9\_\-]+/' , in $route = ''post/\:id', trova corrispondenza in '\:id'
        //preg_replace ( pattern di ricerca, con cosa sostituire, dove cercare )
        
        $route = preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', $route); // $pattern = 'post/([a-zA-Z0-9\-\_]+)' 
        }

        // PREPARIAMO LA VARIABILE '$pattern' PER ESSERE CONFRONTATA CON LA VARIABILE $uri 
        // la stringa 'post/([a-zA-Z0-9\-\_]+)' non può avere come delimitatori il carattere '/' perchè lo stesso carattere è all'interno della stringa 
        // Quindi avvolgiamo la stringa 'post/([a-zA-Z0-9\-\_]+)' con un altro carattere non alfanumerico. es. il carattere '@'
        $route = "@^". $route. "$@"; // = @^post/([a-zA-Z0-9\_\-]+)$@
           
          
            

        // CONFRONTIAMO IL PATTERN CHE ABBIAMO FABBRICATO CON LA URI DELL'URL
        // argomento 1 = $pattern = Pattern di ricerca ---> '@^post/([a-zA-Z0-9\_\-]+)$@D'
        // argomento 2 = $uri     = La stringa dell' url -> 'post/2'
        // argomento 3 = $matches = Array di ritorno -----> [0 => 'post/2',   1 => '2']
        $matches = [];
        if (preg_match($route, $uri, $matches)) { // $uri potrebbe essere 'post/2'

            // rimuove il primo elemento dell'array {'post/2'} perchè non è utilizzabile per passarlo come parametro del metodo
            // ci teniamo il secondo elemento dell'array {'2'} per passarlo come parametro del metodo della classe che chiameremo
            // se il path è 'posts' allora $matches[0] = 'posts' e $matches[1] = null 
            // si può passare un argomento null anche se il metodo non vuole nessun argomento
            array_shift($matches); // elimina $matches[0] = 'post/2' e quindi rimane solo $matches[1] = '2'
            return $this->callMethod($callback, $matches); 
        }
           
        }
        throw new Exception('Nessuna rotta trovata col nome '.$uri);
    }





    protected function callMethod($callback, array $matches=[])
    {
        try {
            if ( is_callable($callback) ) { //se trova la funzione
              die('Errore in classe '.__CLASS__.' metodo '.__METHOD__);
              // al momento non si attiva mai perchè non esitono funzioni tipo come App\Controllers\PostController@getPosts'
              // dobbiamo spezzare dove sta il simbolo '@' per ricavarne il metodo     
                return call_user_func_array($callback, $matches);
            }
            $tokens = explode('@', $callback); // es. spezziamo 'App\Controllers\PostController@getPosts',
            $controller = $tokens[0]; // assegniamo a $controller la classe PostController
            $method = $tokens[1]; // assegniamo a $method il metodo della classe PostController
            $class = new $controller($this->conn); // creiamo un istanza della classe PostController          
            
            if(method_exists($controller, $method)){ // Se il metodo trovato esiste
              
                call_user_func_array([$class, $method], $matches); //es. ([PostController, delete], 8)
           
                return $class;
            } else {
                throw new Exception('Il metodo '.$method.' non esiste nella classe '.$controller);
            }
        } catch (Exception $e){
            die($e->getMessage());
        }
       
    }

}
 

    
   

        














 
    /*
        $str = explode('/', $url); // se $url = post/2  allora  $str['0'] = post e  $str['1'] = 2

        switch ( $str['0'] )
        {
            case '': 
            case 'home': 
            case 'posts': 
                //$this->content = call_user_func(array($this, 'getPosts')); // chiamiamo il metodo 'getPosts' di questa classe
                $this->content = $this->getPosts(); // chiamiamo il metodo 'getPosts' di questa classe
            break;
            case 'post': 
                if ( $_SERVER['REQUEST_METHOD'] === 'GET' ){           
                            
                    if ( is_numeric($str['1']) ) { // is_numeric considera numeri anche quelli tra virgolette. es. '35' da true
                        $this->content = $this->show($str['1']); //chiama il metodo 'Show' di questa classe | $str['1'] è il param di Show($str['1']) 

                    }
                    else { //  $str['1'] = create
                        $this->content = $this->create(); //   
                    }
                } else   if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){           
                            
                    if ( is_numeric($str['1']) ) { // is_numeric considera numeri anche quelli tra virgolette. es. '35' da true
                        $this->content = $this->update($str['1']); //chiama il metodo 'update' di questa classe | $str['1'] è il param di Show($str['1']) 

                    }
                    else {  //  $str['1'] = save
                        $this->content = $this->save(); //   
                    }
                }
            break;
        //  default: $this->content = call_user_func(array($this, 'getPosts')); 
        }
        return $this->content;
    }

    */
?>