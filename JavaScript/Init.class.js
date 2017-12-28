class Init {

    createNewPlayer() {
        player_name = prompt("Indtast dit navn");
        let newPlayer = new Player(player_name, 100, 0, 0);

        // Store name in input field for highscore entry
        fieldName.value = newPlayer.name;

        startButton.style.display = "none";
        startLogo.style.display = "none";
        startRules.style.display = "none";
        startEgo.style.display = "none";
        arrowKeys.style.display = "none";

        // Countdown
        let countdown = 1000;
        let count = 3;
        let countdownLoop = setInterval(function () {
            c.save();
            c.clearRect(0, 0, 900, 600);
            c.font = "bold 150px Calibri";
            c.fillStyle = "white";
            c.shadowBlur = 5;
            c.shadowColor = "black";
            c.shadowOffs = 0;
            c.fillText(count, 400, 300);
            c.restore();

            countdown += 1000;
            count--;

            if (countdown === 5000) {
                clearInterval(countdownLoop);
                isPaused = false;
            }
        }, countdown);

        // Play background music
        //MIDIjs.play('audio/SonicChaos-MechaGreenHillZone.mid');
    }

    placeExit() {
        c.beginPath();
        c.fillRect(exitX, exitY, exitHeight, exitWidth);
        exit.style.display = "block";
        exitDoor.style.display = "block";
        c.closePath();
    }

    placeDummy() {
        c.beginPath();
        c.rect(dummyX, dummyY, dummyWidth, dummyHeight);
        c.fillStyle = "#333";
        c.fill();
        c.closePath();
    }

    placeRoundsCounter() {
        c.save();
        c.font = "bold 20px Calibri";
        c.fillStyle = "#333";
        c.shadowBlur = 3;
        c.shadowColor = "white";
        c.shadowOffs = 0;
        c.fillText("Round: " + gameRound, 20, 35);
        c.restore();
    }

    placePointCounter() {
        c.save();
        c.font = "bold 20px Calibri";
        c.fillStyle = "#333";
        c.shadowBlur = 3;
        c.shadowColor = "white";
        c.shadowOffs = 0;
        c.fillText("Time spent: " + gamePoints, 150, 35);
        c.restore();
    }

    placePlayerName() {
        c.save();
        c.font = "bold 20px Calibri";
        c.fillStyle = "#333";
        c.shadowBlur = 3;
        c.shadowColor = "white";
        c.shadowOffs = 0;
        c.fillText("Player: " + player_name, 350, 35);
        c.restore();

    }

    playerCollisionListener(array, redWall, wallArray) {

        // Listen to collisions between player and array world elements
        for (let i = 0; i < array.length; i++) {

            // array[0] = x
            // array[1] = y
            // array[2] = width
            // array[3] = height
            // array[4] = isRedwall
            // array[5] = isExit

            let xCalc = playerPosX + playerWidth;
            let yCalc = playerPosY + playerHeight;

            let pw = playerWidth - 5;

            if (playerPosX >= array[0] - pw && playerPosY >= array[1] - pw &&
                playerPosX <= (array[0] + array[2]) - 5 && playerPosY <= (array[1] + array[3]) - 5) {

                if (array[4] === false) {
                    // Wall entrance
                    wallArray.length = 0;
                    redWall._color = "#0099ff";
                } else if (array[5] === true) {
                    // Wall hit
                    this.backToStart();

                } else if (gameRound === 3) {
                    // Game end - Save to high score
                    let r = confirm("YOU DID IT! Congrats! Save to highscore?");
                    isPaused = true;

                    if (r === true) {
                        this.saveToHighscore();
                    }

                } else {
                    this.continueLogic();
                }


            } else if (xCalc >= array[0] && yCalc >= array[1] && xCalc <= array[0] && yCalc <= array[1]) {

                if (array[4] === false) {
                    // Wall entrance
                    wallArray.length = 0;
                    redWall._color = "#0099ff";

                } else if (gameRound === 3) {
                    // Game end - Save to high score
                    let r = confirm("YOU DID IT! Congrats! Save to highscore?")
                    isPaused = true;

                    if (r === true) {
                        this.saveToHighscore();
                    }
                } else {
                    this.continueLogic();
                }

            }

        }

    }

    saveToHighscore() {
        exitArray.length = 0;

        canvas.style.display = "none";
        exitDoor.style.display = "none";
        exit.style.display = "none";
        highscoreForm.style.display = "block";

        fieldScore.value = gamePoints;
    }

    backToStart() {
        let r = confirm("OUCH! You hit a red wall. Go back to start.");
        isPaused = true;

        if (r === true) {

            // Lets reset things before next round
            playerPosX = 150;
            playerPosY = 480;

            arrowRight = false;
            arrowLeft = false;
            arrowDown = false;
            arrowUp = false;

            isPaused = false;
        } else {
            // Show game over page?
        }
    }

    continueLogic() {
        let r = confirm("WELL DONE, YOU ESCAPED! CONTINUE NEXT LEVEL?");
        isPaused = true;

        if (r === true) {

            // Lets reset things before next round
            playerPosX = 150;
            playerPosY = 480;

            arrowRight = false;
            arrowLeft = false;
            arrowDown = false;
            arrowUp = false;

            wallArray = [rw01.startPosX, rw01.startPosY, rw01.width, rw01.height, null, true];
            wallArray02 = [rw02.startPosX, rw02.startPosY, rw02.width, rw02.height, null, true];
            wallArray03 = [rw03.startPosX, rw03.startPosY, rw03.width, rw03.height, null, true];
            wallArray04 = [rw04.startPosX, rw04.startPosY, rw04.width, rw04.height, null, true];

            rw01._color = "red";
            rw02._color = "red";
            rw03._color = "red";
            rw04._color = "red";

            // Lets go next round
            gameRound++;
            wallEntranceSpeed += 2;
            isPaused = false;

        } else {
            // Show updated high score
        }
    }

}