<?php
    $imgRootArr = array(
        array(
            'imgBefore' => '/img/comparison__implant__01__before.jpg',
            'imgAfter' => '/img/comparison__implant__02__before.jpg'
        )
    );
    
    echo '<script>';
    echo 'var imgInformation = new Array();';
    foreach ($imgRootArr as $imgRoot) {
        $imgSize = getimagesize($_SERVER["DOCUMENT_ROOT"] . $imgRoot['imgBefore']);
        echo
        'imgInformation.push({
            imgBefore : "' . $imgRoot['imgBefore'] . '",
            imgAfter : "' . $imgRoot['imgAfter'] . '",
            imgWidth : ' . $imgSize[0] .',
            imgHeight : ' . $imgSize[1] . '
        });';
    }
    echo '</script>';
?>

<script>
    if(typeof imgInformation == 'undefined' || imgInformation == null || imgInformation == '') console.log('underfined');
    else console.log(imgInformation);
</script>