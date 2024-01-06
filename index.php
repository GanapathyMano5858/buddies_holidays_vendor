<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('config.php');
require_once('db.php');
require_once 'session_timeout.php';
require_once('models/EmployeeModel.php');
require_once('models/DashboardModel.php');
require_once('models/VehicleListModel.php');
require_once('models/DriverListModel.php');
require_once('models/VehicleAllotmentModel.php');
require_once('models/AddPurchaseModel.php');
require_once('models/OutstandingReportModel.php');
require_once('models/TripAdvanceReportModel.php');
require_once('models/BillDetailsReportModel.php');
require_once('controllers/AuthController.php');
require_once('controllers/DashboardController.php');
require_once('controllers/VehicleListController.php');
require_once('controllers/DriverListController.php');
require_once('controllers/VehicleAllotmentController.php');
require_once('controllers/AddPurchaseController.php');
require_once('controllers/OutstandingReportController.php');
require_once('controllers/TripAdvanceReportController.php');
require_once('controllers/BillDetailsReportController.php');

$employeeModel = new EmployeeModel($pdo);
$authController = new AuthController($employeeModel);
$DashboardModel = new DashboardModel($pdo);
$DashboardController = new DashboardController($DashboardModel);
$vehicleListModel= new vehicleListModel($pdo);
$vehicleListController=new vehicleListController($vehicleListModel);
$driverListModel= new driverListModel($pdo);
$driverListController=new driverListController($driverListModel);

$vehicleAllotmentModel= new vehicleAllotmentModel($pdo);
$vehicleAllotmentController=new vehicleAllotmentController($vehicleAllotmentModel);
$addPurchaseModel= new addPurchaseModel($pdo);
$addPurchaseController=new addPurchaseController($addPurchaseModel);
$OutstandingModel= new OutstandingReportModel($pdo);
$OutstandingController=new OutstandingReportController($OutstandingModel);
    $TripadvanceModel= new TripadvanceReportModel($pdo);
$TripadvanceController=new TripadvanceReportController($TripadvanceModel);
    $BilldetailsModel= new BilldetailsReportModel($pdo);
$BilldetailsController=new BilldetailsReportController($BilldetailsModel);
if(isset($_SESSION['user_id'])){
  $sessionManager = new SessionManager($pdo);
  $userId = $_SESSION['user_id'];
  $sessionTimeout = ini_get('session.gc_maxlifetime');

  setcookie('last_activity', time(), time() + $sessionTimeout+1800, '/');

 if (isset($_COOKIE['last_activity'])) {
    $lastActivityTimestamp = $_COOKIE['last_activity'];
    $maxLifetime = ini_get('session.gc_maxlifetime');
    if (time() - $lastActivityTimestamp > $maxLifetime) {
        $sessionManager->insertSessionInfo($userId);
        if($sessionManager){
            session_destroy();
            setcookie('last_activity', '', time() - 3600, '/');
            header('Location: ./views/login.php');
            exit;  
        }
        
        
    }
}  
}
$action ='';
// Route based on the action parameter
if(isset($_GET['action'])&&$_GET['action']=='login'){
    $action =$_GET['action'];
}
elseif(isset($_GET['action'])&&isset($_SESSION['trans_vendor_id'])){
    $action =  $_GET['action'];
}
elseif(!isset($_SESSION['trans_vendor_id'])){
    header('Location: ./views/login.php');
    exit;
}


switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'forgot-password':
        $authController->forgot_password();
        break;
    case 'get-profile':
        $authController->getProfile();
        break;
    case 'update-profile':
        $authController->updateProfile();
        break;
    case 'GetCount':
        $DashboardController->GetCount();
        break;
    case 'get-vehicleList':
        $vehicleListController->getVehicleList();
         break;
    case 'addVehicle':
        $vehicleListController->addVehicle();
         break;
    case 'addVehicle-submit':
        $vehicleListController->saveVehicle();
         break;
    case 'addVehicle-update':
        $vehicleListController->updateVehicle();
         break;
    case 'CheckalreadyVehicle':
        $vehicleListController->CheckalreadyVehicle();
         break;
         case 'get-driverList':
        $driverListController->getDriverList();
         break;
    case 'addDriver':
        $driverListController->addDriver();
         break;
    case 'addDriver-submit':
        $driverListController->saveDriver();
         break;
    case 'addDriver-update':
    $driverListController->updateDriver();
         break;
    case 'CheckalreadyDriver':
    $driverListController->CheckalreadyDriver();
         break;
     case 'viewdriver':
     $driverListController->viewDriver();
     break;
      case 'vehicle-allotment':
     $vehicleAllotmentController->vehicleAllotment();
     break;
    case 'allotment':
     $vehicleAllotmentController->allotment();
     break;
     case 'Allotmentvehicle':
     $vehicleAllotmentController->Allotmentvehicle();
     break;
      case 'ShowClientDetails':
     $vehicleAllotmentController->ShowClientDetails();
     break;
      case 'add-purchase-bill':
     $addPurchaseController->addPurchaseBill();
     break;
      case 'PurchaseRateAdd':
     $addPurchaseController->PurchaseRateAdd();
     break;
     case 'outstanding-report':
     $OutstandingController->OutstandingReport();
     break;
     //  case 'ShowClientOut':
     // $OutstandingController->ShowClientOut();
     // break;
     case 'tripadvance-report':
     $TripadvanceController->TripadvanceReport();
     break;
      case 'ShowClientTrip':
     $TripadvanceController->ShowClientTrip();
     break;
      case 'ViewDetailsAdvance':
     $TripadvanceController->ViewDetailsTripadvance();
     break;
     case 'billdetails-report':
     $BilldetailsController->BilldetailsReport();
     break;
      case 'ShowClientBill':
     $BilldetailsController->ShowClientBill();
     break;
    default:
        // Redirect to login by default
        header('Location: ./views/login.php');
        exit;
}
?>
