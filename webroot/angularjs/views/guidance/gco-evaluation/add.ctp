<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">GCO EVALUATION</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th class = "text-center" colspan="2">STUDENT INFORMATION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th class="text-left" style="width: 15%"> STUDENT NUMBER </th>
                      <td class="text-left uppercase">{{ data.GcoEvaluation.student_no }}</td>   
                    </tr>
                    <tr>
                      <th class="text-left"> STUDENT NAME </th>
                      <td class="text-left uppercase">{{ data.GcoEvaluation.student_name }}</td>   
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.GcoEvaluation.code" data-validation-engine="validate[required]" disabled="">
              </div>
            </div>
            <div class="col-md-8" >
              <div class="form-group">
                <label> ATTENDANCE TO COUNSELING <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.GcoEvaluation.attendance_counseling_id" ng-options="opt.id as opt.value for opt in counseling_attendance" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.GcoEvaluation.date"  data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div>
                <p style="font-weight: bold;">Rate your visit on a 5 to 1 scale, where:</p>
                <p>5 – Outstanding&#160;&#160;&#160;4 – Very Satisfactory&#160;&#160;&#160;3 –Satisfactory&#160;&#160;&#160;2 – Fair&#160;&#160;&#160;1 – Poor</p>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th class="text-center" colspan="2"></th>
                      <th class="text-center">5</th>
                      <th class="text-center">4</th>
                      <th class="text-center">3</th>
                      <th class="text-center">2</th>
                      <th class="text-center">1</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th class="text-center"> a </th>
                      <td class="text-left">How was your experience today with your counselor?</td>   
                      <td class="text-center"><input type="radio" value="5" name="a" class="myRadio" ng-model="data.GcoEvaluation.a" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="4" name="a" class="myRadio" ng-model="data.GcoEvaluation.a" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="3" name="a" class="myRadio" ng-model="data.GcoEvaluation.a" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="2" name="a" class="myRadio" ng-model="data.GcoEvaluation.a" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="1" name="a" class="myRadio" ng-model="data.GcoEvaluation.a" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                    </tr>
                    <tr>
                      <th class="text-center"> b </th>
                      <td class="text-left">Accessibility of the location of the office</td>   
                      <td class="text-center"><input type="radio" value="5" name="b" class="myRadio" ng-model="data.GcoEvaluation.b" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="4" name="b" class="myRadio" ng-model="data.GcoEvaluation.b" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="3" name="b" class="myRadio" ng-model="data.GcoEvaluation.b" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="2" name="b" class="myRadio" ng-model="data.GcoEvaluation.b" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="1" name="b" class="myRadio" ng-model="data.GcoEvaluation.b" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                    </tr>
                    <tr>
                      <th class="text-center"> c </th>
                      <td class="text-left">Comfort of the counseling area</td>   
                      <td class="text-center"><input type="radio" value="5" name="c" class="myRadio" ng-model="data.GcoEvaluation.c" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="4" name="c" class="myRadio" ng-model="data.GcoEvaluation.c" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="3" name="c" class="myRadio" ng-model="data.GcoEvaluation.c" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="2" name="c" class="myRadio" ng-model="data.GcoEvaluation.c" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="1" name="c" class="myRadio" ng-model="data.GcoEvaluation.c" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                    </tr>
                    <tr>
                      <th class="text-center"> d </th>
                      <td class="text-left">Welcoming manner and warmth of the attending counselor</td>   
                      <td class="text-center"><input type="radio" value="5" name="d" class="myRadio" ng-model="data.GcoEvaluation.d" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="4" name="d" class="myRadio" ng-model="data.GcoEvaluation.d" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="3" name="d" class="myRadio" ng-model="data.GcoEvaluation.d" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="2" name="d" class="myRadio" ng-model="data.GcoEvaluation.d" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="1" name="d" class="myRadio" ng-model="data.GcoEvaluation.d" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                    </tr>
                    <tr>
                      <th class="text-center"> e </th>
                      <td class="text-left">The way the counselor listened to me</td>   
                      <td class="text-center"><input type="radio" value="5" name="e" class="myRadio" ng-model="data.GcoEvaluation.e" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="4" name="e" class="myRadio" ng-model="data.GcoEvaluation.e" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="3" name="e" class="myRadio" ng-model="data.GcoEvaluation.e" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="2" name="e" class="myRadio" ng-model="data.GcoEvaluation.e" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="1" name="e" class="myRadio" ng-model="data.GcoEvaluation.e" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                    </tr>
                    <tr>
                      <th class="text-center"> f </th>
                      <td class="text-left">The counselor’s ability to answer my questions</td>   
                      <td class="text-center"><input type="radio" value="5" name="f" class="myRadio" ng-model="data.GcoEvaluation.f" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="4" name="f" class="myRadio" ng-model="data.GcoEvaluation.f" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="3" name="f" class="myRadio" ng-model="data.GcoEvaluation.f" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="2" name="f" class="myRadio" ng-model="data.GcoEvaluation.f" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="1" name="f" class="myRadio" ng-model="data.GcoEvaluation.f" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                    </tr>
                    <tr>
                      <th class="text-center"> g </th>
                      <td class="text-left">The way the counselor allowed me to express my concerns and ideas</td>   
                      <td class="text-center"><input type="radio" value="5" name="g" class="myRadio" ng-model="data.GcoEvaluation.g" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="4" name="g" class="myRadio" ng-model="data.GcoEvaluation.g" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="3" name="g" class="myRadio" ng-model="data.GcoEvaluation.g" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="2" name="g" class="myRadio" ng-model="data.GcoEvaluation.g" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="1" name="g" class="myRadio" ng-model="data.GcoEvaluation.g" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                    </tr>
                    <tr>
                      <th class="text-center"> h </th>
                      <td class="text-left">Communication of confidentiality information</td>   
                      <td class="text-center"><input type="radio" value="5" name="h" class="myRadio" ng-model="data.GcoEvaluation.h" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="4" name="h" class="myRadio" ng-model="data.GcoEvaluation.h" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="3" name="h" class="myRadio" ng-model="data.GcoEvaluation.h" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="2" name="h" class="myRadio" ng-model="data.GcoEvaluation.h" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="1" name="h" class="myRadio" ng-model="data.GcoEvaluation.h" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                    </tr>
                    <tr>
                      <th class="text-center"> i </th>
                      <td class="text-left">Clarity regarding the services of the office</td>   
                      <td class="text-center"><input type="radio" value="5" name="i" class="myRadio" ng-model="data.GcoEvaluation.i" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="4" name="i" class="myRadio" ng-model="data.GcoEvaluation.i" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="3" name="i" class="myRadio" ng-model="data.GcoEvaluation.i" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="2" name="i" class="myRadio" ng-model="data.GcoEvaluation.i" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                      <td class="text-center"><input type="radio" value="1" name="i" class="myRadio" ng-model="data.GcoEvaluation.i" ng-disabled="data.GcoEvaluation.attendance_counseling_id == null"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> COMMENTS <i class="required">*</i></label>
                <textarea class="form-control" autocomplete="false" ng-model="data.GcoEvaluation.comments" data-validation-engine="validate[required]"></textarea>
              </div>
            </div>
          </div>  
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  .myRadio{
    height:20px; 
    width:20px;
  }
</style>