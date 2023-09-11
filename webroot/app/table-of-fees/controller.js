app.controller('TableOfFeeController', function($scope, TableOfFee) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    TableOfFee.query(options, function(e) {

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

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        TableOfFee.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/table_of_fees?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/table_of_fees?print=1');

    }

  }

});

app.controller('TableOfFeeAddController', function($scope, TableOfFee, Select) {

  $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    TableOfFee : {},

    TableOfFeeItem :[]

  }

  Select.get({ code: 'academic-term-list' },function(e){

    $scope.academic_terms = e.data;

  });

  Select.get({ code: 'department-program-list' },function(e){

    $scope.department_programs = e.data;

  });

  Select.get({ code: 'account-item-list' },function(e){

    $scope.accounts = e.data;

  });

  // add item

  $scope.addRecord = function() {

    $('#record_form').validationEngine('attach');
    
    $scope.record = {};

    $('#add-record-modal').modal('show');

  }
  
  $scope.saveRecord = function(data) {

    valid = $("#record_form").validationEngine('validate');

    if(valid){

      $scope.checkAccount(data.account_id);

      if($scope.counter == 0){

        data.active_view = data.active == 1? 'True' : 'False';

        $scope.data.TableOfFeeItem.push(data);

        $scope.compute();
        
        $('#add-record-modal').modal('hide');

      }else{

        $.gritter.add({

          title: 'Warning.',

          text:  'Account already exist.',

        });

      }

    }

  }

  $scope.editRecord = function(index,data) {

    $('#edit_record_form').validationEngine('attach');
  
    $scope.record = {

      index      : index,

      account_id_old : data.account_id,

      account_id : data.account_id,

      active     : data.active,

      code       : data.code,

      amount     : data.amount

    }

    $('#edit-record-modal').modal('show');

  }
  
  $scope.updateRecord = function(data) {

    valid = $("#edit_record_form").validationEngine('validate');

    if(valid){

      $scope.checkAccount(data.account_id,data.account_id_old);

      if($scope.counter == 0){

        data.active_view = data.active == 1 ? 'True' : 'False';

        $scope.data.TableOfFeeItem[data.index] = data;

        $scope.compute();
        
        $('#edit-record-modal').modal('hide');

      }else{

        $.gritter.add({

          title: 'Warning.',

          text:  'Account already exist.',

        });

      }
      
    }

  }
  
  $scope.removeRecord = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.TableOfFeeItem.splice(index,1);

      $scope.compute();

    }

  }

  $scope.getRecordData = function(id){

    if(id !== undefined && id !== null && id !== ''){

      if($scope.accounts.length > 0){

        $.each($scope.accounts,function(i,value){

          if(value.id == id){

            $scope.record.code = value.name;

            $scope.record.amount = value.amount;

          }

        });

      }

    }else{

      $scope.record.code = null;

      $scope.record.amount = null;

    }

  }

  $scope.compute = function(){

    $scope.data.TableOfFee.total = 0;

    if($scope.data.TableOfFeeItem.length > 0){

      $.each($scope.data.TableOfFeeItem,function(i,value){

        $scope.data.TableOfFee.total += parseFloat(value.amount);

      });

    }

  }

  $scope.checkAccount = function(id = null,edit = null){

    $scope.counter = 0;

    if($scope.data.TableOfFeeItem.length > 0){

      $.each($scope.data.TableOfFeeItem,function(i,value){

        if(id == value.account_id && value.account_id != edit){

          $scope.counter += 1;

        }

      });

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      $scope.data.TableOfFee.amount = number_format($scope.data.TableOfFee.amount, 2, '.', '');

      TableOfFee.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/table-of-fees';

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

app.controller('TableOfFeeViewController', function($scope, $routeParams, DeleteSelected, TableOfFee, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    TableOfFee.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        TableOfFee.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/table-of-fees";

          }

        });

      }

    });

  } 

  $scope.print = function(id){
  
    printTable(base + 'print/table_of_fees_view/'+id);

  } 

});

app.controller('TableOfFeeEditController', function($scope, $routeParams, TableOfFee, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  Select.get({ code: 'academic-term-list' },function(e){

    $scope.academic_terms = e.data;

  });

  Select.get({ code: 'department-program-list' },function(e){

    $scope.department_programs = e.data;

  });

  Select.get({ code: 'account-item-list' },function(e){

    $scope.accounts = e.data;

  });

  // load 
  $scope.load = function() {

    TableOfFee.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  // add item

  $scope.addRecord = function() {

    $('#record_form').validationEngine('attach');
    
    $scope.record = {};

    $('#add-record-modal').modal('show');

  }
  
  $scope.saveRecord = function(data) {

    valid = $("#record_form").validationEngine('validate');

    if(valid){

      $scope.checkAccount(data.account_id);

      if($scope.counter == 0){

        data.active_view = data.active == 1? 'True' : 'False';

        $scope.data.TableOfFeeItem.push(data);

        $scope.compute();
        
        $('#add-record-modal').modal('hide');

      }else{

        $.gritter.add({

          title: 'Warning.',

          text:  'Account already exist.',

        });

      }

    }

  }

  $scope.editRecord = function(index,data) {

    $('#edit_record_form').validationEngine('attach');
  
    $scope.record = {

      index      : index,

      account_id_old : data.account_id,

      account_id : data.account_id,

      active     : data.active,

      code       : data.code,

      amount     : data.amount

    }

    $('#edit-record-modal').modal('show');

  }
  
  $scope.updateRecord = function(data) {

    valid = $("#edit_record_form").validationEngine('validate');

    if(valid){

      $scope.checkAccount(data.account_id,data.account_id_old);

      if($scope.counter == 0){

        data.active_view = data.active == 1 ? 'True' : 'False';

        $scope.data.TableOfFeeItem[data.index] = data;

        $scope.compute();
        
        $('#edit-record-modal').modal('hide');

      }else{

        $.gritter.add({

          title: 'Warning.',

          text:  'Account already exist.',

        });

      }
      
    }

  }
  
  $scope.removeRecord = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.TableOfFeeItem.splice(index,1);

      $scope.compute();

    }

  }

  $scope.getRecordData = function(id){

    if(id !== undefined && id !== null && id !== ''){

      if($scope.accounts.length > 0){

        $.each($scope.accounts,function(i,value){

          if(value.id == id){

            $scope.record.code = value.name;

            $scope.record.amount = value.amount;

          }

        });

      }

    }else{

      $scope.record.code = null;

      $scope.record.amount = null;

    }

  }

  $scope.compute = function(){

    $scope.data.TableOfFee.total = 0;

    if($scope.data.TableOfFeeItem.length > 0){

      $.each($scope.data.TableOfFeeItem,function(i,value){

        $scope.data.TableOfFee.total += parseFloat(value.amount);

      });

    }

  }

  $scope.checkAccount = function(id = null,edit = null){

    $scope.counter = 0;

    if($scope.data.TableOfFeeItem.length > 0){

      $.each($scope.data.TableOfFeeItem,function(i,value){

        if(id == value.account_id && value.account_id != edit){

          $scope.counter += 1;

        }

      });

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      $scope.data.TableOfFee.amount = number_format($scope.data.TableOfFee.amount, 2, '.', '');

      TableOfFee.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/table-of-fees';

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