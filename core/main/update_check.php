 <?php
define('root_dir', $_SERVER['DOCUMENT_ROOT']);

$root_dir = root_dir;

	$current_version = file_get_contents($root_dir.'/version.txt');

	// Создаем поток
	$opts = array(
	  'http'=>array(
	    'method'=>"GET",
	    'header'=>"Accept-language: en\r\n" .
	              "Cookie: foo=bar\r\n"
	  )
	);

	$context = stream_context_create($opts);
	//получем версию с репозитория
	$get_verison = file_get_contents('https://raw.githubusercontent.com/lime-sklad/update_limestore/master/version.txt', false, $context);

	//чистим от пробелов
	$get_verison = trim($get_verison);

	//версия пользователя
	$current_version = trim($current_version);



	if($current_version !== $get_verison) {
		echo "Есть обновление \n Cкачиваем...";
	    exec('curl https://github.com/lime-sklad/update_limestore/archive/master.zip -L -o update.zip');
		//запускаем установку обнов.
		ls_install_update($root_dir);
	} 


	if($current_version === $get_verison) {
		echo "Последняя версия программы";
	}


	function ls_install_update($root_dir) {	 
		$archive_dir = $root_dir.'/updates/';
		$src_dir = $root_dir.'/updates/update_limestore-master/';

		$source = 'update_limestore-master';
		$target = $root_dir;

		$zip = new ZipArchive;
		if($zip->open($root_dir.'/core/main/update.zip') === TRUE) {
		    for($i = 0; $i < $zip->numFiles; $i++) {
		        $name = $zip->getNameIndex($i);

		        // Skip files not in $source
		        if (strpos($name, "{$source}/") !== 0) continue;

		        // Determine output filename (removing the $source prefix)
		        $file = $target.'/'.substr($name, strlen($source)+1);

		        // Create the directories if necessary
		        $dir = dirname($file);
		        if (!is_dir($dir)) mkdir($dir, 0777, true);

		        // Read from Zip and write to disk
		        if($dir != $target) {
		            $fpr = $zip->getStream($name);
		            $fpw = fopen($file, 'w');
		            while ($data = fread($fpr, 1024)) {
		                fwrite($fpw, $data);
		            }
		            fclose($fpr);
		            fclose($fpw);
		        }
		    }
		    $zip->close();
		}


	}
?> 
