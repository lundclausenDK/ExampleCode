import React from "react";
import "../index.css";

class ShoppingListCustom extends React.Component {
    constructor() {
        super();

        this.state = ({list: []});
        console.log(this.state);

        this.addToList = this.addToList.bind(this);
        this.removeFromList = this.removeFromList.bind(this);
    }

    addToList(event) {
        let shoppingField = document.getElementById("field");
        this.state.list.push(shoppingField.value);
        this.setState({list: this.state.list});

        shoppingField.value = "";
        event.preventDefault();
    }

    removeFromList(event) {
        const myElement = event.target.innerText;
        const index = this.state.list.indexOf(myElement);
        console.log(index, myElement);
        this.state.list.splice(index, 1);
        this.setState({list: this.state.list});
        event.preventDefault();
    }

    render() {
        return (
            <div className="sl-custom-container">
                <h2>My own shopping list</h2>
                <br/>
                <form>
                <input type="text" id="field"/>
                <button value="Add list item" onClick={this.addToList}>Button</button>
                </form>
                <hr/>

                {this.state.list.map((element) => {
                    return (<div key={element}><a href="#" onClick={this.removeFromList} key={element}>{element}</a></div>);
                })}

            </div>

        );
    }
}

export default ShoppingListCustom;