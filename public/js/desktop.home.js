    
//document.addEventListener('DOMContentLoaded', function() {

//quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
window.onbeforeunload = function () { 
    window.scrollTo(0, 0);

}

console.log('home');

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

      let head = document.querySelector('head');
       // FONTAWESOME --> <link href="img/fontawesome/css/fontawesome-all.min.css" rel="stylesheet">
       let fontawesome = document.createElement('link');
       fontawesome.setAttribute('rel', 'stylesheet');   
       fontawesome.setAttribute('href', '/img/fontawesome/css/fontawesome-all.min.css');  
       head.appendChild(fontawesome);

        // DEVICON --> <link rel="stylesheet" href="https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css">
        let devicon = document.createElement('link');
        devicon.setAttribute('rel', 'stylesheet');   
        devicon.setAttribute('href', 'https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css');  
        head.appendChild(devicon);


        let body = document.querySelector('body');

         // JQUERY --> src="/js/jquery.js"
        // let scriptJQ = document.createElement('script');
        // scriptJQ.setAttribute('src', '/js/jquery.js');   
        // body.appendChild(scriptJQ);
        
        // BOOTSTRAP <script src="/js/bootstrap.min.js"></script>  
        let scriptbootstrap = document.createElement('script');
        scriptbootstrap.setAttribute('src', '/js/bootstrap.min.js');  
        body.appendChild(scriptbootstrap);



     
        console.log('portfolio completato'); 
      break;  //CHIUDE PORTFOLIO

      case 'skill':  //APRE SKILLS ------------------------------------------------------
      console.log('skill loading'); 

      console.log('skills completato'); 
      break;  //CHIUDE SKILLS

      case 'contact': //APRE CONTACT ------------------------------------------------------
        console.log('contact loading'); 

        console.log('contact completato');
      break; // CHIUDE CONTACT 

      case 'footer':   //APRE FOOTER ------------------------------------------------------
        console.log('footer loading');

        console.log('footer completato');
      break; //CHIUDE FOOTER
    }
  }
}

/**********END SCROLL LOADING*********/


/*****JQUERY**********JQUERY*****JQUERY*****/
// NAVBAR e BUTTON on SCROLL
    var offset = 0;
    var duration = 300;
    
    var nav = document.querySelector('nav');
    
    //SCROLL EFFECT
    $(window).scroll(function() { 
        if ($(this).scrollTop() > offset)
        { 
            $("#btn-scroll").fadeIn(duration); //$("#btn-scroll").fadeTo(duration, 0.5);
            nav.classList.add('nav-bottom');
            nav.classList.remove('nav-top');
          
        }else{ 
            $("#btn-scroll").fadeOut(duration);
            nav.classList.add('nav-top');
            nav.classList.remove('nav-bottom');
        }
    });



$(".navbar-nav li a").click(function (event) { 
    // check if window is small enough so dropdown is created
    var toggle = $(".navbar-toggler").is(":visible");
    if (toggle) {
      $(".navbar-collapse").collapse('hide');
    }
  });




  /// SMOOTH SCROLL to all LINKS
  $(".nav-link").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
     



/** FOOTER **/

var risoluzione = $(window).width()+17; // ottiene la larghezza della finestra
$('#risoluzione').html('<p>' + risoluzione + '</p>');
$(window).resize(function() { // This will execute whenever the window is resized
    risoluzione = $(window).width()+17;
    $('#risoluzione').html('<p>' + risoluzione + '</p>');
});
            


$("#btn-scroll").click(function(event) {
    event.preventDefault();
    $("html, body").animate({scrollTop: 0}, duration);
    return false;
})////BUTTON SCROLL PAGE






//  $('.nav-item').click(function(){
//    $( ".navbar-toggler" ).click();
//     //$('.navbar-toggler').button('toggle'); 
// });
     
    /* 
     // When the user scrolls down 20px from the top of the document, show the button
     window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("btn-scroll").style.display = "block";
        } else {
            document.getElementById("btn-scroll").style.display = "none";
        }
    }

     // When the user clicks on the button, scroll to the top of the document
     function topFunction() {
         document.body.scrollTop = 0; // For Chrome, Safari and Opera 
         document.documentElement.scrollTop = 0; // For IE and Firefox
     }*///BUTTON SCROLL PAGE
    
   /* 
    $(window).resize(function() {
   if ( $("#btncontact").position().bottom - $("#header").position().bottom > 0 ) { alert('ok'); }
    });*/


//});
     








