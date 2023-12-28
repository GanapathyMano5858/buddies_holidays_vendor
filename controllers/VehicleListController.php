<?php
require_once('./models/VehicleListModel.php');
class VehicleListController{
	private $model;
	public function __construct($model)
	{
		$this->model=$model;
	}
	public function getVehicleList(){
		$response=$this->model->getVehicleList();
		 require('./views/addVehicleList.php');
	}
	public function addVehicle(){

		$response=$this->model->addVehicle((isset($_GET['v_id'])&&$_GET['v_id']? $_GET['v_id']:""));
		require ('./views/addNewVehicle.php');
	}
	public function saveVehicle(){
		 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		 	$GetDatas=$_POST;
		 	$response=$this->model->saveVehicle($GetDatas);
		 	 if($response){
               header('Location:./index.php?action=get-vehicleList&&success=Added successful');
               exit;
            }
            else{
               header('Location:./index.php?action=get-vehicleList&&error=Error in Add ...Pls try again later');
               exit;
            }
		 }
	}
	public function updateVehicle(){
		 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		 	$GetDatas=$_POST;
		 	$response=$this->model->updateVehicle($GetDatas);
		 	 if($response){
               header('Location:./index.php?action=get-vehicleList&&success=Update successful');
               exit;
            }
            else{
               header('Location:./index.php?action=get-vehicleList&&error=Error in Update ...Pls try again later');
               exit;
            }
		 }
	}
	public function CheckalreadyVehicle(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		 	$GetDatas=$_POST;
		 	$response=$this->model->CheckalreadyVehicle($GetDatas);
		 	echo $response;
		 	exit;
		 }

	}
	
}
?>