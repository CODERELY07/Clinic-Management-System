<?php
    session_start();

    // if(!isset($_SESSION['patient_id'])){
    //     header("Location:login.php");
    //     exit();
    // }

    require_once 'connection/connection.php';
    $alertMessage='';



    
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
    <title>Patient-dashboard</title>
    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div style="position:absolute;top:0;left:0;width:100%;z-index:99" class="text-center">
        <?php echo $alertMessage; ?>
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
                        <h4>Patient Dashboard</h4>
                    </div>
                    <!-- <div class="container">
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
                    </div> -->
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
        
    </script>
</body>
</html>