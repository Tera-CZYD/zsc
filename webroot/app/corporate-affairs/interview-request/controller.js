app.controller('InterviewRequestController', function($scope, InterviewRequest) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    InterviewRequest.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.approve = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 1;

    InterviewRequest.query(options, function(e) {

      if (e.ok) {

        $scope.datasApprove = e.data;

        $scope.conditionsPrintApprove = e.conditionsPrint;

        $scope.paginatorApprove = e.paginator;

        $scope.pagesApprove = paginator($scope.paginatorApprove, 5);

      }

    });

  }

  $scope.disapprove = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 2;

    InterviewRequest.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapprove = e.data;

        $scope.conditionsPrintDisapprove = e.conditionsPrint;

        $scope.paginatorDisapprove = e.paginator;

        $scope.pagesDisapprove = paginator($scope.paginatorDisapprove, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approve(options);

    $scope.disapprove(options);

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

        InterviewRequest.remove({ id: data.id }, function(e) {
  
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
  
      printTable(base + 'print/interview_request?print=1' + $scope.conditionsPrint);
  
    }else{
  
      printTable(base + 'print/interview_request?print=1');
  
    }
 
  }

  $scope.printApprove = function () {

    date = "";
  
    if ($scope.conditionsPrint !== "") {
  
      printTable(base + "print/interview_request?print=1" + $scope.conditionsPrintApprove);
  
    } else {
  
      printTable(base + "print/interview_request?print=1");
  
    }
  
  };
  
  $scope.printDisapprove = function () {
  
    date = "";
  
    if ($scope.conditionsPrint !== "") {
  
      printTable(base + "print/interview_request?print=1" + $scope.conditionsPrintDisapprove);
  
    } else {
  
      printTable(base + "print/interview_request?print=1");
  
    }
  
  };

});

app.controller('InterviewRequestAddController', function($scope, InterviewRequest, Select) {

 $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    setDate: new Date(),

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

    InterviewRequest : {}

  }

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  Select.get({code: 'interview-request-code'}, function(e) {

    $scope.data.InterviewRequest.code = e.data;

  });


  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.InterviewRequest.student_id = null;

      $scope.data.InterviewRequest.student_name = null;

    }

  }

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

    bDate = new Date(student.date_of_birth);

    var age = getAge(bDate);

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.name,

    }; 
    

  }

  $scope.studentData = function(id) {

    $scope.data.InterviewRequest.student_id = $scope.student.id;

    $scope.data.InterviewRequest.student_name = $scope.student.name;

    $scope.data.InterviewRequest.student_no = $scope.student.code;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      InterviewRequest.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/interview-request';

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

app.controller('InterviewRequestViewController', function($scope, $routeParams, InterviewRequest,  InterviewRequestApprove, InterviewRequestDisapprove) {

  $('#form').validationEngine('attach');

  $scope.id = $routeParams.id;

  $scope.data = {

    InterviewRequest : {}

  }

  // load 

  $scope.load = function() {

    InterviewRequest.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.approve = function(data){

    valid = $("#form").validationEngine("validate");

    if(valid){

      bootbox.confirm('Are you sure you want to mark as Approve?', function(e){

      if(e) {

        InterviewRequestApprove.update({id:data.id},$scope.data, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          window.location = "#/corporate-affairs/interview-request";

        });

      }

    });

    }

  }

  $scope.disapprove = function(data){  

    bootbox.confirm('Are you sure you want to disapprove interview ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            InterviewRequestDisapprove.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Interview Request has been disapproved.'

                });

                $scope.load();

                window.location = "#/corporate-affairs/interview-request";

              }

            });

          }

        });

      }

    });

  }

  $scope.load();  

  $scope.print = function(id){
  
    printTable(base + 'print/medical_certificate_form/'+id);

  }

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        InterviewRequest.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/corporate-affairs/interview-request";
 
          }
    
        });
    
      }
    
    });
  
  } 

});

app.controller('InterviewRequestEditController', function($scope, $routeParams, InterviewRequest, Select) {
  
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

    InterviewRequest : {}

  }

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  Select.get({code: 'interview-request-code'}, function(e) {

    $scope.data.InterviewRequest.code = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.InterviewRequest.year = val.value;

        }

      });

    }

  }

  // load 

  $scope.load = function() {

    InterviewRequest.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

   $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.InterviewRequest.student_id = null;

      $scope.data.InterviewRequest.student_name = null;

    }

  }

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

    bDate = new Date(student.date_of_birth);

    var age = getAge(bDate);

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.name,

    }; 
    

  }

  $scope.studentData = function(id) {

    $scope.data.InterviewRequest.student_id = $scope.student.id;

    $scope.data.InterviewRequest.student_name = $scope.student.name;

    $scope.data.InterviewRequest.student_no = $scope.student.code;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      InterviewRequest.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/interview-request';

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



app.controller("StudentInterviewRequestController", function ($scope, InterviewRequest) {

  $scope.today = Date.parse("today").toString("MM/dd/yyyy");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 0;

    options['status'] = 0;

    InterviewRequest.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.approve = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 1;

    InterviewRequest.query(options, function(e) {

      if (e.ok) {

        $scope.datasApprove = e.data;

        $scope.conditionsPrintApprove = e.conditionsPrint;

        $scope.paginatorApprove = e.paginator;

        $scope.pagesApprove = paginator($scope.paginatorApprove, 5);

      }

    });

  }

  $scope.disapprove = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 2;

    options['status'] = 2;

    InterviewRequest.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapprove = e.data;

        $scope.conditionsPrintDisapprove = e.conditionsPrint;

        $scope.paginatorDisapprove = e.paginator;

        $scope.pagesDisapprove = paginator($scope.paginatorDisapprove, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approve(options);

    $scope.disapprove(options);

  }

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

  $scope.advance_search = function () {

    $scope.search = {};

    $scope.advanceSearch = false;

    $scope.position_id = null;

    $scope.office_id = null;

    $(".monthpicker").datepicker({

      format: "MM",

      autoclose: true,

      minViewMode: "months",

      maxViewMode: "months",

    });

    $(".input-daterange").datepicker({

      format: "yyyy-mm-dd",

    });

    $(".datepicker").datepicker("setDate", "");

    $(".monthpicker").datepicker("setDate", "");

    $(".input-daterange").datepicker("setDate", "");

    $("#advance-search-modal").modal("show");

  };

  $scope.searchFilter = function (search) {

    $scope.filter = false;

    $scope.advanceSearch = true;

    $scope.searchTxt = "";

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;

    if (search.filterBy == "today") {

      $scope.dateToday = Date.parse("today").toString("yyyy-MM-dd");

      $scope.today = Date.parse("today").toString("yyyy-MM-dd");

      $scope.dateToday = $scope.today;

      $scope.load({

        date: $scope.dateToday,

      });

    } else if (search.filterBy == "date") {

      $scope.dateToday = Date.parse(search.date).toString("yyyy-MM-dd");

      $scope.load({

        date: $scope.dateToday,

      });

    } else if (search.filterBy == "month") {

      date = $(".monthpicker").datepicker("getDate");

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = "0" + month;

      $scope.startDate = year + "-" + month + "-01";

      $scope.endDate = year + "-" + month + "-" + lastDay.getDate();

      $scope.load({

        startDate: $scope.startDate,

        endDate: $scope.endDate,

      });

    } else if (search.filterBy == "this-month") {

      date = new Date();

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = "0" + month;

      $scope.startDate = year + "-" + month + "-01";

      $scope.endDate = year + "-" + month + "-" + lastDay.getDate();

      $scope.load({

        startDate: $scope.startDate,

        endDate: $scope.endDate,

      });

    } else if (search.filterBy == "custom") {

      $scope.startDate = Date.parse(search.startDate).toString("yyyy-MM-dd");

      $scope.endDate = Date.parse(search.endDate).toString("yyyy-MM-dd");

    }

    $scope.load({

      date: $scope.dateToday,

      startDate: $scope.startDate,

      endDate: $scope.endDate,

    });

    $("#advance-search-modal").modal("hide");

  };

  $scope.remove = function (data) {

    bootbox.confirm(

      "Are you sure you want to delete " + data.code + " ?",

      function (c) {

        if (c) {

          InterviewRequest.remove({ id: data.id }, function (e) {

            if (e.ok) {

              $.gritter.add({

                title: "Successful!",

                text: e.msg,

              });

              $scope.load();

            }

          });

        }

      }

    );

  };

});

app.controller( "StudentInterviewRequestAddController", function ($scope, InterviewRequest, Select,Student) {

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

    InterviewRequest : {}

  }

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  Select.get({ code: "interview-request-code" }, function (e) {

    $scope.data.InterviewRequest.code = e.data;

    Student.get({ id: e.studentId }, function(response) {

      $scope.data.InterviewRequest.student_id = response.data.Student.id;

      $scope.data.InterviewRequest.student_name = response.data.Student.full_name;

      $scope.data.InterviewRequest.course_id = response.data.Student.program_id;

      $scope.data.InterviewRequest.year = response.data.YearLevelTerm.year;

      $scope.data.InterviewRequest.date = Date.parse('today').toString('MM/dd/yyyy');

      $scope.data.InterviewRequest.student_no = response.data.Student.student_no;

    });

  });

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.InterviewRequest.student_id = null;

      $scope.data.InterviewRequest.student_name = null;

    }

  }

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

    };

  };

  $scope.studentData = function (id) {

    $scope.data.InterviewRequest.student_id = $scope.student.id;

    $scope.data.InterviewRequest.student_name = $scope.student.name;

    $scope.data.InterviewRequest.student_no = $scope.student.code;

  };
 
  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      InterviewRequest.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/corporate-affairs/interview-request/student-index";

        } else {

          $.gritter.add({

            title: "Warning!",

            text: e.msg,

          });

        }

      });

    }

  };

});

app.controller("StudentInterviewRequestViewController",function ($scope, $routeParams, InterviewRequest,  InterviewRequestApprove, InterviewRequestDisapprove) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {

    InterviewRequest.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.approve = function(data){

    bootbox.confirm('Are you sure you want to mark as Approve?', function(e){

      if(e) {

        InterviewRequestApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          window.location = "#/corporate-affairs/interview-request/student-index";

        });

      }

    });

  }
  $scope.disapprove = function(data){  

    bootbox.confirm('Are you sure you want to disapprove appointment ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            InterviewRequestDisapprove.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Interview Request has been disapproved.'

                });

                $scope.load();

                window.location = "#/corporate-affairs/interview-request/student-index";

              }

            });

          }

        });

      }

    });

  }

    // remove
    $scope.remove = function (data) {

      bootbox.confirm(

        "Are you sure you want to remove " + data.code + " ?",

        function (c) {

          if (c) {

            InterviewRequest.remove({ id: data.id }, function (e) {

              if (e.ok) {

                $.gritter.add({

                  title: "Successful!",

                  text: e.msg,

                });

                window.location = "#/corporate-affairs/interview-request/student-view";

              }

            });

          }

        }

      );

    };

});

app.controller("StudentInterviewRequestEditController", function ($scope, $routeParams, InterviewRequest, Select) {

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

    InterviewRequest : {}

  }

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.load = function () {

    InterviewRequest.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      console.log(e);

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

    };

  };

  $scope.studentData = function (id) {

    $scope.data.MedicalCertificate.student_id = $scope.student.id;

    $scope.data.MedicalCertificate.student_name = $scope.student.name;

    $scope.data.MedicalCertificate.student_no = $scope.student.code;

  };

  $scope.update = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      InterviewRequest.update({ id: $scope.id }, $scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/corporate-affairs/interview-request/student-index";

        } else {

          $.gritter.add({

            title: "Warning!",

            text: e.msg,

          });

        }

      });

    }

  };

});