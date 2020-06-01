 <?php
 
$zip1 = new ZipArchive;
 
//Открываем Zip-архив
$extract1 = $zip1->open($_SERVER['DOCUMENT_ROOT'].'/htdocs.zip');
 
if ($extract1 === TRUE) {
 
    //Извлекаем содержимое архива
    $zip1->extractTo($_SERVER['DOCUMENT_ROOT']);
 
    //Закрываем Zip-архив
    $zip1->close();
    echo 'Архивы archive1.zip и archive2.zip были извлеченны в папку!';
 
} else {
       echo 'Извлечение archive1.zip и archive2.zip не удалось!';
}
 
?> 