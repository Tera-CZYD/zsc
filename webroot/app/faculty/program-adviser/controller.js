app.controller('ProgramAdviserController', function($scope, ProgramAdviser,ProgramAdviserEnlist, Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  Select.get({code: 'section-list'}, function(e) {

    $scope.section = e.data;

  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  $scope.forEnlistment = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    // options['per_student'] = 1;

    options['status'] = 0;

    ProgramAdviser.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        // paginator

        $scope.paginator  = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.enlisted = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    // options['per_student'] = 1;

    options['status'] = 1;

    ProgramAdviser.query(options, function(e) {

      if (e.ok) {

        $scope.datasEnlisted = e.data;

        $scope.conditionsPrintEnlisted = e.conditionsPrint;

        // paginator

        $scope.paginatorEnlisted  = e.paginator;

        $scope.pagesEnlisted = paginator($scope.paginatorEnlisted, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.forEnlistment(options);

    $scope.enlisted(options);

  }

  $scope.load();

  $scope.getData = function(year_term_id){

    $scope.year_term_id = year_term_id;

    $scope.load({

      year_term_id: $scope.year_term_id

    });

  }

  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';

    $scope.year_term_id = null;

    $scope.load();

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search: search,

        year_term_id: $scope.year_term_id

      });

    } else {

      $scope.load({

        year_term_id: $scope.year_term_id

      });
    
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

  $scope.selectall = function() {

    if($scope.selectAll) {

      bool = true;

    } else {

      bool = false;

    }

    for ( i in $scope.datas) {

      $scope.datas[i].check = bool;

    }

  }

  $scope.getSection = function(index,data,id){

    if(data.length > 0){

      $.each(data, function(i,val){

        if(val.id == id){

          $scope.datas[index].selected_section_id = val.section_id;

          $scope.datas[index].selected_section = val.section;

        }

      });

    }

  }

  $scope.enlist = function(data){

    bootbox.confirm('Are you sure you want to enlist student number ' + data.student_no + ' ?', function(c) {

      if (c) {

        ProgramAdviserEnlist.save(data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            $scope.load({

              year_term_id: $scope.year_term_id

            });

          }

        });

      }

    });

  }

  $scope.printForEnlistment = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/program_adviser?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/program_adviser?print=1');

    }

  }

  $scope.printEnlisted = function(){

    date = "";
    
    if ($scope.conditionsPrintEnlisted !== '') {
    

      printTable(base + 'print/program_adviser?print=1' + $scope.conditionsPrintEnlisted);

    }else{

      printTable(base + 'print/program_adviser?print=1');

    }

  }

});

app.controller('ProgramAdviserViewController', function($scope, $routeParams, DeleteSelected, ProgramAdviser, ProgramAdviserApproved, ProgramAdviserDisapproved, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    ProgramAdviser.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.approve = function(data){

    bootbox.confirm('Are you sure you want to approve this adviser ' +  data.code + '?', function(e){

      if(e) {

        ProgramAdviserApproved.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Program Adviser has been approved.'

            });

          }

          window.location = "#/faculty/program-adviser";

        });

      }

    });

  }

  $scope.disapprove = function(data){  

    bootbox.confirm('Are you sure you want to disapprove this adviser ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            ProgramAdviserDisapproved.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Program Adviser has been disapproved.'

                });

                $scope.load();

                window.location = "#/faculty/program-adviser";

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

        ProgramAdviser.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/faculty/program-adviser";

          }

        });

      }

    });

  } 

});

