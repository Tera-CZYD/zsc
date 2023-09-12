app.controller('DentalController', function($scope, Dental) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    Dental.query(options, function(e) {
      console.log(e);
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

    options['status'] = 3;

    Dental.query(options, function(e) {

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

    options['status'] = 4;

    Dental.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapprove = e.data;

        $scope.conditionsPrintDisapprove = e.conditionsPrint;

        $scope.paginatorDisapprove = e.paginator;

        $scope.pagesDisapprove = paginator($scope.paginatorDisapprove, 5);

      }

    });

  }
  $scope.treated = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 1;

    Dental.query(options, function(e) {

      if (e.ok) {

        $scope.datasTreated = e.data;

        $scope.conditionsPrintTreated = e.conditionsPrint;

        // paginator

        $scope.paginatorTreated  = e.paginator;

        $scope.pagesTreated = paginator($scope.paginatorTreated, 5);

      }

    });

  }

  $scope.referred = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 2;

    Dental.query(options, function(e) {

      if (e.ok) {

        $scope.datasReferred = e.data;

        $scope.conditionsPrintReferred = e.conditionsPrint;

        // paginator

        $scope.paginatorReferred  = e.paginator;

        $scope.pagesReferred = paginator($scope.paginatorReferred, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);
    $scope.approve(options);
    $scope.disapprove(options);

    $scope.treated(options);

    $scope.referred(options);

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

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        Dental.remove({ id: data.id }, function(e) {
  
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

  $scope.print = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/dental?print=1" + $scope.conditionsPrint);

    } else {

      printTable(base + "print/dental?print=1");

    }

  };

  $scope.printApprove = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/dental?print=1" + $scope.conditionsPrintApprove);

    } else {

      printTable(base + "print/dental?print=1");

    }

  };
  $scope.printDisapprove = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/dental?print=1" + $scope.conditionsPrintDisapprove);

    } else {

      printTable(base + "print/dental?print=1");

    }

  };


  $scope.printTreated = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/dental?print=1" + $scope.conditionsPrintTreated);

    } else {

      printTable(base + "print/dental?print=1");

    }

  };

  $scope.printReferred = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/dental?print=1" + $scope.conditionsPrintReferred);

    } else {

      printTable(base + "print/dental?print=1");

    }

  };

});

app.controller('DentalAddController', function($scope, Dental, Select) {

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

    Dental : {},
    DentalImage : []

  }

  Select.get({code: 'dental-code'}, function(e) {

    $scope.data.Dental.code = e.data;

  });

  Select.get({code: 'program-list'}, function(e) {

    $scope.course = e.data;

  });

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.Dental.employee_id = null;

      $scope.data.Dental.employee_name = null;

    }else{

      $scope.data.Dental.student_id = null;

      $scope.data.Dental.student_name = null;

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
     
      age : age, 

    }; 
    

  }

  $scope.studentData = function(id) {

    $scope.data.Dental.student_id = $scope.student.id;

    $scope.data.Dental.student_name = $scope.student.name;

    $scope.data.Dental.student_no = $scope.student.code;

    $scope.data.Dental.age = $scope.student.age;

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

    $scope.data.Dental.employee_id = $scope.employee.id;

    $scope.data.Dental.employee_no = $scope.employee.code;

    $scope.data.Dental.employee_name = $scope.employee.name;

  }

  $scope.saveImages = function (files) {

    if(files == undefined){

      files = '';

    }

    if(files.length > 0){

      $scope.data.DentalImage.push({

        images  : $scope.files,

      });  

    }



  }



  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      console.log($scope.files)

      Dental.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/dental';

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

app.controller('DentalViewController', function($scope, $routeParams, Dental, DentalTreated, DentalApprove, DentalDisapprove, DentalReferred) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    Dental.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.DentalImage = e.DentalImage

    });

  }
  $scope.load();
  $scope.treat = function(data){

    bootbox.confirm('Are you sure you want to mark patient as treated?', function(e){

      if(e) {

        DentalTreated.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          window.location = "#/medical-services/dental";

        });

      }

    });

  }
  $scope.appr = function(data){

    bootbox.confirm('Are you sure you want to mark patient as Approve?', function(e){

      if(e) {

        DentalApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          window.location = "#/medical-services/dental";

        });

      }

    });

  }
  $scope.disappr = function(data){  

    bootbox.confirm('Are you sure you want to disapprove appointment ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            DentalDisapprove.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Counseling Appointment has been disapproved.'

                });

                $scope.load();

                window.location = "#/medical-services/dental";

              }

            });

          }

        });

      }

    });

  }
  $scope.refer = function(data){  

    bootbox.confirm('Are you sure you want to mark patient as referred?', function(b){

      if(b) {

        DentalReferred.update({id:data.id}, function(e){

          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text: e.msg

            });

            $scope.load();

            window.location = "#/medical-services/dental";

          }

        });

      }

    });

  }

  $scope.load();  

  $scope.print = function(id){
  
    printTable(base + 'print/dental_form/'+id);

  }

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        Dental.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/medical-services/dental";
 
          }
    
        });
    
      }
    
    });
  
  } 

});

app.controller('DentalEditController', function($scope, $routeParams, Dental, DentalImage, DentalRemoveImage, Select) {
  
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

    Dental : {},

   DentalImage : []

  }

  Select.get({code: 'program-list'}, function(e) {

    $scope.course = e.data;

  });

  // load 

  $scope.load = function() {

    Dental.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.DentalImage = e.DentalImage;

    });



  }

  

   $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.Dental.employee_id = null;

      $scope.data.Dental.employee_name = null;

    }else{

      $scope.data.Dental.student_id = null;

      $scope.data.Dental.student_name = null;

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
     
      age : age, 

    }; 
    

  }

  $scope.studentData = function(id) {

    $scope.data.Dental.student_id = $scope.student.id;

    $scope.data.Dental.student_name = $scope.student.name;

    $scope.data.Dental.student_no = $scope.student.code;

    $scope.data.Dental.age = $scope.student.age;

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

    $scope.data.Dental.employee_id = $scope.employee.id;

    $scope.data.Dental.employee_no = $scope.employee.code;

    $scope.data.Dental.employee_name = $scope.employee.name;

  }

  $scope.load();

    $scope.addImage = function() {

    var x = document.getElementById("upload_prev").innerHTML = " ";

    $('#edit-upload-image').modal('show');

  };

  $scope.saveImages = function (files) {
    
    $scope.DentalImage = [];

    angular.forEach(files, function(file, e){

      $scope.DentalImage.push({

        images                : file.name,

        dental_id             : $scope.id,

        url                   : file.url,

        _file                 : file._file,

        $$hashKey             : file.$$hashKey

      });

    });
    
    DentalImage.save($scope.DentalImage, function(e) {

      if (e.ok) {

        $.gritter.add({

          title: 'Success!',

          text:  e.msg,

        });

        $('#edit-upload-image').modal('hide');

        $scope.load();

      } else {

        $.gritter.add({

          title: 'Warning!',

          text:  e.msg,

        });

      }

    });

  }

  $scope.removeImage = function(index,image) {

    bootbox.confirm('Are you sure you want to delete ' + image.name + '?', function(b) {

      if (b) {

        DentalRemoveImage.delete({ id: image.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text: e.msg,

            });

            $scope.load();

          }

        });

      }

    });

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Dental.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/dental';

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



app.controller("StudentDentalController", function ($scope, Dental) {

  $scope.today = Date.parse("today").toString("MM/dd/yyyy");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};
    options['per_student'] = 1;
    options['status'] = 0;

    Dental.query(options, function(e) {

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
    options['status'] = 3;

    Dental.query(options, function(e) {

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
    options['per_student'] = 1;
    options['status'] = 4;

    Dental.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapprove = e.data;

        $scope.conditionsPrintDisapprove = e.conditionsPrint;

        $scope.paginatorDisapprove = e.paginator;

        $scope.pagesDisapprove = paginator($scope.paginatorDisapprove, 5);

      }

    });

  }
  $scope.treated = function(options) {

    options = typeof options !== 'undefined' ?  options : {};
    options['per_student'] = 1;
    options['status'] = 1;

    Dental.query(options, function(e) {

      if (e.ok) {

        $scope.datasTreated = e.data;

        $scope.conditionsPrintTreated = e.conditionsPrint;

        // paginator

        $scope.paginatorTreated  = e.paginator;

        $scope.pagesTreated = paginator($scope.paginatorTreated, 5);

      }

    });

  }

  $scope.referred = function(options) {

    options = typeof options !== 'undefined' ?  options : {};
    options['per_student'] = 1;
    options['status'] = 2;

    Dental.query(options, function(e) {

      if (e.ok) {

        $scope.datasReferred = e.data;

        $scope.conditionsPrintReferred = e.conditionsPrint;

        // paginator

        $scope.paginatorReferred  = e.paginator;

        $scope.pagesReferred = paginator($scope.paginatorReferred, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);
    $scope.approve(options);
    $scope.disapprove(options);

    $scope.treated(options);

    $scope.referred(options);

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

    bootbox.confirm(

      "Are you sure you want to delete " + data.code + " ?",

      function (c) {

        if (c) {

          Dental.remove({ id: data.id }, function (e) {

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

  $scope.print = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/dental?print=1" + $scope.conditionsPrint);

    } else {

      printTable(base + "print/dental?print=1");

    }

  };

  $scope.printApprove = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/dental?print=1" + $scope.conditionsPrintApprove);

    } else {

      printTable(base + "print/dental?print=1");

    }

  };
  $scope.printDisapprove = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/dental?print=1" + $scope.conditionsPrintDisapprove);

    } else {

      printTable(base + "print/dental?print=1");

    }

  };


  $scope.printTreated = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/dental?print=1" + $scope.conditionsPrintTreated);

    } else {

      printTable(base + "print/dental?print=1");

    }

  };

  $scope.printReferred = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/dental?print=1" + $scope.conditionsPrintReferred);

    } else {

      printTable(base + "print/dental?print=1");

    }

  };

});

app.controller( "StudentDentalAddController", function ($scope, Dental, Select,Student) {

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

    Dental: {},


  };

  Select.get({ code: "ailment-list" }, function (e) {

    $scope.ailments = e.data;

  });

  Select.get({code: 'program-list'}, function(e) {

    $scope.course = e.data;

  });

  $scope.getAilment = function(id){

    if($scope.ailments.length > 0){

      $.each($scope.ailments, function(i,val){

        if(id == val.id){

          $scope.adata.chief_complaints = val.value;

          Select.get({ code: "ailment-prescription-list", id : val.id }, function (e) {

            $scope.prescriptions = e.data;

          });

        }

      });

    }

  }

  $scope.getPrescription = function(id){

    if($scope.prescriptions.length > 0){

      $.each($scope.prescriptions, function(i,val){

        if(id == val.id){

          $scope.adata.treatments = val.value;

        }

      });

    }

  }

  Select.get({ code: "dental-code" }, function (e) {

    $scope.data.Dental.code = e.data;
    Student.get({ id: e.studentId }, function(response) {
      // console.log(response.data);
      $scope.data.Dental.student_id = response.data.Student.id;

      $scope.data.Dental.age = response.data.Student.age;

      $scope.data.Dental.course_id = response.data.Student.program_id;

      $scope.data.Dental.year = response.data.YearLevelTerm.year;
      $scope.data.Dental.date = Date.parse('today').toString('MM/dd/yyyy');
      $scope.data.Dental.student_name = response.data.Student.full_name;

      $scope.data.Dental.student_no = response.data.Student.student_no;

    });

  });

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.Dental.employee_id = null;

      $scope.data.Dental.employee_name = null;

    }else{

      $scope.data.Dental.student_id = null;

      $scope.data.Dental.student_name = null;

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

    $scope.data.Dental.student_id = $scope.student.id;

    $scope.data.Dental.student_name = $scope.student.name;

    $scope.data.Dental.student_no = $scope.student.code;

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

    $scope.data.Dental.employee_id = $scope.employee.id;

    $scope.data.Dental.employee_no = $scope.employee.code;

    $scope.data.Dental.employee_name = $scope.employee.name;

  }

  //add others modal

  $scope.addSubs = function () {

    $("#add_subs").validationEngine("attach");

    $scope.adata = {};

    $("#add-subs-modal").modal("show");

  };

  $scope.saveSubs = function (data) {

    valid = $("#add_subs").validationEngine("validate");

    if (valid) {

      $scope.data.DentalSub.push(data);

      console.log(data);

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

      $scope.data.DentalSub[data.index] = data;

      $("#edit-subs-modal").modal("hide");

    }

  };

  $scope.removeSubs = function (index) {

    $scope.data.DentalSub.splice(index, 1);

  };

  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      Dental.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/medical-services/dental/student-index";

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

app.controller("StudentDentalViewController",function ($scope, $routeParams, Dental, DentalTreated, DentalApprove, DentalDisapprove, DentalReferred) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {

    Dental.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.treat = function(data){

    bootbox.confirm('Are you sure you want to mark patient as treated?', function(e){

      if(e) {

        DentalTreated.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          window.location = "#/medical-services/dental/student-index";

        });

      }

    });

  }
  $scope.appr = function(data){

    bootbox.confirm('Are you sure you want to mark patient as Approve?', function(e){

      if(e) {

        DentalApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          window.location = "#/medical-services/dental/student-index";

        });

      }

    });

  }
  $scope.disappr = function(data){  

    bootbox.confirm('Are you sure you want to disapprove appointment ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            DentalDisapprove.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Counseling Appointment has been disapproved.'

                });

                $scope.load();

                window.location = "#/medical-services/dental/student-index";

              }

            });

          }

        });

      }

    });

  }
  $scope.refer = function(data){  

    bootbox.confirm('Are you sure you want to mark patient as referred?', function(b){

      if(b) {

        DentalReferred.update({id:data.id}, function(e){

          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text: e.msg

            });

            $scope.load();

            window.location = "#/medical-services/dental/student-index";

          }

        });

      }

    });

  }

    $scope.print = function (id) {

      printTable(base + "print/dental_form/" + id);

    };

    // remove
    $scope.remove = function (data) {

      bootbox.confirm(

        "Are you sure you want to remove " + data.code + " ?",

        function (c) {

          if (c) {

            Dental.remove({ id: data.id }, function (e) {

              if (e.ok) {

                $.gritter.add({

                  title: "Successful!",

                  text: e.msg,

                });

                window.location = "#medical-services/student-dental";

              }

            });

          }

        }

      );

    };

  }

);

app.controller("StudentDentalEditController", function ($scope, $routeParams, Dental, DentalImage, DentalRemoveImage, Select) {

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

    Dental: {},

    DentalSub : []

  };

  $scope.bool = [

    { id: true, value: "Yes" },

    { id: false, value: "No" },

  ];

  Select.get({ code: "ailment-list" }, function (e) {

    $scope.ailments = e.data;

  });

  
  Select.get({code: 'program-list'}, function(e) {

    $scope.course = e.data;

  });

  $scope.getAilment = function(id){

    if($scope.ailments.length > 0){

      $.each($scope.ailments, function(i,val){

        if(id == val.id){

          $scope.adata.chief_complaints = val.value;

          Select.get({ code: "ailment-prescription-list", id : val.id }, function (e) {

            $scope.prescriptions = e.data;

          });

        }

      });

    }

  }

  $scope.getPrescription = function(id){

    if($scope.prescriptions.length > 0){

      $.each($scope.prescriptions, function(i,val){

        if(id == val.id){

          $scope.adata.treatments = val.value;

        }

      });

    }

  }

  $scope.load = function () {

    Dental.get({ id: $scope.id }, function (e) {

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

    $scope.data.Dental.student_id = $scope.student.id;

    $scope.data.Dental.student_name = $scope.student.name;

    $scope.data.Dental.student_no = $scope.student.code;

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

    $scope.data.Dental.employee_id = $scope.employee.id;

    $scope.data.Dental.employee_no = $scope.employee.code;

    $scope.data.Dental.employee_name = $scope.employee.name;

  }

  //add others modal

  $scope.addSubs = function () {

    $("#add_subs").validationEngine("attach");

    $scope.adata = {};

    $("#add-subs-modal").modal("show");

  };

  $scope.saveSubs = function (data) {

    valid = $("#add_subs").validationEngine("validate");

    if (valid) {

      $scope.data.DentalSub.push(data);

      $("#add-subs-modal").modal("hide");

    }

  };

  $scope.editSubs = function (index, data) {

    Select.get({ code: "ailment-prescription-list", id : data.chief_complaint_id }, function (e) {

      $scope.prescriptions = e.data;

    });

    $("#edit_subs").validationEngine("attach");

    data.index = index;

    $scope.adata = data;

    $("#edit-subs-modal").modal("show");

  };

  $scope.updateSubs = function (data, index) {

    valid = $("#edit_subs").validationEngine("validate");

    if (valid) {

      $scope.data.DentalSub[data.index] = data;

      $("#edit-subs-modal").modal("hide");

    }

  };

  $scope.removeSubs = function (index) {

    $scope.data.DentalSub.splice(index,1);

  };



  $scope.update = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      Dental.update({ id: $scope.id }, $scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/medical-services/dental/student-index";

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

getAge = function(bday) {

  var now = new Date();

  var currentYear = now.getFullYear();

  var currentMonth = now.getMonth();

  var currentDay = now.getDay();

  var myYear = bday.getFullYear();

  var myMonth = bday.getMonth();

  var myDay = bday.getDay();

  var myAge = currentYear - myYear;

  var myAgeMonth = currentMonth - myMonth;

  var myAgeDay = currentDay - myDay;

  if(currentMonth < myMonth && (myAgeMonth < 0 && myAgeDay < 0)){

    parseInt(myAge--);

  } 

  return myAge;

}