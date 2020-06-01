<?php 
require_once 'db/config.php';

$user_list = $dbpdo->prepare("SELECT * FROM user_control");
$user_list->execute();
$user_list_row = $user_list->fetch(PDO::FETCH_BOTH);

	$user_name_val = 'value="'.$user_list_row['user_name'].'" ';

if(isset($_POST['btn-login']))
{
 
	if (isset($_POST['email'])) {

		$email = $_POST['email']; 

		 if ($email =='') { 
		 	unset($email);
		 	echo "пароля нет";
		 } 
	}		  

	if (isset($_POST['pass'])) {
		 $pass = $_POST['pass']; 

		 if ($pass =='') { 
		 	unset($pass);
		 	echo "пароля нет";
		 } 
	}


	$ustmp = $dbpdo->prepare('SELECT * FROM user_control WHERE user_name = :email');
	$ustmp->bindParam(':email',$email, PDO::PARAM_STR);
	$ustmp->execute();
	$row = $ustmp->fetch();


	if($row['user_password'] == $pass){
    	$_SESSION['user'] = $row['user_id'];
    	$_SESSION['time_start_login'] = time();
    	header('Location: ./'); exit();     
	}else{
        echo '<a href="login" style="color: red;">Пожалуйста, проверьте правильность написания логина и пароля.</a>';
    }

	
}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />		
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/print.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/function.js"></script>
	<script src="js/print.min.js"></script>
	<script src="js/ajax.js"></script>
<!-- 	<script src="js/chart_loader.js"></script>
    <script type="text/javascript" src="./charts/loader.js"></script>	 -->
</head>
<body>
	<?php require_once 'include/header.php'; ?>

	<div class="main_a">		
		<div class="user_login_control">
			<div class="user_logn_wrapper">
				<div class="user_login_form">
					<h2 class="form_title">Login</h2>
			        <form method="post">
			            <?php echo @$msg;?>
			                <div class="e_email">
			                    <input type="text" class="email_input" name="email" placeholder="Your Email" <?php echo $user_name_val ?> required/></td>
			                </div>
			                <div class="u_password">
			                    <input type="password" class="email_input" name="pass" placeholder="Your Password" required /></td>
			                </div>
			                <div class="sbm_btn">
			                    <button type="submit" name="btn-login" class="btn">Войти</button></td>
			                </div>
			        </form>					
				</div>
			</div>
		</div>
	</div>
</body>
</html>