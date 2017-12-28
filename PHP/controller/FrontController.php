<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/mappers/UserMapper.php");
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/mappers/ProfilesMapper.php");
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/mappers/MessageMapper.php");

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/business_logic/UserHandling.php");
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/business_logic/MessageHandling.php");

// READ //

// Check for logged in users
function loginCheck() {
    session_start();

    if (!isset($_SESSION["user_id"])) {
        header("location: index.php");
    }
}

function loadProfile() {

    // Load specs from database
    $specs = new SpecsMapper();
    //$getSpecs = $specs->load($_SESSION["user_id"]);
    $getSpecs = $specs->load($_GET["id"]);

    return $getSpecs;
}

function printWomen() {
    $data = new ProfilesMapper();
    $getData = $data->load("kvinde");

    foreach ($getData as $value) {
        echo "<p><a href='profilepage.php?id=$value[0]'>" . $value[1] . "</a></p>";
    }
}

function printMen() {
    $data = new ProfilesMapper();
    $getData = $data->load("mand");

    foreach ($getData as $value) {
        echo "<p><a href='profilepage.php?id=$value[0]'>" . $value[1] . "</a></p>";
    }
}

function linkUpdateSpecs() {
    $my_id = $_SESSION["user_id"];
    $others_id = $_GET["id"];

    if ($my_id == $others_id) {
        echo "<a href=\"update-profile-data.php\" class='btn btn-success btn-block'>Opdater profildata</a>";
    }
}

function showContactLink() {
    $my_id = $_SESSION["user_id"];
    $others_id = $_GET["id"];
    $host_id = loadProfile()->getUserId();
    
    if ($my_id != $others_id) {
        echo "<a href='messages.php?id=$host_id' class='btn btn-warning btn-block'>Skriv til mig her</a>";
    }
}

function loadMessages() {
    $data = new MessageMapper();
    $getData = $data->load($_GET["my"]);

    return $getData;
}




// WRITE //

foreach ($_GET as $key => $value) {
    switch ($key) {

        case "login":
            $um = new UserMapper();
            $um->login();
            break;

        case "createUser":
            $uh = new UserHandling();
            $uh->createUser();
            break;

        case "updateSpecs":
            $uh = new UserHandling();
            $uh->updateSpecs();
            break;

        case "sendMessage":
            $mh = new MessageHandling();
            $mh->createMessage();
            break;
    }
}



