<?php 
require_once 'db/config.php';
date_default_timezone_set('Asia/Baku');

$lincence_check = $dbpdo->prepare("SELECT * FROM licence");
$lincence_check->execute();

	$lince_check_row = $lincence_check->fetch();

	$lincence_status = $lince_check_row['licence_active'];

if($lincence_status == 0)
{
	header('Location: licence.php');
	exit();
}

if($lincence_status == 1)
{
	$licence_deactive_date = $lince_check_row['licence_active_deactive'];
}

$manat_image = '<img src="/img/icon/manat.png" class="manat_con_class">';

$ordertoday = date("d.m.Y");
$order_myear = date("m.Y");

$deactive_date = date('d.m.Y', strtotime('+30 day'));


//кнопка компактного меню на странице
function modalNavigationBtn() {
?>
 	<div class="modle_menu_btn">
		<a href="javascript:void(0)" class="module_nav_btn">
			<img src="img/icon/menu_open.png" class="module_nav_first_image">
			<img src="img/icon/menu_cancle.png" class="module_nav_second_image">
		</a>
	</div>	
<?php
}


//блок для принта чека
function printModal() {
?>
	<div class="print_div">
		<div class="close_print_module">
			<a href="javascript:void(0)" class="hide_print_module"><img src="img/icon/cancel-black.png"></a>
		</div>
		<div class="print_content" id="print_content">
		</div>
	</div>
<?php
}

//preloader

function get_preloader() {
	$preloader = '<div class="preloader_wrapper modal flex-cntr"> <img src="/img/icon/load.gif"> </div>';
	return $preloader;
}

//маркировака возврата
$stock_return_image = '<img src="img/icon/investment.png" style="width: 40px; height:40px;" title="Bu mall vazvrat olunub">';


//имя пользователя
function getUserName() {
	global $dbpdo;
	$ustmp = $dbpdo->prepare('SELECT * FROM user_control');
	$ustmp->bindParam(':email',$email, PDO::PARAM_STR);
	$ustmp->execute();
	$row = $ustmp->fetch();

	$userNameVal = $row['user_name'];
	echo $userNameVal;
}


//врводим компакнтное меню на странице 
function getModalSideBarNav() {
?>	
	<div class="module_sidebar">
		<?php require_once 'core/main/options.php';?>
	</div>
<?php
return true;
}


//меню на главной
// function getPageUrlMain() {
// 	global $get_view_stock; 		
// 	global $sell_stock;				
// 	global $report;					
// 	global $no_stock_order;			
// 	global $rasxod;					
// 	global $recycle;				

// 	$get_view_stock   =  'products/terminal/terminal.php';  		//страница продажы товаров         
// 	$sell_stock 	  =  'sell_stock.php';							//страница склада товаров
// 	$report 		  =  'report.php';								//страница отчета
// 	$no_stock_order   =  'no_stock_order.php';						//страница заказов/заметки
// 	$rasxod 		  =  'rasxod.php';								//страница расходов
// 	$recycle 		  =  'recycle';									//корзина


// 	return $get_view_stock; 
// 	return $sell_stock;		
// 	return $report;			
// 	return $no_stock_order;	
// 	return $rasxod;			
// 	return $recycle;

// }

function root_dir() {
	define('GET_ROOT_DIRS', $_SERVER['DOCUMENT_ROOT']);
	return true;
}


//пути до фалов где что хрнаиться
function get_product_root_dir() {

	//общие ссылки
	global $root_terminal,
		   $root_stock,
		   $root_report,
		   $rasxod_link;

	//terminal 
	global $terminal_phone_link,
		   $terminal_akss_link;

    //stock
    global $stock_phone_link,
    	   $stock_akss_link;

    //report
   	global $report_phone_link,
   		   $report_akss_link;

   	//note+reminder
    global $note_order_link,    
		   $note_reminder_link; 		   

   	//menu
    global $menu_link_for_terminal,	
		   $menu_link_for_stock,	
		   $menu_link_for_report,   
		   $menu_link_for_note,     
		   $menu_link_for_raxdod,   
		   $menu_link_for_recycle; 

	//путь к папке где храняться вкладки
	$root_product_dir = 'page';

	//пусть к папке вклдаки 
	//категории терминал
	$root_terminal 	= 	'terminal';
	//категория stock
	$root_stock 	= 	'stock';
	//категория report
	$root_report	=	'report';


	//конечная на терминал 
	$terminal_phone_link   =	'/page/terminal/terminal_phone.php';
	$terminal_akss_link    =	'/page/terminal/terminal_akss.php';

	//конечная на склад
	$stock_phone_link	   =   	'/page/stock/stock_phone.php';
	$stock_akss_link	   =	'/page/stock/stock_akss.php';

	//конечная на отчет
	$report_phone_link     =	'/page/report/report_phone.php';
	$report_akss_link      =	'/page/report/report_akss.php';


	//ссылка на бокнот
	$note_order_link       =    '/page/note/note_order.php';
	$note_reminder_link    =    '/page/note/reminder.php';

	//ссылка на расход
	$rasxod_link 		   =    '/page/rasxod/rasxod.php';

	//конечные ссылки для меню
	$menu_link_for_terminal	=	'/page/terminal/terminal.php';
	$menu_link_for_stock	=	'/page/stock/stock.php';
	$menu_link_for_report   =   '/page/report/report.php';
	$menu_link_for_note     =   '/page/note/note.php';
	$menu_link_for_raxdod   =   '/page/rasxod/rasxod.php';
	$menu_link_for_recycle  =   'recycle.php';

}



//функция которая выводит кнопки для переключения вкладок 
function getCurrentTab($tab1, $tab2) {
	// data-tab-open="" - содержит класс вкладки, которы йнужно открыть 
?>
<div class="tab_option">
	<div class="tab_change_box">
		<div class="tab_select_box">
			<a href="javascript:void(0)" class="tab_activ phone_select tab_select_link flex-cntr" data-tab-open="<?php echo $tab1; ?>">Telefonlar</a>
		</div>
		<div class="tab_select_box">
			<a href="javascript:void(0)" class="akss_select tab_select_link flex-cntr" data-tab-open="<?php echo $tab2; ?>">Aksesuar</a>
		</div>
		<div class="tab_selected_bcg btn"></div>
	</div>
</div>
	
<?php 
	return true;
}


//получем категорию товара
function get_product_category() {
	global $product_phone, 	
		   $product_akss,	
		   $product_service,
		   $note_category;
	
	//телефоны
	$product_phone 		= 	'phone';

	//акссесуары
	$product_akss  		= 	'akss';            

	//услуги 
	$product_service 	= 	'service';

	//note
	$note_category 	 	= 	'order_note';

	return $product_phone;
	return $product_akss;
	return $product_service;
}

//тип таблицы (terminal, stock, report и тд)
function get_table_svervice_type() {
	global $terminal,		 
		   $stock,
		   $report,
		   $note,
		   $rasxod;

	//таблица терминала(продажи товаров)
	$terminal = 'terminal';
	//табдлица склада товаров где они храняться 	
	$stock    = 'stock';
	//таблица отчета		
	$report   = 'report';
	//note
	$note     = 'note';		
	//reminder
	$rasxod   = 'rasxod';

	return $terminal; 
	return $stock;
	return $report;
	return $note;
	return $rasxod;
}



//шаблон поиска
//product_type - terminal, stock, report
//product_cat -  product_phone/akss
function search_input($product_type, $product_cat) {
?>
	<div class="view_stock_search flex-cntr">
		<input type="search" placeholder="Axtar" autocomplete="off" id="get_item_stock_action" data-stock-src="<?php echo  $product_type; ?>" class="search_stock_input_action search_input" data-category="<?php echo $product_cat; ?>" data-sort="search">

		<div class="reset_akss_search_b">
			<a href="javascript:void(0)" class="reset_stock_view_search_action reset_akss_search_style btn">Geri</a>
		</div>
	</div>

<?php	
}
 

//шаблон таблицы для терминала телефонов
function get_terminal_phone_table_row($get_product_table) {
	$stock_id 				= $get_product_table['stock_id'];			
	$stock_name 			= $get_product_table['stock_name'];		
	$stock_imei 			= $get_product_table['stock_phone_imei'];		
	$stock_first_price 		= $get_product_table['stock_first_price'];	
	$stock_second_price		= $get_product_table['stock_second_price'];
	$stock_return_status	= $get_product_table['stock_return_status'];
	$stock_provider			= $get_product_table['stock_provider'];	
	$manat_image			= $get_product_table['manat_image'];
	$stock_return_image 	= $get_product_table['stock_return_image'];
?>
	<tr class="stock-list" id="<?php echo $stock_id; ?>">

	  <td class="col-w60 table_stock table_stock_id_box">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_id ?> </span> 
	  	</a>
	  </td>

	  <td class="col-w250">
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action">
	  		<span class="stock_info_text"> <?php echo trim($stock_name); ?> </span> 
	  	</a>
	  </td>

	  <td class="col-w250 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_imei ?> </sapn>
	  	</a>
	  </td>	

	  <td class="col-w80 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_first_price; ?> </span>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>

	  <td class="col-w80 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_second_price; ?> </span>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>

	  <td class="col-w120">
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action">
	  		<span class="stock_info_text"> <?php echo trim($stock_provider); ?> </span> 
	  	</a>
	  </td>

	  <td class="col-w60">	
		<?php
		//значение возврата ->  0 - дефолт, 1 - возврат
		$v = $stock_return_status;
		echo ($v == 1) ? $stock_return_image : ' ';		
		?>
	  </td>	

	</tr>

<?php 
}



//шаблон таблицы для терминала акссесуаров
function get_terminal_akss_table_row($get_product_table) {
	$stock_id 				= $get_product_table['stock_id'];			
	$stock_name 			= $get_product_table['stock_name'];				
	$stock_first_price 		= $get_product_table['stock_first_price'];	
	$stock_second_price		= $get_product_table['stock_second_price'];
	$stock_count			= $get_product_table['stock_count'];
	$stock_provider			= $get_product_table['stock_provider'];	
	$manat_image			= $get_product_table['manat_image'];
?>

	<tr class="stock-list" id="<?php echo $stock_id; ?>">
	  <td class="table_stock table_stock_id_box">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_id ?> </span> 
	  	</a>
	  </td>
	  <td>
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action">
	  		<span class="stock_info_text"> <?php echo trim($stock_name); ?> </span> 
	  	</a>
	  </td>				    
	  <td class="table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_first_price; ?> </span>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>
	  <td class="table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_second_price; ?> </span>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>
	  <td class="table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text ter_stock_count"> <?php echo $stock_count; ?></span>
	  		<span class="mark mark--count"> ədəd</span>
	  	</a>
	  </td>	  
	  <td>
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action">
	  		<span class="stock_info_text"> <?php echo trim($stock_provider); ?> </span> 
	  	</a>
	  </td>	  
	</tr>

<?php 
}


//шаблон таблицы для СКЛАДА телефонов
function get_stock_phone_table_row($get_product_table ) {

	$stock_id 				= $get_product_table['stock_id'];
	$stock_date             = $get_product_table['stock_date'];		
	$stock_name 			= $get_product_table['stock_name'];
	$stock_imei             = $get_product_table['stock_imei'];				
	$stock_first_price 		= $get_product_table['stock_first_price'];	
	$stock_second_price		= $get_product_table['stock_second_price'];
	$stock_provider			= $get_product_table['stock_provider'];	
	$manat_image			= $get_product_table['manat_image'];
	$return_image           = $get_product_table['stock_return_image'];
	//дата $new_stock_date
 ob_start();
?>
	<tr class="stock-list" id="<?php echo $stock_id; ?>">

	  <td class="table_stock table_stock_id_box">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_id ?> </span> 
	  	</a>
	  </td>

	  <td>
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action">
	  		<span class="stock_info_text"> <?php echo trim($stock_date); ?> </span> 
	  	</a>
	  </td>

	  <td>
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action">
	  		<span class="stock_info_text s_result_name"> <?php echo trim($stock_name); ?> </span> 
	  	</a>
	  </td>	

	  <td class="table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text s_result_imei"> <?php echo $stock_imei; ?> </sapn>
	  	</a>
	  </td>	

	  <td class="table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text s_result_fprice"> <?php echo $stock_first_price; ?> </span>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>

	  <td class="table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text s_result_sprice"> <?php echo $stock_second_price; ?> </span>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>

	  <td>
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action">
	  		<span class="stock_info_text s_result_provider"> <?php echo trim($stock_provider); ?> </span> 
	  	</a>
	  </td>

	  <td>
	  	<?php echo $return_image; ?>
	  </td>

	</tr>
<?php
    $result = ob_get_clean();
 
    return $result;
}





//шаблон таблицы для СКЛАДА акссесуаров
function get_stock_akss_table_row($get_product_table ) {

	$stock_id 				= $get_product_table['stock_id'];
	$stock_date             = $get_product_table['stock_date'];		
	$stock_name 			= $get_product_table['stock_name'];			
	$stock_count 			= $get_product_table['stock_count'];			
	$stock_first_price 		= $get_product_table['stock_first_price'];	
	$stock_second_price		= $get_product_table['stock_second_price'];
	$stock_provider			= $get_product_table['stock_provider'];	
	$manat_image			= $get_product_table['manat_image'];
	$red 					= '';

	if($stock_count <= 0) {
		$red = 'red';
	}

	//дата $new_stock_date
 ob_start();
?>
	<tr class="stock-list" id="<?php echo $stock_id; ?>">

	  <td class="table_stock table_stock_id_box">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_id ?> </span> 
	  	</a>
	  </td>

	  <td>
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action">
	  		<span class="stock_info_text"> <?php echo trim($stock_date); ?> </span> 
	  	</a>
	  </td>

	  <td>
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action">
	  		<span class="stock_info_text s_result_name"> <?php echo trim($stock_name); ?> </span> 
	  	</a>
	  </td>	

	  <td class="table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text s_result_fprice"> <?php echo $stock_first_price; ?> </span>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>

	  <td class="table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text s_result_sprice"> <?php echo $stock_second_price; ?> </span>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>

	  <td class="table_stock <?php echo $red; ?>">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text s_result_count"> <?php echo $stock_count; ?> </span>
	  		<span class="mark mark--count"> ədəd</span>
	  	</a>
	  </td>

	  <td>
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action">
	  		<span class="stock_info_text s_result_provider"> <?php echo trim($stock_provider); ?> </span> 
	  	</a>
	  </td>

	</tr>
<?php
    $result = ob_get_clean();
 
    return $result;
}





//шаблон таблицы для ОТЧЕТА телефонов
function get_report_phone_tamplate($get_product_table) {
	$stock_id 			= $get_product_table['stock_id'];			
	$order_date 		= $get_product_table['order_date'];		
	$stock_name 		= $get_product_table['stock_name'];		
	$stock_imei 		= $get_product_table['stock_imei'];	
	$stock_sprice 		= $get_product_table['stock_sprice'];
	$stock_provider 	= $get_product_table['stock_provider'];
	$stock_count 		= $get_product_table['stock_count'];	
	$order_who_buy 		= $get_product_table['order_who_buy'];
	$stock_profit 		= $get_product_table['stock_profit'];
	$manat_image 		= $get_product_table['manat_image'];
?>
	<tr class="stock-list" id="<?php echo $stock_id; ?>">

	  <td class="col-w60 table_stock table_stock_id_box">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_id ?> </span> 
	  	</a>
	  </td>

	  <td class="col-w120">
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action" data-sort="date">
	  		<span class="stock_info_text"> <?php echo trim($order_date); ?> </span> 
	  	</a>
	  </td>

	  <td class="col-w250">
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action" data-sort="name">
	  		<span class="stock_info_text"> <?php echo trim($stock_name); ?> </span> 
	  	</a>
	  </td>

	  <td class="col-w250 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_imei ?> </sapn>
	  	</a>
	  </td>	

	  <td class="col-w80 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_sprice; ?> </span>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>

	  <td class="col-w120">
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action" data-sort="provider">
	  		<span class="stock_info_text"> <?php echo trim($stock_provider); ?> </span> 
	  	</a>
	  </td>


	  <td class="col-w80 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block" title="<?php echo $order_who_buy; ?>"> 
	  		<span class="stock_info_text"> <?php echo $order_who_buy ?> </sapn>
	  	</a>
	  </td>	

	  <td class="col-w80 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_count ?> </sapn>
	  	</a>
	  </td>	

	  <td class="col-w120 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_profit ?> </sapn>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>	

	</tr>

<?php 
}



//шаблон таблицы для ОТЧЕТА акссесуаров
function get_report_akks_tamplate($get_product_table) {
	$stock_id 			= $get_product_table['stock_id'];			
	$order_date 		= $get_product_table['order_date'];		
	$stock_name 		= $get_product_table['stock_name'];	
	$stock_sprice 		= $get_product_table['stock_sprice'];
	$stock_provider 	= $get_product_table['stock_provider'];
	$stock_count 		= $get_product_table['stock_count'];	
	$order_who_buy 		= $get_product_table['order_who_buy'];
	$stock_profit 		= $get_product_table['stock_profit'];
	$manat_image 		= $get_product_table['manat_image'];
?>
	<tr class="stock-list" id="<?php echo $stock_id; ?>">

	  <td class="col-w60 table_stock table_stock_id_box">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_id ?> </span> 
	  	</a>
	  </td>

	  <td class="col-w120">
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action" data-sort="date">
	  		<span class="stock_info_text"> <?php echo trim($order_date); ?> </span> 
	  	</a>
	  </td>

	  <td class="col-w250">
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action" data-sort="name">
	  		<span class="stock_info_text"> <?php echo trim($stock_name); ?> </span> 
	  	</a>
	  </td>

	  <td class="col-w120 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_sprice; ?> </span>
	  		<span class="mark"> <?php echo $manat_image; ?> </span>
	  	</a>
	  </td>

	  <td class="col-w80">
	  	<a href="javascript:void(0)" class="stock_name_box_link_btn get_item_stock_action" data-sort="provider">
	  		<span class="stock_info_text"> <?php echo trim($stock_provider); ?> </span> 
	  	</a>
	  </td>


	  <td class="col-w80 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block" title="<?php echo $order_who_buy; ?>"> 
	  		<span class="stock_info_text"> <?php echo $order_who_buy ?> </sapn>
	  	</a>
	  </td>

	  <td class="col-w80 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_count ?> </sapn>
	  	</a>
	  </td>	

	  <td class="col-w120 table_stock">
	  	<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"> <?php echo $stock_profit ?> </sapn>
	  	</a>
	  </td>	

	</tr>


<?php
}




// //дефолтная вкладка  терминал 
// function get_default_terminal_tab() {
// 	// $default_tab = 'terminal_phone.php';
// 	// define('get_default_terminal_tab',$default_tab);
// 	require_once '/terminal_phone';
// }

// //дефолтная вкладка  склада 
// function get_default_stock_tab() {
// 	$default_tab = 'stock_phone.php';
// 	define('get_default_stock_tab',$default_tab);
// }


//модальное окно успешно выполнено функция
function success_done() {
?>
	<div class="success_notify"></div>
<?php
}

//модальное коно ошибка выполнено функция
function fail_notify() {
?>
	<div class="fail_notify red"></div>
<?php
}


//модально окно для оформения заказа
function get_modal_tamplate_checkout_tem() {
?>
	<div class="module_fix_right_side">
		<div class="close_modal_btn"><img src="/img/icon/cancel-black.png"></div>
		<div class="modal_view_stock_order">
			Hello world
		</div>
	</div>

<?php
}


//шаблон оформления заказа - телефон
function order_terminal_template_phone( $give_product_id,
								  		$o_product_name,
								  		$o_product_imei ) {
?>


<div class="module_order_wrp">

	<ul class="modal_order_form" data-order-id="<?php echo $give_product_id; ?>">

		<li class="order_modal_list">
			<span class="module_order_desrioption">Malın adı: </span>
			<span class="module_stock_span_name"><?php echo $o_product_name; ?></span>
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">IMEI: </span>
			<span class="module_stock_span_imei"><?php echo $o_product_imei; ?></span>
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Qeyd: </span>
			<input type="text" class="module_stock_input_whobuy order_input order_note_action" placeholder="Ad...">
		</li>	

		<li class="order_modal_list">
			<span class="module_order_desrioption">Malın qiyməti: </span>
			<input type="num" autocomplete="off" class="order_price_stock order_input order_price_action" placeholder="0">
			<input type="hidden"  class="order_count_action" value="1">	
		</li>

		<li class="order_modal_list">
			<div class="order_total_wrp">
				<a href="javascript:void(0)" class="order_total_btn_style btn get_order_action">Satış</a>
			</div>
		</li>

	</ul>

	<div class="order_resault"></div>
</div>


<?php	
}


//шаблон оформления заказа - акссесуар
function order_terminal_template_akss( $give_product_id,
								  	   $o_product_name ) {

?>

<div class="module_order_wrp">

	<ul class="modal_order_form" data-order-id="<?php echo $give_product_id; ?>">

		<li class="order_modal_list">
			<span class="module_order_desrioption">Malın adı: </span>
			<span class="module_stock_span_name"><?php echo $o_product_name; ?></span>
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Qeyd: </span>
			<input type="text" class="module_stock_input_whobuy order_input order_note_action" placeholder="Ad...">
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Malin sayi: </span>
			<input type="text" autocomplete="off" class="order_input order_stock_count_style order_count_action" value="1">	
		</li>	

		<li class="order_modal_list">
			<span class="module_order_desrioption">Malin qiymeti: </span>
			<input type="num" autocomplete="off" class="order_input order_price_stock order_price_action" >		
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Cemi:</span>
			<span class="show_total_sum_order_action order_input order_total_sum_style">0</span>
			<input type="hidden"class="total_sum_order_stock">			
		</li>	

		<li class="order_modal_list">
			<div class="order_total_wrp">
				<a href="javascript:void(0)" class="order_total_btn_style btn get_order_action">Satış</a>
			</div>
		</li>

	</ul>

	<div class="order_resault"></div>
</div>


<?php
}



//шаблон редактирования продукта -  телефон sklad
function update_stock_phone_tamplate($get_prod_upd) {

$edit_stock_id 				= $get_prod_upd['edit_stock_id'];	
$edit_stock_name 			= $get_prod_upd['edit_stock_name'];		
$edit_stock_imei 			= $get_prod_upd['edit_stock_imei'];		
$edit_stock_provider 		= $get_prod_upd['edit_stock_provider'];			
$manat_image 				= $get_prod_upd['manat_image'];		
$edit_stock_fprice 			= $get_prod_upd['edit_stock_fprice'];			
$edit_stock_sprice 			= $get_prod_upd['edit_stock_sprice'];			
$edit_stock_count 			= $get_prod_upd['edit_stock_count'];			

?>


<div class="delete_stock_module">
	<div class="receipet_success">
		<a><img src="img/icon/print-success.png"></a>
	</div>
	<div class="delete_stock_form">
		<span>Silmək istədiyinizə əminsiniz ?</span>
		<div class="module_delete_btn_link">
			<a href="javascript:void(0)" class="module_delete_btn" id="<?php echo $edit_stock_id; ?>"> Sil</a>
			<a href="javascript:void(0)" class="module_delete_btn_cancle"> Ləğv et</a>
		</div>
	</div>
</div>

<div class="module_order_wrp">
	<ul class="modal_order_form" data-order-id="<?php echo $edit_stock_id; ?>">

		<li class="order_modal_list">
			<span class="module_order_desrioption">Ad: </span>
			<input type="text" class="edit_stock_input edit_sotck_name_input" value="<?php echo $edit_stock_name; ?>" >
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">IMEI </span>
			<input type="text" class="edit_stock_input edit_stock_imei_input" value="<?php echo $edit_stock_imei; ?>" >
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Təchizatçı</span>
			<input type="text" class="edit_stock_input edit_stock_provider_input" value="<?php echo $edit_stock_provider; ?>" >
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Alış qiyməti(<?php echo $manat_image; ?> ): </span>
			<input type="text" class="order_input order_price_action edit_stock_input edit_sotck_fprice_input" value="<?php echo $edit_stock_fprice; ?>" >
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Satış qiyməti(<?php echo $manat_image; ?> ): </span>
			<input type="text" class="edit_stock_input edit_stock_sprice_input" value="<?php echo $edit_stock_sprice; ?>" >
		</li>

		<input type="hidden" class="upd_product_count" value="<?php echo $edit_stock_count; ?>">

		<li class="edit_btn_wrp">
			<a href="javascript:void(0)" class="delete_btn_link btn">Sil</a>
			<a href="javascript:void(0)" class="edit_upd_btn_link btn edit_stock_action">Saxla</a>
		</li>	

	</ul>

</div>	


<?php		
}



//шаблон редактирования продукта -  акссесуаров sklad
function update_stock_akss_tamplate($get_prod_upd) {

$edit_stock_id 				= $get_prod_upd['edit_stock_id'];	
$edit_stock_name 			= $get_prod_upd['edit_stock_name'];		
$edit_stock_provider 		= $get_prod_upd['edit_stock_provider'];			
$manat_image 				= $get_prod_upd['manat_image'];		
$edit_stock_fprice 			= $get_prod_upd['edit_stock_fprice'];			
$edit_stock_sprice 			= $get_prod_upd['edit_stock_sprice'];			
$edit_stock_count 			= $get_prod_upd['edit_stock_count'];			

?>

<div class="delete_stock_module">
	<div class="receipet_success">
		<a><img src="img/icon/print-success.png"></a>
	</div>
	<div class="delete_stock_form">
		<span>Silmək istədiyinizə əminsiniz ?</span>
		<div class="module_delete_btn_link">
			<a href="javascript:void(0)" class="module_delete_btn" id="<?php echo $edit_stock_id; ?>"> Sil</a>
			<a href="javascript:void(0)" class="module_delete_btn_cancle"> Ləğv et</a>
		</div>
	</div>
</div>

<div class="module_order_wrp">
	<ul class="modal_order_form" data-order-id="<?php echo $edit_stock_id; ?>">

		<li class="order_modal_list">
			<span class="module_order_desrioption">Ad: </span>
			<input type="text" class="edit_stock_input edit_sotck_name_input" value="<?php echo $edit_stock_name; ?>" >
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Kategoriya: </span>
			<input type="text" class="edit_stock_input edit_stock_provider_input" value="<?php echo $edit_stock_provider; ?>" >
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Alış qiyməti(<?php echo $manat_image; ?> ): </span>
			<input type="text" class="order_input order_price_action edit_stock_input edit_sotck_fprice_input" value="<?php echo $edit_stock_fprice; ?>" >
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Satış qiyməti(<?php echo $manat_image; ?> ): </span>
			<input type="text" class="edit_stock_input edit_stock_sprice_input" value="<?php echo $edit_stock_sprice; ?>" >
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Say: </span>
			<input type="text" class="edit_stock_input edit_stock_count_style upd_product_count" value="<?php echo $edit_stock_count; ?>">
		</li>

		<li class="order_modal_list edit_stock_count_add" style="opacity: 0.5">
			<a href="javascript:void(0)" title="Əlavə etmək" class="edit_custom_count edit_stock_add_count_ebable">
				<img src="img/icon/plus.png">
			</a>
			<span class="module_order_desrioption">Əlavə etmək(ədəd): </span>
			<span class="stock_add_mark_plus">+</span>
			<input type="text" disabled="" class="edited_custom_stock_count edit_stock_input edit_count_plus" placeholder="0">
		</li>	

		<div class="order_modal_list edit_stock_count_minus" style="opacity: 0.5">
			<a href="javascript:void(0)" title="Azaltmaq" class="edit_custom_count edit_stock_remove_count_ebable">
				<img src="img/icon/plus.png">
			</a>		
			<span class="module_order_desrioption">Azaltmaq</span>				
			<span class="minus_stock_count_mark">-</span>
			<input type="text" disabled="" class="edited_custom_stock_count edit_stock_input edit_count_minus">
		</div>

		<li class="edit_btn_wrp">
			<a href="javascript:void(0)" class="delete_btn_link btn">Sil</a>
			<a href="javascript:void(0)" class="edit_upd_btn_link btn edit_stock_action">Saxla</a>
		</li>	

	</ul>

</div>	


<?php		
}




//если товар есть в базе
function add_product_available($product_id) {
	global $add_stock_available;
$add_stock_available = '
<div class="add_stock_module_error">
	<div class="close_modal_btn_error close_error_module_action"><img src="img/icon/cancel-white.png"></div>
	<div class="module moudle_erro_imei_availible">
		<div class="module_cwrp">
			<div class="module_hdr">Bu product movcudur</div>
			<div class="module_err_option">
				<div  class="hide_stock_list stock-list" id="'.$product_id.'">
					<a href="javascript:void(0)" class="table_stock error_imei_btn close_error_module_action">Redaktə edin <span><img src="img/icon/edit-rasxod.png"></span>
					</a>
				</div>	
			</div>
		</div>
	</div>
</div>';

return 	$add_stock_available;
}



//rpoert - фильт по дате
function filt_report_date($type, $dbpdo, $currenDate, $sort_from) {
?>
<div class="report_date_select_wrp">
	<div class="report_date_select_box">
		<div class="report_date_fotm">
			<label for="report_options_list">Tarix: </label>
			<select class="report_options_list select_option_data" id="report_options_list" data-sort="full_date">
			<option value="<?php echo $currenDate; ?>">-</option>
			<?php
			if($sort_from == 'report') {
				$report_order_select = [];
				
				$report_select_opt = $dbpdo->prepare("SELECT DISTINCT order_my_date
				 FROM stock_order_report 
				 WHERE stock_type =:stock_type
				 AND stock_order_visible = 0
				 ORDER BY order_my_date ASC");
				$report_select_opt->bindParam('stock_type', $type);
				$report_select_opt->execute();
				

				while($report_select_row = $report_select_opt->fetch(PDO::FETCH_BOTH))
					$report_order_select[] = $report_select_row;

				foreach ($report_order_select as $report_select_row)
				{
					$date_options_value = $report_select_row['order_my_date'];
					echo '<option value="'.$date_options_value.'">'.$date_options_value.'</option>';

				}			
			} 
			if($sort_from == 'note') {
				$report_order_select = [];
				
				$report_select_opt = $dbpdo->prepare("SELECT DISTINCT order_stock_date
				 FROM no_availible_order 
				 WHERE note_type = :stock_type
				 AND order_stock_visible = 0
				 ORDER BY order_stock_date ASC");
				$report_select_opt->bindParam('stock_type', $type);
				$report_select_opt->execute();
				

				while($report_select_row = $report_select_opt->fetch(PDO::FETCH_BOTH))
					$report_order_select[] = $report_select_row;

				foreach ($report_order_select as $report_select_row)
				{
					$date_options_value = $report_select_row['order_stock_date'];
					echo '<option value="'.$date_options_value.'">'.$date_options_value.'</option>';

				}			
			}
			?>
			</select>				
		</div>
	</div>
</div>
<?php
}

function get_total_all_profit_phone($dbpdo, $order_myear, $product_category, $manat_image) {
		$order_myear = trim($order_myear);
		$product_category = trim($product_category);

	$arr_price = [];
	$arr_count = [];
	$getOptionNameList = [];

		//делае выборку и получем вырычку
		$check_total_price = $dbpdo->prepare("SELECT *
			FROM stock_order_report,stock_list
			WHERE stock_order_report.order_my_date = :mydateyear
			AND stock_order_report.stock_type = :product_cat
			AND stock_order_report.stock_order_visible = 0
			AND stock_order_report.order_stock_count > 0

			OR  stock_order_report.order_date = :mydateyears
			AND stock_order_report.stock_type = :product_cats
			AND stock_order_report.stock_order_visible = 0
			AND stock_order_report.order_stock_count > 0

			OR  stock_order_report.order_stock_name LIKE :filtr_name1
			AND stock_order_report.order_my_date = stock_order_report.order_my_date
			AND stock_order_report.stock_type = :product_cats1
			AND stock_order_report.stock_order_visible = 0
			AND stock_order_report.order_stock_count > 0

			OR stock_list.stock_provider
			LIKE :filtr_name2  
			AND stock_order_report.stock_id = stock_list.stock_id
			AND stock_order_report.stock_order_visible = 0
			AND stock_order_report.stock_type = :product_cats3	
			AND stock_order_report.order_stock_count > 0

			GROUP BY stock_order_report.order_stock_id DESC
			ORDER BY stock_order_report.order_stock_id DESC
			");
		$check_total_price->bindParam('mydateyear', $order_myear, PDO::PARAM_INT);
		$check_total_price->bindParam('product_cat', $product_category, PDO::PARAM_INT);
		$check_total_price->bindParam('mydateyears', $order_myear, PDO::PARAM_INT);
		$check_total_price->bindParam('product_cats', $product_category, PDO::PARAM_INT);
		$check_total_price->bindParam('product_cats1', $product_category, PDO::PARAM_INT);			
		$check_total_price->bindParam('product_cats3', $product_category, PDO::PARAM_INT);			
		$check_total_price->bindValue('filtr_name1', "%{$order_myear}%");
		$check_total_price->bindValue('filtr_name2', "%{$order_myear}%");
		$check_total_price->execute();
		// $check_total_price_row = $check_total_price->fetch();
		//выручка на за месяц
		// $total_price_money =  round($check_total_price_row['total_money'], 2);
		// var_dump($total_price_money, $order_myear);
		
		while($check_total_price_row = $check_total_price->fetch(PDO::FETCH_BOTH))
			$getOptionNameList[] = $check_total_price_row;
		foreach ($getOptionNameList as $check_total_price_row) {
			//получем выручку товара
			$order_total_profit = $check_total_price_row['order_total_profit'];
			//количество товара
			$order_total_count  = $check_total_price_row['order_stock_count'];

			
			//добавляем в масив и потом сичитаем общую сумму
			$arr_total_price[] = $order_total_profit;
			//добавляем в массив количестов товара
			$arr_total_count[] = $order_total_count;
		}
		//получаем общую сумму выручки
		$total_price_money = array_sum($arr_total_price);
		//общее количество товра
		$total_stock_count = array_sum($arr_total_count);


		//получаем сумму расхода ха текущий меясц
		$check_total_rasxod = $dbpdo->prepare("SELECT sum(rasxod_money) 
			as total_rasxod 
			FROM rasxod 
			WHERE rasxod_year_date = :mydateyear
			AND rasxod_visible = 0
			
			OR rasxod_day_date = :mydateyear2
			AND rasxod_visible = 0");
		$check_total_rasxod->bindParam('mydateyear', $order_myear, PDO::PARAM_INT);
		$check_total_rasxod->bindParam('mydateyear2', $order_myear, PDO::PARAM_INT);
		$check_total_rasxod->execute();
		$check_total_rasxod_row = $check_total_rasxod->fetch();
		//расход за месяц
		$total_rasxod_value = round($check_total_rasxod_row['total_rasxod'], 2);
		//если категория товара телфон тогда учитываем расходи а ессли ассесуар то - нет
		if($product_category == 'phone') {
			//из выручки вычитаем сумму расхода
			$final_total_price = $total_price_money - $total_rasxod_value;
		}
		if($product_category == 'akss') {
			$final_total_price = $total_price_money;
		}

		
?>
<tr class="total_value_table">
	<td style="text-align:right">
		<span><?php echo $total_stock_count; ?></span>
		<span class="mark mark--count"> ədəd</span>
	</td>							
	<td style="text-align:right" title="xərcsiz xeyir: <?php echo $total_price_money; ?>">
		<span><?php echo $final_total_price; ?></span>
		<span class="mark"><?php echo $manat_image; ?></span>
	</td>
</tr>
<?php
}



//модальное окно редактирования для отчёта report

function get_report_order_modal($give_product_id, $return_product_id, $return_product_count) {
	//если количество больше 1 то активируем инпут инчае дективируем
	if($return_product_count == 1) {
		$attr = 'disabled';
	} else {
		$attr = 'enabled';
	}


?>


<div class="module_order_wrp">
	<div class="receipet_success">
		<a><img src="img/icon/print-success.png"></a>
	</div>

	<div class="modal_order_form">

		<div class="order_modal_list return_list">
			<div class="return_modal_list">
				<span class="module_order_desrioption">Vazvrat edin</span>
				<input type="text" class="order_input return_input_action return_input_style" <?php echo $attr; ?> value="<?php echo $return_product_count; ?>" data-report-id="<?php echo $return_product_id; ?>" data-prod-id="<?php echo $give_product_id; ?>">
			</div>
			<div class="return_modal_list">
				<a href="javascript:void(0)" class="btn get_return_accept_btn get_return_accept_style">OK</a>
			</div>	
		</div>
		<div class="order_modal_list return_list">
			<span class="module_order_desrioption">Hesabatı silmək</span>
			<a href="javascript:void(0)" class="delete_btn_link btn">Silmək</a>
		</div>

		<div class="delete_stock_module">
			<div class="receipet_success">
				<a><img src="img/icon/print-success.png"></a>
			</div>
			<div class="delete_stock_form">
				<span>Silmək istədiyinizə əminsiniz ?</span>
				<div class="module_delete_btn_link">
					<a href="javascript:void(0)" class="delete_report" id="<?php echo $give_product_id; ?>"> Sil</a>
					<a href="javascript:void(0)" class="module_delete_btn_cancle"> Ləğv et</a>
				</div>
			</div>
		</div>

	</div>

</div>

<?php 
}



//подсчет количества товаров в склдае акссесуаров

function getTotalPriceSellStock($stock_type) {
	global $dbpdo;
	$arr = [];
	$getOptionNameList = [];
	$getOptionName = $dbpdo->prepare("SELECT * 
		FROM stock_list 
		WHERE stock_type = :stock_type
		AND stock_visible = 0");
	$getOptionName->execute([$stock_type]);

	while($getOptionRow = $getOptionName->fetch(PDO::FETCH_BOTH))
		$getOptionNameList[] = $getOptionRow;
	foreach ($getOptionNameList as $getOptionRow) {

		$stock_count = $getOptionRow['stock_count'];
		$stock_first_price = $getOptionRow['stock_first_price'];

		$res = $stock_count * $stock_first_price;
		
		$arr[] = $res;


	}
		echo array_sum($arr);


}









////////deeeeeeeeeeeeeeeeeeeeeeeeeeeellllllll this updet uner this comment//////////////////


function get_note_list($get_note) {
	$note_id 			= $get_note['note_id'];
	$note_date 			= $get_note['note_date'];
	$note_name 			= $get_note['note_name'];
	$note_descrpt 		= $get_note['note_descrpt'];
	ob_start();

?>
<tr class="note_table" id="<?php echo $note_id ?>">
	<td class="note_list col-w60">
		<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text"><?php echo $note_id; ?></span>
	  	</a>
	</td>	
	<td class="note_list col-w120">
		<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text note_date_a"><?php echo $note_date; ?></span>
	  	</a>		
	</td>
	<td class="note_list col-w250">
		<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text note_name_a"><?php echo $note_name; ?></span>
	  	</a>		
	</td>
	<td class="note_list col-w350">
		<a href="javascript:void(0)" class="stock_info_link_block"> 
	  		<span class="stock_info_text note_descrpt_a"><?php echo $note_descrpt; ?></span>
	  	</a>		
	</td>
</tr>	
<?php
    $result = ob_get_clean();
 
    return $result;
}



function getReminerList() {
		global $dbpdo;
		$note_reminder_list = [];
		$note_reminer_view = $dbpdo->prepare("SELECT * FROM no_availible_order 
			WHERE order_stock_visible = 0 AND
			note_type = 'order_reminder'
			GROUP BY order_stock_id DESC");
		$note_reminer_view->execute();

		while ($order_reminder_row = $note_reminer_view->fetch(PDO::FETCH_BOTH))
			$note_reminder_list[] = $order_reminder_row;

		foreach ($note_reminder_list as $order_reminder_row)
		{ ?>
		<tr class="get_reminder_option_action_left_side reminder_list_style" id="<?php echo $order_reminder_row['order_stock_id']; ?>">
			<td class="note_table_list_w3">
				<span><?php echo $order_reminder_row['order_stock_id']; ?></span>
			</td>	
			<td class="note_table_list_w3">
				<span><?php echo $order_reminder_row['order_stock_full_date']; ?></span>
			</td>
			<td>
				<p><?php echo nl2br($order_reminder_row['order_stock_description']); ?></p>
			</td>
		</tr>
	 <?php }		
}

function getReminder() {
	global $dbpdo;
	$user_reminder_date = date("Y-m-d");
	$get_reminder_list = [];
	$getReminder = $dbpdo->prepare("SELECT * FROM no_availible_order 
			WHERE order_stock_visible = 0 
			AND note_type = 'order_reminder'
			AND order_stock_full_date = :reminder_date
			GROUP BY order_stock_id DESC");
	$getReminder->bindParam('reminder_date', $user_reminder_date, PDO::PARAM_STR);
	$getReminder->execute();

	if($getReminder->rowCount()>0) { ?>
		<div class="reminder_wrapper_header">
			 <div class="reminder_hder">
			 	<span class="notify_indcator"></span>
			 	<h3>Напоминание!</h3> 
			 </div>	
		<?php			 	
		while($get_rminder_row = $getReminder->fetch(PDO::FETCH_BOTH))
			$get_reminder_list[] = $get_rminder_row;
		foreach($get_reminder_list as $get_rminder_row) {
			?>
				<div class="reminder_list">
					<div class="reminder_list_content_wrp">
						<div class="reminder_date_cont_hdr">
							<h3><?php echo $get_rminder_row['order_stock_full_date']; ?></h3>
							<div class="close_reminder_header"><a href="javascript:void(0)" id="<?php echo $get_rminder_row['order_stock_id']; ?>" class="reminder_delete_action reminder_delete_hdr"><img src="img/icon/cancel-black.png"></a></div>
						</div>
						<div class="reminder_description_content_wrp">
							<p class="reminder_descrp_content"><?php echo nl2br($get_rminder_row['order_stock_description']) ?></p>
						</div>
					</div>
				</div>
	<?php } ?>
		</div>
	<?php 	
	}
}


function get_rasxod_tr_tamplate($get_rasxod) {

	$rasxod_id 				= $get_rasxod['rasxod_id'];
	$rasxod_day_date 		= $get_rasxod['rasxod_day_date'];
	$rasxod_price 			= $get_rasxod['rasxod_price'];
	$rasxod_descriptuon 	= $get_rasxod['rasxod_descriptuon'];
	$manat_image 			= $get_rasxod['manat_image'];
	ob_start();
?>

<tr class="rasxod_list_tr" id="<?php echo $rasxod_id; ?>">
	<td>
		<a href="javascript:void(0)" class="get_rasxod_date_search"><?php echo trim($rasxod_day_date); ?></a>
	</td>
	<td>
		<span class="get_raxod_price_span" id="rasxod_price_span_<?php echo $rasxod_id; ?>"><?php echo $rasxod_price . $manat_image; ?></span>
	</td>
	<td>
		<span class="get_raxod_price_span" id="rasxpd_descr_info_<?php echo $rasxod_id; ?>"><?php echo nl2br($rasxod_descriptuon); ?></span>
	</td>
</tr>

<?php
 $result = ob_get_clean();
 return $result;
}



function rasxod_order_tamplate($get_rasxod) {

	$rasxod_id 			=  $get_rasxod['rasxod_id']; 		
	$rasxod_vlue		=  $get_rasxod['rasxod_vlue'];		
	$rasxod_description	=  $get_rasxod['rasxod_description'];
	ob_start();
?>
<div class="module_order_wrp">

	<ul class="modal_order_form" data-order-id="<?php echo $rasxod_id; ?>">
		<li class="order_modal_list">
			<span class="module_order_desrioption">Xərc Mebleg: </span>
			<input type="num" autocomplete="off" class="order_price_stock order_input rasxod_order_style rasxod_order_price_action" value="<?php echo $rasxod_vlue; ?>">
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">Tesvir: </span>

			<textarea class="order_price_stock order_input rasxod_order_description_style rasxod_order_description_action"><?php echo $rasxod_description; ?></textarea>
		</li>

		<li class="edit_btn_wrp">
			<a href="javascript:void(0)" class="delete_rasxod_action delete_rasxod_s btn">Sil</a>
			<a href="javascript:void(0)" class="edit_upd_btn_link btn edit_rasxod_action">Saxla</a>
		</li>	
	</ul>

</div>
<?php
	$res = ob_get_clean();
	return $res;
}



//шаблон оформления заказа - телефон
function order_note_template_upd( $give_product_id,
								  	$note_name,
								  	$note_descrpt ) {
?>


<div class="module_order_wrp">

	<ul class="modal_order_form" data-order-id="<?php echo $give_product_id; ?>">

		<li class="order_modal_list">
			<span class="module_order_desrioption">Qeyd: </span>
			<span class="module_stock_span_name">
				<input type="text" class="add_stock_input note_name_upd_actinon" value="<?php echo $note_name; ?>">		
			</span>
		</li>

		<li class="order_modal_list">
			<span class="module_order_desrioption">TƏSVIR: </span>
			<span class="module_stock_span_imei">
				<textarea class="add_stock_input note_descrpt_upd_action" style="width: 100%;"><?php echo $note_descrpt; ?></textarea>
			</span>
		</li>

		<li class="order_modal_list edit_btn_wrp">
			<a href="javascript:void(0)" class="btn red delete_rasxod_s   ">Sil</a>
			<a href="javascript:void(0)" class="edit_upd_btn_link btn save_edit_note">Saxla</a>
		</li>
	</ul>

	<div class="order_resault"></div>
</div>


<?php	
}