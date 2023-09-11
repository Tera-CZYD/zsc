app.controller("ConsultationController", function ($scope, Consultation) {

  $scope.today = Date.parse("today").toString("MM/dd/yyyy");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    Consultation.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.approve = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 3;

    Consultation.query(options, function(e) {

      if (e.ok) {

        $scope.datasApprove = e.data;

        $scope.conditionsPrintApprove = e.conditionsPrint;

        $scope.paginatorApprove = e.paginator;

        $scope.pagesApprove = paginator($scope.paginatorApprove, 5);

      }

    });

  }
  $scope.disapprove = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 4;

    Consultation.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapprove = e.data;

        $scope.conditionsPrintDisapprove = e.conditionsPrint;

        $scope.paginatorDisapprove = e.paginator;

        $scope.pagesDisapprove = paginator($scope.paginatorDisapprove, 5);

      }

    });

  }
  $scope.treated = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 1;

    Consultation.query(options, function(e) {

      if (e.ok) {

        $scope.datasTreated = e.data;

        $scope.conditionsPrintTreated = e.conditionsPrint;

        // paginator

        $scope.paginatorTreated  = e.paginator;

        $scope.pagesTreated = paginator($scope.paginatorTreated, 5);

      }

    });

  }

  $scope.referred = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 2;

    Consultation.query(options, function(e) {

      if (e.ok) {

        $scope.datasReferred = e.data;

        $scope.conditionsPrintReferred = e.conditionsPrint;

        // paginator

        $scope.paginatorReferred  = e.paginator;

        $scope.pagesReferred = paginator($scope.paginatorReferred, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);
    $scope.approve(options);
    $scope.disapprove(options);

    $scope.treated(options);

    $scope.referred(options);

  }

  $scope.load();

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

  $scope.advance_search = function () {

    $scope.search = {};

    $scope.advanceSearch = false;

    $scope.position_id = null;

    $scope.office_id = null;

    $(".monthpicker").datepicker({

      format: "MM",

      autoclose: true,

      minViewMode: "months",

      maxViewMode: "months",

    });

    $(".input-daterange").datepicker({

      format: "yyyy-mm-dd",

    });

    $(".datepicker").datepicker("setDate", "");

    $(".monthpicker").datepicker("setDate", "");

    $(".input-daterange").datepicker("setDate", "");

    $("#advance-search-modal").modal("show");

  };

  $scope.searchFilter = function (search) {

    $scope.filter = false;

    $scope.advanceSearch = true;

    $scope.searchTxt = "";

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;

    if (search.filterBy == "today") {

      $scope.dateToday = Date.parse("today").toString("yyyy-MM-dd");

      $scope.today = Date.parse("today").toString("yyyy-MM-dd");

      $scope.dateToday = $scope.today;

      $scope.load({

        date: $scope.dateToday,

      });

    } else if (search.filterBy == "date") {

      $scope.dateToday = Date.parse(search.date).toString("yyyy-MM-dd");

      $scope.load({

        date: $scope.dateToday,

      });

    } else if (search.filterBy == "month") {

      date = $(".monthpicker").datepicker("getDate");

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = "0" + month;

      $scope.startDate = year + "-" + month + "-01";

      $scope.endDate = year + "-" + month + "-" + lastDay.getDate();

      $scope.load({

        startDate: $scope.startDate,

        endDate: $scope.endDate,

      });

    } else if (search.filterBy == "this-month") {

      date = new Date();

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = "0" + month;

      $scope.startDate = year + "-" + month + "-01";

      $scope.endDate = year + "-" + month + "-" + lastDay.getDate();

      $scope.load({

        startDate: $scope.startDate,

        endDate: $scope.endDate,

      });

    } else if (search.filterBy == "custom") {

      $scope.startDate = Date.parse(search.startDate).toString("yyyy-MM-dd");

      $scope.endDate = Date.parse(search.endDate).toString("yyyy-MM-dd");

    }

    $scope.load({

      date: $scope.dateToday,

      startDate: $scope.startDate,

      endDate: $scope.endDate,

    });

    $("#advance-search-modal").modal("hide");

  };

  $scope.remove = function (data) {

    bootbox.confirm(

      "Are you sure you want to delete " + data.code + " ?",

      function (c) {

        if (c) {

          Consultation.remove({ id: data.id }, function (e) {

            if (e.ok) {

              $.gritter.add({

                title: "Successful!",

                text: e.msg,

              });

              $scope.load();

            }

          });

        }

      }

    );

  };

  $scope.print = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/consultation?print=1" + $scope.conditionsPrint);

    } else {

      printTable(base + "print/consultation?print=1");

    }

  };

  $scope.printApprove = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/consultation?print=1" + $scope.conditionsPrintApprove);

    } else {

      printTable(base + "print/consultation?print=1");

    }

  };
  $scope.printDisapprove = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/consultation?print=1" + $scope.conditionsPrintDisapprove);

    } else {

      printTable(base + "print/consultation?print=1");

    }

  };


  $scope.printTreated = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/consultation?print=1" + $scope.conditionsPrintTreated);

    } else {

      printTable(base + "print/consultation?print=1");

    }

  };

  $scope.printReferred = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/consultation?print=1" + $scope.conditionsPrintReferred);

    } else {

      printTable(base + "print/consultation?print=1");

    }

  };

});

app.controller( "ConsultationAddController", function ($scope, Consultation, Select) {

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

    Consultation: {},

    ConsultationSub: [],

  };

  Select.get({ code: "ailment-list" }, function (e) {

    $scope.ailments = e.data;

  });

  Select.get({ code: "nurse-profile-list" }, function (e) {

    $scope.nurse_profile = e.data;

  });

  $scope.getNurse = function(id){

    if($scope.nurse_profile.length > 0){

      $.each($scope.nurse_profile, function(i,val){

        if(id == val.id){

          $scope.data.Consultation.nurse_name = val.value;

        }

      });

    }

  }

  $scope.getAilment = function(id){

    if($scope.ailments.length > 0){

      $.each($scope.ailments, function(i,val){

        if(id == val.id){

          $scope.adata.chief_complaints = val.value;

          Select.get({ code: "ailment-prescription-list", id : val.id }, function (e) {

            $scope.prescriptions = e.data;

          });

        }

      });

    }

  }

  $scope.getPrescription = function(id){

    if($scope.prescriptions.length > 0){

      $.each($scope.prescriptions, function(i,val){

        if(id == val.id){

          $scope.adata.treatments = val.value;

        }

      });

    }

  }

  Select.get({ code: "consultation" }, function (e) {

    $scope.data.Consultation.code = e.data;

  });

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.Consultation.employee_id = null;

      $scope.data.Consultation.employee_name = null;

    }else{

      $scope.data.Consultation.student_id = null;

      $scope.data.Consultation.student_name = null;

    }

  }

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

    $scope.data.Consultation.student_id = $scope.student.id;

    $scope.data.Consultation.student_name = $scope.student.name;

    $scope.data.Consultation.student_no = $scope.student.code;

  };

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

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.Consultation.employee_id = $scope.employee.id;

    $scope.data.Consultation.employee_no = $scope.employee.code;

    $scope.data.Consultation.employee_name = $scope.employee.name;

  }

  //add others modal

  $scope.addSubs = function () {

    $("#add_subs").validationEngine("attach");

    $scope.adata = {};

    $("#add-subs-modal").modal("show");

  };

  $scope.saveSubs = function (data) {

    valid = $("#add_subs").validationEngine("validate");

    if (valid) {

      $scope.data.ConsultationSub.push(data);

      console.log(data);

      $("#add-subs-modal").modal("hide");

    }

  };

  $scope.editSubs = function (index, data) {

    $("#edit_subs").validationEngine("attach");

    data.index = index;

    $scope.adata = data;

    $("#edit-subs-modal").modal("show");

  };

  $scope.updateSubs = function (data, index) {

    valid = $("#edit_subs").validationEngine("validate");

    if (valid) {

      $scope.data.ConsultationSub[data.index] = data;

      $("#edit-subs-modal").modal("hide");

    }

  };

  $scope.removeSubs = function (index) {

    $scope.data.ConsultationSub.splice(index, 1);

  };

  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      Consultation.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/medical-services/consultation";

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

app.controller("ConsultationViewController",function ($scope, $routeParams, Consultation, ConsultationTreated, ConsultationApprove, ConsultationDisapprove, ConsultationReferred) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {

    Consultation.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.treat = function(data){

    bootbox.confirm('Are you sure you want to mark patient as treated?', function(e){

      if(e) {

        ConsultationTreated.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

            window.location = "#/medical-services/consultation";

          }

        });

      }

    });

  }
  $scope.appr = function(data){

    bootbox.confirm('Are you sure you want to mark patient as Approve?', function(e){

      if(e) {

        ConsultationApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

            window.location = "#/medical-services/consultation";

          }

        });

      }

    });

  }
  $scope.disappr = function(data){  

    bootbox.confirm('Are you sure you want to disapprove appointment ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            ConsultationDisapprove.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Counseling Appointment has been disapproved.'

                });

                $scope.load();

                window.location = "#/medical-services/consultation";

              }

            });

          }

        });

      }

    });

  }
  $scope.refer = function(data){  

    bootbox.confirm('Are you sure you want to mark patient as referred?', function(b){

      if(b) {

        ConsultationReferred.update({id:data.id}, function(e){

          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text: e.msg

            });

            $scope.load();

            window.location = "#/medical-services/consultation";

          }

        });

      }

    });

  }

    $scope.print = function (id) {

      printTable(base + "print/consultation_form/" + id);

    };

    // remove
    $scope.remove = function (data) {

      bootbox.confirm(

        "Are you sure you want to remove " + data.code + " ?",

        function (c) {

          if (c) {

            Consultation.remove({ id: data.id }, function (e) {

              if (e.ok) {

                $.gritter.add({

                  title: "Successful!",

                  text: e.msg,

                });

                window.location = "#medical-services/consultation";

              }

            });

          }

        }

      );

    };

  }

);

app.controller("ConsultationEditController", function ($scope, $routeParams, Consultation, Select) {

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

    Consultation: {},

    ConsultationSub : []

  };

  $scope.bool = [

    { id: true, value: "Yes" },

    { id: false, value: "No" },

  ];

  Select.get({ code: "ailment-list" }, function (e) {

    $scope.ailments = e.data;

  });

  Select.get({ code: "nurse-profile-list" }, function (e) {

    $scope.nurse_profile = e.data;

  });

  $scope.getNurse = function(id){

    if($scope.nurse_profile.length > 0){

      $.each($scope.nurse_profile, function(i,val){

        if(id == val.id){

          $scope.data.Consultation.nurse_name = val.value;

        }

      });

    }

  }

  $scope.getAilment = function(id){

    if($scope.ailments.length > 0){

      $.each($scope.ailments, function(i,val){

        if(id == val.id){

          $scope.adata.chief_complaints = val.value;

          Select.get({ code: "ailment-prescription-list", id : val.id }, function (e) {

            $scope.prescriptions = e.data;

          });

        }

      });

    }

  }

  $scope.getPrescription = function(id){

    if($scope.prescriptions.length > 0){

      $.each($scope.prescriptions, function(i,val){

        if(id == val.id){

          $scope.adata.treatments = val.value;

        }

      });

    }

  }

  $scope.load = function () {

    Consultation.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      console.log(e);

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

    $scope.data.Consultation.student_id = $scope.student.id;

    $scope.data.Consultation.student_name = $scope.student.name;

    $scope.data.Consultation.student_no = $scope.student.code;

  };

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

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.Consultation.employee_id = $scope.employee.id;

    $scope.data.Consultation.employee_no = $scope.employee.code;

    $scope.data.Consultation.employee_name = $scope.employee.name;

  }

  //add others modal

  $scope.addSubs = function () {

    $("#add_subs").validationEngine("attach");

    $scope.adata = {};

    $("#add-subs-modal").modal("show");

  };

  $scope.saveSubs = function (data) {

    valid = $("#add_subs").validationEngine("validate");

    if (valid) {

      $scope.data.ConsultationSub.push(data);

      $("#add-subs-modal").modal("hide");

    }

  };

  $scope.editSubs = function (index, data) {

    Select.get({ code: "ailment-prescription-list", id : data.chief_complaint_id }, function (e) {

      $scope.prescriptions = e.data;

    });

    $("#edit_subs").validationEngine("attach");

    data.index = index;

    $scope.adata = data;

    $("#edit-subs-modal").modal("show");

  };

  $scope.updateSubs = function (data, index) {

    valid = $("#edit_subs").validationEngine("validate");

    if (valid) {

      $scope.data.ConsultationSub[data.index] = data;

      $("#edit-subs-modal").modal("hide");

    }

  };

  $scope.removeSubs = function (index) {

    $scope.data.ConsultationSub.splice(index,1);

  };

  $scope.update = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      Consultation.update({ id: $scope.id }, $scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/medical-services/consultation";

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

app.controller("StudentConsultationController", function ($scope, Consultation) {

  $scope.today = Date.parse("today").toString("MM/dd/yyyy");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 0;

    Consultation.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.approve = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 3;

    Consultation.query(options, function(e) {

      if (e.ok) {

        $scope.datasApprove = e.data;

        $scope.conditionsPrintApprove = e.conditionsPrint;

        $scope.paginatorApprove = e.paginator;

        $scope.pagesApprove = paginator($scope.paginatorApprove, 5);

      }

    });

  }

  $scope.disapprove = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 4;

    Consultation.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapprove = e.data;

        $scope.conditionsPrintDisapprove = e.conditionsPrint;

        $scope.paginatorDisapprove = e.paginator;

        $scope.pagesDisapprove = paginator($scope.paginatorDisapprove, 5);

      }

    });

  }

  $scope.treated = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 1;

    Consultation.query(options, function(e) {

      if (e.ok) {

        $scope.datasTreated = e.data;

        $scope.conditionsPrintTreated = e.conditionsPrint;

        // paginator

        $scope.paginatorTreated  = e.paginator;

        $scope.pagesTreated = paginator($scope.paginatorTreated, 5);

      }

    });

  }

  $scope.referred = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 2;

    Consultation.query(options, function(e) {

      if (e.ok) {

        $scope.datasReferred = e.data;

        $scope.conditionsPrintReferred = e.conditionsPrint;

        // paginator

        $scope.paginatorReferred  = e.paginator;

        $scope.pagesReferred = paginator($scope.paginatorReferred, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approve(options);

    $scope.disapprove(options);

    $scope.treated(options);

    $scope.referred(options);

  }

  $scope.load();

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

  $scope.advance_search = function () {

    $scope.search = {};

    $scope.advanceSearch = false;

    $scope.position_id = null;

    $scope.office_id = null;

    $(".monthpicker").datepicker({

      format: "MM",

      autoclose: true,

      minViewMode: "months",

      maxViewMode: "months",

    });

    $(".input-daterange").datepicker({

      format: "yyyy-mm-dd",

    });

    $(".datepicker").datepicker("setDate", "");

    $(".monthpicker").datepicker("setDate", "");

    $(".input-daterange").datepicker("setDate", "");

    $("#advance-search-modal").modal("show");

  };

  $scope.searchFilter = function (search) {

    $scope.filter = false;

    $scope.advanceSearch = true;

    $scope.searchTxt = "";

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;

    if (search.filterBy == "today") {

      $scope.dateToday = Date.parse("today").toString("yyyy-MM-dd");

      $scope.today = Date.parse("today").toString("yyyy-MM-dd");

      $scope.dateToday = $scope.today;

      $scope.load({

        date: $scope.dateToday,

      });

    } else if (search.filterBy == "date") {

      $scope.dateToday = Date.parse(search.date).toString("yyyy-MM-dd");

      $scope.load({

        date: $scope.dateToday,

      });

    } else if (search.filterBy == "month") {

      date = $(".monthpicker").datepicker("getDate");

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = "0" + month;

      $scope.startDate = year + "-" + month + "-01";

      $scope.endDate = year + "-" + month + "-" + lastDay.getDate();

      $scope.load({

        startDate: $scope.startDate,

        endDate: $scope.endDate,

      });

    } else if (search.filterBy == "this-month") {

      date = new Date();

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = "0" + month;

      $scope.startDate = year + "-" + month + "-01";

      $scope.endDate = year + "-" + month + "-" + lastDay.getDate();

      $scope.load({

        startDate: $scope.startDate,

        endDate: $scope.endDate,

      });

    } else if (search.filterBy == "custom") {

      $scope.startDate = Date.parse(search.startDate).toString("yyyy-MM-dd");

      $scope.endDate = Date.parse(search.endDate).toString("yyyy-MM-dd");

    }

    $scope.load({

      date: $scope.dateToday,

      startDate: $scope.startDate,

      endDate: $scope.endDate,

    });

    $("#advance-search-modal").modal("hide");

  };

  $scope.remove = function (data) {

    bootbox.confirm(

      "Are you sure you want to delete " + data.code + " ?",

      function (c) {

        if (c) {

          Consultation.remove({ id: data.id }, function (e) {

            if (e.ok) {

              $.gritter.add({

                title: "Successful!",

                text: e.msg,

              });

              $scope.load();

            }

          });

        }

      }

    );

  };

  $scope.print = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/consultation?print=1" + $scope.conditionsPrint);

    } else {

      printTable(base + "print/consultation?print=1");

    }

  };

  $scope.printApprove = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/consultation?print=1" + $scope.conditionsPrintApprove);

    } else {

      printTable(base + "print/consultation?print=1");

    }

  };
  $scope.printDisapprove = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/consultation?print=1" + $scope.conditionsPrintDisapprove);

    } else {

      printTable(base + "print/consultation?print=1");

    }

  };


  $scope.printTreated = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/consultation?print=1" + $scope.conditionsPrintTreated);

    } else {

      printTable(base + "print/consultation?print=1");

    }

  };

  $scope.printReferred = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/consultation?print=1" + $scope.conditionsPrintReferred);

    } else {

      printTable(base + "print/consultation?print=1");

    }

  };

});

app.controller( "StudentConsultationAddController", function ($scope, Consultation, Select, Student) {

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

    Consultation: {},

    ConsultationSub: [],

  };

  Select.get({ code: "ailment-list" }, function (e) {

    $scope.ailments = e.data;

  });

 Select.get({ code: "nurse-profile-list" }, function (e) {

    $scope.nurse_profile = e.data;

  });

  $scope.getNurse = function(id){

    if($scope.nurse_profile.length > 0){

      $.each($scope.nurse_profile, function(i,val){

        if(id == val.id){

          $scope.data.Consultation.nurse_name = val.value;

        }

      });

    }

  }

  $scope.getAilment = function(id){

    if($scope.ailments.length > 0){

      $.each($scope.ailments, function(i,val){

        if(id == val.id){

          $scope.adata.chief_complaints = val.value;

          Select.get({ code: "ailment-prescription-list", id : val.id }, function (e) {

            $scope.prescriptions = e.data;

          });

        }

      });

    }

  }

  $scope.getPrescription = function(id){

    if($scope.prescriptions.length > 0){

      $.each($scope.prescriptions, function(i,val){

        if(id == val.id){

          $scope.adata.treatments = val.value;

        }

      });

    }

  }

  Select.get({ code: "consultation" }, function (e) {

    $scope.data.Consultation.code = e.data;

    Student.get({ id: e.studentId }, function(response) {

      $scope.data.Consultation.student_id = response.data.Student.id;

      $scope.data.Consultation.student_name = response.data.Student.full_name;

      $scope.data.Consultation.address = response.data.Student.present_address;

      $scope.data.Consultation.sex = response.data.Student.gender;

      $scope.data.Consultation.age = response.data.Student.age;

      $scope.data.Consultation.date = Date.parse('today').toString('MM/dd/yyyy');

      $scope.data.Consultation.student_no = response.data.Student.student_no;

      $scope.data.Consultation.classification = 'Student';


    });

  });

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.Consultation.employee_id = null;

      $scope.data.Consultation.employee_name = null;

    }else{

      $scope.data.Consultation.student_id = null;

      $scope.data.Consultation.student_name = null;

    }

  }

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

    $scope.data.Consultation.student_id = $scope.student.id;

    $scope.data.Consultation.student_name = $scope.student.name;

    $scope.data.Consultation.student_no = $scope.student.code;

  };

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

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.Consultation.employee_id = $scope.employee.id;

    $scope.data.Consultation.employee_no = $scope.employee.code;

    $scope.data.Consultation.employee_name = $scope.employee.name;

  }

  //add others modal

  $scope.addSubs = function () {

    $("#add_subs").validationEngine("attach");

    $scope.adata = {};

    $("#add-subs-modal").modal("show");

  };

  $scope.saveSubs = function (data) {

    valid = $("#add_subs").validationEngine("validate");

    if (valid) {

      $scope.data.ConsultationSub.push(data);

      console.log(data);

      $("#add-subs-modal").modal("hide");

    }

  };

  $scope.editSubs = function (index, data) {

    $("#edit_subs").validationEngine("attach");

    data.index = index;

    $scope.adata = data;

    $("#edit-subs-modal").modal("show");

  };

  $scope.updateSubs = function (data, index) {

    valid = $("#edit_subs").validationEngine("validate");

    if (valid) {

      $scope.data.ConsultationSub[data.index] = data;

      $("#edit-subs-modal").modal("hide");

    }

  };

  $scope.removeSubs = function (index) {

    $scope.data.ConsultationSub.splice(index, 1);

  };

  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      Consultation.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/medical-services/consultation/student-index";

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

app.controller("StudentConsultationViewController",function ($scope, $routeParams, Consultation, ConsultationTreated, ConsultationApprove, ConsultationDisapprove, ConsultationReferred) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {

    Consultation.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.treat = function(data){

    bootbox.confirm('Are you sure you want to mark patient as treated?', function(e){

      if(e) {

        ConsultationTreated.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          window.location = "#/medical-services/consultation/student-index";

        });

      }

    });

  }
  $scope.appr = function(data){

    bootbox.confirm('Are you sure you want to mark patient as Approve?', function(e){

      if(e) {

        ConsultationApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          window.location = "#/medical-services/consultation/student-index";

        });

      }

    });

  }
  $scope.disappr = function(data){  

    bootbox.confirm('Are you sure you want to disapprove appointment ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            ConsultationDisapprove.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Counseling Appointment has been disapproved.'

                });

                $scope.load();

                window.location = "#/medical-services/consultation/student-index";

              }

            });

          }

        });

      }

    });

  }
  $scope.refer = function(data){  

    bootbox.confirm('Are you sure you want to mark patient as referred?', function(b){

      if(b) {

        ConsultationReferred.update({id:data.id}, function(e){

          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text: e.msg

            });

            $scope.load();

            window.location = "#/medical-services/consultation/student-index";

          }

        });

      }

    });

  }

    $scope.print = function (id) {

      printTable(base + "print/consultation_form/" + id);

    };

    // remove
    $scope.remove = function (data) {

      bootbox.confirm(

        "Are you sure you want to remove " + data.code + " ?",

        function (c) {

          if (c) {

            Consultation.remove({ id: data.id }, function (e) {

              if (e.ok) {

                $.gritter.add({

                  title: "Successful!",

                  text: e.msg,

                });

                window.location = "#medical-services/student-consultation";

              }

            });

          }

        }

      );

    };

  }

);

app.controller("StudentConsultationEditController", function ($scope, $routeParams, Consultation, Select) {

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

    Consultation: {},

    ConsultationSub : []

  };

  $scope.bool = [

    { id: true, value: "Yes" },

    { id: false, value: "No" },

  ];

  Select.get({ code: "ailment-list" }, function (e) {

    $scope.ailments = e.data;

  });

  $scope.getNurse = function(id){

    if($scope.nurse_profile.length > 0){

      $.each($scope.nurse_profile, function(i,val){

        if(id == val.id){

          $scope.data.Consultation.nurse_name = val.value;

        }

      });

    }

  }

  $scope.getAilment = function(id){

    if($scope.ailments.length > 0){

      $.each($scope.ailments, function(i,val){

        if(id == val.id){

          $scope.adata.chief_complaints = val.value;

          Select.get({ code: "ailment-prescription-list", id : val.id }, function (e) {

            $scope.prescriptions = e.data;

          });

        }

      });

    }

  }

  $scope.getPrescription = function(id){

    if($scope.prescriptions.length > 0){

      $.each($scope.prescriptions, function(i,val){

        if(id == val.id){

          $scope.adata.treatments = val.value;

        }

      });

    }

  }

  $scope.load = function () {

    Consultation.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      console.log(e);

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

    $scope.data.Consultation.student_id = $scope.student.id;

    $scope.data.Consultation.student_name = $scope.student.name;

    $scope.data.Consultation.student_no = $scope.student.code;

  };

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

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.Consultation.employee_id = $scope.employee.id;

    $scope.data.Consultation.employee_no = $scope.employee.code;

    $scope.data.Consultation.employee_name = $scope.employee.name;

  }

  //add others modal

  $scope.addSubs = function () {

    $("#add_subs").validationEngine("attach");

    $scope.adata = {};

    $("#add-subs-modal").modal("show");

  };

  $scope.saveSubs = function (data) {

    valid = $("#add_subs").validationEngine("validate");

    if (valid) {

      $scope.data.ConsultationSub.push(data);

      $("#add-subs-modal").modal("hide");

    }

  };

  $scope.editSubs = function (index, data) {

    Select.get({ code: "ailment-prescription-list", id : data.chief_complaint_id }, function (e) {

      $scope.prescriptions = e.data;

    });

    $("#edit_subs").validationEngine("attach");

    data.index = index;

    $scope.adata = data;

    $("#edit-subs-modal").modal("show");

  };

  $scope.updateSubs = function (data, index) {

    valid = $("#edit_subs").validationEngine("validate");

    if (valid) {

      $scope.data.ConsultationSub[data.index] = data;

      $("#edit-subs-modal").modal("hide");

    }

  };

  $scope.removeSubs = function (index) {

    $scope.data.ConsultationSub.splice(index,1);

  };

  $scope.update = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      Consultation.update({ id: $scope.id }, $scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/medical-services/consultation/student-index";

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
