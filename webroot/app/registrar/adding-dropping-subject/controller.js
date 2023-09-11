app.controller('AddingDroppingSubjectController', function($scope, AddingDroppingSubject) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {}; 

    options['per_student'] = 1;

    options['status'] = 0;

    AddingDroppingSubject.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.approved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 1;

    AddingDroppingSubject.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  
  $scope.disapproved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 2;

    AddingDroppingSubject.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapproved = e.data;

        $scope.conditionsPrintDispproved = e.conditionsPrint;

        // paginator

        $scope.paginatorDisapproved  = e.paginator;

        $scope.pagesDisapproved = paginator($scope.paginatorDisapproved, 5);

      }

    });

  }


  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approved(options);

    $scope.disapproved(options);

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

        AddingDroppingSubject.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/add_drop?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/add_drop?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/add_drop?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/add_drop?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDispproved !== '') {
    
      printTable(base + 'print/add_drop?print=1' + $scope.conditionsPrintDispproved);

    }else{

      printTable(base + 'print/add_drop?print=1');

    }

  }

 
});

app.controller('AddingDroppingSubjectAddController', function($scope, AddingDroppingSubject, Select, Student) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

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
      AddingDroppingSubject: {},

      AddingDroppingSubjectSub: [],
    };

    $scope.removeSubs = function (index) {
      $scope.data.AddingDroppingSubjectSub.splice(index, 1);
    };

 
    Select.get({code: 'add-drop-subject'}, function(e) {

    $scope.data.AddingDroppingSubject.code = e.data;

    Student.get({ id: e.studentId }, function(response) {

      const student = response.data.Student;

      $scope.data.AddingDroppingSubject.student_id = student.id;

      $scope.data.AddingDroppingSubject.student_name = student.full_name;

      $scope.data.AddingDroppingSubject.student_no = student.student_no;

      $scope.data.AddingDroppingSubject.college_id = student.college_id;

      $scope.data.AddingDroppingSubject.program_id = student.program_id;

     $scope.getCollegeProgram($scope.data.AddingDroppingSubject.college_id);

  

    });

  });


  Select.get({ code: "course-list" }, function (e) {
    $scope.course = e.data;
  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });


 // $scope.getCollegeProgram = function(id){

 //    if($scope.colleges.length > 0){

 //      $.each($scope.colleges, function(i,val){

 //        if(val.id == id){

 //          $scope.data.AddingDroppingSubject.college = val.value;

 //        }

 //      });

 //    }

 //    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

 //      $scope.programs = e.data;

 //    });

 //  }
   $scope.getCollegeProgram = function(id) {
    if ($scope.colleges.length > 0) {
      $scope.data.AddingDroppingSubject.college = $scope.colleges.find(c => c.id === id).value;
    }
    Select.get({ code: 'application-program-list', college_id: id }, function(e) {
      $scope.programs = e.data;
      $scope.getProgram($scope.data.AddingDroppingSubject.program_id);
    });
  };


  //   $scope.getProgram = function(id){

  //   if($scope.programs.length > 0){

  //     $.each($scope.programs, function(i,val){

  //       if(val.id == id){

  //         $scope.data.AddingDroppingSubject.program = val.value;

  //       }

  //     });

  //   }

  // }

  $scope.getProgram = function(id) {
    if ($scope.programs.length > 0) {
      $scope.data.AddingDroppingSubject.program = $scope.programs.find(p => p.id === id).value;
    }
  };

 
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

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.adata.faculty_id = $scope.employee.id;

    $scope.adata.faculty_name = $scope.employee.name;

  }

  $scope.addDropSubs = function () {
      $("#add_subs").validationEngine("attach");

      $scope.adata = {};

      $("#add-subs-modal").modal("show");
    };

    $scope.saveSubs = function (data) {

       $scope.bool3 = true;
      
      valid = $("#add_subs").validationEngine("validate");

      if (valid) {
        $scope.data.AddingDroppingSubjectSub.push(data);

        console.log($scope.data);
        $("#add-subs-modal").modal("hide");
      }
    };

    $scope.editSubs = function (index, data) {
      $("#edit_subs").validationEngine("attach");

      data.index = index;

      $scope.adata = data;

      $("#edit-subs-modal").modal("show");
    };

    $scope.updateSubs = function (data, index) {
      valid = $("#edit_subs").validationEngine("validate");

      if (valid) {
        $scope.data.AddingDroppingSubjectSub[data.index] = data;

        $("#edit-subs-modal").modal("hide");
      }
    };

   $scope.save = function() {

    const valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Select.get({code: 'check-student-ledger', student_id : $scope.data.AddingDroppingSubject.student_id}, function(q) {

        if(q.data){

          AddingDroppingSubject.save($scope.data, function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text:  e.msg,

              });

              window.location = '#/registrar/adding-dropping-subject';

            } else {

              $.gritter.add({

                title: 'Warning!',

                text:  e.msg,

              });

            }

          });

        }else{

          $.gritter.add({

            title: 'Warning!',

            text:  'You still have a pending payment from apartelle/dormitory.',

          });

        }

      });

    }  

  }

});

app.controller('AddingDroppingSubjectViewController', function($scope, $routeParams, AddingDroppingSubject) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    AddingDroppingSubject.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.print = function(id){
  
    printTable(base + 'print/adding_dropping_subject_form/'+id);

  }

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        AddingDroppingSubject.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/registrar/adding-dropping-subject";

          }

        });

      }

    });

  } 

});

app.controller('AddingDroppingSubjectEditController', function($scope, $routeParams, AddingDroppingSubject, Select) {
  
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
      AddingDroppingSubject: {},

      // AddingDroppingSubjectSub: [],
    };

    $scope.bool = [

    { id: true, value: "Yes" },

    { id: false, value: "No" },

    ];

  
    $scope.load = function () {
      
      AddingDroppingSubject.get({ id: $scope.id }, function (e) {

        $scope.data = e.data;

        $scope.putIndex();

      });

      AddingDroppingSubject.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.get({ code: 'application-program-list', college_id : $scope.data.AddingDroppingSubject.college_id }, function(e) {

        $scope.programs = e.data;

      });

    });
    };

  $scope.load();

    $scope.putIndex = function () {
      if ($scope.data.AddingDroppingSubjectSub.length > 0) {
        index = 0;

        $.each($scope.data.AddingDroppingSubjectSub, function (key, val) {
          if (val.visible != 0) {
            index += 1;

            $scope.data.AddingDroppingSubjectSub[key].index = index;
          }
          console.log(index);
        });
      }
    };

    $scope.addDropSubs = function () {
      $("#add_subs").validationEngine("attach");

      $scope.adata = {};

      $("#add-subs-modal").modal("show");
    };

    $scope.saveSubs = function (data) {
      
      valid = $("#add_subs").validationEngine("validate");

      if (valid) {
        $scope.data.AddingDroppingSubjectSub.push(data);

        console.log($scope.data);
        $("#add-subs-modal").modal("hide");
      }
    };

    $scope.editSubs = function (index, data) {
      $("#edit_subs").validationEngine("attach");

      data.index = index;

      $scope.adata = data;

      $("#edit-subs-modal").modal("show");
    };
    
    $scope.updateSubs = function (data, index) {
      valid = $("#edit_subs").validationEngine("validate");

      if (valid) {
        $scope.data.AddingDroppingSubjectSub[data.index] = data;
        $scope.putIndex();
        $("#edit-subs-modal").modal("hide");
      }
    };

    $scope.removeSubs = function (index) {
      $scope.data.AddingDroppingSubjectSub[index].visible = 0;

      $scope.putIndex();
    };



  Select.get({ code: "course-list" }, function (e) {
    $scope.course = e.data;
  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });


  $scope.getProgram = function(id){

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.load = function() {

    AddingDroppingSubject.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.get({ code: 'application-program-list', college_id : $scope.data.AddingDroppingSubject.college_id }, function(e) {

        $scope.programs = e.data;

      });

    });

  }

  $scope.getCollegeProgram = function(id){

    if($scope.colleges.length > 0){

      $.each($scope.colleges, function(i,val){

        if(val.id == id){

          $scope.data.AddingDroppingSubject.college = val.value;

        }

      });

    }

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.getProgram = function(id){

    if($scope.programs.length > 0){

      $.each($scope.programs, function(i,val){

        if(val.id == id){

          $scope.data.AddingDroppingSubject.program = val.value;

        }

      });

    }

  }


  // $scope.searchStudent = function(options) {

  //   options = typeof options !== 'undefined' ?  options : {};

  //   options['code'] = 'search-student';

  //   Select.query(options, function(e) {

  //     $scope.students = e.data.result;

  //     $scope.student = {};
      
  //     // paginator

  //     $scope.paginator  = e.data.paginator;

  //     $scope.pages = paginator($scope.paginator, 10);

  //     $("#searched-student-modal").modal('show');

  //   });

  // }

  // $scope.selectedStudent = function(student) { 

  //   $scope.student = {

  //     id    : student.id,

  //     code  : student.code,

  //     name  : student.name,

     
  //   }; 

  // }

  // $scope.studentData = function(id) {

  //   $scope.data.AddingDroppingSubject.student_id = $scope.student.id;

  //   $scope.data.AddingDroppingSubject.student_name = $scope.student.name;

  //   $scope.data.AddingDroppingSubject.student_no = $scope.student.code;

  // }

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

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.adata.faculty_id = $scope.employee.id;

    $scope.adata.faculty_name = $scope.employee.name;

  }

  

  // $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      AddingDroppingSubject.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/adding-dropping-subject';

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


app.controller('AdminAddingDroppingSubjectController', function($scope, AddingDroppingSubject) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    AddingDroppingSubject.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.approved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 1;

    AddingDroppingSubject.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  

  $scope.disapproved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 2;

    AddingDroppingSubject.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapproved = e.data;

        $scope.conditionsPrintDispproved = e.conditionsPrint;

        // paginator

        $scope.paginatorDisapproved  = e.paginator;

        $scope.pagesDisapproved = paginator($scope.paginatorDisapproved, 5);

      }

    });

  }

  

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approved(options);

    $scope.disapproved(options);

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

        AddingDroppingSubject.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/add_drop?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/add_drop?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/add_drop?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/add_drop?print=1');

    }

  }


  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDispproved !== '') {
    
      printTable(base + 'print/add_drop?print=1' + $scope.conditionsPrintDispproved);

    }else{

      printTable(base + 'print/add_drop?print=1');

    }

  }

});

app.controller('AdminAddingDroppingSubjectAddController', function($scope, AddingDroppingSubject, Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

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
      AddingDroppingSubject: {},

      AddingDroppingSubjectSub: [],
    };

    $scope.removeSubs = function (index) {
      $scope.data.AddingDroppingSubjectSub.splice(index, 1);
    };

  Select.get({ code: "add-drop-subject" }, function (e) {
    $scope.data.AddingDroppingSubject.code = e.data;
  });


  Select.get({ code: "course-list" }, function (e) {
    $scope.course = e.data;
  });


  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });


  $scope.getCollegeProgram = function(id){

    if($scope.colleges.length > 0){

      $.each($scope.colleges, function(i,val){

        if(val.id == id){

          $scope.data.AddingDroppingSubject.college = val.value;

        }

      });

    }

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.getProgram = function(id){

    if($scope.programs.length > 0){

      $.each($scope.programs, function(i,val){

        if(val.id == id){

          $scope.data.AddingDroppingSubject.program = val.value;

        }

      });

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

    $scope.student = {

      id    : student.id,

      code  : student.code,

      name  : student.name,

      college_id : student.college_id,


    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.AddingDroppingSubject.student_id = $scope.student.id;

    $scope.data.AddingDroppingSubject.student_name = $scope.student.name;

    $scope.data.AddingDroppingSubject.student_no = $scope.student.code;

    $scope.data.AddingDroppingSubject.college_id = $scope.student.college_id;

    $scope.getCollegeProgram($scope.student.college_id);

  }


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

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.adata.faculty_id = $scope.employee.id;

    $scope.adata.faculty_name = $scope.employee.name;

  }

  $scope.addDropSubs = function () {
      $("#add_subs").validationEngine("attach");

      $scope.adata = {};

      $("#add-subs-modal").modal("show");
    };

    $scope.saveSubs = function (data) {

       $scope.bool3 = true;
      
      valid = $("#add_subs").validationEngine("validate");

      if (valid) {
        $scope.data.AddingDroppingSubjectSub.push(data);

        console.log($scope.data);
        $("#add-subs-modal").modal("hide");
      }
    };

    $scope.editSubs = function (index, data) {
      $("#edit_subs").validationEngine("attach");

      data.index = index;

      $scope.adata = data;

      $("#edit-subs-modal").modal("show");
    };

    $scope.updateSubs = function (data, index) {
      valid = $("#edit_subs").validationEngine("validate");

      if (valid) {
        $scope.data.AddingDroppingSubjectSub[data.index] = data;

        $("#edit-subs-modal").modal("hide");
      }
    };

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Select.get({code: 'check-student-ledger', student_id : $scope.data.AddingDroppingSubject.student_id}, function(q) {

        if(q.data){

          AddingDroppingSubject.save($scope.data, function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text:  e.msg,

              });

              window.location = '#/registrar/admin-adding-dropping-subject';

            } else {

              $.gritter.add({

                title: 'Warning!',

                text:  e.msg,

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

  }


});

app.controller('AdminAddingDroppingSubjectViewController', function($scope, $routeParams, AddingDroppingSubject, AddingDroppingSubjectApprove, AddingDroppingSubjectDisapproved) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    AddingDroppingSubject.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.print = function(id){
  
    printTable(base + 'print/adding_dropping_subject_form/'+id);

  }

  $scope.approve = function(data){

    bootbox.confirm('Are you sure you want to approve adding / dropping subject ' +  data.code + '?', function(e){

      if(e) {

        AddingDroppingSubjectApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Adding / Dropping Subject Appointment has been approved.'

            });

          }

          window.location = "#/registrar/admin-adding-dropping-subject";

        });

      }

    });

  }

  $scope.disapprove = function(data){  

    bootbox.confirm('Are you sure you want to disapprove adding/dropping subject ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            AddingDroppingSubjectDisapproved.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Adding / Dropping Subject has been disapproved.'

                });

                $scope.load();

                window.location = "#/registrar/admin-adding-dropping-subject";

              }

            });

          }

        });

      }

    });

  }

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        AddingDroppingSubject.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/registrar/admin-adding-dropping-subject";

          }

        });

      }

    });

  } 

});

app.controller('AdminAddingDroppingSubjectEditController', function($scope, $routeParams, AddingDroppingSubject, Select) {
  
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
      AddingDroppingSubject: {},

      // AddingDroppingSubjectSub: [],
    };

    $scope.bool = [

    { id: true, value: "Yes" },

    { id: false, value: "No" },

    ];


    $scope.load = function () {
      
      AddingDroppingSubject.get({ id: $scope.id }, function (e) {

        $scope.data = e.data;

        $scope.putIndex();

      });

      AddingDroppingSubject.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.get({ code: 'application-program-list', college_id : $scope.data.AddingDroppingSubject.college_id }, function(e) {

        $scope.programs = e.data;

      });

    });
    };

  $scope.load();

    $scope.putIndex = function () {
      if ($scope.data.AddingDroppingSubjectSub.length > 0) {
        index = 0;

        $.each($scope.data.AddingDroppingSubjectSub, function (key, val) {
          if (val.visible != 0) {
            index += 1;

            $scope.data.AddingDroppingSubjectSub[key].index = index;
          }
          console.log(index);
        });
      }
    };

    $scope.addDropSubs = function () {
      $("#add_subs").validationEngine("attach");

      $scope.adata = {};

      $("#add-subs-modal").modal("show");
    };

    $scope.saveSubs = function (data) {
      
      valid = $("#add_subs").validationEngine("validate");

      if (valid) {
        $scope.data.AddingDroppingSubjectSub.push(data);

        console.log($scope.data);
        $("#add-subs-modal").modal("hide");
      }
    };

    $scope.editSubs = function (index, data) {
      $("#edit_subs").validationEngine("attach");

      data.index = index;

      $scope.adata = data;

      $("#edit-subs-modal").modal("show");
    };
    
    $scope.updateSubs = function (data, index) {
      valid = $("#edit_subs").validationEngine("validate");

      if (valid) {
        $scope.data.AddingDroppingSubjectSub[data.index] = data;
        $scope.putIndex();
        $("#edit-subs-modal").modal("hide");
      }
    };

    $scope.removeSubs = function (index) {
      $scope.data.AddingDroppingSubjectSub[index].visible = 0;

      $scope.putIndex();
    };



  Select.get({ code: "course-list" }, function (e) {
    $scope.course = e.data;
  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });


  // $scope.getProgram = function(id){

  //   Select.get({ code: 'application-program-list', college_id : id }, function(e) {

  //     $scope.programs = e.data;

  //   });

  // }

  $scope.load = function() {

    AddingDroppingSubject.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.get({ code: 'application-program-list', college_id : $scope.data.AddingDroppingSubject.college_id }, function(e) {

        $scope.programs = e.data;

      });

    });

  }

  $scope.getCollegeProgram = function(id){

    if($scope.colleges.length > 0){

      $.each($scope.colleges, function(i,val){

        if(val.id == id){

          $scope.data.AddingDroppingSubject.college = val.value;

        }

      });

    }

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.getProgram = function(id){

    if($scope.programs.length > 0){

      $.each($scope.programs, function(i,val){

        if(val.id == id){

          $scope.data.AddingDroppingSubject.program = val.value;

        }

      });

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

    $scope.student = {

      id    : student.id,

      code  : student.code,

      name  : student.name,

     
    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.AddingDroppingSubject.student_id = $scope.student.id;

    $scope.data.AddingDroppingSubject.student_name = $scope.student.name;

    $scope.data.AddingDroppingSubject.student_no = $scope.student.code;

  }

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

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.adata.faculty_id = $scope.employee.id;

    $scope.adata.faculty_name = $scope.employee.name;

  }

  

  // $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      AddingDroppingSubject.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/admin-adding-dropping-subject';

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



