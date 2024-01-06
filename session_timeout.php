<?php
require_once('config.php');
require_once('db.php');

class SessionManager {
      private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertSessionInfo($userId) {
            $emp_id=$userId;
            $login_time= date('Y-m-d H:i:s');
            $ip_address=$_SERVER['REMOTE_ADDR'];
            $useragent=$_SERVER['HTTP_USER_AGENT'];
            $type=2;

            $stmt = $this->pdo->prepare("INSERT INTO ps_login_report (emp_id,login_time,ip_address,useragent,type) VALUES (:emp_id,:login_time,:ip_address,:useragent,:type)");
            $stmt->bindParam(':emp_id', $emp_id);
            $stmt->bindParam(':login_time', $login_time);
            $stmt->bindParam(':ip_address', $ip_address);
            $stmt->bindParam(':useragent', $useragent);
            $stmt->bindParam(':type', $type);
            return $stmt->execute();
    }
}


?>