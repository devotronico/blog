console.log('blog script');


document.addEventListener('touchstart', clickFunc,  {passive: false}); // mouseenter
    
let navState = false;
    
function clickFunc(e){ 

  let element = e.target;
  console.log( element);
  if ( element.classList.contains('navClass') ) //{  console.log('ok')}
  {
    let nav = document.querySelector('nav');

        if ( element.id === 'toggleNav' )
        { 
            element.classList.toggle('active');
            if ( navState === false) {

                nav.style.display = 'block';
            } else {

                nav.style.display = 'none';
            }
            navState = !navState;
           
        }
        else
        {
            if (element.href === undefined) {  

                var goToId = element.firstElementChild.hash.slice(1);
            }  
            else
            {
                var goToId = element.hash.slice(1);
            }

            smoothScroll(document.getElementById(goToId))
            navState = false;
            nav.style.display = 'none';
            let toggleNav = document.querySelector('#toggleNav');
            toggleNav.classList.toggle('active');
        }
    }
    else if ( element.id === 'scrollFA' ) 
    {

      //  document.body.scrollTop = 0;
     //   document.documentElement.scrollTop = 0;
      
           
            document.documentElement.scrollTop=0;
        }
     // window.scrollY = 0;
        console.log('window.scrollY '+window.scrollY);
        console.log('document.documentElement.scrollTop '+document.documentElement.scrollTop);
      //  console.log('document.body.scrollTop '+document.body.scrollTop);
       // window.scrollY = 0;
       // console.log(window.scrollY);
    }
    else
    {
        // if (element.href !== undefined) {  
        if (navState) {  
            e.preventDefault();
           if (e.defaultPrevented) {
                // console.log('disattiva link')
          }
         // console.log('navbar attivata')
       }
    }
   // console.log(navState);
  
}

/********** END NAVBAR SENZA BOOTSTRAP **********/