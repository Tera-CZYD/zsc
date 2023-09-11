app.controller("PurposeController", function ($scope, Purpose) {

  $scope.today = Date.parse("today").toString("MM/dd/yyyy");

  $(".datepicker").datepicker({
    format: "mm/dd/yyyy",

    autoclose: true,

    todayHighlight: true,
  });

  $scope.load = function (options) {
    options = typeof options !== "undefined" ? options : {};

    Purpose.query(options, function (e) {
      if (e.ok) {
        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);
      }
    });
  };

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
      "Are you sure you want to delete " + data.purpose +  " ?",
      function (c) {
        if (c) {
          Purpose.remove({ id: data.id }, function (e) {
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
      printTable(base + "print/club?print=1" + $scope.conditionsPrint);
    } else {
      printTable(base + "print/club?print=1");
    }
  };
});

app.controller( "PurposeAddController", function ($scope, Purpose, Select) {

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

    Purpose: {},

  };

    $scope.save = function () {

      valid = $("#form").validationEngine("validate");

      if (valid) {

        Purpose.save($scope.data, function (e) {

          if (e.ok) {

            $.gritter.add({

              title: "Successful!",


              text: e.msg,

            });

            window.location = "#/registrar/purpose";

          } else {

            $.gritter.add({

              title: "Warning!",

              text: e.msg,

            });

          }

          console.log(e.msg);

        });

      }

    };

  }

);

app.controller( "PurposeViewController", function ($scope, $routeParams, Purpose) {
    $scope.id = $routeParams.id;

    $scope.data = {};

    // load

    $scope.load = function () {

      Purpose.get({ id: $scope.id }, function (e) {

        $scope.data = e.data;

      });

    };

    $scope.load();

    $scope.print = function (id) {

      printTable(base + "print/club_form/" + id);

    };

    // remove
    $scope.remove = function (data) {

      bootbox.confirm(

        "Are you sure you want to remove " + data.purpose + " ?",

        function (c) {

          if (c) {

            Purpose.remove({ id: data.id }, function (e) {

              if (e.ok) {

                $.gritter.add({

                  title: "Successful!",

                  text: e.msg,

                });

                window.location = "#/registrar/purpose";
              }
            });
          }
        }
      );
    };
  }
);

app.controller("PurposeEditController",function ($scope, $routeParams, Purpose, Select) {

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
      Purpose: {},
    };

    $scope.bool = [
      { id: true, value: "Yes" },
      { id: false, value: "No" },
    ];



    // load

    $scope.load = function () {
      Purpose.get({ id: $scope.id }, function (e) {
        $scope.data = e.data;
      });
    };
    $scope.load();



    $scope.update = function () {
      valid = $("#form").validationEngine("validate");

      if (valid) {
        Club.update({ id: $scope.id }, $scope.data, function (e) {
          if (e.ok) {
            $.gritter.add({
              title: "Successful!",

              text: e.msg,
            });

            window.location = "#/registrar/purpose";
          } else {
            $.gritter.add({
              title: "Warning!",

              text: e.msg,
            });
          }
        });
      }
    };
  }
);
