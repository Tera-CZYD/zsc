app.controller('CurriculumController', function($scope, Curriculum) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Curriculum.query(options, function(e) {

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

        Curriculum.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/Curriculum?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/Curriculum?print=1');

    }

  }

});

app.controller('CurriculumAddController', function($scope, Curriculum, Select) {

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $('#form').validationEngine('attach');

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Curriculum.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/curriculum';

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

app.controller('CurriculumViewController', function($scope, $routeParams, DeleteSelected, Curriculum,CurriculumLock,CurriculumUnlock,CurriculumCourse,CurriculumCourseDelete,CurriculumActivate,CurriculumDeactivate,Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    Curriculum.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.data.CurriculumCourse = [];

      $scope.year_term_id = null;
      
      Select.get({ code: 'year-term-list',educational_level : $scope.data.Curriculum.educational_level },function(e){

        $scope.year_terms = e.data;

      });

    });

  }

  $scope.load();  

  $scope.getRecords = function(id){

    if(id !== undefined && id !== null && id !== ''){

      Select.get({ code: 'curriculum-course-list',id : $scope.id,year_term_id : id },function(e){

        $scope.data.CurriculumCourse = e.data;

      });

    }

  }

  $scope.activate = function(data){

    bootbox.confirm('Are you sure you want to activate curriculum ' +  data.code + '?', function(e){

      if(e) {

        CurriculumActivate.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          $scope.load();

        });

      }

    });

  }

  $scope.deactivate = function(data){

    bootbox.confirm('Are you sure you want to deactivate curriculum ' +  data.code + '?', function(e){

      if(e) {

        CurriculumDeactivate.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          $scope.load();

        });

      }

    });

  }

  $scope.lock = function(data){

    bootbox.confirm('Are you sure you want to lock curriculum ' +  data.code + '?', function(e){

      if(e) {

        CurriculumLock.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          $scope.load();

        });

      }

    });

  }

  $scope.unlock = function(data){

    bootbox.confirm('Are you sure you want to unlock curriculum ' +  data.code + '?', function(e){

      if(e) {

        CurriculumUnlock.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          $scope.load();

        });

      }

    });

  }

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        Curriculum.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/curriculum";

          }

        });

      }

    });

  } 
  
  $scope.removeCourse = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        CurriculumCourseDelete.save({ data: data }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            $scope.getRecords($scope.year_term_id);

          }

        });

      }

    });

  } 

  $scope.print_requisites = function(id){
  
    printTable(base + 'print/curriculum_requisites/'+id);

  } 

  $scope.print_fees = function(id){
  
    printTable(base + 'print/curriculum_fees/'+id);

  } 

});

app.controller('CurriculumEditController', function($scope, $routeParams, Curriculum, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });


  // load 
  $scope.load = function() {

    Curriculum.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Curriculum.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/curriculum';

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

app.controller('CurriculumAddCourseController', function($scope, $routeParams, Curriculum,CurriculumCourse, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    CurriculumCourse : {},

    CurriculumCoursePrerequisite : [],

    CurriculumCourseCorequisite : [],

    CurriculumCourseEquivalency : [],

    CurriculumCourseFee : []

  }

  Select.get({ code: 'course-list' },function(e){

    $scope.courses = e.data;

  });

  Select.get({ code: 'fee-list' },function(e){

    $scope.fees = e.data;

  });


  // load 
  $scope.load = function() {

    Curriculum.get({ id: $scope.id }, function(e) {

      $scope.data.CurriculumCourse = e.data.Curriculum;

      Select.get({ code: 'year-term-list',educational_level : $scope.data.CurriculumCourse.educational_level },function(e){

        $scope.year_terms = e.data;

      });

    });

  }

  $scope.load();

  $scope.addPrerequisite = function() {

    $scope.data.CurriculumCoursePrerequisite.push({

      tmp : ''

    });

  }
  
  $scope.removePrerequisite = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CurriculumCoursePrerequisite.splice(index,1);

    }

  }

  $scope.addCorequisite = function() {

    $scope.data.CurriculumCourseCorequisite.push({

      tmp : ''

    });

  }
  
  $scope.removeCorequisite = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CurriculumCourseCorequisite.splice(index,1);

    }

  }

  $scope.addEquivalency = function() {

    $scope.data.CurriculumCourseEquivalency.push({

      tmp : ''

    });

  }
  
  $scope.removeEquivalency = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CurriculumCourseEquivalency.splice(index,1);

    }

  }

  $scope.addFee = function() {

    $scope.data.CurriculumCourseFee.push({

      tmp : ''

    });

    $scope.compute();

  }
  
  $scope.removeFee = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CurriculumCourseFee.splice(index,1);

      $scope.compute();

    }

  }

  $scope.compute = function(){

    amount = 0;

    if($scope.data.CurriculumCourseFee.length > 0){

      $.each($scope.data.CurriculumCourseFee,function(i,value){

        tmp = number_format(value.amount, 2, '.', '')

        if(parseFloat(tmp) > 0){

          amount += parseFloat(tmp);

        }

      });

    }

    $scope.data.CurriculumCourse.total = amount;

  }

  $scope.getPrerequisites = function(id){

    if(id !== undefined && id !== null && id !== ''){

      Select.get({ code: 'get-prerequisite-list',id : $scope.id,year_term_id : id },function(e){

        $scope.prerequisites = e.data;

      });

      Select.get({ code: 'get-corerequisite-list',id : $scope.id,year_term_id : id },function(e){

        $scope.corerequisites = e.data;

      });

      Select.get({ code: 'course-list',id : $scope.id,year_term_id : id },function(e){

        $scope.courselist = e.data;

      });

    }

  }

  $scope.clear = function(){

    $scope.data.CurriculumCourse.course_id = null;

    $scope.data.CurriculumCourse.year_term_id = null;

    $scope.data.CurriculumCoursePrerequisite = [];

    $scope.data.CurriculumCourseCorequisite = [];

    $scope.data.CurriculumCourseEquivalency = [];

    $scope.data.CurriculumCourseFee = [];

  }

  $scope.cancel = function(){ 

    bootbox.confirm('Are you sure you want to cancel this transaction ?', function(b){

      if(b) {
        
        window.location = '#/curriculum/view/'+$scope.id; 

      }

    });

  }

  $scope.convert = function(){

    if($scope.data.CurriculumCourseFee.length > 0){

      $.each($scope.data.CurriculumCourseFee,function(i,value){

        $scope.data.CurriculumCourseFee[i].amount = number_format(value.amount, 2, '.', '');

      });

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      if($scope.data.CurriculumCourse.course_id !== undefined && $scope.data.CurriculumCourse.course_id !== null && $scope.data.CurriculumCourse.course_id !== ''){

        $scope.convert();

        CurriculumCourse.save($scope.data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });
        
            window.location = '#/curriculum/view/'+$scope.id;

          } else {

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,
              
            });

          }
          
        }); 

      }else{

        $.gritter.add({

          title: 'Warning!',

          text:  'Please select course to proceed.',
          
        });

      }

    }

  }

});

app.controller('CurriculumViewCourseController', function($scope, $routeParams, DeleteSelected, Curriculum,CurriculumLock,CurriculumUnlock,CurriculumCourse,CurriculumCourseView,CurriculumCourseDelete,Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    CurriculumCourseView.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  
  
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.Curriculum.code +' ?', function(c) {

      if (c) {

        CurriculumCourseDelete.save({ data: data.CurriculumCourse }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });
        
            window.location = '#/curriculum/view/'+$scope.data.CurriculumCourse.curriculum_id;

          }

        });

      }

    });

  } 

});

app.controller('CurriculumEditCourseController', function($scope, $routeParams, Curriculum,CurriculumCourseView,CurriculumCourse,CurriculumCourseUpdate, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    CurriculumCourse : {},

    CurriculumCoursePrerequisite : [],

    CurriculumCourseCorequisite : [],

    CurriculumCourseEquivalency : [],

    CurriculumCourseFee : []

  }

  Select.get({ code: 'course-list' },function(e){

    $scope.courses = e.data;

  });

  Select.get({ code: 'fee-list' },function(e){

    $scope.fees = e.data;

  });


  // load 
  $scope.load = function() {

    CurriculumCourseView.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.get({ code: 'year-term-list',educational_level : e.data.Curriculum.educational_level },function(e){

        $scope.year_terms = e.data;

      });

      $scope.getPrerequisites($scope.data.CurriculumCourse.year_term_id);

    });

  }

  $scope.load();

  $scope.addPrerequisite = function() {

    $scope.data.CurriculumCoursePrerequisite.push({

      tmp : ''

    });

  }
  
  $scope.removePrerequisite = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CurriculumCoursePrerequisite.splice(index,1);

    }

  }

  $scope.addCorequisite = function() {

    $scope.data.CurriculumCourseCorequisite.push({

      tmp : ''

    });

  }
  
  $scope.removeCorequisite = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CurriculumCourseCorequisite.splice(index,1);

    }

  }

  $scope.addEquivalency = function() {

    $scope.data.CurriculumCourseEquivalency.push({

      tmp : ''

    });

  }
  
  $scope.removeEquivalency = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CurriculumCourseEquivalency.splice(index,1);

    }

  }

  $scope.addFee = function() {

    $scope.data.CurriculumCourseFee.push({

      tmp : ''

    });

    $scope.compute();

  }
  
  $scope.removeFee = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CurriculumCourseFee.splice(index,1);

      $scope.compute();

    }

  }

  $scope.compute = function(){

    amount = 0;

    if($scope.data.CurriculumCourseFee.length > 0){

      $.each($scope.data.CurriculumCourseFee,function(i,value){

        tmp = number_format(value.amount, 2, '.', '')

        if(parseFloat(tmp) > 0){

          amount += parseFloat(tmp);

        }

      });

    }

    $scope.data.CurriculumCourse.total = amount;

  }

  $scope.getPrerequisites = function(id){

    if(id !== undefined && id !== null && id !== ''){

      Select.get({ code: 'get-prerequisite-list',id : $scope.data.CurriculumCourse.curriculum_id,year_term_id : id },function(e){

        $scope.prerequisites = e.data;

      });

      Select.get({ code: 'get-corerequisite-list',id : $scope.data.CurriculumCourse.curriculum_id,year_term_id : id },function(e){

        $scope.corerequisites = e.data;

      });

      Select.get({ code: 'course-list',id : $scope.data.CurriculumCourse.curriculum_id,year_term_id : id },function(e){

        $scope.courselist = e.data;

      });

    }

  }

  $scope.clear = function(){

    $scope.data.CurriculumCourse.course_id = null;

    $scope.data.CurriculumCourse.year_term_id = null;

    $scope.data.CurriculumCoursePrerequisite = [];

    $scope.data.CurriculumCourseCorequisite = [];

    $scope.data.CurriculumCourseEquivalency = [];

    $scope.data.CurriculumCourseFee = [];

  }

  $scope.cancel = function(){ 

    bootbox.confirm('Are you sure you want to cancel this transaction ?', function(b){

      if(b) {
        
        window.location = '#/curriculum/view-course/'+$scope.id;

      }

    });

  }

  $scope.convert = function(){

    if($scope.data.CurriculumCourseFee.length > 0){

      $.each($scope.data.CurriculumCourseFee,function(i,value){

        $scope.data.CurriculumCourseFee[i].amount = number_format(value.amount, 2, '.', '');

      });

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      if($scope.data.CurriculumCourse.course_id !== undefined && $scope.data.CurriculumCourse.course_id !== null && $scope.data.CurriculumCourse.course_id !== ''){

        $scope.convert();

        CurriculumCourseUpdate.update({id:$scope.id}, $scope.data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });
        
            window.location = '#/curriculum/view-course/'+$scope.id;

          } else {

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,
              
            });

          }
          
        }); 

      }else{

        $.gritter.add({

          title: 'Warning!',

          text:  'Please select course to proceed.',
          
        });

      }

    }

  }

});

app.controller('CurriculumYearTermLoadController', function($scope, $routeParams, DeleteSelected, Curriculum,CurriculumYearLevelTermLoad,Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    Curriculum.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.cancel = function(){ 

    bootbox.confirm('Are you sure you want to cancel this transaction ?', function(b){

      if(b) {
        
        window.location = '#/curriculum/view/'+$scope.id; 

      }

    });

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      CurriculumYearLevelTermLoad.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });
      
          window.location = '#/curriculum/view/'+$scope.id;

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