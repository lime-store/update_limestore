$(document).ready(function(){

	$('body').on('click', '.close_modal_btn', function(){
		$('.module_fix_right_side').hide('slow');
		$('.main').attr("style", "padding-right: 0px");
		$('.add_profit_modal').fadeOut();
		//убираем активированный продукт
		remove_selected_product();
	});

});

$(document).ready(function(){
	$('body').on('click', '.delete_btn_link', function(){
		$('.delete_stock_module').show('slow').attr("style", "display: flex;");
	});
});

$(document).ready(function(){
	$('body').on('click', '.module_delete_btn_cancle', function(){
		$('.delete_stock_module').hide('slow');
	});
});


$(document).ready(function(){
	$('body').on('click', '.module_nav_btn', function (){
		$('.module_sidebar').toggleClass('open_menu');
		$('.module_nav_first_image').toggleClass('menu_close_img');
		$('.module_nav_second_image').toggleClass('menu_open_img');
		$('.modle_menu_btn').toggleClass('menu_btn_active');
	});
});



$(document).ready(function(){
	$('body').on('click', '.close_print_module', function(){
		$('.print_div').fadeOut();
	});
});


$(document).ready(function(){
	$('body').on('click', '.report_action', function(){
		var report_action_id = $(this).attr("id");
		$('.module_fix_right_side').fadeIn();
		$('.phone_modal_view').fadeIn();
		$('.akss_modal_view').fadeOut();
		$('.add_to_recipert').attr('id',report_action_id);
		$('.stock_return_accept_button').attr('id', report_action_id);
		$('.receipet_success').fadeOut();
		$('.stock_return_accept_form').fadeOut();
	});
});



$(document).ready(function(){
	$('body').on('click', '.akss_report_action', function(){
		var report_action_id = $(this).attr("id");
		$('.module_fix_right_side').fadeIn();
		$('.akss_modal_view').fadeIn();
		$('.phone_modal_view').fadeOut();
		$('.akss_stock_return_accpet_action_btn').attr('id', report_action_id);
		$('.akss_stock_return_accept_form').fadeOut();
	});
});



$(document).ready(function(){
	$('body').on('click', '.link_stock_return_btn', function(){
		$('.stock_return_accept_form').attr("style", "display: flex").fadeIn();
	});
});

$(document).ready(function(){
	$('body').on('click', '.akss_link_stock_return_btn', function(){
		$('.akss_stock_return_accept_form').attr("style", "display: flex").fadeIn();
	});
});


$(document).ready(function(){
	$('body').on('click', '.stock_return_cancle', function(){
		$('.stock_return_accept_form').fadeOut();
		$('.akss_stock_return_accept_form').fadeOut();
	});	
});


$(document).ready(function(){
	$('body').on('click', '.close_report_print', function(){
		$('.receipt_order_rerport_list').fadeOut();
		$(this).fadeOut();
	});
});


$(document).ready(function(){
	$('body').on('click', '.close_error_module_action', function(){
		$('.add_stock_module_error').fadeOut();
	});



	$('body').on('click', '.fastOptionOpenAction', function(){
		$('.select_option_name_wrp').fadeIn();
	});

	$('body').on('click', '.close_option_name', function(){
		$('.select_option_name_wrp').fadeOut();
	});
	
	$('body').on('click', '.selectOptionName', function(){
		let selectedoption = $(this).html();

		$('.add_stock_name_input').val(selectedoption);

		$('.select_option_name_wrp').fadeOut();
	});


	$('body').on('click', '.reminder_delete_hdr', function(){
		$('.reminder_wrapper_header').fadeOut();
	});



});



function addLeftPaddingModal() {
	$('.module_fix_right_side').show('slow').attr("style", "display: flex");
}


/**********update start******/

$(document).ready(function(){


//фильтруем данные инпута от муора
$('body').on('keyup', '.order_input', function(){
	//получаем цену заказа
	var order_price = $('.order_price_action').val();
	
	//получаем количество заказа
	var $order_count = $('.order_count_action');

	//количество заказа	
	var order_count_value = $order_count.val();
	//функция очищает цену от лишнего 
	preg_order_price_value(order_price);

	//функция очищает количество от лишнего
	preg_order_count_value(order_count_value);

	//проверка на валидность
	product_count_not_valid(order_count_value, $order_count);

	var order_total_res = order_price*order_count_value;
	var order_total_res = order_total_res.toFixed(1);

	$('.get_order_action').removeClass('click');

	$('.show_total_sum_order_action').html(order_total_res);
	$('.total_sum_order_stock').val(order_total_res);

});




//очищаем цену для заказа
function preg_order_price_value(order_price) {
	//заменяем все запятне на точку 
	var order_price = order_price.replace(',', '.' );

	//удалаяем все буквы и символы кроме цифр
	var order_price = order_price.replace(/[^.\d]+/g,"")

	//удаляем все лишние точки и оставяем тоько одну
	var order_price = order_price.replace( /^([^\.]*\.)|\./g, '$1');

	$('.add_stock_submit').removeClass('click');
	$('.order_price_action').val(order_price);
	return order_price;	
}

//очишаю цену при доавлении в базу 
$('body').on('keyup', '.input_preg_action', function(){
	add_price = $(this).val();
	//вызываем функция очищаем инпут
	preg_order_price_value(add_price);

	//получем очищеный инпут из функции
	var price = preg_order_price_value(add_price);
	
	//выводим в инпут
	$(this).val(price);

});
//очищаем количество заказа
function preg_order_count_value(order_count) {
	//очищаем от точки\запятой и любого символа кроме цифр
	var order_count = order_count.replace(/[^.\d]+/g,"").replace(/[^,\d]+/g,"");

	//удаляем 0  в начале строки
	var order_count = order_count.replace(/^0/,'');

	$('.order_count_action').val(order_count);
}

//если количество товра не валидна
function product_count_not_valid(order_count_value, $order_count) {
	if(order_count_value.length === 0 || order_count_value == 0) {
		//добавляем класс не активного инпута
		$order_count.addClass('not_valid_input');
	} else {
		//удаляем класс не активного инпута
		$order_count.removeClass('not_valid_input');			
	}
}


//переключения вкладок 
$('body').on('click', '.tab_select_link' ,function(){

	//очищаем от паддинга 
	$('.main').css('padding-right', '0');

	//класс активная кнопка
	var tab_btn_activ = 'tab_activ';			   			 		

	//находим все кнопки переключения вклдаки 
	$('.tab_select_link').each(function(){							
		//удаляем активный класс у кнопки 	
		$('.tab_select_link').removeClass(tab_btn_activ)			
	});

	//получаем кнопку на которую кликнули
	var item = $( this ); 

	//получаем позицию кнопки 								
    var offsest = item.position();		

    //добавляем к кнопке класс .tab_activ что бы сделать ее активным				
	$(this).addClass(tab_btn_activ); 

	//перемещаем фон активной вкладки под позицию кнопки на которую кликнули		
	$('.tab_selected_bcg').css("left", offsest.left);  	

	var get_open_tab = $(this).attr("data-tab-open");
		$.ajax({
			url:  get_open_tab,
			type: 'POST',
			success: (data) => {
				$('.terminal_main').html(data);
			}
		});
	 			
	});




$('body').on('click', '.add_prfit_action', function(){
	$('.add_profit_modal').fadeIn().css('display', 'flex');
});



});

function remove_selected_product() {
	$('.stock-list').each(function(){
		$('.stock-list').removeClass('o_product_selected');
	});
	$('.note_table').each(function(){
		$('.note_table').removeClass('o_product_selected');
	});	
}





//прибавить/отнять количество товра дя акссеуаров
$(document).ready(function(){
	$('body').on('click', '.edit_custom_count', function(){
		$(this).hide('slow');
		$(this).parent().attr("style", "opacity: 1");
		$(this).parent().find('.edited_custom_stock_count').prop("disabled", false);
	});
});



/**********update end********/