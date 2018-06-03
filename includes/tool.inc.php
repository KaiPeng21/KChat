<?php

function addGetParaToURL($url, $key, $val=null){
	$query = parse_url($url, PHP_URL_QUERY);

	if ($query) {
		parse_str($query, $queryParams);
		$queryParams[$key] = $val;
        $url = str_replace("?$query", '?' . http_build_query($queryParams), $url);

	} else {
		$url .= '?' . urlencode($key) . '=' . urlencode($val);
	}

	return $url;
}

function validate_timestamp ($timestamp) {
	
	$regex = '/^([1-9][0-9]*)-(([0][1-9])|([1][0-2]))-(([0][1-9])|([12][0-9])|([3][01]))[\s](([01][0-9])|([2][0-3]))[:](([0-5][0-9]))[:](([0-5][0-9]))$/';
	if (preg_match($regex, $timestamp, $matches) === false) {
		return false;
	}
	
	return date('Y-m-d H:i:s', mktime($matches[9], $matches[12], $matches[14], $matches[2], $matches[5], $matches[1]));
}