  /** MODULE **/
  var app = angular.module('App',[]);

  /** CONTROLLER **/

  app.controller('ViewTask',function($scope,$http, $window){
    $scope.select_status="All";
    $scope.select_sender="";
    $scope.select_date_from="";
    $scope.select_date_to="";


   

      $scope.generate_report=function(){
        $scope.my_tasks=[];
        $http.get("../api/reports.php?action=SelectNotifTask&sender="+$scope.select_sender+
                    "&status="+$scope.select_status+
                    "&date_from="+$scope.select_date_from+
                    "&date_to="+$scope.select_date_to).success(function(data){
            $scope.my_tasks=data;
            // console.log($scope.my_tasks);
             console.log("api/reports.php?action=SelectNotifTask&sender="+$scope.select_sender+"&status="+$scope.select_status+"&date_from="+$scope.select_date_from+"&date_to="+$scope.select_date_to);
        });
      }

      $scope.print_report=function(){
          window.open("../view/print_email_report.php?sender="+$scope.select_sender+
                    "&status="+$scope.select_status+
                    "&date_from="+$scope.select_date_from+
                    "&date_to="+$scope.select_date_to);

      }

      $scope.export_excel=function(){
          window.open("../view/print_email_report.php?sender="+$scope.select_sender+
                    "&status="+$scope.select_status+
                    "&date_from="+$scope.select_date_from+
                    "&date_to="+$scope.select_date_to+
                    "&export=1");

      }

      $scope.remove_task=function(task_id){
        var conf=confirm("Are you sure you want to remove this record?");
          if(conf){
                $http.post("../api/task.php?action=DeleteTast&key="+task_id).success(function(data){
                    alert("Record deleted ");
                    $scope.my_tasks=[];
                    $http.get("../api/reports.php?action=SelectNotifTask").success(function(data){
                      $scope.my_tasks=data;
                    });  
                });
          }
      }


     $scope.update_task=function(task_id){
      $window.location.href="../view/update_task.php?id="+task_id;
     }
  });
