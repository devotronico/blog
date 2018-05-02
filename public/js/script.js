    
$(document).ready(function() {
/** NAVBAR **/


    var offset = 0;
    // var offset2 = 200;
    var duration = 300;
    
    var nav = document.querySelector('nav');
    // var card1 = document.getElementsByClassName('row-1');
    // var card2 = document.getElementsByClassName('row-2');
    //SCROLL EFFECT
    $(window).scroll(function() { 
        if ($(this).scrollTop() > offset)
        { 
            $("#btn-scroll").fadeIn(duration); //$("#btn-scroll").fadeTo(duration, 0.5);
            nav.classList.add('nav-bottom');
            nav.classList.remove('nav-top');
          
            // if ($(this).scrollTop() > offset2){
            //     card1.classList.add('slide-top');
            //     card2.classList.add('slide-top');
            // }
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


});
     








