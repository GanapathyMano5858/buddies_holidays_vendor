<?php
require_once('./models/VehicleAllotmentModel.php');
class VehicleAllotmentController{
	private $model;
	public function __construct($model)
	{
		$this->model=$model;
	}
	public function vehicleAllotment(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->vehicleAllotment($GetDatas);
		 require('./views/vehicleAllotment.php');
	}
	public function allotment(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->allotment($GetDatas);
	
	}
	public function Allotmentvehicle(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->Allotmentvehicle($GetDatas);
	
	}
	public function ShowClientDetails(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->ShowClientDetails($GetDatas);
	
	}
}
?>