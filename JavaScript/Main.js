// Virtual Escape Js 
// Version 1.0 release candidate

// Global variables
let canvas = document.getElementById("virtual_escape");
let c = canvas.getContext("2d");
let startButton = document.getElementById("start");
let startLogo = document.getElementById("logo");
let startRules = document.getElementById("gamerules");
let startEgo = document.getElementById("startego");
let arrowKeys = document.getElementById("keyboard");
let exit = document.getElementById("exit");
let exitDoor = document.getElementById("exit-door");
let fieldScore = document.getElementById("highscore_entry");
let fieldName = document.getElementById("playername");
let highscoreForm = document.getElementById("highscore_form");

let arrowRight = false;
let arrowLeft = false;
let arrowDown = false;
let arrowUp = false;

let playerPosX = 150;
let playerPosY = 480;
let playerHeight = 50;
let playerWidth = 40;

let exitX = 830;
let exitY = 30;
let exitHeight = 50;
let exitWidth = 40;

let exitArray = [exitX, exitY, exitWidth, exitHeight];

// Define canvas
canvas.width = 900;
canvas.height = 550;

// Class instances
let init = new Init();
let keys = new Keys();

let rw01 = new RedWall(430, 0, 900, 4, "red");
let we01 = new WallEntrance(427, 0, 100, 10);

let rw02 = new RedWall(330, 0, 900, 4, "red");
let we02 = new WallEntrance(327, 800, 100, 10);

let rw03 = new RedWall(230, 0, 900, 4, "red");
let we03 = new WallEntrance(227, 500, 100, 10);

let rw04 = new RedWall(130, 0, 900, 4, "red");
let we04 = new WallEntrance(127, 100, 100, 10);

let wallArray = [rw01.startPosX, rw01.startPosY, rw01.width, rw01.height, null, true];
let wallEntranceArray = [we01.startPosX, we01.startPosY, we01.width, we01.height, false];

let wallArray02 = [rw02.startPosX, rw02.startPosY, rw02.width, rw02.height, null, true];
let wallEntranceArray02 = [we02.startPosX, we02.startPosY, we02.width, we02.height, false];

let wallArray03 = [rw03.startPosX, rw03.startPosY, rw03.width, rw03.height, null, true];
let wallEntranceArray03 = [we03.startPosX, we03.startPosY, we03.width, we03.height, false];

let wallArray04 = [rw04.startPosX, rw04.startPosY, rw04.width, rw04.height, null, true];
let wallEntranceArray04 = [we04.startPosX, we04.startPosY, we04.width, we04.height, false];

// Number of game rounds
let gameRound = 1;

// Wall speed
let wallEntranceSpeed = 2;

// Points
let gamePoints = 0;

// Pause feature
let isPaused = true;

// Start button
let player_name;
startButton.addEventListener("click", init.createNewPlayer);

// Insert player sprite
canvas.innerHTML += "<img id='player' src='img/player-sprite.png'>";

// Player object
let player = document.getElementById("player");
let playerArrX = [12, 76, 138, 204];
let playerArrY = [10, 73, 137, 201];
let playerGfxChange = 0;

function game() {

    if (isPaused === false) {

        // Lets clear the board
        c.clearRect(0, 0, canvas.width, canvas.height);

        // Insert game elements
        init.placeExit();

        init.placeRoundsCounter();
        init.placePointCounter();

        init.playerCollisionListener(exitArray);
        
        init.playerCollisionListener(wallArray);
        init.playerCollisionListener(wallEntranceArray, rw01, wallArray);
        
        init.playerCollisionListener(wallArray02);
        init.playerCollisionListener(wallEntranceArray02, rw02, wallArray02);

        init.playerCollisionListener(wallArray03);
        init.playerCollisionListener(wallEntranceArray03, rw03, wallArray03);

        init.playerCollisionListener(wallArray04);
        init.playerCollisionListener(wallEntranceArray04, rw04, wallArray04);
        
        init.placePlayerName();

        
        rw01.insertWall();
        we01.insertWallEntrance();
        we01.moveWallEntrance(wallEntranceSpeed, wallEntranceArray, false);
                
        rw02.insertWall();
        we02.insertWallEntrance();
        we02.moveWallEntrance(wallEntranceSpeed, wallEntranceArray02, true);

        rw03.insertWall();
        we03.insertWallEntrance();
        we03.moveWallEntrance(wallEntranceSpeed, wallEntranceArray03, false);

        rw04.insertWall();
        we04.insertWallEntrance();
        we04.moveWallEntrance(wallEntranceSpeed, wallEntranceArray04, false);
        
        keys.moveKeys();

        gamePoints++;
    }
    // Lets run at 60fps
    window.requestAnimationFrame(game);
}
game();

window.addEventListener("keydown", keys.onKeyDown, false);
window.addEventListener("keyup", keys.onKeyUp, false);

