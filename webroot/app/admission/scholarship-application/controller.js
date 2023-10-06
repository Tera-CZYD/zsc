app.controller("ScholarshipApplicationController", function ($scope, ScholarshipApplication) {
  
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

    ScholarshipApplication.query(options, function(e) {

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

    ScholarshipApplication.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  $scope.confirmed = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 4;

    ScholarshipApplication.query(options, function(e) {

      if (e.ok) {

        $scope.datasConfirmed = e.data;

        $scope.conditionsPrintConfirmed = e.conditionsPrint;

        // paginator

        $scope.paginatorConfirmed  = e.paginator;

        $scope.pagesConfirmed = paginator($scope.paginatorConfirmed, 5);

      }

    });

  }

  $scope.disapproved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 2;

    ScholarshipApplication.query(options, function(e) {

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

    $scope.confirmed(options);

    $scope.disapproved(options);

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

    $scope.year_term_id = null;

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

    bootbox.confirm("Are you sure you want to delete " + data.code + " ?", function (c) {

      if (c) {

        ScholarshipApplication.remove({ id: data.id }, function (e) {

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

  $scope.print = function(){

    if ($scope.conditionsPrintPending !== '') {
    
      printTable(base + 'print/student_applications?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_applications?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/student_applications?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/student_applications?print=1');

    }

  }

  $scope.printConfirmed = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/student_applications?print=1' + $scope.conditionsPrintConfirmed);

    }else{

      printTable(base + 'print/student_applications?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDispproved !== '') {
    
      printTable(base + 'print/student_applications?print=1' + $scope.conditionsPrintDispproved);

    }else{

      printTable(base + 'print/student_applications?print=1');

    }

  }

});

app.controller("ScholarshipApplicationAddController", function ($scope, ScholarshipApplication, Select, Student) {

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

    ScholarshipApplication: {},

  };

        Select.get({code: 'program-list'}, function(e) {

    $scope.course = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.ApartelleRegistration.year = val.value;

        }

      });

    }

  }

  Select.get({ code: 'province-list'}, function (e){

    $scope.provinces = e.data;

  });

  $scope.getTown = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'town-list',province_id: id}, function (e){

        $scope.towns = e.data;

      });

    }else{

      $scope.towns = [];

    }

  }

  $scope.getBarangay = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'barangay-list',town_id: id}, function (e){

        $scope.barangays = e.data;

      });

      // Select.get({ code: 'zip-list',town_id: id}, function (e){

      //   $scope.data.StudentProfile.zip_code = e.data;

      // });

    }else{

      $scope.barangays = [];
      
    }

  }

  Select.get({ code: "scholarship-application-code" }, function (e) {
     
    $scope.data.ScholarshipApplication.code = e.data;

    Student.get({ id: e.studentId }, function(response) {

      $scope.data.ScholarshipApplication.student_id = response.data.Student.id;

      $scope.data.ScholarshipApplication.student_name = response.data.Student.full_name;

      $scope.data.ScholarshipApplication.student_no = response.data.Student.student_no;

      $scope.data.ScholarshipApplication.program_id = response.data.Student.program_id;

      $scope.data.ScholarshipApplication.email = response.data.Student.email;

    });

  });

  Select.get({ code: "college-program-list-all" }, function (e) {

    $scope.programs = e.data;

  });

  Select.get({ code: "school-list" }, function (e) {

    $scope.school = e.data;

  });

  $scope.getSchool = function(id){

    if($scope.school.length > 0){

      $.each($scope.school, function(i,val){

        if(val.id == id){

          $scope.data.ScholarshipApplication.school_address = val.school_address;

        }

      });

    }

  }

  Select.get({ code: "scholarship-name-list" }, function (e) {

    $scope.scholarship_name = e.data;

  });

  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      ScholarshipApplication.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/admission/scholarship-application";

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

app.controller("ScholarshipApplicationViewController", function ($scope, $routeParams, ScholarshipApplication, ScholarshipApplicationApprove, ScholarshipApplicationDisapproved) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {
   
    ScholarshipApplication.get({ id: $scope.id }, function (e) {
   
      $scope.data = e.data;
   
    });
  
  };

  $scope.load();

  $scope.print = function (id) {
    // console.log(id);
  
    printTable(base + "print/scholarship_application_form/" + id);
  
  };

  // remove
  $scope.remove = function (data) {
  
    bootbox.confirm("Are you sure you want to remove " + data.code + " ?", function (c) {
  
      if (c) {

        ScholarshipApplication.remove({ id: data.id }, function (e) {

          if (e.ok) {

            $.gritter.add({

              title: "Successful!",

              text: e.msg,

            });

            window.location = "#/admission/scholarship-application";

          }

        });

      }

    });

  };

});

app.controller("ScholarshipApplicationEditController", function ($scope, $routeParams, ScholarshipApplication, Select) {
  
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
  
    ScholarshipApplication: {},
  
  };

        Select.get({code: 'program-list'}, function(e) {

    $scope.course = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.ApartelleRegistration.year = val.value;

        }

      });

    }

  }

  Select.get({ code: 'province-list'}, function (e){

    $scope.provinces = e.data;

  });

  Select.get({ code: 'town-list'}, function (e){

    $scope.towns = e.data;

  });

  Select.get({ code: 'barangay-list'}, function (e){

    $scope.barangays = e.data;

  });

  $scope.getTown = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'town-list',province_id: id}, function (e){

        $scope.towns = e.data;

      });

    }else{

      $scope.towns = [];

    }

  }

  $scope.getBarangay = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'barangay-list',town_id: id}, function (e){

        $scope.barangays = e.data;

      });

      // Select.get({ code: 'zip-list',town_id: id}, function (e){

      //   $scope.data.StudentProfile.zip_code = e.data;

      // });

    }else{

      $scope.barangays = [];
      
    }

  }

  Select.get({ code: "college-program-list-all" }, function (e) {

    $scope.programs = e.data;

  });

  Select.get({ code: "school-list" }, function (e) {

    $scope.school = e.data;

  });

  $scope.getSchool = function(id){

    if($scope.school.length > 0){

      $.each($scope.school, function(i,val){

        if(val.id == id){

          $scope.data.ScholarshipApplication.school_address = val.school_address;

        }

      });

    }

  }

  Select.get({ code: "scholarship-name-list" }, function (e) {

    $scope.scholarship_name = e.data;

  });

  // load

  $scope.load = function () {
  
    ScholarshipApplication.get({ id: $scope.id }, function (e) {
  
      $scope.data = e.data;

  
    });
  
  };

  $scope.load();

  $scope.update = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      ScholarshipApplication.update({ id: $scope.id },$scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/admission/scholarship-application";

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

app.controller("AdminScholarshipApplicationController", function ($scope, ScholarshipApplication,ScholarshipApplicationViewGrade,Select,ScholarshipApplicationRequestData) {
  
  $scope.today = Date.parse("today").toString("MM/dd/yyyy");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    ScholarshipApplication.query(options, function(e) {

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

    ScholarshipApplication.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  $scope.confirmed = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 4;

    ScholarshipApplication.query(options, function(e) {

      if (e.ok) {

        $scope.datasConfirmed = e.data;

        $scope.conditionsPrintConfirmed = e.conditionsPrint;

        // paginator

        $scope.paginatorConfirmed  = e.paginator;

        $scope.pagesConfirmed = paginator($scope.paginatorConfirmed, 5);

      }

    });

  }

  $scope.disapproved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 2;

    ScholarshipApplication.query(options, function(e) {

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

    $scope.confirmed(options);

    $scope.disapproved(options);

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

    $scope.year_term_id = null;

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

  $scope.viewGrade = function (id) {

    
    ScholarshipApplicationViewGrade.get({id:id}, function(e){
      // console.log(e.data.grade);

      if(e.ok){
        $scope.StudentEnrolledCourse = e.data.StudentEnrolledCourse;
        $scope.grade = e.data.grade;
        $scope.Student = e.data.Student;
        $scope.ScholarshipApplication = e.data.ScholarshipApplication;
        $scope.na = e.data.na;
        $("#view-grade").modal("show");
      }
    });
        $scope.load();
  };

  $scope.requestData = function(data){
    bootbox.confirm('Are you sure you want to qualify this student for the scholarship?', function(e){

      if(e) {

        ScholarshipApplicationRequestData.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });
            $("#view-grade").modal("hide");
          }

          window.location = "#/ad/admin-scholarship-application";

        });

      }

    });
  };

  $scope.remove = function (data) {

    bootbox.confirm("Are you sure you want to delete " + data.code + " ?", function (c) {

      if (c) {

        ScholarshipApplication.remove({ id: data.id }, function (e) {

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

  $scope.print = function(){

    if ($scope.conditionsPrintPending !== '') {
    
      printTable(base + 'print/student_applications?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_applications?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/student_applications?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/student_applications?print=1');

    }

  }

  $scope.printConfirmed = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/student_applications?print=1' + $scope.conditionsPrintConfirmed);

    }else{

      printTable(base + 'print/student_applications?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDispproved !== '') {
    
      printTable(base + 'print/student_applications?print=1' + $scope.conditionsPrintDispproved);

    }else{

      printTable(base + 'print/student_applications?print=1');

    }

  }

});

app.controller("AdminScholarshipApplicationAddController", function ($scope, ScholarshipApplication, Select) {

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

    ScholarshipApplication: {},

  };
      Select.get({code: 'program-list'}, function(e) {

    $scope.course = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.ApartelleRegistration.year = val.value;

        }

      });

    }

  }

  Select.get({ code: "scholarship-application-code" }, function (e) {
     
    $scope.data.ScholarshipApplication.code = e.data;

  });

  Select.get({ code: "scholarship-name-list" }, function (e) {

    $scope.scholarship_name = e.data;

  });

  Select.get({ code: "college-program-list-all" }, function (e) {

    $scope.programs = e.data;

  });

  Select.get({ code: "school-list" }, function (e) {

    $scope.school = e.data;

  });

  $scope.getSchool = function(id){

    if($scope.school.length > 0){

      $.each($scope.school, function(i,val){

        if(val.id == id){

          $scope.data.ScholarshipApplication.school_address = val.school_address;

        }

      });

    }

  }

  Select.get({ code: 'province-list'}, function (e){

    $scope.provinces = e.data;

  });


  $scope.getTown = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'town-list',province_id: id}, function (e){

        $scope.towns = e.data;

      });

    }else{

      $scope.towns = [];

    }

  }

  $scope.getBarangay = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'barangay-list',town_id: id}, function (e){

        $scope.barangays = e.data;

      });

      // Select.get({ code: 'zip-list',town_id: id}, function (e){

      //   $scope.data.StudentProfile.zip_code = e.data;

      // });

    }else{

      $scope.barangays = [];
      
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

    // console.log(student);
   
    $scope.student = {
    
      id: student.id,

      code: student.code,

      name: student.name,

      program_id: student.program_id,

      year_term_id: student.year_term_id,

      email: student.email,

      school_year: student.school_year,

      contact_no: student.contact_no,

      age: student.age,

      civil_status: student.civil_status,

      gender: student.gender,
   
    };
 
  };

  $scope.studentData = function (id) {

    if($scope.student.year_term_id == 1 || $scope.student.year_term_id == 4 || $scope.student.year_term_id == 7 || $scope.student.year_term_id == 10 || $scope.student.year_term_id == 13){

      $scope.student.semester = 1;

    }else if($scope.student.year_term_id == 2 || $scope.student.year_term_id == 5 || $scope.student.year_term_id == 8 || $scope.student.year_term_id == 11 || $scope.student.year_term_id == 14){

      $scope.student.semester = 2;

    }
    
    $scope.data.ScholarshipApplication.student_id = $scope.student.id;

    $scope.data.ScholarshipApplication.student_name = $scope.student.name;

    $scope.data.ScholarshipApplication.student_no = $scope.student.code;

    $scope.data.ScholarshipApplication.program_id = $scope.student.program_id;

    $scope.data.ScholarshipApplication.year_term_id = $scope.student.year_term_id;

    $scope.data.ScholarshipApplication.semester = $scope.student.semester;

    $scope.data.ScholarshipApplication.email = $scope.student.email;

    $scope.data.ScholarshipApplication.school_year = $scope.student.school_year;

    $scope.data.ScholarshipApplication.contact_number = $scope.student.contact_no;

    $scope.data.ScholarshipApplication.age = $scope.student.age;

    $scope.data.ScholarshipApplication.civil_status = $scope.student.civil_status;

    $scope.data.ScholarshipApplication.sex = $scope.student.gender;
  
  };

  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      ScholarshipApplication.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/admission/admin-scholarship-application";

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

app.controller("AdminScholarshipApplicationViewController", function ($scope, $routeParams, ScholarshipApplication, ScholarshipApplicationApprove, ScholarshipApplicationConfirm, ScholarshipApplicationDisapproved) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {
   
    ScholarshipApplication.get({ id: $scope.id }, function (e) {
   
      $scope.data = e.data;
   
    });
  
  };

  $scope.load();

  $scope.print = function (id) {
  
    printTable(base + "print/scholarship_application_form/" + id);
  
  };

  $scope.approve = function(data){

    bootbox.confirm('Are you sure you want to approve application ' +  data.code + '?', function(e){

      if(e) {

        ScholarshipApplicationApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Scholarship Application has been successfully approved.'

            });

          }

          window.location = "#/admission/admin-scholarship-application";

        });

      }

    });

  }

  $scope.confirm = function(data){

    bootbox.confirm('Are you sure you want to confirm application ' +  data.code + '?', function(e){

      if(e) {

        ScholarshipApplicationConfirm.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Scholarship Application has been successfully confirmed.'

            });

          }

          window.location = "#/admission/admin-scholarship-application";

        });

      }

    });

  }

  $scope.disapprove = function(data){  

    bootbox.confirm('Are you sure you want to disapprove application ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            ScholarshipApplicationDisapproved.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Scholarship Application has been successfully disapproved.'

                });

                $scope.load();

                window.location = "#/admission/admin-scholarship-application";

              }

            });

          }

        });

      }

    });

  }

  // remove
  $scope.remove = function (data) {
  
    bootbox.confirm("Are you sure you want to remove " + data.code + " ?", function (c) {
  
      if (c) {

        ScholarshipApplication.remove({ id: data.id }, function (e) {

          if (e.ok) {

            $.gritter.add({

              title: "Successful!",

              text: e.msg,

            });

            window.location = "#/admission/admin-scholarship-application";

          }

        });

      }

    });

  };

});

app.controller("AdminScholarshipApplicationEditController", function ($scope, $routeParams, ScholarshipApplication, Select) {
  
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
  
    ScholarshipApplication: {},
  
  };
      Select.get({code: 'program-list'}, function(e) {

    $scope.course = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.ApartelleRegistration.year = val.value;

        }

      });

    }

  }

  Select.get({ code: "college-program-list-all" }, function (e) {

    $scope.programs = e.data;

  });

  Select.get({ code: 'province-list'}, function (e){

    $scope.provinces = e.data;

  });

  Select.get({ code: 'town-list'}, function (e){

    $scope.towns = e.data;

  });

  Select.get({ code: 'barangay-list'}, function (e){

    $scope.barangays = e.data;

  });

  $scope.getTown = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'town-list',province_id: id}, function (e){

        $scope.towns = e.data;

      });

    }else{

      $scope.towns = [];

    }

  }

  $scope.getBarangay = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'barangay-list',town_id: id}, function (e){

        $scope.barangays = e.data;

      });

      // Select.get({ code: 'zip-list',town_id: id}, function (e){

      //   $scope.data.StudentProfile.zip_code = e.data;

      // });

    }else{

      $scope.barangays = [];
      
    }

  }

  Select.get({ code: "school-list" }, function (e) {

    $scope.school = e.data;

  });

  $scope.getSchool = function(id){

    if($scope.school.length > 0){

      $.each($scope.school, function(i,val){

        if(val.id == id){

          $scope.data.ScholarshipApplication.school_address = val.school_address;

        }

      });

    }

  }

  Select.get({ code: "scholarship-name-list" }, function (e) {

    $scope.scholarship_name = e.data;

  });

  // load

  $scope.load = function () {
  
    ScholarshipApplication.get({ id: $scope.id }, function (e) {
  
      $scope.data = e.data;
  
    });
  
  };

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

      program_id: student.program_id,

      email: student.email,
   
    };
 
  };

  $scope.studentData = function (id) {
    
    $scope.data.ScholarshipApplication.student_id = $scope.student.id;

    $scope.data.ScholarshipApplication.student_name = $scope.student.name;

    $scope.data.ScholarshipApplication.student_no = $scope.student.code;

    $scope.data.ScholarshipApplication.program_id = $scope.student.program_id;

    $scope.data.ScholarshipApplication.email = $scope.student.email;
  
  };

  $scope.load();

  $scope.update = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      ScholarshipApplication.update({ id: $scope.id },$scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/admission/admin-scholarship-application";

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
