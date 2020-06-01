<?php 

require_once '../../function.php';

//получем список категорий товаров
get_product_category();

header('Content-type: Application/json');

if(isset($_POST['product_name'])) {

	if(empty($_POST['product_name'] && $_POST['product_count'] && $_POST['product_first_price'] )) {
		$product_err = [
		  'error' 		=> ' ', 
		  'input_empty' => 'Bütün sahələri doldurun!'
		];									  								   
		//выводим сообщение и останавливаем
		echo json_encode($product_err);		
		exit();
	}


	//получаем категорию сервиса
	$get_cat_type			= trim(htmlspecialchars(stripcslashes(strip_tags($_POST['get_cat_type']))));
	//получем категорию товара
	$get_prod_type			= trim(htmlspecialchars(stripcslashes(strip_tags($_POST['get_prod_type']))));

	//имя товара
	$prodct_name			= trim(htmlspecialchars(stripcslashes(strip_tags($_POST['product_name']))));
	//imei товара
	$product_imei			= trim(htmlspecialchars(stripcslashes(strip_tags($_POST['product_imei']))));
	//количество товара
	$product_count   		= trim(htmlspecialchars(stripcslashes(strip_tags($_POST['product_count']))));
	//поставщик/категория (если акссесуар)
	$product_provider 		= trim(htmlspecialchars(stripcslashes(strip_tags($_POST['product_provider']))));
	//себестоимость товара
	$product_first_price	= trim(htmlspecialchars(stripcslashes(strip_tags($_POST['product_first_price']))));
	//стоимость товара
	$product_price 			= trim(htmlspecialchars(stripcslashes(strip_tags($_POST['product_price']))));	

	//проверка на imei только если продукт телефон
	if($get_prod_type === $product_phone) {
		//проверка на imei
		$check_availible_imei = $dbpdo->prepare("SELECT * FROM stock_list WHERE stock_phone_imei =:imei AND stock_visible = 0 AND stock_type = 'phone'");
		$check_availible_imei->bindParam('imei', $product_imei, PDO::PARAM_INT);
		$check_availible_imei->execute();

		$check_availible_imei_row = $check_availible_imei->fetch(PDO::FETCH_BOTH);
		
		//если такой продук есть
		if($check_availible_imei->rowCount()>0) {
			//id продукта
			$product_availible = $check_availible_imei_row['stock_id'];

			//вызываем функцию модального окана и переменную $add_stock_available 
			add_product_available($product_availible);


			$product_err = [
			  'error' => $add_stock_available
			];									  								   
			//выводим сообщение и останавливаем
			echo json_encode($product_err);	
			exit();
			
		}
	}

	$add_stock_insert = $dbpdo->prepare("INSERT INTO stock_list 
		(stock_id, 
		stock_name,
		stock_phone_imei, 
		stock_first_price, 
		stock_second_price, 
		stock_count,
		stock_provider,
		stock_get_fdate,
		stock_get_year, 
		stock_type) 
		VALUES (NULL,?,?,?,?,?,?,?,?, ?) ");

	$add_stock_insert->execute([
		$prodct_name,
		$product_imei,
		$product_first_price,
		$product_price,
		$product_count,
		$product_provider,
		$ordertoday,
		$order_myear,
		$get_prod_type

	]);

	//выводим последний добавленный товар 
	$view_new_stock = $dbpdo->prepare("SELECT * FROM stock_list WHERE stock_type =:stock_type GROUP BY stock_id DESC");
	$view_new_stock->bindParam('stock_type', $get_prod_type);
	$view_new_stock->execute();
	$new_stock_row = $view_new_stock->fetch();

	$stock_id 				= $new_stock_row['stock_id'];			
	$stock_name 			= $new_stock_row['stock_name'];				
	$stock_first_price 		= $new_stock_row['stock_first_price'];	
	$stock_second_price		= $new_stock_row['stock_second_price'];
	$stock_count			= $new_stock_row['stock_count'];
	$stock_provider			= $new_stock_row['stock_provider'];	
	$stock_imei 			= $new_stock_row['stock_phone_imei'];
	$stock_date 			= $new_stock_row['stock_get_fdate'];			
	$stock_return_status 	= $new_stock_row['stock_return_status'];
	$return_image 			= '';

	//если продукт телефон выводим шаблон таблицы
	if($get_prod_type === $product_phone) {
		
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

		//выводим шаблон таблицы склада для теефона 
		$stock_table_tamplate = get_stock_phone_table_row($get_tamplate);

        $success = [
        	'ok' => 'ok',
            'product' => $stock_table_tamplate
        ];

        echo json_encode($success); 
        exit();

	}

	//если продукт аксс выводим шаблон таблицы
	if($get_prod_type === $product_akss) {
		
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

		//выводим шаблон таблицы склада для теефона 
		$stock_table_tamplate = get_stock_akss_table_row($get_tamplate);

        $success = [
        	'ok' => 'ok',
            'product' => $stock_table_tamplate
        ];

        echo json_encode($success); 
        exit();

	}
					 		
}


