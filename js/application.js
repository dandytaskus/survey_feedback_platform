  /** MODULE **/
  var app = angular.module('App',['ngRoute']);


  /** FACTORY **/
  app.config(function($routeProvider){
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
  });

  /** SERVICE **/
  app.service('Page', function($rootScope){
    return {
      setTitle: function(title){
        $rootScope.title = title;
      }
    }
  });


  /** CONTROLLER **/
  app.controller("ScoringSequence", function($scope,$http){

    $scope.player_pts = []; 
    $scope.fgScore = [],
    $scope.selected_game={},
    $scope.myGame=[];

$http.get(myIP+"api/game_ids").success(function(data){
$scope.games=data;
alert('Data Loaded');
});

$scope.set_game=function(){
  //Page.setTitle("Scoring Sequence");
	
     $scope.myGame=$scope.selected_game;
	//alert($scope.myGame._id);
     $scope.fgScore=[];
    $http.get(myIP+"api/play_by_play/"+$scope.myGame._id,function(resp){
    }).success(function(resp){
      $scope.game = resp;
      var playerList = [];

      angular.forEach($scope.game.actions, function(value){
        if(value.game_event=='field_goal' || value.game_event=='free_throw'){
          if(value.game_event=='field_goal'){
            if(typeof $scope.player_pts[value.player_id]=='undefined')
              $scope.player_pts[value.player_id] = 0;
            if(value.op.made==true){
              $scope.player_pts[value.player_id] += value.op.value;
              value.op.totpts = $scope.player_pts[value.player_id];
            }
          }else{
            if(typeof $scope.player_pts[value.player_id]=='undefined')
              $scope.player_pts[value.player_id] = 0;
            if(value.op.made==true){
              $scope.player_pts[value.player_id] += 1;
              value.op.totpts = $scope.player_pts[value.player_id];
            }
          }
          $scope.fgScore.push(value);
        }
      });
    }).error(function(){
      alert("error");
    });


    $scope.selectedEvent = "field_goal, free_throw";

    $scope.containsComparator = function(expected, actual){
      return actual.indexOf(expected) > -1;
    };

    $scope.getPts = function(PID,PTS){
      var pts = ($scope.player_pts[PID]!=undefined) ? $scope.player_pts[PID] + PTS : PTS;
        $scope.player_pts[PID] = pts;
//alert($scope.player_pts[PID]);
      return PTS;
    };
};
  });

  app.controller('GameSequence',function($scope,$http){
    $scope.Math = window.Math;
    $scope.team_win=0;
    $scope.team_lose=1;
    $scope.game = [],
    $scope.play_by_play = [],
    $scope.selected_game = {},
    $scope.test="test";

    $http.get(myIP+"api/game").success(function(data){
      $scope.games=data;
      alert('Data Loaded');
    });

    $scope.set_game=function(){
      $scope.game=$scope.selected_game;
      $http.get(myIP+"api/play_by_play/"+$scope.game._id).success(function(data){
        $scope.play_by_play=data;	
      });
    };

  });



