<?php
// define constants
define ("EVENTSCAL_IMAGE_PATH", WB_PATH.MEDIA_DIRECTORY.'/eventscalendar/');
define ("EVENTSCAL_IMAGE_URL", WB_URL.MEDIA_DIRECTORY.'/eventscalendar/');

global $settings, $monthnames, $weekdays, $CALTEXT;

$module_dir = WB_PATH."/modules/eventscalendar/";
if (LANGUAGE_LOADED) {
	if(file_exists($module_dir."languages/".LANGUAGE.".php")) {
		require_once($module_dir."languages/".LANGUAGE.".php");
	} else {
		require_once($module_dir."languages/EN.php");
	}
}

require_once ($module_dir."functions.php");

// Show how many items, defaults to 10?
if (!isset($max)) { $max = 10; }

// year and month and section defaults
if (!isset($year)) { $year = date('Y'); }
if (!isset($month)) { $month = date('n'); }
if (!isset ($day)) { $day = date('j'); } 
if (!isset($page_id)) { $page_id = 0 ; }
if (!isset($section_id)) { $section_id = 0 ; }
if (!isset($category)) { $category = false; }

define ("EVENTSCAL_FQDN", returnCalPageURL ($page_id));

// Set start and end date for query
$date_start = mktime (0,0,0, $month, $day, $year);
$date_end = $date_start + (182 * 24 * 60 * 60);

// Fetch the items
$settings = fillSettingsArray ($section_id);
$events = fillEventArray ($date_start, $date_end, $section_id, false, $category);

$sizeofEvents = sizeof ($events);

if ($sizeofEvents > 0) {
	
	if ($sizeofEvents > $max) { $sizeofEvents = $max; }
	
	$output = '<ul class="drop_event_list">';
	
	for ($i = 0; $i < $sizeofEvents; $i++) {
		$entry = $events [$i];
		$dateEntry = ShowDate ($settings ['dateformat'], $entry ['date_start']);
		if ($entry ['date_start'] != $entry ['date_end']) {
			$dateEntry .= '&nbsp;'.$CALTEXT['DATE_DIVIDER'].'&nbsp;'.ShowDate ($settings ['dateformat'], $entry ['date_end']);
		}
		$output .= '<li><a href="'.$entry ['event_link'].'"><div>'."\n";
		$output .= '<span class="date_time">'.$dateEntry.'</span>'."\n";
		$output .= '<h3>'.$entry ['event_title'].'</h3>'."\n";
		$output .= '<p>'.$entry ['oneliner'].'</p>'."\n";
		$output .= '</div></a></li>'."\n";
	}
	
	$output .= '</ul>'."\n";

} else $output = $CALTEXT['NODATES'];

return $output;
?>
