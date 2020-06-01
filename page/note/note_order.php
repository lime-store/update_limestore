<?php 
	require_once '../../function.php';

	//получаем тип таблицы
	get_table_svervice_type();

	//получем категорию товара
	get_product_category();

?>

<div class="view_stock_wrapper">
	<div class="view_stock_box_wrp">
		<section class="note_wrapper_section">
			<div class="note_wrapper">
				<div class="note_header">
					<span class="header_text">Notlar</span>
				</div>
				<div class="note_add_wrp">
					<div class="note_add_form">
						<ul class="add_stock_box_form">
							<li class="add_stock_form_list">
								<span class="add_stock_description">Qeyd:</span>
								<input type="text" class="add_stock_input add_note_name_action">
							</li>
							<li class="add_stock_form_list note_custom_list">
								<span class="add_stock_description">Təsvir:</span>
								<textarea class="add_stock_input add_note_descript"></textarea>
							</li>
							<li class="add_stock_form_list submit_list">
								<input type="hidden" class="note_action_type" data-type="<?php echo $note; ?>">
								<a href="javascript:void(0)" class="btn add_note_submit flex-cntr">Saxla</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="note_search_section">
					<div class="note_search_wrapper">
						<?php search_input($note, $note_category); ?>
							
						</div>
					<div class="note_sort_wrapper">
						<?php filt_report_date($note_category, $dbpdo, $order_myear, 'note'); ?>	
					</div>
				</div>
				
				<div class="note_table_list">
					<table>
						<thead>
							<tr>
							    <th class="th_serial">Seriya nömrəsi</th>
							    <th class="th_date">Tarix</th>
							    <th class="th_name">Qeyd</th>
							    <th class="th_imei">Tasvir</th>
							</tr>
						</thead>
						<tbody class="note_order_list stock_list_tbody" data-stock-src="<?php echo $note; ?>" 
							data-category="<?php echo $note_category; ?>">
							<?php 

								$new_order_list = [];
								$order_stock_view = $dbpdo->prepare("SELECT * FROM no_availible_order 
									WHERE order_stock_visible = 0 
									AND note_type = :note_type
									AND order_stock_date = :cur_date
									GROUP BY order_stock_id DESC");
								$order_stock_view->bindValue('note_type', $note_category);
								$order_stock_view->bindValue('cur_date', $order_myear);
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
							?> 							
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
