<?php
class MapperTools {
    
    public function runSQL($con, $dataArray, $query, $dataTypes) {
        try {
            // Split datatypes into array
            $sanArray = str_split($dataTypes);

            // Loop datatypes and filter datainputs
            for ($i = 0; $i < sizeof($sanArray); $i++) {
                if ($sanArray[$i] == "s") {
                    $dataArray[$i] = filter_var($dataArray[$i], FILTER_SANITIZE_STRING);
                } else if ($sanArray[$i] == "i") {
                    $dataArray[$i] = filter_var($dataArray[$i], FILTER_SANITIZE_NUMBER_INT);
                } else if ($sanArray[$i] == "d") {
                    $dataArray[$i] = filter_var($dataArray[$i], FILTER_SANITIZE_NUMBER_FLOAT);
                }
            }

            // Prepared statements
            $stmt = $con->prepare($query);
            $stmt->bind_param($dataTypes, ...$dataArray);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Close
            $stmt->close();
            
            return $result;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

