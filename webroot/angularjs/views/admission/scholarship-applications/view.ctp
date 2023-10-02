<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
          <div class="header-title">VIEW SCHOLARSHIP APPLICATION INFORMATION</div>
          <div class="clearfix"></div>
          <hr>
          <div class="row">
              <div class="col-md-12">
                  <div class="table-responsive">
                      <table class="table table-striped">

                          <tr>
                              <th class="text-left" style="width:15%"> CONTROL NUMBER : </th>
                              <td class="italic">{{ data.ScholarshipApplication.code }}</td>
                          </tr>

                          <tr>
                              <th class="text-left"> STUDENT NAME : </th>
                              <td class="italic">{{ data.ScholarshipApplication.student_name }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> DATE : </th>
                              <td class="italic">{{ data.ScholarshipApplication.date }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> PROGRAM : </th>
                              <td class="italic">{{ data.CollegeProgram.name }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> YEAR LEVEL : </th>
                              <td class="italic">{{ data.ScholarshipApplication.year }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> SCHOOL YEAR : </th>
                              <td class="italic">{{ data.ScholarshipApplication.school_year }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> SEX : </th>
                              <td class="italic">{{ data.ScholarshipApplication.sex }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> HOUSE NO./LOT & BLOCK NO. : </th>
                              <td class="italic">{{ data.ScholarshipApplication.house_no }}</td>
                          </tr>
                          <!-- <tr>
                              <th class="text-left"> PRESENT ADDRESS : </th>
                              <td class="italic">{{ data.ScholarshipApplication.present_address }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> PROVINCIAL ADDRESS : </th>
                              <td class="italic">{{ data.ScholarshipApplication.provincial_address }}</td>
                          </tr> -->
                          <tr>
                              <th class="text-left"> CIVIL STATUS : </th>
                              <td class="italic">{{ data.ScholarshipApplication.civil_status }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> DATE : </th>
                              <td class="italic">{{ data.ScholarshipApplication.date }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> CONTACT # : </th>
                              <td class="italic">{{ data.ScholarshipApplication.contact_number }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> EMAIL : </th>
                              <td class="italic">{{ data.ScholarshipApplication.email }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> SCHOOL GRADUATED : </th>
                              <td class="italic">{{ data.School.school_name }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> SCHOOL ADDRESS : </th>
                              <td class="italic">{{ data.ScholarshipApplication.school_address }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> GENERAL AVERAGE : </th>
                              <td class="italic">{{ data.ScholarshipApplication.gen_ave }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> RELIGION : </th>
                              <td class="italic">{{ data.ScholarshipApplication.religion }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> BIRTHDATE : </th>
                              <td class="italic">{{ data.ScholarshipApplication.birthdate }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> AGE : </th>
                              <td class="italic">{{ data.ScholarshipApplication.age }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> PLACE OF BIRTH : </th>
                              <td class="italic">{{ data.ScholarshipApplication.place_of_birth }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> GWA : </th>
                              <td class="italic">{{ data.ScholarshipApplication.gwa }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> FATHER'S NAME : </th>
                              <td class="italic">{{ data.ScholarshipApplication.father_name }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> OCCUPATION : </th>
                              <td class="italic">{{ data.ScholarshipApplication.father_occupation }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> MOTHER'S MAIDEN NAME : </th>
                              <td class="italic">{{ data.ScholarshipApplication.mother_maiden }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> NUMBER OF SIBLINGS : </th>
                              <td class="italic">{{ data.ScholarshipApplication.number_sibling }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> HOUSEHOLD INCOME : </th>
                              <td class="italic">{{ data.ScholarshipApplication.household_income }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> SCHOLARSHIP NAME : </th>
                              <td class="italic">{{ data.ScholarshipApplication.scholarship_name_id }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> NAME OF SCHOLARSHIP SPONSOR/AGENCY : </th>
                              <td class="italic">{{ data.ScholarshipApplication.sponsor_name }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> ADDRESS OF SCHOLARSHIP SPONSOR/AGENCY : </th>
                              <td class="italic">{{ data.ScholarshipApplication.sponsor_address }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> CONTACT PERSON : </th>
                              <td class="italic">{{ data.ScholarshipApplication.contact_person }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> POSITION : </th>
                              <td class="italic">{{ data.ScholarshipApplication.sponsor_position }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> SPONSOR CONTACT NUMBER OFFICE : </th>
                              <td class="italic">{{ data.ScholarshipApplication.sponsor_contact_office }}</td>
                          </tr>
                          <tr>
                              <th class="text-left"> SPONSOR CONTACT NUMBER MOBILE : </th>
                              <td class="italic">{{ data.ScholarshipApplication.sponsor_contact_mobile }}</td>
                          </tr>
                      </table>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="clearfix"></div>
                  <hr>
              </div>
              <div class="col-md-12">
                <div class="pull-right">
                  <a href="#/admission/scholarship-application/edit/{{ data.ScholarshipApplication.id }}"
                      class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                 
                  <button type="button" class="btn btn-info  btn-min"
                      ng-click="print(data.ScholarshipApplication.id )"><i class="fa fa-print"></i> PRINT
                      SCHOLARSHIP APPLICATION FORM </button>
                 
                  <button class="btn btn-danger btn-min" ng-click="remove(data.ScholarshipApplication)"><i
                          class="fa fa-trash"></i> DELETE
                  </button>
                 
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