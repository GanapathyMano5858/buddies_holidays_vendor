<?php
class DriverListModel{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo=$pdo;
	}
	public function getDriverList() {

		$driverList =$this->pdo->prepare(' SELECT ps_driver.*,ps_driver.status,ps_driver.blocked as vehicle_blocked,ps_driver.contact_no as driver_contact,ps_driver.contactalterno as driver_alternate FROM ps_driver  LEFT JOIN ps_transporter ON ps_transporter.t_id=ps_driver.transporter_id  where ps_transporter.t_id='.$_SESSION['trans_vendor_id'].'  and ps_driver.status!=1  ORDER BY ps_driver.id_driver DESC');
		$driverList->execute();
			return array(
				'driverList'=>$driverList->fetchAll(PDO::FETCH_ASSOC),
			);
			
    }
    public function addDriver($id_driver=false){
        $driverList=[];
        if($id_driver){

            $driverList =$this->pdo->prepare('SELECT tr.transporter_name,ps_driver.* FROM ps_driver  left join ps_transporter as tr on (tr.t_id=ps_driver.transporter_id) where ps_driver.id_driver="'.$id_driver.'" and ps_driver.status not in (1,3,6)');

            $driverList->execute();  
            $driverList= $driverList->fetch(PDO::FETCH_ASSOC);
        }
      
        return array(
            'driverList'=>$driverList
        );
    }
    public function saveDriver($GetDatas){
        $query="INSERT INTO ps_driver (transporter_id,driver_name,contact_no,contactalterno,driving_license,aadhaar,create_date,status,employee_id,tab_id) VALUES (:transporter_id,:driver_name,:contact_no,:contactalterno,:driving_license,:aadhaar,:create_date,:status,:employee_id,:tab_id)";

        $stmt = $this->pdo->prepare($query);
        $todayDateTime=date('Y-m-d H:i:s');
        $status=3;
        $tab_id=319;
        $stmt->bindParam(':transporter_id', $_SESSION['trans_vendor_id']);
        $stmt->bindParam(':driver_name', $GetDatas['driver_name']);
        $stmt->bindParam(':contact_no', $GetDatas['contact_no']);
        $stmt->bindParam(':contactalterno', $GetDatas['contactalterno']);
        $stmt->bindParam(':driving_license', $GetDatas['driving_license']);
        $stmt->bindParam(':aadhaar', $GetDatas['aadhaar']);
        $stmt->bindParam(':create_date', $todayDateTime);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':employee_id', $_SESSION['user_id']);
        $stmt->bindParam(':tab_id', $tab_id); 
        $stmt->execute();
        $lastInsertId = $this->pdo->lastInsertId();
        $query2="INSERT INTO ps_driver_history (transporter_id,driver_name,contact_no,contactalterno,driving_license,aadhaar,create_date,id_history) VALUES (:transporter_id,:driver_name,:contact_no,:contactalterno,:driving_license,:aadhaar,:create_date,:id_history)";

        $stmt2 = $this->pdo->prepare($query2);
        $stmt2->bindParam(':transporter_id', $_SESSION['trans_vendor_id']);
        $stmt2->bindParam(':driver_name', $GetDatas['driver_name']);
        $stmt2->bindParam(':contact_no', $GetDatas['contact_no']);
        $stmt2->bindParam(':contactalterno', $GetDatas['contactalterno']);
        $stmt2->bindParam(':driving_license', $GetDatas['driving_license']);
        $stmt2->bindParam(':aadhaar', $GetDatas['aadhaar']);
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
                $emp=$this->pdo->prepare('select ps_employee.id_employee from ps_employee left join ps_access on (ps_employee.id_profile=ps_access.id_profile) left join ps_driver on (ps_driver.id_driver='.$lastInsertId.') left join ps_transporter t on (t.t_id=ps_driver.transporter_id) where CONCAT(",", t.dest_name, ",") REGEXP ",('.$pri.')," and ps_access.id_tab=319 and ps_access.edit=1 and ps_employee.active=1 and ps_employee.id_employee='.$value_manager['id_employee']);
                $emp->execute();
                $row3=$emp->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($row3 as $key => $employee_id) {
                    $query3="INSERT INTO ps_notification (table_id,menu_name,controller_link,sent_time,sender,inserted_datetime,receiver,type,message) VALUES (:table_id,:menu_name,:controller_link,:sent_time,:sender,:inserted_datetime,:receiver,:type,:message)";
                    $type=2;
                    $controller_link='AdminAdddriver';
                    $menu_name='Add Driver';
                    $message='Driver Active Request from '.$_SESSION['firstname'];
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
    public function updateDriver($GetDatas){
    $query = "UPDATE ps_driver SET transporter_id = :transporter_id, driver_name = :driver_name, contact_no=:contact_no, contactalterno=:contactalterno,driving_license=:driving_license,aadhaar=:aadhaar, updated_date=:updated_date, status=:status,employee_id=:employee_id,tab_id=:tab_id WHERE id_driver = :id_driver";
        $status=4;
        $tab_id=319;
        $todayDateTime=date('Y-m-d H:i:s');
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':transporter_id', $_SESSION['trans_vendor_id']);
        $stmt->bindParam(':driver_name', $GetDatas['driver_name']);
        $stmt->bindParam(':contact_no', $GetDatas['contact_no']);
        $stmt->bindParam(':contactalterno', $GetDatas['contactalterno']);
        $stmt->bindParam(':driving_license', $GetDatas['driving_license']);
        $stmt->bindParam(':aadhaar', $GetDatas['aadhaar']);
        $stmt->bindParam(':updated_date', $todayDateTime);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':employee_id', $_SESSION['user_id']);
        $stmt->bindParam(':tab_id', $tab_id);
        $stmt->bindParam(':id_driver', $GetDatas['id_driver']);
        
        $stmt->execute();
        $query2="INSERT INTO ps_driver_history (transporter_id,driver_name,contact_no,contactalterno,driving_license,aadhaar,updated_date,id_history) VALUES (:transporter_id,:driver_name,:contact_no,:contactalterno,:driving_license,:aadhaar,:updated_date,:id_history)";

        $stmt2 = $this->pdo->prepare($query2);
        $stmt2->bindParam(':transporter_id', $_SESSION['trans_vendor_id']);
        $stmt2->bindParam(':driver_name', $GetDatas['driver_name']);
        $stmt2->bindParam(':contact_no', $GetDatas['contact_no']);
        $stmt2->bindParam(':contactalterno', $GetDatas['contactalterno']);
        $stmt2->bindParam(':driving_license', $GetDatas['driving_license']);
        $stmt2->bindParam(':aadhaar', $GetDatas['aadhaar']);
        $stmt2->bindParam(':updated_date', $todayDateTime);
        $stmt2->bindParam(':id_history', $GetDatas['id_driver']);
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
                $emp=$this->pdo->prepare('select ps_employee.id_employee from ps_employee left join ps_access on (ps_employee.id_profile=ps_access.id_profile) left join ps_driver on (ps_driver.id_driver='.$GetDatas['id_driver'].') left join ps_transporter t on (t.t_id=ps_driver.transporter_id) where CONCAT(",", t.dest_name, ",") REGEXP ",('.$pri.')," and ps_access.id_tab=256 and ps_access.edit=1 and ps_employee.active=1 and ps_employee.id_employee='.$value_manager['id_employee']);
                $emp->execute();
                $row3=$emp->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($row3 as $key => $employee_id) {
                   
                    $query3="INSERT INTO ps_notification (table_id,menu_name,controller_link,sent_time,sender,inserted_datetime,receiver,type,message) VALUES (:table_id,:menu_name,:controller_link,:sent_time,:sender,:inserted_datetime,:receiver,:type,:message)";
                    $type=2;
                    $controller_link='AdminAdddriver';
                    $menu_name='Add Driver';
                    $message='Driver Update Request from '.$_SESSION['firstname'];
                    $stmt3 = $this->pdo->prepare($query3);
                    $stmt3->bindParam(':table_id', $GetDatas['id_driver']);
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
    public function CheckalreadyDriver($GetDatas){
        $name= preg_replace("/\s+/","",strtolower($GetDatas['name']));
        $no = $GetDatas['no'];
        $id = $GetDatas['id'];

        if($id!=""){
            $check=$this->pdo->prepare('SELECT * FROM ps_driver  where  REPLACE(LOWER(driver_name)," ","")="'.$name.'" and contact_no="'.$no.'" and id_driver !='.$id.' and status  not in (1,6)');
             $check->execute();
             $row=$check->fetch(PDO::FETCH_ASSOC);
        }
        else{
            $check=$this->pdo->prepare('SELECT * FROM ps_driver  where  REPLACE(LOWER(driver_name)," ","")="'.$name.'" and contact_no="'.$no.'" and status  not in (1,6)');
             $check->execute();
             $row=$check->fetch(PDO::FETCH_ASSOC);
        }
    
        if($row){
            echo 1;
        }
       
        else{
            echo 0;

        }
        exit;

    }
     public function viewDriver($GetDatas){
        $id = $GetDatas['id'];
        $driverList =$this->pdo->prepare('SELECT tr.transporter_name,ps_driver.* FROM ps_driver  left join ps_transporter as tr on (tr.t_id=ps_driver.transporter_id) where ps_driver.id_driver='.$id);
        $driverList->execute();
        $row=$driverList->fetch(PDO::FETCH_ASSOC);
         $content='<div class="container-fluid border p-3 rounded">
                <div class="row justify-content-between p-2">
                  <div class="col-md-6 text-start">
                    Driver Name :
                  </div>
                  <div class="col-md-6 text-secondary text-end">
                    '.$row["driver_name"].'
                  </div>
                </div>
                <div class="row justify-content-between p-2">
                  <div class="col-md-6 text-start">
                    Driver contact No :
                  </div>
                  <div class="col-md-6 text-secondary text-end">
                    '.$row["contact_no"].'
                  </div>
                </div>
                <div class="row justify-content-between p-2">
                  <div class="col-md-6 text-start">
                    Driver alternate Contact :
                  </div>
                  <div class="col-md-6 text-secondary text-end">
                    '.$row["contactalterno"].'
                  </div>
                </div>
                <div class="row justify-content-between p-2">
                  <div class="col-md-6 text-start">
                    Driving License :
                  </div>
                  <div class="col-md-6 text-secondary text-end">
                    '.$row["driving_license"].'
                  </div>
                </div>
                <div class="row justify-content-between p-2">
                  <div class="col-md-6 text-start">Aadhaar :</div>
                  <div class="col-md-6 text-secondary text-end">
                    '.$row["aadhaar"].'
                  </div>
                </div>
                <div
                  class="row justify-content-between p-2 align-items-center"
                >
                  <div class="col-md-6 text-start">
                    Date Created :
                  </div>
                  <div class="col-md-6 text-secondary text-end">
                    '.date('d/m/Y h:i:s a', strtotime($row["create_date"])).'
                  </div>
                </div>
              </div>';
              echo $content;
              exit;

     }
	
}
?>