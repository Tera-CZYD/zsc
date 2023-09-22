app.controller('UsersController', function($scope, User) {
  
  $scope.user = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['User'] = 'user';

    User.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.paginator  = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.employee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['User'] = 'employee';

    User.query(options, function(e) {

      if (e.ok) {

        $scope.employee_data = e.data;

        $scope.employee_paginator  = e.paginator;

        $scope.employee_pages = paginator($scope.employee_paginator, 5);

      }

    });

  }

  $scope.student = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['User'] = 'student';

    User.query(options, function(e) {

      if (e.ok) {

        $scope.student_data = e.data;

        $scope.student_paginator  = e.paginator;

        $scope.student_pages = paginator($scope.student_paginator, 5);

      }

    });

  }

  $scope.dean = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['User'] = 'dean';

    User.query(options, function(e) {

      if (e.ok) {

        $scope.dean_data = e.data;

        $scope.dean_paginator  = e.paginator;

        $scope.dean_pages = paginator($scope.dean_paginator, 5);

      }

    });

  }

  $scope.vice = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['User'] = 'vice';

    User.query(options, function(e) {

      if (e.ok) {

        $scope.vice_data = e.data;

        $scope.vice_paginator  = e.paginator;

        $scope.vice_pages = paginator($scope.vice_paginator, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.user(options);

    $scope.employee(options);

    $scope.student(options);

    $scope.dean(options);

    $scope.vice(options);

  }

  $scope.load();
   
  $scope.searchy = function(search) {
    
    search = typeof search !== 'undefined' ?  search : '';

    $scope.searchTxts = search;

    if (search.length > 0){

      $scope.load({

        search    : search

      });

    }else{

      $scope.load();
    
    }
  
  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.name +' ?', function(c) {

      if (c) {

        User.remove({ id: data.id }, function(e) {

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
  
});

app.controller('UsersAddController', function($scope, User,$routeParams, Select) {

  $('#form').validationEngine('attach');

  Select.get({ code: 'user-logs-users'}, function(e) {});

  Select.get({ code: 'offices' },function(e){

    $scope.offices = e.data;

  });

  $scope.bool = [{ id: true, value: 'Yes' }, { id: false, value: 'No' }];

  $scope.data = {

    User: {

      image: null

    },

  };

  // console.log($scope);

  $scope.url = base; 

  $scope.$on("fileSelected", function(event, args) {

    $scope.$apply(function() {

      $scope.data.User.image = args;

      d($scope.data.User.image);

    });

  });

  // get session

  Select.get({code: 'session'}, function(e){

    $scope.roleId = e.data.roleId;

  });

  // get branches

  Select.get({code: 'branch'}, function(e){

    $scope.branches = e.data;

  });

  // get roles

  Select.get({code: 'roles'}, function(e){

    $scope.roles = e.data;

  });

  $scope.getEmployee = function(id){

    if($scope.roles.length > 0){

      $.each($scope.roles,function(i,val){

        if(id == val.id){

          $scope.role = val.value;

        }

      });

    }

  }

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selected = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.code + ' - ' + employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.User.employeeId = $scope.employee.id;

    $scope.data.User.employee_name = $scope.employee.name;

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

      name : student.code + ' - ' + student.name

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.User.studentId = $scope.student.id;

    $scope.data.User.student_name = $scope.student.name;

  }

  $scope.save = function () {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      if ($scope.data.User.password != $scope.confirmPassword) {

        $.gritter.add({

          title: 'Warning!',

          text:  'Password does not match.',

        });

      } else {

        User.save($scope.data, function(e) {

          console.log(e);

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:   e.msg

            });

            window.location = '#/users';

          } else {

            $.gritter.add({

              title: 'Warning!',

              text: e.msg

            });

          }

        });

      }

    }

  }

});

app.controller('UsersViewController', function($scope, $routeParams, DeleteSelected, User, Select, UserPermission,UserPermissionDelete) {

  modalMaxHeight();

  $scope.id = $routeParams.id;

  $scope.data = {};

  $scope.data.PermissionSelection = [];

  // $scope.data.PermissionSubModules = [];

  $scope.data.UserPermission = [];

  // load 

  $scope.load = function() {

    User.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.permissions_temp = $scope.data.PermissionSelection;

    });

  }

  $scope.load();

  $scope.removeselected = function() {

    $('.deletePermission').attr('disabled',true);

    permissiondelete = [];

    for (i in $scope.data.UserPermission) {

      if ($scope.data.UserPermission[i].selected) {

        permissiondelete.push({

          user_id:       $scope.id,

          permission_id: $scope.data.UserPermission[i].id

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

          DeleteSelected.save({ permissiondelete : permissiondelete }, function(e) {

            $('.deletePermission').attr('disabled',false);

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text: e.msg

              });

              $scope.load();

            } else {

              $.gritter.add({

                title: 'Warning!',

                text: e.msg

              });

            }

          });

        } else {

          $('.deletePermission').attr('disabled',false);

        }

      });

    }

  }

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.name +' ?', function(c) {

      if (c) {

        User.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/users";

          }

        });

      }

    });

  } 

  // add permission

  $scope.addPermission = function() {

    Select.get({ code: 'get-all-subModules' },function(e){


      $scope.sub_modules = e.data;

    });

    $scope.default = $scope.data.PermissionSelection;

    $('.savePermission').attr('disabled',false);

    $('#add-permission-modal').modal('show');

  }

  $scope.selectall = function() {

    if ($scope.selectAll) {

      bool = true;

    } else {

      bool = false;

    }

    for (i in $scope.data.PermissionSelection) {

      $scope.data.PermissionSelection[i].selected = bool;

    }

  }

  $scope.selectalldelete = function() {

    if ($scope.selectAlldelete) {

      bool = true;

    } else {

      bool = false;

    }

    for (i in $scope.data.UserPermission) {

      $scope.data.UserPermission[i].selected = bool;

    }

  }

  $scope.savePermission = function() {

    $('.savePermission').attr('disabled',true);

    permissions = [];

    for (i in $scope.data.PermissionSelection) {

      if ($scope.data.PermissionSelection[i].selected) {

        permissions.push({

          user_id:       $scope.id,

          permission_id: $scope.data.PermissionSelection[i].id

        });

      }

    }

    if (permissions.length <= 0) {

      $.gritter.add({

        title: 'Warning!',

        text: 'Please select permission to save.',

      });

      $('.savePermission').attr('disabled',false);

    } else {

      $('.savePermission').attr('disabled',true);

      UserPermission.save({ UserPermission: permissions }, function(e) {

        $('.savePermission').attr('disabled',true);

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text: e.msg

          });

          $scope.load();

          $('#add-permission-modal').modal('hide');

          window.location = '#/users/view/'+$scope.id;

        } else {

          $.gritter.add({

            title: 'Warning!',

            text: e.msg

          });

        }

      });

    }

  }

  // remove user

  $scope.removePermission = function (permission) {

    bootbox.confirm('Are you sure you want to delete "' + permission.module + '-' + permission.action + '"?', function(c) {

      if (c) {

        UserPermissionDelete.remove({ id:permission.id }, function(e){

          if(e.ok){

            $.gritter.add({ title: 'Successful!', text: e.msg });

            $scope.load();

          }

        }); 

      }

    }); 

  };

  $scope.clearSearch = function () {

    $scope.data.PermissionSelection = $scope.default

    $scope.search.module = null;

    $scope.search.action = null;

  }

  $scope.filterPermission = function (search) {

    temp = [];

    if (search.module) {

      angular.forEach($scope.permissions_temp, function(value, key) {

        let text = String(value.module);

        let searchString = String(search.module);

        if (text.includes(searchString)) {

          temp.push(value);

        }

      });

    } 

    else if (search.action) {

      angular.forEach($scope.permissions_temp, function(value, key) {

        let text = String(value.action);
        
        let searchString = String(search.action);

        if (text.includes(searchString)) {

          temp.push(value);

        }

      });

    } 

    $scope.data.PermissionSelection = temp;

  }

});

app.controller('UsersEditController', function($scope, $routeParams, User, Select) {

  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $scope.data = {

    User: {

      image: null

    },

  };

  $scope.bool = [{ id: true, value: 'Yes' }, { id: false, value: 'No' }];

  Select.get({ code: 'user-logs-users-edit'}, function(e) {});

  Select.get({ code: 'offices' },function(e){

    $scope.offices = e.data;

  });

  // get session

  // Select.get({code: 'session'}, function(e){

  //   $scope.roleId = e.data.roleId;

  // });

  // get branches

  Select.get({code: 'branch'}, function(e){

    $scope.branches = e.data;

  });

  // get roles

  Select.get({code: 'roles'}, function(e){

    $scope.roles = e.data;

  });  

  // load 

  $scope.load = function() {

    User.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.userImage = e.data.User.image;

      $scope.data.User.password = '';

      $scope.confirmPassword = '';   

      // $scope.role = e.data.Role.name;

    });

  }

  $scope.load();

  $scope.getEmployee = function(id){

    if($scope.roles.length > 0){

      $.each($scope.roles,function(i,val){

        if(id == val.id){

          $scope.role = val.value;

        }

      });

    }

  }

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selected = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.code + ' - ' + employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.User.employeeId = $scope.employee.id;

    $scope.data.User.employee_name = $scope.employee.name;

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

      name : student.code + ' - ' + student.name

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.User.studentId = $scope.student.id;

    $scope.data.User.student_name = $scope.student.name;

  }

  $scope.$on("fileSelected", function(event, args) {

    $scope.$apply(function() {

      $scope.data.User.image = args;

      $scope.data.User.image_name = null;

    });

  });

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      if ($scope.data.User.password != $scope.confirmPassword) {

        $.gritter.add({

          title: 'Warning!',

          text: 'Password does not match'

        });

      } else {

        User.update({id:$scope.id},$scope.data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            if(e.type == 'employee'){
              
              window.location = '#/news-and-events';

            }else if(e.type == 'external'){
              
              window.location = '#/profile';

            }else{

              window.location = '#/users';

            }

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