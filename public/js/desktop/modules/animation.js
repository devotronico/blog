/**************************************************
*                   CANVAS
**************************************************/
var contactBoxCanvas = document.querySelector('#contact__box__canvas');
var canvas = document.createElement("canvas");
canvas.setAttribute('id', 'contact__canvas');
canvas.width = contactBoxCanvas.clientWidth;
canvas.height = contactBoxCanvas.clientHeight;
contactBoxCanvas.appendChild(canvas);
// VARIABILI----------------------------------------------------------------------


// EVENTI ----------------------------------------------------------------------
contactBoxCanvas.addEventListener('resize', function(){

  canvas.width = contactBoxCanvas.clientWidth;
  canvas.height = contactBoxCanvas.clientHeight;
  init();
});
/*
window.addEventListener('click', function(){

  canvas.width = contactBoxCanvas.clientWidth;
  canvas.height = contactBoxCanvas.clientHeight;
  init();
  .
});
*/
// CLASSE
  function Circle(x, y, hspd, radius, color, canBounce, canMove) {

    //this.canvas = canvas;
    //this.ctx = ctx;
    this.x = x;
    this.y = y;
    this.hspd = hspd;
    this.radius = radius;
    this.color = color;
    this.canBounce = canBounce;
    this.canMove = canMove;
    this.vspd = 1;
    this.gravity = 1;
    this.friction = 0.90;

    this.draw = function () {
      let ctx = canvas.getContext("2d");
      // RESETTA LO SFONDO CON UN RETTANGOLO BIANCO CHE A OGNI FRAME SOVRASCRIVE IL CERCHIO
      ctx.fillStyle = 'rgba(255, 255, 255, 1)';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      // DISEGNA IL CERCHIO
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
      ctx.fillStyle = this.color;
      ctx.fill();
    }



    this.update = function () {

      if (this.canBounce) {
        if (this.y + this.radius + this.vspd >= canvas.height) { // se la palla tocca il fondo...
          // la sua velocità in discesa(valore positivo) viene convertita in velocità in salita(valore negativo). Friction riduce la velocità in salita
          this.vspd = -this.vspd * this.friction;
          if (this.vspd > 0) { this.canBounce = false; } // se vspd non ha valore negativo allora la palla non rimbalza più 
        } else {
          this.vspd += this.gravity; // se la palla è in discesa gravity fa AUMENTARE la velocità in discesa - se la palla è in salita gravity fa DIMINUIRE la velocità in salita

        }
        this.y += this.vspd;
      }
      if (this.canMove) {
        //  if ( Math.round(this.hspd) != 0 ) { // se la palla è in movimento orizzontale
        if (Math.abs(this.hspd) > 0.2) { // se la palla è in movimento orizzontale

          if (this.x + this.radius + this.hspd >= canvas.width || this.x - this.radius + this.hspd <= 0) { // se tocca i confini orizzontali...

            this.hspd = -this.hspd; // inverte la direzione e riduce la velocità
          } else {

            this.hspd *= 0.99;
            this.x += this.hspd; // movimento
          }
        } else { this.canMove = false; }
      }

    //  this.shadow();
      this.draw();
    }

  } // chiude Classe Circle


  // INIT ----------------------------------------------------------------------
  var ball;
  function init() {
    var radius = 60;    //randomRangeInt(10, 80);   
    var x = 100;    //  var x = randomRangeInt(radius, canvas.width-radius);   
    var y = 50;     //randomRangeInt(-400, -radius); 
    var hspd = 20;      //randomRange(-5, 5);
    var color = '#2c8cff';  //randomColor();
    return ball = new Circle(x, y, hspd, radius, color, true, true);
  }
  //init();

  // ANIMAZIONE ----------------------------------------------------------------------
var animState;
function animate(play) {

    if ( play ) {
        animState = requestAnimationFrame(animate);
        ball.update();
    } 
    else 
    {
        cancelAnimationFrame(animState);
    }

}

//animate();

export{canvas, init, animate}
/**********END CANVAS*********/
