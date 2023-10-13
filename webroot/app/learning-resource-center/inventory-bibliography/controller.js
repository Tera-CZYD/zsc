app.controller('InventoryBibliographyController', function($scope,Select, $window, InventoryBibliography, Bibliography) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    InventoryBibliography.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

       }

    });

  }

  $scope.quantity = function() {

    var a = document.getElementById("table1");

    var rows = a.rows.length;

    document.getElementById("quantity").value = rows;

    alert(rows);

  }

  Select.get({ code: 'material-type-list' },function(e) {

    $scope.material_types = e.data;
      
  });

  Select.get({ code: 'collection-type-list' },function(e) {

    $scope.collection_types = e.data;
      
  });

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

    $scope.material_types = null;

    $scope.collection_types = null;

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
    
    }else if ($scope.selectedFilter == 'materialType') {

      $scope.material_type =  search.material_type;

    }else if ($scope.selectedFilter == 'collectionType') {

      $scope.collection_type =  search.collection_type;

    }

    $scope.load({

      date         : $scope.dateToday,

      startDate    : $scope.startDate,

      endDate      : $scope.endDate,

      material_type     : $scope.material_type,

      collection_type     : $scope.collection_type,

    });
  
  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        InventoryBibliography.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/inventory_bibliography?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/inventory_bibliography?print=1');

    }

  }

  $scope.export = function(){

    if ($scope.conditionsPrint !== undefined && $scope.conditionsPrint !== ''){

      printTable(base + 'print/export_inventory_bibliography?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/export_inventory_bibliography?print=1');

    }

  }

});

app.controller('InventoryBibliographyViewController', function($scope, $routeParams, InventoryBibliography, InventoryBibliographyManual, InventoryBibliographyManualDelete) {

  $scope.id = $routeParams.id;

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

  $scope.data = {

    Bibliography : {

      date : $scope.today

    },

    InventoryBibliography : []

  }

  // load 

  $scope.load = function() {

    InventoryBibliography.query({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  //add inventory bibliography

  $scope.addInventoryBibliography = function() {

    $('#add_inventory_bibliography').validationEngine('attach');

    $scope.adata = {};

    $('#add-inventory-bibliography-modal').modal('show');

  }

  //save inventory bibliography

  $scope.saveInventoryBibliography = function(data) {

    valid = $('#add_inventory_bibliography').validationEngine('validate');

    $scope.adata.bibliography_id = $scope.id;

    if (valid) {

        bootbox.confirm('Are you sure you want to save this Inventory?', function(c) {

          if(c) {

            InventoryBibliographyManual.save($scope.adata, function(e) {

              if(e.ok) {

                $.gritter.add({

                  title: 'Successfully save Inventory Bibliography!',

                  text: e.msg,

                });

                $scope.load();

              }

            });

            $('#add-inventory-bibliography-modal').modal('hide');

          }

        });

    }

  }

  //edit inventory bibliography

  $scope.editInventoryBibliography = function(index, data) {

    $('#edit_inventory_bibliography').validationEngine('attach');

    data.index = index;

    $scope.adata = data;

    $('#edit-inventory-bibliography-modal').modal('show');

  }

  //update inventory bibliography

  $scope.updateInventoryBibliography = function(data, index) {

    valid = $('#edit_inventory_bibliography').validationEngine('validate');

    if (valid) {

        bootbox.confirm('Are you sure you want to update this Inventory?', function(c) {

          if(c) {

            InventoryBibliographyManual.update({id:data.id}, $scope.adata, function(e) {

              if(e.ok) {

                $.gritter.add({

                  title: 'Successfully save Inventory Bibliography!',

                  text: e.msg,

                });

                $scope.load();

              }

            });

            $('#edit-inventory-bibliography-modal').modal('hide');

          }

        });

    }

  }

  $scope.removeInventoryBibliography = function(data) {

    bootbox.confirm('Are you sure you want to remove this record ?', function(c) {

      if (c) {

        InventoryBibliographyManualDelete.save({ id: data.id },data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            $scope.load();

          }
''
        });

      }

    });

  } 

});