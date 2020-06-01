<?php 
	require_once '../../function.php';
	// //Показывать товары которые находться в базе больше 15 дней 
	// settShowOldProduct();

	// //кнопка компактного меню на странице
	// modalNavigationBtn();

	// //выводим компакнтное меню на странице 
	// getModalSideBarNav();

	// //блок для принта чека
	// printModal();

	// //выводим перекючения вкладок 
	// getCurrentTab(); 


	//получаем тип таблицы
	get_table_svervice_type();

	//получем категорию товара
	get_product_category();
?>

<div class="view_stock_wrapper">
	<div class="view_stock_box_wrp">
		<!-- начало тут выводим поиск -->
		<?php search_input($terminal, $product_phone, $order_myear); ?>
		<!-- конец поиска -->
	<div class="stock_view_wrapper">
		<div class="stock_view_list">
	<table>
		<thead>
				<tr>
					<th>Seriya nömrəsi</th>
					<th>Malın adı</th>
					<th>IMEI</th>
					<th>Alış qiyməti</th>
					<th>Satış qiyməti</th>
					<th>Təchizatçı</th>
					<th title="vazvrat"><?php echo $stock_return_image; ?></th>
				  </tr>
		</thead>
		<tbody class="stock_list_tbody" data-stock-src="<?php echo  $terminal; ?>" data-category="<?php echo $product_phone; ?>">				  
				<?php

					$product_category = $product_phone;

					$stock_list = [];
					$stock_view = $dbpdo->prepare("SELECT * FROM stock_list 
												   WHERE stock_count > 0 
												   AND stock_visible = 0 
												   AND stock_type = ?
												   GROUP BY stock_id DESC");
					$stock_view->execute([$product_category]);

					while ($stock_row = $stock_view->fetch(PDO::FETCH_BOTH))
						$stock_list[] = $stock_row;

					foreach ($stock_list as $stock_row)
					{
						$stock_id 				= $stock_row['stock_id'];
						$stock_name 			= $stock_row['stock_name'];
						$stock_imei 			= $stock_row['stock_phone_imei'];
						$stock_first_price 		= $stock_row['stock_first_price'];
						$stock_second_price 	= $stock_row['stock_second_price'];
						$stock_return_status 	= $stock_row['stock_return_status'];
						$stock_provider		 	= $stock_row['stock_provider'];
						
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

						get_terminal_phone_table_row($get_product_table);
					}
						?>
					</tbody>
				</table>
			</div>
		</div>


	</div>
</div>



<?php 
	//выводим модальное окно для оформления заказа
	get_modal_tamplate_checkout_tem();
?>

