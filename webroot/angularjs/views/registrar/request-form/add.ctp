
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">NEW REQUEST FORM</div>
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
                      <td class="text-left uppercase">{{ data.RequestForm.student_no }}</td>   
                    </tr>
                    <tr>
                      <th class="text-left"> STUDENT NAME </th> 
                      <td class="text-left uppercase">{{ data.RequestForm.student_name }}</td>   
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label> CONTROL NO. </label>
                  <input disabled type="text" class="form-control" ng-model="data.RequestForm.code">
                </div>
              </div>

              


              <div class="col-md-6">
                <div class="form-group">
                  <label> OFFICIAL RECEIPT #: <i class="required">*</i></label>
                  <input type="text" class="form-control" autocomplete="false" ng-model="data.RequestForm.or_no" data-validation-engine="validate[required]"></input>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label> PROGRAM <i class="required">*</i></label>
                  <select selectize ng-model="data.RequestForm.program_id" ng-options="opt.id as opt.value for opt in college_program" ng-change="getCourse(data.RequestForm.course_id)" data-validation-engine="validate[required]">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label> YEAR TERM </label>
                  <select selectize ng-model="data.RequestForm.year_term_id" ng-options="opt.id as opt.value for opt in year_terms">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label> DATE <i class="required">*</i></label>
                  <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.RequestForm.date" data-validation-engine="validate[required]">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label> PURPOSE <i class="required">*</i></label>
                  <select selectize ng-model="data.RequestForm.purpose_id" ng-options="opt.id as opt.value for opt in purpose" ng-change="getPurpose(data.RequestForm.purpose_id)" data-validation-engine="validate[required]">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-9">
                <div class="form-group">
                  <label> REMARKS <i class="required">*</i></label>
                  <textarea rows="1" class="form-control" autocomplete="false" ng-model="data.RequestForm.remarks" data-validation-engine="validate[required]"></textarea>
                </div>
              </div>
              <div class="clearfix"></div>
              <hr>
              <div class="col-md-12 mt-4">
                <div class="form-group">
                  <label> PLEASE CHECK NATURE OF REQUEST <i class="required">*</i></label>
                  <div class="row mt-4">
                    <div class="col-md-4">
                      <input icheck type="checkbox" class="form-control" autocomplete="false" ng-change="selectTorDiploma(data.RequestForm.otr)" ng-model="data.RequestForm.otr"> Transcript of Record (TOR)
                      &nbsp;<p ng-show="data.RequestForm.otr ==true">Price: 120.00/page</p>
                    </div>
                    <div class="col-md-4">
                      <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.cav"> Certification Authentication Verification (CAV)
                    </div>
                    <div class="col-md-4">
                      <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.cert"> Certification
                    </div>
                  </div>
                  <div class="row py-3" ng-show="data.RequestForm.otr !=true"></div>
                  <div class="row">
                    <div class="col-md-2 text-right" ng-show="data.RequestForm.otr ==true">
                      Number of Pages (TOR):
                    </div>
                    <div class="col-md-1" ng-show="data.RequestForm.otr ==true">
                      <input type="text" number="true" class="form-control" autocomplete="false" ng-model="data.RequestForm.otrVal">
                    </div>
                  </div>

                  <div class="row mt-4">
                    <div class="col-md-4">
                      <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.hon"> Honorable Dismissal
                    </div>
                    <div class="col-md-4">
                      <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.authGrad"> Authentication ( Graduate )
                    </div>
                    <div class="col-md-4">
                      <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.authUGrad"> Authentication ( UnderGraduate )
                    </div>
                  </div>
                  <div class="row py-3"></div>
                  <div class="row mt-4">
                    <div class="col-md-4">
                      <input icheck type="checkbox" class="form-control" ng-value-true="true" autocomplete="false" ng-change="selectTorDiploma(data.RequestForm.dip)" ng-model="data.RequestForm.dip"> Diploma
                      <p ng-show="data.RequestForm.dip ==true">Price: 200.00</p>
                    </div>
                    <div class="col-md-4">
                      <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.rr"> Red Ribbon
                    </div>
                    <!-- <div class="col-md-4">
                      <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.RequestForm.lg"> List of Graduates
                    </div> -->
                    <div class="col-md-2 mb-4">
                      <input icheck type="checkbox" class="form-control" ng-value-true="true" autocomplete="false" ng-model="data.RequestForm.other"> Others: <em>(please specify)</em>
                    </div>
                    <div class="col-md-2" ng-show="data.RequestForm.other ==true">
                      <input type="text" class="form-control" autocomplete="false" ng-model="data.RequestForm.otherVal">
                    </div>
                  </div>
                  <!-- <div class="row">
                    <div class="col-md-10 text-right pb-4 mb-3" ng-show="data.RequestForm.lg !=true">
                    </div>
                    <div class="col-md-7"></div>
                    <div class="col-md-2 text-right" ng-show="data.RequestForm.lg ==true">
                      Photocopy:
                    </div>
                    <div class="col-md-1 py-0" ng-show="data.RequestForm.lg ==true">
                      <input type="text" number="true" class="form-control" autocomplete="false" ng-model="data.RequestForm.lgVal">
                    </div>
                  </div> -->
                  <!-- <div class="row mt-4">
                    <div class="col-md-2 mb-4">
                      <input icheck type="checkbox" class="form-control" ng-value-true="true" autocomplete="false" ng-model="data.RequestForm.other"> Others: <em>(please specify)</em>
                    </div>
                    <div class="col-md-2" ng-show="data.RequestForm.other ==true">
                      <input type="text" class="form-control" autocomplete="false" ng-model="data.RequestForm.otherVal">
                    </div>
                  </div> -->


                </div>
              </div>
            </div>
          </form>
          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="pull-right">
                <button class="btn btn-primary btn-min" id="save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo $this->element('modals/search/searched-student-modal') ?>

<style type="text/css">
  th {
    white-space: nowrap;
  }

  td {
    white-space: nowrap;
  }
</style>