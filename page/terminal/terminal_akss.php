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

	<div class="view_stock_box_wrp">

		<!-- начало тут выводим поиск -->
		<?php search_input($terminal, $product_akss); ?>
		<!-- конец поиска -->
		<div class="stock_view_wrapper">
			<div class="stock_view_list">
	<table>
		<thead>
				<tr>
				    <th>Seriya nömrəsi</th>
				    <th>Malın adı</th>
				     <th>Alış qiyməti</th>
				     <th>Satış qiyməti</th>
				     <th>Sayi</th>
				     <th>Kategoriya</th>
				  </tr>
		</thead>
		<tbody class="stock_list_tbody" data-stock-src="<?php echo  $terminal; ?>" data-category="<?php echo $product_akss; ?>">				  
				<?php 
					$product_category = $product_akss;
					$akss_stock_list = [];
					$akss_stock_view = $dbpdo->prepare("SELECT * FROM stock_list 
												   WHERE stock_count > 0 
												   AND stock_visible = 0 
												   AND stock_type = 'akss'
												   GROUP BY stock_id DESC");
					$akss_stock_view->execute();

					while ($akss_stock_row = $akss_stock_view->fetch(PDO::FETCH_BOTH))
						$akss_stock_list[] = $akss_stock_row;

					foreach ($akss_stock_list as $akss_stock_row)
					{
						$stock_id 				= $akss_stock_row['stock_id'];
						$stock_name 			= $akss_stock_row['stock_name'];
						$stock_first_price		= $akss_stock_row['stock_first_price'];
						$stock_second_price 	= $akss_stock_row['stock_second_price'];
						$stock_count 			= $akss_stock_row['stock_count'];
						$stock_provider 		= $akss_stock_row['stock_provider'];
						$stock_get_date 		= $akss_stock_row['stock_get_fdate'];

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
						?>
					</tbody>
				</table>
			</div>
		</div>
		
	</div>


<?php 
	//выводим модальное окно для оформления заказа
	get_modal_tamplate_checkout_tem();
?>	