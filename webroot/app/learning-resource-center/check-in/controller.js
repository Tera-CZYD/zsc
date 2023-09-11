app.controller('CheckInController', function($scope, CheckIn) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    CheckIn.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

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

    bootbox.confirm('Are you sure you want to delete check in of ' + data.library_id_number +' ?', function(c) {

      if (c) {

        CheckIn.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            $scope.load();

          } else {

            $.gritter.add({

              title: 'Warning!',

              text: e.msg

            });

          }

        });

      }

    });

  }

  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/check_in?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/check_in?print=1');

    }

  }

});

app.controller('CheckInAddController', function($scope, $routeParams, CheckIn, Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.id = $routeParams.id;

  $scope.data = {

    CheckIn : {},

    CheckInSub : [],

  };

  $scope.searchMember = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-learning-resource-member';

    Select.query(options, function(e) {

      $scope.learning_resource_members = e.data.result;

      $scope.learning_resource_member = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-learning-resource-member-modal").modal('show');

    });

  }

  //show selected student 

  $scope.selectedMember = function(learning_resource_member) { 

    $scope.learning_resource_member = {

      id                 : learning_resource_member.id,

      library_id_number  : learning_resource_member.library_id_number,

      member_name        : learning_resource_member.member_name,

      email              : learning_resource_member.email, 

    }; 

  }

  //get selected student data

  $scope.memberData = function(id) {

    $scope.data.CheckIn.learning_resource_member_id = $scope.learning_resource_member.id;

    $scope.data.CheckIn.member_name = $scope.learning_resource_member.member_name;

    $scope.data.CheckIn.library_id_number = $scope.learning_resource_member.library_id_number;

    $scope.data.CheckIn.email = $scope.learning_resource_member.email;

    Select.get({ code: 'borrowed-books-list', learning_resource_member_id : $scope.learning_resource_member.id },function(e){

      $scope.datax = e.data;

    });

  }

  //select all items

  $scope.selectall = function() {

    if($scope.selectAll) {

      bool = true;

    } else {

      bool = false;

    }

    for ( i in $scope.datax) {

      $scope.datax[i].selected = bool;

    }

  }

  //check out function

  $scope.checkIn = function() {

    $('#return_date').validationEngine('attach');

    $scope.datas = {};

    $scope.checkin_type = 'single';

    $('#add-returnDate-modal').modal('show');

  }

  //check out all function

  $scope.checkInAll = function() {

    $('#return_date').validationEngine('attach');

    $scope.datas = {};

    $scope.checkin_type = 'all';

    $('#add-returnDate-modal').modal('show');

  }

  $scope.saveCheckIn = function(datas) {

    valid = $('#return_date').validationEngine('validate');

    if (valid) {

      $scope.data.CheckIn.date_returned = datas.date_returned;

      $('#add-returnDate-modal').modal('hide');

      for(i in $scope.datax) {

        if($scope.checkin_type == 'single'){

          if($scope.datax[i].selected) {

            $scope.data.CheckInSub.push({

              inventory_bibliography_id : $scope.datax[i].inventory_bibliography_id,

              barcode_no                : $scope.datax[i].barcode_no,

              check_out_id              : $scope.datax[i].check_out_id,

              check_out_sub_id          : $scope.datax[i].id,

              title                     : $scope.datax[i].title,

              description               : $scope.datax[i].description,

              author                    : $scope.datax[i].author,

              check_out_dueback         : $scope.datax[i].dueback,

            });
            
          }

        }else if($scope.checkin_type == 'all'){

          $scope.data.CheckInSub.push({

            inventory_bibliography_id : $scope.datax[i].inventory_bibliography_id,

            barcode_no                : $scope.datax[i].barcode_no,

            check_out_id              : $scope.datax[i].check_out_id,

            check_out_sub_id          : $scope.datax[i].id,

            title                     : $scope.datax[i].title,

            description               : $scope.datax[i].description,

            author                    : $scope.datax[i].author,

            check_out_dueback         : $scope.datax[i].dueback,

          });

        } 

      }

      bootbox.confirm('Are you sure you want to check-in this selected item/s ? ', function(c) {

        if(c) {

          CheckIn.save($scope.data, function (e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text: e.msg

              });

              window.location = '#/learning-resource-center/check-in';

            } else {

              $.gritter.add({

                title: 'Warning!',

                text: e.msg

              });

            }

          });

        }      

      });

    }

  }

});

app.controller('CheckInViewController', function($scope, $routeParams, CheckIn) {

  $scope.id = $routeParams.id;

  $scope.load = function() {

    CheckIn.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load(); 

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove check in of ' + data.library_id_number + '? ' , function(c) {

      if(c) {

        CheckIn.remove({ id : $scope.datas[0].id }, function(e) {

          if(e.ok) {

            $.gritter.add({

              title: 'Successful',

              text: e.msg

            });

            window.location = '#/learning-resource-center/check-in';

          } else {

            $.gritter.add({

              title: 'Warning!',

              text: e.msg

            });      

          }

        });

      }

    });   

  } 

});

app.controller('CheckInEditController', function($scope, $routeParams, CheckIn, Select) {
  
  $scope.id = $routeParams.id;

  $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    CheckIn : {},

    CheckInSub : [],

  };

  // load 

  $scope.load = function() {

    CheckIn.get({ id: $scope.id }, function(e) {

      if(e.ok) {

        $scope.data = e.data;

        Select.get({ code: 'borrowed-books-list', id : $scope.id, learning_resource_member_id : $scope.data.CheckIn.learning_resource_member_id },function(e){

          $scope.datax = e.data;

        });

      }

    });

  }

  $scope.load();

  $scope.selectall = function() {

    if($scope.selectAll) {

      bool = true;

    } else {

      bool = false;

    }

    for ( i in $scope.datax) {

      $scope.datax[i].selected = bool;

    }

  }

  //check out function

  $scope.checkIn = function() {

    $('#return_date').validationEngine('attach');

    $scope.datas = {};

    $scope.data.CheckInSub = [];

    $scope.checkin_type = 'single';

    $('#add-returnDate-modal').modal('show');

  }

  //check out all function

  $scope.checkInAll = function() {

    $('#return_date').validationEngine('attach');

    $scope.datas = {};

    $scope.data.CheckInSub = [];

    $scope.checkin_type = 'all';

    $('#add-returnDate-modal').modal('show');

  }

  $scope.updateCheckIn = function(datas) {

    valid = $('#return_date').validationEngine('validate');

    if (valid) {

      $scope.data.CheckIn.date_returned = datas.date_returned;

      $('#add-returnDate-modal').modal('hide');

      for(i in $scope.datax) {

        if($scope.checkin_type == 'single'){

          if($scope.datax[i].selected) {

            $scope.data.CheckInSub.push({

              inventory_bibliography_id : $scope.datax[i].inventory_bibliography_id,

              barcode_no                : $scope.datax[i].barcode_no,

              check_out_id              : $scope.datax[i].check_out_id,

              check_out_sub_id          : $scope.datax[i].id,

              title                     : $scope.datax[i].title,

              description               : $scope.datax[i].description,

              author                    : $scope.datax[i].author,

              check_out_dueback         : $scope.datax[i].dueback,

            });
            
          }

        }else if($scope.checkin_type == 'all'){

          $scope.data.CheckInSub.push({

            inventory_bibliography_id : $scope.datax[i].inventory_bibliography_id,

            barcode_no                : $scope.datax[i].barcode_no,

            check_out_id              : $scope.datax[i].check_out_id,

            check_out_sub_id          : $scope.datax[i].id,

            title                     : $scope.datax[i].title,

            description               : $scope.datax[i].description,

            author                    : $scope.datax[i].author,

            check_out_dueback         : $scope.datax[i].dueback,

          });

        } 

      }

      bootbox.confirm('Are you sure you want to check-in this selected item/s ? ', function(c) {

        if(c) {

          CheckIn.update({id:$scope.id}, $scope.data, function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text: e.msg

              });

              window.location = '#/learning-resource-center/check-in';

            } else {

              $.gritter.add({

                title: 'Warning!',

                text: e.msg

              });

            }

          });

        }      

      });

    }

  }

});