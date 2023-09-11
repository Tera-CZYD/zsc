app.controller('SettingController', function($scope, Setting,Select){

  // load business

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Setting.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.user = e.user;

        // paginator

        $scope.paginator  = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load();

  $scope.updateValue = function(data) {

    Setting.update({id:data.id}, data, function(e){

      if(e.response){

        $.gritter.add({

          title: 'Successfully updated!',

          text: e.message

        });

        $scope.load();

      }

    });

  } 

  $scope.log = function(){

    Select.get({ code: 'user-logs-info'}, function(e) {});

  }
  

});    
  
app.controller('SettingAddController', function($scope, Setting){

  $("#form").validationEngine('attach');

  Setting.query(function(e) {

    if (e.ok) {

      $scope.settings = e.datas;

    }

  });     

  $scope.save = function(){

    valid = $("#form").validationEngine('validate');

    console.log(valid);

    if(valid){

      BranchSetting.save($scope.settings, function(e){

        if(e.response){

          console.log(e);

          $.gritter.add({ title: 'Successful!', text: e.message });

        }

      });

    }

  }

});

app.controller('SettingEditController', function($scope, $routeParams, Setting){

  $("#form").validationEngine('attach');

  Setting.get({id:$routeParams.id}, function(e){

    $scope.data = e.result;

  });

  $scope.update = function(){

    valid = $("#form").validationEngine('validate');

    console.log(valid);

    if(valid){

      Setting.save({id:$routeParams.id}, $scope.data, function(e){

        if(e.response){

          console.log(e);

          $.gritter.add({ title: 'Successful!', text: e.message });

          window.location = '#/settings';  

        }

      });

    }

  }

});