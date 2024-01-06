<?php
class DashboardModel{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo=$pdo;
	}
	public function GetCount(){

	$unalloted_vehicle_vendors=$this->pdo->prepare("SELECT count(cc.id_client) as count from ps_client cc  left join ps_vehicle_allotment v on (v.client_table_id=cc.id_client) where cc.start_from between '" .date("Y-m-d") ."' and '" .date("Y-m-d", strtotime("+1 month"))."' and cc.status=0 and  cc.transporter_id=".$_SESSION['trans_vendor_id']." and (v.va_driver_id='' and v.va_vehicle_id='' and cc.cancel_status!=1 and cc.arrivedornot!=1) or cc.status_datechanged=1 and cc.status_datechanged!=1 and v.trip_went_not!=2 group by cc.status");

	$unalloted_vehicle_vendors->execute();
	$unalloted_vehicle_vendors=$unalloted_vehicle_vendors->fetch(PDO::FETCH_ASSOC);

	$unpaid_bill_vendors=$this->pdo->prepare("SELECT count(ve.va_id)as count  from ps_client cc left join  ps_vehicle_allotment as ve on (cc.id_client=ve.client_table_id)  where cc.status=0 and cc.cancel_status=0 and cc.arrivedornot=0 and cc.end_to <= CURDATE() and (ve.purchaserate_added_date!='0000-00-00 00:00:00' and ve.paid_status_bill_allotment=0) and va_transporter_id=".$_SESSION['trans_vendor_id']." GROUP BY ve.va_transporter_id");
	$unpaid_bill_vendors->execute();
	$unpaid_bill_vendors=$unpaid_bill_vendors->fetch(PDO::FETCH_ASSOC);

	$unsubmitted_bill_vendors=$this->pdo->prepare("SELECT count(ve.va_id)as count  from  ps_vehicle_allotment as ve left join  ps_client cc on (ve.client_table_id=cc.id_client)left join  ps_trip_advance as tr on (tr.id_tripadvance=(select yy.id_tripadvance from ps_trip_advance yy where cc.id_client =yy.client_id and ve.va_id =yy.ta_va_id  and (yy.paid_status=2 ||yy.individual_paid_status=1) GROUP BY yy.ta_va_id))   where cc.status=0 and cc.cancel_status=0 and cc.end_to <CURDATE() and (ve.purchaserate_added_date LIKE '%0000-00-00 00:00:00%'||(ve.status=1 and ve.purchaserate_added_date!='0000-00-00 00:00:00')) and ve.va_transporter_id=".$_SESSION['trans_vendor_id']." and (ve.trip_went_not!=2 || tr.tripadvance_paid!=0) and cc.transporter_id!='' and ve.va_driver_id!=0 and ve.va_vehicle_id!=0 GROUP BY ve.va_transporter_id");

	$unsubmitted_bill_vendors->execute();
	$unsubmitted_bill_vendors=$unsubmitted_bill_vendors->fetch(PDO::FETCH_ASSOC);
	return [
		'unalloted_vehicle_vendors'=>($unalloted_vehicle_vendors)? $unalloted_vehicle_vendors['count']:0,
		'unpaid_bill_vendors'=>($unpaid_bill_vendors)? $unpaid_bill_vendors['count']: 0,
		'unsubmitted_bill_vendors'=>($unsubmitted_bill_vendors)? $unsubmitted_bill_vendors['count']: 0

	];

	  }
}

?>
