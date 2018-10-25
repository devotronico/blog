/*
* Array di cerchi che cadono e rimbalzano
* con testo
* https://www.youtube.com/watch?v=EO6OkltgudE
* https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial 
*/

var footerBoxCanvas = document.querySelector('#footer__box__canvas');
var canvas2 = document.createElement("canvas");
canvas2.setAttribute('id', 'footer__canvas');
canvas2.width = footerBoxCanvas.clientWidth;
canvas2.height = footerBoxCanvas.clientHeight;
footerBoxCanvas.appendChild(canvas2);
let ctx = canvas2.getContext("2d");


// FUNZIONI ----------------------------------------------------------------------
  function randomColor() {
    var color = [];
    for (var i = 0; i < 3; i++) {
      color.push(Math.floor(Math.random() * 256));
    }
    return 'rgb(' + color.join(',') + ')';
  }
  function randomRange(min, max) { return Math.random() * (max - min + 1) + min; }
  function randomRangeInt(min, max) { return Math.floor(Math.random() * (max - min + 1) + min); }


// EVENTI ----------------------------------------------------------------------
footerBoxCanvas.addEventListener('resize', function(){

    canvas2.width = footerBoxCanvas.clientWidth;
    canvas2.height = footerBoxCanvas.clientHeight;
    init2();
});

footerBoxCanvas.addEventListener('click', function(){

    canvas2.width = footerBoxCanvas.clientWidth;
    canvas2.height = footerBoxCanvas.clientHeight;
    init2();
});



// OGGETTO  ----------------------------------------------------------------------
function Circle(x, y, hspd, radius, color, gravity) {

  this.x = x;
  this.y = y;
  this.hspd = hspd;
  this.radius = radius;
  this.color = color;
  this.canBounce = true;
  this.vspd = 1;
  this.gravity = gravity;
  this.friction = 0.50;

  this.draw = function() {
    
    ctx.beginPath();
    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
    ctx.fillStyle = this.color;
    ctx.fill();
    //ctx.strokeStyle = 'blue';
    //ctx.stroke();
  }

  this.update = function() {
    
    if ( this.canBounce ) {

      if ( this.y + this.radius + this.vspd >= canvas2.height ) { // se la palla tocca il fondo...
        // la sua velocità in discesa(valore positivo) viene convertita in velocità in salita(valore negativo). Friction riduce la velocità in salita
        this.vspd = -this.vspd * this.friction; 
        if ( this.vspd > 0  ) { this.canBounce = false; } // se vspd non ha valore negativo allora la palla non rimbalza più 
        } else {

          this.vspd += this.gravity; // se la palla è in discesa gravity fa AUMENTARE la velocità in discesa - se la palla è in salita gravity fa DIMINUIRE la velocità in salita
        }
        this.y +=this.vspd; 
    }
 
    if ( this.hspd != 0 ) { // se la palla è in movimento orizzontale
  
      if ( this.x + this.hspd >= canvas2.width || this.x + this.hspd <= 0 ) { // se tocca i confini orizzontali...

        this.hspd = -this.hspd; // inverte la direzione e riduce la velocità
      } else {

        this.hspd *= 0.99;
        this.x += this.hspd; // movimento
      }
    } else {console.log('ferma')}
    
    this.draw();
  }

} // chiude Classe Circle



// INIT ----------------------------------------------------------------------
var ballArray;
function init2() {
  
  ballArray = [];
  for (var i=200; i>0; i--) {
    var radius = i;
    var x = randomRangeInt(radius, canvas2.width-radius); // setta la posizione della palla entro i limiti del canvas2
    var y = randomRangeInt(-400, -radius); // crea la palla al di sopra del confine del canvas2
    var hspd = randomRange(-10, 10);
    if ( i%2==0 ) { var color = 'white' } else { var color = '#2c8cff' }
    //var color = randomColor();
    var gravity = radius / 100;
    ballArray.push(new Circle(x, y, hspd, radius, color, gravity));
  }

}
//init2();



// ANIMAZIONE ----------------------------------------------------------------------
  function animate2(play) {

    if ( play ) {
        requestAnimationFrame(animate2);

        ctx.clearRect(0, 0,  canvas2.width,  canvas2.height);
        
        for (var i=0; i<ballArray.length; i++) {
            ballArray[i].update();
        }
        ctx.font = 'italic 30pt Calibri';
        ctx.textAlign = 'center';
        ctx.fillStyle = '#333';
        ctx.fillText('© Daniele Manzi 2018', canvas2.width * 0.5, canvas2.height * 0.5);
    }
  }

  //animate2();

  export{init2, animate2}