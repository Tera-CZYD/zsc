app.controller('SpecializationController', function($scope, $window, Specialization) {



  $scope.today = Date.parse('today').toString('MM/dd/yyyy');



  $('.datepicker').datepicker({

   

    format: 'mm/dd/yyyy',

   

    autoclose: true,

   

    todayHighlight: true

  

  });



  $scope.load = function(options) {



    options = typeof options !== 'undefined' ?  options : {};



    Specialization.query(options, function(e) {



      if (e.ok) {



        $scope.datas = e.data;



        $scope.paginator = e.paginator;



        $scope.pages = paginator($scope.paginator, 5);



      }



    });



  }

  $scope.scrollToTop = function() {

    $window.scrollTo(0, 0);

  };

  $scope.scrollToTop();

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



        Specialization.remove({ id: data.id }, function(e) {



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



app.controller('SpecializationAddController', function($scope, Specialization, Select) {

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $('#form').validationEngine('attach');

   $scope.load = function() {

    Specialization.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');    

    if (valid) {

      Specialization.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });



          window.location = '#/faculty/specialization';

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



app.controller('SpecializationViewController', function($scope, $routeParams, Specialization) {



  $scope.id = $routeParams.id;



  $scope.data = {};



  // load 

  $scope.load = function() {



    Specialization.get({ id: $scope.id }, function(e) {



      $scope.data = e.data;



    });



  }



  $scope.load();  



  // remove 

  $scope.remove = function(data) {



    bootbox.confirm('Are you sure you want to remove '+ data.room_code +' ?', function(c) {



      if (c) {



        Specialization.remove({ id: data.id }, function(e) {



          if (e.ok) {



            $.gritter.add({



              title: 'Successful!',



              text:  e.msg,



            });



            window.location = "#/faculty/specialization";



          }



        });



      }



    });



  } 



});



app.controller('SpecializationEditController', function($scope, $routeParams, Specialization, Select) {

  

  $scope.id = $routeParams.id;



  $("#form").validationEngine('attach');



  $('.datepicker').datepicker({



    format:    'mm/dd/yyyy',



    autoclose: true,



    todayHighlight: true,



  });




  // load 



  $scope.load = function() {



    Specialization.get({ id: $scope.id }, function(e) {



      $scope.data = e.data;



    });



  }

  

  $scope.load();



  $scope.update = function() {



    valid = $("#form").validationEngine('validate');



    if (valid) {



      Specialization.update({id:$scope.id}, $scope.data, function(e) {



        if (e.ok) {



          $.gritter.add({



            title: 'Successful!',



            text:  e.msg,



          });



          window.location = '#/faculty/specialization';



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