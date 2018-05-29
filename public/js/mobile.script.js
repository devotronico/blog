    
document.addEventListener('DOMContentLoaded', function() {

//quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
window.onbeforeunload = function () { 
  window.scrollTo(0, 0);
}

/*
document.addEventListener('click', clickEvent);
function clickEvent(e){
  switch (e.target.className)
  {
    case 'nav-link':
      var toggle = document.querySelector(".navbar-toggler").disabled; 
      if ( !toggle ) { // se il pulsante del menù non è disattivato
        var navbar = document.querySelector("#navbar-div");  // 
        //console.dir(navbar);
        navbar.classList.remove('show'); // rimuoviamo la classe di bootstrap che mostra i link
        navbar.classList.add('hidden');  // aggiungiamo la classe di bootstrap che nasconde i link
      }     
    break;
    case 'section':
     console.log('section'); 
    break;
  }
}
*/


/********** NAVBAR SENZA BOOTSTRAP **********/
document.addEventListener('touchstart', clickFunc, false); // mouseenter

let navState = false;

function clickFunc(e){ 
   console.dir(e.target.parentNode);
    let nav = document.querySelector('nav');
if ( e.target.parentNode.localName === 'header' ) {  console.log('ok')}

    if (e.target.href === undefined) {  
        
        e.target.classList.toggle('active');
        if (e.target.id === 'toggleNav') {

            if ( navState === false) {
              
                nav.style.display = 'block';
            } else {
              
                nav.style.display = 'none';
            }
            navState = !navState;
        }
    } else {  

    var goToId = e.target.hash.slice(1);

        if ( goToId !== "" ) {

            smoothScroll(document.getElementById(goToId))
            navState = false;
            nav.style.display = 'none';
            let toggleNav = document.querySelector('#toggleNav');
            toggleNav.classList.toggle('active');
        }
    }
}


window.smoothScroll = function(target) {
    var scrollContainer = target;
    do { //find scroll container
        scrollContainer = scrollContainer.parentNode;
        if (!scrollContainer) return;
        scrollContainer.scrollTop += 1;
    } while (scrollContainer.scrollTop == 0);
    
    var targetY = 0;
    do { //find the top of target relatively to the container
        if (target == scrollContainer) break;
        targetY += target.offsetTop;
    } while (target = target.offsetParent);
    
    scroll = function(c, a, b, i) {
        i++; if (i > 30) return;
        c.scrollTop = a + (b - a) / 30 * i;
        setTimeout(function(){ scroll(c, a, b, i); }, 20);
    }
    // start scrolling
    scroll(scrollContainer, scrollContainer.scrollTop, targetY, 0);
}
/********** END NAVBAR SENZA BOOTSTRAP **********/





/**********SCROLL LOADING*********/

document.addEventListener('scroll', scrollLoad, false);

//altezzaTotale = document.body.scrollHeight; // [!]

let altezza = document.querySelector('#portfolio').offsetTop - window.innerHeight * 0.8;
state = ['init', 'portfolio', 'skill', 'contact', 'footer', 'end'];
let index = 0;


function scrollLoad(e){

  if ( window.scrollY > altezza ) {
    
    index++;

    switch( state[index] ) {

      case 'portfolio': //APRE PORTFOLIO ------------------------------------------------------
        console.log('portfolio loading'); 
/*
        // <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        let fontawesome = document.createElement('link');
        fontawesome.setAttribute('rel', 'stylesheet');   
        fontawesome.setAttribute('href', 'https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css');  
        fontawesome.setAttribute('integrity', 'sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp'); 
        fontawesome.setAttribute('crossorigin', 'anonymous'); */

        //  <link rel="stylesheet" href="https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css">
        let devicon = document.createElement('link');
        devicon.setAttribute('rel', 'stylesheet');   
        devicon.setAttribute('href', 'https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css');

        let head = document.querySelector('head');
      //  head.appendChild(fontawesome);
        head.appendChild(devicon);

         // src="/js/jquery.js"
        let scriptJQ = document.createElement('script');
        scriptJQ.setAttribute('src', '/js/jquery.js');   
        let body = document.querySelector('body');
        body.appendChild(scriptJQ);



        let titleList = ['Meteo', 'Social Network', 'Blog', 'Android Game', 'Wordpress', 'Appunti', 'Cryptovalute', 'Database'];
        let faIcon = ['s fa-sun', 'b fa-connectdevelop', 'b fa-blogger-b', 'b fa-android', 'b fa-wordpress', 's fa-sticky-note', 'b fa-bitcoin', 's fa-database'];
        let address =  ['meteo', 'socialnetwork', 'blog', '', 'wp-site', 'note', 'cryptocoin', 'database'];
        
        let portfolio = document.querySelector('#portfolio');
        portfolio.classList.add('visibileBlue');

        let titleBox = document.createElement('div'); 
        titleBox.classList.add('section-title');
        let title = document.createElement('p'); 
        title.innerHTML = 'Portfolio';
        titleBox.appendChild(title);
        portfolio.appendChild(titleBox);
        

        for (let i=0; i<faIcon.length;  i++) {  

          let card = document.createElement('div');
          card.classList.add('card');  
          
          let cardBody = document.createElement('div'); 
          cardBody.classList.add('card-body');  
       
          let cardTitle = document.createElement('h5'); 
          cardTitle.innerHTML = titleList[i];

          let link = document.createElement('a');  
          link.classList.add('btn', 'btn-primary', 'card-icon');
          link.href = 'https://github.com/redeluni/'+address[i];   
          link.setAttribute('target', '"_blank');
          link.innerHTML = '<i class="fa'+faIcon[i]+'"></i>';

          cardBody.appendChild(cardTitle);
          cardBody.appendChild(link);
          card.appendChild(cardBody);
          portfolio.appendChild(card);
        }
       


        altezza = document.querySelector('#skill').offsetTop - window.innerHeight * 0.8;
        console.log('portfolio completato'); 
      break;  //CHIUDE PORTFOLIO


      case 'skill':  //APRE SKILLS ------------------------------------------------------
      console.log('skill loading'); 

      let skillsId = document.querySelector('#skill');
      skillsId.classList.add('visibileWhite');

      let sTitleBox = document.createElement('div'); 
      sTitleBox.classList.add('section-title');
      let sTitle = document.createElement('p'); 
      sTitle.innerHTML = 'Skills';
      sTitleBox.appendChild(sTitle);
      skillsId.appendChild(sTitleBox);

      let row = document.createElement('div');                      
      row.classList.add('row', 'justify-content-center');                   
      skillsId.appendChild(row);

      let skill = ['html5', 'css3', 'javascript', 'jquery', 'php', 'mysql', 'bootstrap', 'git', 'github', 'photoshop', 'inkscape', 'angularjs'];

      for (let i=0; i<skill.length; i++) {

          let col = document.createElement('div');
          col.classList.add('col-auto');

          let icon = document.createElement('div');
          icon.innerHTML = '<i class="devicon-'+skill[i]+'-plain colored"></i>'; 
          icon.classList.add('skill-icon');
         
          col.appendChild(icon); 
          row.appendChild(col);
      }
      let bg = document.createElement('div');    
      bg.classList.add('show-bg');                //  <div id="skill-bg"></div>
      bg.id = "skill-bg"; 
      skillsId.appendChild(bg);
   
      altezza = document.querySelector('#contact').offsetTop - window.innerHeight * 0.8;
      console.log('skills completato'); 
      break;  //CHIUDE SKILLS


      case 'contact': //APRE CONTACT ------------------------------------------------------
        console.log('contact loading'); 

        let campi = ['nome', 'cognome', 'tel', 'email'];
        let tipo = ['text', 'text', 'number', 'email'];

        let contact = document.querySelector('#contact'); // <div class="form-group">
        contact.classList.add('visibileGray');

        let fTitleBox = document.createElement('div'); 
        fTitleBox.classList.add('section-title');
        let fTitle = document.createElement('p'); 
        fTitle.innerHTML = 'Contatti';
        fTitleBox.appendChild(fTitle);
        contact.appendChild(fTitleBox);

        let form = document.createElement('form'); 
        form.classList.add('contact-form');
        form.setAttribute('method', 'post');   
        form.setAttribute('action', '/home/contact'); //  form.setAttribute('action', 'email.php'); 
        contact.appendChild(form);

        let formGroup = document.createElement('div'); // <div class="form-group">
        formGroup.classList.add('form-group');
        form.appendChild(formGroup);
            
            for (let i=0; i<campi.length; i++) {
            
                let label = document.createElement('label');
                label.setAttribute('for', campi[i]);
                label.innerHTML = campi[i];
    
                formGroup.appendChild(label); 
    
                let input = document.createElement('input');
                input.setAttribute('type', tipo[i] );  //   
                input.classList.add('form-control');
                input.setAttribute('name', campi[i]);    
                input.setAttribute('placeholder', campi[i]); 
              
                formGroup.appendChild(input); 
            }
    
            let textarea = document.createElement('textarea');
            textarea.classList.add('form-control');
            textarea.setAttribute('rows', '4');  
            textarea.setAttribute('cols', '50');  
            textarea.setAttribute('name', 'testo');    
            textarea.setAttribute('placeholder', 'Descrivi il lavoro'); 
          
            formGroup.appendChild(textarea); 
    
            let button = document.createElement('input');
            button.classList.add('btn');
            button.classList.add('center-block');
            button.setAttribute('type', 'submit');  
            button.setAttribute('name', 'submit');  
            button.setAttribute('id', 'submit');    
            button.setAttribute('value', 'invia'); 
    
            let buttonBox = document.createElement('div');
            buttonBox.classList.add('btn-box');
            buttonBox.classList.add('text-center');
            buttonBox.appendChild(button);
    
            formGroup.appendChild(buttonBox); 
    
          altezza = document.querySelector('#footer').offsetTop - window.innerHeight * 0.8;
          console.log('contact completato');
      break; // CHIUDE CONTACT 

 
      case 'footer':   //APRE FOOTER ------------------------------------------------------
        console.log('footer loading');

        let siteAddress = ['github.com/redeluni', 'twitter.com/JQALP', 'www.linkedin.com/in/daniele-manzi-b57529110/', 'www.facebook.com/daniele.manzi.83'];  
        let siteIcon = ['github', 'twitter', 'linkedin', 'facebook']; 

        let footer = document.querySelector('footer');
        footer.classList.add('visibileBlue');
        let rowIcon = document.createElement('div');
        rowIcon.classList.add('row', 'justify-content-center'); // row justify-content-center
        let rowCopy = document.createElement('div');
        rowCopy.classList.add('row', 'justify-content-center'); // row justify-content-center

        let dan = document.createElement('p'); // <p id="copyright">&copy;&nbsp;Daniele Manzi 2018</p>
        dan.id = "copyright";
        dan.innerHTML = '&copy;&nbsp;Daniele&nbsp;Manzi&nbsp;2018';
        rowCopy.appendChild(dan);
        footer.appendChild(rowIcon);
        footer.appendChild(rowCopy);

        for (let i=0; i<siteIcon.length;  i++) {  

          let col = document.createElement('div');   
          col.classList.add('col-sm-3'); //  col-auto     col-sm-3

          let link = document.createElement('a');   
          link.classList.add('footer-icon');
          link.href = 'https://'+siteAddress[i];   
          link.setAttribute('target', '"_blank');

          let d = document.createElement('div');
          d.innerHTML = '<i class="fab fa-'+siteIcon[i]+'"></i>'; 
          d.classList.add('footer-fontawesome');

          rowIcon.appendChild(col); 
          col.appendChild(link); 
          link.appendChild(d);
        }
        document.removeEventListener('scroll', scrollLoad);
        console.log('footer completato');
      break; //CHIUDE FOOTER
    }
  }
}

/**********END SCROLL LOADING*********/



/*****JQUERY**********JQUERY*****JQUERY*****/

///SMOOTH SCROLL AL DIV JQUERY
// SCROLL verso i DIV dopo aver cliccato un link della navbar 
/*
$('.nav-link').click(function(){    
  var divId = $(this).attr('href');
   $('html, body').animate({
    scrollTop: $(divId).offset().top 
  }, 600);
});
*/
// CHIUDE LO SMOOTH SCROLL AL DIV


//BUTTON FADEIN on PAGE SCROLL  
// Quando scrolliamo la pagina 
// se la distanza dalla cima della pagina è maggiore di 'offset'
// "#btn-scroll" appare
$(window).scroll(function() { 
  var offset = 0;
  var fadeTime = 300;
    if ($(this).scrollTop() > offset)
    { 
        $("#btn-scroll").fadeIn(fadeTime); //$("#btn-scroll").fadeTo(duration, 0.5);
    }else{ 

        $("#btn-scroll").fadeOut(fadeTime);
    }
});

//AUTOMATIC SCROLL To TOP PAGE on BUTTON CLICK
$("#btn-scroll").click(function(event) {
 // event.preventDefault();
  var time = 300;
  $("html, body").animate({scrollTop: 0}, time);
  //return false;
})////BUTTON SCROLL PAGE




/*

var risoluzione = $(window).width()+17; // ottiene la larghezza della finestra
$('#risoluzione').html('<p>' + risoluzione + '</p>');
$(window).resize(function() { // This will execute whenever the window is resized
    risoluzione = $(window).width()+17;
    $('#risoluzione').html('<p>' + risoluzione + '</p>');
});
            
*/


});
     








