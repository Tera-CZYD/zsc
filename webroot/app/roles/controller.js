app.controller('RoleController', function($scope, Role) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Role.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        //pagination

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.load();

  }

  $scope.load();

  $scope.searchy = function(search) {
    
    search = typeof search !== 'undefined' ?  search : '';

    $scope.searchTxts = search;

    if (search.length > 0){

      $scope.load({

        search    : search,

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate

      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate

      });
    
    }
  
  }

  $scope.advanceSearch = false;
  
  $scope.advance_search = function() {
  
    $scope.search = {};
 
    $scope.advanceSearch = false;
 
    $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
    $('.input-daterange').datepicker({format: 'mm/dd/yyyy'});

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {
  
    $scope.filter = false;
   
    $scope.advanceSearch = true;
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

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
    
      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');

      $scope.endDate = Date.parse(search.endDate).toString('yyyy-MM-dd');
    
    }

    $scope.load({

      date : $scope.dateToday,

      startDate : $scope.startDate,

      endDate : $scope.endDate

    });

    $('#advance-search-modal').modal('hide');
  
  } 

  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/generation_ipcr?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/generation_ipcr?print=1');

    }

  }

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.name +' ?', function(c) {

      if (c) {

        Role.remove({ id: data.id }, function(e) {

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

            $scope.load();

          }

        });

      }

    });

  } 

});

app.controller('RoleAddController', function($scope, Role, Select, RolePermission) {

  modalMaxHeight();

  $('#form').validationEngine('attach');

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    Role : {},

    RolePermission : []

  };

  Select.get({code: 'all-permissions'}, function(e) {

    $scope.permissions = e.data;

  });

  // add permission

  $scope.addPermission = function() {

    $('.savePermission').attr('disabled',false);

    $('#add-permission-modal').modal('show');

  }

  $scope.savePermission = function () {

    angular.forEach($scope.permissions, function(permission, e) {

      if(permission.selected && permission.selecteds != 1) {

        $scope.permissions[e].selecteds = 1;

        $scope.data.RolePermission.push({

          permission_id : permission.id,

          module  : permission.module,

          action  : permission.action

        });

      }

    });

    $('#add-permission-modal').modal('hide');

  }

  $scope.removePermission = function(index,data) {

    bootbox.confirm('Are you sure you want to delete your selected permission ?', function(c) {

      if (c) {

        $scope.$apply(function(){

          $scope.data.RolePermission.splice(index,1);

          angular.forEach($scope.permissions, function(select, s) {
            
            if (select.id == data.permission_id) {

              $scope.permissions[s].selected = false;

              $scope.permissions[s].selecteds = 0;

            }
        
          });

        });

      }

    });

  }

  $scope.selectall = function() {

    if ($scope.selectAll) {

      bool = true;

    } else {

      bool = false;

    }

    for (i in $scope.permissions) {

      $scope.permissions[i].selected = bool;

    }

  }

  $scope.selectalldelete = function() {

    if ($scope.selectAlldelete) {

      bool = true;

    } else {

      bool = false;

    }

    for (i in $scope.data.RolePermission) {

      $scope.data.RolePermission[i].selected = bool;

      $scope.permissions[i].selected = false;

      $scope.permissions[i].selecteds = 0;

    }

  }

  $scope.removeselected = function() {

    $('.deletePermission').attr('disabled',true);

    permissiondelete = [];

    for (i in $scope.data.RolePermission) {

      if ($scope.data.RolePermission[i].selected) {

        permissiondelete.push({

          permission_id: $scope.data.RolePermission[i].permission_id

        });

      }

    }

    if (permissiondelete.length <= 0) {

      $.gritter.add({

        title: 'Warning!',

        text: 'Please select permission to delete.',

      });

      $('.deletePermission').attr('disabled',false);

    } else {

      bootbox.confirm('Are you sure you want to delete your selected permission ?', function(c) {

        if (c) {

          for (a in permissiondelete) {

            for (b in $scope.data.RolePermission) {

              if(permissiondelete[a].permission_id == $scope.data.RolePermission[b].permission_id){

                $scope.$apply(function(){
                  
                  $scope.data.RolePermission.splice(b,1);

                  $scope.permissions[b].selected = false;

                  $scope.permissions[b].selecteds = 0;

                });

              }

            }

          }

          $('.deletePermission').attr('disabled',false);

        } else {

          $('.deletePermission').attr('disabled',false);

        }

      });

    }

  }

  $scope.filterPermission = function (search) {

    temp = [];

    if (search.module) {

      angular.forEach($scope.permissions, function(value, key) {

        if (value.module == search.module) {

          temp.push(value);

        }

      });

    } 

    else if (search.action) {

      angular.forEach($scope.permissions, function(value, key) {

        if (value.action == search.action) {

          temp.push(value);

        }

      });

    } 

    $scope.permissions = temp;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      $('#save').attr('disabled', true);

      Role.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/roles';

        } else {

          $('#save').attr('disabled', false);

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

      });


    }

  }

});

app.controller('RoleViewController', function($scope, Role, $routeParams) {

  $scope.data = {};

  $scope.id = $routeParams.id;

  // load 

  $scope.load = function() {

    Role.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      console.log($scope.data);

    });

  }

  $scope.load();

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        Role.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/roles";

          }

        });

      }

    });

  } 

  $scope.print = function(){

    printTable(base + 'print/print_ipcr/' + $scope.id);

  }

});

app.controller('RoleEditController', function($scope, Role, $routeParams, Select) {

  modalMaxHeight();
  
  $('#form').validationEngine('attach');

  $scope.id = $routeParams.id;

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    Role : {},

    RolePermission : []

  };

  // load 

  $scope.load = function() {

    Role.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.query({code: 'all-permissions'},function(e){

        $scope.permissions = e.data;

        if($scope.permissions.length > 0){

          $.each($scope.permissions,function(i,val){
            
            if($scope.data.RolePermission.length > 0){

              $.each($scope.data.RolePermission,function(is,vals){

                if(val.id == vals.permission_id){

                  $scope.permissions[i].selecteds = 1;

                }

              });

            }

          });

        }

      }); 

    });

  }

  $scope.load();

  // add permission

  $scope.addPermission = function() {

    $('.savePermission').attr('disabled',false);

    $('#add-permission-modal').modal('show');

  }

  $scope.savePermission = function () {

    angular.forEach($scope.permissions, function(permission, e) {

      if(permission.selected && permission.selecteds != 1) {

        $scope.permissions[e].selecteds = 1;

        $scope.data.RolePermission.push({

          permission_id : permission.id,

          module  : permission.module,

          action  : permission.action

        });

      }

    });

    $('#add-permission-modal').modal('hide');

  }

  $scope.removePermission = function(index,data) {

    bootbox.confirm('Are you sure you want to delete your selected permission ?', function(c) {

      if (c) {

        $scope.$apply(function(){

          $scope.data.RolePermission.splice(index,1);

          angular.forEach($scope.permissions, function(select, s) {
            
            if (select.id == data.permission_id) {

              $scope.permissions[s].selected = false;

              $scope.permissions[s].selecteds = 0;

            }
        
          });

        });

      }

    });

  }

  $scope.selectall = function() {

    if ($scope.selectAll) {

      bool = true;

    } else {

      bool = false;

    }

    for (i in $scope.permissions) {

      $scope.permissions[i].selected = bool;

    }

  }

  $scope.selectalldelete = function() {

    if ($scope.selectAlldelete) {

      bool = true;

    } else {

      bool = false;

    }

    for (i in $scope.data.RolePermission) {

      $scope.data.RolePermission[i].selected = bool;

      $scope.permissions[i].selected = false;

      $scope.permissions[i].selecteds = 0;

    }

  }

  $scope.removeselected = function() {

    $('.deletePermission').attr('disabled',true);

    permissiondelete = [];

    for (i in $scope.data.RolePermission) {

      if ($scope.data.RolePermission[i].selected) {

        permissiondelete.push({

          permission_id: $scope.data.RolePermission[i].permission_id

        });

      }

    }

    if (permissiondelete.length <= 0) {

      $.gritter.add({

        title: 'Warning!',

        text: 'Please select permission to delete.',

      });

      $('.deletePermission').attr('disabled',false);

    } else {

      bootbox.confirm('Are you sure you want to delete your selected permission ?', function(c) {

        if (c) {

          for (a in permissiondelete) {

            for (b in $scope.data.RolePermission) {

              if(permissiondelete[a].permission_id == $scope.data.RolePermission[b].permission_id){

                $scope.$apply(function(){
                  
                  $scope.data.RolePermission.splice(b,1);

                  $scope.permissions[b].selected = false;

                  $scope.permissions[b].selecteds = 0;

                });

              }

            }

          }

          $('.deletePermission').attr('disabled',false);

        } else {

          $('.deletePermission').attr('disabled',false);

        }

      });

    }

  }

  $scope.filterPermission = function (search) {

    temp = [];

    if (search.module) {

      angular.forEach($scope.permissions, function(value, key) {

        if (value.module == search.module) {

          temp.push(value);

        }

      });

    } 

    else if (search.action) {

      angular.forEach($scope.permissions, function(value, key) {

        if (value.action == search.action) {

          temp.push(value);

        }

      });

    } 

    $scope.permissions = temp;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      $('#save').attr('disabled', true);

      Role.update({ id : $scope.id }, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/roles';

        } else {

          $('#save').attr('disabled', false);

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

      });

    }

  }

}); 
