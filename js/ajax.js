//- обнова
$(document).ready(function(){

	$('body').on('click', '.header-logo-link', function(){

		$.ajax({
			type: 'POST',
			url: '/core/main/options.php',
			success: (data) => {
				$('.main').html(data);
			}			

		});

	});

});


//меню на главной странице
$(document).ready(function(){
	$('body').on('click', '.select_page_main', function(){
		//смотри в option.php
		//получаем ссылку на страницу
		var getUrl = $(this).attr("data-link"); 
		$.ajax({
			type: 'POST',
			url:  getUrl,
			success: (data) => {
				$('.main').html(data);
				$('.main-option-service').attr("style", "display: block; width: 200px;height: 100%;");
				$('.options-list').attr("style", "display: block;width: 200px;height: auto;");
			}			
		});
	});
});



//сброс поиска
$('body').on('click', '.reset_stock_view_search_action', function() {
    var search_stock = $(this).val();
    var search_input = $('.search_stock_input_action').val('');
	search_item_stock(search_stock);	        
})



//поиск товаров по клику на фильтр 
$('body').on('click', '.get_item_stock_action', function(){
	//делаем поиск по значению 
	var search_item_value = $(this).find('.stock_info_text').text();

	//for report sort data 
	var sort_data = $(this).attr('data-sort');
	search_item_stock(search_item_value, sort_data);
});



//поиск товаров по инпуту
$('body').on('keyup', '.search_stock_input_action', function() {

	var $this = $(this);
	var $delay = 500;

	clearTimeout($this.data('timer'));

	$this.data('timer', setTimeout(function(){
		var search_item_value = $this.val();
		var search_item_value = search_item_value.replace(/\s+/g,' ').trim();

		if(search_item_value.length>2) {
			return search_item_stock(search_item_value)
		}
	}, $delay));	



});


//поиск по дате в отчете
$(document).ready(function(){
	$('body').on('change', '.report_options_list', function(){
		let report_date_value = $(this).val();
		//for report sort data 
		var sort_data = $(this).attr('data-sort');
		search_item_stock(report_date_value,sort_data);
	});
});




//поиск товаров 
function search_item_stock(search_item_value,sort_data) {
	let $search_main_table = $('.stock_list_tbody');
	//тут мы получаем тип таблицы (terminal, stock, report и тд)
	let search_from 		= $search_main_table.attr("data-stock-src");	
	let search_product_cat  = $search_main_table.attr("data-category");

	$('.preloader_wrapper').fadeIn('100').css('display', 'flex');

	$.ajax({
		type: 'POST',
		url: 'search.php',
		data:{
			search_item_value	: search_item_value, 
			search_from			: search_from, 
			search_product_cat  : search_product_cat,
			sort_data 			: sort_data
		},
		success: (data) => {
			//выводим в талицу данные
			$('.stock_list_tbody').html(data);	
			$('.preloader_wrapper').fadeOut('100');
		}			
	});
	console.log('hello world');
}


//получаем данные товара в модальном окне для оформления зазказа
$(document).ready(function(){
	$('body').on('click', '.table_stock', function(){
		//убираем активированный продукт
		remove_selected_product();

		$('.get_order_action').remove('click');

		//получаем табицу что бы в дальнейшем работать с ним
		var $product_table = $('.stock_list_tbody');

		//получаем строку продукта
		var $product_list = $(this).closest('.stock-list');			

		//получаем id проддукта от родительсокого эелемента
		var product_id = $product_list.attr("id");		

		//получем вкладку таблицы (terminal, stock, report)
		var get_product_tab = $product_table.attr("data-stock-src");
		
		//получаем категорию товара (телефоны, аксессуары и тд)
		var get_product_cat = $product_table.attr("data-category");

		console.log(product_id + '\n' + get_product_tab + '\n' + get_product_cat);
		$.ajax({
			type: 'POST',
			url: '/core/modal_action/order.php',

			data:{
				product_id     	  : product_id, 
				get_product_tab   : get_product_tab, 
				get_product_cat   : get_product_cat
			},
			success: (data) => {
				addLeftPaddingModal();
				$product_list.addClass("o_product_selected");
				$('.modal_view_stock_order').html(data);
			}			

		});

	});

});





//оформление заказа
$(document).ready(function(){
	$('body').on('click', '.get_order_action', function(){

	if(!$(this).hasClass('click')){

		$(this).addClass('click');

		//id товара
		var order_product_id = $('.modal_order_form').data("order-id");

		var $order_count_val = $('.order_count_action');

		//количество товра
		var order_product_count = $order_count_val.val();

		//цена продажи
		var order_last_price = $('.order_price_stock').val();

		var order_note = $('.order_note_action').val();

		$.ajax({
			type: 'POST',
			url: '/core/action/add_order.php',

			data: {
				product_id   : order_product_id,	
				product_cont : order_product_count,	
				order_price  : order_last_price,
				order_note   : order_note	
			},
			dataType: 'json',
			success: (data) => {
				//ловим ошибку
				var order_error =  data['error_notify'];

				//если заказ выполнен успешно 
				var order_success = data['order_success'];

				//изменить количество товра если осталось
				var updated_count = +data['updated_count'];

				//скрыть товар если количество 0 
				var upd_hide_stocks = +data['upd_hide_stock'];

				//если есть ошибка
				if(order_error) {
					 show_error_modal(order_error);
				}

				//если выполнен успешно
				if(order_success.length !== 0) {
					//товар в таблце терминала   
					var $get_stock_list = $('.stock-list#' + order_product_id);
					//сколько осталось
					var stock_left_count = updated_count;

					//выводим модально окно о успешной операции и пердаем id товара
					$('.modal_view_stock_order').append(data['successs_modal']);

					//если осталось в базе выводим сколько осталось 
					if(updated_count > 0) {
						$get_stock_list.find('.ter_stock_count').html(stock_left_count);
					} else {
						$get_stock_list.fadeOut();
					}	
				}
				
				console.log(order_success);

			}			

		});
		} 
	});
});





//форма добавления товра в базу
$('body').on('click', '.add_stock_submit', function(){
	if(!$(this).hasClass('click')){

		$(this).addClass('click');

		//таблица
		var $table_stock_list 	= $('.stock_list_tbody');
	
		var $get_prod_name		= $('.add_stock_name_action');
		var $get_prod_imei		= $('.add_stock_imei_action');
		var $get_prodt_count   	= $('.add_stock_count');
		var $get_prod_provider 	= $('.add_stock_provider_action');
		var $get_prod_fprice  	= $('.add_stock_first_price_action');
		var $get_prdot_sprice 	= $('.add_stock_second_price_action');
	
		//получаем категорию сервиса
		var get_cat_type	= $table_stock_list.attr("data-stock-src");
		//получем категорию товара
		var get_prod_type	= $table_stock_list.attr("data-category");
	
		//данные с формы
		//имя товара
		var product_name		= $get_prod_name.val();
		//imei товара
		var product_imei		= $get_prod_imei.val();
		//количество товара
		var product_count   	= $get_prodt_count.val();
		//поставщик/категория (если акссесуар)
		var product_provider 	= $get_prod_provider.val();
		//себестоимость товара
		var product_first_price	= $get_prod_fprice.val();
		//стоимость товара
		var product_price 		= $get_prdot_sprice.val();

		$.ajax({
			type: 'POST',
			url: 'core/action/add_stock.php',

			dataType: 'json',
			data: {
				product_name		: product_name,
				get_cat_type	 	: get_cat_type,
				get_prod_type	 	: get_prod_type,
				product_imei     	: product_imei,
				product_count    	: product_count,
				product_price    	: product_price,
				product_provider 	: product_provider,
				product_first_price : product_first_price
			},
			success: (data) => {
				//собщение если товар добавлен
				var product = data['product'];
				//сообщение модального окна
				var success = data['ok'];
				//вывод ошибки
				var error   = data['error'];

				//если поля пустые
				var empty_input = data['input_empty'];
				//если есть ошибка
				if(error) {
					$('.main').prepend(error);
					if(empty_input) {
						//вызывем модалку ошибки 
						show_error_modal(empty_input);					
					}
				}
				
				//если товар добавлен успешно
				if(success) {
					//добавляем товар в начало таблицы
					$table_stock_list.prepend(product);

					//вызывем модалку success 
					show_success_modal(success);
				}
	
				//очищаем input
				function clearInput() {
					$get_prod_name.val('');	
					$get_prod_imei.val('');	
					$get_prodt_count.val('1'); 
					$get_prod_provider.val('');
					$get_prod_fprice .val('');	
					$get_prdot_sprice.val('');					
				}
				clearInput();
			}			
	
		});
	} else {
		//если кнопка не активна и обезательные поля пустые
		//вызываем функцию ошибки
		var error_text = 'Bütün sahələri doldurun!';
		show_error_modal(error_text);
	}
});



//редактировать товар
$('body').on('click', '.edit_stock_action', function(){

	//получаем таблицу
	var $get_table 			= $('.stock_list_tbody');
	//форма модального окна
	var $modal_form 		= $('.modal_order_form');

	//получем id товара
	var upd_product_id		= $modal_form.attr("data-order-id");
	var prod_category  		= $get_table.attr("data-category");
	//инпуты - 
	//имя продукта
	var product_name  		= 	$('.edit_sotck_name_input').val();
	//imei продукта
	var product_imei  		=   $('.edit_stock_imei_input').val();
	//provider
	var product_provider	=	$('.edit_stock_provider_input').val();
	//себе стоимость
	var product_fprice 		=	$('.edit_sotck_fprice_input').val();
	//цена прожади 
	var product_sprice      =   $('.edit_stock_sprice_input').val();
	//количество товара
	var product_count       =   $('.upd_product_count').val();

	//прибавляем к количеству товара
	var prdocut_count_plus  =   $('.edit_count_plus').val();

	//отнимаем количество товра
	var prdocut_count_minus  =   $('.edit_count_minus').val();

	$.ajax({
		type: 'POST',
		url: 'core/action/update_product.php',
		data:{	
			upd_product_id		: upd_product_id,
			prod_category		: prod_category,
			product_name		: product_name,
			product_imei		: product_imei,
			product_provider 	: product_provider,
			product_fprice 		: product_fprice,
			product_sprice 		: product_sprice,
			product_count 		: product_count,
			prdocut_count_plus  : prdocut_count_plus,
			prdocut_count_minus : prdocut_count_minus
		},
		dataType: "json",
		success: (data) => {
			var error 	= data['error'];
			var success = data['success'];
			if(error) {
				show_error_modal(error);
			}

			if(success) {
				//обн.имя
				// var upd_
				// var upd_name 	= data['upd_name'];
				// var upd_imei 	= data['upd_imei'];
				// var upd_fprice 	= data['upd_fprice'];
				// var upd_sprice 	= data['upd_sprice'];
				// var upd_prov   	= data['upd_provider'];
				// var upd_count 	= data['upd_count'];

				//показываем сообщение о успехе
				
				show_success_modal(success);
				//скрываем сообщение о успехе спустя 4 сек

				var res_name 		=	data['upd_name']; 
				var res_imei 		= 	data['upd_imei'];
				var res_fprice 		= 	data['upd_fprice'];
				var res_sprice 		= 	data['upd_sprice'];
				var res_provider 	= 	data['upd_provider'];
				var res_count 		= 	data['upd_count'];
				//обновляем имя 
				$('.stock-list#'+ upd_product_id).find('.s_result_name').html(res_name);
				$('.stock-list#'+ upd_product_id).find('.s_result_imei').html(res_imei);
				$('.stock-list#'+ upd_product_id).find('.s_result_fprice').html(res_fprice);
				$('.stock-list#'+ upd_product_id).find('.s_result_sprice').html(res_sprice);
				$('.stock-list#'+ upd_product_id).find('.s_result_provider').html(res_provider);
				$('.stock-list#'+ upd_product_id).find('.s_result_count').html(res_count);

			}
		}			

	});

});



//возврат товара
$(document).ready(function(){
	$('body').on('click', '.get_return_accept_btn', function(){
		var $return_input_value = $('.return_input_action');

		var product_count = $return_input_value.val();
		var product_report_id = $return_input_value.attr('data-report-id');
		var product_id = $return_input_value.attr('data-prod-id');


		$.ajax({
			type: 'POST',
			url: 'core/action/return_report.php',
			dataType: 'json',
			data: {
				product_count : product_count,
				product_report_id : product_report_id,
				product_id : product_id
			},
			success: (data) => {

				if(data['ok']) {
					$('.stock-list#' + product_id).fadeOut();
					$('.receipet_success').fadeIn().css('display', 'flex');
				}

				if(data['success']) {
					$('.receipet_success').fadeIn().css('display', 'flex');
				}
			}
		});
	});
});


//удаления товара
$(document).ready(function(){
	$('body').on('click', '.module_delete_btn', function(){
		var delete_products = $(this).attr("id");

		$.ajax({
			type: 'POST',
			url: 'core/action/delete_products.php',

			data: {
				delete_products: delete_products
			},
			dataType: 'json',
			success: (data) => {
				if(data['ok']) {
					$('.receipet_success').fadeIn().css('display', 'flex');
					$('.stock-list#' + delete_products).fadeOut();
					//сообщение если все ок
					show_success_modal(data['ok']);				
				}
			}
		});

	});
});


//удаления отчета
$(document).ready(function(){
	$('body').on('click', '.delete_report', function(){
		var delete_report = $(this).attr("id");

		$.ajax({
			type: 'POST',
			url: 'core/action/delete_products.php',

			data: {
				delete_report: delete_report
			},
			dataType: 'json',
			success: (data) => {
				if(data['ok']) {
					$('.receipet_success').fadeIn().css('display', 'flex');
					$('.stock-list#' + delete_report).fadeOut();
					//сообщение если все ок
					show_success_modal(data['ok']);				

				}
			}
		});

	});
});




$('body').on('click', '.add_profit_action', function(){

	var profit_name = $('.profit_name').val();
	var profit_value = $('.profit_money').val();

	$.ajax({
		type: 'POST',
		url: 'core/action/add_order.php',
		data: {
			profit_name: profit_name,
			profit_value : profit_value
		},
		dataType: 'json',
		success: (data) => {
			if(data['ok']) {
				$('.add_profit_modal').fadeOut();
					//сообщение если все ок
				show_success_modal(data['ok']);					
			}
		}
	});
});



//модальное окно ошибки 
function show_error_modal(eror_text) {
	var $fail_notify        = $('.fail_notify');

	var error  = eror_text;
	//показываем сообщение о ошибки
	$fail_notify.fadeIn().html(error);
	//скрываем сообщение о ошибки спустя 4 сек
	setTimeout(function(){
		$fail_notify.fadeOut();
	}, 4000);

}


//модальное окно успеха 
function show_success_modal(success_text) {
	var $clearTime = '1500';

	var $success_notify        = $('.success_notify');

	var success  = success_text;
	//показываем сообщение о ошибки
	$success_notify.fadeIn().html(success);
	//скрываем сообщение о ошибки спустя 4 сек
	setTimeout(function(){
		$success_notify.fadeOut();
	}, $clearTime);

}


//preloader show/hide 
function get_preloader(action) {
	if(action === 'show') {
		$('.preloader_wrapper').show('fast').addClass('flex-cntr');
	} 
	if(action === 'hide') {
		$('.preloader_wrapper').hide('fast').removeClass('flex-cntr');
	}
	
}


//добавить заметку
$('body').on('click', '.add_note_submit', function(){
	var $note_name_input 	= 	$('.add_note_name_action');
	var $note_descrp_input 	= 	$('.add_note_descript');

	var note_name 		=	$note_name_input.val();
	var note_descrpt 	=	$note_descrp_input.val();
	var note_type 		=	$('.note_action_type').attr('data-type');
	const table_param   = 	['.note_order_list', '[data-stock-src=', note_type + ']'];

	var $note_table     =   $(table_param.join(''));

	$.ajax({
		type: 'POST',
		url: 'core/action/add_note.php',
		data: {
			note_name 		: note_name,
			note_descrpt 	: note_descrpt,
			note_type 		: note_type
		},
		dataType: 'json',
		success: (data) => {
			var success = data['success'];
			var error   = data['error'];
			var table   = data['table'];
			if(success) {
				show_success_modal(success);
				$note_table.prepend(table);		
				$note_name_input.val('');
				$note_descrp_input.val('');
			}

			if(error) {
				show_error_modal(error);
			}
		}		
	});
});

//редактировать заметку
$('body').on('click', '.note_table' ,function(){
	var $this = $(this);
	var get_note_id  = $this.attr('id');
	$('.note_table').removeClass("o_product_selected");

	$.ajax({
		type: 'POST',
		url:  'core/modal_action/service_order.php',
		data: {
			get_note_id : get_note_id
		}, 
		success: (data) => {
		 addLeftPaddingModal();
		 $this.addClass("o_product_selected");
		 $('.modal_view_stock_order').html(data);
		}
	});

});


//редактирование заметки
$('body').on('click', '.save_edit_note', function(){
	var get_note_id			= $('.modal_order_form').data('order-id');
	var get_upd_name 		= $('.note_name_upd_actinon').val();
	var get_upd_dsecrpt 	= $('.note_descrpt_upd_action').val();

	$.ajax({
		type: 'POST',
		url:  'core/action/update_note.php',
		data: {
			update_note 	:  get_note_id,
			get_upd_name  	:  get_upd_name,
			get_upd_dsecrpt :  get_upd_dsecrpt
		},
		dataType: 'JSON',
		success: (data) => {
			var success = data['success'];
			if(success) {
				show_success_modal(success);
				$('.note_table#'+get_note_id).find('.note_name_a').text(get_upd_name);
				$('.note_table#'+get_note_id).find('.note_descrpt_a').text(get_upd_dsecrpt);				
			}
		}
	});
});










$('body').on('click', '.add_rasxod_submit', function(){
	var $rasxod_value_input 	= 	$('.add_rasxod_value_a');
	var $raxod_descrp_input 	= 	$('.add_rasxod_descript_a');
	var rasxod_name 			=	$rasxod_value_input.val();
	var rasxod_descrpt 			=	$raxod_descrp_input.val();
	$.ajax({
		type: 'POST',
		url: 'core/action/rasxod_action.php',
		data: {
			add_rasxod 		: rasxod_name,
			rasxod_descript : rasxod_descrpt
		},
		dataType: 'json',
		success: (data) => {
			var success = data['success'];
			var error 	= data['error'];
			var table 	= data['table'];
			if(success) {
				show_success_modal(success);
				$('.rasxod_order_list').prepend(table);
				$rasxod_value_input.val('');
				$raxod_descrp_input.val('');				
			}

			if(error) {
				show_error_modal(error);
			}
		}		
	});
});


$('body').on('click', '.rasxod_list_tr', function(){

	$('.rasxod_list_tr').removeClass('o_product_selected');
	var rasxod_id 	= 	$(this).attr('id');

	$.ajax({
		type: 'POST',
		url: 'core/action/rasxod_action.php',
		data: {
			rasxod_order 	: rasxod_id
		},
		success: (data) => {
			$(this).addClass('o_product_selected');
			$('.module_fix_right_side').fadeIn();
			$('.modal_view_stock_order').html(data['table']);
		}		
	});
});


$('body').on('click', '.delete_rasxod_action', function(){
	var get_rasxod_id = $('.modal_order_form').attr('data-order-id');
	$.ajax({
		type: 'POST',	
		url: 'core/action/rasxod_action.php',
		data: {
			delete_rasxod : get_rasxod_id
		},
		success: (data) => {
			var success = data['success'];
			if(success) {
				show_success_modal('OK');
				$('.module_fix_right_side').fadeOut();
				$('.rasxod_list_tr#'+get_rasxod_id).fadeOut();
			}
		}		
	});	

});



/******update end******/
