
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">NEW DENTAL </div>
          <div class="clearfix"></div>
          <hr>
          <form id="form">
            <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.Dental.code">
              </div>
            </div>
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
                      <td class="text-left uppercase">{{ data.Dental.student_no }}</td>   
                    </tr>
                    <tr>
                      <th class="text-left"> STUDENT NAME </th>
                      <td class="text-left uppercase">{{ data.Dental.student_name }}</td>   
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label> AGE <i class="required">*</i></label>
                  <input type="text" class="form-control" number="true" autocomplete="false" ng-model="data.Dental.age" data-validation-engine="validate[required]">
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label> PROGRAM <i class="required">*</i></label>
                  <select selectize ng-model="data.Dental.course_id" ng-options="opt.id as opt.value for opt in course" ng-change="getCourse(data.Dental.course_id)" data-validation-engine="validate[required]">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label> YEAR LEVEL <i class="required">*</i></label>
                  <select class="form-control" ng-model="data.Dental.year" autocomplete="false" data-validation-engine="validate[required]" style="height: 44px">
                    <option value=""></option>
                    <option value="First Year">First Year</option>
                    <option value="Second Year">Second Year</option>
                    </option>
                    <option value="Third Year">Third Year</option>
                    <option value="Fourth Year">Fourth Year</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label> DATE <i class="required">*</i></label>
                  <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.Dental.date" data-validation-engine="validate[required]">
                </div>
              </div>
              <div class="col-md-12 mt-4">
                <div class="form-group">
                  <label> Medical History <i class="required">*</i></label>
                  <!-- <input icheck type="checkbox" ng-true-value="true" ng-false-value = "false" ng-model="data.Dental.med"> -->
                  <div class="table-responsive px-5">
                    <table class="table">
                      <h6>Have you had...</h6>
                      <tr>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.exam">
                        </th>
                        <th>A recent physical exam</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.sin">
                        </th>
                        <th>Sinusitis</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.hea">
                        </th>
                        <th>Any heart problem</th>
                      </tr>
                      <tr>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.dia">
                        </th>
                        <th>Diabetes</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.high">
                        </th>
                        <th>High blood pressure</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.epi">
                        </th>
                        <th>Epilepsy</th>
                      </tr>
                      <tr>
                        <th> <input icheck type="checkbox" class="form-control" ng-value-true="true" autocomplete="false" ng-model="data.Dental.low">
                        </th>
                        <th>Low blood pressure</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.mal">
                        </th>
                        <th>Malignancies</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.cir">
                        </th>
                        <th>Circulatory Problems</th>
                      </tr>
                      <tr>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.rheu">
                        </th>
                        <th>Rheumatic fever</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.nerv">
                        </th>
                        <th>Nervous problems</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.thy">
                        </th>
                        <th>Thyroid</th>
                      </tr>
                      <tr>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.rad">
                        </th>
                        <th>Radiation Treatments</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.tb">
                        </th>
                        <th>Tuberculosis</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.ex">
                        </th>
                        <th>Excessive breathing</th>
                      </tr>
                      <tr>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.hep">
                        </th>
                        <th>Hepatitis</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.ane">
                        </th>
                        <th>Anemia</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.ven">
                        </th>
                        <th>Venerial disease</th>
                      </tr>
                    </table>
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
                <button class="btn btn-primary btn-min" id="save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo $this->element('modals/search/searched-student-modal') ?>
  <?php echo $this->element('modals/search/searched-employee-modal') ?>

<style type="text/css">
  th {
    white-space: nowrap;
  }

  td {
    white-space: nowrap;
  }
</style>