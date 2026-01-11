<?php
$croot = $_SERVER["DOCUMENT_ROOT"] . '/img/b4af/implant';

$dir = './'; // 현재 디렉토리
$files = array_diff(scandir($croot), array('.', '..'));
$files = array_values($files); // 키 재정렬
print_r($files); // 또는 foreach($files as $file) echo $file . "\n";
?>