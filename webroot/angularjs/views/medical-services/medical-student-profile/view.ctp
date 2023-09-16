<script type="text/javascript">

  function handleAccess(elementId, permissionCode, currentUser) {
    const element = document.getElementById(elementId);
    const accessGranted = hasAccess(permissionCode, currentUser);
    
    if (accessGranted) {
      element.classList.remove('d-none'); // Remove Bootstrap's "d-none" class to show the element
    } else {
      element.classList.add('d-none'); // Add Bootstrap's "d-none" class to hide the element
    }
  }

  // INCLUDE ALL PAGE PERMISSION
  handleAccess('pageView', 'medical student profile/view', currentUser);
  handleAccess('pageEdit', 'medical student profile/edit', currentUser);
  handleAccess('pageDelete', 'medical student profile/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW MEDICAL STUDENT PROFILE INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.MedicalStudentProfile.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.YearTermLevel.description }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ADDRESS : </th>
                  <td class="italic">{{ data.MedicalStudentProfile.address }}</td>
                </tr>
                <tr>
                  <th class="text-right"> AGE : </th>
                  <td class="italic">{{ data.MedicalStudentProfile.age }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CIVIL STATUS : </th>
                  <td class="italic">{{ data.MedicalStudentProfile.civil_status }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GENDER : </th>
                  <td class="italic">{{ data.MedicalStudentProfile.gender }}</td>
                </tr>
                <tr>
                  <th class="text-right"> HEIGHT : </th>
                  <td class="italic">{{ data.MedicalStudentProfile.height }}</td>
                </tr>
                <tr>
                  <th class="text-right"> WEIGHT : </th>
                  <td class="italic">{{ data.MedicalStudentProfile.weight }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <div class="form-group">
                <label> RESPIRATORY SYSTEM </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.respiratory_system" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> FLOUROGRAPHY </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.flourography" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> LUNGS </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.lungs" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> HEART </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.heart" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> EYES </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.eyes" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> COLOR PRECEPTION </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.color_preception" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> VISION </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.vision" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> FAR RIGHT </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.far_right" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> LEFT </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.far_left" disabled>
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <div class="form-group">
                <label> BLOOD PRESSURE </label>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> SYSTOLIC </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.systolic" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> DIASTOLIC </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.diastolic" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> PULSE </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.pulse" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> AGILITY TEST </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.agility_test" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> EARS </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.ears" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> HEARING </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.hearing" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> NOSE </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.nose" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> THROAT </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.throat" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> IMMUNIZATION </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.immunization" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> URINALYSIS </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.urinalysis" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> SKIN </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.skin" disabled>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> SITTING </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.sitting" disabled>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> NERVOUS SYSTEM </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.nervous_system" disabled>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> LOCOMOTION SYSTEM </label>
                <input type="text" class="form-control" ng-model="data.MedicalStudentProfile.locomotion_system" disabled>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> DIGESTIVE SYSTEM </label>
                <textarea class="form-control" ng-model="data.MedicalStudentProfile.digestive_system" disabled></textareA>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> GENITO-URINARY SYSTEM</label>
                <textarea class="form-control" ng-model="data.MedicalStudentProfile.genito_urinary_system" disabled></textareA>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> RECOMMENDATION </label>
                <textareA class="form-control" ng-model="data.MedicalStudentProfile.recommendation" disabled></textareA>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> REMARKS </label>
                <textareA class="form-control" ng-model="data.MedicalStudentProfile.remarks" disabled></textareA>
              </div>
            </div>
          </div>

          <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <div class="form-group">
                <div class="header-title">MEDICAL HISTORY</div>
              <div class="clearfix"></div><hr>
              </div>
            </div>            

            <div class="col-md-12 mt-4">
              <div class="form-group">
                <label>HAVE YOU HAD : </label>
                <div class="table-responsive px-5">

                  <table class="table">
                    <h6>Please Check each box if the answer is YES, leave blank if NO.</h6>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[0]" disabled>
                      </th>
                      <th>A recent physical exan</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[1]" disabled>
                      </th>
                      <th>Any heart problem</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[2]" disabled>
                      </th>
                      <th>High Blood pressure</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[3]" disabled>
                      </th>
                      <th>Low Blood pressure</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[4]" disabled>
                      </th>
                      <th>Circulatory Problems</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[5]" disabled>
                      </th>
                      <th>Nervous Problems </th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[6]" disabled>
                      </th>
                      <th>Radioation Treatments</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[7]" disabled>
                      </th>
                      <th>Excessive Bleeding</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[8]" disabled>
                      </th>
                      <th>Anemia</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[9]" disabled>
                      </th>
                      <th>Sinustis</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[10]" disabled>
                      </th>
                      <th>Diabetes</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[11]" disabled>
                      </th>
                      <th>Epilepsy</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[13]" disabled>
                      </th>
                      <th>Malignancies</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[14]" disabled>
                      </th>
                      <th>Rheumaic Fever</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[15]" disabled>
                      </th>
                      <th>Thyroid</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[16]" disabled>
                      </th>
                      <th>Tuberculosis</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[17]" disabled>
                      </th>
                      <th>Hepatitis</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalStudentProfile.have[18]" disabled>
                      </th>
                      <th>Venereal Disease</th>
                    </tr>
                    
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-12 mt-4">
              <div class="form-group">
                <label> On previous visits : </label>

                <div class="col-md-12">
                  <div class="form-group">
                    <h6> Have you had any outward reaction during or after other procedure? </h6>
                    <textarea class="form-control" ng-model="data.MedicalStudentProfile.reaction_procedure" disabled></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <h6> Were X-ray given? </h6>
                    <textarea class="form-control" ng-model="data.MedicalStudentProfile.x_ray" disabled></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <h6> Were there any special problems? </h6>
                    <textarea class="form-control" ng-model="data.MedicalStudentProfile.special_problem" disabled></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <h6> ALLERGY TO: <br> Penicilin <br> Local Anesthetics(Novocain, Procaine, etc.) <br> Any other, specify </h6>
                    <textarea class="form-control" ng-model="data.MedicalStudentProfile.allergy" disabled></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <h6> Please describe any current medical treatment, including drugs, impending operationsm pregnancies, or other <br> information regarding your present health health that the doctor should be aware of it  </h6>
                    <textarea class="form-control" ng-model="data.MedicalStudentProfile.current_medical_treatment" disabled></textarea>
                  </div>
                </div>

              </div>
            </div>
          </div>

            <div class="clearfix"></div><hr>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th class = "text-left" colspan="2">UPLOADED FILES</th>
                    </tr>
                    <tr>
                      <th class="w30px text-center">#</th>
                      <th class="text-center">FILE NAME</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="image in medicalStudentProfileImage">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="uppercase text-left">
                        <a href="{{ image.imageSrc }}">{{ image.name }}</a>
                      </td>
                    </tr>
                    <tr ng-if = "medicalStudentProfileImage == ''">
                      <td class="text-center" colspan="2">No data available . . .</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          <div class="col-md-12">
            <div class="pull-right">
                <a id="pageEdit" href="#/medical-services/medical-student-profile/edit/{{ data.MedicalStudentProfile.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button type="button" class="btn btn-info  btn-min" ng-click="printMedical(data.id )"><i class="fa fa-print"></i> PRINT MEDICAL HISTORY FORM</button>
                <button type="button" class="btn btn-info  btn-min" ng-click="print(data.id )"><i class="fa fa-print"></i> PRINT MEDICAL STUDENT PROFILE FORM</button>
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.MedicalStudentProfile)"><i class="fa fa-trash"></i> DELETE </button>
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
