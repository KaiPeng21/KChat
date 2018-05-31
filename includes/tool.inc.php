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
