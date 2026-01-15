<?php
$json = json_encode(array('result' => true, 'value' => $_POST['value']));
echo($json);