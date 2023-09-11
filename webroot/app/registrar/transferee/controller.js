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

  // $scope.printApproved = function(){

  //   if ($scope.conditionsPrintApproved !== '') {
    
  //     printTable(base + 'print/student_application?print=1' + $scope.conditionsPrintApproved);

  //   }else{

  //     printTable(base + 'print/student_application?print=1');

  //   }

  // }

  // $scope.printDisapproved = function(){

  //   if ($scope.conditionsPrintDisapproved !== '') {
    
  //     printTable(base + 'print/student_application?print=1' + $scope.conditionsPrintDisapproved);

  //   }else{

  //     printTable(base + 'print/student_application?print=1');

  //   }

  // }

});

app.controller('TransfereeAddController', function($scope, Transferee, Select) {

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

      Transferee.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/admission/transferee';

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

  // $scope.approve = function(data){

  //   bootbox.confirm('Are you sure you want to transferee?', function(e){

  //     if(e) {

  //       Transferee.get({id:data.id}, function(e){

  //         if(e.ok){

  //           $scope.load();

  //           $.gritter.add({

  //             title: 'Successful!',

  //             text: e.msg

  //           });

  //         }

  //         window.location = "#/admission/transferee";

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

  //               window.location = "#/admission/student-application";

  //             }

  //           });

  //         }

  //       });

  //     }

  //   });

  // }

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

      // console.log($scope.data);

      Transferee.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/admission/transferee';

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

app.controller('AdminTransfereeController', function($scope, Transferee) {

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

  // $scope.printApproved = function(){

  //   if ($scope.conditionsPrintApproved !== '') {
    
  //     printTable(base + 'print/student_application?print=1' + $scope.conditionsPrintApproved);

  //   }else{

  //     printTable(base + 'print/student_application?print=1');

  //   }

  // }

  // $scope.printDisapproved = function(){

  //   if ($scope.conditionsPrintDisapproved !== '') {
    
  //     printTable(base + 'print/student_application?print=1' + $scope.conditionsPrintDisapproved);

  //   }else{

  //     printTable(base + 'print/student_application?print=1');

  //   }

  // }

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

      Transferee.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/admission/transferee';

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

  // $scope.approve = function(data){

  //   bootbox.confirm('Are you sure you want to transferee?', function(e){

  //     if(e) {

  //       Transferee.get({id:data.id}, function(e){

  //         if(e.ok){

  //           $scope.load();

  //           $.gritter.add({

  //             title: 'Successful!',

  //             text: e.msg

  //           });

  //         }

  //         window.location = "#/admission/transferee";

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

  //               window.location = "#/admission/student-application";

  //             }

  //           });

  //         }

  //       });

  //     }

  //   });

  // }

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

      // console.log($scope.data);

      Transferee.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/admission/transferee';

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