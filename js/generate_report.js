  var app = angular.module('App',[]);

  /** CONTROLLER **/


  app.controller('MainContoller',function($scope, $window, $http){
      $scope.loading=false;
      $scope.site=[];
      $scope.select_date_to="";
      $scope.select_date_from="";

        $scope.test=function(){
          $scope.loading=false;
          alert("Here");
        }

        $scope.goto_reports=function(){
          $window.open('upload_database.php');
        }

        $scope.pivote_reports=function(){
          $window.open("pivoted_report.php?date_to="+$scope.select_date_to+
                      "&date_from="+$scope.select_date_from);
        }



        $scope.generate_report=function(){  
          $scope.results=[];
           $http.get("api/reports.php?date_to="+$scope.select_date_to+
                      "&date_from="+$scope.select_date_from).success(function(data){
              $scope.results=data;
           });
     
        }

        $scope.update_site=function(my_index,my_name){
          // alert($scope.site[my_index]);
          // alert(my_name);
          
          $http.post("api/update_tag.php?site="+$scope.site[my_index]+"&key_name="+my_name).success(function(data){  
                        alert("Record Saved!"); 
                        //clear_data();
          });


        }

  });
