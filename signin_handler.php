<?php
    session_start();
    require('connection.php');
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email=$_POST['email'];
        $user_password=md5($_POST['password']);

        $stmt = $conn->prepare("Select userid,name from Users where email=? and password=?;");
        $stmt->bind_param('ss',$email,$user_password);
        $stmt->execute();
        
        $result_set = $stmt->get_result();
        $num_rows = $result_set->num_rows;
        
        if($num_rows>0){
            // echo ($result_set->fetch_array(MYSQLI_BOTH))['userid'];
            $result_array=($result_set->fetch_array(MYSQLI_BOTH));
            $_SESSION['userid']=$result_array['userid'];
            $_SESSION['name']=$result_array['name'];
            header("Location: http://".$_SERVER['SERVER_NAME']."/PropertyDalal/index.php");
        }
        else{
            $_SESSION['invalid_user']=1;
            // echo $_SESSION['invalid_user']."OKay";
            header("Location: http://".$_SERVER['SERVER_NAME']."/PropertyDalal/signin.php");
        }
        
    }
?>