<?php

$matches = array(
        '/^http(s)?:\/\/(meta\.)?([a-z]+)\.stackexchange\.com/',
        '/^http(s)?:\/\/(meta\.)?mathoverflow\.net/',
        '/^http(s)?:\/\/(meta\.)?serverfault\.com/',
        '/^http(s)?:\/\/(meta\.)?stackapps\.com/',
        '/^http(s)?:\/\/(meta\.)?stackexchange\.com/',
        '/^http(s)?:\/\/(meta\.)?stackoverflow\.com/',
        '/^http(s)?:\/\/(meta\.)?superuser\.com/',
);

foreach ($matches as $match) {
    if (preg_match($match, $_SERVER['HTTP_ORIGIN'])) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$raw = file_get_contents('php://input');
	$input = @json_decode($raw);

	if ($input === null) {
		throw new Exception('Invalid Input');
	} else {
		file_put_contents('settings.json', $raw);
	}
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	header('Content-Type: application/json');
	echo file_get_contents('settings.json');
} else {
	throw new Exception('Unsupported Request Method');
}