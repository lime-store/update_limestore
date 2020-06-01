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
						<span>Telefon bazaya daxil etmak</span>
					</li>

					<li class="add_stock_form_list">
						<span class="add_stock_description">Malın adı</span>
						<input type="text" autocomplete="off" class="add_stock_input add_stock_name_action">
					</li>

					<li class="add_stock_form_list">
						<span class="add_stock_description">IMEI</span>
						<input type="text" autocomplete="off" class="add_stock_input  add_stock_imei_action">
					</li>

					<li class="add_stock_form_list">
						<span class="add_stock_description">Kimin malıdı</span>
						<input type="text" autocomplete="off" class="add_stock_input add_stock_provider_action">
					</li>

					<li class="add_stock_form_list">
						<span class="add_stock_description">Mayası</span>
						<input type="text" autocomplete="off" class="add_stock_input add_stock_first_price_action add_stock_fpice_style input_preg_action" placeholder="0">
					</li>

					<li class="add_stock_form_list">
						<span class="add_stock_description">Satış qiyməti</span>
						<input type="text" autocomplete="off" class="add_stock_input add_stock_second_price_action add_stock_spice_style input_preg_action" placeholder="0">
						
						<!-- количество товара если телефон то поумолчанью 1 -->
						<input type="hidden" class="add_stock_count" value="1">						
					</li>

					<li class="add_stock_form_list submit_list">
						<a href="javascript:void(0)" class="add_stock_submit btn add_stock_style click">Yüklə</a>
					</li>

				</ul>
			</div>
		</div>		
		<!-- конец формы добавления товара в базу -->

		<!-- начало формы поиска -->
		<?php search_input($stock, $product_phone); ?>	
		<!-- конец формы поиска -->

		<!-- начало таблицы товаров -->
		<div class="stock_view_wrapper">
			<div class="stock_view_list">
				<table>
					<thead>
						<tr>
						    <th class="th_serial">Seriya nömrəsi</th>
						    <th class="th_date">Alış günü</th>
						    <th class="th_name">Malın adı</th>
						    <th class="th_imei">IMEI</th>
						    <th class="th_fpice">Alış qiyməti</th>
						    <th class="th_sprice">Satış qiyməti</th>
						    <th class="th_provider">Təchizatçı</th>
						    <th><?php echo $stock_return_image; ?></th>
						</tr>
					</thead>
					<tbody class="stock_list_tbody" data-stock-src="<?php echo  $stock; ?>" data-category="<?php echo $product_phone; ?>">

						<?php
							$product_category = $product_phone;

							$stock_list = [];
							$stock_view = $dbpdo->prepare("SELECT * FROM stock_list
							 WHERE stock_visible = 0 
							 AND stock_count > 0 
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
								$stock_imei 			= $stock_row['stock_phone_imei'];
								$stock_date 			= $stock_row['stock_get_fdate'];			
								$stock_return_status 	= $stock_row['stock_return_status'];
								$return_image           = '';

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

						 ?>
						<tr class="total_value_table">
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
