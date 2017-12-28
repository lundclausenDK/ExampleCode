class WallEntrance {
    
    constructor(startPosY, startPosX, width, height) {
        this._startPosY = startPosY;
        this._startPosX = startPosX;
        this._width = width;
        this._height = height;

        this.swap = null;
        this.count = 0;
    }

    insertWallEntrance() {
        c.beginPath();
        c.rect(this._startPosX, this._startPosY, this._width, this._height);
        c.fillStyle = "#c1c4c3";
        c.fill();
    }

    moveWallEntrance(speed, array, leftFirst) {

        // First time trigger
        if (this.count === 0) {
            this.swap = leftFirst;
        }

        // Entrance moving right
        if (this.swap === false) {

            this._startPosX += speed;
            array[0] += speed;

            if (this._startPosX >= 800) {
                this.swap = true;
            }
        }

        // Entrance moving left
        if (this.swap === true) {

            this._startPosX -= speed;
            array[0] -= speed;

            if (this._startPosX <= 0) {
                this.swap = false;
            }
        }

        this.count++;
    }

    // Getters and setters
    get startPosY() {
        return this._startPosY;
    }

    set startPosY(value) {
        this._startPosY = value;
    }

    get startPosX() {
        return this._startPosX;
    }

    set startPosX(value) {
        this._startPosX = value;
    }

    get width() {
        return this._width;
    }

    set width(value) {
        this._width = value;
    }

    get height() {
        return this._height;
    }

    set height(value) {
        this._height = value;
    }
}