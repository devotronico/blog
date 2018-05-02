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

        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
    

    }
    


    public function loadRoutes(array $routes){
        // inizializziamo l'array $routes con i dati presi dal file 'config/app.config.php'
        $this->routes = $routes;
    }



    public function getRoutes(array $routes=[]){

        return $this->routes;
    }



       // Gestione dell URL
       public function dispatch(){ 
        // LEGGIAMO l URL   
        // $_SERVER['REQUEST_URI'] è la stringa dopo il nome di dominio, es. da 'sito.it/pag?nome=max' ottiene solo '/pag?nome=max'   
        // Con parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)  in 'sito.it/pag?nome=max' ottiene solo '/pag' 
        // quindi dobbiamo eliminare le variabili se ci sono  
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // elimina il nome di dominio e le variabili dall 'indirizzo del sito

        // elimina '/' se si trova all' inizio o alla fine della stringa in $url es. '/pag' diventa 'pag'
        $url = trim($url, '/'); 
        $method = $_SERVER['REQUEST_METHOD']; // ottiene se ci sono il metodo POST o GET


    
        return $this->processQueue($url, $method);


    }





    
    protected function processQueue($uri, $method='GET'){

        $routes = $this->routes[$method]; // GET o POST

        // Cicla tutti gli Indici di GET oppure di POST
        // E viene controllato se la rotta esiste
        foreach ( $routes as $route => $callback ) { 


        //Se $method è uguale a 'GET'  $route può essere le seguenti stringhe: "", posts, post/create, post/:id, post/:postid/edit
        //Se $method è uguale a 'POST' $route può essere le seguenti stringhe: post/save, post/:id/store, post/:id/delete, post/:id/comment

        // $callback è il valore di $route
        // 'posts' => 'App\Controllers\PostController@getPosts'
        // Es. se la chiave di $route è 'posts' allora $callback è uguale a 'App\Controllers\PostController@getPosts'

            // converte url come '/post/:id' in regular expression
            // I caratteri speciali per le espressioni regolari sono . \\ + * ? [ ^ ] $ ( ) { } = ! < > | :
            // fa l escape ai caratteri come '/' oppure ':'
            // Es. la stringa 'post/:id' diventa 'post\\/\\:id'
            $regMatch = preg_quote($route); 
  

            // sostituisce qualsiasi cosa che inizia con  :id([a-zA-Z0-9\_\-]+)  con  post/([a-zA-Z0-9\_\-]+)

            // preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', 'post\\/\\:id');  diventa  'post\\/([a-zA-Z0-9\\-\\_]+)'
            // se la stringa nella varibile $regMatch è riconosciuta dal primo argomento verrà sostituita dal secondo argomento
     
            // Es. Il primo argomento '/\\\:[a-zA-Z0-9\_\-]+/' , in $regMatch = 'post\\/\\:id', trova corrispondenza '\:id'
            // La corrispondenza '\:id' viene sostituita dal secondo argomento in 'id'
            $subPattern = preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)',  $regMatch);
           
            

            // Se $route è uguale a 'post/:id' allora  $pattern = @^post/([a-zA-Z0-9\_\-]+)$@D
            $pattern = "@^" . $subPattern. "$@D";
           
           
            
            // $pattern = '@^post/([a-zA-Z0-9\_\-]+)$@D'
            // $uri = 'post/8'
            // $matches[0] = 'post/8'
            // $matches[1] = '8'
            $matches = [];
            if (preg_match($pattern, $uri, $matches)) { // $uri potrebbe essere 'post/2'
                // rimuove la prima parte trovata
                array_shift($matches); // elimina $matches[0] = 'post/8' e quindi rimane solo $matches[1] = '8'
                return $this->route($callback, $matches);
            }
        }
        throw new Exception('Nessuna rotta trovata col nome '.$uri);
    }





    protected function route($callback, array $matches =[])
    {
        try {
            if ( is_callable($callback) ) { //se trova la funzione

                return call_user_func_array($callback, $matches);
            }
            $tokens = explode('@', $callback); // es. spezziamo 'App\Controllers\PostController@getPosts',
            $controller = $tokens[0]; // assegniamo a $controller la classe PostController
            $method = $tokens[1]; // assegniamo a $method il metodo della classe PostController
            $class =  new $controller($this->conn); // creiamo un istanza della classe PostController
          
            
            if(method_exists($controller, $method)){
              
                call_user_func_array([$class, $method], $matches); 
              //  $class->$method();  // PostController->metodo
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