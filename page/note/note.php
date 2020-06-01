<?php
	require_once '../../function.php';
	//Показывать товары которые находться в базе больше 15 дней 
	// settShowOldProduct();

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
	<?php require_once GET_ROOT_DIRS. $note_order_link;	?>
</div>