<?php 
	require_once '../../function.php';

	//получаем тип таблицы
	get_table_svervice_type();

	//получем категорию товара
	get_product_category();
	//пути к категориям
	get_product_root_dir();	

	//кнопка компактного меню на странице
	modalNavigationBtn();

	//выводим компакнтное меню на странице 
	getModalSideBarNav();

	//абсолютный пусть к файлам
	root_dir();


	//модальное окно успешно выполнено функция
	success_done();
	//модальное коно не выполнено функция
	fail_notify();
?>
<div class="terminal_main">
	<div class="view_stock_wrapper">
		<div class="view_stock_box_wrp">
			<section class="note_wrapper_section">
				<div class="note_wrapper">
					<div class="note_header">
						<span class="header_text">Rasxod</span>
					</div>
					<div class="note_add_wrp">
						<div class="note_add_form">
							<ul class="add_stock_box_form">
								<li class="add_stock_form_list">
									<span class="add_stock_description">Xərc <?php echo $manat_image; ?>:</span>
									<input type="text" class="add_stock_input add_rasxod_style add_rasxod_value_a">
								</li>
								<li class="add_stock_form_list">
									<span class="add_stock_description">Təsvir:</span>
									<input class="add_stock_input add_rasxod_descript_a">
								</li>
								<li class="add_stock_form_list submit_list">
									<input type="hidden" class="note_action_type" data-type="<?php echo $note; ?>">
									<a href="javascript:void(0)" class="btn add_rasxod_submit flex-cntr">Saxla</a>
								</li>
							</ul>
						</div>
					</div>
				
					<div class="note_table_list">
						<table>
							<thead>
								<tr>
								    <th class="th_date">Tarix</th>
								    <th class="th_price">Ümumi xərclər (<?php echo $manat_image; ?>)</th>
								    <th class="th_imei">Tasvir</th>
								</tr>
							</thead>
							<tbody class="rasxod_order_list">
							<?php 

								$rasxod_list = [];

								$rasxod_query = $dbpdo->prepare("SELECT * FROM rasxod WHERE rasxod_visible = 0
								AND rasxod_year_date = :mydate  GROUP BY rasxod_id DESC");
								$rasxod_query->bindParam('mydate', $order_myear);
								$rasxod_query->execute();

								while ($rasxod_row = $rasxod_query->fetch(PDO::FETCH_BOTH))

									$rasxod_list[] = $rasxod_row;

								foreach ($rasxod_list as $rasxod_row) 
								{
									$rasxod_id 				= $rasxod_row['rasxod_id'];
									$rasxod_day_date 		= $rasxod_row['rasxod_day_date'];
									$rasxod_price 			= $rasxod_row['rasxod_money'];
									$rasxod_descriptuon 	= $rasxod_row['rasxod_description'];								
									
									$get_rasxod = array(
										'rasxod_id'				=> $rasxod_id, 			   			
										'rasxod_day_date'		=> $rasxod_day_date, 	   	
										'rasxod_price'			=> $rasxod_price, 		   		
										'rasxod_descriptuon' 	=> $rasxod_descriptuon,
										'manat_image'			=> $manat_image 
									);

									echo get_rasxod_tr_tamplate($get_rasxod);
								}
							
								$check_total_rasxod = $dbpdo->prepare("SELECT sum(rasxod_money) 
									as total_rasxod_money 
									FROM rasxod 
									WHERE rasxod_year_date = :mydateyear
									AND rasxod_visible = 0");
								$check_total_rasxod->bindParam('mydateyear', $order_myear, PDO::PARAM_INT);
								$check_total_rasxod->execute();

								$check_total_rasxod_row = $check_total_rasxod->fetch();


						 ?>
							<tr>
							  <td colspan="3" style="text-align:right">Cəmi: <?php echo round($check_total_rasxod_row['total_rasxod_money']) . $manat_image; ?></td>
							</tr>													
							</tbody>
						</table>					
					</div>

				</div>
			</section>
		</div>
	</div>












<?php 
	//выводим модальное окно для оформления заказа
	get_modal_tamplate_checkout_tem();
?>
</div>