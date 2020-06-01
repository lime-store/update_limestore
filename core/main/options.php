<?php

	define('GET_ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);

	require_once(GET_ROOT_DIR.'/function.php');

	get_product_root_dir();

	
?>
<div class="main-option-service">
	<div class="options-list">

		<div class="stock-view option-list-box flex-cntr">
			<div class="stock-view-link">
				<a href="javascript:void(0)" class="select_page_main select_page_btn_style flex-cntr" data-link="<?php echo $menu_link_for_terminal; ?>">
						<span class="stock_view_header"> Malların satışı </span>
					<div class="stock_view_icon">
						<img src="img/icon/cart.png">
					</div>
				</a>				
			</div>
		</div>

		<div class="stock-sall option-list-box flex-cntr">
			<div class="stock-sall-link">
				<a href="javascript:void(0)" class="select_page_main select_page_btn_style flex-cntr" data-link="<?php echo $menu_link_for_stock; ?>">
						<span class="stock_view_header"> Malların alışı </span>
					
					<div class="stock_view_icon">
						<img src="img/icon/stock.png">
					</div>
				</a>
			</div>
		</div>

		<div class="stock-report option-list-box flex-cntr">
			<div class="stock-report-link">
				<a href="javascript:void(0)" class="select_page_main select_page_btn_style flex-cntr" data-link="<?php echo $menu_link_for_report; ?>">
						<span class="stock_view_header"> Hesabat </span>
				
					<div class="stock_view_icon">
						<img src="img/icon/report.png">
					</div>
				</a>								
			</div>
		</div>

		<div class="stock-no_stock_order option-list-box flex-cntr">
			<div class="stock-no_stock_order-link">
				<a href="javascript:void(0)" class="select_page_main select_page_btn_style flex-cntr" data-link="<?php echo $menu_link_for_note; ?>">
						<span class="stock_view_header"> Sifarişlər </span>
				
					<div class="stock_view_icon">
						<img src="img/icon/order.png">
					</div>
				</a>								
			</div>
		</div>	

		<div class="stock-licence option-list-box flex-cntr">
			<div class="stock-licene-link">
				<a href="javascript:void(0)" class="select_page_main select_page_btn_style flex-cntr" data-link="<?php echo $menu_link_for_raxdod; ?>">
						<span class="stock_view_header"> Xərc (Rasxod) </span>
					<div class="stock_view_icon">
						<img src="img/icon/rasxod.png">
					</div>
				</a>								
			</div>
		</div>

		<div class="stock-recycle option-list-box flex-cntr">
			<div class="stock-recycle-link">
				<a href="javascript:void(0)" class="select_page_main select_page_btn_style flex-cntr" data-link="<?php echo $menu_link_for_recycle; ?>">
					<span class="stock_view_header"> Zibil qutusu </span>
					<div class="stock_view_icon">
						<img src="img/icon/trash.png">
					</div>
				</a>								
			</div>
		</div>
		
	</div>
</div>			