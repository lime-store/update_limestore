<?php 

require_once '../../function.php';

//получем список категорий товаров
get_product_category();

header('Content-type: Application/json');


//удалить товар
if(isset($_POST['delete_products'])) {

	$product_id = $_POST['delete_products'];

	$delteStock = $dbpdo->prepare("UPDATE stock_list SET stock_visible = 1 
		WHERE stock_id = :product_id");
	$delteStock->bindParam('product_id', $product_id, PDO::PARAM_INT);
	$delteStock->execute();

	$success = array('ok' => 'ok');

	echo json_encode($success);

}

if(isset($_POST['delete_report'])) {
	$delete_report_id = trim($_POST['delete_report']);

	$upd_report_row = $dbpdo->prepare("UPDATE stock_order_report SET stock_order_visible = 1 WHERE order_stock_id =:delete_report_id");
	$upd_report_row->bindParam('delete_report_id', $delete_report_id, PDO::PARAM_INT);
	$upd_report_row->execute();
	
	$success = array('ok' => 'ok');

	echo json_encode($success);
	exit();
}