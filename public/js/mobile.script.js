    

document.addEventListener('DOMContentLoaded', function() {

    //quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
    window.onbeforeunload = function () { 
        window.scrollTo(0, 0);
    }
    
    console.log('window.location.pathname:'+window.location.pathname);
    
    
    switch (window.location.pathname) {
        
      case '/' : 
    
         
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





