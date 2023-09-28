
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">EDIT AFFIDAVIT OF LOSS</div>
          <div class="clearfix"></div>
          <hr>
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
                      <td class="text-left uppercase">{{ data.AffidavitOfLoss.student_no }}</td>   
                    </tr>
                    <tr>
                      <th class="text-left"> STUDENT NAME </th> 
                      <td class="text-left uppercase">{{ data.AffidavitOfLoss.student_name }}</td>   
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label> CONTROL NO. </label>
                  <input disabled type="text" class="form-control" ng-model="data.AffidavitOfLoss.code">
                </div>
              </div>

              
              
              <div class="col-md-6">
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <select selectize ng-options="opt.id as opt.value for opt in college_programs" ng-model="data.AffidavitOfLoss.program_id" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                  <label> FORM <i class="required">*</i></label>
                  <input type="text" class="form-control" autocomplete="false" ng-model="data.AffidavitOfLoss.form" data-validation-engine="validate[required]">
                </div>
              </div>
              
              
              <div class="col-md-6">
                <div class="form-group">
                  <label> DATE <i class="required">*</i></label>
                  <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.AffidavitOfLoss.date" data-validation-engine="validate[required]">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> AMOUNT <i class="required">*</i></label>
                  <input type="text" class="form-control" autocomplete="false" ng-model="data.AffidavitOfLoss.amount" data-validation-engine="validate[required]">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label> DESCRIPTION <i class="required">*</i></label>
                  <textarea class="form-control" autocomplete="false" ng-model="data.AffidavitOfLoss.description" data-validation-engine="validate[required]"></textarea>
                </div>
              </div>

              <div class="col-md-12">
              <div class="form-group">
                <label> REQUESTOR <i class="required">*</i></label><br>
                <label>
                  <input type="radio" ng-model="data.AffidavitOfLoss.claim" ng-value="false" value="0">
                  Claim
                </label>&nbsp; &nbsp;&nbsp; &nbsp;
                <label>
                  <input type="radio" ng-model="data.AffidavitOfLoss.claim" ng-value="true" value="1">
                  Authorized Person
                </label>
              </div>
            </div>

            <div class="col-md-12" ng-show="data.AffidavitOfLoss.claim">
              <div class="clearfix"></div><hr>
            </div>

            <div class="col-md-12" ng-show="data.AffidavitOfLoss.claim">
              <label>Authorization letter (JPEG or PNG)</label>
              <h5>• ID of the student should be attached in lower right corner of the authorization letter.</h5>
              <ul class="list-group mb-2">
                <div class="col-md-12">
                  <span class="btn btn-primary btn-min btn-file">
                    <i class="fa fa-upload"></i>UPLOAD PHOTO
                    <input ng-file-model="files" id="fileImage" name="picture" class="form-control" type="file" accept=" image/jpeg, image/png" ng-file>
                  </span>
                </div>
              </ul>
            <div class="clearfix"></div>
            <div id="upload_prev"></div> 
            
            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
          </div>


                </div>
              </div>
            </div>
          </form>
          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="pull-right">
                <button class="btn btn-primary btn-min" id="save" ng-click="update();"><i class="fa fa-save"></i> UPDATE </button>
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