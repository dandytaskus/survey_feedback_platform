<?php

$temp_array=explode(".",$_FILES["file"]["name"]);
$temp_index=sizeof($temp_array)-1;
$new_name=$_GET['new_name'];
$target_dir = $_GET['dir'].'/';
$target_file = $target_dir . basename($new_name);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {

}

// Check if file already exists

if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file sizeof()
// if ($_FILES["file"]["size"] > 500000) {
//     echo "Sorry, your file is too large.";
//     $uploadOk = 0;
// }
//Allow certain file formats

if($imageFileType != "xls" && $imageFileType != "csv" && $imageFileType != "xlsx") {
    echo "Sorry, only Excel files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        print_r($_FILES["file"]);
    }
}




ini_set('max_execution_time', 300); 
ini_set('memory_limit', '-1');


$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'test_upload';
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);



if($_GET['dir']=='site'){

    echo $_GET['dir'];

        ///=================Upload Site Source file
        $directory = 'site/';

        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        while($it->valid()) {

            if (!$it->isDot()) {

                //echo 'SubPathName: ' . $it->getSubPathName() . "<br>";
                // echo 'SubPath:     ' . $it->getSubPath() . "<br>";
                // echo 'Key:         ' . $it->key() . "<br><br>";  

                $query="LOAD DATA LOCAL INFILE 'site/".$it->getSubPathName()."' 
                    INTO TABLE upload_site FIELDS TERMINATED BY ',' 
                    ENCLOSED BY '\"' 
                    LINES TERMINATED BY '\r\n' IGNORE 1 LINES
                    (user_id,user_name,@ignore,@ignore,@ignore,@ignore,@ignore,question_label,answer_value)";

                    $result = $mysqli->query($query) or die($mysqli->error.__LINE__);

                    $result = $mysqli->affected_rows;
                    $site_file=$it->getSubPathName();
                    echo $json_response = json_encode($result);

            }

            $it->next();
        }

    unlink("site/".$site_file);

}else if($_GET['dir']=='answer'){

        $directory = 'answer/';
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        while($it->valid()) {

            if (!$it->isDot()) {

                //echo 'SubPathName: ' . $it->getSubPathName() . "<br>";
                // echo 'SubPath:     ' . $it->getSubPath() . "<br>";
                // echo 'Key:         ' . $it->key() . "<br><br>";
                $query="LOAD DATA LOCAL INFILE 'answer/".$it->getSubPathName()."' 
                            INTO TABLE upload_answers FIELDS TERMINATED BY ',' 
                            ENCLOSED BY '\"' 
                            LINES TERMINATED BY '\r\n' IGNORE 1 LINES";

                $answer_file=$it->getSubPathName();

                $result = $mysqli->query($query) or die($mysqli->error.__LINE__);

                $result = $mysqli->affected_rows;

                //echo $json_response = json_encode($result);

            }

            $it->next();
        }
    unlink("answer/".$answer_file);
}



?>