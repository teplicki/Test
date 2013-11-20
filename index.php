<?php

//logowanie b³êdów == 0
error_reporting(0);
 $shortcut = addslashes(
		$_GET['downloadid']
		) ;
	
	
define('domena', 'htteu/');
define('path', '/.eu/');
define('ext','.html');
define('prefix','_');

$db['server'] = 'localhost';
$db['port'] = 3306;
$db['dbname'] = '_0002';
$db['username'] = '_0002';
$db['password'] = '';

$sql_id = mysql_connect($db['server'], $db['username'], $db['password']);
// TODO: pobieranie z konfigu

if (!$sql_id)
{
	echo 'Ooops. We have a problem with database. Try again in a few minutes. If problem will not resolve, this is probably because wrong database configuration or maintenance.';
    exit;
}
mysql_select_db($db['dbname'],$sql_id);
//mysql_close($sql_id); 

function sql($query, $return)
{
    
    //$zapytanie = "SELECT * FROM `_users`";
    $queryid = mysql_query($query);
    
    while ($wiersz = mysql_fetch_assoc($queryid)) {
        print_r($wiersz);
    }

}

$sql = "SELECT * FROM `_dl` WHERE shortcut = '$shortcut'";
$queryid = mysql_query($sql);
if (!$wiersz = mysql_fetch_assoc($queryid))
{
	echo 'Invalid url. Check again.';
	exit;
}
elseif (!is_file($wiersz['file']))
{
	echo 'File not found. Probably deleted';
	exit;
}
else{
	$sql = 'UPDATE `_dl` SET `count` = \'' . ($wiersz['count'] + 1) .
		'\' WHERE `id` = ' . ($wiersz['id']);
	$queryid = mysql_query($sql);

	if (strpos($wiersz['file'], '.png') !== FALSE || strpos($wiersz['file'], '.jpg') !== FALSE)
	header('Content-Type: image/png');

	else {
	header('Content-Type: application/zip');
	header('Content-Disposition: attachment; filename='.basename($wiersz['file']));
	}

	readfile($wiersz['file']);
	exit;
	print_r($wiersz);
}

	
?>


<pre><?php
print_r($_GET);
print_r($_SERVER);
?></pre>

<?php

$dl = Array(

's' => '../smile.jpg',
'x' => '../eu-home.png',
'y' => '../../114.jpg',

'none' => ''
);

echo '<pre>';
print_r($dl);
echo '
</pre>';

if (array_key_exists($_GET['key'] , $dl))
{

$url = $dl[$_GET['key']];
$name = explode('/' , $url);
$name = $name[count($name)- 1];

echo "<a href='$url'>$name</a>";

}

?>