app.controller('CollegeProgramController', function($scope, CollegeProgram) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    CollegeProgram.query(options, function(e) {

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

        CollegeProgram.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/college_programs?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/college_programs?print=1');

    }

  }

});

app.controller('CollegeProgramAddController', function($scope, CollegeProgram, Select) {

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $('.yearpicker').datepicker({

    format: "yyyy",

    autoclose: true,

    minViewMode: "years",

    pickTime: false

  });

  $scope.data = {

    CollegeProgram : {},

    CollegeProgramSub : []

  };

  Select.get({ code: 'program-term-list' },function(e){

    $scope.program_terms = e.data;

  });
      Select.get({ code: 'major-list' },function(e){

    $scope.majors = e.data;

  });

  // add requirement

  $scope.addRequirement = function() {

    $('#requirement_form').validationEngine('attach');
    
    $scope.sub = {};

    $('#add-requirement-modal').modal('show');

  }
  
  $scope.saveRequirement = function(data) {

    valid = $("#requirement_form").validationEngine('validate');

    if(valid){

      $scope.data.CollegeProgramSub.push(data);
      
      $('#add-requirement-modal').modal('hide');

    }

  }

  $scope.editRequirement = function(index,data) {

    $('#edit_requirement_form').validationEngine('attach');
    
    data.index = index;

    $scope.sub = data;

    console.log($scope.sub);

    $('#edit-requirement-modal').modal('show');

  }
  
  $scope.updateRequirement = function(data) {

    valid = $("#edit_requirement_form").validationEngine('validate');

    if(valid){

      $scope.data.CollegeProgramSub[data.index] = data;
      
      $('#edit-requirement-modal').modal('hide');

    }

  }
  
  $scope.removeRequirement = function(index) {

    $scope.data.CollegeProgramSub.splice(index,1);

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      CollegeProgram.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/college-program';

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

app.controller('CollegeProgramViewController', function($scope, $routeParams, DeleteSelected, CollegeProgram, Select, CollegeProgramDelete) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  // load 
  $scope.load = function() {

    CollegeProgram.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.getRecords = function(id){

    if(id !== undefined && id !== null && id !== ''){

      Select.get({ code: 'curriculum-course-list',id : $scope.id,year_term_id : id },function(e){

        $scope.data.CollegeProgramCourse = e.data;

      });

    }

  }

  $scope.removeCourse = function(data) {

    console.log(data);

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        CollegeProgramDelete.save({ data: data }, function(e) {

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

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        CollegeProgram.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/college-program";

          }

        });

      }

    });

  } 

});

app.controller('CollegeProgramEditController', function($scope, $routeParams, CollegeProgram, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $('.yearpicker').datepicker({

    format: "yyyy",

    autoclose: true,

    minViewMode: "years",

    pickTime: false

  });

  Select.get({ code: 'program-term-list' },function(e){

    $scope.program_terms = e.data;

  });
      Select.get({ code: 'major-list' },function(e){

    $scope.majors = e.data;

  });

  Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });

  $scope.data = {

    CollegeProgram : {},

    CollegeProgramSub : []

  };

  // load 
  $scope.load = function() {

    CollegeProgram.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  // add requirement

  $scope.addRequirement = function() {

    $('#requirement_form').validationEngine('attach');
    
    $scope.sub = {};

    $('#add-requirement-modal').modal('show');

  }
  
  $scope.saveRequirement = function(data) {

    valid = $("#requirement_form").validationEngine('validate');

    if(valid){

      $scope.data.CollegeProgramSub.push(data);
      
      $('#add-requirement-modal').modal('hide');

    }

  }

  $scope.editRequirement = function(index,data) {

    $('#edit_requirement_form').validationEngine('attach');
    
    data.index = index;

    $scope.sub = data;

    $('#edit-requirement-modal').modal('show');

  }
  
  $scope.updateRequirement = function(data) {

    valid = $("#edit_requirement_form").validationEngine('validate');

    if(valid){

      $scope.data.CollegeProgramSub[data.index] = data;
      
      $('#edit-requirement-modal').modal('hide');

    }

  }
  
  $scope.removeRequirement = function(index) {

    $scope.data.CollegeProgramSub.splice(index,1);

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      CollegeProgram.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/college-program';

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

app.controller('CollegeProgramAddCourseController', function($scope, $routeParams, CollegeProgram,CollegeProgramCourse, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    CollegeProgram : {},

    CollegeProgramCourse : {},

    CollegeProgramPrerequisite : [],

    CollegeProgramCorequisite : []

  }

  Select.get({ code: 'course-list' },function(e){

    $scope.courses = e.data;

  });

  $scope.getCourse = function(id){

    if($scope.courses.length > 0){

      $.each($scope.courses, function(i,val){

        if(id == val.id){

          $scope.data.CollegeProgramCourse.course = val.value;

        }

      });

    }

  }

  // load 
  $scope.load = function() {

    CollegeProgram.get({ id: $scope.id }, function(e) {

      $scope.data.CollegeProgram.name = e.data.CollegeProgram.name;

      Select.get({ code: 'year-term-list' },function(e){

        $scope.year_terms = e.data;

      });

    });

  }

  $scope.load();

  $scope.addPrerequisite = function() {

    $scope.data.CollegeProgramPrerequisite.push({

      tmp : ''

    });

  }
  
  $scope.removePrerequisite = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CollegeProgramPrerequisite.splice(index,1);

    }

  }

  $scope.addCorequisite = function() {

    $scope.data.CollegeProgramCorequisite.push({

      tmp : ''

    });

  }
  
  $scope.removeCorequisite = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CollegeProgramCorequisite.splice(index,1);

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

  $scope.getPrerequisiteCourse = function(id){

    if($scope.prerequisites.length > 0){

      $.each($scope.prerequisites, function(i,val){

        if(id == val.id){

          $scope.data.CollegeProgramPrerequisite[0].course = val.value;

        }

      });

    }

  }

  $scope.getCorequisiteCourse = function(id){

    if($scope.prerequisites.length > 0){

      $.each($scope.prerequisites, function(i,val){

        if(id == val.id){

          $scope.data.CollegeProgramCorequisite[0].course = val.value;

        }

      });

    }

  }

  $scope.cancel = function(){ 

    bootbox.confirm('Are you sure you want to cancel this transaction ?', function(b){

      if(b) {
        
        window.location = '#/college-program/view/'+$scope.id; 

      }

    });

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      if($scope.data.CollegeProgramCourse.course_id !== undefined && $scope.data.CollegeProgramCourse.course_id !== null && $scope.data.CollegeProgramCourse.course_id !== ''){

        console.log($scope.data.CollegeProgramCourse.course)
        CollegeProgramCourse.save({id:$scope.id}, $scope.data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });
        
            window.location = '#/college-program/view/'+$scope.id;

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

app.controller('CollegeProgramViewCourseController', function($scope, $routeParams, DeleteSelected, CollegeProgram,CollegeProgramCourse,CollegeProgramView,CollegeProgramDelete,Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    CollegeProgramView.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  
  
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.CollegeProgramCourse.course +' ?', function(c) {

      if (c) {

        CollegeProgramDelete.save({ data: data.CollegeProgramCourse }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });
        
            window.location = '#/college-program/view/'+$scope.data.CollegeProgramCourse.college_program_id;

          }

        });

      }

    });

  } 

});

app.controller('CollegeProgramEditCourseController', function($scope, $routeParams, CollegeProgram,CollegeProgramView,CollegeProgramCourse,CollegeProgramUpdate, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    CollegeProgram : {},

    CollegeProgramCourse : {},

    CollegeProgramPrerequisite : [],

    CollegeProgramCorequisite : []

  }

  Select.get({ code: 'course-list' },function(e){

    $scope.courses = e.data;

  });

  // load 
  $scope.load = function() {

    CollegeProgramView.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.get({ code: 'year-term-list' },function(e){

        $scope.year_terms = e.data;

      });

      $scope.getPrerequisites($scope.data.CollegeProgramCourse.year_term_id);

    });

  }

  $scope.load();

  $scope.addPrerequisite = function() {

    $scope.data.CollegeProgramPrerequisite.push({

      tmp : ''

    });

  }
  
  $scope.removePrerequisite = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CollegeProgramPrerequisite.splice(index,1);

    }

  }

  $scope.addCorequisite = function() {

    $scope.data.CollegeProgramCorequisite.push({

      tmp : ''

    });

  }
  
  $scope.removeCorequisite = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.CollegeProgramCorequisite.splice(index,1);

    }

  }

  $scope.getPrerequisites = function(id){

    if(id !== undefined && id !== null && id !== ''){

      Select.get({ code: 'get-prerequisite-list',id : $scope.data.CollegeProgramCourse.curriculum_id,year_term_id : id },function(e){

        $scope.prerequisites = e.data;

      });

      Select.get({ code: 'get-corerequisite-list',id : $scope.data.CollegeProgramCourse.curriculum_id,year_term_id : id },function(e){

        $scope.corerequisites = e.data;

      });

      Select.get({ code: 'course-list',id : $scope.data.CollegeProgramCourse.curriculum_id,year_term_id : id },function(e){

        $scope.courselist = e.data;

      });

    }

  }

  $scope.cancel = function(){ 

    bootbox.confirm('Are you sure you want to cancel this transaction ?', function(b){

      if(b) {
        
        window.location = '#/college-program/view-course/'+$scope.id;

      }

    });

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      if($scope.data.CollegeProgramCourse.course_id !== undefined && $scope.data.CollegeProgramCourse.course_id !== null && $scope.data.CollegeProgramCourse.course_id !== ''){

        CollegeProgramUpdate.update({id:$scope.id}, $scope.data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });
        
            window.location = '#/college-program/view-course/'+$scope.id;

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