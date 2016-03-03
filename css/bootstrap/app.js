var offPanel = angular.module('offPanel',['timer']);
offPanel.controller('mainController',function($scope,$http){
$scope.period_duration=600;
$scope.selected_game={};
$scope.myID='';
$scope.game = [],
$scope.games = [],
$scope.to_left_light=0;
$scope.to_left_dark=0;
$scope.selected_off='';
    //game info
	$scope.game = {
		id:1,
   		time:0,
   		quarter:1,
   		plays:[],
	};

$scope.off_calls={
    game_id:'',
    game_no:'',
    date:'',
    light:{
        name:'',
        score:'',
    },
    dark:{
        name:'',
        score:'',

    },

    call:[{
        player_name:'',
        player_no:'',
        player_pos:'',
        team:'',
        call_type:'',
        call_code:'',
        period:'',
        game_time:'',
        ref_id:'',
        ref_name:'',
        ref_pos:''
        }]
 };


function saveCall(){
    $scope.date= new Date();
    //alert($scope.off_calls.player_pos);

    if($scope.off_calls.team==''){
	alert('Please select a team member');
    }else if(($scope.off_calls.call_type=='') || ($scope.off_calls.call_code=='')){
	alert('Please select call');
    }else if($scope.off_calls.ref_id==''){
	alert('Please select official');
    }else{
    $http.post("ajax/addOffCalls.php?game_id="+$scope.off_calls.game_id+
                                    "&game_no="+$scope.off_calls.game_no+
                                    "&game_date="+$scope.off_calls.date+
                                    "&team="+$scope.off_calls.team+
                                    "&player_name="+$scope.off_calls.player_name+
                                    "&player_no="+$scope.off_calls.player_no+
                                    "&player_pos="+$scope.off_calls.player_pos+
                                    "&call_code="+$scope.off_calls.call_code+
                                    "&call_type="+$scope.off_calls.call_type+
                                    "&ref_id="+$scope.off_calls.ref_id+
                                    "&ref_name="+$scope.off_calls.ref_name+
                                    "&ref_pos="+$scope.off_calls.ref_pos+
                                    "&period="+$scope.off_calls.period+
                                    "&clock="+$scope.clock+
                                    "&light="+$scope.off_calls.light.name+
                                    "&dark="+$scope.off_calls.dark.name+
                                    "&milis="+$scope.milis).success(function(data){
				    //alert($scope.off_calls.date);
                                    });
	clear();
   }


};

$scope.key_press=function(e){

    if(e.which==122){
	   if($scope.timerRunning)
            $scope.$broadcast('timer-stop');
        else
            $scope.$broadcast('timer-start');
            $scope.timerRunning = !$scope.timerRunning
    }else if(e.which==120){
        $scope.set_call_type('Violation');
        $scope.off_calls.call_code='Out of Bounds';
    }else if(e.which==116){
        $scope.off_calls.call_code='Regular Time out';
        $scope.set_call_type('Time Out');
    }

     if((e.which>=49)&&(e.which<=55)){

        $scope.off_calls.period=e.which-48;

     }

	//alert(e.which);

};



function callBoard(){

	$http.get("ajax/getTotal.php?game_id="+$scope.off_calls.game_id).success(function(data){
		$scope.call_boards=data[0];
		//console.log($scope.call_boards);
	/**if($scope.off_calls.period<=2){
		$scope.dark_time=$call_boards.dark_time_out_1st;
		$scope.light_time=$call_boards.light_time_out_1st;
	}else if($scope.off_calls.period<=4){
		$scope.dark_time=$call_boards.dark_time_out_2nd;
                $scope.light_time=$call_boards.light_time_out_2nd;
	}else{
		$scope.dark_time=$call_boards.dark_time_out_OT;
                $scope.light_time=$call_boards.light_time_out_OT;
	}**/
	//alert($call_boards.dark_time_out_1st);
    //alert('Here');
		
	});
};



    //teams

    $http.get(myIP+"/api/game_ids").success(function(data){
        $scope.games=data;

    });


    $scope.team = {
            light:{
                team_name:'',
                team_id:'',
                score:00,
                    players:[],
                    players_in_game:[],
            },
            dark:{
                team_name:'',
                team_id:'',
                score:00,
                players:[],
                players_in_game:[],
            }
        };
    $scope.referees=[];



    $scope.set_game=function(){
        $scope.myID=$scope.selected_game._id;
        $http.get(myIP+"/api/game/"+$scope.myID).success(function(data){
            $scope.game=data;
      
                $scope.team.light.team_name=$scope.game.teams[0].team_name;
                $scope.team.light.team_id=$scope.game.teams[0]._id;
                $scope.team.light.score=$scope.game.teams[0].score;            
       
                $scope.team.dark.team_name=$scope.game.teams[1].team_name;
                $scope.team.dark.team_id=$scope.game.teams[1]._id;
                $scope.team.dark.score=$scope.game.teams[1].score;

            $scope.team.light.players_in_game=$scope.game.teams[0].players;
            $scope.team.dark.players_in_game=$scope.game.teams[1].players;
            $scope.referees=$scope.game.officials
            //console.log($scope.referees);            
            $scope.off_calls.game_id=$scope.game._id;
            $scope.off_calls.game_no=$scope.game.no;
            $scope.off_calls.date=$scope.game.sched.date;
            $scope.off_calls.light.name=$scope.game.teams[0].team_name;
            $scope.off_calls.light.score=$scope.game.teams[0].score;
            $scope.off_calls.dark.name=$scope.game.teams[1].team_name;
            $scope.off_calls.dark.score=$scope.game.teams[1].score;
            $scope.off_calls.period='1';
            $scope.period_duration=600;
	    clear();
	    callBoard();
	    $scope.to_left_light=2;
            $scope.to_left_dark=2;
            //console.log($scope.off_calls);
            //alert($scope.game.sched.date);

            /**$http.post("http://172.31.1.243:81/api/off_calls",$scope.off_calls).success(function(resp){
                    $rootScope.$broadcast('respHandler',{
                        method:'off_calls.save',
                        data:resp
                    });
            }).error(function(err){
                alert('error');
                console.log(err);
            });**/

        });
    }; 

    //button statuses
    $scope.btn = {
        player_select:{
            light:{
                enabled:false
            },
            dark:{
                enabled:false
            }
        },
        fg_shot_type:{enabled:false},
        block:{enabled:false},
        rebound:{enabled:false}
    };

    $scope.change_period=function(){

         if($scope.off_calls.period>4){
                  $scope.period_duration=300;
                  $scope.clock="05:00";
		  //$scope.to_left_light=1;
		  //$scope.to_left_dark=1;
         }else{
                  $scope.period_duration=600;
                     $scope.clock="10:00";
 		  /**if($scope.off_calls.period<=2){
			$scope.to_left_light=2;
			$scope.to_left_dark=2;
		  }else{
			$scope.to_left_light=3;
			$scope.to_left_dark=3;
		  }**/
                }
        //alert($scope.period_duration);
    };

    
    $scope.current_action = '';
    $scope.selected_player='';
    $scope.selected_team='';

    //player selection for action
    $scope.player_select = function(team,player){
        //console.log(player);
        $scope.non_player='';
        $scope.selected_player = player._id;
        $scope.off_calls.player_name=player.last_name+','+player.first_name;
        $scope.off_calls.player_no=player.no;
        $scope.off_calls.team=team;
        //console.log($scope.off_calls);
        
    };


    $scope.non_player_select=function(staff,team,selected){
        $scope.selected_player = '';
        $scope.non_player=selected;
        $scope.off_calls.player_name=staff;
        $scope.off_calls.player_no=0;
        $scope.off_calls.team=team;
        $scope.off_calls.player_pos='none';

    };

    //Set Player Location
    $scope.player_Loc = function(zone){
        $scope.btn.player_select.dark.enabled=true;
        $scope.btn.player_select.light.enabled=true;
        $scope.off_calls.player_pos=zone;
        //console.log($scope.off_calls);
    };

    $scope.set_call_type= function(call_type){
        $scope.off_calls.call_type=call_type;

        if(($scope.off_calls.call_code=='Regular Time out') || ($scope.off_calls.call_code=='24 Seconds')){
            
            $scope.selected_off='Tbl';
            $scope.off_calls.ref_id='offTables';
            $scope.off_calls.ref_name='table';
        }
        //console.log($scope.off_calls);
    };

    $scope.set_ref_pos=function(ref_pos){
        $scope.off_calls.ref_pos=ref_pos;
    };

    $scope.select_off=function (ref_name,ref_id,ref_sel){
        $scope.selected_off=ref_sel;
        $scope.off_calls.ref_id=ref_id;
        $scope.off_calls.ref_name=ref_name;
        //console.log($scope.off_calls);

    };

    $scope.cancel=function(){
        clear();
    };
   
    $scope.undo=function(){

    if(confirm("Are you sure you want to undo the previous call?")==true){
        clear();
        $http.get("ajax/getLast.php").success(function(data){
        last_id=data
            myID=last_id[0].maxId;
        $http.post("ajax/undo.php?call_id="+myID).success(function(data){
        });

        })    
    }

    
    };


    //save off call

    $scope.save_call=function(){
        //$scope.off_calls.game_time=$scope
        //alert($scope.clock);
        //alert($scope.off_calls.game_id);
        //console.log($scope.off_calls);
        saveCall();
	callBoard();
       // clear();

    };
    
    //button switch
    var player_select_btn_switch = function(enabled,team){
       if(team){
            if(team=='light'){
                $scope.btn.player_select.light.enabled = enabled;
                $scope.btn.player_select.dark.enabled = !enabled;
            }else{
                $scope.btn.player_select.dark.enabled = enabled;
                $scope.btn.player_select.light.enabled = !enabled
            }
       }else{
            $scope.btn.player_select.dark.enabled = enabled;
            $scope.btn.player_select.light.enabled = enabled
       }
       
    };

    var clear = function(){
        $scope.off_calls.player_name='',
        $scope.off_calls.player_no='',
        $scope.off_calls.player_pos='none',
        $scope.off_calls.ref_id='',
        $scope.off_calls.ref_name='',
        $scope.off_calls.ref_pos='',
        $scope.off_calls.call_type='',
        $scope.off_calls.call_code='',
        $scope.off_calls.team='',
        $scope.selected_off='';
        $scope.selected_player='';
	$scope.non_player='';

    }
    //timer

    $scope.timerRunning = false;
    $scope.startStopTimer = function (){              
        if($scope.timerRunning)                	
            $scope.$broadcast('timer-stop');
        else
            $scope.$broadcast('timer-start');
        $scope.timerRunning = !$scope.timerRunning
    };
    $scope.$on('timer-tick',function(event,args){
        $scope.clock = args.mins + ':' +args.secs;
        $scope.milis=args.millis;

    });

    $scope.adjust_Clock = function (secs) {
        $scope.$broadcast('timer-add-cd-seconds', secs);
        $scope.$broadcast('timer-stop');
    }

});

