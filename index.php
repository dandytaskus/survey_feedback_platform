<!doctype html>
<html ng-app="App">
<head>
   <?php require_once 'header.php'; ?>
   <script type="text/javascript" src="js/index.js"></script>
   <title>File Uploader</title>
</head>



<body ng-controller="BudgetPrepay">



 <?php require_once 'menu_bar.php'; ?>

<center><h4>Upload you CSV source file Here</h4></center>
<!--  <div class="controls controls-row"> 
           	<div class="span1"></div>
          <label class="span3"><i>Upload you CSV source file Here:</i></label>

 </div> -->
 
<div class="well">
 <div class="controls controls-row"> 
	<label class="span3"><b>Step 1:</b>Upload the site source file:</label><br>
</div>
 <div class="controls controls-row"> 
           	<div class="span1"></div>
            <input class="span3 " id="sortpicture" type="file" name="sortpic" />
            <button class="span2 btn-info" ng-click="add_file()" ng-hide="loading"><i class="fa fa-paperclip"></i> Upload</button>
            <button class="span2 btn-danger" ng-click="test()" ng-hide="!loading"> Loading...</button>

 </div>
<div class="controls controls-row"> 
<label class="span4"><b>Step 2:</b>Upload the answer source file:</label><br>
</div>
 <div class="controls controls-row"> 
           	<div class="span1"></div>
            <input class="span3 " id="sortpicture2" type="file" name="sortpic2" />
            <button class="span2 btn-info" ng-click="add_file2()"><i class="fa fa-paperclip"></i> Upload</button>

 </div>


<div class="controls controls-row"> 
<label class="span4"><b>Step 3:</b>Scrub data, click the button below.</label><br>
</div>

<div class="controls controls-row"> 
<div class="span4"></div>
<button class="span2 btn-success" ng-click="data_scrub()"><i class="fa fa-paperclip"></i> Scrub Data</button>
</div>


</div>


</body>

</html>