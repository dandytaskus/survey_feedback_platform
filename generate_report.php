<!doctype html>
<html ng-app="App">
<head>
   <?php require_once 'header.php'; ?>
   <script type="text/javascript" src="js/generate_report.js"></script>
   <title>Generate Report</title>
</head>



<body ng-controller="MainContoller">



 <?php require_once 'menu_bar.php'; ?>

<script>
$(function(){
        $('.datepicker').datepicker({
        });
});
</script>

<?php require_once 'menu_bar.php'; ?>

<body ng-controller="ViewTask">


<div class="well">
    <div class="modal-header">
         <center><b><i class="fa fa-tasks"></i> Generate Report</b></center>
      </div>
      <br>
     

     <div class="controls controls-row">
             <label class="span2">Date From:</label> <input name="date_created" class="datepicker span3" ng-model="select_date_from"></input>
              <label class="span2">To:</label> <input name="date_created" class="datepicker span3" ng-model="select_date_to"></input>
      </div>
      <br>

      <div class="controls controls-row">

            <button class="span2 btn-info" ng-click="generate_report();"><i class="fa fa-refresh"></i> Generate</button>
            <button class="span2 btn-success" ng-click="export_excel();"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
            <button class="span2 btn-success" ng-click="pivote_reports();"><i class="fa fa-file-excel-o"></i> Pivoted Report</button>
         
      </div>

</div>
<div class="well">
      <br>
      <div class="controls controls-row">
          <table class="table span12">
            <tr>
              <th width="170">Name</th>
              <th>Site</th>
              <th>Date</th>
              <th width="150">Question 1</th>
              <th>Question 2</th>
              <th>Question 3</th>
              <th>Question 4</th>
              <th>Question 5</th>
            </tr>

            <tr ng-repeat="result in results | orderBy:'created_at'">
              <td>{{result.user_name}}</td>
              <td>{{result.answer_value}}
                  <select class="span2  " ng-hide="result.answer_value" ng-model="site[$index]">
                      <option value="Anonas">Anonas</option>
                      <option value="BGC">BGC</option>
                      <option value="Cavite">Cavite</option>
                  </select>
                  <button class="span1 btn-success" ng-click="update_site($index,result.user_name);" ng-hide="result.answer_value">Save</button>
              </td>
              <td>{{result.created_at}}</td>
              <td>{{result.question_1}}</td>
              <td>{{result.question_2}}</td>
              <td>{{result.question_3}}</td>
              <td>{{result.question_4}}</td>
              <td>{{result.question_5}}</td>
            </tr>
  
          </table>
      </div>
</div>

</body>

</html>