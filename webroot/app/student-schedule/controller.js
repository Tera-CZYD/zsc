app.controller('StudentScheduleController', function($scope, StudentSchedule) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

  $scope.timeSlots = [];

  var startTime = new Date(0, 0, 0, 7, 0); // 7:00 AM

  var endTime = new Date(0, 0, 0, 17, 0);  // 5:00 PM


  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    StudentSchedule.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.paginator = e.paginator;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.pages = paginator($scope.paginator, 5);

        $scope.timeSlots = [];

        // Define the start and end times for the time slots
        var startTime = new Date(0, 0, 0, 7, 0); // 7:00 AM
        var endTime = new Date(0, 0, 0, 17, 0);  // 6:00 PM

        // Generate the time slots in 15-minute intervals
        while (startTime <= endTime) {

            var formattedTime = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            $scope.timeSlots.push(formattedTime);

            startTime.setMinutes(startTime.getMinutes() + 30); // Increment by 15 minutes

        }

      }

    });

  }



  $scope.load();


  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/student_schedule?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_schedule?print=1');

    }

  }

});

app.controller('StudentScheduleAddController', function($scope, StudentSchedule) {

 $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $scope.data = {

    StudentSchedule : {}

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      StudentSchedule.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/StudentSchedules';

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

app.controller('StudentScheduleEditController', function($scope, $routeParams, StudentSchedule) {
  
  $scope.id = $routeParams.id;

  $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $scope.data = {

    StudentSchedule : {}

  }

  // load 

  $scope.load = function() {

    StudentSchedule.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      StudentSchedule.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/StudentSchedules';

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