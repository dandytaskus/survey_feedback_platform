<html ng-app="App">
<head>
   <?php require_once 'header.php'; ?>
   <script type="text/javascript" src="js/index.js"></script>
   <title>File Uploader</title>
</head>

<?php
ini_set('max_execution_time', 300); 
ini_set('memory_limit', '-1');


$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'test_upload';
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);


///=================Upload Site Source file


$query="SELECT question_2, SUM(case when answer_value = 'BGC' then 1 else 0 end) as BGC,
		SUM(case when answer_value = 'Cavite' then 1 else 0 end) as Cavite,
		SUM(case when answer_value = 'Anonas' then 1 else 0 end) as Anonas,
		SUM(case when answer_value = '' then 1 else 0 end) as Undefined,
		COUNT(question_2) as Grand_Total

		FROM `upload_result`";


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

$query=$query." group by question_2 ORDER BY CAST(`upload_result`.`question_2` AS INT)  DESC";

//echo $query;

$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

     $arr=array();
     $promoter=0;
     $passive=0;
     $detractor=0;
     $promoter_bgc=0;
     $promoter_cavite=0;
     $promoter_anonas=0;
     $promoter_undefined=0;
     $passive=0;
     $passive_bgc=0;
     $passive_cavite=0;
     $passive_anonas=0;
     $passive_undefined=0;
     $detractor=0;
     $detractor_bgc=0;
     $detractor_cavite=0;
     $detractor_anonas=0;
     $detractor_undefined=0;

     //echo $query;
     echo '<table border=1>
     		<tr>
     			<th width="20%">Were there clear instructions on completing the online registration and examination?</th>
     			<th>BGC</th>
     			<th>Cavite</th>
     			<th>Anonas</th>
     			<th>Untag</th>
     			<th>Grand Total</th>
     			
     		</tr>
     	';
        if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
//                    $arr[] = $row;
              		  if($row['question_2']>=9){

              		  		$promoter=$promoter+$row['Grand_Total'];
              		  		$promoter_bgc+=$row['BGC'];
              		  		$promoter_cavite+=$row['Cavite'];
              		  		$promoter_anonas+=$row['Anonas'];
              		  		$promoter_undefined+=$row['Undefined'];

              		  }elseif($row['question_2']>=7){

              		  		$passive=$passive+$row['Grand_Total'];
              		  		$passive_bgc+=$row['BGC'];
              		  		$passive_cavite+=$row['Cavite'];
              		  		$passive_anonas+=$row['Anonas'];
              		  		$passive_undefined+=$row['Undefined'];

              		  }else{

              		  		$detractor=$detractor+$row['Grand_Total'];
              		  		$detractor_bgc+=$row['BGC'];
              		  		$detractor_cavite+=$row['Cavite'];
              		  		$detractor_anonas+=$row['Anonas'];
              		  		$detractor_undefined+=$row['Undefined'];

              		  }

						

						echo '<tr>
							<td>'.$row['question_2']. '</td>
							<td>'.$row['BGC']. '</td>
							<td>'.$row['Cavite']. '</td>
							<td>'.$row['Anonas']. '</td>
							<td>'.$row['Undefined']. '</td>
							<td>'.$row['Grand_Total']. '</td>
							
						</tr>';
						// $row['question_1']=str_replace("'","\'",$row['question_1']);
						// $row['user_name']=str_replace("'","\'",$row['user_name']);
						



            
          }
        }
        $anps=(($promoter-$detractor)/($promoter+$passive+$detractor))*100;
        $anps_anonas=(($promoter_anonas-$detractor_anonas)/($promoter_anonas+$passive_anonas+$detractor_anonas))*100;
        $anps_bgc=(($promoter_bgc-$detractor_bgc)/($promoter_bgc+$passive_bgc+$detractor_bgc))*100;
        $anps_cavite=(($promoter_cavite-$detractor_cavite)/($promoter_cavite+$passive_cavite+$detractor_cavite))*100;
        $anps_undefined=(($promoter_undefined-$detractor_undefined)/($promoter_undefined+$passive_undefined+$detractor_undefined))*100;
        echo '</table>';
        echo '<br><br>';
        echo '<table border=1>
        		<tr>
        			<th colspan=2>Anonas</th>
        			<th colspan=2>BGC</th>
        			<th colspan=2>Cavite</th>
        			<th colspan=2>Un-tag</th>
        			<th colspan=2>Across all site</th>
        		</tr>

        		<tr>
        			<th>Promoter</th>
        			<td>'.$promoter_anonas.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_bgc.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_cavite.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_undefined.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter.'</td>	
        		</tr>

        		<tr>
        			<th>Detractor</th>
        			<td>'.$detractor_anonas.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_bgc.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_cavite.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_undefined.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor.'</td>	
        		</tr>

        		<tr>
        			<th>Total</th>
        			<td>'.round($anps_anonas,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_bgc,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_cavite,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_undefined,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps,0).'%</td>	
        		</tr>


        </table>';

        //echo 'Promoter- '.$promoter.' Passive- '.$passive.' Detractor- '.$detractor;


  echo '<br><br>';




  $query="SELECT question_3, SUM(case when answer_value = 'BGC' then 1 else 0 end) as BGC,
		SUM(case when answer_value = 'Cavite' then 1 else 0 end) as Cavite,
		SUM(case when answer_value = 'Anonas' then 1 else 0 end) as Anonas,
		SUM(case when answer_value = '' then 1 else 0 end) as Undefined,
		COUNT(question_3) as Grand_Total

		FROM `upload_result`";

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

$query=$query." group by question_3 ORDER BY CAST(`upload_result`.`question_3` AS INT)  DESC";


$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

     $arr=array();


     $promoter=0;
     $passive=0;
     $detractor=0;
     $promoter_bgc=0;
     $promoter_cavite=0;
     $promoter_anonas=0;
     $promoter_undefined=0;
     $passive=0;
     $passive_bgc=0;
     $passive_cavite=0;
     $passive_anonas=0;
     $passive_undefined=0;
     $detractor=0;
     $detractor_bgc=0;
     $detractor_cavite=0;
     $detractor_anonas=0;
     $detractor_undefined=0;
     //echo $query;
     echo '<table border=1>
     		<tr>
     			<th width="20%">Were the receptionists accommodating?</th>
     			<th>BGC</th>
     			<th>Cavite</th>
     			<th>Anonas</th>
     			<th>Untag</th>
     			<th>Grand Total</th>
     			
     		</tr>
     	';
        if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
//                    $arr[] = $row;

              	       if($row['question_3']>=9){

              		  		$promoter=$promoter+$row['Grand_Total'];
              		  		$promoter_bgc+=$row['BGC'];
              		  		$promoter_cavite+=$row['Cavite'];
              		  		$promoter_anonas+=$row['Anonas'];
              		  		$promoter_undefined+=$row['Undefined'];

              		  }elseif($row['question_3']>=7){

              		  		$passive=$passive+$row['Grand_Total'];
              		  		$passive_bgc+=$row['BGC'];
              		  		$passive_cavite+=$row['Cavite'];
              		  		$passive_anonas+=$row['Anonas'];
              		  		$passive_undefined+=$row['Undefined'];

              		  }else{

              		  		$detractor=$detractor+$row['Grand_Total'];
              		  		$detractor_bgc+=$row['BGC'];
              		  		$detractor_cavite+=$row['Cavite'];
              		  		$detractor_anonas+=$row['Anonas'];
              		  		$detractor_undefined+=$row['Undefined'];

              		  }
						

						echo '<tr>
							<td>'.$row['question_3']. '</td>
							<td>'.$row['BGC']. '</td>
							<td>'.$row['Cavite']. '</td>
							<td>'.$row['Anonas']. '</td>
							<td>'.$row['Undefined']. '</td>
							<td>'.$row['Grand_Total']. '</td>
							
						</tr>';
						// $row['question_1']=str_replace("'","\'",$row['question_1']);
						// $row['user_name']=str_replace("'","\'",$row['user_name']);
						



            
          }
        }
        $anps=(($promoter-$detractor)/($promoter+$passive+$detractor))*100;
        $anps_anonas=(($promoter_anonas-$detractor_anonas)/($promoter_anonas+$passive_anonas+$detractor_anonas))*100;
        $anps_bgc=(($promoter_bgc-$detractor_bgc)/($promoter_bgc+$passive_bgc+$detractor_bgc))*100;
        $anps_cavite=(($promoter_cavite-$detractor_cavite)/($promoter_cavite+$passive_cavite+$detractor_cavite))*100;
        $anps_undefined=(($promoter_undefined-$detractor_undefined)/($promoter_undefined+$passive_undefined+$detractor_undefined))*100;
        echo '</table>';
        echo '<br><br>';
        echo '<table border=1>
        		<tr>
        			<th colspan=2>Anonas</th>
        			<th colspan=2>BGC</th>
        			<th colspan=2>Cavite</th>
        			<th colspan=2>Un-tag</th>
        			<th colspan=2>Across all site</th>
        		</tr>

        		<tr>
        			<th>Promoter</th>
        			<td>'.$promoter_anonas.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_bgc.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_cavite.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_undefined.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter.'</td>	
        		</tr>

        		<tr>
        			<th>Detractor</th>
        			<td>'.$detractor_anonas.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_bgc.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_cavite.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_undefined.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor.'</td>	
        		</tr>

        		<tr>
        			<th>Total</th>
        			<td>'.round($anps_anonas,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_bgc,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_cavite,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_undefined,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps,0).'%</td>	
        		</tr>


        </table>';

        echo '</table>';


          echo '<br><br>';




  $query="SELECT question_4, SUM(case when answer_value = 'BGC' then 1 else 0 end) as BGC,
		SUM(case when answer_value = 'Cavite' then 1 else 0 end) as Cavite,
		SUM(case when answer_value = 'Anonas' then 1 else 0 end) as Anonas,
		SUM(case when answer_value = '' then 1 else 0 end) as Undefined,
		COUNT(question_4) as Grand_Total

		FROM `upload_result`";

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

    $query=$query." group by question_4 ORDER BY CAST(`upload_result`.`question_4` AS INT)  DESC";


$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

     $arr=array();

     $promoter=0;
     $passive=0;
     $detractor=0;
     $promoter_bgc=0;
     $promoter_cavite=0;
     $promoter_anonas=0;
     $promoter_undefined=0;
     $passive=0;
     $passive_bgc=0;
     $passive_cavite=0;
     $passive_anonas=0;
     $passive_undefined=0;
     $detractor=0;
     $detractor_bgc=0;
     $detractor_cavite=0;
     $detractor_anonas=0;
     $detractor_undefined=0;

     //echo $query;
     echo '<table border=1>
     		<tr>
     			<th width="20%">Were you given enough time to answer the questions during the interview process?</th>
     			<th>BGC</th>
     			<th>Cavite</th>
     			<th>Anonas</th>
     			<th>Untag</th>
     			<th>Grand Total</th>
     			
     		</tr>
     	';
        if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
//                    $arr[] = $row;

              	       if($row['question_4']>=9){

              		  		$promoter=$promoter+$row['Grand_Total'];
              		  		$promoter_bgc+=$row['BGC'];
              		  		$promoter_cavite+=$row['Cavite'];
              		  		$promoter_anonas+=$row['Anonas'];
              		  		$promoter_undefined+=$row['Undefined'];

              		  }elseif($row['question_4']>=7){

              		  		$passive=$passive+$row['Grand_Total'];
              		  		$passive_bgc+=$row['BGC'];
              		  		$passive_cavite+=$row['Cavite'];
              		  		$passive_anonas+=$row['Anonas'];
              		  		$passive_undefined+=$row['Undefined'];

              		  }else{

              		  		$detractor=$detractor+$row['Grand_Total'];
              		  		$detractor_bgc+=$row['BGC'];
              		  		$detractor_cavite+=$row['Cavite'];
              		  		$detractor_anonas+=$row['Anonas'];
              		  		$detractor_undefined+=$row['Undefined'];

              		  }
						

						echo '<tr>
							<td>'.$row['question_4']. '</td>
							<td>'.$row['BGC']. '</td>
							<td>'.$row['Cavite']. '</td>
							<td>'.$row['Anonas']. '</td>
							<td>'.$row['Undefined']. '</td>
							<td>'.$row['Grand_Total']. '</td>
							
						</tr>';
						// $row['question_1']=str_replace("'","\'",$row['question_1']);
						// $row['user_name']=str_replace("'","\'",$row['user_name']);
						



            
          }
        }
        $anps=(($promoter-$detractor)/($promoter+$passive+$detractor))*100;
        $anps_anonas=(($promoter_anonas-$detractor_anonas)/($promoter_anonas+$passive_anonas+$detractor_anonas))*100;
        $anps_bgc=(($promoter_bgc-$detractor_bgc)/($promoter_bgc+$passive_bgc+$detractor_bgc))*100;
        $anps_cavite=(($promoter_cavite-$detractor_cavite)/($promoter_cavite+$passive_cavite+$detractor_cavite))*100;
        $anps_undefined=(($promoter_undefined-$detractor_undefined)/($promoter_undefined+$passive_undefined+$detractor_undefined))*100;
        echo '</table>';
        echo '<br><br>';
        echo '<table border=1>
        		<tr>
        			<th colspan=2>Anonas</th>
        			<th colspan=2>BGC</th>
        			<th colspan=2>Cavite</th>
        			<th colspan=2>Un-tag</th>
        			<th colspan=2>Across all site</th>
        		</tr>

        		<tr>
        			<th>Promoter</th>
        			<td>'.$promoter_anonas.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_bgc.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_cavite.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_undefined.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter.'</td>	
        		</tr>

        		<tr>
        			<th>Detractor</th>
        			<td>'.$detractor_anonas.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_bgc.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_cavite.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_undefined.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor.'</td>	
        		</tr>

        		<tr>
        			<th>Total</th>
        			<td>'.round($anps_anonas,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_bgc,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_cavite,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_undefined,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps,0).'%</td>	
        		</tr>


        </table>';

        echo '</table>';

           echo '<br><br>';




  $query="SELECT question_5, SUM(case when answer_value = 'BGC' then 1 else 0 end) as BGC,
		SUM(case when answer_value = 'Cavite' then 1 else 0 end) as Cavite,
		SUM(case when answer_value = 'Anonas' then 1 else 0 end) as Anonas,
		SUM(case when answer_value = '' then 1 else 0 end) as Undefined,
		COUNT(question_5) as Grand_Total

		FROM `upload_result`";

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

    $query=$query." group by question_5 ORDER BY CAST(`upload_result`.`question_5` AS INT)  DESC";

$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

     $arr=array();
     $promoter=0;
     $passive=0;
     $detractor=0;
     $promoter_bgc=0;
     $promoter_cavite=0;
     $promoter_anonas=0;
     $promoter_undefined=0;
     $passive=0;
     $passive_bgc=0;
     $passive_cavite=0;
     $passive_anonas=0;
     $passive_undefined=0;
     $detractor=0;
     $detractor_bgc=0;
     $detractor_cavite=0;
     $detractor_anonas=0;
     $detractor_undefined=0;
     //echo $query;
     echo '<table border=1>
     		<tr>
     			<th width="20%">Overall, how would you rate your TaskUs experience?</th>
     			<th>BGC</th>
     			<th>Cavite</th>
     			<th>Anonas</th>
     			<th>Untag</th>
     			<th>Grand Total</th>
     			
     		</tr>
     	';
        if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
//                    $arr[] = $row;

              	       if($row['question_5']>=9){

              		  		$promoter=$promoter+$row['Grand_Total'];
              		  		$promoter_bgc+=$row['BGC'];
              		  		$promoter_cavite+=$row['Cavite'];
              		  		$promoter_anonas+=$row['Anonas'];
              		  		$promoter_undefined+=$row['Undefined'];

              		  }elseif($row['question_5']>=7){

              		  		$passive=$passive+$row['Grand_Total'];
              		  		$passive_bgc+=$row['BGC'];
              		  		$passive_cavite+=$row['Cavite'];
              		  		$passive_anonas+=$row['Anonas'];
              		  		$passive_undefined+=$row['Undefined'];

              		  }else{

              		  		$detractor=$detractor+$row['Grand_Total'];
              		  		$detractor_bgc+=$row['BGC'];
              		  		$detractor_cavite+=$row['Cavite'];
              		  		$detractor_anonas+=$row['Anonas'];
              		  		$detractor_undefined+=$row['Undefined'];

              		  }
						

						echo '<tr>
							<td>'.$row['question_5']. '</td>
							<td>'.$row['BGC']. '</td>
							<td>'.$row['Cavite']. '</td>
							<td>'.$row['Anonas']. '</td>
							<td>'.$row['Undefined']. '</td>
							<td>'.$row['Grand_Total']. '</td>
							
						</tr>';
						// $row['question_1']=str_replace("'","\'",$row['question_1']);
						// $row['user_name']=str_replace("'","\'",$row['user_name']);
						



            
          }
        }
        $anps=(($promoter-$detractor)/($promoter+$passive+$detractor))*100;
        $anps_anonas=(($promoter_anonas-$detractor_anonas)/($promoter_anonas+$passive_anonas+$detractor_anonas))*100;
        $anps_bgc=(($promoter_bgc-$detractor_bgc)/($promoter_bgc+$passive_bgc+$detractor_bgc))*100;
        $anps_cavite=(($promoter_cavite-$detractor_cavite)/($promoter_cavite+$passive_cavite+$detractor_cavite))*100;
        $anps_undefined=(($promoter_undefined-$detractor_undefined)/($promoter_undefined+$passive_undefined+$detractor_undefined))*100;
        echo '</table>';
        echo '<br><br>';
        echo '<table border=1>
        		<tr>
        			<th colspan=2>Anonas</th>
        			<th colspan=2>BGC</th>
        			<th colspan=2>Cavite</th>
        			<th colspan=2>Un-tag</th>
        			<th colspan=2>Across all site</th>
        		</tr>

        		<tr>
        			<th>Promoter</th>
        			<td>'.$promoter_anonas.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_bgc.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_cavite.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter_undefined.'</td>
        			<th>Promoter</th>
        			<td>'.$promoter.'</td>	
        		</tr>

        		<tr>
        			<th>Detractor</th>
        			<td>'.$detractor_anonas.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_bgc.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_cavite.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor_undefined.'</td>
        			<th>Detractor</th>
        			<td>'.$detractor.'</td>	
        		</tr>

        		<tr>
        			<th>Total</th>
        			<td>'.round($anps_anonas,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_bgc,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_cavite,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps_undefined,0).'%</td>
        			<th>Total</th>
        			<td>'.round($anps,0).'%</td>	
        		</tr>


        </table>';

        echo '</table>';

?>

























































