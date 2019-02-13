<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/app/model/mapper/MapperTools.php");


class ProfileMapper {
    
    private $con;
    private $tools;

    public function __construct($connection) {
        $this->con = $connection;
        $this->tools = new MapperTools();
    }

    public function createProfile(Profile $profile) {
        $data = [$profile->getUsername(), $profile->getPassword(), $profile->getGender(), $profile->getbirthyear(), $profile->getTitle(), $profile->getGeo(), $profile->getContract()];
        $sql = "INSERT INTO _profile (profile_name, profile_pass, profile_gender, profile_birthyear, profile_title, profile_geo, profile_contract) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $types = "sssisss";
        
        $this->tools->runSQL($this->con, $data, $sql, $types);
    }

    public function deleteProfile($profile_id) {
        $data = [$profile_id];
        $sql = "DELETE FROM _profile WHERE profile_id = ?";
        $types = "i";

        $this->tools->runSQL($this->con, $data, $sql, $types);
    }

    public function getProfileById($profile_id) {
        $data = [$profile_id];
        $sql = "SELECT profile_name, profile_gender, profile_birthyear, profile_title, profile_geo, profile_contract FROM _profile WHERE profile_id = ?";
        $types = "s";

        return $this->tools->runSQL($this->con, $data, $sql, $types);
    }

    // NEEDS REFACTOR
    public function readProfileIdByEmail($profile_email) {
        $sql = "SELECT * FROM _profile WHERE profile_id = $profile_email";
        $result = $con->query($sql);

        return $result->fetch_all();
    }

    public function getAllProfiles() {
        $data = ["profile_id"];
        $sql = "SELECT * FROM _profile ORDER BY ?";
        $types = "s";

        return $this->tools->runSQL($this->con, $data, $sql, $types);
    }

    public function getHighestId() {
        $data = ["profile_id"];
        $sql = "SELECT profile_id FROM _profile ORDER BY ?";
        $types = "s";

        $result = $this->tools->runSQL($this->con, $data, $sql, $types);

        $output = $result->fetch_all();
        $highNum = 0;

        for ($i = 0; $i < sizeof($output); $i++) {
            if ($output[$i][0] > $highNum) {
                $highNum = $output[$i][0];
            }
        }
        return $highNum;
    }

    // REFACTOR INTO SWITCH
    public function search($keywords) {
        $begin = "SELECT profile_id, profile_gender, profile_birthyear, profile_title, profile_geo, profile_contract FROM _profile_law_subarea NATURAL JOIN _profile ";
        $sql = "";
        $types = "";
        
        if ($keywords[0] == false && $keywords[1] == false && $keywords[2] == false) {
            // If all fields are empty
            $search = ["exp_id"];
            $sql = $begin . "ORDER BY ?";
            $types = "s";
        } else if ($keywords[0] != false && $keywords[1] == false && $keywords[2] == false) {
            // If only first field is filled out
            $search = [$keywords[0]];
            $sql = $begin . "NATURAL JOIN _module_law_subarea WHERE law_subarea_name = ?";
            $types = "s";
        } else if ($keywords[0] == false && $keywords[1] != false && $keywords[2] == false) {
            // If only second field is filled out
            $search = [$keywords[1]];
            $sql = $begin . "NATURAL JOIN _module_law_subarea WHERE FIND_IN_SET(?,profile_geo)";
            $types = "s";
        } else if ($keywords[0] == false && $keywords[1] == false && $keywords[2] != false) {
            // If only third field is filled out
            $search = [];
            $sql = $begin . "NATURAL JOIN _module_law_subarea NATURAL JOIN _experience WHERE ";

            // Loop exp checkboxes
            for ($i = 0; $i < sizeof($keywords[2]); $i++) {
                array_push($search, $keywords[2][$i]);
                $sql .= " exp_duration = ? ";
                if ($i+1 != sizeof($keywords[2])) {
                    $sql .= " OR ";
                }
                $types .= "s";
            }
        } else if ($keywords[0] != false && $keywords[1] != false && $keywords[2] == false) {
            // If first two fields are filled out
            $search = [$keywords[0], $keywords[1]];
            $sql = $begin . "NATURAL JOIN _module_law_subarea NATURAL JOIN _experience WHERE law_subarea_name = ? AND FIND_IN_SET(?,profile_geo)";
            $types = "ss";
        } else if ($keywords[0] != false && $keywords[1] == false && $keywords[2] != false) {
            // If first and last field are filled out
            $search = [];
            $sql = $begin . "NATURAL JOIN _module_law_subarea NATURAL JOIN _experience WHERE ";

            // Loop exp checkboxes
            for ($i = 0; $i < sizeof($keywords[2]); $i++) {
                array_push($search, $keywords[0], $keywords[2][$i]);
                $sql .= " law_subarea_name = ? AND exp_duration = ? ";
                if ($i+1 != sizeof($keywords[2])) {
                    $sql .= " OR ";
                }
                $types .= "ss";
            }
        } else if ($keywords[0] == false && $keywords[1] != false && $keywords[2] != false) {
            // If second and last field are filled out
            $search = [];
            $sql = $begin . "NATURAL JOIN _module_law_subarea NATURAL JOIN _experience WHERE ";

            // Loop exp checkboxes
            for ($i = 0; $i < sizeof($keywords[2]); $i++) {
                array_push($search, $keywords[1], $keywords[2][$i]);
                $sql .= " profile_geo = ? AND exp_duration = ? ";
                if ($i+1 != sizeof($keywords[2])) {
                    $sql .= " OR ";
                }
                $types .= "ss";
            }
        } else if ($keywords[0] != false && $keywords[1] != false && $keywords[2] != false) {
            // If all fields are filled out
            $search = [];
            $sql = $begin . "NATURAL JOIN _module_law_subarea NATURAL JOIN _experience WHERE ";

            // Loop exp checkboxes
            for ($i = 0; $i < sizeof($keywords[2]); $i++) {
                array_push($search, $keywords[0], $keywords[1], $keywords[2][$i]);
                $sql .= " law_subarea_name = ? AND profile_geo = ? AND exp_duration = ? ";
                if ($i+1 != sizeof($keywords[2])) {
                    $sql .= " OR ";
                }
                $types .= "sss";
            }
        }
        return $this->tools->runSQL($this->con, $search, $sql, $types);
    }
    
}