    
document.addEventListener('DOMContentLoaded', function() {

//quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
window.onbeforeunload = function () { 
  window.scrollTo(0, 0);
}

document.addEventListener('click', clickEvent);


function clickEvent(e){
//console.dir(e.target);

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

  switch (e.target.id){
    case 'portfolio':
      console.log('portfolio'); 
    break;
    case 'skill':
      var bg = document.querySelector('#skill-bg');
      bg.classList.add('show-bg'); 
    break;
    case 'contact':
     console.log('contact'); 
    break;
  }
 
}

/******************SCROLL LOADING ******************/

document.addEventListener('scroll', scrollLoad, false);

//altezzaTotale = document.body.scrollHeight; // [!]
let altezza = document.querySelector('#portfolio').offsetTop - window.innerHeight * 0.2;
state = ['init', 'portfolio', 'skill', 'contact', 'footer', 'end'];
let index = 0;

function scrollLoad(e){

  if ( window.scrollY > altezza ) {
    
    index++;

    switch( state[index] ) {

      case 'portfolio': //APRE PORTFOLIO ------------------------------------------------------
        console.log('portfolio loading'); 

        let cardTitle = ['Meteo', 'Social Network', 'Blog', 'Android Game', 'Wordpress', 'Appunti', 'Cryptovalute', 'Database'];
        let faIcon = ['s fa-sun', 'b fa-connectdevelop', 'b fa-blogger-b', 'b fa-android', 'b fa-wordpress', 's fa-sticky-note', 'b fa-bitcoin', 's fa-database'];
        let text =  ['descrizione1', 'descrizione2', 'descrizione3', 'descrizione4', 'descrizione5', 'descrizione6', 'descrizione7', 'descrizione8'];
        let address =  ['meteo', 'socialnetwork', 'blog', 'https://play.google.com/store/apps/details?id=com.manzidevelopment.fantasyflappy', 'wp-site', 'note', 'cryptocoin', 'database'];
        
        let portfolio = document.querySelector('#portfolio');

        let titleBox = document.createElement('div'); //  <div class="section-title"><p>Portfolio</p></div>
        titleBox.classList.add('section-title');
        let title = document.createElement('p'); 
        title.innerHTML = 'Portfolio';
        titleBox.appendChild(title);
        portfolio.appendChild(titleBox);
        
        let rowCard1 = document.createElement('div'); //  <div class="row">
        rowCard1.classList.add('row'); 

        let rowCard2 = document.createElement('div'); //  <div class="row">
        rowCard2.classList.add('row'); 

        portfolio.appendChild(rowCard1);
        portfolio.appendChild(rowCard2);

        for (let i=0; i<faIcon.length;  i++) {  

          let col = document.createElement('div'); // <div class="col-sm-6 col-md-3">  x4|x2
          col.classList.add('col-sm-6', 'col-md-3');  
        
          let card = document.createElement('div');// <div class="card mb-3">    x4|x2
          card.classList.add('card', 'mb-3');  
        
          let cardHeader = document.createElement('div');// <div class="card-header"><h4>Meteo</h4></div>   x4|x2
          cardHeader.classList.add('card-header');  

          let h4Title = document.createElement('h4'); // x4|x2
          h4Title.innerHTML = cardTitle[i];


          let cardIcon = document.createElement('div'); // <div class="card-fontawesome"> // x4|x2
          cardIcon.classList.add('card-fontawesome'); 
          cardIcon.innerHTML = '<i class="fa'+faIcon[i]+'"></i>';

          let cardBody = document.createElement('div'); //  <div class="card-body"> // x4|x2
          cardBody.classList.add('card-body');  

          let cardText = document.createElement('p'); //  <p class="card-text"> x4|x2
          cardText.classList.add('card-text');
          cardText.innerHTML = text[i];
          //FOOTER
          let cardFooter = document.createElement('div');     // <div class="card-footer bg-transparent"> x4|x2
          cardFooter.classList.add('card-footer', 'bg-transparent');

          let link = document.createElement('a');   //  <a href='https://github.com/redeluni/meteo' target="_blank" class="btn">Visita</a> x4|x2
          link.classList.add('btn');
          link.href = 'https://github.com/redeluni/'+address[i];   
          link.setAttribute('target', '"_blank');
          link.innerHTML = 'Visita';

          cardHeader.appendChild(h4Title);

          cardBody.appendChild(cardText);

          cardFooter.appendChild(link);
        
          card.appendChild(cardHeader);
          card.appendChild(cardIcon);
          card.appendChild(cardBody);
          card.appendChild(cardFooter);

          col.appendChild(card);

          if (i > 3) {

            rowCard1.appendChild(col);
          } else {
            rowCard2.appendChild(col);
          }
        }
        altezza = document.querySelector('#skill').offsetTop - window.innerHeight * 0.5;
        console.log('portfolio completato'); 
      break;  //CHIUDE PORTFOLIO


      case 'skill':  //APRE SKILLS ------------------------------------------------------
        console.log('skill loading'); 

        let skillsId = document.querySelector('#skill');
        let skill = ['html5', 'css3', 'javascript', 'jquery', 'php', 'mysql', 'bootstrap', 'git', 'github', 'photoshop', 'inkscape', 'angularjs'];

        for (let i=0; i<skill.length; i++) {

            let col = document.createElement('div');
            col.classList.add('col-auto');

            let icon = document.createElement('div');
            icon.innerHTML = '<i class="devicon-'+skill[i]+'-plain colored"></i>'; 
            icon.classList.add('skill-icon');
            icon.classList.add('visibile');

            col.appendChild(icon); 

            skillsId.children[1].appendChild(col);
        }
        var bg = document.querySelector('#skill-bg');
        bg.classList.add('show-bg'); 
     
        altezza = document.querySelector('#contact').offsetTop - window.innerHeight * 0.5;
        console.log('skills completato'); 
      break;  //CHIUDE SKILLS

      case 'contact': //APRE CONTACT ------------------------------------------------------
        console.log('contact loading'); 

        let form = document.querySelector('.form-group'); 
        let campi = ['nome', 'cognome', 'tel', 'email'];
        let tipo = ['text', 'text', 'tel', 'email'];
            
            for (let i=0; i<campi.length; i++) {
            
                let label = document.createElement('label');
                label.setAttribute('for', campi[i]);
                label.innerHTML = campi[i];
    
                form.appendChild(label); 
    
                let input = document.createElement('input');
                input.setAttribute('type', tipo[i] );  //   
                input.classList.add('form-control');
                input.setAttribute('name', campi[i]);    
                input.setAttribute('placeholder', campi[i]); 
              
                form.appendChild(input); 
            }
    
            let textarea = document.createElement('textarea');
            textarea.classList.add('form-control');
            textarea.setAttribute('rows', '4');  
            textarea.setAttribute('cols', '50');  
            textarea.setAttribute('name', 'testo');    
            textarea.setAttribute('placeholder', 'Descrivi il lavoro'); 
          
            form.appendChild(textarea); 
    
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
    
            form.appendChild(buttonBox); 
            form.classList.add('visibile');
    
          altezza = document.querySelector('#footer').offsetTop - window.innerHeight * 0.5;
          console.log('contact completato');
      break; // CHIUDE CONTACT 

 
      case 'footer':   //APRE FOOTER ------------------------------------------------------
        console.log('footer loading');

        let footer = document.querySelector('footer');
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

      //  let immagini = document.querySelectorAll('.footer-icon');

        let siteAddress = ['github.com/redeluni', 'twitter.com/JQALP', 'www.linkedin.com/in/daniele-manzi-b57529110/', 'www.facebook.com/daniele.manzi.83'];  
        let siteIcon = ['github', 'twitter', 'linkedin', 'facebook']; 

        for (let i=0; i<siteIcon.length;  i++) { 
            
          let col = document.createElement('div');   // <div class="col-sm-3">
          col.classList.add('col-sm-3');

          let link = document.createElement('a');   //  <a class="footer-icon" href="https://github.com/redeluni" target="_blank">
          link.classList.add('footer-icon');
          link.href = 'https://'+siteAddress[i];   
          link.setAttribute('target', '"_blank');

          let d = document.createElement('div');
          d.innerHTML = '<i class="fab fa-'+siteIcon[i]+'"></i>'; 
          d.classList.add('footer-fontawesome');
          d.classList.add('visibile');

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

/*****************CHIUDE*SCROLL LOADING ******************/


/*****JQUERY**********JQUERY*****JQUERY*****/

 /// SCROLL verso i DIV dopo aver cliccato un link della navbar
  $('.nav-link').click(function(){    
    var divId = $(this).attr('href');
     $('html, body').animate({
      scrollTop: $(divId).offset().top 
    }, 600);
  });



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






var risoluzione = $(window).width()+17; // ottiene la larghezza della finestra
$('#risoluzione').html('<p>' + risoluzione + '</p>');
$(window).resize(function() { // This will execute whenever the window is resized
    risoluzione = $(window).width()+17;
    $('#risoluzione').html('<p>' + risoluzione + '</p>');
});
            



});
     








