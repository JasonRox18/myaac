<?php
defined('MYAAC') or die('Direct access not allowed!');
function query($query)
{
	global $db, $error;

	try {
		$db->query($query);
	}
	catch(PDOException $error_) {
		error($error_);
		$error = true;
	}
	
	return !$error;
}

// define php version id if its not already
if(!defined('PHP_VERSION_ID')) {
	$version = explode('.', PHP_VERSION);

	define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

function ini_get_bool($a)
{
	$b = ini_get($a);

	switch (strtolower($b))
	{
	case 'on':
	case 'yes':
	case 'true':
		return 'assert.active' !== $a;

	case 'stdout':
	case 'stderr':
		return 'display_errors' === $a;

	default:
		return (bool) (int) $b;
	}
}

function next_buttons($previous = true, $next = true)
{
	global $locale, $step, $steps;

	$i = 1;
	foreach($steps as $id => $value)
	{
		if($step == $value)
			break;

		$i++;
	}

	$ret = '<div class="input">';
/*	if($previous)
		$ret .= '<input class="button" type="submit" onclick="document.getElementById(\'step\').value=\'' . $steps[$i - 1] . '\';" value="' . $locale['previous'] . '" />';
	if($next)
		$ret .= '<input class="button" type="submit" onclick="document.getElementById(\'step\').value=\'' . $steps[$i + 1] . '\';" value="' . $locale['next'] . '" />';
*/
	if($previous)
		$ret .= '<input type="button" class="button" onclick="document.getElementById(\'step\').value=\'' . $steps[$i - 1] . '\'; this.form.submit();" value="' . $locale['previous'] . '" />';
	if($next)
		$ret .= '<input type="button" class="button" onclick="document.getElementById(\'step\').value=\'' . $steps[$i + 1] . '\'; this.form.submit();" value="' . $locale['next'] . '" />';

	$ret .= '</div>';
	return $ret;
}

function next_form($previous = true, $next = true)
{
	global $step;

	return '<form action="' . BASE_URL . 'install/" method="post">
	<input type="hidden" name="step" id="step" value="' . $step . '" />' . next_buttons($previous, $next) . '
</form>';
}
?>