<?php
class EmployeeModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function emailExists($email){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM ps_employee WHERE email= :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    public function emailExistsForgot($email) {
        $stmt = $this->pdo->prepare("SELECT firstname FROM ps_employee WHERE email= :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user=$stmt->fetch(PDO::FETCH_ASSOC);
         if ($user) {
            return $user;
        } else {
            return false;
        }
    }
    public function checkVendor($email){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM ps_employee WHERE email= :email and trans_vendor_id!=0");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function authenticate($email, $passwd) {
        $passwd=md5(_COOKIE_KEY_.$passwd);
        $query = "SELECT trans_vendor_id,id_employee, firstname, lastname,mobile,email,password_custom FROM ps_employee WHERE email = :email AND passwd = :passwd";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':passwd', $passwd);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }
    public function getProfile($id_employee) {
        $stmt = $this->pdo->prepare("SELECT firstname,lastname,email,mobile,id_employee,password_custom FROM ps_employee WHERE id_employee= :id_employee");
        $stmt->bindParam(':id_employee', $id_employee);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateProfile($GetDatas){
    $query = "UPDATE ps_employee SET firstname = :firstname, lastname = :lastname, mobile=:mobile, email=:email, passwd=:passwd, password_custom=:password_custom WHERE id_employee = :id_employee";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':passwd', $passwd);
        $stmt->bindParam(':password_custom', $password_custom);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id_employee', $id_employee);
        $firstname = $GetDatas["firstname"];
        $lastname = $GetDatas["lastname"];
        $passwd = md5(_COOKIE_KEY_.$GetDatas["password"]);
        $password_custom = base64_encode($GetDatas["password"]);
        $mobile = $GetDatas["mobile"];
        $email = $GetDatas["email"];
        $id_employee = $GetDatas["id_employee"];
        return $stmt->execute();
            
    }
    public function sendEmail($email,$subject,$message,$passwdd){
        $passwd = md5(_COOKIE_KEY_.$passwdd);
        $password_custom = base64_encode($passwdd);
        $query = "UPDATE ps_employee SET passwd=:passwd, password_custom=:password_custom WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':passwd', $passwd);
        $stmt->bindParam(':password_custom', $password_custom);
        $stmt->bindParam(':email', $email);
       
        if($stmt->execute()){
           return sendEmail($email,$subject,$message); 
        }
        else{
            echo 'Error in update...Pls try again later.';
            exit;
        }

        
    }
    public function generateRandomPassword() {
        $length = 8;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;

    }

    public function generateContent($firstname,$email,$password){
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Message from Buddies Holidays</title>
        </head>
        <body>
        <table style="font-family: Verdana,sans-serif; font-size: 11px; color: #374953; width: 550px;">
        <tbody>
        <tr>
        <td align="left"><a title="Buddies Holidays" href="https://www.buddiesholidays.com"><img style="border: none; width:80%" src="https://vendor.buddiesholidays.in/assets/buddies_holidays_logo.png" alt="Buddies Holidays" /></a></td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td align="left">Hi <strong style="color: #dc3545;">'.$firstname.'</strong>,</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td style="background-color: #dc3545; color: #fff; font-size: 12px; font-weight: bold; padding: 0.5em 1em;" align="left">Your new Buddies Holidays login details</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td align="left"><strong>E-mail address:</strong> '.$email.'<br /> <strong>Password:</strong> '.$password.'</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td align="left">Please be careful when sharing these login details with others.<br /><br />You can now login on our Dashboard: https://vendor.buddiesholidays.in</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
        <tr>

        </tr>
        <td style="font-size: 10px; border-top: 1px solid #D9DADE;" align="center"><a style="color: #dc3545; font-weight: bold; text-decoration: none;" href="https://www.buddiesholidays.com">Copyrights &copy; 2017-2023  Buddies Holidays Pvt.Ltd - All Rights Reserved.</a> </td>
        </tr>
        </tbody>
        </table>
        </body>
        </html>';

    }
}
?>
