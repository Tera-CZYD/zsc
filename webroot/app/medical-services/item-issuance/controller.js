app.controller("ItemIssuanceController", function ($scope, ItemIssuance) {

  $scope.today = Date.parse("today").toString("MM/dd/yyyy");

  $(".datepicker").datepicker({

    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,

  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    ItemIssuance.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.approved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 1;

    ItemIssuance.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approved(options);

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

    bootbox.confirm("Are you sure you want to delete " + data.code + " ?",

      function (c) {

        if (c) {

          ItemIssuance.remove({ id: data.id }, function (e) {

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

        printTable(base + "print/item_issuances?print=1" + $scope.conditionsPrint);

      } else {

        printTable(base + "print/item_issuances?print=1");

      }

    };

  $scope.printApproved = function () {

    date = "";

    if ($scope.conditionsPrint !== "") {

      printTable(base + "print/item_issuances?print=1" + $scope.conditionsPrintApproved);

    } else {

      printTable(base + "print/item_issuances?print=1");

    }

  };

});

app.controller( "ItemIssuanceAddController", function ($scope, ItemIssuance, Select) {

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

    ItemIssuance: {},

    ItemIssuanceSub: [],

  };

  Select.get({ code: "item-issuance-code" }, function (e) {

    $scope.data.ItemIssuance.code = e.data;

  });

  Select.get({ code: "dental-list" }, function (e) {

    $scope.dentals = e.data;

  });

  Select.get({ code: "consultation-list" }, function (e) {

    $scope.consultations = e.data;

  });

  $scope.getDental = function(id){

    if($scope.dentals.length > 0){

      $.each($scope.dentals, function(i,val){

        if(id == val.id){

          $scope.data.ItemIssuance.dental = val.value;

        }

      });

    }

  }

  $scope.getConsultation = function(id){

    if($scope.consultations.length > 0){

      $.each($scope.consultations, function(i,val){

        if(id == val.id){

          $scope.data.ItemIssuance.consultation = val.value;

        }

      });

    }

  }

  $scope.getItemType = function(data){

    Select.get({ code: "item-list", type : data }, function (e) {

      $scope.items = e.data;

    });

  }

  $scope.getItem = function(id){

    if($scope.items.length > 0){

      $.each($scope.items, function(i,val){

        if(id == val.id){

          $scope.adata.item = val.value;

        }

      });

    }

  }

  //add others modal

  $scope.addItem = function () {

    $("#add_item").validationEngine("attach");

    $scope.adata = {};

    $("#add-item-modal").modal("show");

  };

  $scope.saveItem = function (data) {

    valid = $("#add_item").validationEngine("validate");

    if (valid) {

      $scope.data.ItemIssuanceSub.push(data);

      $("#add-item-modal").modal("hide");

    }

  };

  $scope.editItem = function (index, data) {

    $("#edit_item").validationEngine("attach");

    data.index = index;

    Select.get({ code: "item-list", type : data.item_type }, function (e) {

      $scope.items = e.data;

    });

    $scope.adata = data;

    $("#edit-item-modal").modal("show");

  };

  $scope.updateItem = function (data, index) {

    valid = $("#edit_item").validationEngine("validate");

    if (valid) {

      $scope.data.ItemIssuanceSub[data.index] = data;

      $("#edit-item-modal").modal("hide");

    }

  };

  $scope.removeItem = function (index) {

    $scope.data.ItemIssuanceSub.splice(index, 1);

  };

  $scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      ItemIssuance.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/medical-services/item-issuance";

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

app.controller("ItemIssuanceViewController",function ($scope, $routeParams, ItemIssuance, ItemIssuanceApproved) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load

  $scope.load = function () {

    ItemIssuance.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  $scope.approve = function(data){

    bootbox.confirm('Are you sure you want to approve '+data.code+'?', function(e){

      if(e) {

        ItemIssuanceApproved.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: e.msg

            });

          }

          window.location = "#/medical-services/item-issuance";

        });

      }

    });

  }
  
  $scope.remove = function (data) {

    bootbox.confirm("Are you sure you want to remove " + data.code + " ?",function (c) {

      if (c) {

        Consultation.remove({ id: data.id }, function (e) {

          if (e.ok) {

            $.gritter.add({

              title: "Successful!",

              text: e.msg,

            });

            window.location = "#/medical-services/medical-certificate";

          }

      });

      }

    });

  };

});

app.controller("ItemIssuanceEditController", function ($scope, $routeParams, ItemIssuance, Select) {

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

    ItemIssuance: {},

    ItemIssuanceSub: [],

  };

  $scope.load = function () {

    ItemIssuance.get({ id: $scope.id }, function (e) {

      $scope.data = e.data;

    });

  };

  $scope.load();

  Select.get({ code: "dental-list" }, function (e) {

    $scope.dentals = e.data;

  });

  Select.get({ code: "consultation-list" }, function (e) {

    $scope.consultations = e.data;

  });

  $scope.getDental = function(id){

    if($scope.dentals.length > 0){

      $.each($scope.dentals, function(i,val){

        if(id == val.id){

          $scope.data.ItemIssuance.dental = val.value;

        }

      });

    }

  }

  $scope.getConsultation = function(id){

    if($scope.consultations.length > 0){

      $.each($scope.consultations, function(i,val){

        if(id == val.id){

          $scope.data.ItemIssuance.consultation = val.value;

        }

      });

    }

  }

  $scope.getItemType = function(data){

    Select.get({ code: "item-list", type : data }, function (e) {

      $scope.items = e.data;

    });

  }

  $scope.getItem = function(id){

    if($scope.items.length > 0){

      $.each($scope.items, function(i,val){

        if(id == val.id){

          $scope.adata.item = val.value;

        }

      });

    }

  }

  //add others modal

  $scope.addItem = function () {

    $("#add_item").validationEngine("attach");

    $scope.adata = {};

    $("#add-item-modal").modal("show");

  };

  $scope.saveItem = function (data) {

    valid = $("#add_item").validationEngine("validate");

    if (valid) {

      $scope.data.ItemIssuanceSub.push(data);

      $("#add-item-modal").modal("hide");

    }

  };

  $scope.editItem = function (index, data) {

    $("#edit_item").validationEngine("attach");

    data.index = index;

    Select.get({ code: "item-list", type : data.item_type }, function (e) {

      $scope.items = e.data;

    });

    $scope.adata = data;

    $("#edit-item-modal").modal("show");

  };

  $scope.updateItem = function (data, index) {

    valid = $("#edit_item").validationEngine("validate");

    if (valid) {

      $scope.data.ItemIssuanceSub[data.index] = data;

      $("#edit-item-modal").modal("hide");

    }

  };

  $scope.removeItem = function (index) {

    $scope.data.ItemIssuanceSub.splice(index, 1);

  };

  $scope.update = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      ItemIssuance.update({ id: $scope.id }, $scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.location = "#/medical-services/item-issuance";

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

