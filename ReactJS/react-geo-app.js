import React from 'react';
import {StyleSheet, Text, View, Button} from 'react-native';

export default class App extends React.Component {

    constructor() {
        super();
        this.state = {
            list: [],
            latitude: null,
            longitude: null,
            error: null,
        };
        this.getGeo = this.getGeo.bind(this);
        //this.getGeo();
    }


    addMyGeo() {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                this.setState({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    error: null,
                });

                return fetch('https://lundclausen.dk/rest/api.php/location/' + this.state.longitude + "x" + this.state.latitude, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                })
            },
            (error) => this.setState({error: error.message}),
            {enableHighAccuracy: true, timeout: 20000, maximumAge: 1000}
        );

        this.setState({list: this.state.list});
    }

    getGeo() {
        let getRequest = new Request("https://lundclausen.dk/rest/api.php/location/");

        fetch(getRequest).then((response) => response.json()).then((responseJson) => {
            this.state.list = [];

            for (let i = 0; i < responseJson.length; i++) {
                this.state.list.push(responseJson[i].geo);
            }
            this.setState({list: this.state.list});
        }).catch((error) => {
            console.error(error);
        });
    }

    render() {
        return (
            <View style={styles.container}>
                <Text style={{fontWeight: 'bold'}}>Welcome to my GEO APP</Text>
                <Text>Press the button to add your geo-location.</Text>

                <Button
                    onPress={() => {
                        this.addMyGeo();
                        this.getGeo();
                    }}
                    title="Press this!"
                />

                {this.state.list.map((element) => {
                    return (<Text key={element}>{element}</Text>);
                })}

            </View>
        );
    }
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: '#fff',
        alignItems: 'center',
        justifyContent: 'center',
    },
    button: {
        marginBottom: 30,
        width: 260,
        alignItems: 'center',
        backgroundColor: '#2196F3'
    },
    buttonText: {
        padding: 20,
        color: 'white'
    }
});
