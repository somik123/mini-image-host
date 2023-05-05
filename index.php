<?php
header("Access-Control-Allow-Origin: *");

$domain = "https://img.ec.gy/";
$upload_path = "/var/www/img.ec.gy/public_html/";

if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    try{
        $file_name =  $_FILES['file']['name']; //getting file name
        $tmp_name = $_FILES['file']['tmp_name']; //getting temp_name of file

        $image_info = @getimagesize($tmp_name);

        if($image_info == false)
            throw new Exception('Please upload valid image file.');
        
        $type = $_FILES['file']['type'];     
        $extensions = array( 'image/jpeg', 'image/png', 'image/gif' );
        if(!in_array( $type, $extensions ))
            throw new Exception('Only jpg, jpeg, png, and gif image type supported.');
        
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_id = rand_str(6);
        
        $new_file_name = "{$file_id}.{$file_ext}";
        
        move_uploaded_file($tmp_name, $upload_path.$new_file_name);
        
        $url = $domain.$new_file_name;
        
        $out = array("status"=>"OK","url"=>$url);
        echo json_encode($out);

    }
    catch(Exception $e){
        $out = array("status"=>"FAIL","msg"=>$e->getMessage());
        echo json_encode($out);
    }
}
else{
    $v = "?v=".rand(1111,9999);
    ?>
    
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Image Host | ImagePerl</title>
    <link rel="stylesheet" href="style.css<?=$v?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div class="wrapper">
        <header onclick="location.href='.';">Mini Image Host</header>
        <div class="mirror-div">
            Select mirror:
            <select id="mirror">
                <option value="">img.ec.gy</option>
                <option>img.c1.is</option>
            </select>
        </div>
        <form action="#">
            <input class="file-input" type="file" name="file" hidden>
            <i class="fas fa-cloud-upload-alt"></i>
            <p>Browse Image to Upload</p>
            <span class="small">Max file size: 5MB</span>
        </form>
        <section class="progress-area"></section>
        <section class="uploaded-area"></section>
    </div>

    <script src="script.js<?=$v?>"></script>

    

</body>

</html>

    <?php

}



function rand_str($length = 10) {
    $characters = '23456789abcdefghjkmnpqrtuvwxyzABCDEFGHJKLMNPQRTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
