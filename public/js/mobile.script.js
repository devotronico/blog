    
document.addEventListener('DOMContentLoaded', function() {

//quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
window.onbeforeunload = function () { 
  window.scrollTo(0, 0);
}

/*
//CLICK sul LINK della NAVBAR quando la NAVBAR è collassata //
  $("a.nav-link").click(function (event) { 
    // check if window is small enough so dropdown is created
    var toggle = $(".navbar-toggler").is(":visible");
    if (toggle) {
     // $(".navbar-collapse").collapse('hide'); // navbar-div
      $("#navbar-div").collapse('hide'); // 
    }
  });
*/
//document.addEventListener('scroll', function);
document.addEventListener('scroll', scrollEvent);
document.addEventListener('scroll', scrollEvent);
document.addEventListener('click', clickEvent);

function scrollEvent(e){
  var e = document.querySelector('html').scrollTop;
 // console.log(e.scrollHeight); // altezza totale pagina = 5603  //  
 //console.log(e.scrollTop);
 console.log(window.scrollY);
 //latestKnownScrollY = window.scrollY;
 /*
if ( e > 300 && e < 400) {
  console.log(e);
}
else if ( e > 400 && e < 500) {
  console.log(e);
}
*/
/*
 switch (e.scrollTop){
    case 500: console.log('html = 500');
    case 700: console.log('html = 700');
    case 1000: console.log('html = 1000');
 }
 */

}


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
     








