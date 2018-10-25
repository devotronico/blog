document.addEventListener('DOMContentLoaded', function() {

//quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
window.onbeforeunload = function () { 
  
    window.scrollTo(0, 0);
}

console.log('window.location.pathname = ' + window.location.pathname);


function downloadJSAtOnload () {

    let element = document.createElement ("script");


    switch (window.location.pathname) {
        
        case '/' : 
        case '/home/contact':
    
        element.setAttribute('type', 'module');   // element.src = " example.js" ;
        element.setAttribute('src', '/js/desktop/home.js');   // element.src = " example.js" ;
        break;

        case '/post/create':
         
            element.setAttribute('src', '/js/desktop/postcreate.js'); 
        break;

    
        default : 

            //var mystr = window.location.pathname;
            //var myarr = mystr.split('/');
            //var myvar = myarr[0] + ":" + myarr[1];
            //console.log(myarr[0]);
            //console.log(myarr[1]);
            //console.log(myarr[2]);
    
        element.setAttribute('src', '/js/desktop/blog.js');   
    }

    document.body.appendChild (element); 
}




if (window.addEventListener) {
    console.log('LOAD');
window.addEventListener ("load", downloadJSAtOnload, false);
}
else if (window.attachEvent) {
    console.log('ONLOAD');
window.attachEvent ("onload", downloadJSAtOnload);
}
else { 
    console.log('ELSE');
window.onload = downloadJSAtOnload;
}


}); // chiude DOMContentLoaded
     








