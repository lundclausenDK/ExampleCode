class Keys {
    onKeyDown(event) {
        var keyCode = event.keyCode;
        switch (keyCode) {
            case 38:  //up
                arrowUp = true;
                break;
            case 40:  //down
                arrowDown = true;
                break;
            case 37:  //left
                arrowLeft = true;
                break;
            case 39: //right
                arrowRight = true;
                break;
        }
    }

    onKeyUp(event) {
        var keyCode = event.keyCode;
        switch (keyCode) {
            case 38:  //up
                arrowUp = false;
                break;
            case 40:  //down
                arrowDown = false;
                break;
            case 37: //left
                arrowLeft = false;
                break;
            case 39: // right
                arrowRight = false;
                break;
        }
    }

    moveKeys() {

        var movement_speed = 4;

        // AFK
        if (arrowUp != true && arrowDown != true && arrowLeft != true && arrowRight != true ) {
            //this.drawPlayer(15, 202);
            c.drawImage(player, 15, 202, playerWidth, playerHeight, playerPosX, playerPosY, playerWidth, playerHeight);
        }

        // Keys touched
        if (arrowUp === true) {
            playerPosY -= movement_speed;
            this.drawPlayer(playerArrX, playerArrY[3]);
        }
        
        if (arrowDown === true) {
            playerPosY += movement_speed;
            this.drawPlayer(playerArrX, playerArrY[0]);
        }
        
        if (arrowLeft === true) {
            playerPosX -= movement_speed;
            this.drawPlayer(playerArrX, playerArrY[1]);
        }
        
        if (arrowRight === true) {
            playerPosX += movement_speed;
            this.drawPlayer(playerArrX, playerArrY[2]);
        }
        
    }

    drawPlayer(x, y) {
        playerGfxChange++;

        if (playerGfxChange < 10) {
            c.drawImage(player, x[0], y, playerWidth, playerHeight, playerPosX, playerPosY, playerWidth, playerHeight);
        }
        if (playerGfxChange >= 10 && playerGfxChange < 20) {
            c.drawImage(player, x[1], y, playerWidth, playerHeight, playerPosX, playerPosY, playerWidth, playerHeight);
        }
        if (playerGfxChange >= 20 && playerGfxChange < 30) {
            c.drawImage(player, x[2], y, playerWidth, playerHeight, playerPosX, playerPosY, playerWidth, playerHeight);
        }
        if (playerGfxChange >= 30 && playerGfxChange < 40) {
            c.drawImage(player, x[3], y, playerWidth, playerHeight, playerPosX, playerPosY, playerWidth, playerHeight);
        }
        if (playerGfxChange === 40) {
            c.drawImage(player, x[3], y, playerWidth, playerHeight, playerPosX, playerPosY, playerWidth, playerHeight);
            playerGfxChange = 0;
        }

        
        
    }


}