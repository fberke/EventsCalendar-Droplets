<?php
// define constants
define ("EVENTSCAL_IMAGE_PATH", WB_PATH.MEDIA_DIRECTORY.'/eventscalendar/');
define ("EVENTSCAL_IMAGE_URL", WB_URL.MEDIA_DIRECTORY.'/eventscalendar/');
define ("EVENTSCAL_TEMPLATE_PATH", WB_PATH.'/modules/eventscalendar/templates/');

require (WB_PATH.'/modules/eventscalendar/dwoo_inc.php');

global $settings, $monthnames, $weekdays, $CALTEXT, $dwoo;

$module_dir = WB_PATH."/modules/eventscalendar/";
if (LANGUAGE_LOADED) {
	if(file_exists($module_dir."languages/".LANGUAGE.".php")) {
		require_once($module_dir."languages/".LANGUAGE.".php");
	} else {
		require_once($module_dir."languages/EN.php");
	}
}

require_once ($module_dir."functions.php");

if (isset($_GET['month'])) {
	$month = (int)$_GET['month'];
} else {
	$month = date('n');
}
if (isset($_GET['year'])) {
	$year = (int)$_GET['year'];
} else {
	$year = date('Y');
}

if (!isset($section_id)) { $section_id = 0 ; }
if (!isset($page_id)) { $page_id = 0 ; }

$date_start = mktime (0, 0, 0, $month, 1, $year);
$date_end = mktime (23, 59, 59, $month, DaysCount($month, $year), $year);
$settings = fillSettingsArray ($section_id);
$events = fillEventArray($date_start, $date_end, $section_id);

$output = ShowCalendar($month,$year,$events,$section_id,$page_id,false);
return $output;
?>
