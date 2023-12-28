<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include(dirname(dirname(__FILE__))).'/config.php';
$con = mysqli_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_,_DB_NAME_) or die("Error " . mysqli_error($con));
		date_default_timezone_set('Asia/Kolkata');


$arrival_via="";	
$departure_via="";
$vialist= array(1=>'Flight',2=>'Train',3=>'Bus',4=>'Residency');
$query = "SELECT a.*,c.company_name FROM ps_client as a  left join ps_agent as c on (a.agent_id=c.id_agent  and c.status=0) WHERE id_client='".$_GET['id_client']."'";	
$select= mysqli_query($con,$query);
while($row=mysqli_fetch_array($select))
{
	$adult=$row['noofadult'];
	$kid=$row['noofkid'];
	$clientname=$row['client_name'];
	//$startfrom=$row['start_from'];
	$startfrom = date('d-m-Y', strtotime($row['start_from']));
	//$endto=$row['end_to'];
	$endto = date('d-m-Y', strtotime($row['end_to']));
	$agent=$row['company_name'];
	$clientcontactno=$row['contact_no'];
	if (array_key_exists($row['arrival_via'],$vialist)){
		  $arrival_via = '('.$vialist[$row['arrival_via']].')';  
	  	}
	  	
	$arrival=$row['client_arrival_name'].'-'.$arrival_via.'-'.$row['a_train_flight_no'];
	if (array_key_exists($row['departure_via'],$vialist)){
		  $departure_via = '('.$vialist[$row['departure_via']].')';  
	  	}
	$departure=$row['client_departure_name'].'-'.$departure_via.'-'.$row['d_train_flight'];
	
}

$selectss= mysqli_query($con,'select * from ps_vehicle_allotment where client_table_id='.$_GET['id_client'].' order by va_id desc limit 1');
while($rowssss=mysqli_fetch_array($selectss))
{
	$va_id=$rowssss['va_id'];

}

/* $fetch_driver = mysqli_query($con,"select va.*,v.contact_no,v.driver_name,vt.vehicle_type_name,v.vehicle_no,v.contactalterno from  ps_vehicle_allotment va left join ps_vehicles v on(v.v_id=va.va_driver_id) left join ps_vehicletypes vt on(vt.vt_id=v.vehicle_type) where client_table_id=".$_GET['id_client']." and v.status=0  and  va.va_id=".$va_id.""); 
	$row=mysqli_fetch_array($fetch_driver);
	$driver = $row['driver_name'];
	$vehicle_type_name = $row['vehicle_type_name'];
	$vehicle_no = $row['vehicle_no'];
	$driver_mobile_no = $row['contact_no'];
	$driver_al_mobile_no = $row['contactalterno'];*/
if(isset($_GET['name'])){
	$driver = $_GET['name'];
	$vehicle_type_name = $_GET['vehicle'];
	$vehicle_no = $_GET['vehicle_no'];
	$driver_mobile_no = $_GET['mobile'];
	$driver_al_mobile_no = $_GET['al_mobile'];
}



$get_details="SELECT details ,special_note FROM `ps_client` WHERE id_client='".$_GET['id_client']."'";
$select2= mysqli_query($con,$get_details);
	while($row2=mysqli_fetch_array($select2))
	{
		$dets=$row2['details'];	
		$special_note=$row2['special_note'];	
	}
	$get_agent="SELECT * FROM  ps_client as a  left join ps_agent as b on a.agent_id=b.id_agent WHERE a.id_client='".$_GET['id_client']."'";
	$select3= mysqli_query($con,$get_agent);
	while($row3=mysqli_fetch_array($select3))
	{
		$agent=$row3['company_name'];	
	}

$agent_name= preg_replace("/\s+/","",strtolower($agent));
//echo $agent_name;

	$feedback="";
	if($agent_name=='makemytrip'){
			$feedback='feedback_makemytrip.jpg';

	}
//	else if($agent_name=='buddiesholidays'){
//		$feedback='feedback_buddiesholidays.jpg';

//	}
	else{
		$feedback='feedback_buddiesholidays.jpg';

	}

$html='';


	
//<h2>Emergency Contact: '.$cuser.' : '.$usermob.',8220044442 – Buddies Tours</h2>
$html.= '<h1 style="text-align:center; color:red;">Itinerary Details</h1>
<table cellpadding="0" cellspacing="0" width="100%" border="1" style="text-align:center; margin-left:120px; font-size:14px; ">
   <tr style="background-color:#ffffff; #000">
      <td style=" vertical-align:middle; padding:20px 30px 0 0; font-size:18px;">Guest Name</td>
      <td style="text-align:center;padding-top:10px;">'.$clientname.'</td>
   </tr>
   <tr style="background-color:#ffffff; #000">
      <td style=" vertical-align:middle; padding-top:20px; font-size:18px;">Date of Arrival  & Departure</td>
      <td style="text-align:center;padding-top:10px;">'.$startfrom.' To '.$endto.'</td>
   </tr>';
    if($_GET['vendor']==0){
    $html.= '<tr style="background-color:#ffffff; #000">
      <td style=" vertical-align:middle; padding-top:20px; font-size:18px;">Contact Number</td>
      <td style="text-align:center;padding-top:10px;">'.$clientcontactno.'</td>
   </tr>';
}
  
    $html.= '<tr style="background-color:#ffffff; #000">
      <td style=" vertical-align:middle; padding-top:20px; font-size:18px;">Arrival</td>
      <td style="text-align:center;padding-top:10px;">'.$arrival.'</td>
   </tr>
   <tr style="background-color:#ffffff; #000">
      <td style=" vertical-align:middle; padding-top:20px; font-size:18px;">Departure</td>
      <td style="text-align:center;padding-top:10px; font-weight:normal;">'.$departure.'</td>
   </tr>';
//    if($_GET['vendor']==0){
//      $html.= '<tr style="background-color:#ffffff; #000">
//       <td style=" vertical-align:middle; padding-top:20px; font-size:18px;">Agent Name</td>
//       <td style="text-align:center;padding-top:10px; font-weight:normal;">'.$agent.'</td>
//    </tr>';
// }
    $html.= '<tr style="background-color:#ffffff; #000">
      <td style=" vertical-align:middle; padding-top:20px; font-size:18px;">No of People</td>
      <td style="text-align:center;padding-top:10px;">Adult:'.$adult.' , Kid:'.$kid.'</td>
   </tr>';
   if(isset($_GET['name'])){
     $html.= '<tr style="background-color:#ffffff; #000">
      <td style=" vertical-align:middle; padding-top:20px; font-size:18px;">Driver Name</td>
      <td style="text-align:center;padding-top:10px; font-weight:normal;">'.$driver.'</td>
   </tr>

     <tr style="background-color:#ffffff; #000">
      <td style=" vertical-align:middle; padding-top:20px; font-size:18px;">Driver Mobile No</td>
      <td style="text-align:center;padding-top:10px; font-weight:normal;">'.$driver_mobile_no.','.$driver_al_mobile_no.'</td>
   </tr>
     <tr style="background-color:#ffffff; #000">
      <td style=" vertical-align:middle; padding-top:20px; font-size:18px;">Vehicle</td>
      <td style="text-align:center;padding-top:10px;">'.$vehicle_type_name.'</td>
   </tr>
     <tr style="background-color:#ffffff; #000">
      <td style=" vertical-align:middle; padding-top:20px; font-size:18px;">Vehicle No</td>
      <td style="text-align:center;padding-top:10px;">'.$vehicle_no.'</td>
   </tr>';
}
//   if($_GET['vendor']==1&&$_GET['date']<=date("Y-m-d", strtotime("+1 days"))){
//        $html.='<tr  style="background-color:#ffffff; #000">
//        <td colspan="2">'.$dets.'</td>
//    </tr>';
// }
// else if($_GET['vendor']==0){
	$html.='<tr  style="background-color:#ffffff; #000">
       <td colspan="2">'.$dets.'</td>
   </tr>';

//}

  
  
$html.='</table>';
 if($_GET['special']==1&&$special_note!=""){
	
  $html.= '<h1 style="text-align:center; color:red;">Special Note</h1>
<table cellpadding="0" cellspacing="0" width="100%" border="1" style="text-align:center; margin-left:120px; font-size:14px; "><tr  style="background-color:#ffffff; #000">
       <td colspan="2">'.$special_note.'</td>
   </tr>

</table>';

}

$html.= '<img src="'.$feedback.'" height="900px">';

$html=preg_replace('/[[:^print:]]/', ' ', $html);
//echo $html; die;

//============================================================+
// File name   : example_021.php 
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 021 for TCPDF class
//               WriteHTML text flow
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML text flow.
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).

   
include dirname(__FILE__).'/pdf/examples/tcpdf_include.php';


// create new PDF document
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nalinee Sekar');
$pdf->SetTitle('Itinerary Details');
$pdf->SetSubject('Itinerary Details');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
 
// set default header data

//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// /$pdf->SetMargins(30, 200, PDF_MARGIN_RIGHT,true);
$pdf->SetMargins(10, PDF_MARGIN_TOP-15, PDF_MARGIN_RIGHT,true);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM-15);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 $pdf->setPrintHeader(true);
// set font
$pdf->SetFont('helvetica', '', 9);
//$pdf->SetMargins(10, 10, 10,true);

//$pdf->SetAutoPageBreak(TRUE, 0);
// add a page
$pdf->AddPage();


// create some HTML content


$html=$html;




// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//ob_end_clean();
$pdf->Output('vehicleallotment.pdf','I');


//============================================================+
// END OF FILE
//============================================================+
?>