import {initCanvas, canvasResize, indexOfBall, animate} from "./modules/canvas.js"; // <--import deve andare prima dell evento 'DOMContentLoaded'
import{request} from "./modules/request.js";
import{project} from "./modules/project.js";
import{skill} from "./modules/skill.js";
import{contact} from "./modules/contact.js";
import{footer} from "./modules/footer.js";
import{about} from "./modules/about.js";
import{debug} from "./modules/debug.js";
import{navbarRefresh, navbarClick, navbarScroll, navbarResize} from "./modules/navbar.js";




    
//==VARIABILI==    
let containerList = document.querySelectorAll('.wrapper'); // il numero dei contenitori da scrollare
let num; // contatore dei contenitori
let elemetCreated = [];
const heightTrigger = -200 // window.innerHeight/2; // variabile che determina in che altezza della pagina attivare il prossimo canvas
let play = true; // attiva e disattiva l' animazione
const listOffSetTop = []; // lista del valore 'offsetTop' di ogni contenitore
for (let i=0; i<containerList.length; i++) { 
    listOffSetTop.push(containerList[i].offsetTop); // inizializza la lista di 'offsetTop' 
} 


// console.dir('altezza con scroll 1 : '+document.scrollingElement.scrollTop+' e num: '+num);
// console.dir('altezza con scroll 2 : '+window.scrollY+' e num: '+num);



function loadSection(){
    
    if ( window.scrollY > listOffSetTop[0] + heightTrigger && window.scrollY < listOffSetTop[1] + heightTrigger ) { 
        if (num != 0) {num = 0; play = false;} 
    }
    else if ( window.scrollY > listOffSetTop[1] + heightTrigger && window.scrollY < listOffSetTop[2] + heightTrigger ) {
        if (num != 1) {num = 1; play = false;}   
    }
    else if ( window.scrollY >= listOffSetTop[2] + heightTrigger && window.scrollY < listOffSetTop[3] + heightTrigger ) {
        if (num != 2) {num = 2; play = false;}  
    }
    else if ( window.scrollY >= listOffSetTop[3] + heightTrigger && window.scrollY < listOffSetTop[4] + heightTrigger ) {
        if (num != 3) {num = 3; play = false;}  
    }
    else if ( window.scrollY >= listOffSetTop[4] + heightTrigger ) {
        if (num != 4) {num = 4; play = false}  
    } 
    else // se ci troviamo nella sezione cover(dove non ci sono canvas) disattiviamo l'animazione dell' ultimo canvas che abbiamo visualizzato
    {
        play = false; 
        indexOfBall(num); // disattiva l'animazione a ultima palla
        animate(play);  // disattiva l'animazione a ultimo palla 
    return
    }
    // console.log(num)
    if ( num != undefined ) { // console.log('DEFINED'); 
        if (!elemetCreated[num]) { // se il canvas e la palla non sono stati ancora creati
            elemetCreated[num] = true; // settiamo questo elemento con il canvas e la palla come creati
        
            let color1 = '#fff';
            let color2 = '#2c8cff';
    
            switch (num) {

                case 0: initSection("vertical", project, 'project', color2, color1); break;
                case 1: initSection("vertical", skill, 'skill', color1, color2); break;
                case 2: initSection("vertical", contact, 'contact', color2, color1); break;
                case 3: initSection("test", about, 'about', color1, color2); break;
                case 4: initSection("horizontal", footer, 'footer', color1, color2); break;
            } // END SWITCH
        } 

        if ( num != 3 ) {
            // SELEZIONA CANVAS E BALL 
            if ( !play ) {
                indexOfBall(num); // disattiva l'animazione a questa palla
                animate(play);  // disattiva l'animazione a questa palla
                if ( window.innerWidth >= 320 ) { 
                    play = true;
                    animate(play);
                    
                }
            }
            // END SELEZIONA CANVAS E BALL 
        }
    }
}


function initSection(direction, sectionFunction, sectionString, color1, color2 ){

    let section = document.querySelector(".section-"+num); // seleziona la riga
    let col = document.createElement("div"); // contenitore senza canvas
    col.classList.add("col-"+direction); // aggiunge classe al contenitore senza canvas
    col.classList.add("col-"+num); // aggiunge classe al contenitore senza canvas
    section.appendChild(col); // appende il contenitore senza canvas nel contenitore 'section'
    section.classList.add('section-anim-alpha');
    request(sectionFunction, sectionString, col); // chiamata XMLHttpRequest

    if ( num != 3 ) {
        // CREA CANVAS E BALL 
        let bgColor = color1; // colore sfondo canvas
        let ballColor = color2; // colore palla    
        let canvasBox = document.createElement("div"); // contenitore del canvas
        canvasBox.classList.add("col-"+direction+"-canvas");
        canvasBox.classList.add("col-canvas-"+num);
        section.appendChild(canvasBox);
        initCanvas(num, canvasBox, bgColor, ballColor); // crea un canvas e la sua palla
        // END CREA CANVAS E BALL 
    }
}



//========================================================================================================================
// EVENTI
//========================================================================================================================
// REFRESH DELLA PAGINA --------------------------------------------------------------------------
loadSection();  // carica la sezione attuale al refresh della pagina
navbarRefresh(); 
// END REFRESH DELLA PAGINA ----------------------------------------------------------------------




// SCROLL ----------------------------------------------------------------------------------------

document.addEventListener('scroll', scrollFunc); // evento scroll

function scrollFunc() { // funzione di scroll
    
    loadSection();
    navbarScroll();
    debug(listOffSetTop, heightTrigger. num); 
}// chiude funzione scrollFunc




// CLICK ----------------------------------------------------------------------
document.addEventListener('click', function(e){

    navbarClick(e);
    //navbarEffect();
    play = !play;
    switch ( e.target.id )
    {
        case 'project': indexOfBall(0); break;
        case 'skill': indexOfBall(1); break;
        case 'contact': indexOfBall(2); break;
        case 'footer': indexOfBall(3); break;
    } 
    animate(play);
});
// END CLICK ----------------------------------------------------------------------




// RESIZE ----------------------------------------------------------------------
/*
* OTTIMIZZAZIONI PER IL RESIZE
* http://loopinfinito.com.br/2013/09/24/throttle-e-debounce-patterns-em-javascript/
* https://davidwalsh.name/javascript-debounce-function
* https://www.html5rocks.com/en/tutorials/speed/animations/
*/
window.addEventListener('resize', function(){
    navbarResize();
    canvasResize();
});
// END RESIZE ----------------------------------------------------------------------




let downloadingImage = new Image();


downloadingImage.src = "/img/gif/cover_anim.gif";


downloadingImage.onload = function() {

  
    document.querySelector(".loader").classList.add('hidden');
    let elements = document.querySelector("#cover__animation-gif");
    console.log('oooooooookkkkkkkkk');
    // let photo = document.querySelector("#cover__photo");
    // photo.classList.add('cover__photo__animation');

    elements.src =  this.src;   
    document.body.style.overflow = 'visible'; // attiva lo scroll
}








