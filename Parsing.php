<?php
require '../vendor/autoload.php';

$parsingName='.post__title_link';
$parsingData='.post__time';
$parsingNumberOfComments='.post-stats__comments-count';

parsingFunction($parsingData,5);
parsingFunction($parsingName,5);
parsingFunction($parsingNumberOfComments,5);

///
function parsingFunction ($url,$numberPages)
{
	for ($number=1; $number<$numberPages+1; $number++)
	{
		$file='https://habr.com/all/page'.$number."/";
		$html=file_get_contents($file);
		$doc=new nokogiri($html);
		echo '<pre>';
			foreach($doc->get($url)->toArray() as $item)
			{ 
				print_r($item['#text'][0]);
				echo '<br>';
			}	
		echo '</pre>';
	}
}

?>