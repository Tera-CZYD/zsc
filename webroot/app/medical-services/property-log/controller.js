app.controller('PropertyLogController', function($scope, PropertyLog) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.medicalEquipment = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['type'] = 'MEDICAL EQUIPMENT';

    PropertyLog.query(options, function(e) {

      if (e.ok) {

        $scope.datasMedicalEquipment = e.data;

        $scope.conditionsMedicalEquipmentPrint = e.conditionsPrint;

        $scope.paginatorMedicalEquipment = e.paginator;

        $scope.pagesMedicalEquipment = paginator($scope.paginatorMedicalEquipment, 5);

      }

    });

  }

  $scope.dentalEquipment = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['type'] = 'DENTAL EQUIPMENT';

    PropertyLog.query(options, function(e) {

      if (e.ok) {

        $scope.datasDentalEquipment = e.data;

        $scope.conditionsDentalEquipmentPrint = e.conditionsPrint;

        $scope.paginatorDentalEquipment = e.paginator;

        $scope.pagesDentalEquipment = paginator($scope.paginatorDentalEquipment, 5);

      }

    });

  }

  $scope.medicalSupplies = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['type'] = 'MEDICAL SUPPLIES';

    PropertyLog.query(options, function(e) {

      if (e.ok) {

        $scope.datasMedicalSupplies = e.data;

        $scope.conditionsMedicalSuppliesPrint = e.conditionsPrint;

        $scope.paginatorMedicalSupplies = e.paginator;

        $scope.pagesMedicalSupplies = paginator($scope.paginatorMedicalSupplies, 5);

      }

    });

  }

  $scope.dentalSupplies = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['type'] = 'DENTAL SUPPLIES';

    PropertyLog.query(options, function(e) {

      if (e.ok) {

        $scope.datasDentalSupplies = e.data;

        $scope.conditionsDentalSuppliesPrint = e.conditionsPrint;

        $scope.paginatorDentalSupplies = e.paginator;

        $scope.pagesDentalSupplies = paginator($scope.paginatorDentalSupplies, 5);

      }

    });

  }

  $scope.medicine = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['type'] = 'MEDICINE';

    PropertyLog.query(options, function(e) {

      if (e.ok) {

        $scope.datasMedicine = e.data;

        $scope.conditionsMedicinePrint = e.conditionsPrint;

        // paginator

        $scope.paginatorMedicine  = e.paginator;

        $scope.pagesMedicine = paginator($scope.paginatorMedicine, 5);

      }

    });

  }

  $scope.others = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['type'] = 'OTHERS';

    PropertyLog.query(options, function(e) {

      if (e.ok) {

        $scope.datasOthers = e.data;

        $scope.conditionsOthersPrint = e.conditionsPrint;

        // paginator

        $scope.paginatorOthers  = e.paginator;

        $scope.pagesOthers = paginator($scope.paginatorOthers, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.medicalEquipment(options);

    $scope.dentalEquipment(options);

    $scope.medicalSupplies(options);

    $scope.dentalSupplies(options);

    $scope.medicine(options);

    $scope.others(options);

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

    bootbox.confirm('Are you sure you want to delete ' + data.property_name +' ?', function(c) {

      if (c) {

        PropertyLog.remove({ id: data.id }, function(e) {

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

  $scope.printMedicalEquipment = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/property_log?print=1' + $scope.conditionsMedicalEquipmentPrint);

    }else{

      printTable(base + 'print/property_log?print=1');

    }

  }

  $scope.printDentalEquipment = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/property_log?print=1' + $scope.conditionsDentalEquipmentPrint);

    }else{

      printTable(base + 'print/property_log?print=1');

    }

  }
  $scope.printMedicalSupplies = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/property_log?print=1' + $scope.conditionsMedicalSuppliesPrint);

    }else{

      printTable(base + 'print/property_log?print=1');

    }

  }
  $scope.printDentalSupplies = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/property_log?print=1' + $scope.conditionsDentalSuppliesPrint);

    }else{

      printTable(base + 'print/property_log?print=1');

    }

  }
  $scope.printMedicine = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/property_log?print=1' + $scope.conditionsMedicinePrint);

    }else{

      printTable(base + 'print/property_log?print=1');

    }

  }

  $scope.printOthers = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/property_log?print=1' + $scope.conditionsOthersPrint);

    }else{

      printTable(base + 'print/property_log?print=1');

    }

  }

});

app.controller('PropertyLogAddController', function($scope, PropertyLog, Select) {

  $('#form').validationEngine('attach');

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $scope.data = {

    PropertyLog : {

      date : $scope.today

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      PropertyLog.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/property-log';

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

app.controller('PropertyLogViewController', function($scope, $routeParams, PropertyLog, PropertyLogManual, PropertyLogManualDelete) {
  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });
  $scope.id = $routeParams.id;

  $scope.data = {
    PropertyLog:{},
    InventoryProperty : []
  };

  // load 

  $scope.load = function() {

    PropertyLog.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  
  $scope.addInventory = function() {

    $('#add_inventory').validationEngine('attach');

    $scope.adata = {};

    $('#add-inventory-modal').modal('show');

  }

  //save Inventory

  $scope.saveInventory = function(data) {

    valid = $('#add_inventory').validationEngine('validate');

    $scope.adata.property_log_id = $scope.id;

    if (valid) {

        bootbox.confirm('Are you sure you want to save this Inventory?', function(c) {

          if(c) {

            PropertyLogManual.save($scope.adata, function(e) {

              if(e.ok) {

                $.gritter.add({

                  title: 'Successfully save Inventory!',

                  text: e.msg,

                });

                $scope.load();

              }

            });

            $('#add-inventory-modal').modal('hide');

          }

        });

    }

  }

  //edit Inventory

  $scope.editInventory = function(index, data) {

    $('#edit_inventory').validationEngine('attach');

    data.index = index;

    $scope.adata = data;

    $('#edit-inventory-modal').modal('show');

  }

  //update Inventory

  $scope.updateInventory = function(data, index) {

    valid = $('#edit_inventory').validationEngine('validate');

    if (valid) {

        bootbox.confirm('Are you sure you want to update this Inventory?', function(c) {

          if(c) {

            PropertyLogManual.update({id:data.id}, $scope.adata, function(e) {

              if(e.ok) {

                $.gritter.add({

                  title: 'Successfully save Inventory!',

                  text: e.msg,

                });

                $scope.load();

              }

            });

            $('#edit-inventory-modal').modal('hide');

          }

        });

    }

  }

  $scope.removeInventory = function(data) {

    bootbox.confirm('Are you sure you want to remove this record ?', function(c) {

      if (c) {

        PropertyLogManualDelete.save({ id: data.id },data, function(e) {

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

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.property_name +' ?', function(c) {

      if (c) {

        PropertyLog.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/medical-services/property-log";

          }

        });

      }

    });

  } 

});

app.controller('PropertyLogEditController', function($scope, $routeParams, PropertyLog) {
  
  $scope.id = $routeParams.id;

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $scope.data = {

    PropertyLog : {}

  }
  // load 

  $scope.load = function() {

    PropertyLog.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      PropertyLog.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/property-log';

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