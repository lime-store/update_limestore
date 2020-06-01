<?php
	require_once '../../function.php';
	//Показывать товары которые находться в базе больше 15 дней 
	// settShowOldProduct();

	//кнопка компактного меню на странице
	modalNavigationBtn();

	//выводим компакнтное меню на странице 
	getModalSideBarNav();

	//блок для принта чека
	printModal();

	//выводим перекючения вкладок 
	getCurrentTab($terminal_phone_link, $terminal_akss_link); 

	//абсолютный пусть к файлам
	root_dir();

	//пути к категориям
	get_product_root_dir();	

	//модальное окно успешно выполнено функция
	success_done();
	//модальное коно не выполнено функция
	fail_notify();

?>


<div class="terminal_main">
	<?php 
		require_once GET_ROOT_DIRS. $terminal_phone_link;	
	?>
</div>