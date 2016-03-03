  var app = angular.module('App',[]);

  /** CONTROLLER **/

  app.controller('BudgetPrepay',function($scope, $window, $http){
    $scope.loading=false;

      $scope.test=function(){
        $scope.loading=false;
        alert("Here");
      }

      $scope.goto_reports=function(){
        $window.open('upload_database.php');
      }



      $scope.data_scrub=function(){
         $http.get("api/scrub.php").success(function(data){
            alert("Here");   
         });

          
      }

      function loading(){
        if($scope.loading){
          $scope.loading=false;
        }else{
          $scope.loading=true;
        }

      }

      function getExtension(file_name){
        var file_array=file_name.split(".");
        var file_extension="";
          angular.forEach(file_array,function(file, index){
                  file_extension=file;
             });
          return file_extension
      }

      $scope.add_file=function(){
         if($('#sortpicture').val()!=='') {
              //$scope.loading=true;
              var file_data = $('#sortpicture').prop('files')[0]; 
              var form_data = new FormData();                  
              form_data.append('file', file_data);
              var new_name=Date.now();
              var old_name=file_data.name;
              //console.log(file_data);
              new_name=new_name+'.'+getExtension(old_name);
             
              
              //alert(new_name);
              $.ajax({
                      url: 'upload.php?new_name='+new_name+'&dir=site', // point to server-side PHP script 
                      dataType: 'text',  // what to expect back from the PHP script, if anything
                      cache: false,
                      contentType: false,
                      processData: false,   
                      data: form_data,                         
                      type: 'post',
                      success: function(php_script_response){
                          $scope.loading=false;
                          $scope.loading=false;
                          console.log($scope.loading);
                          //alert("File Attached");
                          alert(php_script_response); // display response from the PHP script, if any

                          $('#sortpicture').val('');
                          // console.log(file_data);
                          // console.log(new_name);
                      }

              });



              
          }else{
            alert("Please select file first");
          }
          

      } 

      $scope.add_file2=function(){
         if($('#sortpicture2').val()!=='') {
              console.log($('#sortpicture2').prop('files'));
              var file_data = $('#sortpicture2').prop('files')[0]; 
              var form_data = new FormData();                  
              form_data.append('file', file_data);
              var new_name=Date.now();
              var old_name=file_data.name;
              //console.log(file_data);
              new_name=new_name+'.'+getExtension(old_name);
             
              
              //alert(new_name);
              $.ajax({
                      url: 'upload.php?new_name='+new_name+'&dir=answer', // point to server-side PHP script 
                      dataType: 'text',  // what to expect back from the PHP script, if anything
                      cache: false,
                      contentType: false,
                      processData: false,   
                      data: form_data,                         
                      type: 'post',
                      success: function(php_script_response){
                          //alert("File Attached");
                          $('#sortpicture2').val('');
                          alert(php_script_response); // display response from the PHP script, if any
                          // console.log(file_data);
                          // console.log(new_name);
                      }

              });

              
          }else{
            alert("Please select file first");
          }
          

      } 

  });
