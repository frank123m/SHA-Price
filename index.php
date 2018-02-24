<?php

function get_data($url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$response = curl_exec($ch);
	curl_close($ch);
	return json_decode($response);
}

function show_price($ex, $p, $c) {
	echo $ex . ': ';
	echo ($p != 100) ? number_format($p, 8) . ' ' . $c : 'Price Not Available.';
	echo '<br>';
}


if (isset($_GET['market'])) {

	$m = $_GET['market'];
	$m_array = explode('_', $m);
	$c1 = $m_array[0];
	$c2 = $m_array[1];

	$ex1_data = get_data('https://www.cryptopia.co.nz/api/GetMarket/' . $m);
	$ex2_data = get_data('https://tradesatoshi.com/api/public/getmarketsummary?market=' . $m);

	$p1 = ($ex1_data != null) ? $ex1_data->Data->LastPrice : 100;
	$p2 = ($ex2_data != null) ? $ex2_data->result->last : 100;

	echo '<br><b>' . $c1 . '</b><hr>';

	show_price('Cryptopia', $p1, $c2);
	show_price('TradeSatoshi', $p2, $c2);

}


