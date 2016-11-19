<?php
ini_set('display_errors', 1); 
error_reporting(-1);



$xmlFiles 	= glob('./PhoneGap/xml/*.xml');
$books 		= '';
$chapters 	= '';
$content 	= '';

// books
$template_books = '  <li><a href="#TITLE_LOWERCASE">TITLE</a></li>'."\n";

// chapters
$template_chapters 		= '<ul id="TITLE_LOWERCASE" title="TITLE">'."\n".'LIST</ul>'."\n"."\n";
$template_chapters_list = '  <li><a href="html/TITLE_LOWERCASE.html">Kapitel NUMBER</a></li>'."\n";

// content
$template_content		= '<div id="TITLE_AND_NR_LOWERCASE" title="TITLE_AND_NR">'."\n".'LIST</div>'."\n"."\n";
$template_content_list	= '  <span class="vers">NUMBER</span><span class="text">CONTENT</span>'."\n";

// content
$template_note			= '<hr />'."\n".'<span class="notes">'."\n".'LIST';
$template_note_list		= '  <span class="notenumber">NUMBER</span><span class="notetext">CONTENT</span>'."\n";

foreach ($xmlFiles as $fileName) {
	$xml 	= simplexml_load_file($fileName);
	$title 	= $xml->Buch->Titel;

	$list = '';
	
	foreach($xml->Buch->Kapitel as $xmlKapitel) {
		
		$list2 = '';
		$list3 = '';

		foreach ($xmlKapitel->Abschnitt as $xmlAbschnitt) {
			$i = 0;
			
			if (strlen((string)$xmlAbschnitt->Us1)) {
				$list2 .= '  <div class="heading">'.(string)$xmlAbschnitt->Us1.'</div>';
			} else {
				$list2 .= "\n".'<br />'."\n";
			}
			
			// Collect Verses
			foreach ($xmlAbschnitt->Grundtext->Vers as $xmlVers) {
				$list2 .= str_replace(array('NUMBER', 'CONTENT'), array((string)$xmlVers->Versziffer, (string)$xmlVers->Verstext), $template_content_list);
			}
			
			// Add Ausnahme
			if (strlen((string)$xmlAbschnitt->Ausnahme)) {
				$list2 .= '  <span class="kursiv">'.trim(str_replace('\'\'', '', (string)$xmlAbschnitt->Ausnahme)).'</span>'."\n";
			}
			
			
			// Collect Notes			
			if (count($xmlAbschnitt->Fussnote) > 0) {
				foreach ($xmlAbschnitt->Fussnote as $xmlFussnote) {
					$list3 .= str_replace(array('NUMBER', 'CONTENT'), array(/*'<sub><a href="#">'.*/(string)$xmlFussnote->Fussnotenummer/*.'</a></sub>'*/, (string)$xmlFussnote->Fussnotetext), $template_note_list);
				}
			}
		}

		// Add Notes
		if (strlen($list3)) {
			$list2 .=  str_replace(array('LIST'), $list3, $template_note).'</span>'."\n"."\n";
		}
		
		// Add Verses
		//$content .=  str_replace(array('TITLE_AND_NR_LOWERCASE', 'TITLE_AND_NR', 'LIST'), array(clearString($title).'_'.(int)$xmlKapitel->Kapitelziffer, $title.' '.(int)$xmlKapitel->Kapitelziffer, $list2), $template_content);
		file_put_contents('./PhoneGap/html/'.clearString($title).'_'.(int)$xmlKapitel->Kapitelziffer.'.html', str_replace(array('TITLE_AND_NR_LOWERCASE', 'TITLE_AND_NR', 'LIST'), array(clearString($title).'_'.(int)$xmlKapitel->Kapitelziffer, $title.' '.(int)$xmlKapitel->Kapitelziffer, $list2), $template_content));

		$list 	.= str_replace(	array('TITLE_LOWERCASE', 'NUMBER'), 
								array(clearString($title).'_'.(int)$xmlKapitel->Kapitelziffer, (int)$xmlKapitel->Kapitelziffer),
								$template_chapters_list);
	}
	
	
	$chapters 	.= str_replace(array('TITLE_LOWERCASE', 'TITLE', 'LIST'), array(clearString($title), $title, $list), $template_chapters);
	
	$books 		.= str_replace(array('TITLE_LOWERCASE', 'TITLE'), array(clearString($title), $title), $template_books);
	
}

$books 		.= '<li>&nbsp;</li>';
$books 		.= '<li><a href="#about">Über diese App</a></li>';

$result = '<ul id="books" title="Volxbibel" selected="true">'."\n".$books.'</ul>'."\n"."\n";
$result .= $chapters;
//$result .= $content;

file_put_contents('./PhoneGap/kapitelliste.html', $result);
echo $result;

function clearString($string) {
	return strtolower(str_replace(array('.', ' ', ',', 'ä', 'ö', 'ü'), array('_', '_', '_', 'ae', 'oe', 'ue'), trim($string)));
}

