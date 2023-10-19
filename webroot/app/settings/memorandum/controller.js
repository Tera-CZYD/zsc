app.controller('MemorandumController', function($scope, $window, Memorandum) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Memorandum.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        // paginator

        $scope.paginator  = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.scrollToTop = function() {

    $window.scrollTo(0, 0);

  };

  $scope.scrollToTop();

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

    bootbox.confirm('Are you sure you want to delete memorandum?', function(c) {

      if (c) {

        Memorandum.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/memorandum?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/memorandum?print=1');

    }

  }

});

app.controller('MemorandumAddController', function($scope, Memorandum, Select, Student) {

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

  });

 Select.get({code: 'roles'}, function(e){

    $scope.roles = e.data;

  });

  $scope.data = {

    Memorandum : {},

    memorandumImage : []

  }

  $scope.saveImages = function (files) {

    if(files == undefined){

      files = '';

    }

    if(files.length > 0){

      $scope.data.memorandumImage.push({

        images  : $scope.files,

      });  

    }

  }

  

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Memorandum.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/settings/memorandum';

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

app.controller('MemorandumViewController', function($scope, $routeParams, Memorandum) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    Memorandum.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.memorandumImage = e.memorandumImage;

    });

  }

  $scope.load();  

  // $scope.approve = function(data){

  //   bootbox.confirm('Are you sure you want to memorandum?', function(e){

  //     if(e) {

  //       Memorandum.get({id:data.id}, function(e){

  //         if(e.ok){

  //           $scope.load();

  //           $.gritter.add({

  //             title: 'Successful!',

  //             text: e.msg

  //           });

  //         }

  //         window.location = "#/settings/memorandum";

  //       });

  //     }

  //   });

  // }

  // $scope.disapprove = function(data){  

  //   bootbox.confirm('Are you sure you want to disapprove application?', function(b){

  //     if(b) {

  //       bootbox.prompt('REASON ?', function(result){

  //         if(result){

  //           $scope.data = {

  //             explanation : result

  //           };

  //           StudentApplicationDisapproved.update({id:data.id},$scope.data, function(e){

  //             if(e.ok){

  //               $.gritter.add({

  //                 title : 'Successful!',

  //                 text: e.msg

  //               });

  //               $scope.load();

  //               window.location = "#/settings/student-application";

  //             }

  //           });

  //         }

  //       });

  //     }

  //   });

  // }

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove memorandum?', function(c) {

      if (c) {

        Memorandum.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/settings/memorandum";

          }

        });

      }

    });

  } 

});

app.controller('MemorandumEditController', function($scope, $routeParams, Select, Memorandum, MemorandumImage, MemorandumRemoveImage) {
  
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

    Memorandum : {},

    MemorandumImage : []

  }

  Select.get({code: 'roles'}, function(e){

    $scope.roles = e.data;

  });

  // load 

  $scope.load = function() {

    Memorandum.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.memorandumImage = e.memorandumImage;

    });

  }

  $scope.load();

  $scope.addImage = function() {

    var x = document.getElementById("upload_prev").innerHTML = " ";

    $('#edit-upload-image').modal('show');

  };

  $scope.saveImages = function (files) {
    
    $scope.MemorandumImage = [];

    angular.forEach(files, function(file, e){

      $scope.MemorandumImage.push({

        images                : file.name,

        memorandum_id         : $scope.id,

        url                   : file.url,

        _file                 : file._file,

        $$hashKey             : file.$$hashKey

      });

    });
    
    MemorandumImage.save($scope.MemorandumImage, function(e) {

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

        MemorandumRemoveImage.delete({ id: image.id }, function(e) {

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


      Memorandum.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/settings/memorandum';

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

// app.controller('AdminTransfereeController', function($scope, Memorandum) {

//   $scope.today = Date.parse('today').toString('MM/dd/yyyy');

//   $('.datepicker').datepicker({
   
//     format: 'mm/dd/yyyy',
   
//     autoclose: true,
   
//     todayHighlight: true
  
//   });

//   $scope.pending = function(options) {

//     options = typeof options !== 'undefined' ?  options : {};

//     options['status'] = 0;

//     Memorandum.query(options, function(e) {

//       if (e.ok) {

//         $scope.datas = e.data;

//         $scope.conditionsPrint = e.conditionsPrint;

//         $scope.paginator = e.paginator;

//         $scope.pages = paginator($scope.paginator, 5);

//       }

//     });

//   }

//   $scope.approved = function(options) {

//     options = typeof options !== 'undefined' ?  options : {};

//     options['status'] = 1;

//     Memorandum.query(options, function(e) {

//       if (e.ok) {

//         $scope.datasApproved = e.data;

//         $scope.conditionsPrintApproved = e.conditionsPrint;

//         // paginator

//         $scope.paginatorApproved  = e.paginator;

//         $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

//       }

//     });

//   }

//   $scope.disapproved = function(options) {

//     options = typeof options !== 'undefined' ?  options : {};

//     options['status'] = 2;

//     Memorandum.query(options, function(e) {

//       if (e.ok) {

//         $scope.datasDisapproved = e.data;

//         $scope.conditionsPrintDisapproved = e.conditionsPrint;

//         // paginator

//         $scope.paginatorDisapproved  = e.paginator;

//         $scope.pagesDisapproved = paginator($scope.paginatorDisapproved, 5);

//       }

//     });

//   }

//   $scope.load = function(options) {

//     $scope.pending(options);

//     // $scope.approved(options);

//     // $scope.disapproved(options);

//   }

//   $scope.load();
  
//   $scope.reload = function(options) {
  
//     $scope.search = {};
 
//     $scope.searchTxt = '';
   
//     $scope.dateToday = null;
   
//     $scope.startDate = null;
   
//     $scope.endDate = null;

//     $scope.load();

//   }

//   $scope.searchy = function(search) {

//     search = typeof search !== 'undefined' ? search : '';

//     if (search.length > 0){

//       $scope.load({

//         search: search

//       });

//     }else{

//       $scope.load();
    
//     }

//   }

//   $scope.selectedFilter = 'date';

//   $scope.changeFilter = function(type){

//     $scope.search = {};

//     $scope.selectedFilter = type;

//     $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
//     $('.input-daterange').datepicker({
 
//       format: 'mm/dd/yyyy'

//     });

//   }

//   $scope.searchFilter = function(search) {
   
//     $scope.searchTxt = '';

//     $scope.dateToday = null;
   
//     $scope.startDate = null;
   
//     $scope.endDate = null;

//     if ($scope.selectedFilter == 'date') {
    
//       $scope.dateToday = Date.parse(search.date).toString('yyyy-MM-dd');
   
//     }else if ($scope.selectedFilter == 'month') {
   
//       date = $('.monthpicker').datepicker('getDate');
   
//       year = date.getFullYear();
   
//       month = date.getMonth() + 1;
   
//       lastDay = new Date(year, month, 0);

//       if (month < 10) month = '0' + month;
      
//       $scope.startDate = year + '-' + month + '-01';
      
//       $scope.endDate = year + '-' + month + '-' + lastDay.getDate();
    
//     }else if ($scope.selectedFilter == 'customRange') {
    
//       $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');
    
//       $scope.endDate = Date.parse(search.endDate).toString('yyyy-MM-dd');
    
//     }

//     $scope.load({

//       date         : $scope.dateToday,

//       startDate    : $scope.startDate,

//       endDate      : $scope.endDate

//     });
  
//   }

//   $scope.remove = function(data) {

//     bootbox.confirm('Are you sure you want to delete memorandum?', function(c) {

//       if (c) {

//         Memorandum.remove({ id: data.id }, function(e) {

//           if (e.ok) {

//             $.gritter.add({

//               title: 'Successful!',

//               text:  e.msg,

//             });

//             $scope.load();

//           }

//         });

//       }

//     });

//   }

//   $scope.print = function(){

//     if ($scope.conditionsPrintPending !== '') {
    
//       printTable(base + 'print/memorandum?print=1' + $scope.conditionsPrint);

//     }else{

//       printTable(base + 'print/memorandum?print=1');

//     }

//   }

//   // $scope.printApproved = function(){

//   //   if ($scope.conditionsPrintApproved !== '') {
    
//   //     printTable(base + 'print/student_application?print=1' + $scope.conditionsPrintApproved);

//   //   }else{

//   //     printTable(base + 'print/student_application?print=1');

//   //   }

//   // }

//   // $scope.printDisapproved = function(){

//   //   if ($scope.conditionsPrintDisapproved !== '') {
    
//   //     printTable(base + 'print/student_application?print=1' + $scope.conditionsPrintDisapproved);

//   //   }else{

//   //     printTable(base + 'print/student_application?print=1');

//   //   }

//   // }

// });

// app.controller('AdminTransfereeAddController', function($scope, Memorandum) {

//  $('#form').validationEngine('attach');

//  $('.datepicker').datepicker({

//     format:'mm/dd/yyyy',

//     autoclose: true,

//     todayHighlight: true,

//   });

//  $('.clockpicker').clockpicker({

//     donetext: 'Done',

//     twelvehour:  true,

//     placement: 'bottom'

//   })

//   $scope.data = {

//     Memorandum : {},

//     MemorandumImage : []

//   }

//   $scope.searchStudent = function(options) {

//     options = typeof options !== 'undefined' ?  options : {};

//     options['code'] = 'search-student';

//     Select.query(options, function(e) {

//       $scope.students = e.data.result;

//       $scope.student = {};
      
//       // paginator

//       $scope.paginator  = e.data.paginator;

//       $scope.pages = paginator($scope.paginator, 10);

//       $("#searched-student-modal").modal('show');

//     });

//   }

//   $scope.selectedStudent = function(student) { 

//     $scope.student = {

//       id   : student.id,

//       code : student.code,

//       name : student.name,

//       first_name : student.first_name,

//       middle_name : student.middle_name,

//       last_name : student.last_name,

//     }; 

//   }

//   $scope.studentData = function(id) {

//     $scope.data.Memorandum.student_id = $scope.student.id;

//     $scope.data.Memorandum.student_no = $scope.student.code;

//     $scope.data.Memorandum.student_name = $scope.student.name;

//     $scope.data.Memorandum.first_name = $scope.student.first_name;

//     $scope.data.Memorandum.middle_name = $scope.student.middle_name;

//     $scope.data.Memorandum.last_name = $scope.student.last_name;

//   }

//   $scope.clearData = function(){

//     $scope.data.Memorandum.student_id = null;

//     $scope.data.Memorandum.student_no = null;

//     $scope.data.Memorandum.student_name = null;

//     $scope.data.Memorandum.first_name = null;

//     $scope.data.Memorandum.middle_name = null;

//     $scope.data.Memorandum.last_name = null;

//   }

//   $scope.saveImages = function (files) {

//     if(files == undefined){

//       files = '';

//     }

//     if(files.length > 0){

//       $scope.data.MemorandumImage.push({

//         images  : $scope.files,

//       });  

//     }

//   }

//   $scope.save = function() {

//     valid = $("#form").validationEngine('validate');
    
//     if (valid) {

//       if($scope.data.Memorandum.type == 'Transfer Out'){

//         Select.get({code: 'check-honorable-dismissal', student_id : $scope.data.Memorandum.student_id}, function(q) {

//           if(q.data){

//             Memorandum.save($scope.data, function(e) {

//               if (e.ok) {

//                 $.gritter.add({

//                   title: 'Successful!',

//                   text:  e.msg,

//                 });

//                 window.location = '#/settings/admin-memorandum';

//               } else {

//                 $.gritter.add({

//                   title: 'Warning!',

//                   text:  e.msg,

//                 });

//               }

//             });

//           }else{

//             $.gritter.add({

//               title: 'Warning!',

//               text:  'Please apply for Honorable Dismissal to proceed.',

//             });

//           }

//         });

//       }else{

//         Memorandum.save($scope.data, function(e) {

//           if (e.ok) {

//             $.gritter.add({

//               title: 'Successful!',

//               text:  e.msg,

//             });

//             window.location = '#/settings/admin-memorandum';

//           } else {

//             $.gritter.add({

//               title: 'Warning!',

//               text:  e.msg,

//             });

//           }

//         });

//       }

//     }  

//   }

// });

// app.controller('AdminTransfereeViewController', function($scope, $routeParams, memorandumm) {

//   $scope.id = $routeParams.id;

//   $scope.data = {};

//   // load 

//   $scope.load = function() {

//     Memorandum.get({ id: $scope.id }, function(e) {

//       $scope.data = e.data;

//       $scope.transfereeImage = e.transfereeImage;

//     });

//   }

//   $scope.load();  

//   // $scope.approve = function(data){

//   //   bootbox.confirm('Are you sure you want to memorandum?', function(e){

//   //     if(e) {

//   //       Memorandum.get({id:data.id}, function(e){

//   //         if(e.ok){

//   //           $scope.load();

//   //           $.gritter.add({

//   //             title: 'Successful!',

//   //             text: e.msg

//   //           });

//   //         }

//   //         window.location = "#/settings/memorandum";

//   //       });

//   //     }

//   //   });

//   // }

//   // $scope.disapprove = function(data){  

//   //   bootbox.confirm('Are you sure you want to disapprove application?', function(b){

//   //     if(b) {

//   //       bootbox.prompt('REASON ?', function(result){

//   //         if(result){

//   //           $scope.data = {

//   //             explanation : result

//   //           };

//   //           StudentApplicationDisapproved.update({id:data.id},$scope.data, function(e){

//   //             if(e.ok){

//   //               $.gritter.add({

//   //                 title : 'Successful!',

//   //                 text: e.msg

//   //               });

//   //               $scope.load();

//   //               window.location = "#/settings/student-application";

//   //             }

//   //           });

//   //         }

//   //       });

//   //     }

//   //   });

//   // }

//   // remove 
//   $scope.remove = function(data) {

//     bootbox.confirm('Are you sure you want to remove memorandum?', function(c) {

//       if (c) {

//         Memorandum.remove({ id: data.id }, function(e) {

//           if (e.ok) {

//             $.gritter.add({

//               title: 'Successful!',

//               text:  e.msg,

//             });

//             window.location = "#/settings/admin-memorandum";

//           }

//         });

//       }

//     });

//   } 

// });

// app.controller('AdminTransfereeEditController', function($scope, $routeParams, Memorandum, memorandumImage, MemorandumRemoveImage, memorandumt) {
  
//   $scope.id = $routeParams.id;

//   $('#form').validationEngine('attach');

//  $('.datepicker').datepicker({

//     format:'mm/dd/yyyy',

//     autoclose: true,

//     todayHighlight: true,

//   });

//  $('.clockpicker').clockpicker({

//     donetext: 'Done',

//     twelvehour:  true,

//     placement: 'bottom'

//   })

//   $scope.data = {

//     Memorandum : {},

//     MemorandumImage : []

//   }

//   // load 

//   $scope.load = function() {

//     Memorandum.get({ id: $scope.id }, function(e) {

//       $scope.data = e.data;

//       $scope.transfereeImage = e.transfereeImage;

//     });

//   }

//   $scope.load();

//   $scope.searchStudent = function(options) {

//     options = typeof options !== 'undefined' ?  options : {};

//     options['code'] = 'search-student';

//     Select.query(options, function(e) {

//       $scope.students = e.data.result;

//       $scope.student = {};
      
//       // paginator

//       $scope.paginator  = e.data.paginator;

//       $scope.pages = paginator($scope.paginator, 10);

//       $("#searched-student-modal").modal('show');

//     });

//   }

//   $scope.selectedStudent = function(student) { 

//     $scope.student = {

//       id   : student.id,

//       code : student.code,

//       name : student.name,

//       first_name : student.first_name,

//       middle_name : student.middle_name,

//       last_name : student.last_name,

//     }; 

//   }

//   $scope.studentData = function(id) {

//     $scope.data.Memorandum.student_id = $scope.student.id;

//     $scope.data.Memorandum.student_no = $scope.student.code;

//     $scope.data.Memorandum.student_name = $scope.student.name;

//     $scope.data.Memorandum.first_name = $scope.student.first_name;

//     $scope.data.Memorandum.middle_name = $scope.student.middle_name;

//     $scope.data.Memorandum.last_name = $scope.student.last_name;

//   }

//   $scope.clearData = function(){

//     $scope.data.Memorandum.student_id = null;

//     $scope.data.Memorandum.student_no = null;

//     $scope.data.Memorandum.student_name = null;

//     $scope.data.Memorandum.first_name = null;

//     $scope.data.Memorandum.middle_name = null;

//     $scope.data.Memorandum.last_name = null;

//   }

//   $scope.addImage = function() {

//     var x = document.getElementById("upload_prev").innerHTML = " ";

//     $('#edit-upload-image').modal('show');

//   };

//   $scope.saveImages = function (files) {
    
//     $scope.MemorandumImage = [];

//     angular.forEach(files, function(file, e){

//       $scope.MemorandumImage.push({

//         images                : file.name,

//         transferee_id         : $scope.id,

//         url                   : file.url,

//         _file                 : file._file,

//         $$hashKey             : file.$$hashKey

//       });

//     });
    
//     MemorandumImage.save($scope.MemorandumImage, function(e) {

//       if (e.ok) {

//         $.gritter.add({

//           title: 'Success!',

//           text:  e.msg,

//         });

//         $('#edit-upload-image').modal('hide');

//         $scope.load();

//       } else {

//         $.gritter.add({

//           title: 'Warning!',

//           text:  e.msg,

//         });

//       }

//     });

//   }

//   $scope.removeImage = function(index,image) {

//     bootbox.confirm('Are you sure you want to delete ' + image.name + '?', function(b) {

//       if (b) {

//         TransfereeRemoveImage.delete({ id: image.id }, function(e) {

//           if (e.ok) {

//             $.gritter.add({

//               title: 'Successful!',

//               text: e.msg,

//             });

//             $scope.load();

//           }

//         });

//       }

//     });

//   }

//   $scope.save = function() {

//     valid = $("#form").validationEngine('validate');
    
//     if (valid) {

//       if($scope.data.Memorandum.type == 'Transfer Out'){

//         Select.get({code: 'check-honorable-dismissal', student_id : $scope.data.Memorandum.student_id}, function(q) {

//           if(q.data){

//             Memorandum.update({id:$scope.id}, $scope.data, function(e) {

//               if (e.ok) {

//                 $.gritter.add({

//                   title: 'Successful!',

//                   text:  e.msg,

//                 });

//                 window.location = '#/settings/admin-memorandum';

//               } else {

//                 $.gritter.add({

//                   title: 'Warning!',

//                   text:  e.msg,
                  
//                 });

//               }
              
//             }); 

//           }else{

//             $.gritter.add({

//               title: 'Warning!',

//               text:  'Please apply for Honorable Dismissal to proceed.',

//             });

//           }

//         });

//       }else{

//         Memorandum.update({id:$scope.id}, $scope.data, function(e) {

//           if (e.ok) {

//             $.gritter.add({

//               title: 'Successful!',

//               text:  e.msg,

//             });

//             window.location = '#/settings/admin-memorandum';

//           } else {

//             $.gritter.add({

//               title: 'Warning!',

//               text:  e.msg,
              
//             });

//           }
          
//         }); 

//       }

//     }  

//   }

// Memorandum);