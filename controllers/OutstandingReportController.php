<?php
require_once('./models/OutstandingReportModel.php');
class OutstandingReportController{
	private $model;
	public function __construct($model)
	{
		$this->model=$model;
	}
	public function OutstandingReport(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->OutstandingReport($GetDatas);
		 require('./views/transporterOutstandingReport.php');
	}
		

}
?>