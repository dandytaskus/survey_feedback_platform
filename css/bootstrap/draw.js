var drawStat = angular.module('drawStat',[]);
drawStat.controller('mainController',function($scope){

    $scope.draws = [
        1,2,3
    ];
    $scope.current_day_draw_values={};
    $scope.stations = ['A','B','C'];
    
    $scope.current_day_total = 0;
    $scope.compute_draw_val_per_station = function(station){
        //$scope.current_draw_values = val
        var total = 0;
        angular.forEach($scope.draws,function(draw){
           total+=$scope.current_day_draw_values[station+draw] ? parseInt($scope.current_day_draw_values[station+draw]):0;
        });
        return total;
    };
    $scope.compute_total_draw_val_per_draw = function(draw){
        var total = 0;
        angular.forEach($scope.stations,function(station){
           total+=$scope.current_day_draw_values[station+draw] ? parseInt($scope.current_day_draw_values[station+draw]):0;
        });
        return total;
    };
    $scope.current_day_total_draw_val = function(){
        var total = 0;
        angular.forEach($scope.stations,function(station){
            angular.forEach($scope.draws,function(draw){
                total+=$scope.current_day_draw_values[station+draw] ? parseInt($scope.current_day_draw_values[station+draw]):0;
            });
        });
        return total;
    }

    $scope.save = function(){
        console.log($scope.current_day_draw_values);
    };
});

