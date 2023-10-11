app.controller('ClassScheduleController', function($scope, $window, ClassSchedule, Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $('.yearpicker').datepicker({

    format: "yyyy",

    autoclose: true,

    minViewMode: "years",

    pickTime: false

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    ClassSchedule.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

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

  // $scope.loadSelect = function () {

  //   Select.get({ code: 'faculty-list-all' },function(e) {

  //     $scope.faculties = e.data;
      
  //   });

  //   Select.get({ code: 'college-list-all' },function(e) {

  //     $scope.colleges = e.data;
      
  //   });

  //   Select.get({ code: 'college-program-list-all' },function(e) {

  //     $scope.programs = e.data;
    
  //   });

  //   Select.get({ code: 'year-term-list' },function(e) {

  //     $scope.year_terms = e.data;
      
  //   });

  // }

  Select.get({ code: 'year-term-list' },function(e) {

      $scope.year_terms = e.data;
      
    });

  $scope.selectedFilter = 'year';

  $scope.changeFilter = function(type){

    $scope.search = {};

    $scope.selectedFilter = type;

  }

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_level_term = e.data;

  });

  $scope.searchFilter = function(search) {
   
    $scope.searchTxt = '';

    $scope.year = null;

    $scope.semester = null;

    if ($scope.selectedFilter == 'year') {
    
      date = $('.yearpicker').datepicker('getDate');

      year = date.getFullYear();

      $scope.year = year;
   
    } else if($scope.selectedFilter == 'semester'){

      $scope.semester = search.semester;

    }

    $scope.load({

      year : $scope.year,

      semester : $scope.semester

    });
  
  } 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        ClassSchedule.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/class_schedule?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/class_schedule?print=1');

    }

  }

});

app.controller('ClassScheduleAddController', function($scope, ClassSchedule, Select) {

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

  $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $scope.data = {

    ClassSchedule : {},

    ClassScheduleSub : [],

    ClassScheduleDay : [],

    ClassScheduleTmp : [],

  };

  Select.get({code: 'class-schedule-code'}, function(e) {

    $scope.data.ClassSchedule.code = e.data;

  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  Select.get({ code: 'section-list' },function(e){

    $scope.sections = e.data;

  });

  Select.get({ code: 'course-list' },function(e){

    $scope.courses = e.data;

  });

  Select.get({ code: 'room-list' },function(e){

    $scope.rooms = e.data;

  });

  Select.get({ code: 'building-list' },function(e){

    $scope.buildings = e.data;

  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getCollegeProgram = function(id){

    if($scope.colleges.length > 0){

      $.each($scope.colleges, function(i,val){

        if(val.id == id){

          $scope.data.ClassSchedule.college = val.value;

        }

      });

    }

    // Select.get({ code: 'faculty-list', id : id }, function(e) {

    //   $scope.faculties = e.data;

    // });

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.getProgram = function(id){

    if($scope.programs.length > 0){

      $.each($scope.programs, function(i,val){

        if(val.id == id){

          $scope.data.ClassSchedule.program = val.value;

        }

      });

    }

  }

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name,

      college_id : employee.college_id,

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.ClassSchedule.faculty_id = $scope.employee.id;

    $scope.data.ClassSchedule.faculty_name = $scope.employee.name;

    $scope.data.ClassSchedule.college_id = $scope.employee.college_id;

    $scope.getCollegeProgram($scope.employee.college_id);

  }

  $scope.getDatas = function(id,start,end){

    Select.get({ code: 'schedule-list', year_term_id : id, school_year_start : start, school_year_end : end },function(e) {

      $scope.schedules = e.data;


    });

  }

  // add schedule

  $scope.getCourse = function(id){

    if($scope.courses.length > 0){

      $.each($scope.courses, function(i,val){

        if(id == val.id){

          $scope.sub.course = val.value;

        }

      });

    }

  }

  $scope.addSchedule = function() {

    $('#schedule_form').validationEngine('attach');
    
    $scope.sub = {};

    $scope.data.ClassScheduleDay = [];

    $('#add-schedule-modal').modal('show');

  }
  
  $scope.saveSchedule = function(data) {

    $scope.bool3 = true;

    valid = $("#schedule_form").validationEngine('validate'); 

    if(valid){

      if($scope.schedules.length > 0){

        $.each($scope.schedules, function(index,values){

          $.each($scope.data.ClassScheduleDay, function(i,val){

            if(values.day == val.day){

              //NEW TIME START

                new_time_start = val.time_start;

                new_time_start = new_time_start.replace('AM', '');

                new_time_start = new_time_start.replace('PM', '');

                const [inputHours, inputMinutes] = new_time_start.split(':');

                const timestamp_new_start = new Date();

                timestamp_new_start.setHours(inputHours);

                timestamp_new_start.setMinutes(inputMinutes);

                timestamp_new_start.setSeconds(0);

                timestamp_new_start.setMilliseconds(0);

                const timestampValue_new_start = timestamp_new_start.getTime();

              //END NEW TIME START

              //NEW TIME END

                new_time_end = val.time_end;

                new_time_end = new_time_end.replace('AM', '');

                new_time_end = new_time_end.replace('PM', '');

                const [inputHours_new_end, inputMinutes_new_end] = new_time_end.split(':');

                const timestamp_new_end = new Date();

                timestamp_new_end.setHours(inputHours_new_end);

                timestamp_new_end.setMinutes(inputMinutes_new_end);

                timestamp_new_end.setSeconds(0);

                timestamp_new_end.setMilliseconds(0);

                const timestampValue_new_end = timestamp_new_end.getTime();

              //END NEW TIME END

              //ADDED TIME START

                added_time_start = values.time_start;

                added_time_start = added_time_start.replace('AM', '');

                added_time_start = added_time_start.replace('PM', '');

                const [inputHours_added_start, inputMinutes_added_start] = added_time_start.split(':');

                const timestamp_added_start = new Date();

                timestamp_added_start.setHours(inputHours_added_start);

                timestamp_added_start.setMinutes(inputMinutes_added_start);

                timestamp_added_start.setSeconds(0);

                timestamp_added_start.setMilliseconds(0);

                const timestampValue_added_start = timestamp_added_start.getTime();

              //END ADDED TIME START

              //ADDED TIME END

                added_time_end = values.time_end;

                added_time_end = added_time_end.replace('AM', '');

                added_time_end = added_time_end.replace('PM', '');

                const [inputHours_added_end, inputMinutes_added_end] = added_time_end.split(':');

                const timestamp_added_end = new Date();

                timestamp_added_end.setHours(inputHours_added_end);

                timestamp_added_end.setMinutes(inputMinutes_added_end);

                timestamp_added_end.setSeconds(0);

                timestamp_added_end.setMilliseconds(0);

                const timestampValue_added_end = timestamp_added_end.getTime();

              //END ADDED TIME END

              if(values.room_id == val.room_id || values.section_id === val.section_id){

                if (timestampValue_new_start >= timestampValue_added_start && timestampValue_new_start <= timestampValue_added_end) {

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+values.code+' - '+values.room+' - '+values.section+' - '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool3 = false;
                  $scope.data.ClassScheduleTmp = [];
                  
                }else if(timestampValue_new_end >= timestampValue_added_start && timestampValue_new_end <= timestampValue_added_end){

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+values.code+' - '+values.room+' - '+values.section+' - '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool3 = false;
                  $scope.data.ClassScheduleTmp = [];

                }

              }

            }

          });

        });

      }

      if($scope.bool3){

        $scope.data.ClassScheduleSub.push({

          course            : $scope.sub.course,

          course_id         : $scope.sub.course_id,

          ClassScheduleDay  : $scope.data.ClassScheduleDay

        }); 

        $('#add-schedule-modal').modal('hide');



      }

    }

  }

  $scope.editSchedule = function(index,data) {

    $('#edit_program_form').validationEngine('attach');

    $scope.index = index;

    data.index = index;

    $scope.sub = data;

    console.log(index)


    $('#edit-schedule-modal').modal('show');

  }
  
  $scope.updateSchedule = function(data) {

    $scope.bool3 = true;

    

    valid = $("#edit_schedule_form").validationEngine('validate');

    if(valid){

      if($scope.schedules.length > 0){

        $.each($scope.schedules, function(index,values){

          $.each($scope.data.ClassScheduleTmp, function(i,val){

            if(values.day == val.day){

              //NEW TIME START

                new_time_start = val.time_start;

                new_time_start = new_time_start.replace('AM', '');

                new_time_start = new_time_start.replace('PM', '');

                const [inputHours, inputMinutes] = new_time_start.split(':');

                const timestamp_new_start = new Date();

                timestamp_new_start.setHours(inputHours);

                timestamp_new_start.setMinutes(inputMinutes);

                timestamp_new_start.setSeconds(0);

                timestamp_new_start.setMilliseconds(0);

                const timestampValue_new_start = timestamp_new_start.getTime();

              //END NEW TIME START

              //NEW TIME END

                new_time_end = val.time_end;

                new_time_end = new_time_end.replace('AM', '');

                new_time_end = new_time_end.replace('PM', '');

                const [inputHours_new_end, inputMinutes_new_end] = new_time_end.split(':');

                const timestamp_new_end = new Date();

                timestamp_new_end.setHours(inputHours_new_end);

                timestamp_new_end.setMinutes(inputMinutes_new_end);

                timestamp_new_end.setSeconds(0);

                timestamp_new_end.setMilliseconds(0);

                const timestampValue_new_end = timestamp_new_end.getTime();

              //END NEW TIME END

              //ADDED TIME START

                added_time_start = values.time_start;

                added_time_start = added_time_start.replace('AM', '');

                added_time_start = added_time_start.replace('PM', '');

                const [inputHours_added_start, inputMinutes_added_start] = added_time_start.split(':');

                const timestamp_added_start = new Date();

                timestamp_added_start.setHours(inputHours_added_start);

                timestamp_added_start.setMinutes(inputMinutes_added_start);

                timestamp_added_start.setSeconds(0);

                timestamp_added_start.setMilliseconds(0);

                const timestampValue_added_start = timestamp_added_start.getTime();

              //END ADDED TIME START

              //ADDED TIME END

                added_time_end = values.time_end;

                added_time_end = added_time_end.replace('AM', '');

                added_time_end = added_time_end.replace('PM', '');

                const [inputHours_added_end, inputMinutes_added_end] = added_time_end.split(':');

                const timestamp_added_end = new Date();

                timestamp_added_end.setHours(inputHours_added_end);

                timestamp_added_end.setMinutes(inputMinutes_added_end);

                timestamp_added_end.setSeconds(0);

                timestamp_added_end.setMilliseconds(0);

                const timestampValue_added_end = timestamp_added_end.getTime();

              //END ADDED TIME END

              if(values.room_id == val.room_id || values.section_id === val.section_id){

                if (timestampValue_new_start >= timestampValue_added_start && timestampValue_new_start <= timestampValue_added_end) {

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+values.code+' - '+values.room+' - '+values.section+' - '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool3 = false;

                  
                  
                }else if(timestampValue_new_end >= timestampValue_added_start && timestampValue_new_end <= timestampValue_added_end){

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+values.code+' - '+values.room+' - '+values.section+' - '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool3 = false;


                }

              }

            }

          });

        });

      }

      if($scope.bool3){

        $scope.data.ClassScheduleSub[data.index] = {

          course            : $scope.sub.course,

          course_id         : $scope.sub.course_id,

          ClassScheduleDay  : data.ClassScheduleDay

        }; 

        console.log($scope.data.ClassScheduleSub[data.index])

        $('#edit-schedule-modal').modal('hide');

      }

    }

  }
  
  $scope.removeSchedule = function(index) {

    $scope.data.ClassScheduleSub.splice(index,1);

  }

  //add schedule day

  $scope.getRoom = function(id){

    if($scope.rooms.length > 0){

      $.each($scope.rooms, function(i,val){

        if(id == val.id){

          $scope.day.room = val.value;

        }

      });

    }

  }

   $scope.getBuilding = function(id){

    if($scope.buildings.length > 0){

      $.each($scope.buildings, function(i,val){

        if(id == val.id){

          $scope.day.building = val.value;

        }

      });

    }

  }

  $scope.getSection = function(id){

    if($scope.sections.length > 0){

      $.each($scope.sections, function(i,val){

        if(id == val.id){

          $scope.day.section = val.value;

        }

      });

    }

  }

  $scope.addScheduleDay = function() {

    $('#schedule_day_form').validationEngine('attach');
    
    $scope.day = {};

    console.log($scope.data.ClassScheduleTmp)


    $('#add-schedule-day-modal').modal('show');

  }

  $scope.saveScheduleDay = function(data) {

    $scope.bool = true;



    valid = $("#schedule_day_form").validationEngine('validate');

    if(valid){

      //VALIDATION FOR CURRENT SCHEDULE

        if($scope.data.ClassScheduleTmp.length){

          $.each($scope.data.ClassScheduleTmp, function(i,val){

            //NEW TIME START

              new_time_start = data.time_start;

              new_time_start = new_time_start.replace('AM', '');

              new_time_start = new_time_start.replace('PM', '');

              const [inputHours, inputMinutes] = new_time_start.split(':');

              const timestamp_new_start = new Date();

              timestamp_new_start.setHours(inputHours);

              timestamp_new_start.setMinutes(inputMinutes);

              timestamp_new_start.setSeconds(0);

              timestamp_new_start.setMilliseconds(0);

              const timestampValue_new_start = timestamp_new_start.getTime();

            //END NEW TIME START

            //NEW TIME END

              new_time_end = data.time_end;

              new_time_end = new_time_end.replace('AM', '');

              new_time_end = new_time_end.replace('PM', '');

              const [inputHours_new_end, inputMinutes_new_end] = new_time_end.split(':');

              const timestamp_new_end = new Date();

              timestamp_new_end.setHours(inputHours_new_end);

              timestamp_new_end.setMinutes(inputMinutes_new_end);

              timestamp_new_end.setSeconds(0);

              timestamp_new_end.setMilliseconds(0);

              const timestampValue_new_end = timestamp_new_end.getTime();

            //END NEW TIME END

            //ADDED TIME START

              added_time_start = val.time_start;

              added_time_start = added_time_start.replace('AM', '');

              added_time_start = added_time_start.replace('PM', '');

              const [inputHours_added_start, inputMinutes_added_start] = added_time_start.split(':');

              const timestamp_added_start = new Date();

              timestamp_added_start.setHours(inputHours_added_start);

              timestamp_added_start.setMinutes(inputMinutes_added_start);

              timestamp_added_start.setSeconds(0);

              timestamp_added_start.setMilliseconds(0);

              const timestampValue_added_start = timestamp_added_start.getTime();

            //END ADDED TIME START

            //ADDED TIME END

              added_time_end = val.time_end;

              added_time_end = added_time_end.replace('AM', '');

              added_time_end = added_time_end.replace('PM', '');

              const [inputHours_added_end, inputMinutes_added_end] = added_time_end.split(':');

              const timestamp_added_end = new Date();

              timestamp_added_end.setHours(inputHours_added_end);

              timestamp_added_end.setMinutes(inputMinutes_added_end);

              timestamp_added_end.setSeconds(0);

              timestamp_added_end.setMilliseconds(0);

              const timestampValue_added_end = timestamp_added_end.getTime();

            //END ADDED TIME END

              console.log(data)
              console.log(val)

            if(data.day == val.day){

              if (timestampValue_new_start >= timestampValue_added_start && timestampValue_new_start <= timestampValue_added_end) {

                $.gritter.add({

                  title: 'Warning!',

                  text:  'Schedule is conflict to '+val.day+'('+val.time_start+' - '+val.time_end+')'

                });

                $scope.bool = false;
                
              }else if(timestampValue_new_end >= timestampValue_added_start && timestampValue_new_end <= timestampValue_added_end){

                $.gritter.add({

                  title: 'Warning!',

                  text:  'Schedule is conflict to '+val.day+'('+val.time_start+' - '+val.time_end+')'

                });

                $scope.bool = false;

              }

            }

          });

        }

      //END 

      if($scope.bool){

        $scope.data.ClassScheduleDay.push(data);



        $scope.data.ClassScheduleTmp.push(data);

        $('#add-schedule-day-modal').modal('hide');



      }

    }

  }

  $scope.editScheduleDay = function(index,data) {

    $('#edit_program_form').validationEngine('attach');
    
    data.index = index;

    $scope.day = data;

    console.log(index)

    $('#edit-schedule-day-modal').modal('show');

  }
  
  $scope.updateScheduleDay = function(data) {

    valid = $("#edit_schedule_day_form").validationEngine('validate');

    if(valid){

      $scope.bool = true;

      //VALIDATION FOR CURRENT SCHEDULE

        if($scope.data.ClassScheduleTmp.length){

          $.each($scope.data.ClassScheduleTmp, function(i,val){

            console.log($scope.data.ClassScheduleTmp)

            //NEW TIME START

              new_time_start = data.time_start;

              new_time_start = new_time_start.replace('AM', '');

              new_time_start = new_time_start.replace('PM', '');

              const [inputHours, inputMinutes] = new_time_start.split(':');

              const timestamp_new_start = new Date();

              timestamp_new_start.setHours(inputHours);

              timestamp_new_start.setMinutes(inputMinutes);

              timestamp_new_start.setSeconds(0);

              timestamp_new_start.setMilliseconds(0);

              const timestampValue_new_start = timestamp_new_start.getTime();

            //END NEW TIME START

            //NEW TIME END

              new_time_end = data.time_end;

              new_time_end = new_time_end.replace('AM', '');

              new_time_end = new_time_end.replace('PM', '');

              const [inputHours_new_end, inputMinutes_new_end] = new_time_end.split(':');

              const timestamp_new_end = new Date();

              timestamp_new_end.setHours(inputHours_new_end);

              timestamp_new_end.setMinutes(inputMinutes_new_end);

              timestamp_new_end.setSeconds(0);

              timestamp_new_end.setMilliseconds(0);

              const timestampValue_new_end = timestamp_new_end.getTime();

            //END NEW TIME END

            //ADDED TIME START

              added_time_start = val.time_start;

              added_time_start = added_time_start.replace('AM', '');

              added_time_start = added_time_start.replace('PM', '');

              const [inputHours_added_start, inputMinutes_added_start] = added_time_start.split(':');

              const timestamp_added_start = new Date();

              timestamp_added_start.setHours(inputHours_added_start);

              timestamp_added_start.setMinutes(inputMinutes_added_start);

              timestamp_added_start.setSeconds(0);

              timestamp_added_start.setMilliseconds(0);

              const timestampValue_added_start = timestamp_added_start.getTime();

            //END ADDED TIME START

            //ADDED TIME END

              added_time_end = val.time_end;

              added_time_end = added_time_end.replace('AM', '');

              added_time_end = added_time_end.replace('PM', '');

              const [inputHours_added_end, inputMinutes_added_end] = added_time_end.split(':');

              const timestamp_added_end = new Date();

              timestamp_added_end.setHours(inputHours_added_end);

              timestamp_added_end.setMinutes(inputMinutes_added_end);

              timestamp_added_end.setSeconds(0);

              timestamp_added_end.setMilliseconds(0);

              const timestampValue_added_end = timestamp_added_end.getTime();

            //END ADDED TIME END

            if(data.index != val.index){

              if(data.day == val.day){

                console.log('hakdog')

                if (timestampValue_new_start >= timestampValue_added_start && timestampValue_new_start <= timestampValue_added_end) {

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool = false;
                  
                }else if(timestampValue_new_end >= timestampValue_added_start && timestampValue_new_end <= timestampValue_added_end){

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool = false;

                }

              }

            }

          });

        }

      //END

      if($scope.bool){

        $scope.data.ClassScheduleDay[data.index] = data;

        $scope.data.ClassScheduleTmp[data.index] = data;

        $('#edit-schedule-day-modal').modal('hide');

      }

    }

  }
  
  $scope.removeScheduleDay = function(index) {


    $scope.sub.ClassScheduleDay.splice(index,1);

    $scope.data.ClassScheduleTmp.splice(index,1);

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      ClassSchedule.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/class-schedule';

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

app.controller('ClassScheduleViewController', function($scope, $routeParams, ClassSchedule, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    ClassSchedule.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        ClassSchedule.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/class-schedule";

          }

        });

      }

    });

  } 

});

app.controller('ClassScheduleEditController', function($scope, $routeParams, ClassSchedule, Select) {
  
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

  $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $scope.data = {

    ClassSchedule : {},

    ClassScheduleSub : [],

    ClassScheduleDay : [],

    ClassScheduleTmp : null,

  };

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  Select.get({ code: 'section-list' },function(e){

    $scope.sections = e.data;

  });

  Select.get({ code: 'course-list' },function(e){

    $scope.courses = e.data;

  });

  Select.get({ code: 'room-list' },function(e){

    $scope.rooms = e.data;

  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  Select.get({ code: 'building-list' },function(e){

    $scope.buildings = e.data;

  });

  $scope.getProgram = function(id){

    if($scope.programs.length > 0){

      $.each($scope.programs, function(i,val){

        if(val.id == id){

          $scope.data.ClassSchedule.program = val.value;

        }

      });

    }

  }

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name,

      college_id : employee.college_id,

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.ClassSchedule.faculty_id = $scope.employee.id;

    $scope.data.ClassSchedule.faculty_name = $scope.employee.name;

    $scope.data.ClassSchedule.college_id = $scope.employee.college_id;

    $scope.getCollegeProgram($scope.employee.college_id);

  }

  // add schedule

  $scope.getCourse = function(id){

    if($scope.courses.length > 0){

      $.each($scope.courses, function(i,val){

        if(id == val.id){

          $scope.sub.course = val.value;

        }

      });

    }

  }

  $scope.getDatas = function(id,start,end){

    Select.get({ code: 'schedule-list', year_term_id : id, school_year_start : start, school_year_end : end },function(e) {

      $scope.schedules = e.data;


    });

  }

  $scope.addSchedule = function() {

    $('#schedule_form').validationEngine('attach');
    
    $scope.sub = {};

    $scope.sub.ClassScheduleDay = [];

    $('#add-schedule-modal').modal('show');

  }
  
  $scope.saveSchedule = function(data) {

    $scope.bool3 = true;

    valid = $("#schedule_form").validationEngine('validate');

    if(valid){

      if($scope.schedules.length > 0){

        $.each($scope.schedules, function(index,values){




          $.each(data.ClassScheduleDay, function(i,val){


            if(values.day == val.day){

              //NEW TIME START

                new_time_start = val.time_start;

                new_time_start = new_time_start.replace('AM', '');

                new_time_start = new_time_start.replace('PM', '');

                const [inputHours, inputMinutes] = new_time_start.split(':');

                const timestamp_new_start = new Date();

                timestamp_new_start.setHours(inputHours);

                timestamp_new_start.setMinutes(inputMinutes);

                timestamp_new_start.setSeconds(0);

                timestamp_new_start.setMilliseconds(0);

                const timestampValue_new_start = timestamp_new_start.getTime();

              //END NEW TIME START

              //NEW TIME END

                new_time_end = val.time_end;

                new_time_end = new_time_end.replace('AM', '');

                new_time_end = new_time_end.replace('PM', '');

                const [inputHours_new_end, inputMinutes_new_end] = new_time_end.split(':');

                const timestamp_new_end = new Date();

                timestamp_new_end.setHours(inputHours_new_end);

                timestamp_new_end.setMinutes(inputMinutes_new_end);

                timestamp_new_end.setSeconds(0);

                timestamp_new_end.setMilliseconds(0);

                const timestampValue_new_end = timestamp_new_end.getTime();

              //END NEW TIME END

              //ADDED TIME START

                added_time_start = values.time_start;

                added_time_start = added_time_start.replace('AM', '');

                added_time_start = added_time_start.replace('PM', '');

                const [inputHours_added_start, inputMinutes_added_start] = added_time_start.split(':');

                const timestamp_added_start = new Date();

                timestamp_added_start.setHours(inputHours_added_start);

                timestamp_added_start.setMinutes(inputMinutes_added_start);

                timestamp_added_start.setSeconds(0);

                timestamp_added_start.setMilliseconds(0);

                const timestampValue_added_start = timestamp_added_start.getTime();

              //END ADDED TIME START

              //ADDED TIME END

                added_time_end = values.time_end;

                added_time_end = added_time_end.replace('AM', '');

                added_time_end = added_time_end.replace('PM', '');

                const [inputHours_added_end, inputMinutes_added_end] = added_time_end.split(':');

                const timestamp_added_end = new Date();

                timestamp_added_end.setHours(inputHours_added_end);

                timestamp_added_end.setMinutes(inputMinutes_added_end);

                timestamp_added_end.setSeconds(0);

                timestamp_added_end.setMilliseconds(0);

                const timestampValue_added_end = timestamp_added_end.getTime();

              //END ADDED TIME END

                
              
              if(values.room_id == val.room_id || values.section_id === val.section_id){

                if (timestampValue_new_start >= timestampValue_added_start && timestampValue_new_start <= timestampValue_added_end) {



                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+values.code+' - '+values.room+' - '+values.section+' - '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool3 = false;
                  
                }else if(timestampValue_new_end >= timestampValue_added_start && timestampValue_new_end <= timestampValue_added_end){

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+values.code+' - '+values.room+' - '+values.section+' - '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool3 = false;

                }

              }

            }

            // }

          });

        });

      }

      if($scope.bool3){

        $scope.data.ClassScheduleSub.push({

          course            : $scope.sub.course,

          course_id         : $scope.sub.course_id,

          ClassScheduleDay  : $scope.sub.ClassScheduleDay

        }); 

        $('#add-schedule-modal').modal('hide');

      }

    }

  }

  $scope.editSchedule = function(index,data) {

    $('#edit_program_form').validationEngine('attach');

    $scope.index = index;
    
    data.index = index;

    $scope.sub = data;

    $('#edit-schedule-modal').modal('show');

  }
  
  $scope.updateSchedule = function(data) {

    $scope.bool3 = true;

    valid = $("#edit_schedule_form").validationEngine('validate');

    if(valid){

      if($scope.schedules.length > 0){

        $.each($scope.schedules, function(index,values){

          $.each($scope.data.ClassScheduleTmp, function(i,val){

            if(values.day == val.day){

              //NEW TIME START

                new_time_start = val.time_start;

                new_time_start = new_time_start.replace('AM', '');

                new_time_start = new_time_start.replace('PM', '');

                const [inputHours, inputMinutes] = new_time_start.split(':');

                const timestamp_new_start = new Date();

                timestamp_new_start.setHours(inputHours);

                timestamp_new_start.setMinutes(inputMinutes);

                timestamp_new_start.setSeconds(0);

                timestamp_new_start.setMilliseconds(0);

                const timestampValue_new_start = timestamp_new_start.getTime();

              //END NEW TIME START

              //NEW TIME END

                new_time_end = val.time_end;

                new_time_end = new_time_end.replace('AM', '');

                new_time_end = new_time_end.replace('PM', '');

                const [inputHours_new_end, inputMinutes_new_end] = new_time_end.split(':');

                const timestamp_new_end = new Date();

                timestamp_new_end.setHours(inputHours_new_end);

                timestamp_new_end.setMinutes(inputMinutes_new_end);

                timestamp_new_end.setSeconds(0);

                timestamp_new_end.setMilliseconds(0);

                const timestampValue_new_end = timestamp_new_end.getTime();

              //END NEW TIME END

              //ADDED TIME START

                added_time_start = values.time_start;

                added_time_start = added_time_start.replace('AM', '');

                added_time_start = added_time_start.replace('PM', '');

                const [inputHours_added_start, inputMinutes_added_start] = added_time_start.split(':');

                const timestamp_added_start = new Date();

                timestamp_added_start.setHours(inputHours_added_start);

                timestamp_added_start.setMinutes(inputMinutes_added_start);

                timestamp_added_start.setSeconds(0);

                timestamp_added_start.setMilliseconds(0);

                const timestampValue_added_start = timestamp_added_start.getTime();

              //END ADDED TIME START

              //ADDED TIME END

                added_time_end = values.time_end;

                added_time_end = added_time_end.replace('AM', '');

                added_time_end = added_time_end.replace('PM', '');

                const [inputHours_added_end, inputMinutes_added_end] = added_time_end.split(':');

                const timestamp_added_end = new Date();

                timestamp_added_end.setHours(inputHours_added_end);

                timestamp_added_end.setMinutes(inputMinutes_added_end);

                timestamp_added_end.setSeconds(0);

                timestamp_added_end.setMilliseconds(0);

                const timestampValue_added_end = timestamp_added_end.getTime();

              //END ADDED TIME END

               
              if(values.tmp_id != val.id && values.schedule_id != val.class_schedule_id){

                console.log(values.tmp_id+' - '+val.id)

                console.log(val)


              if(values.room_id == val.room_id || values.section_id === val.section_id){

                if (timestampValue_new_start >= timestampValue_added_start && timestampValue_new_start <= timestampValue_added_end) {

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+values.code+' - '+values.room+' - '+values.section+' - '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool3 = false;
                  
                }else if(timestampValue_new_end >= timestampValue_added_start && timestampValue_new_end <= timestampValue_added_end){

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+values.code+' - '+values.room+' - '+values.section+' - '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool3 = false;

                }

              }

            }

          }

          });

        });

      }

      if($scope.bool3){

        $scope.data.ClassScheduleSub[data.index] = {

          course            : $scope.sub.course,

          course_id         : $scope.sub.course_id,

          ClassScheduleDay  : data.ClassScheduleDay

        }; 

        $('#edit-schedule-modal').modal('hide');

      }

    }

  }
  
  $scope.removeSchedule = function(index) {

    $scope.data.ClassScheduleSub.splice(index,1);

  }

  //add schedule day

  $scope.getRoom = function(id){

    if($scope.rooms.length > 0){

      $.each($scope.rooms, function(i,val){

        if(id == val.id){

          $scope.day.room = val.value;

        }

      });

    }

  }

  $scope.getSection = function(id){

    if($scope.sections.length > 0){

      $.each($scope.sections, function(i,val){

        if(id == val.id){

          $scope.day.section = val.value;

        }

      });

    }

  }
  
  $scope.getBuilding = function(id){

    if($scope.buildings.length > 0){

      $.each($scope.buildings, function(i,val){

        if(id == val.id){

          $scope.day.building = val.value;

        }

      });

    }

  }

  $scope.addScheduleDay = function() {

    $('#schedule_day_form').validationEngine('attach');
    
    $scope.day = {};

    $('#add-schedule-day-modal').modal('show');

  }

  $scope.saveScheduleDay = function(data) {

    $scope.bool = true;

    valid = $("#schedule_day_form").validationEngine('validate');

    if(valid){

      //VALIDATION FOR CURRENT SCHEDULE

        if($scope.data.ClassScheduleTmp.length){

          $.each($scope.data.ClassScheduleTmp, function(i,val){

            //NEW TIME START

              new_time_start = data.time_start;

              new_time_start = new_time_start.replace('AM', '');

              new_time_start = new_time_start.replace('PM', '');

              const [inputHours, inputMinutes] = new_time_start.split(':');

              const timestamp_new_start = new Date();

              timestamp_new_start.setHours(inputHours);

              timestamp_new_start.setMinutes(inputMinutes);

              timestamp_new_start.setSeconds(0);

              timestamp_new_start.setMilliseconds(0);

              const timestampValue_new_start = timestamp_new_start.getTime();

            //END NEW TIME START

            //NEW TIME END

              new_time_end = data.time_end;

              new_time_end = new_time_end.replace('AM', '');

              new_time_end = new_time_end.replace('PM', '');

              const [inputHours_new_end, inputMinutes_new_end] = new_time_end.split(':');

              const timestamp_new_end = new Date();

              timestamp_new_end.setHours(inputHours_new_end);

              timestamp_new_end.setMinutes(inputMinutes_new_end);

              timestamp_new_end.setSeconds(0);

              timestamp_new_end.setMilliseconds(0);

              const timestampValue_new_end = timestamp_new_end.getTime();

            //END NEW TIME END

            //ADDED TIME START

              added_time_start = val.time_start;

              added_time_start = added_time_start.replace('AM', '');

              added_time_start = added_time_start.replace('PM', '');

              const [inputHours_added_start, inputMinutes_added_start] = added_time_start.split(':');

              const timestamp_added_start = new Date();

              timestamp_added_start.setHours(inputHours_added_start);

              timestamp_added_start.setMinutes(inputMinutes_added_start);

              timestamp_added_start.setSeconds(0);

              timestamp_added_start.setMilliseconds(0);

              const timestampValue_added_start = timestamp_added_start.getTime();

            //END ADDED TIME START

            //ADDED TIME END

              added_time_end = val.time_end;

              added_time_end = added_time_end.replace('AM', '');

              added_time_end = added_time_end.replace('PM', '');

              const [inputHours_added_end, inputMinutes_added_end] = added_time_end.split(':');

              const timestamp_added_end = new Date();

              timestamp_added_end.setHours(inputHours_added_end);

              timestamp_added_end.setMinutes(inputMinutes_added_end);

              timestamp_added_end.setSeconds(0);

              timestamp_added_end.setMilliseconds(0);

              const timestampValue_added_end = timestamp_added_end.getTime();

            //END ADDED TIME END


            if(data.day == val.day){

              if(data.room_id == val.room_id || data.section_id === val.section_id){

              if (timestampValue_new_start >= timestampValue_added_start && timestampValue_new_start <= timestampValue_added_end) {

                $.gritter.add({

                  title: 'Warning!',

                  text:  'Schedule is conflict to '+val.day+'('+val.time_start+' - '+val.time_end+')'

                });

                $scope.bool = false;
                
              }else if(timestampValue_new_end >= timestampValue_added_start && timestampValue_new_end <= timestampValue_added_end){

                $.gritter.add({

                  title: 'Warning!',

                  text:  'Schedule is conflict to '+val.day+'('+val.time_start+' - '+val.time_end+')'

                });

                $scope.bool = false;

              }

              }
            }

          });

        }

      //END 

      if($scope.bool){
    
        $scope.sub.ClassScheduleDay.push(data);

        $scope.data.ClassScheduleTmp.push(data);

        $('#add-schedule-day-modal').modal('hide');

      }

    }

  }

  $scope.editScheduleDay = function(index,data) {

    $('#edit_program_form').validationEngine('attach');
    
    data.index = index;

    $scope.day = data;

    console.log($scope.data.ClassScheduleTmp)

    $('#edit-schedule-day-modal').modal('show');

  }
  
  $scope.updateScheduleDay = function(data) {


    valid = $("#edit_schedule_day_form").validationEngine('validate');

    if(valid){

      $scope.bool = true;

      //VALIDATION FOR CURRENT SCHEDULE

        if($scope.data.ClassScheduleTmp.length){

          $.each($scope.data.ClassScheduleTmp, function(i,val){

            console.log(val)
            //NEW TIME START

              new_time_start = data.time_start;

              new_time_start = new_time_start.replace('AM', '');

              new_time_start = new_time_start.replace('PM', '');

              const [inputHours, inputMinutes] = new_time_start.split(':');

              const timestamp_new_start = new Date();

              timestamp_new_start.setHours(inputHours);

              timestamp_new_start.setMinutes(inputMinutes);

              timestamp_new_start.setSeconds(0);

              timestamp_new_start.setMilliseconds(0);

              const timestampValue_new_start = timestamp_new_start.getTime();

            //END NEW TIME START

            //NEW TIME END

              new_time_end = data.time_end;

              new_time_end = new_time_end.replace('AM', '');

              new_time_end = new_time_end.replace('PM', '');

              const [inputHours_new_end, inputMinutes_new_end] = new_time_end.split(':');

              const timestamp_new_end = new Date();

              timestamp_new_end.setHours(inputHours_new_end);

              timestamp_new_end.setMinutes(inputMinutes_new_end);

              timestamp_new_end.setSeconds(0);

              timestamp_new_end.setMilliseconds(0);

              const timestampValue_new_end = timestamp_new_end.getTime();

            //END NEW TIME END

            //ADDED TIME START

              added_time_start = val.time_start;

              added_time_start = added_time_start.replace('AM', '');

              added_time_start = added_time_start.replace('PM', '');

              const [inputHours_added_start, inputMinutes_added_start] = added_time_start.split(':');

              const timestamp_added_start = new Date();

              timestamp_added_start.setHours(inputHours_added_start);

              timestamp_added_start.setMinutes(inputMinutes_added_start);

              timestamp_added_start.setSeconds(0);

              timestamp_added_start.setMilliseconds(0);

              const timestampValue_added_start = timestamp_added_start.getTime();

            //END ADDED TIME START

            //ADDED TIME END

              added_time_end = val.time_end;

              added_time_end = added_time_end.replace('AM', '');

              added_time_end = added_time_end.replace('PM', '');

              const [inputHours_added_end, inputMinutes_added_end] = added_time_end.split(':');

              const timestamp_added_end = new Date();

              timestamp_added_end.setHours(inputHours_added_end);

              timestamp_added_end.setMinutes(inputMinutes_added_end);

              timestamp_added_end.setSeconds(0);

              timestamp_added_end.setMilliseconds(0);

              const timestampValue_added_end = timestamp_added_end.getTime();

            //END ADDED TIME END

            

            if(data.index != val.index){

                console.log(data.index+' - '+i);

              if(data.day == val.day){

                  if(data.room_id == val.room_id || data.section_id === val.section_id){

                if (timestampValue_new_start >= timestampValue_added_start && timestampValue_new_start <= timestampValue_added_end) {

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool = false;
                  
                }else if(timestampValue_new_end >= timestampValue_added_start && timestampValue_new_end <= timestampValue_added_end){

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Schedule is conflict to '+val.day+'('+val.time_start+' - '+val.time_end+')'

                  });

                  $scope.bool = false;

                }
              }

              }
            }

          });

        }

      //END

      if($scope.bool){

        $scope.sub.ClassScheduleDay[data.index] = data;

        $scope.data.ClassScheduleTmp[data.index] = data;


        $('#edit-schedule-day-modal').modal('hide');

      }

    }

  }

  $scope.removeScheduleDay = function(index) {


    $scope.sub.ClassScheduleDay.splice(index,1);

    $scope.data.ClassScheduleTmp.splice(index,1);

  }

  // load 
  $scope.load = function() {

    ClassSchedule.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.get({ code: 'application-program-list', college_id : $scope.data.ClassSchedule.college_id }, function(e) {

        $scope.programs = e.data;

      });

      Select.get({ code: 'schedule-list', year_term_id : $scope.data.ClassSchedule.year_term_id },function(e) {

        $scope.schedules = e.data;

      });

    });

  }

  $scope.load();

  $scope.getCollegeProgram = function(id){

    if($scope.colleges.length > 0){

      $.each($scope.colleges, function(i,val){

        if(val.id == id){

          $scope.data.ClassSchedule.college = val.value;

        }

      });

    }

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  // add program

  $scope.addProgram = function() {

    $('#program_form').validationEngine('attach');
    
    $scope.sub = {};

    $('#add-program-modal').modal('show');

  }
  
  $scope.saveProgram = function(data) {

    valid = $("#program_form").validationEngine('validate');

    if(valid){

      $scope.data.ClassScheduleSub.push(data);
      
      $('#add-program-modal').modal('hide');

    }

  }

  $scope.editProgram = function(index,data) {

    $('#edit_program_form').validationEngine('attach');
    
    data.index = index;

    $scope.sub = data;

    $('#edit-program-modal').modal('show');

  }
  
  $scope.updateProgram = function(data) {

    valid = $("#edit_program_form").validationEngine('validate');

    if(valid){

      $scope.data.ClassScheduleSub[data.index] = data;
      
      $('#edit-program-modal').modal('hide');

    }

  }
  
  $scope.removeProgram = function(index) {

    $scope.data.ClassScheduleSub.splice(index,1);

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      ClassSchedule.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/class-schedule';

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