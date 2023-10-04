app.controller("StudentClearanceController", function ($scope,Select, StudentClearance,StudentClearanceEmail,StudentClearanceClear) {

  $scope.today = Date.parse("today").toString("MM/dd/yyyy");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  Select.get({ code: 'college-program-list-all' },function(e){

    $scope.college_programs = e.data;

  });


  Select.get({ code: 'student-enrolled-courses' },function(e){

    $scope.enrolled_course = e.data;

  });

  $scope.getEnrolledCourse = function(id){

    $scope.course_id = id;

    $scope.load({

      course_id: $scope.course_id,

    });

  }

  $scope.getData = function(college_program_id){

    $scope.college_program_id = college_program_id;

    $scope.load({

      college_program_id: $scope.college_program_id

    });

  }

  $scope.roleId = currentUser.roleId;

  if(currentUser.roleId == 12 && currentUser.employee.academic_rank_id==2){

    $scope.pending = function(options) {

      options = typeof options !== 'undefined' ?  options : {};

      options['status'] = 0;

      options['course_id'] = $scope.course_id;

      StudentClearance.query(options, function(e) {

        if (e.ok) {

          $scope.datas = e.data;

          $scope.conditionsPrint = e.conditionsPrint;

          // paginator

          $scope.paginator  = e.paginator;

          $scope.pages = paginator($scope.paginator, 5);

        }

      });

    }

    $scope.cleared = function(options) {

      options = typeof options !== 'undefined' ?  options : {};

      options['status'] = 1;

      options['course_id'] = $scope.course_id;

      StudentClearance.query(options, function(e) {

        if (e.ok) {

          $scope.datasCleared = e.data;

          $scope.conditionsPrintCleared = e.conditionsPrint;

          // paginator

          $scope.paginatorCleared  = e.paginator;

          $scope.pagesCleared = paginator($scope.paginatorCleared, 5);

        }

      });

    }

    $scope.incomplete = function(options) {

      options = typeof options !== 'undefined' ?  options : {};

      options['status'] = 2;

      options['course_id'] = $scope.course_id;

      StudentClearance.query(options, function(e) {

        if (e.ok) {

          $scope.datasIncomplete = e.data;

          $scope.conditionsPrintIncomplete = e.conditionsPrint;

          // paginator

          $scope.paginatorIncomplete  = e.paginator;

          $scope.pagesIncomplete = paginator($scope.paginatorIncomplete, 5);

        }

      });

    }

    $scope.load = function(options) {

      $scope.pending(options);

      $scope.cleared(options);

      $scope.incomplete(options);

    }

  }else{

    $scope.load = function (options) {

      options = typeof options !== "undefined" ? options : {};

      StudentClearance.query(options, function (e) {

        if (e.ok) {

          $scope.datas = e.data;

          $scope.conditionsPrint = e.conditionsPrint;

          $scope.paginator = e.paginator;

          $scope.pages = paginator($scope.paginator, 5);

        }

      });

    };

  }
 
  $scope.reload = function (options) {

    $scope.search = {};

    $scope.searchTxt = "";

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;

    $scope.load();

  };

  $scope.searchy = function (search) {

    search = typeof search !== "undefined" ? search : "";

    if (search.length > 0) {

      $scope.load({

        search: search,

      });

    } else {

      $scope.load();

    }

  };

  $scope.remove = function (data) {

    bootbox.confirm("Are you sure you want to delete " + data.code + " ?",function (c) {

      if (c) {

        StudentClearance.remove({ id: data.id }, function (e) {

          if (e.ok) {

            $.gritter.add({

              title: "Successful!",

              text: e.msg,

            });

            $scope.load();

          }

        });

      }

    });

  };

  $scope.sendMail = function(data){  

    bootbox.prompt('Remarks: ', function(result){

      if(result){

        $scope.data = {

          remarks : result,

          course_id : $scope.course_id

        };

        StudentClearanceEmail.update({id:data.id},$scope.data, function(e){

          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text: e.msg

            });

            $scope.load();

          }

        });

      }

    });

  }

  $scope.print = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(

        base + "print/student_clearance?print=1" + $scope.conditionsPrint

      );

    } else {

      printTable(base + "print/student_clearance?print=1");

    }

  };

  if(currentUser.roleId != 23){

    if(currentUser.roleId ==25){

      $scope.clearStudent = function(data){  

        bootbox.confirm('Are you sure you want to approve the student clearance?', function(b){

          if(b) {

            Select.get({code: 'get-student', student_id : data.student_id },function(n){

              Select.get({ code: 'get-student-absent', student_id : n.data.id, year_term_id : n.data.year_term_id },function(q){

                $scope.count = q.data.length;

                // console.log($scope.count);

                if($scope.count==0){

                  // if($scope.count==5){

                  //   $.gritter.add({

                  //     title: 'Unable to clear Student!',

                  //     text:  'Student Dropped',

                  //   });


                  // }else{

                    StudentClearanceClear.update({id:data.id},$scope.data, function(e){

                      if(e.ok){

                        $.gritter.add({

                          title : 'Successful!',

                          text: e.msg

                        });

                        $scope.load();

                      }

                    });

                  // }

                }else{

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Student Dropped',

                  });

                }
                

              });

              $scope.data = {

                course_id : $scope.course_id

              };

            });

          }

        });

      }

    }else{

      $scope.clearStudent = function(data){  

        bootbox.confirm('Are you sure you want to approve the student clearance?', function(b){

          if(b) {

            $scope.data = {

              course_id : $scope.course_id

            };

            StudentClearanceClear.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text: e.msg

                });

                // $scope.loadPage();

                $scope.load();

              }

            });

          }

        });

      }

    }

  }else{

    $scope.clearStudent = function(data){  

      bootbox.confirm('Are you sure you want to approve the student clearance?', function(b){

        if(b) {

          $scope.data = {

            course_id : $scope.course_id

          };

          // console.log(data);

          Select.get({code: 'check-student-check-outs',student_id:data.student_id}, function(q) {

            // alert(q.data);

            if(q.data){

              StudentClearanceClear.update({id:data.id},$scope.data, function(e){

                if(e.ok){

                  $.gritter.add({

                    title : 'Successful!',

                    text: e.msg

                  });

                  $scope.load();

                }

              });

            }else{

              $.gritter.add({

                title: 'Warning!',

                text:  'Student still have some unreturned books.',

                
              });

            }

          }); 

        }

      });

    }

  }

  //RELOAD UPON CLEAR OF STUDENT

    // $scope.loadPage = function(){

    //   if(currentUser.roleId == 12 && currentUser.employee.academic_rank_id == 2){

    //     $scope.pending = function(options) {

    //       options = typeof options !== 'undefined' ?  options : {};

    //       options['status'] = 0;

    //       options['course_id'] = $scope.course_id;

    //       StudentClearance.query(options, function(e) {

    //         if (e.ok) {

    //           $scope.datas = e.data;

    //           $scope.conditionsPrint = e.conditionsPrint;

    //           // paginator

    //           $scope.paginator  = e.paginator;

    //           $scope.pages = paginator($scope.paginator, 5);

    //         }

    //       });

    //     }

    //     $scope.cleared = function(options) {

    //       options = typeof options !== 'undefined' ?  options : {};

    //       options['status'] = 1;

    //       options['course_id'] = $scope.course_id;

    //       StudentClearance.query(options, function(e) {

    //         if (e.ok) {

    //           $scope.datasCleared = e.data;

    //           $scope.conditionsPrintCleared = e.conditionsPrint;

    //           // paginator

    //           $scope.paginatorCleared  = e.paginator;

    //           $scope.pagesCleared = paginator($scope.paginatorCleared, 5);

    //         }

    //       });

    //     }

    //     $scope.incomplete = function(options) {

    //       options = typeof options !== 'undefined' ?  options : {};

    //       options['status'] = 2;

    //       options['course_id'] = $scope.course_id;

    //       StudentClearance.query(options, function(e) {

    //         if (e.ok) {

    //           $scope.datasIncomplete = e.data;

    //           $scope.conditionsPrintIncomplete = e.conditionsPrint;

    //           // paginator

    //           $scope.paginatorIncomplete  = e.paginator;

    //           $scope.pagesIncomplete = paginator($scope.paginatorIncomplete, 5);

    //         }

    //       });

    //     }

    //     $scope.pending([]);

    //     $scope.cleared([]);

    //     $scope.incomplete([]);

    //   }else{

    //     $scope.load = function (options) {

    //       options = typeof options !== "undefined" ? options : {};

    //       StudentClearance.query(options, function (e) {

    //         if (e.ok) {

    //           $scope.datas = e.data;

    //           $scope.conditionsPrint = e.conditionsPrint;

    //           $scope.paginator = e.paginator;

    //           $scope.pages = paginator($scope.paginator, 5);

    //         }

    //       });

    //     };

    //   }

    // }

  //endDate

});

app.controller("StudentClearanceAddController", function ($scope, StudentClearance, Select) {

  $("#form").validationEngine("attach");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $(".clockpicker").clockpicker({

    donetext: "Done",

    twelvehour: true,

    placement: "bottom",

  });

  $scope.data = {

    StudentClearance: {},

  };

  Select.get({ code: "student-clearance-code" }, function (e) {

    $scope.data.StudentClearance.code = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

      program_id: student.program_id,

      year_term_id: student.year_term_id,

      school_year: student.school_year,

    };

  };

  $scope.studentData = function (id) {

    $scope.data.StudentClearance.student_id = $scope.student.id;

    $scope.data.StudentClearance.student_name = $scope.student.name;

    $scope.data.StudentClearance.student_no = $scope.student.code;

    $scope.data.StudentClearance.course_id = $scope.student.program_id;

    $scope.data.StudentClearance.year_term_id = $scope.student.year_term_id;

    $scope.data.StudentClearance.school_year = $scope.student.school_year;

  };

  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      StudentClearance.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/faculty/student-clearance";

        } else {

          $.gritter.add({

            title: "Warning!",

            text: e.msg,

          });

        }

      });

    }

  };

});

app.controller("StudentClearanceViewController", function ($scope, $routeParams, StudentClearance) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {

    StudentClearance.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.print = function (id) {

    printTable(base + "print/student_clearance_form/" + id);

  };

  // remove
  $scope.remove = function (data) {

    bootbox.confirm("Are you sure you want to remove " + data.code + " ?",function (c) {

      if (c) {

        StudentClearance.remove({ id: data.id }, function (e) {

          if (e.ok) {

            $.gritter.add({

              title: "Successful!",

              text: e.msg,

            });

            window.location = "#/faculty/student-clearance";
          }

        });

      }

    });

  };

});

app.controller("StudentClearanceEditController", function ($scope, $routeParams, StudentClearance, Select) {

  $scope.id = $routeParams.id;

  $("#form").validationEngine("attach");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $(".clockpicker").clockpicker({

    donetext: "Done",

    twelvehour: true,

    placement: "bottom",

  });

  $scope.data = {

    StudentClearance: {},

  };

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  // load

  $scope.load = function () {

    StudentClearance.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

    };

  };

  $scope.studentData = function (id) {

    $scope.data.StudentClearance.student_id = $scope.student.id;

    $scope.data.StudentClearance.student_name = $scope.student.name;

    $scope.data.StudentClearance.student_no = $scope.student.code;

  };

  $scope.load();

  $scope.update = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      StudentClearance.update({ id: $scope.id }, $scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/faculty/student-clearance";

        } else {

          $.gritter.add({

            title: "Warning!",

            text: e.msg,

          });

        }

      });

    }

  };

});

app.controller("StudentClearanceFacultyAddController", function ($scope, StudentClearance, Select) {

  $("#form").validationEngine("attach");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $(".clockpicker").clockpicker({

    donetext: "Done",

    twelvehour: true,

    placement: "bottom",

  });

  $scope.data = {

    StudentClearance: {},

  };

  Select.get({ code: "student-clearance-code" }, function (e) {

    $scope.data.StudentClearance.code = e.data;

  });

  Select.get({ code: "course-list" }, function (e) {

    $scope.course = e.data;

  });

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

    };

  };

  $scope.studentData = function (id) {

    $scope.data.StudentClearance.student_id = $scope.student.id;

    $scope.data.StudentClearance.student_name = $scope.student.name;

    $scope.data.StudentClearance.student_no = $scope.student.code;

  };

  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      StudentClearance.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/faculty/student-clearance/faculty-index";

        } else {

          $.gritter.add({

            title: "Warning!",

            text: e.msg,

          });

        }

      });

    }

  };

});

app.controller("StudentClearanceFacultyViewController", function ($scope, $routeParams, StudentClearance) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {

    StudentClearance.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.print = function (id) {

    printTable(base + "print/student_clearance_form/" + id);

  };

  // remove
  $scope.remove = function (data) {

    bootbox.confirm("Are you sure you want to remove " + data.code + " ?",function (c) {

      if (c) {

        StudentClearance.remove({ id: data.id }, function (e) {

          if (e.ok) {

            $.gritter.add({

              title: "Successful!",

              text: e.msg,

            });

            window.location = "#/faculty/student-clearance";
          }

        });

      }

    });

  };

});

app.controller("StudentClearanceDeanAddController", function ($scope, StudentClearance, Select) {

  $("#form").validationEngine("attach");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $(".clockpicker").clockpicker({

    donetext: "Done",

    twelvehour: true,

    placement: "bottom",

  });

  $scope.data = {

    StudentClearance: {},

  };

  Select.get({ code: "student-clearance-code" }, function (e) {

    $scope.data.StudentClearance.code = e.data;

  });

  Select.get({ code: "course-list" }, function (e) {

    $scope.course = e.data;

  });

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

    };

  };

  $scope.studentData = function (id) {

    $scope.data.StudentClearance.student_id = $scope.student.id;

    $scope.data.StudentClearance.student_name = $scope.student.name;

    $scope.data.StudentClearance.student_no = $scope.student.code;

  };

  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      StudentClearance.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/faculty/student-clearance/dean-index";

        } else {

          $.gritter.add({

            title: "Warning!",

            text: e.msg,

          });

        }

      });

    }

  };

});

app.controller("StudentClearanceDeanViewController", function ($scope, $routeParams, StudentClearance) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {

    StudentClearance.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.print = function (id) {

    printTable(base + "print/student_clearance_form/" + id);

  };

  // remove
  $scope.remove = function (data) {

    bootbox.confirm("Are you sure you want to remove " + data.code + " ?",function (c) {

      if (c) {

        StudentClearance.remove({ id: data.id }, function (e) {

          if (e.ok) {

            $.gritter.add({

              title: "Successful!",

              text: e.msg,

            });

            window.location = "#/faculty/student-clearance";
          }

        });

      }

    });

  };

});