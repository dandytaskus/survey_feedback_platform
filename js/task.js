  /** MODULE **/
  var app = angular.module('App',[]);

  /** CONTROLLER **/

  app.controller('Task',function($scope,$http){
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1;
      var yyyy = today.getFullYear();

      if(dd<10){
          dd='0'+dd
      }

      if(mm<10){
          mm='0'+mm
      }

      $scope.notifs=[];
      $scope.recieves=[];
      $scope.attachments=[];
      $scope.str_recievers='';
      $scope.email_reciever='';
      $scope.notif_status='enable';
      $scope.date_created= mm+'/'+dd+'/'+yyyy;

       $http.get("../api/task.php?action=GetLast  ").success(function(data){
          $scope.last_id=data;
          $scope.last_task=$scope.last_id[0].last_id;
          
       });

     

      $scope.save_task=function(){

        var conf=confirm("Are you sure you want to save this record?");
        
            angular.forEach($scope.recieves,function(recieves, index){
                  if(index==0){
                    $scope.str_recievers =recieves.item;
                  }else{
                    $scope.str_recievers=$scope.str_recievers+","+recieves.item;
                  }
             });
        
        
        if(conf == true){

               angular.forEach($scope.notifs, function (notifs, index) {
                  //console.log(notifs.title);
                    // $http.post("../api/notif.php?action=AddNew&title="+notifs.title+
                    //      "&content="+notifs.content+
                    //      "&notif_date="+notifs.notif_date+
                    //      "&task_id="+$scope.last_task).success(function(data){
                           
                    //  });

                    $http({
                         url: "../api/notif.php?action=AddNew",
                         method: "POST",
                         headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                         data: $.param({
                           title:notifs.title,
                           content:notifs.content,
                           notif_date:notifs.notif_date,
                           attachments:notifs.attachments,
                           task_id:$scope.last_task,  
                        })
                    }).success(function(data, status, headers, config) {
                        alert(data);
                    }).error(function(data, status, headers, config) {
                        alert('Error');
                    });

                });                                                                                                            

              $http.post("../api/task.php?action=AddNew&task_date="+$scope.date_created+
                 "&dead_line="+$scope.deadline+
                 "&subject="+$scope.subject+
                 "&description="+$scope.description+
                 "&email_reciever="+$scope.str_recievers+
                 "&email_sender="+$scope.email_sender+
                 "&status="+$scope.notif_status).success(function(data){
                      alert("Task Saved!"); 
                      clear_data();

                  /*console.log("api/task.php?action=AddNew&task_date="+$scope.date_created+
                 "&dead_line="+$scope.deadline+
                 "&subject="+$scope.subject+
                 "&description="+$scope.description);*/
              });

          
        } 

      };   //===end of save_task
      $scope.str_attachments="";
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
                content:$scope.notif_content,
                notif_date:$scope.notif_date,
                attachments:$scope.str_attachments  
            });
         //$scope.textContent = tinyMCE.activeEditor.getContent();
         console.log($scope.str_attachments);
         alert("Notification added");

         $scope.notif_title="";
         $scope.notif_date="";

      };

      $scope.add_recieve=function(){
        if(ValidateEmail($scope.email_reciever)){
              $scope.recieves.push({
                item:$scope.email_reciever
              });
              $scope.email_reciever=""; 
             
        }else{
              $scope.email_reciever="";   
        }
         

      };

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
          //alert(para_index);
          $scope.recieves.splice(para_index,1);
          console.log($scope.recieves);

      };

      $scope.remove_notif=function(){
          alert("Removed");         
      }

      function clear_data(){
          $scope.deadline="";
          $scope.subject="";
          $scope.description="";
          $scope.str_recievers="";
          $scope.email_sender="";
          $scope.notifs=[];
          $scope.recieves=[];
          $scope.notif_status='enable';
          $scope.date_created= mm+'/'+dd+'/'+yyyy;
      }

      function ValidateEmail(mail)   
            {  
              if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)){  
                 return (true);  
              }  
              alert("You have entered an invalid email address!");
              return (false);
      } 

  });






  /** FACTORY **/
  /**app.config(function($routeProvider){
    $routeProvider
    .when('/scoring-sequence',
      {
        //controller: 'controller/ScoringSequence',
        controller: 'ScoringSequence',
        templateUrl: 'view/scoring_sequence.html'
      }
    )
    .when('/game-sequence',
      {
        controller: 'GameSequence',
        templateUrl: 'view/game_sequence.html'
      }
    )
    .when('/team-summary-offense',
      {
        controller: 'TeamSummaryOffence',
        templateUrl: 'view/team_summary_offense.html'
      }
    )
    .when('/scoring-sequence2',
      {
        controller: 'ScoringSequence',
        templateUrl: 'view/scoring_sequence2.html'
      }
    )
    .otherwise(
      {
        redirectTo: '/scoring-sequence'
      }
    );
  });**/

  /** SERVICE **/
/**  app.service('Page', function($rootScope){
    return {
      setTitle: function(title){
        $rootScope.title = title;
      }
    }
  });**/