<?php  

require_once '../../function.php';


if(isset($_POST['get_note_id'])) {
	//списко категорий товара
	get_product_category();
	//тип таблицы (terminal, stock, report и тд)
	get_table_svervice_type();



	$id = $_POST['get_note_id'];

	$new_order_list = [];
	$order_stock_view = $dbpdo->prepare("SELECT * FROM no_availible_order 
		WHERE order_stock_id = :get_note_id
		AND order_stock_visible = 0 ");
	$order_stock_view->bindValue('get_note_id', $id);
	$order_stock_view->execute();	
	$note_row = $order_stock_view->fetch(PDO::FETCH_BOTH);


	$get_note_type		= $note_row['note_type'];
	$note_name 			= $note_row['order_stock_name'];
	$note_descrpt 		= $note_row['order_stock_description'];

	//если запрос по заметки 
	if($get_note_type == $note_category) {
		order_note_template_upd($id, $note_name, $note_descrpt);
	}

}



?>