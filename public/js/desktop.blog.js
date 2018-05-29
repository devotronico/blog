


 console.log('blog javascript');         
      let head = document.querySelector('head');
      // FONTAWESOME --> <link href="/img/fontawesome/css/fontawesome-all.min.css" rel="stylesheet">
      let fontawesome = document.createElement('link');
      fontawesome.setAttribute('rel', 'stylesheet');   
      fontawesome.setAttribute('href', '/img/fontawesome/css/fontawesome-all.min.css');  
      head.appendChild(fontawesome);