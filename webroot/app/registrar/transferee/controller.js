app.controller('TransfereeController', function($scope, Transferee) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    options['per_student'] = 1;

    Transferee.query(options, function(e) {

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

    options['per_student'] = 1;

    Transferee.query(options, function(e) {

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

    options['per_student'] = 1;

    Transferee.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapproved = e.data;

        $scope.conditionsPrintDisapproved = e.conditionsPrint;

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

    bootbox.confirm('Are you sure you want to delete transferee?', function(c) {

      if (c) {

        Transferee.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/transferee?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/transferee?print=1');

    }

  }

});

app.controller('TransfereeAddController', function($scope, Transferee, Select, Student) {

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

    Transferee : {},

    TransfereeImage : []

  }

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  $scope.saveImages = function (files) {

    if(files == undefined){

      files = '';

    }

    if(files.length > 0){

      $scope.data.TransfereeImage.push({

        images  : $scope.files,

      });  

    }

  }

  Select.get({code: ''}, function(e) {

    Student.get({ id: e.studentId }, function(response) {

      $scope.data.Transferee.student_id = response.data.Student.id;

      $scope.data.Transferee.student_name = response.data.Student.full_name;

      $scope.data.Transferee.student_no = response.data.Student.student_no;

      $scope.data.Transferee.first_name = response.data.Student.first_name;

      $scope.data.Transferee.middle_name = response.data.Student.middle_name;

      $scope.data.Transferee.last_name = response.data.Student.last_name;

      $scope.data.Transferee.year_term_id = response.data.Student.year_term_id;

      $scope.data.Transferee.college_id = response.data.Student.college_id;

      $scope.data.Transferee.program_id = response.data.Student.program_id;

      $scope.data.Transferee.email = response.data.Student.email;

      $scope.data.Transferee.gender = response.data.Student.gender;

      $scope.data.Transferee.contact_no = response.data.Student.contact_no;

      $scope.data.Transferee.address = response.data.Student.present_address;

      $scope.data.Transferee.type = 'Transfer Out';

    });

  });

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Select.get({code: 'check-honorable-dismissal', student_id : $scope.data.Transferee.student_id}, function(q) {

        if(q.data){

          Transferee.save($scope.data, function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text:  e.msg,

              });

              window.location = '#/registrar/transferee';

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

            text:  'Please apply for Honorable Dismissal to proceed.',

          });

        }

      });

    }  

  }

});

app.controller('TransfereeViewController', function($scope, $routeParams, Transferee) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    Transferee.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.transfereeImage = e.transfereeImage;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove transferee?', function(c) {

      if (c) {

        Transferee.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/admission/transferee";

          }

        });

      }

    });

  } 

});

app.controller('TransfereeEditController', function($scope, $routeParams, Transferee, TransfereeImage, TransfereeRemoveImage, Select) {
  
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

    Transferee : {},

    TransfereeImage : []

  }

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  // load 

  $scope.load = function() {

    Transferee.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.transfereeImage = e.transfereeImage;

    });

  }

  $scope.load();

  $scope.addImage = function() {

    var x = document.getElementById("upload_prev").innerHTML = " ";

    $('#edit-upload-image').modal('show');

  };

  $scope.saveImages = function (files) {
    
    $scope.TransfereeImage = [];

    angular.forEach(files, function(file, e){

      $scope.TransfereeImage.push({

        images                : file.name,

        transferee_id         : $scope.id,

        url                   : file.url,

        _file                 : file._file,

        $$hashKey             : file.$$hashKey

      });

    });
    
    TransfereeImage.save($scope.TransfereeImage, function(e) {

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

        TransfereeRemoveImage.delete({ id: image.id }, function(e) {

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

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Select.get({code: 'check-honorable-dismissal', student_id : $scope.data.Transferee.student_id}, function(q) {

        if(q.data){

          Transferee.update({id:$scope.id}, $scope.data, function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text:  e.msg,

              });

              window.location = '#/registrar/transferee';

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

            text:  'Please apply for Honorable Dismissal to proceed.',

          });

        }

      });

    }

  }

});

app.controller('AdminTransfereeController', function($scope, Transferee, TransfereeApprove) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    Transferee.query(options, function(e) {

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

    Transferee.query(options, function(e) {

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

    Transferee.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapproved = e.data;

        $scope.conditionsPrintDisapproved = e.conditionsPrint;

        // paginator

        $scope.paginatorDisapproved  = e.paginator;

        $scope.pagesDisapproved = paginator($scope.paginatorDisapproved, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);

    // $scope.approved(options);

    // $scope.disapproved(options);

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

  $scope.approve = function(data) {

    bootbox.confirm('Are you sure you want to approve transferee?', function(c) {

      if (c) {

        TransfereeApprove.get({id : data.id}, function(e) {

          if(e.ok) {

            $.gritter.add({

              title : 'Successful!',

              text: e.msg

            });

            $scope.load();

          }else{

            $.gritter.add({

              title : 'Warning!',

              text: e.msg

            });

          }

        })

      }

    });

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete transferee?', function(c) {

      if (c) {

        Transferee.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/transferee?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/transferee?print=1');

    }

  }

});

app.controller('AdminTransfereeAddController', function($scope, Transferee, Select) {

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

    Transferee : {},

    TransfereeImage : []

  }

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getProgram = function(id){

      Select.get({ code: 'application-program-list', college_id : id }, function(e) { 

        $scope.programs = e.data;

      });

  }

  if($scope.data.type == 'Transfer In'){

      $scope.getProgram = function(id){

      Select.get({ code: 'application-program-list', college_id : id }, function(e) { 

        $scope.programs = e.data;

      });

    }

  }else{

    Select.get({ code: 'program-list' }, function(e) { 

        $scope.programs = e.data;

    });

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

      id   : student.id,

      code : student.code,

      name : student.name,

      first_name : student.first_name,

      middle_name : student.middle_name,

      last_name : student.last_name,

      year_term_id : student.year_term_id,

      college_id : student.college_id,

      program_id : student.program_id,

      email : student.email,

      gender : student.gender,

      contact_no : student.contact_no,

      address : student.address,

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.Transferee.student_id = $scope.student.id;

    $scope.data.Transferee.student_no = $scope.student.code;

    $scope.data.Transferee.student_name = $scope.student.name;

    $scope.data.Transferee.first_name = $scope.student.first_name;

    $scope.data.Transferee.middle_name = $scope.student.middle_name;

    $scope.data.Transferee.last_name = $scope.student.last_name;

    $scope.data.Transferee.year_term_id = $scope.student.year_term_id;

    $scope.data.Transferee.college_id = $scope.student.college_id;

    $scope.data.Transferee.program_id = $scope.student.program_id;

    $scope.data.Transferee.email = $scope.student.email;

    $scope.data.Transferee.gender = $scope.student.gender;

    $scope.data.Transferee.contact_no = $scope.student.contact_no;

    $scope.data.Transferee.address = $scope.student.address;

  }

  $scope.clearData = function(){

    $scope.data.Transferee.student_id = null;

    $scope.data.Transferee.student_no = null;

    $scope.data.Transferee.student_name = null;

    $scope.data.Transferee.first_name = null;

    $scope.data.Transferee.middle_name = null;

    $scope.data.Transferee.last_name = null;

    $scope.data.Transferee.year_term_id = null;

    $scope.data.Transferee.college_id = null;

    $scope.data.Transferee.program_id = null;

    $scope.data.Transferee.email = null;

  }

  $scope.saveImages = function (files) {

    if(files == undefined){

      files = '';

    }

    if(files.length > 0){

      $scope.data.TransfereeImage.push({

        images  : $scope.files,

      });  

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      if($scope.data.Transferee.type == 'Transfer Out'){

        Select.get({code: 'check-honorable-dismissal', student_id : $scope.data.Transferee.student_id}, function(q) {

          if(q.data){

            Transferee.save($scope.data, function(e) {

              if (e.ok) {

                $.gritter.add({

                  title: 'Successful!',

                  text:  e.msg,

                });

                window.location = '#/registrar/admin-transferee';

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

              text:  'Please apply for Honorable Dismissal to proceed.',

            });

          }

        });

      }else{

        Transferee.save($scope.data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = '#/registrar/admin-transferee';

          } else {

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,

            });

          }

        });

      }

    }  

  }

});

app.controller('AdminTransfereeViewController', function($scope, $routeParams, Transferee) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    Transferee.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.transfereeImage = e.transfereeImage;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove transferee?', function(c) {

      if (c) {

        Transferee.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/registrar/admin-transferee";

          }

        });

      }

    });

  } 

});

app.controller('AdminTransfereeEditController', function($scope, $routeParams, Transferee, TransfereeImage, TransfereeRemoveImage, Select) {
  
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

    Transferee : {},

    TransfereeImage : []

  }

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getProgram = function(id){

      Select.get({ code: 'application-program-list', college_id : id }, function(e) { 

        $scope.programs = e.data;

      });

  }

  if($scope.data.type == 'Transfer In'){

      $scope.getProgram = function(id){

      Select.get({ code: 'application-program-list', college_id : id }, function(e) { 

        $scope.programs = e.data;

      });

    }

  }else{

    Select.get({ code: 'program-list' }, function(e) { 

        $scope.programs = e.data;

    });

  }

  // load 

  $scope.load = function() {

    Transferee.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.transfereeImage = e.transfereeImage;

    });

  }

  $scope.load();

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

      name : student.name,

      first_name : student.first_name,

      middle_name : student.middle_name,

      last_name : student.last_name,

      year_term_id : student.year_term_id,

      email : student.email,

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.Transferee.student_id = $scope.student.id;

    $scope.data.Transferee.student_no = $scope.student.code;

    $scope.data.Transferee.student_name = $scope.student.name;

    $scope.data.Transferee.first_name = $scope.student.first_name;

    $scope.data.Transferee.middle_name = $scope.student.middle_name;

    $scope.data.Transferee.last_name = $scope.student.last_name;

    $scope.data.Transferee.year_term_id = $scope.student.year_term_id;

    $scope.data.Transferee.email = $scope.student.email;

  }

  $scope.clearData = function(){

    $scope.data.Transferee.student_id = null;

    $scope.data.Transferee.student_no = null;

    $scope.data.Transferee.student_name = null;

    $scope.data.Transferee.first_name = null;

    $scope.data.Transferee.middle_name = null;

    $scope.data.Transferee.last_name = null;

    $scope.data.Transferee.year_term_id = null;

    $scope.data.Transferee.email = null;

  }

  $scope.addImage = function() {

    var x = document.getElementById("upload_prev").innerHTML = " ";

    $('#edit-upload-image').modal('show');

  };

  $scope.saveImages = function (files) {
    
    $scope.TransfereeImage = [];

    angular.forEach(files, function(file, e){

      $scope.TransfereeImage.push({

        images                : file.name,

        transferee_id         : $scope.id,

        url                   : file.url,

        _file                 : file._file,

        $$hashKey             : file.$$hashKey

      });

    });
    
    TransfereeImage.save($scope.TransfereeImage, function(e) {

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

        TransfereeRemoveImage.delete({ id: image.id }, function(e) {

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

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      if($scope.data.Transferee.type == 'Transfer Out'){

        Select.get({code: 'check-honorable-dismissal', student_id : $scope.data.Transferee.student_id}, function(q) {

          if(q.data){

            Transferee.update({id:$scope.id}, $scope.data, function(e) {

              if (e.ok) {

                $.gritter.add({

                  title: 'Successful!',

                  text:  e.msg,

                });

                window.location = '#/registrar/admin-transferee';

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

              text:  'Please apply for Honorable Dismissal to proceed.',

            });

          }

        });

      }else{

        Transferee.update({id:$scope.id}, $scope.data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = '#/registrar/admin-transferee';

          } else {

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,
              
            });

          }
          
        }); 

      }

    }  

  }

});