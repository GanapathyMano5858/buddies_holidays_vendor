<?php
require_once('./models/DashboardModel.php');
class DashboardController{
	private $model;
	public function __construct($model)
	{
		$this->model=$model;
	}
	public function GetCount(){
		$response=$this->model->GetCount();
		 require('./views/dashboard.php');
	}
}
?>