app.controller('StudentAdmissionController', function($scope, StudentApplicant,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  Select.get({ code: 'college-list'}, function (e){

    $scope.colleges = e.data;

  });

  Select.get({ code: 'degree-list'}, function (e){

    $scope.degrees = e.data;

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    StudentApplicant.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.header = e.header;

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
 
    $scope.college_id = null;
 
    $scope.degree_id = null;

    $scope.load();

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search      : search,

        date        : $scope.dateToday,

        startDate   : $scope.startDate,

        endDate     : $scope.endDate,

        college_id  : $scope.college_id,

        degree_id   : $scope.degree_id

      });

    }else{

      $scope.load({

        date        : $scope.dateToday,

        startDate   : $scope.startDate,

        endDate     : $scope.endDate,

        college_id  : $scope.college_id,

        degree_id   : $scope.degree_id

      });
    
    }

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.description +' ?', function(c) {

      if (c) {

        StudentApplicant.remove({ id: data.id }, function(e) {

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

  $scope.advanceSearch = false;
  
  $scope.advance_search = function() {
  
    $scope.search = {};
 
    $scope.advanceSearch = false;
 
    $('.yearpicker').datepicker({

      format: 'yyyy', 

      autoclose: true, 

      minViewMode: 'years',

      maxViewMode:'years'

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });
 
    $('.monthpicker').datepicker({

      format: 'MM', 

      autoclose: true, 

      minViewMode: 'months',

      maxViewMode:'months'

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });

    $('.datepicker').datepicker({

      format:    'mm/dd/yyyy',

      autoclose: true,

      todayHighlight: true,

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });
 
    $('.input-daterange').datepicker({
 
      format: 'mm/dd/yyyy'

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {

    $scope.filter = false;

    $scope.advanceSearch = true;

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;
 
    $scope.college_id = null;
 
    $scope.degree_id = null;

    if (search.filterBy == 'today') {
     
      $scope.dateToday = Date.parse($scope.today).toString('yyyy-MM-dd');

    }else if (search.filterBy == 'date') {

      $scope.dateToday = Date.parse(search.date).toString('yyyy-MM-dd');
   
    }else if (search.filterBy == 'month') {
   
      date = $('.monthpicker').datepicker('getDate');
   
      year = date.getFullYear();
   
      month = date.getMonth() + 1;
   
      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;
      
      $scope.startDate = year + '-' + month + '-01';
      
      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();
    
    }else if (search.filterBy == 'this-month') {
      
      date = new Date();
      
      year = date.getFullYear();
      
      month = date.getMonth() + 1;
      
      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;
      
      $scope.startDate = year + '-' + month + '-01';
      
      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();
   
    }else if (search.filterBy == 'custom-range') {
    
      $scope.startDate = search.startDate;
    
      $scope.endDate = search.endDate;
    
    }else if (search.filterBy == 'year') {
   
      year = search.year;
      
      $scope.startDate = year + '-01-01';
      
      $scope.endDate = year + '-12-31';

    }

    if(search.college_id !== null && search.college_id !== '' && search.college_id !== undefined){

      $scope.college_id = search.college_id;

    }

    if(search.degree_id !== null && search.degree_id !== '' && search.degree_id !== undefined){

      $scope.degree_id = search.degree_id;

    }

    $scope.load({

      date        : $scope.dateToday,

      startDate   : $scope.startDate,

      endDate     : $scope.endDate,

      college_id  : $scope.college_id,

      degree_id   : $scope.degree_id

    });

    $('#advance-search-modal').modal('hide');
  
  }

  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/student_admission?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_admission?print=1');

    }

  }

  $scope.import = function(){

    printTable(base + 'print/import_student?print=1');

  }

});

app.controller('StudentAdmissionAddController', function($scope, StudentApplicant, Select) {

  $('#form').validationEngine('attach');

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({

    format: 'mm/dd/yyyy',

    autoclose: true,

  }).on('show', function(e){
    
    if ( e.date ) {
    
      $(this).data('stickyDate', e.date);
    
    } else if($(this).val()){
    
      /**auto-populate existing selection*/
    
      $(this).data('stickyDate', new Date($(this).val()));
    
      $(this).datepicker('setDate', new Date($(this).val()));
    
    } else {
    
      $(this).data('stickyDate', null);
    
    }
  
  }).on('hide', function(e){
  
    var stickyDate = $(this).data('stickyDate');

    if ( !e.date && stickyDate ) {

      $(this).datepicker('setDate', stickyDate);

      $(this).data('stickyDate', null);

    }
  
  });

  $scope.data = {

    StudentApplicant : {

      date : $scope.today

    }

  }

  Select.get({ code: 'college-list'}, function (e){

    $scope.colleges = e.data;

  });

  Select.get({ code: 'degree-list'}, function (e){

    $scope.degrees = e.data;

  });

  Select.get({ code: 'income-list'}, function (e){

    $scope.incomes = e.data;

  });

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      StudentApplicant.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/student-admission';

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

app.controller('StudentAdmissionViewController', function($scope, $routeParams, DeleteSelected, StudentApplicant,StudentApplicantAdmit,Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    StudentApplicant.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.admit = function(data) {

    bootbox.confirm('Are you sure you want to admit '+ data.code +' ?', function(c) {

      if (c) {

        StudentApplicantAdmit.get({id:data.id}, function(e){

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/student-admission";

          }

        });

      }

    });

  } 

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.description +' ?', function(c) {

      if (c) {

        StudentApplicant.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/student-admission";

          }

        });

      }

    });

  } 

});

app.controller('StudentAdmissionEditController', function($scope, $routeParams, StudentApplicant, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format: 'mm/dd/yyyy',

    autoclose: true,

  }).on('show', function(e){
    
    if ( e.date ) {
    
      $(this).data('stickyDate', e.date);
    
    } else if($(this).val()){
    
      /**auto-populate existing selection*/
    
      $(this).data('stickyDate', new Date($(this).val()));
    
      $(this).datepicker('setDate', new Date($(this).val()));
    
    } else {
    
      $(this).data('stickyDate', null);
    
    }
  
  }).on('hide', function(e){
  
    var stickyDate = $(this).data('stickyDate');

    if ( !e.date && stickyDate ) {

      $(this).datepicker('setDate', stickyDate);

      $(this).data('stickyDate', null);

    }
  
  });

  Select.get({ code: 'college-list'}, function (e){

    $scope.colleges = e.data;

  });

  Select.get({ code: 'degree-list'}, function (e){

    $scope.degrees = e.data;

  });

  Select.get({ code: 'income-list'}, function (e){

    $scope.incomes = e.data;

  });

  // load 

  $scope.load = function() {

    StudentApplicant.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      StudentApplicant.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/student-admission';

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

app.controller('StudentAdmissionUploadStudentInformationAddController', function($scope, ImportUpload,ImportUploadCheckData,ImportUploadSave,StudentApplicantImport,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.files = [];

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    ImportUpload.query(options, function(e) {

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
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;
 
    $scope.college_id = null;
 
    $scope.degree_id = null;

    $scope.load();

  }

  $scope.upload = function (files){

    if(files.length == undefined){

      bootbox.confirm('Are you sure you want to upload this file ?', function(c) {

        if (c) {
      
          $scope.StudentApplicantImport = [];

          angular.forEach(files, function(file, e){

            $scope.StudentApplicantImport.push({

              file_name       : file.name,

              url             : file.url,

              _file           : file._file,

              $$hashKey       : file.$$hashKey

            });

          });
          
          StudentApplicantImport.save($scope.StudentApplicantImport, function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Success!',

                text:  e.msg,

              });

              $('#edit-upload-image').modal('hide');

              $scope.load();

              $scope.reset();

            } else {

              $.gritter.add({

                title: 'Warning!',

                text:  e.msg,

              });

            }

          });

        }

      });

    } else {

      $.gritter.add({

        title: 'Warning!',

        text:  'No file selected.',

      });

    }

  }

  $scope.reset = function(){

    document.getElementById("excel").value = "";

    $scope.files = [];

  }

  $scope.showFiles = function(){

    $scope.show = true;

  }

  $scope.checkData = function(data) {

    bootbox.confirm('Are you sure you want to check data of '+ data.file_name +' ?', function(c) {

      if (c) {

        ImportUploadCheckData.get({id:data.id}, function(e){

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            $scope.load();

          }else{

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,

            });

          }

        });

      }

    });

  } 

  $scope.importData = function(data) {

    bootbox.confirm('Are you sure you want to import data of '+ data.file_name +' ?', function(c) {

      if (c) {

        ImportUploadSave.get({id:data.id}, function(e){

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            $scope.load();

          }else{

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,

            });

          }

        });

      }

    });

  } 

  $scope.ExportToExcel = function(type, fn, dl){

    var elt = document.getElementById('tbl_exporttable_to_xls');

    var wb = XLSX.utils.table_to_book(elt, { sheet: "student" });

    return dl ? XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) : XLSX.writeFile(wb, fn || ('studentdatatemplate.' + (type || 'csv')));

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search      : search,

        date        : $scope.dateToday,

        startDate   : $scope.startDate,

        endDate     : $scope.endDate,

        college_id  : $scope.college_id,

        degree_id   : $scope.degree_id

      });

    }else{

      $scope.load({

        date        : $scope.dateToday,

        startDate   : $scope.startDate,

        endDate     : $scope.endDate,

        college_id  : $scope.college_id,

        degree_id   : $scope.degree_id

      });
    
    }

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.file_name +' ?', function(c) {

      if (c) {

        ImportUpload.remove({ id: data.id }, function(e) {

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

  $scope.advanceSearch = false;
  
  $scope.advance_search = function() {
  
    $scope.search = {};
 
    $scope.advanceSearch = false;
 
    $('.yearpicker').datepicker({

      format: 'yyyy', 

      autoclose: true, 

      minViewMode: 'years',

      maxViewMode:'years'

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });
 
    $('.monthpicker').datepicker({

      format: 'MM', 

      autoclose: true, 

      minViewMode: 'months',

      maxViewMode:'months'

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });

    $('.datepicker').datepicker({

      format:    'mm/dd/yyyy',

      autoclose: true,

      todayHighlight: true,

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });
 
    $('.input-daterange').datepicker({
 
      format: 'mm/dd/yyyy'

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {

    $scope.filter = false;

    $scope.advanceSearch = true;

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;
 
    $scope.college_id = null;
 
    $scope.degree_id = null;

    if (search.filterBy == 'today') {
     
      $scope.dateToday = Date.parse($scope.today).toString('yyyy-MM-dd');

    }else if (search.filterBy == 'date') {

      $scope.dateToday = Date.parse(search.date).toString('yyyy-MM-dd');
   
    }else if (search.filterBy == 'month') {
   
      date = $('.monthpicker').datepicker('getDate');
   
      year = date.getFullYear();
   
      month = date.getMonth() + 1;
   
      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;
      
      $scope.startDate = year + '-' + month + '-01';
      
      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();
    
    }else if (search.filterBy == 'this-month') {
      
      date = new Date();
      
      year = date.getFullYear();
      
      month = date.getMonth() + 1;
      
      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;
      
      $scope.startDate = year + '-' + month + '-01';
      
      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();
   
    }else if (search.filterBy == 'custom-range') {
    
      $scope.startDate = search.startDate;
    
      $scope.endDate = search.endDate;
    
    }else if (search.filterBy == 'year') {
   
      year = search.year;
      
      $scope.startDate = year + '-01-01';
      
      $scope.endDate = year + '-12-31';

    }

    if(search.college_id !== null && search.college_id !== '' && search.college_id !== undefined){

      $scope.college_id = search.college_id;

    }

    if(search.degree_id !== null && search.degree_id !== '' && search.degree_id !== undefined){

      $scope.degree_id = search.degree_id;

    }

    $scope.load({

      date        : $scope.dateToday,

      startDate   : $scope.startDate,

      endDate     : $scope.endDate,

      college_id  : $scope.college_id,

      degree_id   : $scope.degree_id

    });

    $('#advance-search-modal').modal('hide');
  
  }

  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/student_admission?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_admission?print=1');

    }

  }

  $scope.import = function(){

    printTable(base + 'print/import_student?print=1');

  }

});