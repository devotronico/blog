<div id="cover">
    <!-- <img id="cover-animation" src='https://media.giphy.com/media/duVyjvb0c43gQ/giphy.gif' width="100%" height="100%" style="position:absolute"> -->
    <img id="cover-animation" src='/img/gif/d_anim.gif' width="100%" height="100%" style="position:absolute">
    <div id="cover-container">
        <div id="cover-box-image">
            <img id='cover-foto' src='/img/<?=$photo?>.jpg'> 
        </div>
        <div id="cover-box-info">
            <p id="cover-text">web developer</p>
            <a id="cover-btn" href="#contact">Contattami</a>
        </div>
    </div>
</div>
<div class="about">
    <div class="about-container">
    <div class="about__title"><h1>About this WebSite</h1></div>
        <div class="about__info-left">
         
                <h3>Linguaggi di programmazione</h3>
                <p class="about-text">Questo sito è realizzato in html css e javascript per il lato frontend<br> 
                mentre il backend è stato realizzato con php e mysql<br>  
                Al fine di migliorare le prestazioni e avere maggior controllo sul codice<br> 
                ho evitato di utilizzare CSM(es. Wordpress), framework(es. Angular, Laravel) o librerie(es. Jquery, Bootstrap) che<br> 
                facilitano lo sviluppo ma di contro appesantiscono le pagine in fase di caricamento.<br> 
                <br><br>

                <h3>Javascript Vanilla</h3>
                <p class="about-text">Nella programmazione lato client ho utilizzato esclusivamente il linguaggio Javascript<br> 
                senza appoggiarmi alla sua libreria Jquery,Questa scelta è dovuta dal fatto che<br>
                nonostante Jquery consente di scrivere meno codice ed è di più facile utilizzo,<br>
                è comunque una libreria che pesa nel caricamento della pagina,<br>
                inoltre col tempo puoi diventare obsoleta o non più supportata .</p><br><br> 
                
                <h3>OOP</h3>
                <p class="about-text">Nella programmazione lato server è stato usato il linguaggio php con il paradigma <a class="about-link" href="https://it.wikipedia.org/wiki/Programmazione_orientata_agli_oggetti" target="_blank">OOP</a> (Object Oriented Programming)<br> 
                questo consente di scrivere un codice più chiaro, ordinato e riutilizzabile e si integra perfettamente con il pattern MVC.</p><br><br> 

                <h3>Modello di progettazione</h3>
                <p class="about-text">Come modello di progettazione ho implementato il pattern <a class="about-link" href="http://html.it/pag/18299/il-pattern-mvc/" target="_blank">MVC</a> (Model View Controller).<br> 
                Utilizzando questo approccio allo sviluppo web otteniamo un codice più mantenibile e espandibile,<br> 
                che richiede sessioni minori per correggere gli errori e inoltre agevola il lavoro in team.</p><br><br> 
               
            </div>
            <div class="about__info-right">

                <h3>Routing</h3>
                <p class="about-text">per ragioni di SEO e quindi di una migliore indicizzazione sui motori di ricerca<br>
                 ho scelto di utilizzare piuttosto<a class="about-link" href="https://moz.com/learn/seo/url" target="_blank">URL statici</a> che dinamici.<br>
                 Gli URL statici offrono una struttura di logica a cartelle e parole chiave descrittive del contenuto di ogni pagina<br>
                 e sono più user-friendly poiché si può capire di cosa tratta la pagina semplicemente guardando il nome dell'URL statico.</p><br><br> 

                <h3>Caricamento dinamico</h3>
                <p class="about-text">La versione mobile di questo sito che è più avanti nello sviluppo rispetto a quella desktop,<br>
                carica gli elementi della home in modo dinamico in base alla posizione dello scrolling della pagina.<br> 
                In questo modo la pagina non viene caricata interamente alla sua richiesta ma caricherà solo la porzione di pagina<br>
                che l'utente andrà a visualizzare all' interno della pagina.<br> 
                Questo metodo incrementa notevolmente la velocità di caricameno delle pagine.</p><br><br> 
               
                
                <h3>Supporto per diversi dispositivi</h3>
                <p class="about-text">Per adattare il sito a diversi tipi di dispositivi mobile e desktop<br> 
                non mi sono limitato a utilizzare le media query del css<br> 
                ma ho implementato via javascript e php un sistema che rileva la tipologia di dispositivo su cui è aperto il sito,<br> 
                In base al dispositivo vengono caricati file e script specifici per esso,<br>
                questo metodo consente di programmare in modo più incisivo per i diversi dispositivi,<br> 
                questo porta a un' ottimizzazione del codice, incremento delle prestazione e miglioramento dell'esperienza utente.</p><br><br>  
               
                <h3>Prossimi obiettivi</h3>
                <ul class="about-text">
                    <li>implementazione di un sistema di ecommerce</li>
                    <li>caricamento dinamico di tutte le pagine della versione mobile e desktop</li>
                    <li>nuove funzionalità nel blog</li>
                    <li>integrazione con i social network</li>
                    <li>inserimento di annunci pubblicitari</li>
                </ul>
        </div>
    </div>
</div>



