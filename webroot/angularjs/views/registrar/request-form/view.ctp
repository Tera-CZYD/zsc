
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">REQUEST FORM INFORMATION</div>
          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped">

                  <tr>
                    <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                    <td class="italic">{{ data.RequestForm.code }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> OFFICIAL RECEIPT # : </th>
                    <td class="italic">{{ data.RequestForm.or_no }}</td>
                  </tr>
                  <tr>
                    <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                    <td class="italic">{{ data.RequestForm.student_name }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> DATE : </th>
                    <td class="italic">{{ data.RequestForm.date }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> COURSE : </th>
                    <td class="italic">{{ data.Course.code }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> YEAR : </th>
                    <td class="italic">{{ data.RequestForm.year }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> PURPOSE : </th> 
                    <td class="italic">{{ data.RequestForm.purpose }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> REMARKS : </th>
                    <td class="italic">{{ data.RequestForm.remarks }}</td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="col-md-12 mt-4">
              <div class="form-group">
                <label> PLEASE CHECK NATURE OF REQUEST <i class="required">*</i></label>
                <div class="row mt-4">
                  <div class="col-md-4">
                    <input icheck disabled type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.otr"> Transcript of Record (TOR)
                  </div>
                  <div class="col-md-4">
                    <input icheck disabled type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.cav"> Certification Authentication Verification (CAV)
                  </div>
                  <div class="col-md-4">
                    <input icheck disabled type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.cert"> Certification
                  </div>
                </div>
                <div class="row py-3"  ng-show="data.RequestForm.otr !=true"></div>
                <div class="row" ng-show="data.RequestForm.otr ==true">
                  <div class="col-md-2 text-right">
                    Number of Pages (TOR):
                  </div>
                  <div class="col-md-1">
                    <input disabled type="text" number="true" class="form-control" autocomplete="false" ng-model="data.RequestForm.otrVal">
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-4">
                    <input icheck disabled type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.hon"> Honorable Dismissal
                  </div>
                  <div class="col-md-4">
                    <input icheck disabled type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.authGrad"> Authentication ( Graduate )
                  </div>
                  <div class="col-md-4">
                    <input icheck disabled type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.authUGrad"> Authentication ( UnderGraduate )
                  </div>
                </div>
                <div class="row py-3"></div>
                <div class="row mt-4">
                  <div class="col-md-4">
                    <input icheck disabled type="checkbox" class="form-control" ng-value-true="true" autocomplete="false" ng-model="data.RequestForm.dip"> Diploma
                  </div>
                  <div class="col-md-4">
                    <input icheck disabled type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.rr"> Red Ribbon
                  </div>
                  <div class="col-md-4">
                    <input icheck disabled type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.lg"> List of Graduates
                  </div>
                </div>
                <div class="row" ng-show="data.RequestForm.lg ==true">
                  <div class="col-md-7"></div>
                  <div class="col-md-2 text-right">
                    Photocopy:
                  </div>
                  <div class="col-md-1">
                    <input disabled type="text" number="true" class="form-control" autocomplete="false" ng-model="data.RequestForm.lgVal">
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-2">
                    <input icheck disabled type="checkbox" class="form-control" ng-value-true="true" autocomplete="false" ng-model="data.RequestForm.other"> Others: <em>(please specify)</em>
                  </div>
                  <div class="col-md-2" ng-show="data.RequestForm.other ==true">
                    <input disabled type="text" class="form-control" autocomplete="false" ng-model="data.RequestForm.otherVal">
                  </div>
                </div>


              </div>
            </div>
            <div class="col-md-12">
              <div class="clearfix"></div>
              <hr>
            </div>
            <div class="col-md-12">
              <div class="pull-right">
                <button type="button" class="btn btn-warning btn-min" ng-show="data.RequestForm.approve == 1" ng-disabled="data.RequestForm.is_request_printed == 1"  ng-click="printRequested(data.RequestForm.id )"><i class="fa fa-print"></i> PRINT REQUESTED FORM </button>
                <a href="#/registrar/request-form/edit/{{ data.RequestForm.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button type="button" class="btn btn-info btn-min" ng-show="data.RequestForm.approve == 1" ng-disabled="data.RequestForm.isprint == 1"  ng-click="print(data.RequestForm.id )"><i class="fa fa-print"></i> PRINT REQUEST FORM </button>
                <button class="btn btn-danger btn-min" ng-click="remove(data.RequestForm)"><i class="fa fa-trash"></i> DELETE </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<style type="text/css">
  th {
    white-space: nowrap;
  }

  td {
    white-space: nowrap;
  }
</style>