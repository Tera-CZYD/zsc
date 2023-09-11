app.directive('ngFile', function () {

  return {

    scope: true,        //create a new scope

    link: function (scope, el, attrs) {

      el.bind('change', function (event) {

        var files = event.target.files;

        //iterate files since 'multiple' may be specified on the element

        for (var i = 0;i<files.length;i++) {

          //emit event upward

          scope.$emit("fileSelected", { file: files[i] });

        }                                       

      });

    }

  };

});

app.directive('decimal', function() {

  return {

    require: "ngModel",

    link: function (scope, elem, attr, ctrl) {

    $(elem).inputmask({

      alias: 'decimal'

      , groupSeparator: ','

      , autoGroup: true

      , rightAlign: false

    });
    elem.on('keyup', function () 
        {
          scope.$apply(function()
            {
              ctrl.$setViewValue(elem.val());
            });
        });
      }
    };
  });

app.directive('number', function() {

  return {

    restrict: 'A',

    require: 'ngModel',

    link: function(scope, element, attr, ngModel) {

      element.on('keypress', function(evt) {

        var charCode = (evt.which) ? evt.which : event.keyCode;

        if ((charCode  < 48 || charCode > 57))

          return false;

        return true;

      });



      element.on('blur', function(evt) {

        if (ngModel.$viewValue == '' || isNaN(ngModel.$viewValue))

          result = 0;

        else

          result = parseInt(ngModel.$viewValue);

        return scope.$apply(function() {

          $(element).val(result);

          return ngModel.$setViewValue(result);

        });

      });

    }

  };

});

app.directive('numberdecimal', function () {
  
  return {

    restrict: 'A',

    link: function (scope, elm, attrs, ctrl) {

      elm.on('keydown', function (event) {

        var $input = $(this);

        var value = $input.val();

        value = value.replace(/[^0-9\.]/g, '') 

        var findsDot = new RegExp(/\./g)

        var containsDot = value.match(findsDot)

        if (containsDot != null && ([46, 110, 190].indexOf(event.which) > -1)) {

          event.preventDefault();

          return false;

        }

        $input.val(value);

        if (event.which == 64 || event.which == 16) {

          // numbers

          return false;

        } 

        if ([8, 13, 27, 37, 38, 39, 40, 110].indexOf(event.which) > -1) { 

          // backspace, enter, escape, arrows 

           return true;

        } else if (event.which >= 48 && event.which <= 57) {

          // numbers

          return true; 

        } else if (event.which >= 96 && event.which <= 105) { 

          // numpad number 

          return true;

        } else if ([46, 110, 190].indexOf(event.which) > -1) {

          // dot and numpad dot

          return true; 

        } else {

          event.preventDefault();

          return false;

        }
        
      });

    }

  }  

});

app.directive('numbersOnly', function () {

  return {

    require: 'ngModel',

    link: function (scope, element, attr, ngModelCtrl) {

      function fromUser(text) {

        if (text) {

          var transformedInput = text.replace(/[^0-9]./g, '');

          if (transformedInput !== text) {

            ngModelCtrl.$setViewValue(transformedInput);

            ngModelCtrl.$render();

          }

          return transformedInput;

        }

        return undefined;

      }            

      ngModelCtrl.$parsers.push(fromUser);

    }

  };

});

app.directive('passbooknumber', function() {

  return {

    restrict: 'A',

    require: 'ngModel',

    link: function(scope, element, attr, ngModel) {

      element.on('keypress', function(evt) {

        var charCode = (evt.which) ? evt.which : event.keyCode;

        if ((charCode  < 48 || charCode > 57))

          return false;

        return true;

      });



      element.on('blur', function(evt) {

        if (ngModel.$viewValue == '' || isNaN(ngModel.$viewValue))

          result = '';

        else

          result = parseInt(ngModel.$viewValue);

        return scope.$apply(function() {

          $(element).val(result);

          return ngModel.$setViewValue(result);

        });

      });

    }

  };

});



app.directive('ornumber', function() {

  return {

    restrict: 'A',

    require: 'ngModel',

    link: function(scope, element, attr, ngModel) {

      element.on('keypress', function(evt) {

        var charCode = (evt.which) ? evt.which : event.keyCode;

        if ((charCode  < 48 || charCode > 57))

          return false;

        return true;

      });



      element.on('blur', function(evt) {

        if (ngModel.$viewValue == '' || isNaN(ngModel.$viewValue))

          result = '';

        else

          result = ngModel.$viewValue;

        return scope.$apply(function() {

          $(element).val(result);

          return ngModel.$setViewValue(result);

        });

      });

    }

  };

});



app.directive('icheck', function($timeout, $parse) {

  return {

    require: 'ngModel',

    link: function($scope, element, $attrs, ngModel) {

      return $timeout(function() {

        var value;

        value = $attrs['value'];



        $scope.$watch($attrs['ngModel'], function(newValue){

          $(element).iCheck('update');

        });

        return $(element).iCheck({

          checkboxClass: 'icheckbox_square-blue',

          radioClass: 'iradio_square-blue'



        }).on('ifChanged', function(event) {

          if ($(element).attr('type') === 'checkbox' && $attrs['ngModel']) {

            $scope.$apply(function() {

              return ngModel.$setViewValue(event.target.checked);

            });

          }

          if ($(element).attr('type') === 'radio' && $attrs['ngModel']) {

            return $scope.$apply(function() {

              return ngModel.$setViewValue(value);

            });

          }

        });

      });

    }

  };

});



app.directive('ngEnter', function () {

    return function (scope, element, attrs) {

        element.bind("keydown keypress", function (event) {

            if(event.which === 13) {

                scope.$apply(function (){

                    scope.$eval(attrs.ngEnter);

                });

 

                event.preventDefault();

            }

        });

    };

});

app.directive('ngFileModel', ['$parse', function ($parse) {

    return {

        restrict: 'A',

        link: function (scope, element, attrs) {

            var model = $parse(attrs.ngFileModel);

            var isMultiple = attrs.multiple;

            var modelSetter = model.assign;

            element.bind('change', function () {

                var values = [];

                angular.forEach(element[0].files, function (item) {

                    var value = {

                       // File Name 

                        name: item.name,

                        //File Size 

                        size: item.size,

                        //File URL to view 

                        url: URL.createObjectURL(item),

                        // File Input Value 

                        _file: item

                    };

                    values.push(value);

                });

                scope.$apply(function () {

                    if (isMultiple) {

                        modelSetter(scope, values);

                    } else {

                        modelSetter(scope, values[0]);

                    }

                });

            });

        }

    };

}]);