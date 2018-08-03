<?php
require '../vendor/autoload.php';
require 'QueryingDatabase.php';
//numberPages-колличество страниц
$numberPages=5;

//ПРИМЕЧАНИЕ!
//Цикл используется для прохода по страницам хабра
 for ($number=1; $number<$numberPages+1; $number++)
 {
	 //hostname-адрес удаленного сервера
	 $hostname ='https://habr.com/all/page'.$number."/";
	 get_content($hostname);	
 }
 
// Скрипт парсинга определенных классов (ищет + выводит на экран) с помощью библиотеки nokogiri
 function parsingFunction ($url,$content)
{
		
		$doc=new nokogiri($content);
		echo '<pre>';
			foreach($doc->get($url)->toArray() as $item)
			{ 
				print_r($item['#text'][0]);
				echo '<br>';
			}	
		echo '</pre>';

}

//Скрипт загрузки удаленной страницы средствами
//библиотеки CURL + функция parsingFunction
 function get_content($hostname)
 {
	 //Ключевые адреса поиска классов
	 //parsingName- классов "Заголовки статей"
	 //parsingData- классов "Даты публикаци статей"
	 //parsingNumberOfComments- классов "Колличества комментариев статей"
			$parsingName='.post__title_link';
			$parsingData='.post__time';
			$parsingNumberOfComments='.post-stats__comments-count';
			
	//задание адреса серва
			$curl = curl_init($hostname);
			
 
			curl_setopt($curl, CURLOPT_URL,$hostname);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($curl, CURLOPT_HEADER, 0);

			$content = curl_exec($curl);
			
	// Закрытие CURL-соединение
			curl_close($curl);
			
	//парсинг заголовков,даты,комментариев
			parsingFunction($parsingName,$content);
			parsingFunction($parsingData,$content);
			parsingFunction($parsingNumberOfComments,$content);
			return $content;
 }
 
?>