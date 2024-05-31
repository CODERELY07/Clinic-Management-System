<?php
    session_start();

    require_once 'connection/connection.php';
    if(isset($_SESSION['admin_id'])){
        header("Location:admin-dashboard.php");
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script defer src="js/script.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <main>
                <div class="roleField">
                    <label for="role">Select your role</label>
                    <button class="btn" onclick="changePage('admin-login')">Admin</button>
                    <button class="btn" onclick="changePage('doctor-login')">Doctor</button>
                    <button class="btn" onclick="changePage('patient-login')">Patient</button>
                </div>

                <div class="hidden dashactive" id="admin-login">
                    <h2>Admin</h2>
                    <form action="login.php" method="post">
                        <div class="inputFields">
                            <label for="">Email:</label>
                            <input type="email" name="adminEmail" id="adminEmail">
                        </div>
                        <div class="inputFields">
                            <label for="">Password:</label>
                            <input type="password" name="adminPass" id="adminPass">
                        </div>
                        <input type="submit" value="Login" name="adminLogin">
                    </form>
                </div>
                <div class="hidden" id="doctor-login">
                    <h2>doctor</h2>
                    <form action="#">
                        <div class="inputFields">
                            <label for="">Email:</label>
                            <input type="email" name="doctorEmail" id="doctorEmail">
                        </div>
                        <div class="inputFields">
                            <label for="">Password:</label>
                            <input type="password" name="doctorPass" id="doctorPass">
                        </div>
                        <input type="submit" value="Login" name="doctorLogin">
                    </form>
                </div>
                <div class="hidden" id="patient-login">
                    <h2>patient</h2>
                    <form action="#">
                        <div class="inputFields">
                            <label for="">Email:</label>
                            <input type="email" name="patientEmail" id="patientEmail">
                        </div>
                        <div class="inputFields">
                            <label for="">Password:</label>
                            <input type="password" name="patientPass" id="patientPass">
                        </div>
                        <input type="submit" value="Login" name="patientLogin">
                    </form>
                </div>
        </main>
    </div>
</body>
</html>