    <?php
ini_set('max_execution_time', 300); 
ini_set('memory_limit', '-1');


$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'test_upload';
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);




$query="SELECT * FROM upload_result";
$cond="";

if($_GET['date_to']!=''){
    $_GET['date_to']=date('Y-m-d', strtotime($_GET['date_to']));
    $_GET['date_from']=date('Y-m-d', strtotime($_GET['date_from']));
    $cond=" WHERE created_at BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."' ";
}elseif ($_GET['date_from']!=''){
    $_GET['date_from']=date('Y-m-d', strtotime($_GET['date_from']));
    $cond=" WHERE created_at='".$_GET['date_from']."' ";    
}

$query=$query.$cond;
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

     $arr=array();
  
        if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {	
                 $arr[] = $row;
					
          }
        }



  
     $json_response = json_encode($arr);
     //echo '<pre>';
     echo $json_response;
     //	echo '</pre>';


// $string_out="10 (extremely positive)";
// $output=(int)$string_out;
// echo $output;

//=============Report Query

// SELECT COUNT(question_2) as ans_count, question_2  FROM `upload_result` group by question_2  
// ORDER BY CAST(`upload_result`.`question_2` AS INT)  ASC


		

// SELECT question_2, SUM(case when answer_value = 'BGC' then 1 else 0 end) as BGC,
// SUM(case when answer_value = 'Cavite' then 1 else 0 end) as Cavite,
// SUM(case when answer_value = 'Anonas' then 1 else 0 end) as Anonas,
// SUM(case when answer_value = '' then 1 else 0 end) as Undefined,
// COUNT(question_2) as Grand_Total

// FROM `upload_result` group by question_2  
// ORDER BY CAST(`upload_result`.`question_2` AS INT)  DESC

?>

























































