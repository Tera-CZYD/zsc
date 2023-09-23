app.controller('StudentApplicationController', function($scope, StudentApplication) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    StudentApplication.query(options, function(e) {

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

    StudentApplication.query(options, function(e) {

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

    StudentApplication.query(options, function(e) {

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

    bootbox.confirm('Are you sure you want to delete application?', function(c) {

      if (c) {

        StudentApplication.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/student_application?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_application?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/student_application?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/student_application?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDisapproved !== '') {
    
      printTable(base + 'print/student_application?print=1' + $scope.conditionsPrintDisapproved);

    }else{

      printTable(base + 'print/student_application?print=1');

    }

  }

});

app.controller('StudentApplicationAddController', function($scope, StudentApplication, Select) {

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

    StudentApplication : {},

    StudentApplicationImage : []

  }


  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getProgram = function(id){

    Select.get({ code: 'application-program-list', college_id : id }, function(e) { 

      $scope.programs = e.data;

    });

  }

  $scope.generateRandomString = function(){

    var result = '';
   
    var characters = '0123456789';
   
    var charactersLength = characters.length;
   
    for (var i = 0; i < 5; i++) {
   
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   
    }

    const d = new Date();

    $scope.data.StudentApplication.student_no = d.getFullYear()+'OA'+result;

  }

  $scope.generateRandomString();

  // $scope.isValidFileType = function (file) {
    
  //   var allowedExtensions = ["png", "jpeg", "jpg", "pdf"];

    
  //   var fileExtension = file.name.split('.').pop().toLowerCase();

    
  //   return allowedExtensions.indexOf(fileExtension) !== -1;

  // };

  // $scope.validateFiles = function () {

  //   console.log('sheesh')

  //   var validFiles = [];
  //   var invalidFiles = [];

  //   // Loop through the selected files
  //   for (var i = 0; i < $scope.data.StudentApplicationImage.length; i++) {
  //     var file = $scope.data.StudentApplicationImage[i];

  //     // Check if the file is of an allowed type
  //     if ($scope.isValidFileType(file)) {
  //       validFiles.push(file);
  //     } else {
  //       invalidFiles.push(file);
  //     }
  //   }

    
  //   $scope.data.StudentApplicationImage = validFiles;


  //   if (invalidFiles.length > 0) {
  //     alert("Invalid file types. Allowed types: PNG, JPEG, PDF");
      
  //   }

  // };

  $scope.saveImages = function (files) {

    if(files == undefined){

      files = '';

    }

    if(files.length > 0){

      $scope.data.StudentApplicationImage.push({

        images  : $scope.files,

      });  

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      StudentApplication.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/admission/student-application';

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

app.controller('StudentApplicationViewController', function($scope, $routeParams, StudentApplication, StudentApplicationApprove, StudentApplicationDisapprove) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    StudentApplication.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.requirements = e.requirement;

      $scope.applicationImage = e.applicationImage;

    });

  }

  $scope.load(); 

  $scope.approve = function(data){  

    bootbox.confirm('Are you sure you want to approve application?', function(b){

      if(b) {

        StudentApplicationApprove.update({id:data.id},$scope.data, function(e){

          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text: e.msg

            });

            window.location = '#/admission/student-application';

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

  $scope.adata = {}

  $scope.disapprove = function(data){  

    bootbox.confirm('Are you sure you want to disapprove application?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.adata = $scope.data;

            $scope.data = {

              explanation : result

            };

            StudentApplicationDisapprove.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text: e.msg

                });

                window.location = "#/admission/student-application";

              }else{

                $.gritter.add({

                  title : 'Warning!',

                  text: e.msg

                });

                $scope.data = $scope.adata;

              }

            });

          }

        });

      }

    });

  }

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove application?', function(c) {

      if (c) {

        StudentApplication.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/admission/student-application";

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

});

app.controller('StudentApplicationEditController', function($scope, $routeParams, StudentApplication, StudentApplicationImage, StudentApplicationRemoveImage, Select) {
  
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

    StudentApplication : {},

    StudentApplicationImage : []

  }

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getProgram = function(id){

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  // load 

  $scope.load = function() {

    StudentApplication.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.applicationImage = e.applicationImage;

      Select.get({ code: 'application-program-list', college_id : $scope.data.StudentApplication.college_id }, function(e) {

        $scope.programs = e.data;

      });

    });

  }

  $scope.load();

  $scope.addImage = function() {

    var x = document.getElementById("upload_prev").innerHTML = " ";

    $('#edit-upload-image').modal('show');

  };

  $scope.saveImages = function (files) {
    
    $scope.StudentApplicationImage = [];

    angular.forEach(files, function(file, e){

      $scope.StudentApplicationImage.push({

        images                : file.name,

        application_id        : $scope.id,

        url                   : file.url,

        _file                 : file._file,

        $$hashKey             : file.$$hashKey

      });

    });
    
    StudentApplicationImage.save($scope.StudentApplicationImage, function(e) {

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

  $scope.removeImage = function(image) {

    bootbox.confirm('Are you sure you want to delete ' + image.name + '?', function(b) {

      if (b) {

        StudentApplicationRemoveImage.delete({ id: image.id }, function(e) {

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

      StudentApplication.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/admission/student-application';

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