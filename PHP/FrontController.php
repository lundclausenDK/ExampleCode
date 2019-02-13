<?php
session_cache_limiter(FALSE); 
/*
spl_autoload_register(function($class){
    $file = str_replace('\\', '/', $class);
    require_once "$file.php";
});
*/
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/model/connector/DBConnector.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/model/mapper/ProfileMapper.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/model/mapper/AreaMapper.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/model/mapper/ExperienceMapper.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/model/mapper/MessageMapper.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/model/mapper/LoginMapper.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/model/mapper/MapperTools.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/model/mail/Mailer.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/model/Profile.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/model/Message.php");

function printExpDropdown($keyValuePairs, $exp_id, $isSelected) {
    //print_r($isSelected);
    echo "<select name='experience_$exp_id'>";
    echo "<option value='' disabled selected>Angiv erfaring...</option>";
    foreach ($keyValuePairs as $key => $value) {
        if ($isSelected[0] == true && $key == $isSelected[1]) {
            echo "<option value='" . $key ."' selected>" . $value . "</option>";
        } else {
            echo "<option value='" . $key ."'>" . $value . "</option>";
        }
        
    }
    echo "</select>";
}

function printAllAreas() {
    $dbc = new DBConnector();
    $con = $dbc->newConnection();
    $mapper = new AreaMapper($con);
    
    $result = $mapper->getAllAreas()->fetch_all();
    $profile_selected = $mapper->getAllSelectedAreasWithExp($_SESSION["profile_id"], false)->fetch_all();

    $exp_mapper = new ExperienceMapper($con);
    $exp_result = $exp_mapper->getAllExp();
    $exp_options = [];

    while ($row = mysqli_fetch_assoc($exp_result)) {
        $exp_options[$row["exp_id"]] = $row["exp_duration"];
    }

    // Store main area to prevent repeating print
    $main_area = "";

    // Prepare array for option selects per checkbox
    $selectedArray = [];

    // Prepare boolean for validating checked marks
    $matchFound = true;
    

    // Lets print all areas and select dropdowns
    for ($i = 0; $i < sizeof($result); $i++) {
        
        // Prevent repeating print
        $print_done = false;
        
        // Set area headline
        if ($main_area != $result[$i][2]) {
            echo "<hr>";
            echo "<h5>" . $result[$i][2] . "</h5>";
            $main_area = $result[$i][2];
        }

        // If user has no areas and experience selected
        if (sizeof($profile_selected) == 0) {
            echo " <input type='checkbox' name='area[]' value='" . $result[$i][0] . "'> " . $result[$i][1] . " ";
            printExpDropdown($exp_options, $result[$i][0], $selectedArray);
        } else {
            // Mark checkboxes if selected in DB
            for ($y = 0; $y < sizeof($profile_selected); $y++) {
                if ($result[$i][0] == $profile_selected[$y][1]) {
                    echo " <input type='checkbox' name='area[]' value='" . $result[$i][0] . "' checked> " . $result[$i][1] . " ";
                    $selectedArray[0] = true;
                    $selectedArray[1] = $profile_selected[$y][2];
                    printExpDropdown($exp_options, $result[$i][0], $selectedArray);
                    //$profile_selected[$y][1] = null;
                    $print_done = true;
                } else {
                    $matchFound = false;
                }
            }

            if ($matchFound == false && $print_done == false) {
                echo " <input type='checkbox' name='area[]' value='" . $result[$i][0] . "'> " . $result[$i][1] . " ";
                $selectedArray[0] = false;
                printExpDropdown($exp_options, $result[$i][0], $selectedArray);
            }
        }
        
        
    }
    $con->close();
}

function printSearchResult() {
    session_start();

    if (isset($_SESSION["search"])) echo "Du søgte på: " . $_SESSION["search"];
    if (isset($_SESSION["search_geo"])) echo ", " . $_SESSION["search_geo"];
    if (isset($_SESSION["search_exp"])) {
        foreach ($_SESSION["search_exp"] as $selected) {
            echo ", " . $selected;
        }
    }
    echo "<br><br>";
    
    $result = $_SESSION["search_result"];
    $year = date('Y');

    //print_r($result);

    for ($i = 0; $i < sizeof($result); $i++) {
        if ($result[$i][0] != $result[$i-1][0]) {
            echo "<div class='custom-box'>";
            echo $result[$i][3] . "<br>";
            echo $result[$i][1] . "<br>";
            echo $year - $result[$i][2] . " år<br>";
            echo $result[$i][4] . "<br>";
            echo $result[$i][5] . "<br>";
    
            echo "<br><a href='/app/view/profile.php?id=" . $result[$i][0] . "' class='button button-block'>Se profil</a>";
            echo "</div>";
        }

    }

    session_destroy();
}

function printProfilePage() {
    session_start();
    $dbc = new DBConnector();
    $con = $dbc->newConnection();
    $mapper = new ProfileMapper($con);
    $area_mapper = new AreaMapper($con);

    $id = $_GET["id"];
    $profile_result = $mapper->getProfileById($id);
    $area_result = $area_mapper->getAllSelectedAreasWithExp($id, true);

    while ($row = mysqli_fetch_assoc($profile_result)) {
        $_SESSION["profile_name"] = $row["profile_name"];
        
        echo $row["profile_title"] . "<br>";
        echo $row["profile_gender"] . "<br>";
        echo $row["profile_birthyear"] . "<br>";
        echo $row["profile_geo"] . "<br>";
        echo $row["profile_contract"] . "<br>";
    }
    echo "<hr>";
    while ($row = mysqli_fetch_assoc($area_result)) {
        echo $row["law_subarea_name"] . " - ";
        echo $row["exp_duration"] . "<br>";
    }
    $con->close();
}

function printHiddenField() {
    $id = $_GET["id"];
    echo "<input type='hidden' name='profile_id' value='$id'>";
}

function printProfileMessages() {
    $dbc = new DBConnector();
    $con = $dbc->newConnection();
    $mapper = new MessageMapper($con);

    $profile_id = $_SESSION["profile_id"];
    $result = $mapper->getMessagesByProfileId($profile_id);

    while ($row = mysqli_fetch_assoc($result)) {
        
        // Set button colors upon status
        if ($row["message_agreement"] == 1) {
            $color_yes = "btn-success";
            $color_no = "btn-secondary";
        } else if ($row["message_agreement"] == 2) {
            $color_no = "btn-danger";
            $color_yes = "btn-secondary";
        } else {
            $color_yes = "btn-secondary";
            $color_no = "btn-secondary";
        }

        // Print messages and buttons
        echo "<hr>";
        echo "<div class='row'>";
            echo "<div class='col-4'>";
                echo $row["message_datetime"] . "<br>";
                echo $row["message_contract"] . "<br>";
                echo $row["message_content"] . "<br>";
                echo "</div>";
                
                echo "<div class='col-4'>";
                echo $row["message_sender_person"] . "<br>";
                echo $row["message_sender_phone"] . "<br>";
                echo $row["message_sender_email"] . "<br>";
                echo $row["message_sender_company"] . "<br>";
                echo $row["message_agreement"] . "<br>";
            echo "</div>";

            echo "<div class='col-4 text-right'>";
                echo "<form action='/app/controller/FrontController.php?updateAgreementStatus' method='post'>";
                    echo "<br><div class='btn-group' role='group'>";
                        echo "<button type='submit' class='btn $color_yes' name='agreement_status' value='1'>Ja</button>";
                        echo "<input type='hidden' name='profile_id' value='$profile_id'>";
                        echo "<input type='hidden' name='message_id' value='" . $row["message_id"] . "'>";
                        echo "<button type='submit' class='btn $color_no' name='agreement_status' value='2'>Nej</button>";
                    echo "</div>";
                    echo "</form>";
            echo "</div>";
        echo "</div>";
    }
    $con->close();
}

function printAreaSearchField() {
    $dbc = new DBConnector();
    $con = $dbc->newConnection();
    $mapper = new AreaMapper($con);
    
    $result = $mapper->getAllAreas()->fetch_all();

    echo "<input type='text' name='subarea' class='awesomplete form-control' data-list='";
    for ($i = 0; $i < sizeof($result); $i++) {
        echo $result[$i][1] . ", ";
    }
    echo "' placeholder='Skriv ønsket specialeområde...'/>";

    $con->close();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
// Controller url actions
foreach ($_GET as $key => $value) {
    switch ($key) {

        case "login":
            if (isset($_POST["username"])) {
                $dbc = new DBConnector();
                $con = $dbc->newConnection();
                $mapper = new LoginMapper($con);
            
                // Save inputs
                $login[0] = $_POST["username"];
                $login[1] = hash("sha256", $_POST["password"]);
                
                // Run query and save result
                $result = $mapper->userLogin($login);
                $data = $result->fetch_assoc();
                $total = $result->num_rows;
                
                $userId = $data["profile_id"];
                $userName = $data["profile_name"];

                // Login logic
                if ($total > 0) {
                    session_start();
                    $_SESSION["profile_id"] = $userId;
                    $_SESSION["profile"] = $userName;
                    
                    header("location: /app/view/my-profile.php");
                } else {
                    echo "Login error!";
                }
            }
            $con->close();
            break;

        case "logout":
            session_start();
            session_destroy();
            header("location: /");
            break;

        case "createProfile":
            $dbc = new DBConnector();
            $con = $dbc->newConnection();

            $username = $_POST["email"];
            $password = hash("sha256", $_POST["password"]);
            $fullname = $_POST["fullname"];
            $address = $_POST["address"];
            $city = $_POST["city"];
            $zip = $_POST["zip"];
            $phone = $_POST["phone"];
            $gender = $_POST["gender"];
            $birthyear = $_POST["birthyear"];
            $title = $_POST["title"];
            $geo = implode(",", $_POST["geo"]);
            $contract = $_POST["contract"];

            $profile = new Profile(0, $username, $password, $fullname, $address, $city, $zip, $phone, $gender, $birthyear, $title, $geo, $contract);

            $mapper = new ProfileMapper($con);
            $mapper->createProfile($profile);

            $con->close();
            header("Location: /app/view/");
            break;
        
        case "editAreas":
            session_start();
            $dbc = new DBConnector();
            $con = $dbc->newConnection();
            $mapper = new AreaMapper($con);

            $profile_id = $_SESSION["profile_id"];

            foreach($_POST['area'] as $selected){
                $area_exp_pairs[$selected] = $_POST["experience_$selected"];
            }

            // First delete all rows
            $mapper->deleteAllRowsWithProfileId($profile_id);

            // Then save selected checkmarks from scratch
            $mapper->editAreas($area_exp_pairs, $profile_id);

            $con->close();
            header("Location: /app/view/edit-areas.php");
            break;

        case "search":
            session_start();
            $dbc = new DBConnector();
            $con = $dbc->newConnection();
            $mapper = new ProfileMapper($con);
            
            if (isset($_POST["subarea"])) {
                $subarea[0] = $_POST["subarea"];
                $_SESSION["search"] = $subarea[0];
            } else {
                $subarea[0] = false;
            }
            
            if (isset($_POST["geo"])) {
                $subarea[1] = $_POST["geo"];
                $_SESSION["search_geo"] = $subarea[1];
            } else {
                $subarea[1] = false;
            }

            if (isset($_POST["exp"])) {
                $subarea[2] = $_POST["exp"];
                $_SESSION["search_exp"] = $subarea[2];
            } else {
                $subarea[2] = false;
            }
            
            $_SESSION["search_result"] = $mapper->search($subarea)->fetch_all();

            $con->close();
            header("Location: /app/view/result.php");
            break;

        case "createMessage":
            session_start();
            $dbc = new DBConnector();
            $con = $dbc->newConnection();
            $mapper = new MessageMapper($con);
            $mailer = new Mailer();

            $content = $_POST["content"];
            $contract = $_POST["contract"];
            $company = $_POST["company"];
            $person = $_POST["person"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $profile_id = $_POST["profile_id"];
            $agreement = 0;
 
            $users_email = $_SESSION["profile_name"];
            
            $message = new Message(0, $content, $contract, $company, $person, $email, $phone, $agreement);
            $mapper->createMessage($message, $profile_id);
            $mailer->sendMail($users_email, $email, $content, $person, $company);
            session_destroy();
            
            $con->close();
            header("Location: /app/view/");
            break;
        
        case "updateAgreementStatus":
            session_start();
            $dbc = new DBConnector();
            $con = $dbc->newConnection();
            $mapper = new MessageMapper($con);

            $profile_id = $_SESSION["profile_id"];
            $message_id = $_POST["message_id"];
            $agreement_status_id = $_POST["agreement_status"];

            $mapper->updateMessageById($profile_id, $message_id, $agreement_status_id);

            $con->close();
            header("Location: /app/view/my-profile.php");
            break;
    }
}