<?php
    session_start();

    if(!isset($_SESSION['admin_id'])){
        header("Location:login.php");
        exit();
    }

    require_once 'connection/connection.php';
    $alertMessage='';

    if(isset($_POST['add-doctor'])){
        $name = $_POST['doctorname'];
        $age = $_POST['doctorage'];
       // Check if 'doctorgender' key exists in $_POST
       $gender = isset($_POST['doctorgender']) ? $_POST['doctorgender'] : '';
        $specialization = $_POST['specialization'];
        $phone = $_POST['doctorphone'];
        $email = $_POST['doctoremail'];
        $address = $_POST['doctoraddress'];
        $password = $_POST['doctorpassword'];

        $query = "INSERT INTO doctor (name,age,gender,phone,email,address,specialization,password) VALUES('$name',$age,'$gender','$phone','$email','$address','$specialization','$password')";
        
        $result = mysqli_query($conn,$query);


        if ($result) {
            // Set the success message
            $_SESSION['alertMessage'] = "<div class='alert alert-success alert-dismissible'>
                                <strong>Success!</strong> Data Inserted Successfully.
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            </div>";
        } else {
            // Set the error message
            $_SESSION['alertMessage'] = "<div class='alert alert-danger alert-dismissible'>
                                <strong>Error!</strong> Failed to insert data.
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            </div>";
        }

        // Redirect to the same page to prevent form resubmission
        header("Location: {$_SERVER['PHP_SELF']}");
        exit; // Stop further execution
    }

    //patient-submit
    
    if(isset($_POST['patient-submit'])){
        $name = $_POST['patientname'];
        $age = $_POST['patientage'];
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $phone = $_POST['patientphone'];
        $email = $_POST['patientemail'];
        $address = $_POST['patientaddress'];
        $password = $_POST['patientpassword'];

        $query = "INSERT INTO patient (name,age,gender,phone,email,address,password) VALUES ('$name','$age','$gender','$phone','$email','$address','$password')";

        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));


        if ($result) {
            // Set the success message
            $_SESSION['alertMessage'] = "<div class='alert alert-success alert-dismissible'>
                                <strong>Success!</strong> Data Inserted Successfully.
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            </div>";
        } else {
            // Set the error message
            $_SESSION['alertMessage'] = "<div class='alert alert-danger alert-dismissible'>
                                <strong>Error!</strong> Failed to insert data.
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            </div>";
        }
        // Redirect to the same page to prevent form resubmission
        header("Location: {$_SERVER['PHP_SELF']}");
        exit; // Stop further execution
    }

    // Check if there's an alert message in the session
    if (isset($_SESSION['alertMessage'])) {
        // Retrieve the alert message
        $alertMessage = $_SESSION['alertMessage'];
        // Clear the session variable
        unset($_SESSION['alertMessage']);
    }
    

    //doctor view
    $doctors_query = "SELECT * FROM doctor";
    $doctors_result = mysqli_query($conn, $doctors_query);
    //patient view
    $patient_query = "SELECT * FROM patient";
    $patient_result = mysqli_query($conn, $patient_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-dashboard</title>
    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div style="position:absolute;top:0;left:0;width:100%;z-index:99" class="text-center">
        <?php echo $alertMessage; ?>
    </div>
<!-- Doctor Modal -->
<!-- View Modal -->
<div class="modal fade" id="viewusermdoal" tabindex="-1" aria-labelledby="viewusermdoalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewusermdoalLabel">Doctor Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- ajax output -->
        <div class="view_user_data">
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- View Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="edit-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-userLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-userLabel">Edit User</h5>
      </div>
      <form action="code.php" method="post">
        <div class="modal-body">
            <div class="form-group mt-3">
                <input type="hidden" id="user_id" name="id" class="form-control" >
            </div>
            <div class="mb-3">
                <label for="doctorname" class="form-label">Name</label>
                <input type="text" class="form-control" id="doctorname" name="doctorname">
            </div>
            <div class="mb-3">
                <label for="doctorage" class="form-label">Age</label>
                <input type="number" class="form-control col-xs-3" id="doctorage" name="doctorage">
            </div>
            <div class="mb-3">
                <label class="form-label d-block">Sex</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="doctorgender" id="doctormale" value="Male">
                    <label class="form-check-label" for="doctormale">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="doctorgender" id="doctorfemale" value="Male">
                    <label class="form-check-label" for="doctorfemale">Female</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="specialization" class="form-label">Specialization</label>
                <select class="form-control" name="specialization" id="specialization">
                    <option value="" selected hidded>Select Specialization</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Neurologist">Neurologist</option>
                    <option value="Urologist">Urologist</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="doctorphone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="doctorphone" name="doctorphone">
            </div>
            <div class="mb-3">
                <label for="doctoremail" class="form-label">Email</label>
                <input type="email" class="form-control" id="doctoremail" name="doctoremail">
            </div>
            <div class="mb-3">
                <label for="doctoraddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="doctoraddress" name="doctoraddress">
            </div>
            <div class="mb-3">
                <label for="doctorpassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="doctorpassword" name="doctorpassword">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" name="update_data" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Patiet Modal -->
<!-- View Modal -->
<div class="modal fade" id="viewpatientmodal" tabindex="-1" aria-labelledby="viewpatientmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewpatientmodalLabel">Doctor Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- ajax output -->
        <div class="view_patient_data">
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- View Modal -->
<!-- Edit Modal -->
<div class="modal fade" id="editpatient" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editpatientLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editpatientLabel">Edit Patient</h5>
      </div>
      <form action="code.php" method="post">
        <div class="modal-body">
            <div class="form-group mt-3">
                <input type="hidden" id="patient_id" name="id_pat" class="form-control" >
            </div>
            <div class="mb-3">
                <label for="patientname" class="form-label">Name</label>
                <input type="text" class="form-control" id="patientname" name="patientname">
            </div>
            <div class="mb-3">
                <label for="patientage" class="form-label">Age</label>
                <input type="number" class="form-control col-xs-3" id="patientage" name="patientage">
            </div>
            <div class="mb-3">
                <label class="form-label d-block">Sex</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="patientmale" value="Male">
                    <label class="form-check-label" for="patientmale">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="patientfemale" value="Female">
                    <label class="form-check-label" for="patientfemale">Female</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="patientphone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="patientphone" name="patientphone">
            </div>
            <div class="mb-3">
                <label for="patientemail" class="form-label">Email</label>
                <input type="email" class="form-control" id="patientemail" name="patientemail">
            </div>
            <div class="mb-3">
                <label for="patientaddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="patientaddress" name="patientaddress">
            </div>
            <div class="mb-3">
                <label for="patientpassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="patientpassword" name="patientpassword">
            </div>
            </div>
        <div class="modal-footer">
            <button type="submit" name="update_patient_data" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

    <div class="wrapper">
        <aside id="sidebar">
           
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="#">MEDICTECH</a>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                       Admin Menu
                    </li>
                    <li class="sidebar-item">
                        <a href="" class="sidebar-link" onclick="changePage('main-dashboard')">
                            <i class="fa-solid fa-list"></i>
                            Dashboard
                        </a>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed" data-bs-target="#doctor" data-bs-toggle="collapse" aria-expanded="false">
                                <i class="fa-solid fa-user-doctor"></i>
                                Doctor
                            </a>
                        <ul id="doctor" class="sidebar-dropdown accordion-collapse collapse list-unstyled" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#" onclick="changePage('add-doctor')">
                                    <i class="fa-solid fa-plus"></i>
                                    Add Doctor
                               </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#" onclick="changePage('view-doctor')">
                                    <i class="fa-solid fa-street-view"></i>
                                    View Doctor
                               </a>
                            </li>
                        </ul>
                    </li>
                    <!-- The importnat is the data-vbs-targer abd tge id ul -->
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#patient" data-bs-toggle="collapse" aria-expanded="false">
                            <i class="fa-solid fa-bed"></i>
                            Patient
                        </a>
                        <ul id="patient" class="sidebar-dropdown accordion-collapse collapse list-unstyled" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#" onclick="changePage('add-patient')">
                                    <i class="fa-solid fa-plus"></i>
                                    Add Patient
                               </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#" onclick="changePage('view-patient')">
                                    <i class="fa-solid fa-street-view"></i>
                                    View Patient
                               </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="main">
          
            <!-- Profile -->
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" type="button" id="sidebar-toggle">
                    <!-- toggle icon from bootsrap -->
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0" aria-expanded="false">
                                <i class="fa-solid fa-user avatar img-fluid rounded "></i>
                            </a>
                            <!-- dropdown menu end to make the dropdown inside -->
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                              </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-2" id="main-dashboard">
                <div class="container-fluid hidden dashactive">
                    <div class="mb-3">
                        <h4>Admin Dashboard</h4>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0 illustration">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-6">
                                            <div class="p-3 m-1">
                                                <h4>Welcome Back, Admin</h4>
                                                <p class="mb-0">Admin Dashboard, MEDICTECH</p>
                                            </div>
                                        </div>
                                        <div class="col-6 align-self-end text-end">
                                            <img src="https://img.freepik.com/premium-vector/man-working-computer-with-man-his-head-word-no-it_1113671-162.jpg" alt="Customer suppport illustration" class="img-fluid illustration-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body py-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-2">
                                                199
                                            </h4>
                                            <p class="mb-2">
                                                Total Patient
                                            </p>
                                            <div class="mb-0">
                                                <span class="badge text-success me-2">
                                                    +9.0%
                                                </span>
                                                <span class="text-muted">
                                                    Since Last Month
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <h3>Dashboard</h3>
                        <p>This is a shortcut dashboard for you</p>
                        <div class="row custom-row">
                            <div class="card custom-width bg-success text-white col-md-3 col-sm-6  mb-4">
                                <img src="img/doctor.png" class="card-img-top img-fluid" alt="doctor-icon">
                                <div class="card-body">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col">
                                            <h4 class="card-title">Doctor</h4>
                                        </div>
                                        <div class="col">
                                            <span class="ml-3">1</span>
                                        </div>
                                    </div>
                                    <button onclick="changePage('add-doctor')" class="btn btn-secondary my-2">Add Doctor</button>
                                    <button onclick="changePage('view-doctor')" class="btn btn-info">View Doctor</button>
                                </div>
                            </div>
                            <div class="card custom-width bg-dark text-white col-md-3 col-sm-6  mb-4">
                                <img src="img/patient.png" class="card-img-top img-fluid" alt="patient-icon">
                                <div class="card-body">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col">
                                            <h4 class="card-title">Patient</h4>
                                        </div>
                                        <div class="col">
                                            <span class="ml-3">1</span>
                                        </div>
                                    </div>
                                    
                                    <button onclick="changePage('add-patient')" class="btn btn-primary my-2">Add Patient</button>
                                    <button onclick="changePage('view-patient')" class="btn btn-primary">View Patient</button>
                                </div>
                            </div>
                   
                        </div>
                    </div>
                </div>
                <div class="hidden" id="add-doctor">
                    <div class="container my-3">
                        <div class="card">
                            <div class="card-header p-4">
                                <h4 class="mb-0">Add Doctor</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                                    <div class="mb-3">
                                        <label for="doctorname" class="form-label">Name</label>
                                        <input type="text" class="form-control"  name="doctorname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="doctorage" class="form-label">Age</label>
                                        <input type="number" class="form-control col-xs-3" name="doctorage">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label d-block">Sex</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="doctorgender" value="Male">
                                            <label class="form-check-label" for="doctormale">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="doctorgender"  value="Male">
                                            <label class="form-check-label" for="doctorfemale">Female</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="specialization" class="form-label">Specialization</label>
                                        <select class="form-control" name="specialization">
                                            <option value="" selected hidded>Select Specialization</option>
                                            <option value="Cardiologist">Cardiologist</option>
                                            <option value="Neurologist">Neurologist</option>
                                            <option value="Urologist">Urologist</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="doctorphone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" name="doctorphone">
                                    </div>
                                    <div class="mb-3">
                                        <label for="doctoremail" class="form-label">Email</label>
                                        <input type="email" class="form-control"  name="doctoremail">
                                    </div>
                                    <div class="mb-3">
                                        <label for="doctoraddress" class="form-label">Address</label>
                                        <input type="text" class="form-control"  name="doctoraddress">
                                    </div>
                                    <div class="mb-3">
                                        <label for="doctorpassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="doctorpassword">
                                    </div>
                                    <button type="submit" name="add-doctor" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden" id="view-doctor">
                    <!-- table  -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title mb-3">
                                Doctors
                            </h5>
                            <h6 class="card-subtitle text-muted mb-3">
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorum architecto voluptatum eaque, eum ipsam quibusdam et obcaecati corrupti magnam blanditiis expedita, minima molestiae tempora quasi voluptas sit numquam quis quia? Modi sed possimus blanditiis impedit, esse vitae, provident animi vel adipisci quibusdam, deserunt voluptate ipsam ullam. Velit dolore aliquid facilis.
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Doctor Name</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Specialization</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                
                                    if(mysqli_num_rows($doctors_result) > 0){

                                  
                                    while ($row = mysqli_fetch_assoc($doctors_result)) {
                                ?>
                                    <tr>
                                        <td class="doctor_id"><?php echo $row['id']?></td>
                                        <td><?php echo $row['name']?></td>
                                        <td><?php echo $row['age']?></td>
                                        <td><?php echo $row['phone']?></td>
                                        <td><?php echo $row['address']?></td>
                                        <td><?php echo $row['specialization']?></td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm view-data">View Data</a>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-success btn-sm edit-data">Edit Data</a>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-danger btn-sm delete-btn">Delete Data</a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }else{
                                    echo "<tr><td colspan='7'>No Doctors</td></tr>";
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="hidden" id="add-patient">
                    <div class="container my-3">
                        <div class="card">
                            <div class="card-header p-4">
                                <h4 class="mb-0">Add Patient</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                                    <div class="mb-3">
                                        <label for="patientname" class="form-label">Name</label>
                                        <input type="text" class="form-control"  name="patientname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="patientage" class="form-label">Age</label>
                                        <input type="number" class="form-control col-xs-3" name="patientage">
                                    </div>
                                    <div class="mb-3">
                                                <label class="form-label d-block">Sex</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" value="Male">
                                                    <label class="form-check-label" for="patientmale">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" value="Female">
                                                    <label class="form-check-label" for="patientfemale">Female</label>
                                                </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="patientphone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control"  name="patientphone">
                                    </div>
                                    <div class="mb-3">
                                        <label for="patientemail" class="form-label">Email</label>
                                        <input type="email" class="form-control"  name="patientemail">
                                    </div>
                                    <div class="mb-3">
                                        <label for="patientaddress" class="form-label">Address</label>
                                        <input type="text" class="form-control"  name="patientaddress">
                                    </div>
                                    <div class="mb-3">
                                        <label for="patientpassword" class="form-label">Password</label>
                                        <input type="password" class="form-control"  name="patientpassword">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="patient-submit">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden" id="view-patient">
                    <!-- table  -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title mb-3">
                                Basic Table
                            </h5>
                            <h6 class="card-subtitle text-muted mb-3">
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorum architecto voluptatum eaque, eum ipsam quibusdam et obcaecati corrupti magnam blanditiis expedita, minima molestiae tempora quasi voluptas sit numquam quis quia? Modi sed possimus blanditiis impedit, esse vitae, provident animi vel adipisci quibusdam, deserunt voluptate ipsam ullam. Velit dolore aliquid facilis.
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-dark">
                                  <tr>
                                  <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Patient Name</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                
                                if(mysqli_num_rows($patient_result) > 0){

                              
                                while ($row = mysqli_fetch_assoc($patient_result)) {
                                ?>
                                <tr>
                                    <td class="patient_id"><?php echo $row['id']?></td>
                                    <td><?php echo $row['name']?></td>
                                    <td><?php echo $row['age']?></td>
                                    <td><?php echo $row['phone']?></td>
                                    <td><?php echo $row['gender']?></td>
                                    <td><?php echo $row['address']?></td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm view-patient-data">View Data</a>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm edit-patient-data">Edit Data</a>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-danger btn-sm delete-patient-btn">Delete Data</a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }else{
                                    echo "<tr><td colspan='7'>No Patient</td></tr>";
                                }
                                ?>

                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="" class="text-muted">
                                    <strong>MEDICTECH</strong>
                                </a>
                            </p>
                        </div>
                        <div class="col6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Contact</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">About Us</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Terms</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
     <!-- Bootstrap JS -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    
    <!-- Jquery -->
    <script>
        // view data
        $(document).ready(function(){
            $('.view-data').click(function(e){
                e.preventDefault();
                // console.log('hello');

                var user_id = $(this).closest('tr').find('.doctor_id').text();
                // console.log(user_id);

                $.ajax({
                    method:"Post",
                    url:'code.php',
                    data:{
                        'click_view_btn':true,
                        'user_id': user_id,
                    },
                    success: function(response){
                        $('.view_user_data').html(response);
                        $('#viewusermdoal').modal('show');
                    }
                })

            })
            //edit
            $('.edit-data').click(function(e){
                e.preventDefault();

                var user_id = $(this).closest('tr').find('.doctor_id').text();
                // console.log(user_id)
                $.ajax({
                    method:"Post",
                    url:"code.php",
                    data:{
                        'click_edit_btn':true,
                        'user_id': user_id,
                    },
                    success: function(response){
                        $.each(response, function(key, value){
                            $('#user_id').val(value['id']);
                            $('#doctorname').val(value['name']);
                            $('#doctorage').val(value['age']);
                            $('#specialization').val(value['specialization']);
                            $('#doctorphone').val(value['phone']);
                            $('#doctoremail').val(value['email']);
                            $('#doctoraddress').val(value['address']);
                            $('#doctorpassword').val(value['password']);

                            // Set gender radio button value based on the response
                            if (value['gender'] === 'female') {
                                $('#doctorfemale').prop('checked', true);
                            } else {
                                $('#doctormale').prop('checked', true);
                            }
                        });

                        $('#edit-user').modal('show');

                    }
                });
            });

           //delte
           $('.delete-btn').click(function(e){
                 e.preventDefault();

                var user_id = $(this).closest('tr').find('.doctor_id').text();
                    
                $.ajax({
                    method: "Post",
                    url: "code.php",
                    data: {
                    'click_delete_button':true,
                    'user_id':user_id,
                    },
                    success: function (response){
                        console.log(response);
                        window.location.reload();
  
                    }
                })
            })

            // Patient
            $('.view-patient-data').click(function(e){
                    e.preventDefault();
                    // console.log('hello');

                    var patient_id = $(this).closest('tr').find('.patient_id').text();
                    console.log(patient_id);

                    $.ajax({
                        method:"Post",
                        url:'code.php',
                        data:{
                            'click_patient_view_btn':true,
                            'patient_id': patient_id,
                        },
                        success: function(response){
                            $('.view_patient_data').html(response);
                            $('#viewpatientmodal').modal('show');
                        }
                    })

            })
            
            //edit
            $('.edit-patient-data').click(function(e){
                e.preventDefault();
                var patient_id = $(this).closest('tr').find('.patient_id').text();
            $.ajax({
                method:"Post",
                url:"code.php",
                data:{
                    'click_patient_edit_btn':true,
                    'patient_id': patient_id,
                },
                success: function(response){
                    $.each(response, function(key, value){
                        $('#patient_id').val(value['id']);
                            $('#patientname').val(value['name']);
                            $('#patientage').val(value['age']);
                            $('#patientphone').val(value['phone']);
                            $('#patientemail').val(value['email']);
                            $('#patientaddress').val(value['address']);
                            $('#patientpassword').val(value['password']);

                            // Set gender radio button value based on the response
                            if (value['gender'] === 'female') {
                                $('#patientfemale').prop('checked', true);
                            } else {
                                $('#patientmale').prop('checked', true);
                            }
                    });

                    $('#editpatient').modal('show');

                }
            });
        });

        // delete
         //delte
         $('.delete-patient-btn').click(function(e){
                 e.preventDefault();

                var patient_id = $(this).closest('tr').find('.patient_id').text();
                console.log(patient_id)
                $.ajax({
                    method: "Post",
                    url: "code.php",
                    data: {
                    'click_patient_delete_button':true,
                    'patient_id':patient_id,
                    },
                    success: function (response){
                        console.log(response);
                        window.location.reload();
  
                    }
                })
            })

        });

               
        
    </script>
</body>
</html>