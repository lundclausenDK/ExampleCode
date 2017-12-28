class Player {

    constructor(name, health, stock, points) {
        this.player_name = name;
        this.player_health = health;
        this.player_stock = stock;
        this.player_points = points;
    }


    get name() {
        return this.player_name;
    }

    set name(value) {
        this.player_name = value;
    }

    get health() {
        return this.player_health;
    }

    set health(value) {
        this.player_health = value;
    }

    get stock() {
        return this.player_stock;
    }

    set stock(value) {
        this.player_stock = value;
    }

    get points() {
        return this.player_points;
    }

    set points(value) {
        this.player_points = value;
    }
}