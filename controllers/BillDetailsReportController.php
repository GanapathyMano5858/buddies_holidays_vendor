<?php
require_once('./models/BillDetailsReportModel.php');
class BillDetailsReportController{
	private $model;
	public function __construct($model)
	{
		$this->model=$model;
	}
	public function BilldetailsReport(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->BilldetailsReport($GetDatas);
		 require('./views/billDetailsReport.php');
	}
	public function ShowDetailsBill(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->ShowDetailsBill($GetDatas);
	
	}

}
?>