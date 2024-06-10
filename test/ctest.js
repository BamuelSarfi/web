const canvas = document.getElementById('test');
const ctx = canvas.getContext('2d');


let colors = ["#004241", "#006463", "#00CAC7"];
const canvasColors = ["#5BED18", "#18ED72", "#18ED2A", "#B4ED18", "#1EEB3A"];

let controllerIndex = null;
let playerX = 0;
let playerY = 0;
let playerWidth = 0;
let playerHeight = 0;
let horizontalVelocity = 0;

const obstacles = [];
const maxObstacles = 5; // Maximum number of obstacles on the screen at once
let leftPressed = false;
let rightPressed = false;
let aPressed = false;
let bPressed = false;
let yPressed = false;
let xPressed = false;

let percentage;

let time = 0;
let stick = 0;

let obstacleTick = 0;//num of obstacles that have hit the "floor"
let obstacleNum = 15;//num of obstacles allowed on the "floor" before game over.

let endGame = false;
let score = obstacleNum - 15;

console.log("Endgame is " + endGame)

//obstacles//////////////////////////////////////////////////////////////////////////////
function getRandomInt(max) {
    return Math.floor(Math.random() * max);
}

// Function to generate a random obstacle

function generateObstacle() {
    if (obstacles.length < maxObstacles) {
        const size = getRandomInt(50) + 20; // Random size between 20 and 70
        const color = colors[getRandomInt(colors.length)]; // Random color from the colors array
        const x = getRandomInt(canvas.width - size); // Random horizontal position
        const y = -size; // Start above the canvas
        const speed = (Math.random() * 2 + 1) // Random speed between 1 and 3 pixels/frame
        obstacles.push({ x, y, size, color, speed }); // Add obstacle to the array
    }
}
// Function to update obstacles' positions
function updateObstacles() {

    let obstacle;

    for (let i = 0; i < obstacles.length; i++) {
        obstacle = obstacles[i];
        obstacle.y += obstacle.speed; // Move obstacle down
        // Remove obstacle if it goes below the canvas
        if (obstacle.y > canvas.height + obstacle.size) {
            obstacleTick++;
            vibrate();
            //console.log(obstacleTick)
            //console.log(obstacle.y)
            obstacles.splice(i, 1);
            i--; // Decrement i since we removed an obstacle
        }
    }

}

// Function to draw obstacles
function drawObstacles() {
    for (const obstacle of obstacles) {
        ctx.fillStyle = obstacle.color;
        ctx.fillRect(obstacle.x, obstacle.y, obstacle.size, obstacle.size);
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////
    function vibrate() {
    
    gamepad.vibrationActuator.playEffect("dual-rumble", {
    startDelay: 0,
    duration: 200,
    weakMagnitude: 0.1,
    strongMagnitude: 0.9,
});
}


//event listeners///////////////////////////////////////////////////////////////////////
window.addEventListener('resize', setupCanvas);
window.addEventListener('gamepadconnected', (e) => {
    gamepad = e.gamepad;
    console.log(gamepad)
    controllerIndex = e.gamepad.index;
     vibrate();
    
});
window.addEventListener('gamepaddisconnected', (e) => {

    controllerIndex = null;
    window.alert("Gamepad disconnected.")
    
})
//ControllerInput//////////////////////////////////////////////////////////////////////
function controllerInput(){
    if(controllerIndex !== null){
        const gamepad = navigator.getGamepads()[controllerIndex];
        const buttons = gamepad.buttons;

        leftPressed = buttons[14].pressed;
        rightPressed = buttons[15].pressed;
        aPressed = buttons[0].pressed;
        bPressed = buttons[1].pressed;
        yPressed = buttons[3].pressed;
        xPressed = buttons[2].pressed;
    

        const stickDeadZone = 0.4;
        const leftRightValue = gamepad.axes[0];
        percentage = ((gamepad.axes[0]) * 50)/100; // Convert range from [-1, 1] to [0, 100]
        //console.log("Percentage:", percentage);

      
        
        if(leftRightValue >= stickDeadZone){
            rightPressed = true;
        }
        else if(leftRightValue <= -stickDeadZone){
            leftPressed = true;
            
        }
        
 

        // Apply dead zone adjustment
        if (Math.abs(leftRightValue) < stickDeadZone) {
            percentage = 0; // Set percentage to 0 within dead zone
        } else {
            // Calculate percentage for both left and right directions
            percentage = ((Math.abs(leftRightValue) - stickDeadZone) / (1 - stickDeadZone)) * Math.sign(leftRightValue);
        }

        //console.log("Percentage:", percentage);



    }
}
//function counter//////////////////////////////////////////////////////////////////
function counter(){
    ctx.font = "50px serif";
    //ctx.fillStyle = "#ffffff";
    ctx.fillText("collected: " + obstacleNum, canvas.width/25, canvas.height - 300)
}

///Draws player//////////////////////////////////////////////////////////////////////
function setupCanvas() {
    canvas.height = window.innerHeight;
    canvas.width = window.innerWidth;
    playerWidth = canvas.width * 0.1;
    playerHeight = canvas.height * 0.01;
    
    horizontalVelocity = canvas.width * 0.005 * obstacleNum;
    playerX = (canvas.width - playerWidth) / 2;
    playerY = (canvas.height - playerHeight) / 1.2;
    drawPlayer();

}setupCanvas();
function clearScreen() {
    if(endGame == true){
        return;
     }else{
      ctx.fillStyle = "#008F8C";
    ctx.fillRect(0, 0, canvas.width, canvas.height);  
     }
    
}
function drawPlayer() {
   ctx.fillStyle = "#00ECE8";
    ctx.fillRect(playerX , playerY, playerWidth, playerHeight);
}

/////////////////////////////////////////////////////////////////////////

//move player(object/player)//////////////////////////////////////////////////time
function movePlayer(){
     if(leftPressed){
    playerX -= horizontalVelocity * (-percentage * 0.3);
    
}
 if(rightPressed){
    playerX += horizontalVelocity * (percentage * 0.3);
    
}
}
function updatePlayer(){
    movePlayer();
    if(playerX >= canvas.width){
        playerX = 0;
    }else if(playerX <= 0 - playerWidth){
        playerX = canvas.width;
    }
}
//function change background if buttons are pressed/////////////////////////////
function changeBackground() {
   if(obstacleTick >= obstacleNum){
    //window.alert("GameOver")
    //setTimeout(window.close(), 3000);
    
    //vibrate();
    console.log("dam")
    
} 
}
function player(){
   
    if(bPressed == false && endGame == false){
          drawPlayer();//draws player
        updatePlayer();//update existing player
        generateObstacle(); // Generate new obstacles
        updateObstacles(); // Update existing obstacles
        drawObstacles(); // Draw obstacles

        // Check for collision between player and obstacles
    for (let i = 0; i < obstacles.length; i++) {
        const obstacle = obstacles[i];
        if (playerX < obstacle.x + obstacle.size &&
            playerX + playerWidth > obstacle.x &&
            playerY < obstacle.y + obstacle.size &&
            playerY + playerHeight > obstacle.y) {
            // Collision detected
            obstacles.splice(i, 1); // Remove obstacle
            obstacleNum++; // Increase obstacleNum
            console.log("obstacleNum = " + obstacleNum);
            //vibrater
            gamepad.vibrationActuator.playEffect("dual-rumble", {
                startDelay: 0,
                duration: 50 * obstacle.size * 0.01,
                weakMagnitude: 0.3,
                strongMagnitude: 0.9,
            });
            ////////////////////////////////////////////////////
            break; // Exit the loop after handling one collision
        }
    }

    }else{
        console.log("bpressed or endgame.");
        return;
    }

}
// Function to check collision between two rectangles

    setInterval(function() {
    if(controllerIndex != null){
        time++;
    }
        
    //console.log(time)
        }, 1000)


//obstacleTick, game over screen////////////////////////////////////////////
//obstacleTick;
//gameLoop (repeated every frame)/////////////////////////////////////////
function gameLoop(){
    controllerInput();
    clearScreen();
    
    //drawPlayer();//draws player
    //updatePlayer();//update existing player
    //generateObstacle(); // Generate new obstacles
    //updateObstacles(); // Update existing obstacles
    //drawObstacles(); // Draw obstacles
    
    changeBackground();//gameoverScreen
    requestAnimationFrame(gameLoop);

    if(controllerIndex != null){
        player();
    }else if(controllerIndex == null){
        ctx.font = "48px serif";
        ctx.fillText("Please connect your gamepad, and press some buttons to play.", 10, 50);
    }
    
}
gameLoop();


