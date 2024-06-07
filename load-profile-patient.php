<?php
    require_once 'connection/connection.php';

    $id = $_POST['id'];
    $sql = "SELECT * FROM patient WHERE id = $id";
    $result = $conn->query($sql);

    $output = "";
    if($result->num_rows > 0){
        $output .= "<ul>";
        while($row = $result->fetch_assoc()){
            foreach($row as $key => $value) {
                // Skip certain columns
                if($key == 'id' || $key == 'created_at' || $key == 'password'){
                    continue;
                }
                $output .= "<li class='m-3 border border-dark rounded p-3 bg-light fs-6'>" . "<strong>" . ucfirst($key) . "</strong>" . ": " . $value . "</li>"; // ucfirst() to capitalize the field name
            }
        }
        $output .= "</ul>";
    }

    echo $output;
    $conn->close();
?>
