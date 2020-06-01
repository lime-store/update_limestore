<?php 

	require_once 'function.php';
	

	if (isset($_POST['search_item_value']) && isset($_POST['search_from'])){
		
		//вызываем функцию типы таблиц (если не ясно посмотри комментарий в function.php)
		get_table_svervice_type();


		//получаем списко категорий товаров 
		//$product_phone телефоны
		//$product_akss  акссесуары
		get_product_category();

		$search_val  		= trim(strip_tags(htmlspecialchars($_POST['search_item_value'])));  //получаем текст поиска
		$search_table_type  = trim(strip_tags(htmlspecialchars($_POST['search_from'])));		//тип поиска (терминал, склад и тд)
		$search_product_cat = trim(strip_tags(htmlspecialchars($_POST['search_product_cat'])));			//категория товара (акссеаупаы, телефоны)
		
		$search_value_stmt = $dbpdo->prepare('SELECT * FROM stock_list 
								WHERE stock_name 
								LIKE :search_val_name 
								AND stock_visible = 0
								AND stock_type = :name_prod_cat 
								AND stock_count > 0 
								
								OR stock_phone_imei 
								LIKE :search_val_imei  
								AND stock_count > 0 
								AND stock_type = :imei_prod_cat
								AND stock_visible = 0 

								OR stock_provider 
								LIKE :search_val_provider 
								AND stock_visible = 0
								AND stock_type = :provider_prod_cat
								AND stock_count > 0

								OR stock_get_fdate 
								LIKE :search_val_fdate 
								AND stock_visible = 0
								AND stock_type = :fdate_prod_cat
								AND stock_count > 0

								GROUP BY stock_id DESC');
		$search_value_stmt->bindValue('search_val_name', 	  "%{$search_val}%"); 
		$search_value_stmt->bindValue('search_val_imei', 	  "%{$search_val}%"); 
		$search_value_stmt->bindValue('search_val_provider',  "%{$search_val}%"); 
		$search_value_stmt->bindValue('search_val_fdate', 	  "%{$search_val}%");

		$search_value_stmt->bindValue('name_prod_cat', 	  	$search_product_cat);
		$search_value_stmt->bindValue('imei_prod_cat', 	  	$search_product_cat);
		$search_value_stmt->bindValue('provider_prod_cat',  $search_product_cat);
		$search_value_stmt->bindValue('fdate_prod_cat', 	$search_product_cat);

		$search_value_stmt->execute();


		if($search_value_stmt->rowCount() > 0) {
			while ($search_value_row = $search_value_stmt->fetch(PDO::FETCH_BOTH))
				$search_list[] = $search_value_row;
				foreach ($search_list as $search_value_row) {

					//общие данные
					$stock_id 				= $search_value_row['stock_id'];
					$stock_name 			= $search_value_row['stock_name'];
					$stock_first_price 		= $search_value_row['stock_first_price'];
					$stock_second_price 	= $search_value_row['stock_second_price'];
					$stock_provider		 	= $search_value_row['stock_provider'];
					$stock_date             = $search_value_row['stock_get_fdate'];
					$return_image           = '';

					//телефоны
					$stock_imei 			= $search_value_row['stock_phone_imei'];
					$stock_get_date 		= $search_value_row['stock_get_fdate'];
					$stock_return_status 	= $search_value_row['stock_return_status'];


					//акссеуары
					$stock_count 			= $search_value_row['stock_count'];
					$stock_date 			= $search_value_row['stock_get_fdate'];
					
					//тут проверяем на вклдаку терминала
					if($search_table_type == $terminal) {
						//проверяем товар на категорию телефон
						if($search_product_cat == $product_phone) {

							$get_product_table = array( 'stock_id' 				=> 	$stock_id,
													    'stock_name' 			=> 	$stock_name,
													    'stock_phone_imei' 		=> 	$stock_imei,
													    'stock_first_price' 	=> 	$stock_first_price, 
													    'stock_second_price' 	=> 	$stock_second_price,
													    'stock_return_status' 	=> 	$stock_return_status,
													    'stock_provider'		=> 	$stock_provider, 
													    'manat_image' 			=>  $manat_image,
													    'stock_return_image' 	=>  $stock_return_image
													);				

							get_terminal_phone_table_row( $get_product_table );	
						} 

						//проверяем товар на категорию акссесуар
						if($search_product_cat == $product_akss) {
							$get_product_table = array( 'stock_id'  			=> 	$stock_id,
													    'stock_name' 			=> 	$stock_name,
													    'stock_first_price' 	=> 	$stock_first_price, 
													    'stock_second_price' 	=> 	$stock_second_price,
													    'stock_count'			=>  $stock_count,
													    'stock_provider'		=> 	$stock_provider,
													    'stock_get_date'		=>  $stock_get_date, 
													    'manat_image' 			=>  $manat_image
													);
							get_terminal_akss_table_row($get_product_table);
						}

					}
					//если поиск по складу
					if($search_table_type == $stock) {
						//если телефон в складе
						if($search_product_cat == $product_phone) {
							if($stock_return_status == '1') {
								$return_image = $stock_return_image;
							}

							$get_tamplate = array(
								'stock_id' 					=> $stock_id,
								'stock_date' 				=> $stock_date,
								'stock_name' 				=> $stock_name,
								'stock_imei' 				=> $stock_imei,
								'stock_first_price' 		=> $stock_first_price,
								'stock_second_price' 		=> $stock_second_price,
								'stock_provider' 			=> $stock_provider,
								'manat_image' 				=> $manat_image,
								'stock_return_image' 		=> $return_image 
							);

							echo get_stock_phone_table_row($get_tamplate);	
						}

						if($search_product_cat == $product_akss) {
							$get_tamplate = array(
								'stock_id' 					=> $stock_id,
								'stock_date' 				=> $stock_date,
								'stock_name' 				=> $stock_name,
								'stock_count'				=> $stock_count,
								'stock_first_price' 		=> $stock_first_price,
								'stock_second_price' 		=> $stock_second_price,
								'stock_provider' 			=> $stock_provider,
								'manat_image' 				=> $manat_image
							);

							echo get_stock_akss_table_row($get_tamplate);								
						}
					}


		}


	}


	//если поиск по отчету
	if($search_table_type == $report) {
		$product_category = $search_product_cat;



		if(isset($_POST['sort_data'])){
			$sort_product = trim($_POST['sort_data']);
			//СОРТИРОВКА ПО ИМЕНИ 
			if($sort_product == 'name') {
				$report_stmt = $dbpdo->prepare("SELECT *
				FROM rasxod

				INNER JOIN stock_order_report
				ON stock_order_report.order_stock_name 
				LIKE :search_query
				AND stock_order_report.stock_order_visible = 0
				AND stock_order_report.stock_type = :prod_category
				AND stock_order_report.order_stock_count > 0

				LEFT JOIN stock_list 
				ON stock_list.stock_id = stock_order_report.stock_id 			
				
		 		GROUP BY stock_order_report.order_stock_id DESC
				ORDER BY stock_order_report.order_stock_id DESC");
			}

			//СОРТИРОВКА ПО ДАТЕ
			if($sort_product == 'date') {
				$report_stmt = $dbpdo->prepare("SELECT *
				FROM rasxod

				INNER JOIN stock_order_report
				ON stock_order_report.order_date
				LIKE :search_query
				AND stock_order_report.stock_order_visible = 0
				AND stock_order_report.stock_type = :prod_category	
				AND stock_order_report.order_stock_count > 0

				LEFT JOIN stock_list 
				ON stock_list.stock_id = stock_order_report.stock_id 			
				
		 		GROUP BY stock_order_report.order_stock_id DESC
				ORDER BY stock_order_report.order_stock_id DESC");				
			}

			//СОРТИРОВКА ПО ДАТЕ
			if($sort_product == 'full_date') {
				$report_stmt = $dbpdo->prepare("SELECT *
				FROM rasxod

				INNER JOIN stock_order_report
				ON stock_order_report.order_my_date
				LIKE :search_query
				AND stock_order_report.stock_order_visible = 0
				AND stock_order_report.stock_type = :prod_category	
				AND stock_order_report.order_stock_count > 0

				LEFT JOIN stock_list 
				ON stock_list.stock_id = stock_order_report.stock_id 			
				
		 		GROUP BY stock_order_report.order_stock_id DESC
				ORDER BY stock_order_report.order_stock_id DESC");				
			}
			//сортировка по категоии/provider
			if($sort_product == 'provider') {
				$report_stmt = $dbpdo->prepare("SELECT *
				FROM rasxod

				LEFT JOIN stock_list 
				ON stock_list.stock_provider
				LIKE :search_query 

				INNER JOIN stock_order_report
				ON stock_order_report.stock_id = stock_list.stock_id
				AND stock_order_report.stock_order_visible = 0
				AND stock_order_report.stock_type = :prod_category	
				AND stock_order_report.order_stock_count > 0

				
		 		GROUP BY stock_order_report.order_stock_id DESC
				ORDER BY stock_order_report.order_stock_id DESC");							
			}
		} if(empty($_POST['sort_data'])) {	
				$report_stmt = $dbpdo->prepare("SELECT *
				FROM rasxod

				INNER JOIN stock_order_report
				ON stock_order_report.order_stock_name 
				LIKE :search_query
				AND stock_order_report.stock_order_visible = 0
				AND stock_order_report.stock_type = :prod_category
				AND stock_order_report.order_stock_count > 0

				OR 	stock_order_report.order_stock_imei 
				LIKE :search_query_imei
				AND stock_order_report.stock_order_visible = 0
				AND stock_order_report.stock_type = :prod_category_second
				AND stock_order_report.order_stock_count > 0

				LEFT JOIN stock_list 
				ON stock_list.stock_id = stock_order_report.stock_id 			
				
		 		GROUP BY stock_order_report.order_stock_id DESC
				ORDER BY stock_order_report.order_stock_id DESC");	

				$report_stmt->bindValue('search_query_imei',  "%{$search_val}%"); 
				$report_stmt->bindValue('prod_category_second',  $search_product_cat);	
		}

		if(empty($search_val)) {
			$search_val = $order_myear;
				$report_stmt = $dbpdo->prepare("SELECT *
				FROM rasxod

				INNER JOIN stock_order_report
				ON stock_order_report.order_my_date
				LIKE :search_query
				AND stock_order_report.stock_order_visible = 0
				AND stock_order_report.stock_type = :prod_category	
				AND stock_order_report.order_stock_count > 0

				LEFT JOIN stock_list 
				ON stock_list.stock_id = stock_order_report.stock_id 			
				
		 		GROUP BY stock_order_report.order_stock_id DESC
				ORDER BY stock_order_report.order_stock_id DESC");			
		}

		$report_list = [];
		$report_stmt;
		$report_stmt->bindValue('search_query',  "%{$search_val}%"); 
		$report_stmt->bindValue('prod_category',  $search_product_cat);
		$report_stmt->execute();

		   if($report_stmt->rowCount() > 0){
				while ($report_row = $report_stmt->fetch(PDO::FETCH_BOTH))
					$report_list[] = $report_row;
					foreach ($report_list as $report_row)
					{
						$stock_id 			= $report_row['order_stock_id'];
						$order_date 		= $report_row['order_date'];
						$order_mydate 		= $report_row['order_my_date'];
						$stock_name 		= $report_row['order_stock_name'];
						$stock_imei 		= $report_row['order_stock_imei'];
						$stock_sprice 		= $report_row['order_stock_sprice'];
						$stock_provider 	= $report_row['stock_provider'];
						$stock_count 		= $report_row['order_stock_count'];
						$order_who_buy 		= $report_row['order_who_buy'];
						$stock_profit 		= $report_row['order_total_profit'];

						//если телефон
						if($search_product_cat == $product_phone) {
							$get_product_table = array(
								'stock_id'			=> $stock_id, 		
								'order_date'		=> $order_date, 	
								'stock_name'		=> $stock_name, 	
								'stock_imei'		=> $stock_imei, 	
								'stock_sprice'		=> $stock_sprice, 	
								'stock_provider'	=> $stock_provider, 
								'stock_count'		=> $stock_count, 	
								'order_who_buy'		=> $order_who_buy, 	
								'stock_profit'		=> $stock_profit,
								'manat_image'		=> $manat_image 	
							 );
							get_report_phone_tamplate($get_product_table);
						}

						//если акссесуар
						if($search_product_cat == $product_akss) {
							$get_product_table = array(
								'stock_id'			=> $stock_id, 		
								'order_date'		=> $order_date, 	
								'stock_name'		=> $stock_name, 	
								'stock_sprice'		=> $stock_sprice, 	
								'stock_provider'	=> $stock_provider, 
								'stock_count'		=> $stock_count, 	
								'order_who_buy'		=> $order_who_buy, 	
								'stock_profit'		=> $stock_profit,
								'manat_image'		=> $manat_image 	
							 );
							get_report_akks_tamplate($get_product_table);							
						}
					}

					get_total_all_profit_phone($dbpdo, $search_val, $product_category,$manat_image);	
			} else {
				echo 'Natice tapilmadi';
			}			

	} 


	//поиск по блокноту и расходу
	if($search_table_type == $note) {
		$new_order_list = [];

		if(isset($_POST['sort_data'])){
			$order_stock_view = $dbpdo->prepare("SELECT * FROM no_availible_order 
				WHERE order_stock_date = :search3
				AND order_stock_visible = 0 
				AND note_type = :note_type3	

				GROUP BY order_stock_id DESC");			
			$order_stock_view->bindValue('search3', $search_val, PDO::PARAM_INT);
			$order_stock_view->bindValue('note_type3', $search_product_cat, PDO::PARAM_INT);
		} else {
			$order_stock_view = $dbpdo->prepare("SELECT * FROM no_availible_order 
				WHERE order_stock_name LIKE :search1
				AND order_stock_visible = 0 
				AND note_type = :note_type

				OR order_stock_description LIKE :search2
				AND order_stock_visible = 0 
				AND note_type = :note_type2	

				GROUP BY order_stock_id DESC");
			$order_stock_view->bindValue('search1', "%{$search_val}%");
			$order_stock_view->bindValue('search2', "%{$search_val}%");
			$order_stock_view->bindValue('note_type', $search_product_cat);
			$order_stock_view->bindValue('note_type2', $search_product_cat);
		}
		if(empty($search_val)) {
			$search_val = $order_myear;

			$order_stock_view = $dbpdo->prepare("SELECT * FROM no_availible_order 
				WHERE order_stock_date = :search3
				AND order_stock_visible = 0 
				AND note_type = :note_type3	

				GROUP BY order_stock_id DESC");			
			$order_stock_view->bindValue('search3', $order_myear);
			$order_stock_view->bindValue('note_type3', $search_product_cat);
		} 


		$order_stock_view->execute();			
		while ($order_stock_row = $order_stock_view->fetch(PDO::FETCH_BOTH))
			$new_order_list[] = $order_stock_row;
		foreach ($new_order_list as $order_stock_row)
		{	
				$note_id 			= $order_stock_row['order_stock_id'];
				$note_date 			= $order_stock_row['order_stock_full_date'];
				$note_name 			= $order_stock_row['order_stock_name'];
				$note_descrpt 		= $order_stock_row['order_stock_description'];

				$get_note = array(
					'note_id' 		=> $note_id,
					'note_date' 	=> $note_date, 			
					'note_name' 	=> $note_name, 			
					'note_descrpt'  => $note_descrpt 	 	
				);

				echo get_note_list($get_note);

		}

	}
 

}
?>