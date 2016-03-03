<?php
ini_set('max_execution_time', 300); 
ini_set('memory_limit', '-1');


$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'test_upload';
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);




$query="SELECT s.user_id, a.name as user_name, s.answer_value, 
				a.created_at, a.question_1, a.question_2, 
				a.question_3, a.question_4, a.question_5 
		FROM upload_site s RIGHT JOIN upload_answers a ON s.user_name = a.name
		WHERE (a.question_1 !='' OR a.question_2 !='' OR a.question_3 != '' OR a.question_4 !='' OR a.question_5 != '')
		GROUP BY a.name";


$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

     $arr=array();
     echo '<table border=1>
     		<tr>
     			<th width="20%">Name</th>
     			<th>Site</th>
     			<th>Date</th>
     			<th width="20%">Question1</th>
     			<th>Question2</th>
     			<th>Question3</th>
     			<th>Question4</th>
     			<th>Question5</th>
     		</tr>
     	';
        if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {	
//                    $arr[] = $row;
						

						echo '<tr>
							<td>'.$row['user_name']. '</td>
							<td>'.$row['answer_value']. '</td>
							<td>'.date('Y-m-d',strtotime($row['created_at'])) . '</td>
							<td>'.$row['question_1']. '</td>
							<td>'.(int)$row['question_2']. '</td>
							<td>'.(int)$row['question_3']. '</td>
							<td>'.(int)$row['question_4']. '</td>
							<td>'.(int)$row['question_5']. '</td>
						</tr>';
						$row['question_1']=str_replace("'","\'",$row['question_1']);
						$row['user_name']=str_replace("'","\'",$row['user_name']);
						$query_insert="INSERT INTO upload_result(user_id, 
							user_name, 
							answer_value, 
							created_at, 
							question_1, 
							question_2, 
							question_3, 
							question_4, 
							question_5) VALUES ('".$row['user_id']."',
							'".$row['user_name']."',
							'".$row['answer_value']."',
							'".date('Y-m-d',strtotime($row['created_at']))."',
							'".$row['question_1']."',
							'".(int)$row['question_2']."',
							'".(int)$row['question_3']."',
							'".(int)$row['question_4']."',
							'".(int)$row['question_5']."')";

						//echo $query_insert;

						 $result_insert = $mysqli->query($query_insert) or die($mysqli->error.__LINE__);

						 $result_insert = $mysqli->affected_rows;



            
          }
        }

        echo '</table>';

  
//      $json_response = json_encode($arr);
//      //echo '<pre>';
//      echo $json_response;
//      //	echo '</pre>';


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

























































