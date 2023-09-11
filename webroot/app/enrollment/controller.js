app.controller('EnrollmentController', function($scope,StudentEnrollment,Select,StudentApplication,Student) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.data = {

    StudentEnrollment : {},

    StudentEnrolledCourse : [],

    StudentEnrolledUnit : {},

    StudentEnrolledSchedule : [],

  }

  Select.get({ code: 'student-academic-term-list' },function(e){

    Student.get({ id: e.studentId }, function(response) {

      $scope.data = response.data;

      Select.get({ code: 'block-section-list', college_id : $scope.data.Student.college_id, program_id : $scope.data.Student.program_id, year_term_id : $scope.data.Student.year_term_id },function(e){

        $scope.datas = e.data;

      });

    });

  });

});

app.controller('EnrollmentAddController', function($scope, $routeParams, StudentEnrollment, Select, Student, BlockSection) {

  $scope.id = $routeParams.id;

  $('#form').validationEngine('attach');

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    BlockSectionCourse : [],

    StudentEnrolledCourse : []

  };

  Select.get({ code: 'student-academic-term-list' },function(e){

    Student.get({ id: e.studentId }, function(response) {

      $scope.data = response.data

      if($scope.data.StudentEnrolledUnit.length > 0){

        $.each($scope.data.StudentEnrolledUnit, function(i,val){

          if(val.year_term_id == $scope.data.Student.year_term_id){

            $scope.total_course = val.total_course;

            $scope.total_credit_unit = val.credit_unit;

            $scope.total_lecture_unit = val.lecture_unit;

            $scope.total_laboratory_unit = val.laboratory_unit;

          }

        });

      }else{

        $scope.total_course = 0;

        $scope.total_credit_unit = 0;

        $scope.total_lecture_unit = 0;

        $scope.total_laboratory_unit = 0;

      }

    });

  });

  Select.get({ code: 'block-section-enrollment', block_section_id : $scope.id },function(e){

    $scope.datas = e.data;

  });

  BlockSection.get({ id: $scope.id }, function(e) {

    $scope.blockSectionData = e.data;

  });

  $scope.addCourse = function(data, index){

    bootbox.confirm('Are you sure you want to add course ' + data.course +' ?', function(c) {

      if (c) {

        $scope.$apply(function() {

          $scope.datas[index].btn_status = 1;

          $scope.total_course += 1;

          $scope.total_credit_unit += parseFloat(data.credit_unit);

          $scope.total_lecture_unit += parseFloat(data.lecture_unit);

          $scope.total_laboratory_unit += parseFloat(data.laboratory_unit);

          $scope.data.StudentEnrolledCourse.push({

            block_section_course_id : data.id,

            student_id              : $scope.data.Student.id,

            course_id               : data.course_id,

            course_code             : data.course_code,

            course                  : data.course,

            section_id              : $scope.blockSectionData.BlockSection.section_id,

            section                 : $scope.blockSectionData.BlockSection.section,

            year_term_id            : $scope.data.YearLevelTerm.id,

            credit_unit             : data.credit_unit,

            lecture_unit            : data.lecture_unit,

            lecture_hours           : data.lecture_hours,

            laboratory_unit         : data.laboratory_unit,

            laboratory_hours        : data.laboratory_hours,

            faculty_id              : data.faculty_id,

            faculty_name            : data.faculty_name,

            index                   : index

          });

          if($scope.datas[index].schedules.length > 0){

            $.each($scope.datas[index].schedules, function(i,val){

              $scope.data.StudentEnrolledSchedule.push({

                student_id    : $scope.data.Student.id,

                course_id     : data.course_id,

                course        : data.course,

                block_section_schedule_id : val.id,

                faculty_id    : data.faculty_id,

                faculty_name  : data.faculty_name,

                year_term_id  : $scope.data.YearLevelTerm.id,

                day           : val.day,

                time_start    : val.time_start,

                time_end      : val.time_end,

                section_id    : $scope.blockSectionData.BlockSection.section_id,

                section       : $scope.blockSectionData.BlockSection.section,

                room_id       : data.room_id,

                room          : data.room,

              });

            });

          }

        });

      }

    });

  }

  $scope.removeCourse = function(data, index) {

    bootbox.confirm('Are you sure you want to remove course ' + data.course +' ?', function(c) {

      if (c) {

        $scope.$apply(function() {

          const filteredTimetable = $scope.data.StudentEnrolledSchedule.filter(item => item.course_id !== data.course_id);

          $scope.data.StudentEnrolledSchedule = filteredTimetable;

          $scope.total_course -= 1;

          $scope.total_credit_unit -= parseFloat(data.credit_unit);

          $scope.total_lecture_unit -= parseFloat(data.lecture_unit);

          $scope.total_laboratory_unit -= parseFloat(data.laboratory_unit);

          $scope.data.StudentEnrolledCourse.splice(index,1);

          $scope.datas[data.index].btn_status = 0;

        });

      }

    });

    

  }

  $scope.save = function(){
    
    if (confirm("Are you sure you want to save this registration?") == true) {

      if($scope.data.StudentEnrolledCourse.length > 0){

        Select.get({ code : 'validate-enrollment-registration',student_id : $scope.data.Student.id,year_term_id : $scope.data.YearLevelTerm.id }, function(e) {

          if (e.data.ok) {

            $scope.data.StudentEnrolledUnit.push({

              student_id        : $scope.data.Student.id,

              credit_unit       : $scope.total_credit_unit,

              lecture_unit      : $scope.total_lecture_unit,

              laboratory_unit   : $scope.total_laboratory_unit,

              total_course      : $scope.total_course,

              year_term_id      : $scope.data.YearLevelTerm.id

            });

            StudentEnrollment.save($scope.data, function(e) {
 
              if (e.ok) {

                $.gritter.add({

                  title: 'Successful!',

                  text:  e.msg,

                });

                window.location = '#/registrar/prospectus/view-student/'+$scope.data.Student.id;

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

              text:  'Already registered!',

            });

          }

        });

      }else{

        $.gritter.add({

          title: 'Warning!',

          text:  'No added course.',

        });

      }

    }

  }

});

app.controller('EnrollmentOldController', function($scope,StudentEnrollment,Select,StudentApplication,Student) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.data = {

    StudentEnrollment : {},

    StudentEnrolledCourse : [],

    StudentEnrolledUnit : {},

    StudentEnrolledSchedule : [],

  }

  Select.get({ code: 'student-academic-term-list' },function(e){

    Student.get({ id: e.studentId }, function(response) {

      $scope.data = response.data;

      $scope.data.StudentEnrollment = $scope.data.Student;

      //RESET DISPLAYED DATA BY YEAR TERM

        tmp = [];
        
        if($scope.data.StudentEnrolledSchedule.length > 0){

          $.each($scope.data.StudentEnrolledSchedule, function(i,val){

            if($scope.data.StudentEnrolledSchedule[i].year_term_id == $scope.data.Student.year_term_id){

              tmp.push($scope.data.StudentEnrolledSchedule[i]);

            }

          });

        }

        $scope.data.StudentEnrolledSchedule = tmp;

        tmp = [];
        
        if($scope.data.StudentEnrolledCourse.length > 0){

          $.each($scope.data.StudentEnrolledCourse, function(i,val){

            if($scope.data.StudentEnrolledCourse[i].year_term_id == $scope.data.Student.year_term_id){

              tmp.push($scope.data.StudentEnrolledCourse[i]);

            }

          });

        }

        $scope.data.StudentEnrolledCourse = tmp;

      //END

      Select.get({ code: 'student-enrollment-course', college_id : $scope.data.Student.college_id, program_id : $scope.data.Student.program_id, year_term_id : $scope.data.Student.year_term_id },function(e){

        $scope.courses = e.data;

      });

    });

  });

  // $scope.getId = function(sub_id, course_id){

  //   $scope.slot_bool = false;

  //   if($scope.courses.length > 0){

  //     $.each($scope.courses, function(i,val){

  //       if(val.course_id == course_id){

  //         if(val.schedule.length > 0){

  //           $.each(val.schedule, function(a,value){

  //             if(value.sub_id == sub_id){

  //               $scope.schedule_id = value.id;

  //               $scope.section_id = value.section_id;

  //               $scope.section = value.section;

  //               if(value.slot > 0){

  //                 $scope.slot_bool = true;

  //               }
                
  //             }

  //           });

  //         }

  //       }

  //     });

  //   }

  // }

  $scope.total_credit_unit = 0;

  $scope.total_lecture_unit = 0;

  $scope.total_laboratory_unit = 0;

  $scope.total_course = 0;

  $scope.disable = false;

  $scope.addCourse = function(data, subs){

    bootbox.confirm('Are you sure you want to add course ' + data.course +' ?', function(c) {

      if (c) {

        $scope.units = [];

        bool = true;

        bool2 = true;

        if($scope.data.StudentEnrolledSchedule.length > 0){

          $.each($scope.data.StudentEnrolledSchedule, function(i,val){

            if(subs.day_id == val.day_id){

              bool = false;

            }

          });

        }

        if(bool){

          $scope.data.StudentEnrolledSchedule.push({

            student_id   : $scope.data.Student.id,

            day_id       : subs.day_id,

            course_id    : data.course_id,

            course       : data.course,

            course_id    : data.course_id,

            faculty_id   : subs.faculty_id,

            faculty_name : subs.faculty_name,

            section_id   : subs.section_id,

            section      : subs.section,

            time_start   : subs.time_start,

            time_end     : subs.time_end,

            time         : subs.time,

            room_id      : subs.room_id,

            room         : subs.room,

            day          : subs.day,

            year_term_id : $scope.data.Student.year_term_id

          });

          Select.get({ code : 'get-course-unit',course_id : data.course_id }, function(e) {

            if($scope.data.StudentEnrolledCourse.length > 0){

              $.each($scope.data.StudentEnrolledCourse, function(i,val){

                if(data.course_id == val.course_id){

                  bool2 = false;

                }

              });

            }

            if(bool2){

              $scope.data.StudentEnrolledCourse.push({

                student_id            : $scope.data.Student.id,

                course_id             : data.course_id,

                course                : data.course,

                course_code           : data.course_code,

                class_schedule_id     : subs.id,

                class_schedule_sub_id : subs.sub_id,

                class_schedule_day_id : subs.day_id,

                class_schedule_code   : subs.code,

                section_id            : subs.section_id,

                section               : subs.section,

                year_term_id          : $scope.data.YearLevelTerm.id,

                credit_unit           : e.data[0].credit_unit,

                lecture_unit          : e.data[0].lecture_unit,

                lecture_hours         : e.data[0].lecture_hours,

                laboratory_unit       : e.data[0].laboratory_unit,

                laboratory_hours      : e.data[0].laboratory_unit,

                faculty_name          : subs.faculty_name,

              });

              $scope.total_credit_unit += parseFloat(e.data[0].credit_unit);

              $scope.total_lecture_unit += parseFloat(e.data[0].lecture_unit);

              $scope.total_laboratory_unit += parseFloat(e.data[0].laboratory_unit);

              $scope.total_course =  $scope.data.StudentEnrolledCourse.length;

              $scope.units.push({

                student_id      : $scope.data.Student.id,

                credit_unit     : $scope.total_credit_unit,

                lecture_unit    : $scope.total_lecture_unit,

                laboratory_unit : $scope.total_laboratory_unit,

                total_course    : $scope.total_course,

                year_term_id    : $scope.data.YearLevelTerm.id

              });

              $scope.data.StudentEnrolledUnit = $scope.units;

            }

          });

        }else{

          $.gritter.add({

            title: 'Warning!',

            text:  'Schedule already added',

          });

        }

      }

    });

  }

  $scope.removeSchedule = function(index,course_id) {

    $scope.data.StudentEnrolledSchedule.splice(index,1);

    count = 0;

    if($scope.data.StudentEnrolledSchedule.length > 0){

      $.each($scope.data.StudentEnrolledSchedule, function(i,val){

        if(course_id == val.course_id){

          count += 1;

        }

      });

    }

    remove = false;

    if($scope.data.StudentEnrolledCourse.length > 0){

      $.each($scope.data.StudentEnrolledCourse, function(i,val){

        if(course_id == val.course_id && count == 0){

          index_to_remove = i;

          remove = true;

          $scope.total_credit_unit -= parseFloat(val.credit_unit);

          $scope.total_lecture_unit -= parseFloat(val.lecture_unit);

          $scope.total_laboratory_unit -= parseFloat(val.laboratory_unit);

        }

      });

    }

    if(remove){

      $scope.data.StudentEnrolledCourse.splice(index_to_remove,1);

      $scope.total_course =  $scope.data.StudentEnrolledCourse.length;

    }

  }

  $scope.save = function(){
    
    if (confirm("Are you sure you want to save this registration?") == true) {

      if($scope.data.StudentEnrolledCourse.length > 0){

        Select.get({ code : 'validate-enrollment-registration',student_id : $scope.data.Student.id,year_term_id : $scope.data.YearLevelTerm.id }, function(e) {

          if (e.data.ok) {

            StudentEnrollment.save($scope.data, function(e) {

              if (e.ok) {

                $.gritter.add({

                  title: 'Successful!',

                  text:  e.msg,

                });

                window.location = '#/registrar/prospectus/view-student/'+$scope.data.Student.id;

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

              text:  'Already registered!',

            });

          }

        });

      }else{

        $.gritter.add({

          title: 'Warning!',

          text:  'No added course.',

        });

      }

    }

  }

});