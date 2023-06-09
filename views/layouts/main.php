<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Simple Hospital </title>

  <link href="../css/styles2.css" rel="stylesheet" />
  <link href="../css/styles.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


  <!-- link sweetalert2 -->



  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/styles.css" rel="stylesheet" />
</head>


<body>
  <div class="d-flex" id="wrapper">
    <!-- Sidebar-->
    <div class="border-end bg-white" id="sidebar-wrapper">
      <div class="sidebar-heading border-bottom bg-dark text-light">Start Menu</div>
      <div class="list-group list-group-flush">
        <!-- <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
          Panel
        </button>
        <ul class="dropdown-menu ">
          <li><a class="dropdown-item" href="/Dashboard/Management">Management</a></li>
          <li><a class="dropdown-item" href="/Dashboard/Doctor">Doctor</a></li>
          <li><a class="dropdown-item" href="/dashboard/patient">patient</a></li>
        </ul> -->
        <a class=" list-group-item list-group-item-action list-group-item-secondary p-3" href="/home">home</a>
        <a class=" list-group-item list-group-item-action list-group-item-light p-3" href="/Dashboard/Management">Management</a>
        <a class=" list-group-item list-group-item-action list-group-item-secondary p-3" href="/Dashboard/Doctor">Doctor</a>
        <a class=" list-group-item list-group-item-action list-group-item-light p-3" href="/dashboard/patient">patient</a>
        <a class="list-group-item list-group-item-action list-group-item-secondary p-3" href="/DoctorList">Doctor list</a>
      </div>
    </div>
    <!-- Page content wrapper-->
    <div id="page-content-wrapper">
      <!-- Top navigation-->
      <nav class="navbar navbar-expand-lg navbar-light bg-dark border-bottom">
        <div class="container-fluid">
          <button class="btn btn-light" id="sidebarToggle">Menu</button>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse text-light" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
              <?php
              if (isset($_SESSION['id'])) {
              ?>
                <li class="nav-item dropdown">
                  <p href="" class="dropdown-toggle " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION['email'];
                    //echo $data[0]['firstName'] . '  ' . $data[0]['lastName'];  ?>
                  </p>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="/logout">logout</a></li>
                  </ul>
                </li>
              <?php
              } else { ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile</a>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/login">Login</a>
                    <a class="dropdown-item" href="/register">Register</a>
                  </div>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </nav>

      <!-- Page content-->
      <div class="container-fluid">
        {{content}}
      </div>
    </div>
  </div>

  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="../../js/scripts.js"></script>
  <!-- <script src="../../js/scripts2.js"></script> -->

</body>


</html>