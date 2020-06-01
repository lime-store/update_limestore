<?php 
ob_start();

session_start();
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','lime_sklad');


define('DIR','http://domain.com/');
define('SITEEMAIL','noreply@domain.com');

try 
{
	$dbpdo = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
    $dbpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbpdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		if(!isset($_SESSION['user'])){
			include 'user_auth.php';
			exit();
		}

 

} 
catch(PDOException $e)
{
    echo "Проблемы на сервере";
    exit();
}


?>
