<?php  

require_once '../../function.php';


if(isset($_POST['get_product_tab'])) {
	//списко категорий товара
	get_product_category();
	//тип таблицы (terminal, stock, report и тд)
	get_table_svervice_type();

	//id товара
	$give_product_id  = $_POST['product_id'];

	//Категория товара
	$give_prdouct_cat =  trim(strip_tags(stripcslashes(htmlspecialchars($_POST['get_product_cat']))));

	//тип события  (терминал, склда и тд..)
	$give_action_type =  trim(strip_tags(stripcslashes(htmlspecialchars($_POST['get_product_tab']))));

	$get_order = $dbpdo->prepare("SELECT * FROM stock_list WHERE stock_id =:stockId");
	$get_order->bindParam('stockId', $give_product_id, PDO::PARAM_INT);
	$get_order->execute();
	
	$get_order_row = $get_order->fetch();	
	if($get_order->rowCount()>0){
		$o_product_name 	= $get_order_row['stock_name'];
		$o_product_imei 	= $get_order_row['stock_phone_imei'];
		$edit_stock_count 	= $get_order_row['stock_count'];
	}

	//НАЧАЛО: если события терминал
	if($give_action_type == $terminal) {
		//проверяем на категорию товара телефон
		if($give_prdouct_cat === $product_phone) {
			//вызываем шаблон заказа для телефонов
			order_terminal_template_phone( $give_product_id,
										   $o_product_name,
										   $o_product_imei );
		}

		//проверяем на категорию товара акссесуар
		if($give_prdouct_cat === $product_akss) {
			//вызываем шаблон заказа для акссесуара
			order_terminal_template_akss( $give_product_id,
										   $o_product_name,
										   $o_product_imei );		
		}
	}
	//КОНЕЦ: если события терминал

	//НАЧАЛО: если события склад
	if($give_action_type == $stock) {

		$edit_stock_name 		=  $get_order_row['stock_name'];
		$edit_stock_imei 		=  $get_order_row['stock_phone_imei'];


		$edit_stock_sprice 		=  $get_order_row['stock_second_price'];	
		$edit_stock_fprice 		=  $get_order_row['stock_first_price'];

		$edit_stock_provider 	=  $get_order_row['stock_provider'];




		//проверяем на категорию товара телефон
		if($give_prdouct_cat === $product_phone) {

			$get_prod_upd = array(
				'edit_stock_id' 		=> $give_product_id,
				'edit_stock_name' 		=> $o_product_name,
				'edit_stock_imei' 		=> $o_product_imei,
				'edit_stock_provider' 	=> $edit_stock_provider,
				'manat_image' 			=> $manat_image,
				'edit_stock_fprice' 	=> $edit_stock_fprice,
				'edit_stock_sprice' 	=> $edit_stock_sprice,
				'edit_stock_count'		=> $edit_stock_count
			);

			update_stock_phone_tamplate($get_prod_upd);
		}

		//проверяем на категорию товара акссесуар
		if($give_prdouct_cat === $product_akss) {
			$get_prod_upd = array(
				'edit_stock_id' 		=> $give_product_id,
				'edit_stock_name' 		=> $o_product_name,
				'edit_stock_imei' 		=> $o_product_imei,
				'edit_stock_provider' 	=> $edit_stock_provider,
				'manat_image' 			=> $manat_image,
				'edit_stock_fprice' 	=> $edit_stock_fprice,
				'edit_stock_sprice' 	=> $edit_stock_sprice,
				'edit_stock_count'		=> $edit_stock_count
			);
			
			//вызываем шаблон заказа для акссесуара
			update_stock_akss_tamplate( $get_prod_upd );		
		}		
	}
	//КОНЕЦ: если события терминал

	//НАЧАЛО: если события отчёт(report)
	if($give_action_type == $report){
		
		$get_report_order = $dbpdo->prepare("SELECT * FROM stock_order_report 
			WHERE order_stock_id = :product_id 
			AND stock_order_visible = 0");
		$get_report_order->bindParam('product_id', $give_product_id);
		$get_report_order->execute();

		if($get_report_order->rowCount()>0) {
			$retunr_report = $get_report_order->fetch();
			//количество заказа
			$return_product_count = $retunr_report['order_stock_count']; 
			//id товара
			$return_product_id = $retunr_report['stock_id'];
			#give_product_id - id заказа в отчете
			get_report_order_modal($give_product_id, $return_product_id, $return_product_count);
		}

	}
	//КОНЕЦ: если события отчёт(report)
}



