app.controller('AssessmentController', function($scope, $window, Assessment) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.scrollToTop = function() {

    $window.scrollTo(0, 0);

  };

    $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};  

    options['status'] = 0;

    // options['per_student'] = 1;

    Assessment.query(options, function(e) {

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

    // options['per_student'] = 1;

    Assessment.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approved(options);


  }

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

        Assessment.remove({ id: data.id }, function(e) {
         
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

      printTable(base + 'print/assessment?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/assessment?print=1');

    }
  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/assessment?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/assessment?print=1');

    }

  }

});


app.controller('AssessmentViewController', function($scope, $routeParams, Select, Assessment, AssessmentApprove) {

  $('#form').validationEngine('attach');

  $scope.id = $routeParams.id;

  $scope.data = {

    Assessment : {}

  };

  // load

  $scope.load = function() {

    Assessment.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

    Select.get({ code:'scholarship-name-list' }, function(e) {

      $scope.scholarships = e.data;

    });

  }

  $scope.load();  


  $scope.compute = function() {

    amount = 0;

    if ( $scope.data.Assessment.length > 0) {

      $.each($scope.data.Assessment, function(key,val) {

        amount += parseFloat(val[account.amount]);

      });

    }

    $scope.data.Assessment.total = amount;

  }

  //   $scope.approve = function(data){

  //       $scope.bootboxMessage = '<div class="form-group">' +
  //     '<label for="dropdown">Select an option:</label>' +
  //     '<select id="dropdown" class="form-control" ng-model="data.Assessment.scholarship" ' +
  //     'ng-options="opt.id as opt.value for opt in scholarships">' +
  //     '</select>' +
  //     '</div>';

  //     bootbox.dialog({

  //       title: "Select Scholarship Name",

  //       message: $scope.bootboxMessage,

  //      buttons: {

  //       confirm: {

  //         label: "OK",

  //         className:'btn btn-success',

  //         callback: function () {

  //           console.log("Selected Option:" + $scope.data.Assessment.code);

  //         }

  //       },

  //       cancel:{

  //         label: "Cancel",

  //         className: "btn btn-danger"

  //       }

  //      },

  //      onEscape: function () {  

  //      }          

  //     });

  //   // bootbox.confirm('Are you sure you want to approve assessment ' +  data.code + '?', function(e){

  //   //   if(e) {

  //   //     AssessmentApprove.get({id:data.id}, function(e){

  //   //       if(e.ok){

  //   //         $.gritter.add({

  //   //           title: 'Successful!',

  //   //           text: 'Assessment has been approved.'

  //   //         });

  //   //       }

  //   //       window.location = "#/cashier/assessment";

  //   //     });

  //   //   }

  //   // });

  // }

  $scope.approve = function (data){

    $('#scholarship').modal('show');

    $scope.scholarship = function (data){

        const scholarship_name = $scope.scholarships.filter(function (scholarship) {
            return scholarship.id == data.scholarship_id;
        });


          bootbox.confirm('Are you sure you want to approve assessment ' +  data.code + '?', function(e){

          if(e) {

            AssessmentApprove.get({id:data.id, scholarship_name : scholarship_name[0].value, scholarship_id : data.scholarship_id}, function(e){

              if(e.ok){

                $.gritter.add({

                  title: 'Successful!',

                  text: 'Assessment has been approved.'

                });

              }

              window.location = "#/cashier/assessment";

            });

          }

        });

    }


  }

 
  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        Assessment.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = '#/cashier/assessment';

          }

        });

      }

    });

  } 

});

