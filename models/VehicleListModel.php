<?php
class VehicleListModel{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo=$pdo;
	}
	public function getVehicleList() {
		$vehicleList =$this->pdo->prepare('SELECT ps_vehicles.*,ps_vehicletypes.vehicle_category,ps_vehicletypes.vehicle_type_name,ps_vehicles.status as vehicle_status,ps_vehicletypes.vehicle_type_name as vehicle_name,ps_vehicles.blocked as vehicle_blocked FROM ps_vehicles  LEFT JOIN ps_transporter ON ps_transporter.t_id=ps_vehicles.transporter_id left join ps_vehicletypes on ps_vehicletypes.vt_id=ps_vehicles.vehicle_type where ps_transporter.t_id='.$_SESSION['trans_vendor_id'].'
			 and ps_vehicles.status !=1  ORDER BY ps_vehicles.v_id DESC');
		$vehicleList->execute();

		$CheckvehiclecountForOwnCome = $this->pdo->prepare('SELECT count(ps_vehicles.v_id) as count FROM ps_vehicles  LEFT JOIN ps_transporter ON ps_transporter.t_id=ps_vehicles.transporter_id  where ps_transporter.t_id='.$_SESSION['trans_vendor_id'].'  and ps_transporter.trans_vendors=0 and ps_vehicles.status not in (1,3,6)');
			$CheckvehiclecountForOwnCome->execute();
			return array(
				'vehicleList'=>$vehicleList->fetchAll(PDO::FETCH_ASSOC),
				'CheckvehiclecountForOwnCome'=>$CheckvehiclecountForOwnCome->fetch(PDO::FETCH_ASSOC)
			);
			
    }
    public function addVehicle($v_id=false){
        $vehicleList=[];
        $vehicleType= $this->pdo->prepare('select vt_id,vehicle_type_name from ps_vehicletypes where status=0 order by vehicle_type_name asc');
        $vehicleType->execute();
        if($v_id){
            $vehicleList =$this->pdo->prepare('SELECT ps_vehicles.*,ps_vehicletypes.vehicle_type_name,ps_vehicletypes.vehicle_type_name as vehicle_name FROM ps_vehicles  LEFT JOIN ps_transporter ON ps_transporter.t_id=ps_vehicles.transporter_id left join ps_vehicletypes on ps_vehicletypes.vt_id=ps_vehicles.vehicle_type where ps_vehicles.v_id='.$v_id);
            $vehicleList->execute();  
            $vehicleList= $vehicleList->fetch(PDO::FETCH_ASSOC);
        }
      
        return array(
            'vehicleType'=>$vehicleType->fetchAll(PDO::FETCH_ASSOC),
            'vehicleList'=>$vehicleList
        );
    }
    public function saveVehicle($GetDatas){
        $query="INSERT INTO ps_vehicles (transporter_id,vehicle_type,vehicle_no,vehicle_year,create_date,status,id_employee,tab_id) VALUES (:transporter_id,:vehicle_type,:vehicle_no,:vehicle_year,:create_date,:status,:id_employee,:tab_id)";

        $stmt = $this->pdo->prepare($query);
        $todayDateTime=date('Y-m-d H:i:s');
        $status=3;
        $tab_id=256;
        $vehicle_no=$GetDatas['vehicle_no'].' '.$GetDatas['vehicle_no2'].' '.$GetDatas['vehicle_no3'].' '.$GetDatas['vehicle_no4'];
        $stmt->bindParam(':transporter_id', $_SESSION['trans_vendor_id']);
        $stmt->bindParam(':vehicle_type', $GetDatas['vehicle_type']);
        $stmt->bindParam(':vehicle_no', $vehicle_no);
        $stmt->bindParam(':vehicle_year', $GetDatas['vehicle_year']);
        $stmt->bindParam(':create_date', $todayDateTime);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id_employee', $_SESSION['user_id']);
        $stmt->bindParam(':tab_id', $tab_id);
        
        $stmt->execute();
        $lastInsertId = $this->pdo->lastInsertId();
        $query2="INSERT INTO ps_vehicles_history (transporter_id,vehicle_type,vehicle_no,vehicle_year,create_date,id_history) VALUES (:transporter_id,:vehicle_type,:vehicle_no,:vehicle_year,:create_date,:id_history)";

        $stmt2 = $this->pdo->prepare($query2);
        $stmt2->bindParam(':transporter_id', $_SESSION['trans_vendor_id']);
        $stmt2->bindParam(':vehicle_type', $GetDatas['vehicle_type']);
        $stmt2->bindParam(':vehicle_no', $GetDatas['vehicle_no']);
        $stmt2->bindParam(':vehicle_year', $GetDatas['vehicle_year']);
        $stmt2->bindParam(':create_date', $todayDateTime);
        $stmt2->bindParam(':id_history', $lastInsertId);
        $stmt2->execute();

             $select_trans_manager = $this->pdo->prepare('select a.id_employee from ps_employee as a left join ps_privilege as b on (a.pri_id=b.pri_id and b.status=0)  where a.active=1 and b.clientbranchmanager=1');
             $select_trans_manager->execute();
             $row=$select_trans_manager->fetchAll(PDO::FETCH_ASSOC);

           foreach ($row as $key_manager => $value_manager) {
                    $pri=$city_list=$privilege_query_noti='';
                    $all_city_list=$city_list=[];
            
                $privilege_query_noti=$this->pdo->prepare('select a.*,b.*,city.id_city as all_cities from ps_employee as a left join ps_privilege as b on (a.pri_id=b.pri_id and b.status=0) left join ps_city as city on (FIND_IN_SET(city.id_state,a.all_city_in_state)) where a.active=1 and a.id_employee='.$value_manager['id_employee'].'');
                $privilege_query_noti->execute();
                $row2=$privilege_query_noti->fetchAll(PDO::FETCH_ASSOC);

                $city_list=explode(',', $row2[0]['city']);
                foreach ($row2 as $keyssss => $valuess) {
                $all_city_list[]=$valuess['all_cities'];

                }
                foreach($all_city_list as $key_cityy=>$value_cityy){
                if(!in_array($value_cityy, $city_list)){
                $city_list[]=$value_cityy;
                }
                }
                $pri=implode('|', array_filter($city_list));
                $emp=$this->pdo->prepare('select ps_employee.id_employee from ps_employee left join ps_access on (ps_employee.id_profile=ps_access.id_profile) left join ps_vehicles on (ps_vehicles.v_id='.$lastInsertId.') left join ps_transporter t on (t.t_id=ps_vehicles.transporter_id) where CONCAT(",", t.dest_name, ",") REGEXP ",('.$pri.')," and ps_access.id_tab=256 and ps_access.edit=1 and ps_employee.active=1 and ps_employee.id_employee='.$value_manager['id_employee']);
                $emp->execute();
                $row3=$emp->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($row3 as $key => $employee_id) {
                    $query3="INSERT INTO ps_notification (table_id,menu_name,controller_link,sent_time,sender,inserted_datetime,receiver,type,message) VALUES (:table_id,:menu_name,:controller_link,:sent_time,:sender,:inserted_datetime,:receiver,:type,:message)";
                    $type=1;
                    $controller_link='AdminAddvehicle';
                    $menu_name='Add Vehicle';
                    $message='Vehicle Active Request from '.$_SESSION['firstname'];
                    $stmt3 = $this->pdo->prepare($query3);
                    $stmt3->bindParam(':table_id', $lastInsertId);
                    $stmt3->bindParam(':menu_name', $menu_name);
                    $stmt3->bindParam(':controller_link', $controller_link);
                    $stmt3->bindParam(':sent_time', $todayDateTime);
                    $stmt3->bindParam(':sender', $_SESSION['user_id']);
                    $stmt3->bindParam(':inserted_datetime', $todayDateTime);
                    $stmt3->bindParam(':receiver', $employee_id['id_employee']);
                    $stmt3->bindParam(':type', $type);
                    $stmt3->bindParam(':message', $message);
                    $stmt3->execute();

            }
                
         
           }
          return $lastInsertId;
            
            
    }
    public function updateVehicle($GetDatas){
    $query = "UPDATE ps_vehicles SET transporter_id = :transporter_id, vehicle_type = :vehicle_type, vehicle_no=:vehicle_no, vehicle_year=:vehicle_year, updated_date=:updated_date, status=:status,id_employee=:id_employee,tab_id=:tab_id WHERE v_id = :v_id";
        $status=4;
        $tab_id=256;
        $vehicle_no=$GetDatas['vehicle_no'].' '.$GetDatas['vehicle_no2'].' '.$GetDatas['vehicle_no3'].' '.$GetDatas['vehicle_no4'];
        $todayDateTime=date('Y-m-d H:i:s');
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':transporter_id', $_SESSION['trans_vendor_id']);
        $stmt->bindParam(':vehicle_type', $GetDatas['vehicle_type']);
        $stmt->bindParam(':vehicle_no', $vehicle_no);
        $stmt->bindParam(':vehicle_year', $GetDatas['vehicle_year']);
        $stmt->bindParam(':updated_date', $todayDateTime);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id_employee', $_SESSION['user_id']);
        $stmt->bindParam(':tab_id', $tab_id);
        $stmt->bindParam(':v_id', $GetDatas['v_id']);
        
        $stmt->execute();
        $query2="INSERT INTO ps_vehicles_history (transporter_id,vehicle_type,vehicle_no,vehicle_year,updated_date,id_history) VALUES (:transporter_id,:vehicle_type,:vehicle_no,:vehicle_year,:updated_date,:id_history)";

        $stmt2 = $this->pdo->prepare($query2);
        $stmt2->bindParam(':transporter_id', $_SESSION['trans_vendor_id']);
        $stmt2->bindParam(':vehicle_type', $GetDatas['vehicle_type']);
        $stmt2->bindParam(':vehicle_no', $GetDatas['vehicle_no']);
        $stmt2->bindParam(':vehicle_year', $GetDatas['vehicle_year']);
        $stmt2->bindParam(':updated_date', $todayDateTime);
        $stmt2->bindParam(':id_history', $GetDatas['v_id']);
        $stmt2->execute();
        $lastInsertId = $this->pdo->lastInsertId();

             $select_trans_manager = $this->pdo->prepare('select a.id_employee from ps_employee as a left join ps_privilege as b on (a.pri_id=b.pri_id and b.status=0)  where a.active=1 and b.clientbranchmanager=1');
             $select_trans_manager->execute();
             $row=$select_trans_manager->fetchAll(PDO::FETCH_ASSOC);
             

           foreach ($row as $key_manager => $value_manager) {
                    $pri=$city_list=$privilege_query_noti='';
                    $all_city_list=$city_list=[];
            
                $privilege_query_noti=$this->pdo->prepare('select a.*,b.*,city.id_city as all_cities from ps_employee as a left join ps_privilege as b on (a.pri_id=b.pri_id and b.status=0) left join ps_city as city on (FIND_IN_SET(city.id_state,a.all_city_in_state)) where a.active=1 and a.id_employee='.$value_manager['id_employee'].'');
                $privilege_query_noti->execute();
                $row2=$privilege_query_noti->fetchAll(PDO::FETCH_ASSOC);

                $city_list=explode(',', $row2[0]['city']);
                foreach ($row2 as $keyssss => $valuess) {

                $all_city_list[]=$valuess['all_cities'];

                }
                foreach($all_city_list as $key_cityy=>$value_cityy){
                if(!in_array($value_cityy, $city_list)){
                $city_list[]=$value_cityy;
                }
                }
                $pri=implode('|', array_filter($city_list));
                $emp=$this->pdo->prepare('select ps_employee.id_employee from ps_employee left join ps_access on (ps_employee.id_profile=ps_access.id_profile) left join ps_vehicles on (ps_vehicles.v_id='.$GetDatas['v_id'].') left join ps_transporter t on (t.t_id=ps_vehicles.transporter_id) where CONCAT(",", t.dest_name, ",") REGEXP ",('.$pri.')," and ps_access.id_tab=256 and ps_access.edit=1 and ps_employee.active=1 and ps_employee.id_employee='.$value_manager['id_employee']);
                $emp->execute();
                $row3=$emp->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($row3 as $key => $employee_id) {
                   
                    $query3="INSERT INTO ps_notification (table_id,menu_name,controller_link,sent_time,sender,inserted_datetime,receiver,type,message) VALUES (:table_id,:menu_name,:controller_link,:sent_time,:sender,:inserted_datetime,:receiver,:type,:message)";
                    $type=1;
                    $controller_link='AdminAddvehicle';
                    $menu_name='Add Vehicle';
                    $message='Vehicle Update Request from '.$_SESSION['firstname'];
                    $stmt3 = $this->pdo->prepare($query3);
                    $stmt3->bindParam(':table_id', $GetDatas['v_id']);
                    $stmt3->bindParam(':menu_name',$menu_name );
                    $stmt3->bindParam(':controller_link',$controller_link );
                    $stmt3->bindParam(':sent_time', $todayDateTime);
                    $stmt3->bindParam(':sender', $_SESSION['user_id']);
                    $stmt3->bindParam(':inserted_datetime', $todayDateTime);
                    $stmt3->bindParam(':receiver', $employee_id['id_employee']);
                    $stmt3->bindParam(':type', $type);
                    $stmt3->bindParam(':message', $message);
                    $stmt3->execute();

            }
                
         
           }
          return $lastInsertId;
            
    }
    public function CheckalreadyVehicle($GetDatas){
        $no = $GetDatas['no'];
        $id = $GetDatas['id'];
        $transporter_id = $GetDatas['transporter_id'];
        $transcheck=$this->pdo->prepare('SELECT trans_vendors FROM ps_transporter  where  t_id="'.$transporter_id.'"');
        $transcheck->execute();
        $row=$transcheck->fetch(PDO::FETCH_ASSOC);
        $row2=0;
    if($row['trans_vendors']==0){
            if($id!=""){
                $check1=$this->pdo->prepare('SELECT * FROM ps_vehicles  where  transporter_id="'.$transporter_id.'" and v_id!="'.$id.'" and  status not in (1,6)');
                $check1->execute();
                $row2=$check1->fetch(PDO::FETCH_ASSOC);
            }
            else{
                $check1=$this->pdo->prepare('SELECT * FROM ps_vehicles  where transporter_id="'.$transporter_id.'" and status not in (1,6)');
                $check1->execute();
                $row2=$check1->fetch(PDO::FETCH_ASSOC);

            }
    }
            if($id!=""){
                $check=$this->pdo->prepare('SELECT * FROM ps_vehicles  where REPLACE(vehicle_no, " ", "") = "'.$no.'" and v_id!="'.$id.'" and status not in (1,6)');
                $check->execute();
                $row3=$check->fetch(PDO::FETCH_ASSOC);
            }
            else{
                $check=$this->pdo->prepare('SELECT * FROM ps_vehicles  where REPLACE(vehicle_no, " ", "") = "'.$no.'" and status not in (1,6)');
                $check->execute();
                $row3=$check->fetch(PDO::FETCH_ASSOC);

            }
    

        if($row2){
            echo 2;
        }
        else if($row3){
            echo 1;
        }
        else{
            echo 0;

        }
        exit;

    }
	
}
?>