// LEARN YOU NODE
//1
console.log("HELLO WORLD");

//2
console.log(process.argv);
var sum = 0;

for (var i = 2; i < process.argv.length; i++) {
    sum += Number(process.argv[i]);
}

console.log(sum);

//3
var fs = require("fs");

var myFile = fs.readFileSync(process.argv[2]).toString().split("\n").length -1;
console.log(myFile);

//4
var fs = require("fs");

fs.readFile(process.argv[2], function cb(err, data) {
    if (err) {
        throw err;
    } else {
        var lines = data.toString().split('\n').length - 1;
        console.log(lines);
    }
});

//5
var fs = require("fs");
var path = require('path')

fs.readdir(process.argv[2], function(err, list) {
    list.forEach(function(value) {
        if (path.extname(value) === '.' + process.argv[3]) {
            console.log(value);
        }
    })
});



// ITERATION METHODS - BUILD IN
let msg = "Hello World";
console.log(msg);

myArray = ["Lars", "Jan", "Peter", "Bo", "Frederik"];

// Filter
sortedArray = myArray.filter(function(value) {
    return value.length > 3
});
console.log(sortedArray);

// Map
changedArray = myArray.map(function(value) {
    return value.toUpperCase()
});
console.log(changedArray);



// CUSTOM WRITTEN CALLBACK FUNCTIONS
myArray = ["Lars", "Jan", "Peter", "Bo", "Frederik"];

// Filter
function nameLength(element) {
    return element.length <= 3;
}

function myFilter(array, callback) {
    let newArray = [];
    for (let i = 0; i < array.length; i++) {
        if (callback(array[i])) {
            newArray.push(array[i]);
        }
    }
    return newArray;
}

filteredArray = myFilter(myArray, nameLength);

console.log(myArray);
console.log(filteredArray);


// Map
function addElements(element) {
    return "<div>" + element + "</div>";
}

function myMap(array, callback) {
    let newArray = [];
    for (let i = 0; i < array.length; i++) {
        newArray.push(callback(array[i]));
    }
    return newArray;
}

mappedArray = myMap(myArray, addElements);

console.log(myArray);
console.log(mappedArray);


// Reduce
const numbers = [2, 3, 67, 33];

function getSum(total, element) {
    return total + element;
}

function myReduce(array, callback) {
    let sum = 0;

    for (let i = 0; i < array.length; i++) {
        sum = callback(sum, array[i]);
    }
    return sum;
}

newReducedArray = myReduce(numbers, getSum);

console.log(numbers);
console.log(newReducedArray);



// PROTOTYPES
myArray = ["Lars", "Jan", "Peter", "Bo", "Frederik"];

// Prototype filter
Array.prototype.myFilter = function(callback) {
    let newArray = [];
    for (let i = 0; i < this.length; i++) {
        if (callback(this[i])) {
            newArray.push(this[i]);
        }
    }
    return newArray;
};

let filteredArray = myArray.myFilter(nameLength);
console.log(filteredArray);

// Prototype map
Array.prototype.myMap = function(callback) {
    let newArray = [];
    for (let i = 0; i < this.length; i++) {
        newArray.push(callback(this[i]));
    }
    return newArray;
};

let mappedArray = myArray.myMap(addElements);
console.log(mappedArray);



// OBJECTS
let ego = {
    name: "Mike Tyson",
    birthday: "05-02-1978",
    hobby: "Stay out of trouble",
    email: "mail@mail.dk"
};

for (let i = 0; i < ego.length; i++) {
    if (ego[i].hobby === "name") {
        console.log("ping");
    }
}

for (let property in object) {
    if (object.hasOwnProperty(property)) {
        console.log(this)
    }
}

delete ego.name;
console.log(ego);



class Person {

    constructor(firstName, lastName, age) {
        this._firstName = firstName;
        this._lastName = lastName;
        this._age = age;
    }


    get firstName() {
        return this._firstName;
    }

    set firstName(value) {
        this._firstName = value;
    }

    get lastName() {
        return this._lastName;
    }

    set lastName(value) {
        this._lastName = value;
    }

    get age() {
        return this._age;
    }

    set age(value) {
        this._age = value;
    }
}

// Person instantiation
pers = new Person("Mike", "Johnson", "40");

console.log(pers.firstName);



// PROMISES
function count(number) {

    while (number !== 0) {
        number--;
    }

    return "Done decrementing!";
}

let calculator = function(name, num, delay) {
    return new Promise(function(resolve, reject) {
        let message;
        setTimeout(function() {
            message = count(num);

            let isDone = true;

            if (isDone) {
                resolve(name + ": " + message);
            } else {
                reject("Failed");
            }

        }, delay);

    });
};

// SYNCED results
let c1 = calculator("c1", 100, 2000);
let c2 = calculator("c2", 10000000000, 5000);
let c3 = calculator("c3", 10000, 1000);

Promise.all([c1, c2, c3]).then(function(data) {
    console.log(data);
}).catch(function(error) {
    console.log(error);
});

// ASYNC results
setTimeout(function() {
    console.log("c1: " + count(100));
}, 2000);

setTimeout(function() {
    console.log("c2: " + count(10000000000));
}, 5000);

setTimeout(function() {
    console.log("c3: " + count(10000));
}, 1000);


// FetchPerson - ASYNC AWAIT
const fetch = require('node-fetch');

const URL = "https://swapi.co/api/people/";

function fetchPerson(url) {
    fetch(url).then(function(data) {
        return data.json();
    }).then(function(data) {
        console.log(data);
    });
}

async function printNames() {
    console.log("Before");
    const person1 = await fetchPerson(URL + 1);
    const person2 = await fetchPerson(URL + 2);
    console.log(person1.name);
    console.log(person2.name);
    console.log("After all");
}

printNames();



// TYPESCRIPT
// a
interface iBook {
    title: string;
    readonly author: string;
    published: string;
    pages: number;
}

// b
function myBook(book: iBook): void {
    console.log(book.title, book.author, book.published, book.pages);
}

let bible = {
    title: "The Bible",
    author: "A holy crowd",
    published: "Too long ago",
    pages: 1000
};

myBook(bible);

// c

// d
interface iBook2 {
    title: string;
    author: string;
    published?: string;
    pages?: number;

    thisFunction(): void;
}

// e - done

// f
class Book implements iBook2 {

    title: string = "The adventure";
    author: string = "Joe Rogan";
    published: string = "12 february 2018";
    pages: number = 400;

    constructor() {

    }

    thisFunction(): void {
        throw new Error("Method not implemented.");
    }

}


// CLOSURES
function sayHello(name) {
  var text = 'Hello ' + name;
  var say = function() { console.log(text); }
  say();
}
sayHello('Joe');

function sayHello2(name) {
  var text = 'Hello ' + name; // Local variable
  var say = function() { console.log(text); }
  return say;
}
var say2 = sayHello2('Bob');
say2(); // logs "Hello Bob"

function say667() {
  // Local variable that ends up within closure
  var num = 42;
  var say = function() { console.log(num); }
  num++;
  return say;
}
var sayNumber = say667();
sayNumber(); // logs 43


// HOISTING
function hoist() {
  a = 20;
  var b = 100;
}
hoist();
console.log(a); 
/* 
Accessible as a global variable outside hoist() function
Output: 20
*/
console.log(b);
/*
Output: ReferenceError: b is not defined
*/

var hoist;
console.log(hoist); // Output: undefined
hoist = 'The variable has been hoisted.';


function hoist() {
  console.log(message);
  var message='Hoisting is all the rage!'
}
hoist();


// Immediately-Invoked Function Expressions (IIFE)
// Variation 1
(function() {
    alert("I am an IIFE!");
}());

// Variation 2
(function() {
    alert("I am an IIFE, too!");
})();


// INHERITANCE
var inheritsFrom = function (child, parent) {
    child.prototype = Object.create(parent.prototype);
};

var ClassB = function() {
    this.name = "class B";
    this.surname = "I'm the child";
}

inheritsFrom(ClassB, ClassA);

var b = new ClassB();
b.print();

/* Output: class B */


// CALLBACK HELL
fs.readdir(source, function (err, files) {
  if (err) {
    console.log('Error finding files: ' + err)
  } else {
    files.forEach(function (filename, fileIndex) {
      console.log(filename)
      gm(source + filename).size(function (err, values) {
        if (err) {
          console.log('Error identifying file size: ' + err)
        } else {
          console.log(filename + ' : ' + values)
          aspect = (values.width / values.height)
          widths.forEach(function (width, widthIndex) {
            height = Math.round(width / aspect)
            console.log('resizing ' + filename + 'to ' + height + 'x' + height)
            this.resize(width, height).write(dest + 'w' + width + '_' + filename, function(err) {
              if (err) console.log('Error writing file: ' + err)
            })
          }.bind(this))
        }
      })
    })
  }
});

router.post('/:id/title-image', (req, res, next) => {
    lwip.open(req.file.buffer, 'jpg', (err, image) => {
        if (err) { next(err); return; }
        let ratio = (image.width() > 960 ? (960 / image.width()) : 1);
        image.scale(ratio, (err, image) => {
            if (err) { next(err); return; }
            image.crop(image.width(), Math.min((image.width() / 2), image.height()), (err, image) => {
                if (err) { next(err); return; }
                image.toBuffer('jpg', { quality: 80 }, (err, buffer) => {
                    if (err) { next(err); return; }
                    db.doc.attachment.write(req.params['id'], "TITLE_IMAGE", buffer, "image/jpeg", (err) => {
                        if (err) { next(err); return; }
                        res.sendStatus(200);
                    });
                });
            });
        });
    });
});


// MOCHA CHAI
describe('axe', function () {
	'use strict';

	it('should report that good HTML is good', function (done) {
		var n = document.getElementById('working');
		axe.run(n, function (err, result) {
			expect(err).to.be.null();
			expect(result.violations.length).to.equal(0);
			done();
		});
	});

	it('should report that bad HTML is bad', function (done) {
		var n = document.getElementById('broken');
		axe.run(n, function (err, result) {
			expect(err).to.be.null();
			expect(result.violations.length).to.equal(1);
			done();
		});
	});
});