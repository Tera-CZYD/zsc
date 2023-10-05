app.controller('GradeController', function($scope, Employee,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });

  $scope.getCollege = function(id){

    $scope.college_id = id;

    $scope.load({

      college_id: $scope.college_id,

    });

  }

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Employee.query(options, function(e) {

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

    $scope.load();

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search: search,

      });

    } else {

      $scope.load();
    
    }

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        Employee.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/faculty?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/faculty?print=1');

    }

  }

});

app.controller('GradeViewController', function($scope, $routeParams, Grade, GradeUpdate, GradeSubmitMidterm, GradeSubmitFinalTerm, Employee, Select,GradeSubmitSingleMidterm, GradeSubmitSingleFinalTerm) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  $scope.bool = true;

  Select.get({ code: 'program-list' },function(e){

    $scope.programs = e.data;

  });

  $scope.getProgram = function(id){

    Select.get({ code: 'program-course-list', id : id },function(e){

      $scope.courses = e.data;

    });

  }

  Select.get({ code: 'section-list' },function(e){

    $scope.sections = e.data;

  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  // load 
  $scope.load = function() {

    Grade.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.conditionsPrint = '';

  $scope.boolMidterm = true;

  $scope.boolFinalterm = true;

  $scope.boolIncomplete = true;

  $scope.getDatas = function(){

    if($scope.program_id != null && $scope.course_id != null &&  $scope.section_id != null && $scope.year_term_id != null){

      Select.get({ code: 'get-enrolled-courses', program_id : $scope.program_id, course_id : $scope.course_id, section_id : $scope.section_id, year_term_id : $scope.year_term_id, faculty_id : $scope.id },function(e){

        $scope.datas = e.data;

        if($scope.datas.length > 0){

          $scope.conditionsPrint += '&program_id='+$scope.program_id+'&course_id='+$scope.course_id+'&section_id='+$scope.section_id+'&year_term_id='+$scope.year_term_id+'&faculty_id='+$scope.id;

          $.each($scope.datas, function(i,val){

            if(val.midterm_submitted == 0){

              $scope.boolMidterm = false;

            }else{

              $scope.boolMidterm = true;

            }

            if(val.finalterm_submitted == 0 && $scope.boolMidterm == true){

              $scope.boolFinalterm = false;

            }else{

              $scope.boolFinalterm = true;

            }

            if(val.remarks == 'INCOMPLETE'){

              $scope.boolIncomplete = false;

            }else{

              $scope.boolIncomplete = true;

            }

          });

          $scope.bool = false;

        }

      });

    }

  }

  $scope.button_status = 'edit';

  $scope.editIncomplete = function(){

    $scope.button_status = 'save';

    Select.get({ code: 'get-enrolled-courses', program_id : $scope.program_id, course_id : $scope.course_id, section_id : $scope.section_id, year_term_id : $scope.year_term_id, faculty_id : $scope.id },function(e){

      $scope.datas = e.data;

      if($scope.datas.length > 0){

        $scope.conditionsPrint += '&program_id='+$scope.program_id+'&course_id='+$scope.course_id+'&section_id='+$scope.section_id+'&year_term_id='+$scope.year_term_id+'&faculty_id='+$scope.id;

        $.each($scope.datas, function(i,val){

          if(val.incomplete == 1){

            $scope.datas[i].incomplete_status = true;

          }

        });

      }

    });

  }

  $scope.button_single_status = 'edit';

  $scope.editSingleIncomplete = function(){

    $scope.button_single_status = 'save';

    Select.get({ code: 'get-enrolled-courses', program_id : $scope.program_id, course_id : $scope.course_id, section_id : $scope.section_id, year_term_id : $scope.year_term_id, faculty_id : $scope.id },function(e){

      $scope.datas = e.data;

      if($scope.datas.length > 0){

        $scope.conditionsPrint += '&program_id='+$scope.program_id+'&course_id='+$scope.course_id+'&section_id='+$scope.section_id+'&year_term_id='+$scope.year_term_id+'&faculty_id='+$scope.id;

        $.each($scope.datas, function(i,val){

          if(val.incomplete == 1){

            $scope.datas[i].incomplete_status = true;

          }

        });

      }

    });

  }

  $scope.getFinalGrade = function(index){

    if($scope.datas[index].midterm_grade != null && $scope.datas[index].finalterm_grade != null && $scope.datas[index].finalterm_grade != ''){

      $scope.datas[index].final_grade = (parseFloat($scope.datas[index].midterm_grade) + parseFloat($scope.datas[index].finalterm_grade)) / 2;

      if($scope.datas[index].final_grade <= 3){

        $scope.datas[index].remarks = 'PASSED';

      }else{

        $scope.datas[index].remarks = 'FAILED'

      }

    }

    if($scope.datas[index].finalterm_grade == ''){

      $scope.datas[index].final_grade = '';

      $scope.datas[index].remarks = '';

    }

  }

  $scope.submitMidterm = function(data){  

    bootbox.confirm('Are you sure you want to submit mid term grade?', function(b){

      if(b) {

        GradeSubmitMidterm.update($scope.datas, function(e){
                // console.log($scope.datas);
          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text : e.msg

            });

            $scope.getDatas();

          }

        });

      }

    });

  }

  $scope.submitFinalterm = function(data){  

    text = 'submit final term grade';

    if($scope.button_status == 'save'){

      text = 'update incomplete';

    }

    bootbox.confirm('Are you sure you want to '+text+'?', function(b){

      if(b) {

        $scope.button_status = 'edit';

        GradeSubmitFinalTerm.update($scope.datas, function(e){

          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text : e.msg

            });

            $scope.getDatas();

          }

        });

      }

    });

  }

  $scope.submitSingleMidterm = function(sub){  

    bootbox.confirm('Are you sure you want to submit mid term grade?', function(b){

      if(b) {

        GradeSubmitSingleMidterm.update(sub, function(e){
                // console.log($scope.datas);
          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text : e.msg

            });

            $scope.getDatas();

          }

        });

      }

    });

  }

  $scope.submitSingleFinalterm = function(sub){  

    text = 'submit final term grade';

    if($scope.button_status == 'save'){

      text = 'update incomplete';

    }

    bootbox.confirm('Are you sure you want to '+text+'?', function(b){

      if(b) {

        $scope.button_status = 'edit';

        GradeSubmitSingleFinalTerm.update(sub, function(e){

          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text : e.msg

            });

            $scope.getDatas();

          }

        });

      }

    });

  }

  $scope.save = function(data){  

    bootbox.confirm('Are you sure you want to save grades?', function(b){

      if(b) {

        GradeUpdate.update($scope.datas, function(e){

          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text : e.msg

            });

            $scope.getDatas();

          }

        });

      }

    });

  }

  $scope.print = function(){
    
    printTable(base + 'print/report_rating_form?print=1' + $scope.conditionsPrint);

  }

});