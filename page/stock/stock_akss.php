<?php 
	require_once '../../function.php';

	//получаем тип таблицы
	get_table_svervice_type();

	//получем категорию товара
	get_product_category();

?>
<div class="view_stock_wrapper">
	<div class="view_stock_box_wrp">

		<!-- начало формы добавления товара в базу -->
		<div class="add_stock_sell_wrp flex-cntr">
			<div class="new_stock_box">

				<ul class="add_stock_box_form">

					<li class="add_stock_form_list new_stock_box_header_description">
						<span>AKSESUAR bazaya daxil etmak</span>
					</li>

					<li class="add_stock_form_list">
						<span class="add_stock_description">Malın adı</span>
						<input type="text" autocomplete="off" class="add_stock_input add_stock_name_action">
					</li>

					<input type="hidden" autocomplete="off" class="add_stock_input  add_stock_imei_action">

					<li class="add_stock_form_list">
						<span class="add_stock_description">KATEGORIYA</span>
						<input type="text" autocomplete="off" class="add_stock_input add_stock_provider_action">
					</li>

					<li class="add_stock_form_list">
						<span class="add_stock_description">Mayası</span>
						<input type="text" autocomplete="off" class="add_stock_input add_stock_first_price_action add_stock_fpice_style input_preg_action" placeholder="0">
					</li>

					<li class="add_stock_form_list">
						<span class="add_stock_description">Satış qiyməti</span>
						<input type="text" autocomplete="off" class="add_stock_input add_stock_second_price_action add_stock_spice_style input_preg_action" placeholder="0">
					</li>

					<li class="add_stock_form_list">
						<span class="add_stock_description">MALIN SAYI</span>
						<input type="text" class="add_stock_input add_stock_count input_preg_action add_stock_count_style" autocomplete="off" placeholder="0">						
					</li>
					
					<li class="add_stock_form_list submit_list">
						<a href="javascript:void(0)" class="add_stock_submit btn add_stock_style click">Yüklə</a>
					</li>

				</ul>

			</div>
		</div>		
		<!-- конец формы добавления товара в базу -->

		<!-- начало формы поиска -->
		<?php search_input($stock, $product_akss); ?>	
		<!-- конец формы поиска -->

		<!-- начало таблицы товаров -->
		<div class="stock_view_wrapper">
			<div class="stock_view_list">
				<table>
					<thead>
						<tr>
						    <th>Seriya nömrəsi</th>
						    <th>Alış günü</th>
						    <th>Malın adı</th>
						    <th>Alış qiyməti</th>
						    <th>Satış qiyməti</th>
						   	<th>Sayi</th>
						    <th>Kategoriya</th>
						</tr>
					</thead>
					<tbody class="stock_list_tbody" data-stock-src="<?php echo $stock; ?>" data-category="<?php echo $product_akss; ?>">
						<?php 
							$product_category = $product_akss;

							$stock_list = [];
							$stock_view = $dbpdo->prepare("SELECT * FROM stock_list
							 WHERE stock_visible = 0 
							 AND stock_type = ?
							 ORDER BY stock_id DESC");
							$stock_view->execute([$product_category]);

							while ($stock_row = $stock_view->fetch(PDO::FETCH_BOTH))
								$stock_list[] = $stock_row;

							foreach ($stock_list as $stock_row)
							{
								$stock_id 				= $stock_row['stock_id'];			
								$stock_name 			= $stock_row['stock_name'];				
								$stock_first_price 		= $stock_row['stock_first_price'];	
								$stock_second_price		= $stock_row['stock_second_price'];
								$stock_count			= $stock_row['stock_count'];
								$stock_provider			= $stock_row['stock_provider'];	
								$stock_date 			= $stock_row['stock_get_fdate'];	
								
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

						?>
						<tr>
							<td colspan="8" style="text-align: right;">
								<?php getTotalPriceSellStock($product_category); ?>
								<span class="mark"> <?php echo $manat_image; ?> </span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- конец табицы товаров -->

	</div>
</div>










<?php 
	//выводим модальное окно для оформления заказа
	get_modal_tamplate_checkout_tem();
?>
