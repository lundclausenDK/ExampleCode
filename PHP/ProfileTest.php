<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/app/model/connector/DBConnector.php");
require_once("$root/app/model/Profile.php");
require_once("$root/app/model/mapper/ProfileMapper.php");

class ProfileTest extends \PHPUnit\Framework\TestCase {

    private $con;
    private $mapper;

    protected function setUp() {
        $dbc = new DBConnector();
        $this->con = $dbc->newConnection();
        $this->mapper = new ProfileMapper($this->con);
    }

    public function testCreateProfile() {
        $randNum = rand(1, 100000);

        // Get highest id
        $result = $this->mapper->getHighestId();
        
        // Create dummy data
        $username = "mlc" . $randNum . "@mail.com";
        $password = hash("sha256", "yolo");
        $fullname = "fullname";
        $address = "address";
        $city = "city";
        $zip = 1234;
        $phone = 12345678;
        $gender = "gender";
        $birthyear = 1234;
        $title = "title";
        $geo = "geo";
        $contract = "contract";

        $profile = new Profile(0, $username, $password, $fullname, $address, $city, $zip, $phone, $gender, $birthyear, $title, $geo, $contract);
        $this->mapper->createProfile($profile);
        
        // Get highest id again
        $newStatus = $this->mapper->getHighestId();

        $this->assertTrue($newStatus > $result);
    }
    
    public function testDeleteProfile() {
        // find profile by id
        $id = $this->mapper->getHighestId();

        // delete profile
        $this->mapper->deleteProfile($id);

        // try to find profile just deleted
        $result = $this->mapper->getProfileById($id)->fetch_all();
        $rowCount = sizeof($result);
     
        // if gone, test green
        $this->assertTrue($rowCount == 0);
    }

    protected function tearDown() {
        $this->con->close();
    }
}

