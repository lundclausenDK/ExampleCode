<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/db/DB_Connector.php");
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/mappers/iMapper.php");

class UserMapper implements iMapper {

    public function getConnection() {
        $dbc = new DB_Connector();
        return $dbc->newConnection();
    }

    public function add($Object) {
        // Get connection
        $con = $this->getConnection();

        // Get data
        $name = $Object->getUsername();
        $pass = $Object->getPassword();

        // Prepare and execute
        $stmt = $con->prepare("INSERT INTO users (user_name, user_password) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $pass);
        $stmt->execute();

        // Close
        $stmt->close();
        $con->close();

        header("location: ../index.php");
    }

    public function load($id) {
        // TODO: Implement load() method.
    }

    public function login() {

        $con = $this->getConnection();

        $user = mysqli_real_escape_string($con, $_POST["user"]);
        $password = mysqli_real_escape_string($con, hash("sha256", $_POST["password"]));

        // Get user data from database
        $query = mysqli_query($con, "SELECT user_name FROM users WHERE user_name = '$user' AND user_password = '$password'") or die(mysqli_error($con));
        $query_user_id = mysqli_query($con, "SELECT user_id FROM users WHERE user_name = '$user'");

        $total = mysqli_num_rows($query);

        if ($total > 0) {
            session_start();

            // Set logged-in user's id to session
            $user_result = mysqli_fetch_row($query_user_id);
            $_SESSION["user_id"] = $user_result[0];

            header("location: ../home.php");
        } else {
            echo "Login error!";
        }

    }
}