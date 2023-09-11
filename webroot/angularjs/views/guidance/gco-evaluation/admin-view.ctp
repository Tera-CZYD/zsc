<?php if (hasAccess('gco evaluation/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW GCO EVALUATION INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width: 20%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.GcoEvaluation.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NO. : </th>
                  <td class="uppercase italic">{{ data.GcoEvaluation.student_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="uppercase italic">{{ data.GcoEvaluation.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.GcoEvaluation.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COMMENTS : </th>
                  <td class="italic">{{ data.GcoEvaluation.comments }}</td>
                </tr>
              </table>
              <div class="col-md-12">
                <div class="clearfix"></div><hr>
              </div>
              <div class="col-md-12">
                <div>
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
                        <td class="text-center"><input type="radio" value="5" name="a" class="myRadio" ng-model="data.GcoEvaluation.a" disabled=""></td>
                        <td class="text-center"><input type="radio" value="4" name="a" class="myRadio" ng-model="data.GcoEvaluation.a" disabled=""></td>
                        <td class="text-center"><input type="radio" value="3" name="a" class="myRadio" ng-model="data.GcoEvaluation.a" disabled=""></td>
                        <td class="text-center"><input type="radio" value="2" name="a" class="myRadio" ng-model="data.GcoEvaluation.a" disabled=""></td>
                        <td class="text-center"><input type="radio" value="1" name="a" class="myRadio" ng-model="data.GcoEvaluation.a" disabled=""></td>
                      </tr>
                      <tr>
                        <th class="text-center"> b </th>
                        <td class="text-left">Accessibility of the location of the office</td>   
                        <td class="text-center"><input type="radio" value="5" name="b" class="myRadio" ng-model="data.GcoEvaluation.b" disabled=""></td>
                        <td class="text-center"><input type="radio" value="4" name="b" class="myRadio" ng-model="data.GcoEvaluation.b" disabled=""></td>
                        <td class="text-center"><input type="radio" value="3" name="b" class="myRadio" ng-model="data.GcoEvaluation.b" disabled=""></td>
                        <td class="text-center"><input type="radio" value="2" name="b" class="myRadio" ng-model="data.GcoEvaluation.b" disabled=""></td>
                        <td class="text-center"><input type="radio" value="1" name="b" class="myRadio" ng-model="data.GcoEvaluation.b" disabled=""></td>
                      </tr>
                      <tr>
                        <th class="text-center"> c </th>
                        <td class="text-left">Comfort of the counseling area</td>   
                        <td class="text-center"><input type="radio" value="5" name="c" class="myRadio" ng-model="data.GcoEvaluation.c" disabled=""></td>
                        <td class="text-center"><input type="radio" value="4" name="c" class="myRadio" ng-model="data.GcoEvaluation.c" disabled=""></td>
                        <td class="text-center"><input type="radio" value="3" name="c" class="myRadio" ng-model="data.GcoEvaluation.c" disabled=""></td>
                        <td class="text-center"><input type="radio" value="2" name="c" class="myRadio" ng-model="data.GcoEvaluation.c" disabled=""></td>
                        <td class="text-center"><input type="radio" value="1" name="c" class="myRadio" ng-model="data.GcoEvaluation.c" disabled=""></td>
                      </tr>
                      <tr>
                        <th class="text-center"> d </th>
                        <td class="text-left">Welcoming manner and warmth of the attending counselor</td>   
                        <td class="text-center"><input type="radio" value="5" name="d" class="myRadio" ng-model="data.GcoEvaluation.d" disabled=""></td>
                        <td class="text-center"><input type="radio" value="4" name="d" class="myRadio" ng-model="data.GcoEvaluation.d" disabled=""></td>
                        <td class="text-center"><input type="radio" value="3" name="d" class="myRadio" ng-model="data.GcoEvaluation.d" disabled=""></td>
                        <td class="text-center"><input type="radio" value="2" name="d" class="myRadio" ng-model="data.GcoEvaluation.d" disabled=""></td>
                        <td class="text-center"><input type="radio" value="1" name="d" class="myRadio" ng-model="data.GcoEvaluation.d" disabled=""></td>
                      </tr>
                      <tr>
                        <th class="text-center"> e </th>
                        <td class="text-left">The way the counselor listened to me</td>   
                        <td class="text-center"><input type="radio" value="5" name="e" class="myRadio" ng-model="data.GcoEvaluation.e" disabled=""></td>
                        <td class="text-center"><input type="radio" value="4" name="e" class="myRadio" ng-model="data.GcoEvaluation.e" disabled=""></td>
                        <td class="text-center"><input type="radio" value="3" name="e" class="myRadio" ng-model="data.GcoEvaluation.e" disabled=""></td>
                        <td class="text-center"><input type="radio" value="2" name="e" class="myRadio" ng-model="data.GcoEvaluation.e" disabled=""></td>
                        <td class="text-center"><input type="radio" value="1" name="e" class="myRadio" ng-model="data.GcoEvaluation.e" disabled=""></td>
                      </tr>
                      <tr>
                        <th class="text-center"> f </th>
                        <td class="text-left">The counselor’s ability to answer my questions</td>   
                        <td class="text-center"><input type="radio" value="5" name="f" class="myRadio" ng-model="data.GcoEvaluation.f" disabled=""></td>
                        <td class="text-center"><input type="radio" value="4" name="f" class="myRadio" ng-model="data.GcoEvaluation.f" disabled=""></td>
                        <td class="text-center"><input type="radio" value="3" name="f" class="myRadio" ng-model="data.GcoEvaluation.f" disabled=""></td>
                        <td class="text-center"><input type="radio" value="2" name="f" class="myRadio" ng-model="data.GcoEvaluation.f" disabled=""></td>
                        <td class="text-center"><input type="radio" value="1" name="f" class="myRadio" ng-model="data.GcoEvaluation.f" disabled=""></td>
                      </tr>
                      <tr>
                        <th class="text-center"> g </th>
                        <td class="text-left">The way the counselor allowed me to express my concerns and ideas</td>   
                        <td class="text-center"><input type="radio" value="5" name="g" class="myRadio" ng-model="data.GcoEvaluation.g" disabled=""></td>
                        <td class="text-center"><input type="radio" value="4" name="g" class="myRadio" ng-model="data.GcoEvaluation.g" disabled=""></td>
                        <td class="text-center"><input type="radio" value="3" name="g" class="myRadio" ng-model="data.GcoEvaluation.g" disabled=""></td>
                        <td class="text-center"><input type="radio" value="2" name="g" class="myRadio" ng-model="data.GcoEvaluation.g" disabled=""></td>
                        <td class="text-center"><input type="radio" value="1" name="g" class="myRadio" ng-model="data.GcoEvaluation.g" disabled=""></td>
                      </tr>
                      <tr>
                        <th class="text-center"> h </th>
                        <td class="text-left">Communication of confidentiality information</td>   
                        <td class="text-center"><input type="radio" value="5" name="h" class="myRadio" ng-model="data.GcoEvaluation.h" disabled=""></td>
                        <td class="text-center"><input type="radio" value="4" name="h" class="myRadio" ng-model="data.GcoEvaluation.h" disabled=""></td>
                        <td class="text-center"><input type="radio" value="3" name="h" class="myRadio" ng-model="data.GcoEvaluation.h" disabled=""></td>
                        <td class="text-center"><input type="radio" value="2" name="h" class="myRadio" ng-model="data.GcoEvaluation.h" disabled=""></td>
                        <td class="text-center"><input type="radio" value="1" name="h" class="myRadio" ng-model="data.GcoEvaluation.h" disabled=""></td>
                      </tr>
                      <tr>
                        <th class="text-center"> i </th>
                        <td class="text-left">Clarity regarding the services of the office</td>   
                        <td class="text-center"><input type="radio" value="5" name="i" class="myRadio" ng-model="data.GcoEvaluation.i" disabled=""></td>
                        <td class="text-center"><input type="radio" value="4" name="i" class="myRadio" ng-model="data.GcoEvaluation.i" disabled=""></td>
                        <td class="text-center"><input type="radio" value="3" name="i" class="myRadio" ng-model="data.GcoEvaluation.i" disabled=""></td>
                        <td class="text-center"><input type="radio" value="2" name="i" class="myRadio" ng-model="data.GcoEvaluation.i" disabled=""></td>
                        <td class="text-center"><input type="radio" value="1" name="i" class="myRadio" ng-model="data.GcoEvaluation.i" disabled=""></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('gco evaluation/print gco evaluation form', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.GcoEvaluation.id )"><i class="fa fa-print"></i> PRINT GCO EVALUATION FORM </button>
              <?php endif ?>
            </div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<style>
  .table-wrapper{
    width:100%;
    height:500px;
    overflow-y:auto;
  }
</style>

<style type="text/css">
  .myRadio{
    height:20px; 
    width:20px;
  }
</style>