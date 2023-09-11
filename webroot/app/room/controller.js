app.controller('RoomController', function($scope, Room) {



  $scope.today = Date.parse('today').toString('MM/dd/yyyy');



  $('.datepicker').datepicker({

   

    format: 'mm/dd/yyyy',

   

    autoclose: true,

   

    todayHighlight: true

  

  });



  $scope.load = function(options) {



    options = typeof options !== 'undefined' ?  options : {};



    Room.query(options, function(e) {



      if (e.ok) {



        $scope.datas = e.data;



        $scope.paginator = e.paginator;



        $scope.pages = paginator($scope.paginator, 5);



      }



    });



  }



  $scope.load();

  

  $scope.reload = function(options) {

  

    $scope.search = {};

 

    $scope.searchTxt = '';

   

    $scope.dateToday = null;

   

    $scope.startDate = null;

   

    $scope.endDate = null;



    $scope.load();



  }



  $scope.searchy = function(search) {



    search = typeof search !== 'undefined' ? search : '';



    if (search.length > 0){



      $scope.load({



        search: search



      });



    }else{



      $scope.load();

    

    }



  }



  $scope.remove = function(data) {



    bootbox.confirm('Are you sure you want to delete ' + data.room_code +' ?', function(c) {



      if (c) {



        Room.remove({ id: data.id }, function(e) {



          if (e.ok) {



            $.gritter.add({



              title: 'Successful!',



              text:  e.msg,



            });



            $scope.load();



          }



        });



      }



    });



  }



});



app.controller('RoomAddController', function($scope, Room, Select) {

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $('#form').validationEngine('attach');

   $scope.load = function() {

    Room.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  Select.get({code: 'building-list'}, function(e) {

    $scope.building = e.data;

  });

  Select.get({code: 'room-type-list'}, function(e) {

    $scope.room_type = e.data;

  });

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');    

    if (valid) {

      Room.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });



          window.location = '#/room';

        } else {

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

      });

    }  

  }

});



app.controller('RoomViewController', function($scope, $routeParams, Room) {



  $scope.id = $routeParams.id;



  $scope.data = {};



  // load 

  $scope.load = function() {



    Room.get({ id: $scope.id }, function(e) {



      $scope.data = e.data;



    });



  }



  $scope.load();  



  // remove 

  $scope.remove = function(data) {



    bootbox.confirm('Are you sure you want to remove '+ data.room_code +' ?', function(c) {



      if (c) {



        Room.remove({ id: data.id }, function(e) {



          if (e.ok) {



            $.gritter.add({



              title: 'Successful!',



              text:  e.msg,



            });



            window.location = "#/room";



          }



        });



      }



    });



  } 



});



app.controller('RoomEditController', function($scope, $routeParams, Room, Select) {

  

  $scope.id = $routeParams.id;



  $("#form").validationEngine('attach');



  $('.datepicker').datepicker({



    format:    'mm/dd/yyyy',



    autoclose: true,



    todayHighlight: true,



  });



  Select.get({code: 'building-list'}, function(e) {



    $scope.building = e.data;



  });



  Select.get({code: 'room-type-list'}, function(e) {



    $scope.room_type = e.data;



  });



  // load 



  $scope.load = function() {



    Room.get({ id: $scope.id }, function(e) {



      $scope.data = e.data;



    });



  }

  

  $scope.load();



  $scope.update = function() {



    valid = $("#form").validationEngine('validate');



    if (valid) {



      Room.update({id:$scope.id}, $scope.data, function(e) {



        if (e.ok) {



          $.gritter.add({



            title: 'Successful!',



            text:  e.msg,



          });



          window.location = '#/room';



        } else {



          $.gritter.add({



            title: 'Warning!',



            text:  e.msg,

            

          });



        }

        

      }); 



    }



  }



});