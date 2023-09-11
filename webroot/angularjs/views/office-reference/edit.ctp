<?php if (hasAccess('office reference/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW OFFICE REFERENCE</div>
        <div class="clearfix"></div><hr>
         <form id="form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label> MODULE <i class="required">*</i></label>
                <select class="form-control" ng-model="data.OfficeReference.module" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Admission">ADMISSION</option>
                  <option value="Registrar">REGISTRAR</option>
                  <option value="Guidance & Counseling">GUIDANCE & COUNSELING</option>
                  <option value="Faculty">FACULTY</option>
                  <option value="Health & Medical Services">HEALTH & MEDICAL SERVICES</option>
                </select>
              </div>
            </div>

            <div class="col-md-6" ng-hide="data.OfficeReference.module == 'Admission' || data.OfficeReference.module == 'Registrar' || data.OfficeReference.module == 'Guidance & Counseling' || data.OfficeReference.module == 'Faculty' || data.OfficeReference.module == 'Health & Medical Services'">
              <div class="form-group">
                <label> SUBMODULE <i class="required">*</i></label>
                <select class="form-control" ng-model="data.OfficeReference.sub_module" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                </select>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.OfficeReference.module == 'Admission'">
              <div class="form-group">
                <label> SUBMODULE <i class="required">*</i></label>
                <select class="form-control" ng-model="data.OfficeReference.sub_module" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Cat">CAT</option>
                  <option value="Registered Student">REGISTERED STUDENT</option>
                  <option value="Scholarship Application">SCHOLARSHIP APPLICATION</option>
                </select>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.OfficeReference.module == 'Registrar'">
              <div class="form-group">
                <label> SUBMODULE <i class="required">*</i></label>
                <select class="form-control" ng-model="data.OfficeReference.sub_module" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Completion Form">COMPLETION FORM</option>
                  <option value="Request Form">REQUEST FORM</option>
                  <option value="Prospectus">PROSPECTUS</option>
                  <option value="Student Behavior">STUDENT BEHAVIOR</option>
                  <option value="Transcript of Record">TRANSCRIPT OF RECORD</option>
                  <option value="Add/Drop Subject">ADDING/DROPPING SUBJECT</option>
                  <option value="Student Behavior">STUDENT BEHAVIOR</option>
                </select>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.OfficeReference.module == 'Guidance & Counseling'">
              <div class="form-group">
                <label> SUBMODULE <i class="required">*</i></label>
                <select class="form-control" ng-model="data.OfficeReference.sub_module" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Referral/Appointment Slip">REFERRAL/APPOINTMENT SLIP</option>
                  <option value="Counseling Appointment">COUNSELING APPOINTMENT</option>
                  <option value="Attendance to Counseling">ATTENDANCE TO COUNSELING</option>
                  <option value="Affidavit for Lost ID/Passbook">AFFIDAVIT FOR LOST ID/PASSBOOK</option>
                  <option value="Promissory Note Waiver">PROMISSORY NOTE WAIVER</option>
                  <option value="Gco Evaluation">GCO EVALUATION</option>
                  <option value="Counseling Intake">COUNSELING INTAKE</option>
                  <option value="Customer Satisfaction">CUSTOMER SATISFACTION</option>
                  <option value="Participant Evaluation Activity">PARTICIPANT EVALUATION ACTIVITY</option>
                  <option value="Student Exit Management">STUDENT EXIT MANAGEMENT</option>
                </select>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.OfficeReference.module == 'Faculty'">
              <div class="form-group">
                <label> SUBMODULE <i class="required">*</i></label>
                <select class="form-control" ng-model="data.OfficeReference.sub_module" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Faculty Clearance">FACULTY CLEARANCE</option>
                </select>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.OfficeReference.module == 'Health & Medical Services'">
              <div class="form-group">
                <label> SUBMODULE <i class="required">*</i></label>
                <select class="form-control" ng-model="data.OfficeReference.sub_module" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Medical Student Profile">MEDICAL STUDENT PROFILE</option>
                  <option value="Medical Employee Profile">MEDICAL EMPLOYEE PROFILE</option>
                  <option value="Consultation">CONSULTATION</option>
                  <option value="Dental">DENTAL</option>
                  <option value="Medical Certificate Request">MEDICAL CERTIFICATE REQUEST</option>
                  <option value="Medical Student Profile">MEDICAL STUDENT PROFILE</option>
                  <option value="Referral Recommendation">REFERRAL RECOMMENDATION</option>
                </select>
              </div>
            </div>

            <div class="col-md-12" ng-hide=" data.OfficeReference.sub_module == 'Counseling Appointment' || data.OfficeReference.sub_module == 'Medical Student Profile' || data.OfficeReference.sub_module == 'Medical Employee Profile'">
              <div class="form-group">
                <label> REFERENCE CODE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.reference_code" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3" ng-show=" data.OfficeReference.sub_module == 'Counseling Appointment'">
              <div class="form-group">
                <label> CONTRACT FORM REFERENCE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.reference_code" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3" ng-show=" data.OfficeReference.sub_module == 'Counseling Appointment'">
              <div class="form-group">
                <label> COUNSELEE INFORMED CONSENT REFERENCE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.counselee_informed_consent_reference" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3" ng-show=" data.OfficeReference.sub_module == 'Counseling Appointment'">
              <div class="form-group">
                <label> RELEASE INFORMATION REFERENCE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.release_information_reference" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6" ng-show=" data.OfficeReference.sub_module == 'Medical Student Profile'">
              <div class="form-group">
                <label> MEDICAL HISTORY REFERENCE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.medical_student_history_reference" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6" ng-show=" data.OfficeReference.sub_module == 'Medical Student Profile'">
              <div class="form-group">
                <label> MEDICAL STUDENT REFERENCE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.reference_code" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6" ng-show=" data.OfficeReference.sub_module == 'Medical Employee Profile'">
              <div class="form-group">
                <label> MEDICAL HISTORY REFERENCE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.medical_employee_history_reference" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6" ng-show=" data.OfficeReference.sub_module == 'Medical Employee Profile'">
              <div class="form-group">
                <label> MEDICAL EMPLOYEE REFERENCE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.reference_code" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> ADOPTED <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.adopted" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> REVISION STATUS <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.revision_status" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> REVISION DATE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.OfficeReference.revision_date" data-validation-engine="validate[required]">
              </div>
            </div>

          </div>
        </form>
      </div>
       <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="update();"><i class="fa fa-save"></i> UPDATE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<script>
$('#form').validationEngine('attach');
</script>


          

