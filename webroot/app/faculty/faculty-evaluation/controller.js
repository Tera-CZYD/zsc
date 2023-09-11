app.controller('FacultyEvaluationController', function($scope, FacultyEvaluation,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  Select.get({code: 'faculty-evaluation-list'}, function(e) {

    console.log(e.data);

    $scope.datas = e.data;

  });

  
  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.load();

  }



  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/faculty_evaluation?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/faculty_evaluation?print=1');

    }

  }

});

app.controller('FacultyEvaluationAddController', function($scope,$routeParams, FacultyEvaluation,Employee, Select, Student) {

 $('#form').validationEngine('attach');
  $scope.today = Date.parse('today').toString('MM/dd/yyyy');
  $scope.employee_id = $routeParams.id;
  $scope.enrolled_course = $routeParams.course;
  $scope.course_id = $routeParams.course_id;
  // console.log($routeParams);
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

    FacultyEvaluation : {

      date : $scope.today

    }

  }

  Select.get({code: 'faculty-evaluation-code'}, function(e) {

    $scope.data.FacultyEvaluation.code = e.data;

    Student.get({ id: e.studentId }, function(response) {
      // console.log(response);
      $scope.data.FacultyEvaluation.student_id = response.data.Student.id;

      $scope.data.FacultyEvaluation.student_name = response.data.Student.full_name;

      $scope.data.FacultyEvaluation.student_no = response.data.Student.student_no;
      $scope.data.FacultyEvaluation.school_year = response.data.Student.school_year;
      $scope.data.FacultyEvaluation.year_term_id = response.data.Student.year_term_id;
    });

  });
    Employee.get({ id: $scope.employee_id }, function(e) {

      $scope.data.Employee = e.data;

      $scope.data.FacultyEvaluation.employee_id = $scope.data.Employee.Employee.id;
      $scope.data.FacultyEvaluation.employee_no = $scope.data.Employee.Employee.code;
      $scope.data.FacultyEvaluation.employee_name = $scope.data.Employee.Employee.full_name;
      $scope.data.FacultyEvaluation.college_id = $scope.data.Employee.Employee.college_id;

// console.log($scope.data.Employee.Employee);
    });

    $scope.data.FacultyEvaluation.course_id = $scope.course_id;

    $scope.data.FacultyEvaluation.enrolled_course_id = $scope.enrolled_course;
console.log($scope.data.FacultyEvaluation.course_id);
  $scope.searchStudent = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-student';

    Select.query(options, function(e) {

      $scope.students = e.data.result;

      $scope.student = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal('show');

    });

  }

  $scope.selectedStudent = function(student) { 

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.code + ' - ' + student.name

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.CounselingAppointment.student_id = $scope.student.id;

    $scope.data.CounselingAppointment.student_name = $scope.student.name;

  }

  $scope.save = function() {

    bootbox.confirm('Note: You cannot redo the evaluation. Are you sure you want to save?', function(b){

      if(b) {

        valid = $("#form").validationEngine('validate');
        
        if (valid) {

          FacultyEvaluation.save($scope.data, function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text:  e.msg,

              });

// window.location.reload();
              window.location.href = '#/faculty/faculty-evaluation';
              window.location.reload();
              Swal.fire({
                title: 'Please Wait !',
                html: 'data uploading',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

              // $scope.load();

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

  }

});

app.controller('FacultyEvaluationViewController', function($scope, $routeParams, FacultyEvaluation) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    FacultyEvaluation.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        FacultyEvaluation.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/faculty/Faculty-evaluation";

          }

        });

      }

    });

  } 

});

app.controller('AdminFacultyEvaluationController', function($scope, FacultyEvaluation) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    FacultyEvaluation.query(options, function(e) {
console.log(e);
      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

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

  $scope.advance_search = function() {

    $scope.search = {};

    $scope.advanceSearch = false;
 
    $scope.position_id = null;
 
    $scope.office_id = null;

    $('.monthpicker').datepicker({

      format: 'MM',

      autoclose: true,

      minViewMode: 'months',

      maxViewMode: 'months'

    });

    $('.input-daterange').datepicker({

      format: 'yyyy-mm-dd'

    });

    $('.datepicker').datepicker('setDate', '');

    $('.monthpicker').datepicker('setDate', '');

    $('.input-daterange').datepicker('setDate', '');

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {

    $scope.filter = false;

    $scope.advanceSearch = true;

    $scope.searchTxt = '';

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;

    if (search.filterBy == 'today') {

      $scope.dateToday = Date.parse('today').toString('yyyy-MM-dd');

      $scope.today = Date.parse('today').toString('yyyy-MM-dd');


      $scope.dateToday = $scope.today;

      $scope.load({

        date: $scope.dateToday

      });

    }else if (search.filterBy == 'date') {

      $scope.dateToday = Date.parse(search.date).toString('yyyy-MM-dd');

      $scope.load({

        date: $scope.dateToday

      });

    }else if (search.filterBy == 'month') {

      date = $('.monthpicker').datepicker('getDate');

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;

      $scope.startDate = year + '-' + month + '-01';

      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();

      $scope.load({

        startDate: $scope.startDate,

        endDate: $scope.endDate

      });

    }else if (search.filterBy == 'this-month') {

      date = new Date();

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;

      $scope.startDate = year + '-' + month + '-01';

      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();

      $scope.load({

        startDate: $scope.startDate,

        endDate: $scope.endDate

      });

    }else if (search.filterBy == 'custom') {

      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');

      $scope.endDate =  Date.parse(search.endDate).toString('yyyy-MM-dd');


    }

    $scope.load({

      date        : $scope.dateToday,

      startDate   : $scope.startDate,

      endDate     : $scope.endDate,

    });

    $('#advance-search-modal').modal('hide');

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        CounselingAppointment.remove({ id: data.id }, function(e) {

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

    if ($scope.conditionsPrintPending !== '') {
    
      printTable(base + 'print/faculty_evaluation?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/faculty_evaluation?print=1');

    }

  }

});

app.controller('AdminFacultyEvaluationViewController', function($scope, $routeParams, FacultyEvaluation) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    FacultyEvaluation.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.print = function(id){
  
    printTable(base + 'print/faculty_evaluation_form/'+id);

  }

});
app.controller('AdminFacultyEvaluationViewScoreController', function($scope, $routeParams, FacultyEvaluation,Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  Select.get({code: 'faculty-evaluation-score',id:$scope.id}, function(e) {

    console.log(e);

    $scope.datas = e.data;

  });  

  $scope.print = function(id){
  
    printTable(base + 'print/faculty_score?print=1');

  }

});
app.controller('AdminFacultyEvaluationViewCommentController', function($scope, $routeParams, FacultyEvaluation,Select) {

  $scope.id = $routeParams.id;



  // load 
  Select.get({code: 'faculty-evaluation-comment',id:$scope.id}, function(e) {

    console.log(e);

    $scope.datas = e.data;

  });


  $scope.print = function(id){
  // console.log(id);
    printTable(base + 'print/faculty_comment_form/'+$scope.id);

  }

});