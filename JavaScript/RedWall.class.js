class RedWall {
    constructor(startPosY, startPosX, width, height, color) {
        this._startPosY = startPosY;
        this._startPosX = startPosX;
        this._width = width;
        this._height = height;
        this._color = color;
    }

    insertWall() {
        c.beginPath();
        c.rect(this._startPosX, this._startPosY, this._width, this._height);
        c.fillStyle = this._color;
        c.fill();
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

    get color() {
        return this._color;
    }

    set color(value) {
        this._color = value;
    }
}