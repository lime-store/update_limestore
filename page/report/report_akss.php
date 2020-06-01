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

		<div class="report_search_item">	
			<div class="report_search_box">

				<input type="text" class="search_stock_input_action input_report_search" placeholder="imei, tel model..." data-stock-src="<?php echo $report ?>" data-category="<?php echo $product_akss; ?>" >

			</div>

			<!-- выводим фильт по дате -->
			<?php filt_report_date($product_akss, $dbpdo, $order_myear); ?>
		</div>	

		<!-- конец поиска -->
		<div class="stock_view_wrapper">
			<div class="stock_view_list">
				<table>
					<thead>
						<tr>
							<th class="col-w60">Satış nömrəsi</th>
							<th class="col-w120">Satış günü</th>
							<th class="col-w250">Malın adı</th>
							<th class="col-w120">Satış qiyməti	</th>
							<th class="col-w80">Kategoriya</th>
							<th class="col-w60" title="kimə satılıb">Qeyd</th>
							<th class="col-w60">Sayı</th>
							<th class="col-w120">Xeyir</th>
						</tr>
					</thead>
					<tbody class="stock_list_tbody" data-stock-src="<?php echo  $report; ?>" data-category="<?php echo $product_akss; ?>">	

						<?php 
							$product_category = $product_akss;

							$report_list = [];
							$report_stmt = $dbpdo->prepare("SELECT *
								FROM rasxod 
								INNER JOIN stock_order_report ON stock_order_report.order_my_date = :mydateyear
								AND stock_order_report.stock_order_visible = 0
								AND stock_order_report.stock_type = :product_category
								AND stock_order_report.order_stock_count > 0

								LEFT JOIN stock_list ON stock_list.stock_id = stock_order_report.stock_id
								GROUP BY stock_order_report.order_stock_id DESC
								ORDER BY stock_order_report.order_stock_id DESC
								");
							$report_stmt->bindParam('mydateyear', $order_myear, PDO::PARAM_INT);
							$report_stmt->bindParam('product_category', $product_category, PDO::PARAM_INT);
							$report_stmt->execute();

							   if($report_stmt->rowCount() > 0){
									while ($report_row = $report_stmt->fetch(PDO::FETCH_BOTH))
										$report_list[] = $report_row;
										foreach ($report_list as $report_row)
										{
											$stock_id 			= $report_row['order_stock_id'];
											$order_date 		= $report_row['order_date'];
											$stock_name 		= $report_row['order_stock_name'];
											$stock_sprice 		= $report_row['order_stock_sprice'];
											$stock_provider 	= $report_row['stock_provider'];
											$stock_count 		= $report_row['order_stock_count'];
											$order_who_buy 		= $report_row['order_who_buy'];
											$stock_profit 		= $report_row['order_total_profit'];

											$get_product_table = array('stock_id' => $stock_id,
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
									//выводим выручку за меясц
									get_total_all_profit_phone($dbpdo, $order_myear, $product_category,$manat_image);
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

