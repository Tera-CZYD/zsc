app.controller('ProgramAdviserController', function($scope, ProgramAdviser,ProgramAdviserEnlist, Ptc, Select) {

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

  $scope.ptc = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Ptc.query(options, function(e) {

      if (e.ok) {

        $scope.datasPtc = e.data;

        $scope.conditionsPrintPtc = e.conditionsPrint;

        // paginator

        $scope.paginatorPtc  = e.paginator;

        $scope.pagesPtc = paginator($scope.paginatorPtc, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.forEnlistment(options);

    $scope.enlisted(options);

    $scope.ptc(options);

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
    
    }

    $scope.load({

      date         : $scope.dateToday,

      startDate    : $scope.startDate,

      endDate      : $scope.endDate,

      year_term_id  : $scope.year_term_id,

    });
  
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

  $scope.enlist = function(data,section){

    if(section.available_slot > 0){

      data.selected_block_section_id = section.id;

      data.selected_section_id = section.section_id;

      data.selected_section = section.section;

      if(section.available_slot == 5){

        $.gritter.add({

          title: 'Warning!',

          text:  'Remaining 5 slots available.',

        });

      }

      bootbox.confirm('Are you sure you want to enlist student number ' + data.student_no + ' to section ' +  section.section + '?', function(c) {

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

    }else{

      $.gritter.add({

        title: 'Warning!',

        text:  'There is no available slots left to this section.',

      });

    }

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

app.controller('ProgramAdviserAddController', function($scope, ProgramAdviser, Ptc, Select) {

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    Ptc : {},

    PtcSub : []

  };

  Select.get({ code: 'ptc-code' },function(e){

    $scope.data.Ptc.code = e.data;

  });

  Select.get({ code: 'ptc-block-section' },function(e){

    $scope.block_sections = e.data;

  });

  $scope.getSection = function(id){

    if($scope.block_sections.length > 0){

      $.each($scope.block_sections, function(i,val){

        if(val.id == id){

          $scope.data.Ptc.section = val.section;

          $scope.data.Ptc.section_id = val.section_id;

        }

      });

    }

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

      name : student.name

    }; 

  }

  $scope.studentData = function(id) {

    $scope.sub.student_id = $scope.student.id;

    $scope.sub.student_no = $scope.student.code;

    $scope.sub.student_name = $scope.student.name;

  }

  $scope.addStudent = function() {

    $('#student_form').validationEngine('attach');
    
    $scope.sub = {};

    $('#add-student-modal').modal('show');

  }
  
  $scope.saveStudent = function(data) {

    data.student_id = $scope.sub.student_id;

    valid = $("#student_form").validationEngine('validate'); 

    if(valid){

      $scope.data.PtcSub.push(data); 

      $('#add-student-modal').modal('hide');

    }

  }

  $scope.editStudent = function(index,data) {

    $('#edit_student_form').validationEngine('attach');

    $scope.index = index;

    data.index = index;

    $scope.sub = data;


    $('#edit-student-modal').modal('show');

  }
  
  $scope.updateStudent = function(data) {

    valid = $("#edit_student_form").validationEngine('validate');

    if(valid){

      data.student_id = $scope.sub.student_id;

      $scope.data.PtcSub[data.index] = data; 

      $('#edit-student-modal').modal('hide');

    }

  }
  
  $scope.removeStudent = function(index) {

    $scope.data.PtcSub.splice(index,1);

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Ptc.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/faculty/program-adviser';

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

app.controller('ProgramAdviserViewController', function($scope, $routeParams, DeleteSelected, ProgramAdviser, Ptc, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    Ptc.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

});

