  /** MODULE **/
  var app = angular.module('App',[]);

  /** CONTROLLER **/

  app.controller('ViewTask',function($scope,$http, $window){

      $http.get("../api/task.php?action=SelectAll").success(function(data){
        $scope.my_tasks=data;
      });

      $scope.remove_task=function(task_id){
        var conf=confirm("Are you sure you want to remove this record?");
          if(conf){
                $http.post("../api/task.php?action=DeleteTast&key="+task_id).success(function(data){
                    alert("Record deleted ");
                    $scope.my_tasks=[];
                    $http.get("../api/task.php?action=SelectAll").success(function(data){
                      $scope.my_tasks=data;
                    });  
                });
          }
      }


     $scope.update_task=function(task_id){
      $window.location.href="../view/update_task.php?id="+task_id;
     }
  });






