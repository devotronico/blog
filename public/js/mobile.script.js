    

document.addEventListener('DOMContentLoaded', function() {

    //quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
    window.onbeforeunload = function () { 
     // window.scrollTo({top: 0,behavior: "smooth"});
       // window.scrollTo(0, 0);
    }

     setTimeout (function () {
      window.scrollTo(0,0);
      }, 500); //100ms for example
    
    console.log('window.location.pathname:'+window.location.pathname);
    
    
    switch (window.location.pathname) {
        
      case '/' : 
      case '/home/contact':
    
          var scriptHome = document.createElement('script');
          scriptHome.setAttribute('src', '/js/mobile.home.js');   
          
          var body = document.querySelector('body');
          body.appendChild(scriptHome);
          
    
      break;
/*
      case '/home/contact':
      var scriptHome = document.createElement('script');
        scriptHome.setAttribute('src', '/js/mobile.home.js');   
        
        var body = document.querySelector('body');
        body.appendChild(scriptHome);
      break;
    */
      default : 
    
      let scriptBlog = document.createElement('script');
      scriptBlog.setAttribute('src', '/js/mobile.blog.js');   
      
      var body = document.querySelector('body');
      body.appendChild(scriptBlog);
    
    
    }
    
    
    
    });





