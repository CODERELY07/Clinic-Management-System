<?php
     require_once 'connection/connection.php';

     $doctorS = $_POST['doctorS'];
     
     $sql = "SELECT * FROM doctor WHERE specialization = '$doctorS'";
     $result = $conn->query($sql);
     $output = "<option selected value=''>Select Specialization</option>";
     if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $output .= "<option value='".$row['name']."'>".$row['name'] . "</option>";
        }
     }
         echo $output;
        $conn->close();
    ?>
