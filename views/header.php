<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
error_reporting(0);
session_start();
if (empty($_SESSION)) {
  session_destroy();
  header('Location: index.php');
}
define('_ROOT_DIRECTORY_', 'http://localhost/buddies_holidays_vendor/');
// define('_ROOT_DIRECTORY_', 'https://vendor.buddiesholidays.in/');
define('_ASSETS_DIR_', _ROOT_DIRECTORY_ . 'assets/');
?>
<!DOCTYPE html>

<head>
  <title>Buddies Holidays</title>
  <link rel="icon" type="image/x-icon" href="<?php echo _ASSETS_DIR_; ?>favicon.png" />
  <link rel="stylesheet" type="text/css" href="<?php echo _ASSETS_DIR_; ?>css/style.css" />
  <link rel="stylesheet" href="<?php echo _ASSETS_DIR_; ?>css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo _ASSETS_DIR_; ?>css/jquery-confirm.min.css">
  <link rel="stylesheet" href="<?php echo _ASSETS_DIR_; ?>css/jquery.dataTables.css" />
  <link rel="stylesheet" href="<?php echo _ASSETS_DIR_; ?>css/jquery-ui.css">


  <head>
  </head>
</head>
<header>
  <nav class="navbar navbar-expand-lg">
    <div class="container-lg">
      <a class="navbar-brand" style="width: 200px" href="<?php echo _ROOT_DIRECTORY_; ?>views/dashboard.php">
        <img src="<?php echo _ASSETS_DIR_; ?>buddies_holidays_logo.png" alt="" class="logo w-100" />
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="offcanvas offcanvas-end text-bg-dark bg-light" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="<?php echo _ROOT_DIRECTORY_; ?>views/dashboard.php" style="color: black;">Home</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Transport
              </a>
              <ul class="dropdown-menu bg-light ">
                <li>
                  <a class="dropdown-item" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=get-vehicleList">Add Vehicle</a>
                </li>
                <!-- <hr class="dropdown-divider" /> -->
                <li>
                  <a class="dropdown-item" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=get-driverList">Add Driver</a>
                </li>
                <!-- <hr class="dropdown-divider" /> -->
                <li>
                  <a class="dropdown-item" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=vehicle-allotment">Vehicle Allotment</a>
                </li>
                <!-- <hr class="dropdown-divider" /> -->
                <li>
                  <a class="dropdown-item" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=add-purchase-bill">Add Purchase Bill</a>
                </li>
              </ul>
            </li>

            <!--<li class="nav-item dropdown">-->
            <!--  <a-->
            <!--    class="nav-link dropdown-toggle"-->
            <!--    href="#"-->
            <!--    role="button"-->
            <!--    data-bs-toggle="dropdown"-->
            <!--    aria-expanded="false"-->
            <!--  >-->
            <!--    Report-->
            <!--  </a>-->
            <!--  <ul class="dropdown-menu bg-danger-subtle">-->
            <!--    <li>-->
            <!--      <a class="dropdown-item" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=outstanding-report"-->
            <!--        >Transporter Outstanding Report</a-->
            <!--      >-->
            <!--    </li>-->
            <!-- <hr class="dropdown-divider" /> -->
            <!--    <li>-->
            <!--      <a class="dropdown-item" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=tripadvance-report">Trip Advance Report</a>-->
            <!--    </li>-->
            <!-- <hr class="dropdown-divider" /> -->
            <!--    <li>-->
            <!--      <a class="dropdown-item" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=billdetails-report">Bill Details Report</a>-->
            <!--    </li>-->
            <!--  </ul>-->
            <!--</li>-->

            <li class="nav-item dropdown">

              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo $_SESSION['firstname']; ?>&nbsp;&nbsp;
                <img src="<?php echo _ASSETS_DIR_; ?>profile_Icon.svg" alt="ProfileIcon" style="width: 25px;" /></a>

              <ul class="dropdown-menu bg-danger-subtle">
                <li>
                  <a class="dropdown-item" href=<?php echo _ROOT_DIRECTORY_ . 'index.php?action=get-profile&&id=' . $_SESSION['user_id']; ?>>My Account</a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?php echo _ROOT_DIRECTORY_ . 'index.php?action=logout'; ?>">Log Out</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>


<!-- Include jQuery -->
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>js/jquery-3.7.1.min.js"></script>

<!-- Include jQuery UI (if needed) -->
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>js/jquery-ui.js"></script>

<!-- Include Bootstrap JS -->
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>js/bootstrap.bundle.min.js"></script>

<!-- Include jQuery Confirm JS -->
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>js/jquery-confirm.min.js"></script>

<!-- Include DataTables JS -->
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>js/jquery.sieve.min.js"></script>



<!-- Include DataTables Buttons JS (if needed) -->
<script type="text/javascript" charset="utf8" src="<?php echo _ASSETS_DIR_; ?>js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo _ASSETS_DIR_; ?>js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo _ASSETS_DIR_; ?>js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>js/fontawesome.js" crossorigin="anonymous"></script>

<!-- Include Fancybox CSS -->
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>fancybox/jquery.fancybox.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo _ASSETS_DIR_; ?>fancybox/jquery.fancybox.css" />

<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>viewerjs/viewer.min.js"></script>
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>viewerjs/jquery-viewer.min.js"></script>

<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>viewerjs/custom-viewer.js"></script>


<link rel="stylesheet" type="text/css" href="<?php echo _ASSETS_DIR_; ?>viewerjs/viewer.min.css" />

<!-- Include Your Custom Scripts -->
<script type="text/javascript" src="<?php echo _ASSETS_DIR_; ?>js/script.js"></script>