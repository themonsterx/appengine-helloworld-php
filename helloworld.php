<?php
	$ip = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$browser = @$_SERVER['HTTP_USER_AGENT'];
	$request = @$_SERVER['REQUEST_URI'];
	$referer = @$_SERVER['HTTP_REFERER'];
	$app = explode('.', @$_SERVER['HTTP_HOST'])[0];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://$app.extensionx.xyz$request");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"X-Forwarded-for: $ip",
		"User-Agent: $browser",
		"Referer: $referer",
		"Site:".@$_SERVER['HTTP_HOST'],
		"Via: Compression"
    ));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	@ob_end_clean();
    @ob_end_flush();
	header('Content-Type:'.$info['content_type']);
	header('HTTP/1.1 '.$info['http_code']);
	echo $response;
?>
