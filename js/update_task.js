    /** MODULE **/
  var app = angular.module('App',[]);

  /** CONTROLLER **/

  app.controller('UpdateTask',function($scope,$http, $window){

    $scope.new_notifs=[];
    $scope.attachments=[];


      $scope.get_task=function(task_id){
        $scope.task_id=task_id;
        $http.get("../api/task.php?action=SelectID&key="+task_id).success(function(data){
          $scope.selected_task=data[0];
          console.log($scope.selected_task);
          $scope.email_recievers=$scope.selected_task.email_reciever.split(',');
          $scope.get_notifs(task_id);
        });  
      }

      $scope.get_notifs=function(task_id){
          $http.get("../api/notif.php?action=GetNotif&task_id="+task_id).success(function(data){
                $scope.notifs=data; 

          });
      }

      $scope.save_task=function(){

          var conf=confirm("Are you sure you want to save this record?");
          if(conf){
            angular.forEach($scope.new_notifs, function (notifs, index) {
                    
                    // $http.post("../api/notif.php?action=AddNew&title="+notifs.title+
                    //      "&content="+notifs.content+
                    //      "&notif_date="+notifs.notif_date+
                    //      "&task_id="+$scope.task_id).success(function(data){
                    // });   

                     $http({
                         url: "../api/notif.php?action=AddNew",
                         method: "POST",
                         headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                         data: $.param({
                           title:notifs.title,
                           content:notifs.content,
                           notif_date:notifs.notif_date,
                           attachments:notifs.attachments,  
                           task_id:$scope.task_id,  
                        })
                    }).success(function(data, status, headers, config) {
                           alert('Saved!');
               
                    }).error(function(data, status, headers, config) {
                           alert('Error');
                    });
            });   

            angular.forEach($scope.email_recievers,function(email_reciever, index){
                  if(index==0){
                    $scope.str_recievers =email_reciever;
                  }else{
                    $scope.str_recievers=$scope.str_recievers+","+email_reciever;
                  }
             });

            $http.post("../api/task.php?action=UpdateTask&key="+$scope.task_id+
                 "&task_date="+$scope.selected_task.task_date+
                 "&dead_line="+$scope.deadline+
                 "&subject="+$scope.selected_task.subject+
                 "&description="+$scope.selected_task.description+
                 "&email_reciever="+$scope.str_recievers+
                 "&status="+$scope.selected_task.status+
                 "&email_sender="+$scope.selected_task.email_sender).success(function(data){  
                      alert("Task Saved!"); 
                      //clear_data();
              });



            console.log($scope.str_recievers);

            //$window.location.href="http://localhost/my_project/view/view_task.php";  
          }
      }

      $scope.add_notif=function(){
        var nicE = new nicEditors.findEditor('textarea2');
        $scope.notif_content=nicE.getContent();
         angular.forEach($scope.attachments,function(attachment, index){
                  if(index==0){
                    $scope.str_attachments =attachment.new_name;
                  }else{
                    $scope.str_attachments =$scope.str_attachments+","+attachment.new_name;
                    //$scope.str_recievers=$scope.str_recievers+","+recieves.item;
                  }
             });
        $scope.notifs.push({
            title:$scope.notif_title,
            notif_date:$scope.notif_date, 
            content:$scope.notif_content,
            attachments:$scope.str_attachments
        });

        $scope.new_notifs.push({
            title:$scope.notif_title,
            notif_date:$scope.notif_date, 
            content:$scope.notif_content
        });
         alert("Notification added");
      }

      $scope.remove_notif=function(notif_id,index){
          $scope.notifs.splice(index,1);
          alert("Removed "+notif_id);         
      }

      $scope.add_email=function(){
          $scope.email_recievers.push($scope.email_recieve);
          $scope.email_recieve="";
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
              var file_data = $('#sortpicture').prop('files')[0]; 
              var form_data = new FormData();                  
              form_data.append('file', file_data);
              var new_name=Date.now();
              var old_name=file_data.name;
              //console.log(file_data);
              new_name=new_name+'.'+getExtension(old_name);
              $scope.attachments.push({
                    new_name:new_name,
                    old_name:file_data.name
              });

              
              //alert(new_name);
              $.ajax({
                      url: 'upload.php?new_name='+new_name, // point to server-side PHP script 
                      dataType: 'text',  // what to expect back from the PHP script, if anything
                      cache: false,
                      contentType: false,
                      processData: false,   
                      data: form_data,                         
                      type: 'post',
                      success: function(php_script_response){
                          alert("File Attached");
                          // alert(php_script_response); // display response from the PHP script, if any
                          // console.log(file_data);
                          // console.log(new_name);
                      }

              });

              $('#sortpicture').val('');
          }else{
            alert("Please select file first");
          }
          

      } 


      $scope.remove_recieve=function(para_index){
          
          $scope.email_recievers.splice(para_index,1);
          console.log($scope.email_recievers);

      };
      
      
  });






