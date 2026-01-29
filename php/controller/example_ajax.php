<?php
if (isset($_POST["dataArr"])) {
    $dataArr = $_POST["dataArr"];
    $fn = isset($dataArr["fn"]) ? $dataArr["fn"] : "";
}
echo json_encode(["result" => $fn]);