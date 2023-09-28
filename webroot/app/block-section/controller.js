app.controller('BlockSectionController', function($scope, BlockSection, Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getCollegeProgram = function(id){

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    BlockSection.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.paginator = e.paginator;

        $scope.conditionsPrint = e.conditionsPrint;

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

    $scope.year_term_id = null;

    $scope.college_id = null;

    $scope.program_id = null;

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

    $scope.year_term_id = null;

    $scope.college_id = null;

    $scope.program_id = null;

    if($scope.search.year_term_id != undefined || $scope.search.year_term_id != null){

      $scope.year_term_id = $scope.search.year_term_id;

    }

    if($scope.search.college_id != undefined || $scope.search.college_id != null){

      $scope.college_id = $scope.search.college_id;

    }

    if($scope.search.program_id != undefined || $scope.search.program_id != null){

      $scope.program_id = $scope.search.program_id;

    }

    $scope.load({

      year_term_id  : $scope.year_term_id,

      college_id    : $scope.college_id,

      program_id    : $scope.program_id,

    });

    $('#advance-search-modal').modal('hide');

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        BlockSection.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/block_sections?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/block_sections?print=1');

    }

  }

});
app.controller('BlockSectionAddController', function($scope, BlockSection, Select) {

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

  });

 $('.yearpicker').datepicker({

    format: "yyyy",

    autoclose: true,

    minViewMode: "years",

    pickTime: false

  });

  $scope.data = {

    BlockSection : {},

    BlockSectionCourse : []

  };

  Select.get({code: 'class-schedule-code'}, function(e) {

    $scope.data.BlockSection.code = e.data;

  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  Select.get({ code: 'section-list' },function(e){

    $scope.sections = e.data;

  });

  Select.get({ code: 'room-list' },function(e){

    $scope.rooms = e.data;

  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getCollegeProgram = function(id){

    if($scope.colleges.length > 0){

      $.each($scope.colleges, function(i,val){

        if(val.id == id){

          $scope.data.BlockSection.college = val.value;

        }

      });

    }

    Select.get({ code: 'faculty-list', id : id }, function(e) {

      $scope.faculties = e.data;

    });

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.getProgram = function(id){

    if($scope.programs.length > 0){

      $.each($scope.programs, function(i,val){

        if(val.id == id){

          $scope.data.BlockSection.program = val.value;

        }

      });

      Select.get({ code: 'program-course-list', id : id },function(e){

        $scope.courses = e.data;

      });

    }

  }

  $scope.getSection = function(id){

    if($scope.sections.length > 0){

      $.each($scope.sections, function(i,val){

        if(val.id == id){

          $scope.data.BlockSection.section = val.value;

        }

      });

    }

  }

  $scope.getCourse = function(id){

    if($scope.courses.length > 0){

      $.each($scope.courses, function(i,val){

        if(val.course_id == id){

          $scope.sub.course = val.value;

        }

      });

    }

  }

  $scope.getFaculty = function(id){

    if($scope.faculties.length > 0){

      $.each($scope.faculties, function(i,val){

        if(val.id == id){

          $scope.sub.faculty_name = val.value;

        }

      });

    }

  }

  $scope.getRoom = function(id){

    if($scope.rooms.length > 0){

      $.each($scope.rooms, function(i,val){

        if(val.id == id){

          $scope.sub.room = val.value;

        }

      });

    }

  }

  $scope.addCourse = function() {

    $('#course_form').validationEngine('attach');
    
    $scope.sub = {};

    $('#add-course-modal').modal('show');

  }
  
  $scope.saveCourse = function(data) {

    valid = $("#course_form").validationEngine('validate'); 

    if(valid){

      $scope.data.BlockSectionCourse.push(data); 

      $('#add-course-modal').modal('hide');

    }

  }

  $scope.editCourse = function(index,data) {

    $('#edit_course_form').validationEngine('attach');

    $scope.index = index;

    data.index = index;

    $scope.sub = data;


    $('#edit-course-modal').modal('show');

  }
  
  $scope.updateCourse = function(data) {

    valid = $("#edit_course_form").validationEngine('validate');

    if(valid){

      $scope.data.BlockSectionCourse[data.index] = data; 

      $('#edit-course-modal').modal('hide');

    }

  }
  
  $scope.removeCourse = function(index) {

    $scope.data.BlockSectionCourse.splice(index,1);

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      BlockSection.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/block-section';

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

app.controller('BlockSectionEditController', function($scope, $routeParams, BlockSection, Select) {
  
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

  });

  $('.yearpicker').datepicker({

    format: "yyyy",

    autoclose: true,

    minViewMode: "years",

    pickTime: false

  });

  $scope.data = {

    BlockSection : {},

    BlockSectionCourse : []

  };

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  Select.get({ code: 'section-list' },function(e){

    $scope.sections = e.data;

  });

  Select.get({ code: 'room-list' },function(e){

    $scope.rooms = e.data;

  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  // load 

  $scope.load = function() {

    BlockSection.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.get({ code: 'application-program-list', college_id : $scope.data.BlockSection.college_id }, function(e) {

        $scope.programs = e.data;

      });

      Select.get({ code: 'faculty-list', id : $scope.data.BlockSection.college_id }, function(e) {

        $scope.faculties = e.data;

      });

      Select.get({ code: 'program-course-list', id : $scope.data.BlockSection.program_id },function(e){

        $scope.courses = e.data;

      });

    });

  }

  $scope.load();

  $scope.getCollegeProgram = function(id){

    if($scope.colleges.length > 0){

      $.each($scope.colleges, function(i,val){

        if(val.id == id){

          $scope.data.BlockSection.college = val.value;

        }

      });

    }

    Select.get({ code: 'faculty-list', id : id }, function(e) {

      $scope.faculties = e.data;

    });

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.getProgram = function(id){

    if($scope.programs.length > 0){

      $.each($scope.programs, function(i,val){

        if(val.id == id){

          $scope.data.BlockSection.program = val.value;

        }

      });

      Select.get({ code: 'program-course-list', id : id },function(e){

        $scope.courses = e.data;

      });

    }

  }

  $scope.getSection = function(id){

    if($scope.sections.length > 0){

      $.each($scope.sections, function(i,val){

        if(val.id == id){

          $scope.data.BlockSection.section = val.value;

        }

      });

    }

  }

  $scope.getCourse = function(id){

    if($scope.courses.length > 0){

      $.each($scope.courses, function(i,val){

        if(val.course_id == id){

          $scope.sub.course = val.value;

          $scope.sub.course_code = val.course_code;

        }

      });

    }

  }

  $scope.getFaculty = function(id){

    if($scope.faculties.length > 0){

      $.each($scope.faculties, function(i,val){

        if(val.id == id){

          $scope.sub.faculty_name = val.value;

        }

      });

    }

  }

  $scope.getRoom = function(id){

    if($scope.rooms.length > 0){

      $.each($scope.rooms, function(i,val){

        if(val.id == id){

          $scope.sub.room = val.value;

        }

      });

    }

  }

  $scope.addCourse = function() {

    $('#course_form').validationEngine('attach');
    
    $scope.sub = {};

    $('#add-course-modal').modal('show');

  }
  
  $scope.saveCourse = function(data) {

    valid = $("#course_form").validationEngine('validate'); 

    if(valid){

      $scope.data.BlockSectionCourse.push(data); 

      $('#add-course-modal').modal('hide');

    }

  }

  $scope.editCourse = function(index,data) {

    $('#edit_course_form').validationEngine('attach');

    $scope.index = index;

    data.index = index;

    $scope.sub = data;


    $('#edit-course-modal').modal('show');

  }
  
  $scope.updateCourse = function(data) {

    valid = $("#edit_course_form").validationEngine('validate');

    if(valid){

      $scope.data.BlockSectionCourse[data.index] = data; 

      $('#edit-course-modal').modal('hide');

    }

  }
  
  $scope.removeCourse = function(index) {

    $scope.data.BlockSectionCourse.splice(index,1);

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      BlockSection.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/block-section';

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

app.controller('BlockSectionViewController', function($scope, $routeParams, BlockSection, BlockSectionCourse, Select) {
  
  $scope.id = $routeParams.id;

  $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

 $scope.data = {

  BlockSectionCourse : []

 }

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  });

 Select.get({ code: 'faculty-list' },function(e){

    $scope.faculties = e.data;

  });

  // load 

  $scope.load = function() {

    BlockSection.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.BlockSectionCourse = e.BlockSectionCourse;
      
    });

  }

  $scope.addFaculty = function(index) {

    $('#faculty_form').validationEngine('attach');
    
    $scope.sub = {};

    $scope.index = index

    $('#add-faculty-modal').modal('show');

  }

  $scope.getFaculty = function(id){

    if($scope.faculties.length > 0){

      $.each($scope.faculties, function(i,val){

        if(val.id == id){

          $scope.sub.faculty_name = val.value;

        }

      });

    }

  }

  $scope.saveFaculty = function(data) {

    valid = $("#faculty_form").validationEngine('validate'); 

    if(valid){

      // $scope.data.BlockSectionCourse.push({

      //   course_id : $scope.data.BlockSectionCourse.course_id,

      //   faculty_id : data.faculty_id,

      //   faculty_name : data.faculty_name

      // }); 


      bootbox.confirm('Are you sure with the selected faculty member?' , function(c){

        if(c) {

          $scope.data.BlockSectionCourse[$scope.index].faculty_id = data.faculty_id

          $scope.data.BlockSectionCourse[$scope.index].faculty_name = data.faculty_name

          BlockSectionCourse.update($scope.data.BlockSectionCourse[$scope.index], function(e){

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text: e.msg

              });

              $scope.load();

            }

          });

        }

      });

    }

    $('#add-faculty-modal').modal('hide');

  }

  $scope.load();

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        BlockSection.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/block-section";

          }

        });

      }

    });

  } 

});

app.controller('BlockSectionScheduleViewController', function($scope, $routeParams, Select, BlockSectionScheduleView, BlockSectionScheduleAdd, BlockSectionScheduleDelete) {
  
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

  // load 


  $scope.load = function() {

    BlockSectionScheduleView.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

    Select.get({ code: 'block-section-schedules' },function(e){

      $scope.schedules = e.data;

    });

  }



  $scope.load();




    function timeToMinutes(time) {
      // Split the time string into hours and minutes
      const [hourString, minutes, ampm] = time.match(/(\d+):(\d+)\s(AM|PM)/).slice(1);
      let hours = parseInt(hourString, 10);

      // Determine if it's AM or PM and adjust the hours accordingly
      if (ampm === 'PM' && hours !== 12) {
        hours += 12;
      } else if (ampm === 'AM' && hours === 12) {
        hours = 0;
      }

      // Calculate the total minutes since midnight
      return hours * 60 + parseInt(minutes, 10);
    }






  $scope.addSchedule = function() { 

    Select.get({ code: 'block-section', id: $scope.data.BlockSectionCourse.block_section_id },function(e){

      $scope.section = e.data;

    });

    $('#add_schedule').validationEngine('attach');

    $scope.adata = {};

    $('#add-schedule-modal').modal('show');

  }

  $scope.saveSchedule = function(data) {

    valid = $('#add_schedule').validationEngine('validate');

    $scope.adata.block_section_course_id = $scope.id;

    if (valid) {

      // bootbox.confirm('Are you sure you want to save schedule?', function(c) {

      //   if(c) {

          let validTime = true;

          let sectionId = $scope.section.section_id;

          let section = $scope.section.section;

          let year = $scope.section.school_year_start;

          const input_time_end = timeToMinutes(data.time_end)

          const input_time_start = timeToMinutes(data.time_start)

          let data_time_start = ""

          let data_time_end = ""

              if($scope.schedules.length > 0){

                  angular.forEach($scope.schedules, function(schedValue,schedKey){

                    if(schedValue.day == data.day && year == schedValue.year_start){

                      data_time_start = timeToMinutes(schedValue.time_start)

                      data_time_end = timeToMinutes(schedValue.time_end)

                      if($scope.data.BlockSectionCourse.room_id === schedValue.room_id || sectionId === schedValue.section_id){

                        let reason = `${schedValue.room} - ${schedValue.section}`

                          if (input_time_start < data_time_end && input_time_end > data_time_start){

                            validTime = false

                              $.gritter.add({

                                    title: 'Warning!',

                                    text: `The schedule is conflict to ${reason} ${schedValue.day}  ${schedValue.time_start} - ${schedValue.time_end}`

                              });

                          }

                      }

                    }

                  })

                }        

          if(validTime){

            $scope.adata.room = $scope.data.BlockSectionCourse.room;

            $scope.adata.room_id = $scope.data.BlockSectionCourse.room_id;

            $scope.adata.section = section;

            $scope.adata.section_id = sectionId;

            $scope.adata.year_start = $scope.section.school_year_start;

            $scope.adata.year_end = $scope.section.school_year_end;

            BlockSectionScheduleAdd.save($scope.adata, function(e) {

            if(e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text: e.msg,

              });

              $scope.load();

            }

          });

            $('#add-schedule-modal').modal('hide');

          }

      //   }

      // });

    }

  }

  $scope.editSchedule = function(index, data) {


    $('#edit_schedule').validationEngine('attach');

    data.index = index;

    $scope.adata = data;

    $('#edit-schedule-modal').modal('show');

  }

  $scope.updateSchedule = function(data) {

    valid = $('#edit_schedule').validationEngine('validate');

    if (valid) {

      // bootbox.confirm('Are you sure you want to update schedule?', function(c) {

      //   if(c) {

          let validTime = true;

          const input_time_end = timeToMinutes(data.time_end)

          const input_time_start = timeToMinutes(data.time_start)

          let data_time_start = ""

          let data_time_end = ""

              if($scope.schedules.length > 0){

                  angular.forEach($scope.schedules, function(schedValue,schedKey){

                    if(data.id != schedValue.id){

                    if(schedValue.day == data.day && data.year_start == schedValue.year_start){

                      data_time_start = timeToMinutes(schedValue.time_start)

                      data_time_end = timeToMinutes(schedValue.time_end)

                      if(data.room_id === schedValue.room_id || data.section_id === schedValue.section_id){

                        let reason = `${schedValue.room} - ${schedValue.section}`

                          if (input_time_start < data_time_end && input_time_end > data_time_start) {

                              validTime = false

                              $.gritter.add({

                                    title: 'Warning!',

                                    text: `The schedule is conflict to ${reason} ${schedValue.day}  ${schedValue.time_start} - ${schedValue.time_end}`

                              });

                          }

                      }

                    }

                  }

                  })

                }   

    if(validTime){

          BlockSectionScheduleAdd.update({id:data.id}, data, function(e) {

            if(e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text: e.msg,

              });

              $scope.load();

            }else{

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,

            });

          }

          });

            $('#edit-schedule-modal').modal('hide');
          }

      //   }

      // });

    }

  }

  $scope.removeSchedule = function(data) {

    bootbox.confirm('Are you sure you want to remove this schedule?', function(c) {

      if (c) {

        BlockSectionScheduleDelete.save({ id: data.id },data, function(e) {

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

});

