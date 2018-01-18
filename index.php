<?php

function get_data($url) {
	$client = curl_init($url);
	curl_setopt($client, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($client);
	curl_close($client);
	return json_decode($response);
}

function show_price($ex, $p) {
	echo $ex . ': ';
	echo ($p != 100) ? number_format($p, 8) . ' BTC' : 'Price Not Available.';
	echo '<br>';
}


if (isset($_GET['market'])) {

	$m = $_GET['market'];

	$ex1_data = get_data('https://www.cryptopia.co.nz/api/GetMarket/' . $m);
	$ex2_data = get_data('https://tradesatoshi.com/api/public/getmarketsummary?market=' . $m);

	$p1 = ($ex1_data != null) ? $ex1_data->Data->LastPrice : 100;
	$p2 = ($ex2_data != null) ? $ex2_data->result->last : 100;

	show_price('Cryptopia', $p1);
	show_price('TradeSatoshi', $p2);

}


