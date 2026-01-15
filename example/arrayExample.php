<?php
    // $imgRootArr = array(
    //     array(
    //         'imgBefore' => '/img/comparison__implant__01__before.jpg',
    //         'imgAfter' => '/img/comparison__implant__02__before.jpg'
    //     )
    // );
    
    // echo '<script>';
    // echo 'var imgInformation = new Array();';
    // foreach ($imgRootArr as $imgRoot) {
    //     $imgSize = getimagesize($_SERVER["DOCUMENT_ROOT"] . $imgRoot['imgBefore']);
    //     echo
    //     'imgInformation.push({
    //         imgBefore : "' . $imgRoot['imgBefore'] . '",
    //         imgAfter : "' . $imgRoot['imgAfter'] . '",
    //         imgWidth : ' . $imgSize[0] .',
    //         imgHeight : ' . $imgSize[1] . '
    //     });';
    // }
    // echo '</script>';
    $arr = [];
    $arr['in1'] = array('index1' => 'value1');
    $arr['in2'] = array('index2' => 'value2');
    $arr['in3'] = array('index3' => 'value3');
    $arr['in4'] = array('index4' => 'value4');
?>

<script>
    // if(typeof imgInformation == 'undefined' || imgInformation == null || imgInformation == '') console.log('underfined');
    // else console.log(imgInformation);
    var arrStr = '<?php echo json_encode($arr); ?>';
    var arrJson = JSON.parse(arrStr);
    console.log(arrJson.in1);
    console.log(arrJson.in2);
    console.log(arrJson.in3);
    console.log(arrJson.in4);
</script>