<?php
namespace App\Controllers;

use App\Models\Blog;

use \PDO;

class BlogController extends Controller
{
    protected $Blog ;

  
    public function __construct(PDO $conn) { 
  
        parent::__construct(); 
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->Blog = new Blog($conn);  // creiamo qui un istanza della classe 'Blog' e gli passiamo la connessione al database
       
    }

/***********************************************************************************************************************|
* GETPOSTS          metodo = GET    route = posts/page/id                                                               |
* Otteniamo tutti i post di una pagina                                                                                  |     
* Se ci sono i post allora viene caricato anche il template della paginazione                                           |   
* Spiegazione Paginazione                                                                                               |
* 'page' è la il numero della pagina in cui ci troviamo                                                                 |
* 'postForPage' è il numero di post che ci sono per ogni pagina                                                         |
* 'postStart' è uguale al numero precedente del primo post della pagina in cui ci troviamo                              |
* Se ci troviamo nella pagina 3 {'currentPage'=3} e abbiamo deciso che ogni pagina deve avere 2 post{'postForPage'=2}   |
* allora il primo post della terza pagina deve essere il post numero 4{'postStart'=4}                                   |
* 1  2  3 pagine {'currentPage'}                                                                                        |
* 12 34 56 il numero dei post che visualizza se abbiamo impostato {'postForPage'=2}                                     |
* 0  2  4 sono i valori che ci servono per cominciare a contare i post da visualizzare {'postStart'}                    |
************************************************************************************************************************/
public function getPosts($currentPage=1){ 
   
    if ( isset($_COOKIE['user_id']) ) {
     
         $this->Blog->loginWithCookie(); 
    }

    $totalPosts = $this->Blog->totalPosts();
    $link="posts";
    if ( empty($totalPosts ) ) { 
        $this->page = 'empty';
        $files=[$this->device.'.navbar-blog', 'post.empty'];
        $this->content = View($this->device, 'blog', $files, compact('link', 'page')); 

     } else {
        $this->page = 'blog';
        $postForPage = $this->device === 'desktop'? 5 : 3;
        for ($i=0, $postStart=-$postForPage; $i<$currentPage; $postStart+=$postForPage, $i++);
        $posts = $this->Blog->pagePosts($postStart, $postForPage); 
        $dates = $this->Blog->getDates();
        $files=[$this->device.'.navbar-blog', 'blog.posts', 'blog.aside', 'blog.pagination', 'blog.footer'];
        $this->content = View($this->device, 'blog', $files, compact('link', 'posts', 'dates', 'currentPage', 'totalPosts', 'postForPage')); 
     }
}
    

//getPostsByDate
/***************************************************************************************|
* GET POST BY DATE      metodo = GET    path = post/id                                  |
* questa classe mostrerà un solo post e mostrerà tutti i commenti legati a questo post  |
****************************************************************************************/
public function getPostsByDate($month, $year){ 
    $link="posts";
    $this->page = 'blog';
    $totalPosts = $this->Blog->totalPosts();
   
    
        if ( empty($totalPosts ) ) { 
            $this->page = 'empty';
            $files=[$this->device.'.navbar-blog', 'post.empty'];
            $this->content = View($this->device, 'blog', $files, compact('link', 'page')); 

        } else {
       
            $this->page = 'blog';
        
            $posts = $this->Blog->postsByDate($month, $year); 
            $dates = $this->Blog->getDates();
            $files=[$this->device.'.navbar-blog', 'blog.posts', 'blog.aside', 'blog.footer'];
            $this->content = View($this->device, 'blog', $files, compact('link', 'posts', 'dates')); 
    
        } 
    }



} // chiude classe BlogController

