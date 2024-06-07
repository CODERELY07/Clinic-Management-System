<?php
    session_start();

    require_once 'connection/connection.php';
    if(isset($_SESSION['admin_id'])){
        header("Location:admin-dashboard.php");
        exit();
    }
    if(isset($_SESSION['patient_id'])){
        header("Location:patient-dashboard.php");
        exit();
    }

    if( isset($_POST['adminLogin'])){
       $email =  mysqli_real_escape_string($conn, $_POST['adminEmail']);
       $password =  mysqli_real_escape_string($conn, $_POST['adminPass']);

       $sql = "SELECT * FROM admin WHERE email = '$email' && password = '$password'";

       $result = $conn->query($sql) or die($conn->error);

       if($result && $result->num_rows > 0){
          $row = $result->fetch_assoc();
          $_SESSION['admin_id'] = $row['id'];
          echo header("Location: admin-dashboard.php");
          exit();
       }else{
          echo "User not found";
       }
    }

    if(isset($_POST['patientLogin'])){
       $email =  mysqli_real_escape_string($conn, $_POST['patientEmail']);
       $password =  mysqli_real_escape_string($conn, $_POST['patientPass']);

       $sql = "SELECT * FROM patient WHERE email = '$email' && password = '$password'";

       $result = $conn->query($sql) or die($conn->error);

       if($result && $result->num_rows > 0){
          $row = $result->fetch_assoc();
          $_SESSION['patient_id'] = $row['id'];
          echo header("Location: patient-dashboard.php");
          exit();
       }else{
          echo "User not found";
       }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script defer src="js/script.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    <div class="container">
        <main class="mt-5 mx-auto text-center card p-3">
            <div class="roleField">
                <label for="role" class="mb-3">Select your role</label><br>
                <div class="btn-group">
                    <button class="btn btn-primary role-btn" onclick="changePage('admin-login')">Admin</button>
                    <button class="btn btn-primary role-btn" onclick="changePage('doctor-login')">Doctor</button>
                    <button class="btn btn-primary role-btn" onclick="changePage('patient-login')">Patient</button>
                </div>
            </div>

            <div class="hidden dashactive" id="admin-login">
                <h2>Admin</h2>
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label for="adminEmail" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="adminEmail" name="adminEmail">
                    </div>
                    <div class="mb-3">
                        <label for="adminPass" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="adminPass" name="adminPass">
                    </div>
                    <button type="submit" class="btn btn-primary" name="adminLogin">Login</button>
                </form>
            </div>
            <div class="hidden" id="doctor-login">
                <h2>Doctor</h2>
                <form action="#">
                    <div class="mb-3">
                        <label for="doctorEmail" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="doctorEmail" name="doctorEmail">
                    </div>
                    <div class="mb-3">
                        <label for="doctorPass" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="doctorPass" name="doctorPass">
                    </div>
                    <button type="submit" class="btn btn-primary" name="doctorLogin">Login</button>
                </form>
            </div>
            <div class="hidden" id="patient-login">
                <h2>Patient</h2>
                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="patientEmail" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="patientEmail" name="patientEmail">
                    </div>
                    <div class="mb-3">
                        <label for="patientPass" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="patientPass" name="patientPass">
                    </div>
                    <button type="submit" class="btn btn-primary" name="patientLogin">Login</button>
                </form>
            </div>
        </main>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>