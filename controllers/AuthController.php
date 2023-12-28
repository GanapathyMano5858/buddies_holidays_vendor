<?php
require_once('./models/EmployeeModel.php');

class AuthController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $passwd = $_POST['passwd'];
            if(empty($email)){
                $error = "Email is empty";
            }
            elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
                $error = "Invalid email";
            }
            elseif(empty($passwd)){
                $error = "Password is empty";
            }
            else{

                if ($this->model->emailExists($email)) {
                    if($this->model->checkVendor($email)){
                    if ($user = $this->model->authenticate($email, $passwd)) {
                        session_start();
                        $_SESSION['trans_vendor_id']=$user['trans_vendor_id'];
                        $_SESSION['user_id'] = $user['id_employee'];
                        $_SESSION['lastname'] = $user['lastname'];
                        $_SESSION['firstname'] =$user['firstname'];
                        $_SESSION['mobile'] = $user['mobile'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['passwd'] = $user['password_custom'];

                        header('Location: ./views/dashboard.php');
                        exit;
                    } else {
                             $error = "Incorrect password";
                            }
                }
                else{
                    $error = "Your are Not Vendor";
                }
            }
                 else {
                      $error = "Email does not exist";
                    }
         }
            
            
        }

        require('./views/login.php');
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ./views/login.php');
        exit;
    }
    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $GetDatas=$_POST;
            $response=$this->model->updateProfile($GetDatas);
            if($response){
               header('Location:./index.php?action=get-profile&&id='.$_SESSION['user_id'].'&&success=Update successful');
               exit;
            }
            else{
               header('Location:./index.php?action=get-profile&&id='.$_SESSION['user_id'].'&&error=Error in Profile Update ...Pls try again later');
               exit;
            }
           
        }
    }
    public function getProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id_employee=$_GET['id'];
            $response=$this->model->getProfile($id_employee);
            // print_r($response);die;
        }
        require('./views/profile.php');
    }

    public function forgot_password(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            if(empty($email)){
                echo "Email is empty";
                exit;
            }
            elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
               echo "Invalid email";
               exit;
            }
            else{
                    $user=$this->model->emailExistsForgot($email);
                if ($user) {
                   $passwd=$this->model->generateRandomPassword();
                   $content= $this->model->generateContent($user['firstname'],$email,$passwd);
                   $emailRes=$this->model->sendEmail($email,'[Buddies Holidays] Your new password',$content,$passwd);
                   
                }
                else{
                     echo "Email does not exist";
                     exit;
                }

            }
        }
        
    }
}
?>
