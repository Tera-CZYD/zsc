app.controller('CourseScheduleController', function($scope,$routeParams,Select,CourseSchedule) {

  $scope.curriculum_id = $routeParams.id;

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.search = {};

  Select.get({ code: 'academic-term-list' },function(e){

    $scope.academic_terms = e.data;

    if($scope.academic_terms.length > 0){

      $scope.search.academic_term_id = e.data[0].id;

      $scope.filterData();

    }

  });

  Select.get({ code: '_get_curr_courses',curriculum_id : $scope.curriculum_id },function(e){

    $scope.courses = e.data;

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    CourseSchedule.query(options, function(e) {

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

    $scope.academic_term_id = null;

    $scope.course_id = null;

    $scope.load();

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search: search,

        academic_term_id : $scope.academic_term_id,

        course_id : $scope.course_id

      });

    }else{

      $scope.load({

        academic_term_id : $scope.academic_term_id,

        course_id : $scope.course_id

      });
    
    }

  }

  $scope.filterData = function(){

    $scope.academic_term_id = null;

    $scope.course_id = null;

    if($scope.search.academic_term_id !== undefined && $scope.search.academic_term_id !== '' && $scope.search.academic_term_id !== null){

      $scope.academic_term_id = $scope.search.academic_term_id;

    }

    if($scope.search.course_id !== undefined && $scope.search.course_id !== '' && $scope.search.course_id !== null){

      $scope.course_id = $scope.search.course_id;

    }

    $scope.load({

      search : $scope.searchTxt,

      academic_term_id : $scope.academic_term_id,

      course_id : $scope.course_id

    });

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.class_name +' ?', function(c) {

      if (c) {

        CourseSchedule.remove({ id: data.id }, function(e) {

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

app.controller('CourseScheduleAddController', function($scope,$routeParams, CourseSchedule, Select) {

  $scope.curriculum_id = $routeParams.id;

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    CourseSchedule : {}

  }

  Select.get({ code: 'academic-term-list' },function(e){

    $scope.academic_terms = e.data;

    if($scope.academic_terms.length > 0){

      $scope.data.CourseSchedule.academic_term_id = e.data[0].id;

    }

  });

  Select.get({ code: '_get_curr_courses',curriculum_id : $scope.curriculum_id },function(e){

    $scope.courses = e.data;

  });

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selected = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.CourseSchedule.faculty_id = $scope.employee.id;

    $scope.data.CourseSchedule.faculty_name = $scope.employee.name;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      CourseSchedule.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/course-schedule/' + $scope.curriculum_id;

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

app.controller('CourseScheduleAddFacultyController', function($scope,$routeParams, CourseSchedule, Select) {

  $scope.faculty_id = $routeParams.id;

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    CourseSchedule : {}

  }

  Select.get({ code: 'academic-term-list' },function(e){

    $scope.academic_terms = e.data;

    if($scope.academic_terms.length > 0){

      $scope.data.CourseSchedule.academic_term_id = e.data[0].id;

    }

  });

  Select.get({ code: '_get_curr_courses',faculty_id : $scope.faculty_id },function(e){

    $scope.courses = e.data;

  });

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      $scope.data.CourseSchedule.by_faculty = true;

      $scope.data.CourseSchedule.faculty_id = $scope.faculty_id;

      CourseSchedule.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/schedule-courses/view-by-faculty-schedule/' + $scope.faculty_id;

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

app.controller('CourseScheduleViewFacultyController', function($scope, $routeParams, CourseSchedule,ClassSchedule) {
  
  $scope.id = $routeParams.id;

  $scope.faculty_id = $routeParams.faculty_id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    CourseSchedule.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.class_name +' ?', function(c) {

      if (c) {

        CourseSchedule.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = '#/schedule-courses/view-by-faculty-schedule/' + $scope.faculty_id;

          }

        });

      }

    });

  } 

});

app.controller('CourseScheduleEditFacultyController', function($scope, $routeParams, CourseSchedule, Select) {
  
  $scope.id = $routeParams.id;

  $scope.faculty_id = $routeParams.faculty_id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  Select.get({ code: 'academic-term-list' },function(e){

    $scope.academic_terms = e.data;

    if($scope.academic_terms.length > 0){

      $scope.data.CourseSchedule.academic_term_id = e.data[0].id;

    }

  });

  Select.get({ code: '_get_curr_courses',faculty_id : $scope.faculty_id },function(e){

    $scope.courses = e.data;

  });

  // load 

  $scope.load = function() {

    CourseSchedule.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      $scope.data.CourseSchedule.by_faculty = true;

      $scope.data.CourseSchedule.faculty_id = $scope.faculty_id;

      CourseSchedule.save({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/schedule-courses/view-by-faculty-schedule/' + $scope.faculty_id;

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

app.controller('CourseScheduleViewController', function($scope, $routeParams, CourseSchedule,ClassSchedule) {
  
  $scope.id = $routeParams.id;

  $scope.curriculum_id = $routeParams.curriculum_id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    CourseSchedule.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.removeClass = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.class_event +' ?', function(c) {

      if (c) {

        ClassSchedule.remove({ id: data.id }, function(e) {

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

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.course_id +' ?', function(c) {

      if (c) {

        CourseSchedule.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = '#/course-schedule/' + $scope.curriculum_id;
            
          }

        });

      }

    });

  } 

});

app.controller('CourseScheduleEditController', function($scope, $routeParams, CourseSchedule, Select) {
  
  $scope.id = $routeParams.id;

  $scope.curriculum_id = $routeParams.curriculum_id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  Select.get({ code: 'academic-term-list' },function(e){

    $scope.academic_terms = e.data;

    if($scope.academic_terms.length > 0){

      $scope.data.CourseSchedule.academic_term_id = e.data[0].id;

    }

  });

  Select.get({ code: '_get_curr_courses',curriculum_id : $scope.curriculum_id },function(e){

    $scope.courses = e.data;

  });

  // load 

  $scope.load = function() {

    CourseSchedule.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selected = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.CourseSchedule.faculty_id = $scope.employee.id;

    $scope.data.CourseSchedule.faculty_name = $scope.employee.name;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      CourseSchedule.save({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/course-schedule/' + $scope.curriculum_id;

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