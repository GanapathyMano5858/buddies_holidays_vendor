<?php
require_once('./models/DriverListModel.php');
class DriverListController{
	private $model;
	public function __construct($model)
	{
		$this->model=$model;
	}
	public function getDriverList(){
		$response=$this->model->getDriverList();
		 require('./views/addDriverList.php');
	}
	public function addDriver(){

		$response=$this->model->addDriver((isset($_GET['id_driver'])&&$_GET['id_driver']? $_GET['id_driver']:""));
		require ('./views/addNewDriver.php');
	}
	public function saveDriver(){
		 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		 	$GetDatas=$_POST;
		 	$response=$this->model->saveDriver($GetDatas);
		 	 if($response){
               header('Location:./index.php?action=get-driverList&&success=Added successful');
               exit;
            }
            else{
               header('Location:./index.php?action=get-driverList&&error=Error in Add ...Pls try again later');
               exit;
            }
		 }
	}
	public function updateDriver(){
		 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		 	$GetDatas=$_POST;
		 	$response=$this->model->updateDriver($GetDatas);
		 	 if($response){
               header('Location:./index.php?action=get-driverList&&success=Update successful');
               exit;
            }
            else{
               header('Location:./index.php?action=get-driverList&&error=Error in Update ...Pls try again later');
               exit;
            }
		 }
	}
	public function CheckalreadyDriver(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		 	$GetDatas=$_POST;
		 	$response=$this->model->CheckalreadyDriver($GetDatas);
		 	echo $response;
		 	exit;
		 }

	}
	public function viewDriver()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$GetDatas=$_POST;
		$response=$this->model->viewDriver($GetDatas);
		echo $response;
		exit;
		}
	}
	
}
?>