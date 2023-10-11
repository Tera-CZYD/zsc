app.controller('CourseController', function($scope, $window, Course, Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $('.yearpicker').datepicker({

    format: "yyyy",

    autoclose: true,

    minViewMode: "years",

    pickTime: false

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Course.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

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

  $scope.selectedFilter = 'year';

  $scope.changeFilter = function(type){

    $scope.search = {};

    $scope.selectedFilter = type;

  }

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_level_term = e.data;

  });

  $scope.searchFilter = function(search) {
   
    $scope.searchTxt = '';

    $scope.year = null;

    $scope.semester = null;

    if ($scope.selectedFilter == 'year') {
    
      date = $('.yearpicker').datepicker('getDate');

      year = date.getFullYear();

      $scope.year = year;
   
    } else if($scope.selectedFilter == 'semester'){

      $scope.semester = search.semester;

    }

    $scope.load({

      year : $scope.year,

      semester : $scope.semester

    });
  
  } 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        Course.remove({ id: data.id }, function(e) {

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

  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/course?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/course?print=1');

    }

  }

});

app.controller('CourseAddController', function($scope, Course, Select) {

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

 $('.yearpicker').datepicker({

    format: "yyyy",

    autoclose: true,

    minViewMode: "years",

    pickTime: false

  });

 $scope.data = {

  Course : {}

 };

 Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_level_term = e.data;

  });

  $('#form').validationEngine('attach');

  // $scope.getCreditHours = function(){

  //   if($scope.data.Course.lecture_hours != null && $scope.data.Course.lecture_hours != '' && $scope.data.Course.laboratory_hours != null && $scope.data.Course.laboratory_hours != ''){

  //     $scope.data.Course.credit_hours = parseFloat($scope.data.Course.lecture_hours) + parseFloat($scope.data.Course.laboratory_hours);

  //   }

  // }

  // $scope.getCreditUnit = function(){

  //   if($scope.data.Course.lecture_unit != null && $scope.data.Course.lecture_unit != '' && $scope.data.Course.laboratory_unit != null && $scope.data.Course.laboratory_unit != ''){

  //     $scope.data.Course.credit_unit = parseFloat($scope.data.Course.lecture_unit) + parseFloat($scope.data.Course.laboratory_unit);

  //   }

  // }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Course.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/course';

        } else {

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

      });

      console.log($scope.data.Course);

    }  

    

  }

});

app.controller('CourseViewController', function($scope, $routeParams, DeleteSelected, Course, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    Course.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        Course.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/course";

          }

        });

      }

    });

  } 

});

app.controller('CourseEditController', function($scope, $routeParams, Course, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $('.yearpicker').datepicker({

    format: "yyyy",

    autoclose: true,

    minViewMode: "years",

    pickTime: false

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_level_term = e.data;

  });

  // $scope.getCreditHours = function(){

  //   if($scope.data.Course.lecture_hours != null && $scope.data.Course.lecture_hours != '' && $scope.data.Course.laboratory_hours != null && $scope.data.Course.laboratory_hours != ''){

  //     $scope.data.Course.credit_hours = parseFloat($scope.data.Course.lecture_hours) + parseFloat($scope.data.Course.laboratory_hours);

  //   }

  // }

  // $scope.getCreditUnit = function(){

  //   if($scope.data.Course.lecture_unit != null && $scope.data.Course.lecture_unit != '' && $scope.data.Course.laboratory_unit != null && $scope.data.Course.laboratory_unit != ''){

  //     $scope.data.Course.credit_unit = parseFloat($scope.data.Course.lecture_unit) + parseFloat($scope.data.Course.laboratory_unit);

  //   }

  // }

  // load 
  $scope.load = function() {

    Course.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.data.Course.is_computer = ($scope.data.Course.is_computer > 0) ? true : false 

      $scope.data.Course.is_jeep = ($scope.data.Course.is_jeep > 0) ? true : false

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Course.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/course';

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