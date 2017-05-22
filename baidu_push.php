<?php
$urls = array(
'http://www.baicaio.com',
);
$api = 'http://data.zz.baidu.com/urls?site=www.baicaio.com&token=Bftm4X2ltkQJyL7L';
$ch = curl_init();
$options = array(
CURLOPT_URL => $api,
CURLOPT_POST => true,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_POSTFIELDS => implode("\n", $urls),
CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
echo $result;
?>