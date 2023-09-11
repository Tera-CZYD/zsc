app.controller('FacultyQceController', function($scope, FacultyQce,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $scope.new = 1;

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  Select.get({ code: 'academic-term-list' },function(e){

    $scope.academic_terms = e.data;

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    FacultyQce.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        if($scope.new == 1){

          $('#info-modal').modal('show');

          $scope.new = 0;

        }

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

  $scope.showInfo = function(data){

    $scope.info = {

      code     : data.code,

      title    : data.title,

      faculty  : data.full_name,

      status   : data.status == 0 ? 'Not Evaluated' : 'Evaluated'

    }

    $('#show-info-modal').modal('show');

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.description +' ?', function(c) {

      if (c) {

        AcademicTerm.remove({ id: data.id }, function(e) {

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

  $scope.filterData = function(){

    $scope.academic_term_id = null;

    if($scope.search.academic_term_id !== undefined && $scope.search.academic_term_id !== '' && $scope.search.academic_term_id !== null){

      $scope.academic_term_id = $scope.search.academic_term_id;

    }

    $scope.load({

      search : $scope.searchTxt,

      academic_term_id : $scope.academic_term_id

    });

  }

  $scope.print = function(){

    printTable(base + 'print/FacultyQces/' + $scope.data.Student.id);

  }

});

app.controller('FacultyQceEvaluateFacultyController', function($scope,$routeParams,FacultyQce,Select) {

  $('#form1').validationEngine('attach');

  $('#form2').validationEngine('attach');

  $('#form3').validationEngine('attach');

  $('#form4').validationEngine('attach');

  $('#form5').validationEngine('attach');

  $scope.id = $routeParams.id;

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');
  
  var current_fs, next_fs, previous_fs; //fieldsets

  var opacity;

  $scope.new = 1;

  $scope.currentForm = 1;

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.data = {

    FacultyQce : {}

  }

  $scope.ratings = [

    {

      id : 1,

      value : '1: Strongly disagree'

    },

    {

      id : 2,

      value : '2: Disagree'

    },

    {

      id : 3,

      value : '3: Moderately agree'

    },

    {

      id : 4,

      value : '4: Agree'

    },

    {

      id : 5,

      value : '5: Strongly agree'

    },

  ];

  Select.get({ code: 'academic-term-list' },function(e){

    $scope.academic_terms = e.data;

  });

  Select.get({ code: 'evaluation-a-list' },function(e){

    $scope.a_list = e.data;

  });

  Select.get({ code: 'evaluation-b-list' },function(e){

    $scope.b_list = e.data;

  });

  Select.get({ code: 'evaluation-c-list' },function(e){

    $scope.c_list = e.data;

  });

  Select.get({ code: 'evaluation-d-list' },function(e){

    $scope.d_list = e.data;

  });

  // load 
  $scope.load = function() {

    FacultyQce.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $(".next").click(function(){

    if($scope.currentForm == 1){

      valid = $("#form1").validationEngine('validate');

    }else if($scope.currentForm == 2){

      valid = $("#form2").validationEngine('validate');

    }else if($scope.currentForm == 3){

      valid = $("#form3").validationEngine('validate');

    }else if($scope.currentForm == 4){

      valid = $("#form4").validationEngine('validate');

    }

    if (valid) {
      
      current_fs = $(this).parent();

      next_fs = $(this).parent().next();

      //Add Class Active

      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
      
      //show the next fieldset

      next_fs.show();

      //hide the current fieldset with style

      current_fs.animate({opacity: 0}, {

        step: function(now) {

          // for making fielset appear animation

          opacity = 1 - now;

          current_fs.css({

            'display': 'none',

            'position': 'relative'

          });

          next_fs.css({'opacity': opacity});

        }, 

        duration: 600

      });

      $scope.currentForm += 1;

    }

  });

  $(".previous").click(function(){
  
    current_fs = $(this).parent();

    previous_fs = $(this).parent().prev();
    
    //Remove class active

    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    
    //show the previous fieldset

    previous_fs.show();

    //hide the current fieldset with style

    current_fs.animate({opacity: 0}, {

      step: function(now) {

        // for making fielset appear animation

        opacity = 1 - now;

        current_fs.css({

          'display': 'none',

          'position': 'relative'

        });

        previous_fs.css({'opacity': opacity});

      }, 

      duration: 600

    });

    $scope.currentForm -= 1;

  });

  $scope.save = function() {

    valid = $("#form5").validationEngine('validate');
    
    if (valid) {

      bootbox.confirm('Are you sure you want to save evaluation for '+ $scope.data.CourseSchedule.Employee.proper_name1 +' ?', function(c) {

        if (c) {

          $scope.data.Alist = $scope.a_list;

          $scope.data.Blist = $scope.b_list;

          $scope.data.Clist = $scope.c_list;

          $scope.data.Dlist = $scope.d_list;

          FacultyQce.save($scope.data, function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text:  e.msg,

              });

              window.location = '#/faculty-qce';

            } else {

              $.gritter.add({

                title: 'Warning!',

                text:  e.msg,

              });

            }

          });

        }

      });

    }  

  }

});