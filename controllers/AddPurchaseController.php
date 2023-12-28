<?php
require_once('./models/AddPurchaseModel.php');
class AddPurchaseController{
	private $model;
	public function __construct($model)
	{
		$this->model=$model;
	}
	public function addPurchaseBill(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->addPurchaseBill($GetDatas);
		 require('./views/addPurchaseBill.php');
	}
	public function PurchaseRateAdd(){
		$GetDatas=[];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$GetDatas=$_POST;
		}
		$response=$this->model->PurchaseRateAdd($GetDatas);
		
	}
}
?>