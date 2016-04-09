<?php
include_once "../keyCommon/upDownFile.class.php";

$upDownFileObj = new upDownFile();
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";

if($action == 'upload'){
    $result = $upDownFileObj->uploads('myFile','../resources/uploads/','img');
    print_r($result);

}elseif($action == 'download'){
    $result = $upDownFileObj->download_header_smp('../resources/uploads/file.zip');
//		$result = $obj->download_location('Upload/file.rar');
//		$result = $obj->download_header_pro('Upload/file.rar');
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>

<form action="upDownFile.php?action=upload" method="post" enctype="multipart/form-data">
    <input type="file" name="myFile[]" multiple="multiple"><br>

    <input type="submit" value="ok">

    <input type="hidden" name="MAX_FILE_SIZE" value="20971520">
</form>

</body>
</html>
