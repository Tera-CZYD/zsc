app.controller('ApartelleController', function($scope, Apartelle) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Apartelle.query(options, function(e) {

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

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        Apartelle.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/list_apartelle?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/list_apartelle?print=1');

    }

  }

});

app.controller('ApartelleAddController', function($scope, Apartelle, Select) {

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

    Apartelle : {},

    ApartelleImage : []

  }

  $scope.newImages = [];

  $scope.files = [];

  $scope.images = [];

  Select.get({code: 'apartelle-code'}, function(e) {

    $scope.data.Apartelle.code = e.data;

  });

  $scope.resetImages = function () {

    $scope.newImages = [];

    $scope.data.ApartelleImage = [];

    $scope.files = [];

    $scope.images = [];

  } 

  $scope.saveImages = function (files) {

    $scope.images.push({ images  : $scope.files, });

    $scope.data.ApartelleImage.push({

      images  : $scope.files,

    });

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      $scope.data.Apartelle.price = number_format($scope.data.Apartelle.price, 2, '.', '');

      Apartelle.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/apartelle';

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

app.controller('ApartelleViewController', function($scope, $routeParams, Apartelle) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    Apartelle.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.apartelleImage = e.apartelleImage;

    });

  }

  $scope.load();  

  $scope.viewImage = function(image) {

    $scope.image = image;

    $('#view-image-modal').modal('show');
    
  }

  $scope.print = function(id){
  
    printTable(base + 'print/good_moral_certificiate/'+id);

  }

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        Apartelle.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/corporate-affairs/apartelle";

          }

        });

      }

    });

  } 

});

app.controller('ApartelleEditController', function($scope, $routeParams, Apartelle, Select, ApartelleImage, ApartelleRemoveImage) {
  
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

    Apartelle : {},

    ApartelleImage : []

  }

  // load 

  $scope.load = function() {

    Apartelle.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.apartelleImage = e.apartelleImage;

    });

  }

  $scope.load();

  $scope.addImage = function() {

    $('#edit-upload-image').modal('show');

  }

  $scope.saveImages = function (files) {

    $scope.selecteds  = [];

    $scope.newImages = [];

    $scope.ApartelleImage = [];

    $scope.files = [];

    $scope.images=[];

    $scope.images.push({ 

      images  : files 

    });

    $scope.selecteds.push($scope.files);

    angular.forEach(files, function(file, e){

      $scope.ApartelleImage.push({

        images  : file.name,

        apartelle_id : $scope.id,

        url : file.url,

        _file : file._file,

        $$hashKey : file.$$hashKey

      });

    });
      
    ApartelleImage.save($scope.ApartelleImage, function(e) {

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

        ApartelleRemoveImage.delete({ id: image.id }, function(e) {

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

      $scope.data.Apartelle.price = number_format($scope.data.Apartelle.price, 2, '.', '');

      Apartelle.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/apartelle';

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