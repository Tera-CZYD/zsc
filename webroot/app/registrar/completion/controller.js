app.controller("CompletionController", function ($scope, Completion) {

  $scope.today = Date.parse("today").toString("MM/dd/yyyy");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $scope.load = function (options) {

    options = typeof options !== "undefined" ? options : {};

    Completion.query(options, function (e) {
      if (e.ok) {
        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);
      }
    });
  };

  $scope.load();

  $scope.reload = function (options) {

    $scope.search = {};

    $scope.searchTxt = "";

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;

    $scope.load();
  };

  $scope.searchy = function (search) {

    search = typeof search !== "undefined" ? search : "";

    if (search.length > 0) {
      $scope.load({
        search: search,
      });
    } else {
      $scope.load();
    }
  };

  $scope.selectedFilter = 'date';

  $scope.changeFilter = function(type){

    $scope.search = {};

    $scope.selectedFilter = type;

    $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
    $('.input-daterange').datepicker({
 
      format: 'mm/dd/yyyy'

    });

  }

  $scope.searchFilter = function(search) {
   
    $scope.searchTxt = '';

    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    if ($scope.selectedFilter == 'date') {
    
      $scope.dateToday = Date.parse(search.date).toString('yyyy-MM-dd');
   
    }else if ($scope.selectedFilter == 'month') {
   
      date = $('.monthpicker').datepicker('getDate');
   
      year = date.getFullYear();
   
      month = date.getMonth() + 1;
   
      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;
      
      $scope.startDate = year + '-' + month + '-01';
      
      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();
    
    }else if ($scope.selectedFilter == 'customRange') {
    
      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');
    
      $scope.endDate = Date.parse(search.endDate).toString('yyyy-MM-dd');
    
    }

    $scope.load({

      date         : $scope.dateToday,

      startDate    : $scope.startDate,

      endDate      : $scope.endDate

    });
  
  }

  $scope.remove = function (data) {

    bootbox.confirm("Are you sure you want to delete " + data.student_name + " ?",function (c) {
      if (c) {

        Completion.remove({ id: data.id }, function (e) {

          if (e.ok) {

            $.gritter.add({

              title: "Successful!",

              text: e.msg,

            });

            $scope.load();
          }

        });

      }

    });

  };

  $scope.print = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/completion?print=1" + $scope.conditionsPrint);

    } else {

      printTable(base + "print/completion?print=1");

    }

  };
});

app.controller("CompletionAddController",function ($scope, Completion, Select) {

  $("#form").validationEngine("attach");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $(".clockpicker").clockpicker({

    donetext: "Done",

    twelvehour: true,

    placement: "bottom",

  });

  $scope.data = {

    Completion: {},

  };

  Select.get({ code: "completions" }, function (e) {

    $scope.data.Completion.code = e.data;

  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

      program_id : student.program_id,

      year_term_id : student.year_term_id

    };

  };

  $scope.studentData = function (id) {

    $scope.data.Completion.student_id = $scope.student.id;

    $scope.data.Completion.student_name = $scope.student.name;

    $scope.data.Completion.student_no = $scope.student.code;

    $scope.data.Completion.year_term_id = $scope.student.year_term_id;

  };

  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      Select.get({code: 'check-student-ledger', student_id : $scope.data.Completion.student_id}, function(q) {

        if(q.data){

          Completion.save($scope.data, function (e) {

            if (e.ok) {

              $.gritter.add({

                title: "Successful!",

                text: e.msg,

              });

              window.location = "#/registrar/completion";

            } else {

              $.gritter.add({

                title: "Warning!",

                text: e.msg,

              });

            }
          
          });

        }else{

          $.gritter.add({

            title: 'Warning!',

            text:  'Student still have a pending payment from apartelle/dormitory.',

          });

        }

      });

    }

  };

});

app.controller("CompletionViewController",function ($scope, $routeParams, Completion) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {
    
    Completion.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.print = function (id) {

    printTable(base + "print/completion_form/" + id);

  };

  // remove
  $scope.remove = function (data) {

    bootbox.confirm("Are you sure you want to remove " + data.code + " ?",function (c) {

      if (c) {

        Completion.remove({ id: data.id }, function (e) {

          if (e.ok) {

            $.gritter.add({

              title: "Successful!",

              text: e.msg,

            });

            window.location = "#/registrar/completion";

          }

        });

      }

    });

  };

});

app.controller("CompletionEditController",function ($scope, $routeParams, Completion, Select) {

  $scope.id = $routeParams.id;

  $("#form").validationEngine("attach");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $(".clockpicker").clockpicker({

    donetext: "Done",

    twelvehour: true,

    placement: "bottom",

  });

  $scope.data = {

    Completion: {},

  };

  $scope.bool = [

    { id: true, value: "Yes" },

    { id: false, value: "No" },

  ];

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

    // load

  $scope.load = function () {

    Completion.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

      program_id : student.program_id,

      year_term_id : student.year_term_id

    };

  };

  $scope.studentData = function (id) {

    $scope.data.Completion.student_id = $scope.student.id;

    $scope.data.Completion.student_name = $scope.student.name;

    $scope.data.Completion.student_no = $scope.student.code;

    $scope.data.Completion.year_term_id = $scope.student.year_term_id;

  };

    $scope.update = function () {
      valid = $("#form").validationEngine("validate");

      if (valid) {
        Completion.update({ id: $scope.id }, $scope.data, function (e) {
          if (e.ok) {
            $.gritter.add({
              title: "Successful!",

              text: e.msg,
            });

            window.location = "#/registrar/completion";
          } else {
            $.gritter.add({
              title: "Warning!",

              text: e.msg,
            });
          }
        });
      }
    };
  }
);
