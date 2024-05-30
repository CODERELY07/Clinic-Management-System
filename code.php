<?php
  
  require_once 'connection/connection.php';
  
  if(isset($_POST['click_view_btn'])){
    $id = $_POST['user_id'];

    $query = "SELECT * FROM doctor WHERE id='$id'";
    $fetch_query = mysqli_query($conn,$query);

    if(mysqli_num_rows($fetch_query) > 0){
        while($row = mysqli_fetch_array($fetch_query)){
            echo '
            <h6>User id : ' . $row['id'] .'</h6>
            <h6>Doctor name : ' . $row['name'] .'</h6>
            <h6>Age : ' . $row['age'] .'</h6>
            <h6>Phone Number : ' . $row['phone'] .'</h6>
            <h6>Email : ' . $row['email'] .'</h6>
            <h6>Address : ' . $row['address'] .'</h6>
            <h6>Sex : ' . $row['gender'] .'</h6>
            <h6>Specialization : ' . $row['specialization'] .'</h6>
           
            ';
        }
    }else{
        echo $result = '<h4>No record found</h4>';
    }
  }
  
  //edit
  if(isset($_POST['click_edit_btn'])){
    $id = $_POST['user_id'];

    $arrayresult = [];
    $query = "SELECT * FROM doctor WHERE id='$id'";
    $fetch_query = mysqli_query($conn,$query);

    if(mysqli_num_rows($fetch_query) > 0){
      while($row = mysqli_fetch_array($fetch_query)){
        array_push($arrayresult,$row);
        header('content-type: application/json');
        echo json_encode($arrayresult);
      }
    }
    else{
      echo $result = '<h4>No record found</h4>';
    }
  }

   //update data
   if(isset($_POST['update_data'])){
    $name = $_POST['doctorname'];
    $id = $_POST['id'];
    $email = $_POST['doctoremail'];
    $age = $_POST['doctorage'];
    $specialization = $_POST['specialization'];
    $phone = $_POST['doctorphone'];
    $address = $_POST['doctoraddress'];
    $password = $_POST['doctorpassword'];
    $gender = $_POST['doctorgender'];

    $update_query = "UPDATE doctor SET name='$name', email='$email', phone='$phone',age='$age', specialization = '$specialization',address = '$address', password = '$password', gender = '$gender' WHERE id = '$id'";

    $update_query_run = mysqli_query($conn,$update_query);

    if($update_query_run){
        $_SESSION['status'] = "Data Updated successfully";
        header("Location: index.php");
    }else{
        $_SESSION['status'] = "Data not updated successfully";
        header("Location: index.php");
    }
    

  }

//delete data

if(isset($_POST['click_delete_button'])){
  $id = $_POST['user_id'];

  $delete_query = "DELETE FROM doctor WHERE id='$id'";
  $delete_run = mysqli_query($conn, $delete_query);

  if($delete_run){
      echo "Data deleted Successfully";
  }else{
      die($conn->error . "Data delition Not Successfulll");
  }
}

//patient
//view patient
if(isset($_POST['click_patient_view_btn'])){
  $id = $_POST['patient_id'];

  $query = "SELECT * FROM patient WHERE id='$id'";
  $fetch_query = mysqli_query($conn,$query);

  if(mysqli_num_rows($fetch_query) > 0){
      while($row = mysqli_fetch_array($fetch_query)){
          echo '
          <h6>Patient id : ' . $row['id'] .'</h6>
          <h6>Patient name : ' . $row['name'] .'</h6>
          <h6>Age : ' . $row['email'] .'</h6>
          <h6>Phone Number : ' . $row['phone'] .'</h6>
          <h6>Email : ' . $row['email'] .'</h6>
          <h6>Address : ' . $row['address'] .'</h6>
          <h6>Password : ' . $row['password'] .'</h6>
         
          ';
      }
  }else{
      echo $result = '<h4>No record found</h4>';
  }
}

  //edit
  if(isset($_POST['click_patient_edit_btn'])){
    $id = $_POST['patient_id'];

    $array_result = [];
    $query = "SELECT * FROM patient WHERE id='$id'";
    $fetch_query = mysqli_query($conn,$query);

    if(mysqli_num_rows($fetch_query) > 0){
      while($row = mysqli_fetch_array($fetch_query)){
        array_push($array_result,$row);
        header('content-type: application/json');
        echo json_encode($array_result);
      }
    }
    else{
      echo $result = '<h4>No record found</h4>';
    }
  }

   //update data
   if(isset($_POST['update_patient_data'])){
    $name = $_POST['patientname'];
    $id = $_POST['id_pat'];
    $email = $_POST['patientemail'];
    $age = $_POST['patientage'];
    $phone = $_POST['patientphone'];
    $address = $_POST['patientaddress'];
    $password = $_POST['patientpassword'];

    $update_patient_query = "UPDATE patient SET name='$name', email='$email', phone='$phone', age='$age', address='$address', password='$password' WHERE id='$id'";

    $update_patient_query_run = mysqli_query($conn,$update_patient_query);

    if($update_patient_query_run){
        die("update " . $conn->error);
        header("Location: index.php");
    }else{
        die("update not " . $conn->error);
        header("Location: index.php");
    }
  }

  
//delete data

if(isset($_POST['click_patient_delete_button'])){
  $id = $_POST['patient_id'];

  $delete_query = "DELETE FROM patient WHERE id='$id'";
  $delete_run = mysqli_query($conn, $delete_query);

  if($delete_run){
      echo "Data deleted Successfully";
  }else{
      die($conn->error . "Data delition Not Successfulll");
  }
}

?>