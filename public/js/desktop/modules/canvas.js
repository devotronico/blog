//======================================================================
// CANVAS [cerchio che cade e rimbalza]
//======================================================================
let canvasList = [];
let ctx = [];
let ball = [];

// CREA CANVAS E BALL----------------------------------------------------------------------
// function initCanvas(n, section, color) {
function initCanvas(n, canvasBox, bgcolor, ballColor) {
 
    let canvas = document.createElement("canvas");
    canvasBox.appendChild(canvas);
  
    canvas.width = canvasBox.clientWidth 
    canvas.height = canvasBox.clientHeight; 
    canvas.style.backgroundColor = bgcolor;
    if ( window.innerWidth < 320 ) { canvas.style.display = 'none';}
    canvasList[n] = canvas;
    ctx[n] = canvas.getContext("2d");  

    let y = 0; 
    let radius = 60;
    ball[n] = new Circle(canvasList[n].width*.5, y, radius, n, canvasList[n].height, ballColor);
}


/*
* Durante il resize della pagina
* Aggiorna le dimensioni del canvas rispetto al suo contenitore
* Aggiorna la posizione della palla rispetto alle nuove dimensioni del canvas
* Nasconde il canvas se la pagina è minore di 320 pixel altrimenti lo mostra
*/
let resizeTimer;

function canvasResize(){
    
    animate(false); 
   
    // clearTimeout resetta setTimeout quindi evita che viene richiamato più volte ma soltato una volta alla fine del riseze
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        animate(false); 
        animate(true);
    }, 1000);

    
   
    for (let i=0; i<canvasList.length; i++) {
        if ( canvasList[i] ) {
     
            canvasList[i].width = document.querySelector(".col-canvas-"+i).clientWidth;
            canvasList[i].height = document.querySelector(".col-canvas-"+i).clientHeight;

            ball[i].x = canvasList[i].width *.5; // la palla si riposiziona al centro del canvas
            ball[i].floor = canvasList[i].height; // la palla si riposiziona al centro del canvas
            if ( window.innerWidth < 320 ) {
                canvasList[i].style.display = 'none';
            } else { 
                canvasList[i].style.display = 'block';
            }
        }
    }
}



// OGGETTO  ----------------------------------------------------------------------
function Circle(x, y, radius, i, floor, ballColor) {

    this.x = x;
    this.y = y;
    this.radius = radius;
    this.color = ballColor;
    this.vspd = 0;
    this.gravity = 1;
    this.floor = floor

  this.draw = function() {
    
    ctx[i].beginPath();
    ctx[i].arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
    ctx[i].fillStyle = this.color;
    ctx[i].fill(); // riempimento
    ctx[i].closePath();
  }

    this.update = function() {
 
        this.vspd += this.gravity;
        if ( this.y+this.radius >= this.floor ) { this.vspd = -30; }
        this.y += this.vspd;
        this.draw();
    }

} // chiude Classe Circle




let n;
function indexOfBall(index) {return n = index}


// ANIMAZIONE ----------------------------------------------------------------------
let animState;
function animate(play) {
  
    if ( play ) {
        if ( ctx[n] != undefined ) {
            animState = requestAnimationFrame(animate);
            ctx[n].clearRect(0, 0, canvasList[n].width, canvasList[n].height); // clear canvas
            ball[n].update();
        }
    } 
     else {
       // console.log('NOT PLAY');
        cancelAnimationFrame(animState);
     }
}
export {initCanvas, canvasResize, indexOfBall, animate}
//======================================================================
// CHIUDE CANVAS
//======================================================================