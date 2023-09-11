<div class="row">
    <div class="col-lg-12 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="header-title">EDIT SCHOLARSHIP APPLICATION INFORMATION</div>
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
                      <td class="text-left uppercase">{{ data.ScholarshipApplication.student_no }}</td>   
                    </tr>
                    <tr>
                      <th class="text-left"> STUDENT NAME </th>
                      <td class="text-left uppercase">{{ data.ScholarshipApplication.student_name }}</td>   
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            
            <div class="col-md-12">
                <div class="form-group">
                    <label> CONTROL NO. </label>
                    <input disabled type="text" class="form-control"
                        ng-model="data.ScholarshipApplication.code">
                </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <select selectize ng-model="data.ScholarshipApplication.program_id" ng-options="opt.id as opt.value for opt in programs" ng-change="getCourse(data.ScholarshipApplication.program_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label> YEAR LEVEL <i class="required">*</i></label>
                    <select class="form-control" ng-model="data.ScholarshipApplication.year"
                        autocomplete="false" data-validation-engine="validate[required]"
                        style="height: 44px">
                        <option value=""></option>
                        <option value="First Year">First Year</option>
                        <option value="Second Year">Second Year</option>
                        </option>
                        <option value="Third Year">Third Year</option>
                        <option value="Fourth Year">Fourth Year</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label> DATE <i class="required">*</i></label>
                    <input type="text" class="form-control datepicker" autocomplete="false"
                        ng-model="data.ScholarshipApplication.date"
                        data-validation-engine="validate[required]">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> SCHOOL YEAR <i class="required">*</i></label>
                    <input type="text" class="form-control" autocomplete="false"
                        ng-model="data.ScholarshipApplication.school_year"
                        data-validation-engine="validate[required]">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> CONTACT NUMBER <i class="required">*</i></label>
                    <input type="text" class="form-control" autocomplete="false"
                        ng-model="data.ScholarshipApplication.contact_number"
                        data-validation-engine="validate[required]">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>SEMESTER<i class="required">*</i></label>
                    <select class="form-control" ng-model="data.ScholarshipApplication.semester"
                        autocomplete="false" data-validation-engine="validate[required]"
                        style="height: 44px">
                        <option value=""></option>
                        <option value="2">2nd semester</option>
                        <option value="1">1st semester</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> CIVIL STATUS <i class="required">*</i></label>
                    <select class="form-control" ng-model="data.ScholarshipApplication.civil_status"
                        autocomplete="false" data-validation-engine="validate[required]"
                        style="height: 44px">
                        <option value=""></option>
                        <option value="Maried">Maried</option>
                        <option value="Single">Single</option>
                        </option>
                        <option value="Separated">Separated</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> AGE <i class="required">*</i></label>
                    <input number class="form-control" autocomplete="off"
                        ng-model="data.ScholarshipApplication.age"
                        data-validation-engine="validate[required]">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> RELIGION <i class="required">*</i></label>
                    <input type="text" class="form-control" autocomplete="off"
                        ng-model="data.ScholarshipApplication.religion"
                        data-validation-engine="validate[required]">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label> SEX <i class="required">*</i></label><br>
                    <label>
                        <input type="radio" ng-model="data.ScholarshipApplication.sex" value="Male">
                        Male
                    </label>&nbsp; &nbsp;&nbsp; &nbsp;
                    <label>
                        <input type="radio" ng-model="data.ScholarshipApplication.sex" value="Female">
                        Female
                    </label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> House no./Lot & Block no. <i class="required">*</i></label>
                    <input type="text" class="form-control" autocomplete="off"
                        ng-model="data.ScholarshipApplication.house_no"
                        data-validation-engine="validate[required]">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> EMAIL ADDRESS <i class="required">*</i></label>
                    <input type="text" class="form-control" autocomplete="off"
                        ng-model="data.ScholarshipApplication.email"
                        data-validation-engine="validate[required]">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> PROVINCE <i class="required">*</i></label>
                    <select selectize ng-model="data.ScholarshipApplication.province_id"
                        ng-options="opt.id as opt.value for opt in provinces"

                        ng-change="getTown(data.ScholarshipApplication.province_id)"
                        data-validation-engine="validate[required]">
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> SCHOOL NAME <i class="required">*</i></label>
                    <select selectize ng-model="data.ScholarshipApplication.school_name_id" ng-options="opt.id as opt.value for opt in school" ng-change="getSchool(data.ScholarshipApplication.school_name_id)"
                        data-validation-engine="validate[required]">
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> MUNICIPALITY <i class="required">*</i></label>
                    <select selectize ng-model="data.ScholarshipApplication.town_id"
                        ng-options="opt.id as opt.value for opt in towns"
                        ng-change="getBarangay(data.ScholarshipApplication.town_id)"
                        data-validation-engine="validate[required]">
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> SCHOOL ADDRESS <i class="required">*</i></label>
                    <input type="text" class="form-control" autocomplete="off" ng-model="data.ScholarshipApplication.school_address"
                        data-validation-engine="validate[required]">
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label> BARANGAY <i class="required">*</i></label>
                    <select selectize ng-model="data.ScholarshipApplication.barangay_id"
                        ng-options="opt.id as opt.value for opt in barangays"
                        
                        data-validation-engine="validate[required]">
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label> GENERAL AVERAGE <i class="required">*</i></label>
                    <input type="text" class="form-control" autocomplete="off"
                        ng-model="data.ScholarshipApplication.gen_ave"
                        data-validation-engine="validate[required]">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>TYPE OF SCHOLARSHIP<i class="required">*</i></label>
                    <select class="form-control" ng-model="data.ScholarshipApplication.scholarship_type"
                        autocomplete="false" data-validation-engine="validate[required]"
                        style="height: 44px">
                        <option value=""></option>
                        <option value="Non-Institutional">Non-Institutional</option>
                        <option value="Disability">Disability</option>
                        <option value="Indegenous People Group">Indegenous People Group</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> ZIP CODE<i class="required">*</i></label>
                    <input type="text" class="form-control" autocomplete="off"
                        ng-model="data.ScholarshipApplication.zip_code"
                        data-validation-engine="validate[required]">
                </div>
            </div>


           

            

            

            

            

            

            <div class="col-md-6">
                <div class="form-group">
                    <label> BIRTH DATE <i class="required">*</i></label>
                    <input type="text" class="form-control datepicker" autocomplete="false"
                        ng-model="data.ScholarshipApplication.birthdate"
                        data-validation-engine="validate[required]">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> PLACE OF BIRTH <i class="required">*</i></label>
                    <input type="text" class="form-control" autocomplete="false"
                        ng-model="data.ScholarshipApplication.place_of_birth"
                        data-validation-engine="validate[required]">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label> STUDENT STATUS <i class="required">*</i></label><br>
                    <label>
                        <input type="radio" ng-model="data.ScholarshipApplication.isnew" value="0">
                        old student
                    </label>&nbsp; &nbsp;&nbsp; &nbsp;
                    <label>
                        <input type="radio" ng-model="data.ScholarshipApplication.isnew" value="1">
                        new student
                    </label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label> GWA <i class="required">*</i></label>
                    <input type="text" class="form-control" autocomplete="false"
                        ng-model="data.ScholarshipApplication.gwa"
                        data-validation-engine="validate[required]">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> FATHER'S NAME <i class="required">*</i></label>
                    <input type="text" class="form-control uppercase" autocomplete="false"
                        ng-model="data.ScholarshipApplication.father_name"
                        data-validation-engine="validate[required]"
                        placeholder="LAST NAME/ GIVEN NAME/ MIDDLE NAME">
                </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> FATHER'S OCCUPATION <i class="required">*</i></label>
                <input type="text" class="form-control uppercase" autocomplete="false" ng-model="data.ScholarshipApplication.father_occupation" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> MOTHER'S MAIDEN NAME <i class="required">*</i></label>
                <input type="text" class="form-control uppercase" autocomplete="false" ng-model="data.ScholarshipApplication.mother_maiden" data-validation-engine="validate[required]" placeholder="LAST NAME/ GIVEN NAME/ MIDDLE NAME">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> NUMBER OF SIBLINGS <i class="required">*</i></label>
                <input number class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.number_sibling" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> HOUSEHOLD INCOME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.household_income" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> DO YOU HAVE SPONSOR <i class="required">*</i></label><br>
                <label>
                  <input type="radio" ng-model="data.ScholarshipApplication.issponsor" ng-value="true" value="1"> yes
                </label>&nbsp; &nbsp;&nbsp; &nbsp;
                <label>
                  <input type="radio" ng-model="data.ScholarshipApplication.issponsor" ng-value="false" value="0"> no
                </label>
              </div>
            </div>


            <div class="col-md-6" ng-show="data.ScholarshipApplication.issponsor">
                <div class="form-group">
                    <label> SCHOLARSHIP NAME <i class="required">*</i></label>
                    <select selectize ng-model="data.ScholarshipApplication.scholarship_name_id" ng-options="opt.id as opt.value for opt in scholarship_name" ng-change="getScholarshipName(data.ScholarshipApplication.scholarship_name_id)"
                        data-validation-engine="validate[required]">
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="col-md-6" ng-show="data.ScholarshipApplication.issponsor">
              <div class="form-group">
                <label> NAME OF SCHOLARSHIP SPONSOR/AGENCY <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.sponsor_name">
              </div>
            </div>

            <div class="col-md-6" ng-show="data.ScholarshipApplication.issponsor">
              <div class="form-group">
                <label> ADDRESS OF SPONSOR/AGENCY <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.sponsor_address">
              </div>
            </div>

            <div class="col-md-6" ng-show="data.ScholarshipApplication.issponsor">
              <div class="form-group">
                <label> CONTACT PERSON <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.contact_person">
              </div>
            </div>

            <div class="col-md-6" ng-show="data.ScholarshipApplication.issponsor">
              <div class="form-group">
                <label> POSITION <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.sponsor_position">
              </div>
            </div>

            <div class="col-md-6" ng-show="data.ScholarshipApplication.issponsor">
              <div class="form-group">
                <label> SPONSOR CONTACT OFFICE <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.sponsor_contact_office">
              </div>
            </div>

            <div class="col-md-6" ng-show="data.ScholarshipApplication.issponsor">
              <div class="form-group">
                <label> SPONSOR CONTACT MOBILE NUMBER <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.sponsor_contact_mobile">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> Why do you think you deserve to be given a scholarship assistance? <i class="required">*</i></label>
                <textarea class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.reason" data-validation-engine="validate[required]"></textarea>
              </div>
            </div>
          </div>
        </form>
                <div class="clearfix"></div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn btn-primary btn-min" id="save" ng-click="update();"><i
                                    class="fa fa-save"></i> UPDATE </button>
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