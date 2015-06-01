<?php
// get component parameter
jimport('joomla.application.component.helper');
$showurl = JComponentHelper::getParams('com_basiccomponent')->get('frontend_url', 'http://joomlacommunity.eu');


// show view
$viewPath = JPATH_BASE . '/components/com_basiccomponent/views/basiccomponent/tmpl/default.php';

// If the template has a layout override use it
$template = JFactory::getApplication()->getTemplate();
$tPath = JPATH_THEMES . '/' . $template . '/html/com_basiccomponent/basiccomponent/default.php';
if (file_exists($tPath)) {
    $viewPath = $tPath;
}

require($viewPath);

