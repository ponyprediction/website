<?php

$page = 'error';

if (isset($_GET['page']))
{
	$ok = false;
	$page = $_GET['page'];
	if($page == 'home'
		|| $page == 'register'
		|| $page == 'log-in'
		|| $page == 'log-out'
		|| $page == 'account'
		|| $page == 'confirmation')
	{
		$ok = true;
	}
	if(!$ok)
		$page = 'error';
}

// Magic to replace foo-bar-boo in FooBarBoo
$pattern = '/(-)(.)/i';
$class = ucfirst($page) . 'Page';
$class = preg_replace_callback($pattern, 'upper', $class);
function upper($matches)
{
  return strtoupper($matches[2]);
}
//

$filename = './php/pages/'.$page.'.php';

include_once($filename);
new $class($page);
?>
