app.controller('SelfEnrollController', function($scope,Student,StudentRegistration,PreregistrationSubject,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.data = {

    Student : {},

    YearLevelTerm : []

  }

  Select.get({ code: 'student-academic-term-list' },function(e){

    $scope.academic_terms = e.data;

    Student.get({ id: e.studentId }, function(response) {

      $scope.data = response.data;

      $scope.check = response.check;

      $scope.regular = response.regular;

      $scope.show_subject = false;

      $scope.data.YearLevelTerm = [];

      if($scope.academic_terms.length > 0){

        $scope.data.Student.academic_term_id = $scope.academic_terms[0].id;
        
      }

      if(!$scope.check){

        Select.get({ code : 'close-student-curriculum-course-list',curriculum_id : $scope.data.Student.curriculum_id,academic_term_id : $scope.data.Student.academic_term_id }, function(e) {

          $scope.data.YearLevelTerm = e.data;

        });

      }else{
        
        Select.get({ code : 'open-student-curriculum-course-list',curriculum_id : $scope.data.Student.curriculum_id,academic_term_id : $scope.data.Student.academic_term_id }, function(e) {

          $scope.data.YearLevelTerm = e.data;

        });

      }
        
      Select.get({ code : 'student-assessment-list',feesID : response.feesID,yeartermID : response.yeartermID,student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id }, function(e) {

        $scope.data.StudentAssessment = e.data.TableOfFeeItem;

        $scope.data.Student.assess_fee = e.data.total;

      });

      $scope.data.Student.year_term_id = response.yeartermID != '' ? response.yeartermID : 1;

      $scope.data.Student.feesID = response.feesID;

    });

  });
  
  $scope.load = function(){

    Student.get({ id: $scope.data.Student.id }, function(response) {

      $scope.data = response.data;

      $scope.check = response.check;

      $scope.regular = response.regular;

      $scope.data.YearLevelTerm = [];

      if($scope.academic_terms.length > 0){

        $scope.data.Student.academic_term_id = $scope.academic_terms[0].id;
        
      }

      if(!$scope.check){

        Select.get({ code : 'close-student-curriculum-course-list',curriculum_id : $scope.data.Student.curriculum_id,academic_term_id : $scope.data.Student.academic_term_id }, function(e) {

          $scope.data.YearLevelTerm = e.data;

        });

      }else{
        
        Select.get({ code : 'open-student-curriculum-course-list',curriculum_id : $scope.data.Student.curriculum_id,academic_term_id : $scope.data.Student.academic_term_id }, function(e) {

          $scope.data.YearLevelTerm = e.data;

        });

      }

      Select.get({ code : 'get-total-list',student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id }, function(e) {

        $scope.ffsemcount = e.data.ffsemcount;

        $scope.cunits_total = e.data.cunits_total;

        $scope.lecunits_total = e.data.lecunits_total;

        $scope.labunits_total = e.data.labunits_total;

      });
        
      Select.get({ code : 'student-assessment-list',feesID : response.feesID,yeartermID : response.yeartermID,student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id }, function(e) {

        $scope.data.StudentAssessment = e.data.TableOfFeeItem;

        $scope.data.Student.assess_fee = e.data.total;

      });

      $scope.data.Student.year_term_id = response.yeartermID != '' ? response.yeartermID : 1;

      $scope.data.Student.feesID = response.feesID;

    });

  }

  $scope.showSubject = function(){

    Select.get({ code : 'get-total-list',student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id }, function(e) {

      $scope.ffsemcount = e.data.ffsemcount;

      $scope.cunits_total = e.data.cunits_total;

      $scope.lecunits_total = e.data.lecunits_total;

      $scope.labunits_total = e.data.labunits_total;

    });

    $(document).ready(function(){   

      $("#loading-modal").modal({backdrop: 'static', keyboard: false, show:true});

    });

    setTimeout(function() {  
   
      $('.alert').hide();
          
      $("#loading-modal").modal("hide");    

    },3000);

    $scope.show_subject = true;

  }
  
  $scope.addSubject = function(subject){

    bootbox.confirm('Are you sure you want to add subject ' + subject.title +' ?', function(c) {

      if (c) {

        Select.get({ code : 'validate-registration',student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id }, function(e) {

          holder = e.data;

          holder.course = subject.course_id;

          holder.coursesched = subject.course_schedule_id;

          if (e.data.ok) {

            if(holder.year_term_id != "" && holder.year_term_id != null && holder.year_term_id != undefined){
          
              if(holder.course != "" && holder.course != null && holder.course != undefined){
              
                if(holder.coursesched != "" && holder.coursesched != null && holder.coursesched != undefined){

                  Select.get({ code : 'validate-prereg-max-unit',student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id,schedule_id : holder.coursesched }, function(response) {

                    if (response.data.ok) {

                      Select.get({ code : 'validate-duplicate-course',student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id,course_id : holder.course,year_term_id : holder.year_term_id }, function(respo) {

                        if (respo.data.ok) {
                            
                          var returnvalue = respo.data.value.split(";");

                          var string = returnvalue[1];

                          var substring = "Subject already taken last";

                          if(string.indexOf(substring) != -1){

                            Select.get({ code : 'validate-schedule',student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id,course_schedule_id : holder.coursesched,year_term_id : holder.year_term_id }, function(resultset) {
                                  
                              if (resultset.data.ok) {

                                var array = resultset.data.result.split(';');

                                if(array[0] == 'False'){

                                  $.gritter.add({

                                    title: 'Warning!',

                                    text:  'Conflict schedule.' + '<br>' + array[1]

                                  });

                                }else{

                                  Select.get({ code : 'validate-course-size',course_schedule_id : holder.coursesched }, function(final) {
                                  
                                    if (final.data.ok) {

                                      $scope.entry = {

                                        student_id : $scope.data.Student.id,

                                        year_term_id : holder.year_term_id,
                                        
                                        academic_term_id : $scope.data.Student.academic_term_id,

                                        course_schedule_id : holder.coursesched,

                                        course_id : holder.course,

                                      }

                                      PreregistrationSubject.save($scope.entry, function(save) {

                                        if (save.ok) {

                                          $.gritter.add({

                                            title: 'Successful!',

                                            text: save.msg,

                                          });

                                          $scope.load();

                                        } else {

                                          $.gritter.add({

                                            title: 'Warning!',

                                            text:  save.msg,

                                          });

                                        }

                                      });
                                    
                                    }else{

                                      $.gritter.add({

                                        title: 'Warning!',

                                        text:  'This schedule this already full.'

                                      });

                                    }

                                  });

                                }

                              }

                            });                            

                          }else{

                            if(returnvalue[0] == "False"){

                              $.gritter.add({

                                title: 'Warning!',

                                text:  returnvalue[1]

                              });
                            
                            }else{

                              Select.get({ code : 'validate-schedule',student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id,course_schedule_id : holder.coursesched,year_term_id : holder.year_term_id }, function(resultset) {

                                if (resultset.data.ok) {

                                  var array = resultset.data.result.split(';');

                                  if(array[0] == 'False'){

                                    $.gritter.add({

                                      title: 'Warning!',

                                      text:  'Conflict schedule.' + '<br>' + array[1]

                                    });

                                  }else{

                                    Select.get({ code : 'validate-course-size',course_schedule_id : holder.coursesched }, function(final) {
                                    
                                      if (final.data.ok) {

                                        $scope.entry = {

                                          student_id : $scope.data.Student.id,

                                          year_term_id : holder.year_term_id,
                                          
                                          academic_term_id : $scope.data.Student.academic_term_id,

                                          course_schedule_id : holder.coursesched,

                                          course_id : holder.course,

                                        }

                                        PreregistrationSubject.save($scope.entry, function(save) {

                                          if (save.ok) {

                                            $.gritter.add({

                                              title: 'Successful!',

                                              text: save.msg,

                                            });

                                            $scope.load();

                                          } else {

                                            $.gritter.add({

                                              title: 'Warning!',

                                              text:  save.msg,

                                            });

                                          }

                                        });
                                      
                                      }else{

                                        $.gritter.add({

                                          title: 'Warning!',

                                          text:  'This schedule this already full.'

                                        });

                                      }

                                    });

                                  }

                                }

                              });    

                            }

                          }

                        }

                      });

                    }else{

                      $.gritter.add({

                        title: 'Warning!',

                        text:  response.data.msg,

                      });

                    }

                  });

                }else{

                  $.gritter.add({

                    title: 'Warning!',

                    text:  'Course schedule is empty.',

                  });

                }

              }else{

                $.gritter.add({

                  title: 'Warning!',

                  text:  'Course field is empty.',

                });

              }

            }else{

              $.gritter.add({

                title: 'Warning!',

                text:  'Year term field is empty.',

              });

            }

          }else{

            $.gritter.add({

              title: 'Warning!',

              text:  e.data.msg,

            });

          }

        });

        $(document).ready(function(){   

          $("#loading-modal-success").modal({backdrop: 'static', keyboard: false, show:true});

        });

        setTimeout(function() {  
       
          $('.alert').hide();
              
          $("#loading-modal-success").modal("hide");    

        },3000);

      }

    });

  }
  
  $scope.deleteSubject = function(subject){

    bootbox.confirm('Are you sure you want to delete subject ' + subject.Course.title_tmp +' ?', function(c) {

      if (c) {

        Select.get({ code : 'validate-delete-subject',student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id }, function(respo) {

          if(respo.data.ok){

            PreregistrationSubject.remove({ id: subject.id }, function(e) {

              if (e.ok) {

                $.gritter.add({

                  title: 'Successful!',

                  text:  e.msg,

                });

                $scope.load();

              }else{

                $.gritter.add({

                  title: 'Warning!',

                  text:  e.msg,

                });

              }

            });

            $(document).ready(function(){   

              $("#loading-modal-danger").modal({backdrop: 'static', keyboard: false, show:true});

            });

            setTimeout(function() {  
           
              $('.alert').hide();
                  
              $("#loading-modal-danger").modal("hide");    

            },3000);

          }else{

            $.gritter.add({

              title: 'Warning!',

              text:  respo.data.msg

            });

          }

        });

      }

    });

  }

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

    bootbox.confirm('Are you sure you want to delete ' + data.area +' ?', function(c) {

      if (c) {

        CourseArea.remove({ id: data.id }, function(e) {

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

  $scope.save = function(){
    
    if (confirm("Are you sure you want to save this registration?") == true) {

      Select.get({ code : 'validate-registration',student_id : $scope.data.Student.id,academic_term_id : $scope.data.Student.academic_term_id }, function(e) {

        if (e.data.ok) {

          $(document).ready(function(){            

            $("#loading-modal-warning").modal({backdrop: 'static', keyboard: false, show:true});

          });

          setTimeout(function() {
       
            $('.alert').hide();
                
            $("#loading-modal-warning").modal("hide");  

          },6000);

          StudentRegistration.save($scope.data, function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text:  e.msg,

              });

              $scope.load();

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

    }

  }

});