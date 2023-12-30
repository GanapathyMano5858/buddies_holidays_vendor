<?php
require_once('./models/TripAdvanceReportModel.php');
class TripAdvanceReportController{
	private $model;
	public function __construct($model)
	{
		$this->model=$model;
	}
	public function TripadvanceReport(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->TripadvanceReport($GetDatas);
		 require('./views/tripAdvanceReport.php');
	}
		public function ViewDetailsTripadvance(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->ViewDetails($GetDatas);
		
	}
	public function ShowClientTrip(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->ShowClientDetails($GetDatas);
	}
	

}
?>