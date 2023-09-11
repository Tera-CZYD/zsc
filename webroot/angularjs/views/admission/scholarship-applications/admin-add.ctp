<?php if (hasAccess('scholarship application/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW SCHOLARSHIP APPLICATION</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.ScholarshipApplication.code">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudent({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> STUDENT <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.ScholarshipApplication.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.ScholarshipApplication.student_name }}</td>
                    <td style="{{ data.ScholarshipApplication.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.ScholarshipApplication.student_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.ScholarshipApplication.student_name = null; data.ScholarshipApplication.student_id = null;" ng-init="data.ScholarshipApplication.student_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>
                </table>
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
                <label> YEAR TERM </label>
                <select selectize ng-model="data.ScholarshipApplication.year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change = "getYear(data.ScholarshipApplication.year_term_id)">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.ScholarshipApplication.date" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> SCHOOL YEAR <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.school_year" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> CONTACT NUMBER <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.contact_number" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>SEMESTER<i class="required">*</i></label>
                <select class="form-control" ng-model="data.ScholarshipApplication.semester" autocomplete="false" data-validation-engine="validate[required]" style="height: 44px">
                  <option value=""></option>
                  <option value="2">2nd semester</option>
                  <option value="1">1st semester</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> CIVIL STATUS <i class="required">*</i></label>
                <select class="form-control" ng-model="data.ScholarshipApplication.civil_status" autocomplete="false" data-validation-engine="validate[required]" style="height: 44px">
                  <option value=""></option>
                  <option value="Maried">Maried</option>
                  <option value="Single">Single</option>
                  <option value="Separated">Separated</option>
                  <option value="Widowed">Widowed</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> AGE <i class="required">*</i></label>
                <input number class="form-control" autocomplete="off" ng-model="data.ScholarshipApplication.age" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> RELIGION <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.ScholarshipApplication.religion" data-validation-engine="validate[required]">
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
                <input type="text" class="form-control" autocomplete="off" ng-model="data.ScholarshipApplication.house_no" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> EMAIL ADDRESS <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.ScholarshipApplication.email" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> PROVINCE <i class="required">*</i></label>
                <select selectize ng-model="data.ScholarshipApplication.province_id" ng-options="opt.id as opt.value for opt in provinces" ng-change="getTown(data.ScholarshipApplication.province_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> SCHOOL GRADUATED <i class="required">*</i></label>
                <select selectize ng-model="data.ScholarshipApplication.school_name_id" ng-options="opt.id as opt.value for opt in school" ng-change="getSchool(data.ScholarshipApplication.school_name_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> MUNICIPALITY <i class="required">*</i></label>
                <select selectize ng-model="data.ScholarshipApplication.town_id" ng-options="opt.id as opt.value for opt in towns" ng-change="getBarangay(data.ScholarshipApplication.town_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6" ng-hide="data.ScholarshipApplication.school_name_id == '7'">
              <div class="form-group">
                <label> SCHOOL ADDRESS <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.ScholarshipApplication.school_address" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3" ng-show="data.ScholarshipApplication.school_name_id == '7'">
              <div class="form-group">
                <label> NAME OF SCHOOL <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.ScholarshipApplication.name_of_school" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3" ng-show="data.ScholarshipApplication.school_name_id == '7'">
              <div class="form-group">
                <label> OTHERS SCHOOL ADDRESS <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.ScholarshipApplication.school_address" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> BARANGAY <i class="required">*</i></label>
                <select selectize ng-model="data.ScholarshipApplication.barangay_id" ng-options="opt.id as opt.value for opt in barangays" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> GENERAL AVERAGE <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.ScholarshipApplication.gen_ave" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>TYPE OF SCHOLARSHIP<i class="required">*</i></label>
                <select class="form-control" ng-model="data.ScholarshipApplication.scholarship_type" autocomplete="false" data-validation-engine="validate[required]" style="height: 44px">
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
                <input type="text" class="form-control" autocomplete="off" ng-model="data.ScholarshipApplication.zip_code" data-validation-engine="validate[required]">
              </div>
            </div>


            <div class="col-md-6">
              <div class="form-group">
                <label> BIRTH DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.ScholarshipApplication.birthdate" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> PLACE OF BIRTH <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.place_of_birth" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> STUDENT STATUS <i class="required">*</i></label><br>
                <select class="form-control" ng-model="data.ScholarshipApplication.isnew" autocomplete="false" data-validation-engine="validate[required]" style="height: 44px">
                  <option value="0">Old Student</option>
                  <option value="1">New Student</option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> GWA <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.gwa" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> FATHER'S NAME <i class="required">*</i></label>
                <input type="text" class="form-control uppercase" autocomplete="false" ng-model="data.ScholarshipApplication.father_name" data-validation-engine="validate[required]" placeholder="LAST NAME/ GIVEN NAME/ MIDDLE NAME">
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
                <label> HOUSEHOLD ANNUAL INCOME <i class="required">*</i></label>
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
                <label> NAME OF SCHOLARSHIP <i class="required">*</i></label>
                <select selectize ng-model="data.ScholarshipApplication.scholarship_name_id" ng-options="opt.id as opt.value for opt in scholarship_name" ng-change="getScholarshipName(data.ScholarshipApplication.scholarship_name_id)" data-validation-engine="validate[required]">
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

            <!-- <div class="col-md-6" ng-show="data.ScholarshipApplication.issponsor">
              <div class="form-group">
                <label> POSITION <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ScholarshipApplication.sponsor_position">
              </div>
            </div> -->

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
              <button class="btn btn-primary btn-min" id="save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="searched-student-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADVANCE SEARCH</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered vcenter table-striped table-condensed">
              <thead>
                <tr>
                  <th class="w30px">#</th>
                  <th class="text-center">STUDENT NUMBER</th>
                  <th class="text-center">NAME</th>
                  <th class="w30px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="student in students">
                  <td>{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
                  <td class="uppercase text-center">{{ student.code }}</td>
                  <td class="uppercase text-center">{{ student.name }}</td>
                  <td>
                    <input icheck type="radio" ng-init="student.selected = false" ng-model="student.selected" name="iCheck" ng-selected="student.selected = true" ng-change="selectedStudent(student)">
                  </td>
                </tr>
              </tbody>
              <tfoot ng-show="paginator.pageCount > 0">
                <tr>
                  <td colspan="4" class="text-center">
                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col-md-12">
                        <ul class="pagination justify-content-center">
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&laquo;&laquo;</sub></a>
                          </li>
                          <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&laquo;</a>
                          </li>
                          <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                            <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">{{ page.number }}</a>
                          </li>
                          <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&raquo;</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&raquo;&raquo;</sub> </a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="text-center" ng-show="paginator.pageCount > 0">
                          <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>  
      </div> 

      <div class="modal-footer">
        <div class="pull-right">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="studentData(employee.id)" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
        </div> 
        
      </div>
    </div>  
  </div><!-- /.modal-content -->
</div>
<?php endif ?>
<style type="text/css">
th {
    white-space: nowrap;
}

td {
    white-space: nowrap;
}
</style>