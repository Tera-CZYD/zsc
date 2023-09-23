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
  handleAccess('pageView', 'cat/view', currentUser);
  handleAccess('pageQualify', 'cat/qualify application', currentUser);
  handleAccess('pageUnqualify', 'cat/unqualify application', currentUser);
  handleAccess('pagePrintForm', 'cat/print cat', currentUser);


</script>


<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW STUDENT APPLICATION INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> FIRST NAME : </th>
                  <td class="italic">{{ data.StudentApplication.first_name }}</td>
                  <th class="text-right"> STUDENT ID NUMBER : </th>
                  <td class="italic">{{ data.StudentApplication.student_no }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> MIDDLE NAME : </th>
                  <td class="italic">{{ data.StudentApplication.middle_name }}</td>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> LAST NAME : </th>
                  <td class="italic">{{ data.StudentApplication.last_name }}</td>
                  <th class="text-right"> PREFERRED PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> AUXILLIARY NAME : </th>
                  <td class="italic">{{ data.StudentApplication.auxilliary_name }}</td>
                  <th class="text-right"> SECONDARY PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgramSecondary.name }}</td>
                  
                </tr>
                <tr>
                  <th class="text-right"> EMAIL : </th>
                  <td class="italic">{{ data.StudentApplication.email }}</td>
                  <th class="text-right"> NAME OF PARENTS/GUARDIAN : </th>
                  <td class="italic">{{ data.StudentApplication.guardian_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE OF BIRTH : </th>
                  <td class="italic">{{ data.StudentApplication.birth_date }}</td>
                  <th class="text-right"> ADDRESS OF PARENTS/GUARDIAN : </th>
                  <td class="italic">{{ data.StudentApplication.guardian_address }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PLACE OF BIRTH : </th>
                  <td class="italic">{{ data.StudentApplication.birth_place }}</td>
                  <th class="text-right"> CONTACT NO. OF PARENTS/GUARDIAN : </th>
                  <td class="italic">{{ data.StudentApplication.guardian_contact }}</td>
                </tr>
                <tr>
                  <th class="text-right"> RELIGION : </th>
                  <td class="italic">{{ data.StudentApplication.religion }}</td>
                  <th class="text-right"> OCCUPATION OF PARENTS/GUARDIAN : </th>
                  <td class="italic">{{ data.StudentApplication.guardian_occupation }}</td>
                </tr>
                <tr>
                  <th class="text-right"> NATIONALITY : </th>
                  <td class="italic">{{ data.StudentApplication.nationality }}</td>
                  <th class="text-right"> LAST SCHOOL ATTENDED : </th>
                  <td class="italic">{{ data.StudentApplication.last_school }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CIVIL STATUS : </th>
                  <td class="italic">{{ data.StudentApplication.civil_status }}</td>
                  <th class="text-right"> ADDRESS OF LAST SCHOOL ATTENDED : </th>
                  <td class="italic">{{ data.StudentApplication.last_school_address }}</td>
                </tr>
                

                <tr>
                  <th class="text-right"> ADDRESS : </th>
                  <td class="italic">{{ data.StudentApplication.address }}</td>
                  <th class="text-right"> GRADE : </th>
                  <td class="italic">{{ data.StudentApplication.grade }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONTACT NO. : </th>
                  <td class="italic">{{ data.StudentApplication.contact_no }}</td>
                  <th class="text-right"> TYPE OF STUDENT : </th>
                  <td class="italic">{{ data.StudentApplication.student_type }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GENDER : </th>
                  <td class="italic">{{ data.StudentApplication.gender }}</td>
                  <th class="text-right"> CURRICULUM : </th>
                  <td class="italic">{{ data.StudentApplication.curriculum }}</td>
                </tr>
                <tr>
                  <th class="text-right"> MEMBERSHIP SCHOOL CLUBS : </th>
                  <td class="italic">{{ data.StudentApplication.frat }}</td>
                  <th class="text-right"> SCHOOL TYPE : </th>
                  <td class="italic">{{ data.StudentApplication.school_type }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STATUS : </th>
                  <td class="italic" ng-if="data.StudentApplication.approve == 0" >PENDING</td>
                  <td class="italic" ng-if="data.StudentApplication.approve == 1" >APPROVED</td>
                  <td class="italic" ng-if="data.StudentApplication.approve == 2" >DISAPPROVED</td>
                  <th class="text-right"> YEAR GRADUATED : </th>
                  <td class="italic">{{ data.StudentApplication.year_graduated }}</td>
                </tr>
                <tr ng-if="data.StudentApplication.approve == 1">
                  <th class="text-right"> APPROVED DATE : </th>
                  <td class="italic" colspan="3">{{ data.StudentApplication.approved_date }}</td>
                </tr>
                <tr ng-if="data.StudentApplication.approve == 2">
                  <th class="text-right"> DISAPPROVED DATE : </th>
                  <td class="italic" colspan="3">{{ data.StudentApplication.disapproved_date }}</td>
                </tr>
                <tr ng-if="data.StudentApplication.approve == 2">
                  <th class="text-right"> REASON : </th>
                  <td class="italic" colspan="3">{{ data.StudentApplication.disapproved_reason }}</td>
                </tr>
                <tr>
              </table>
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
                    <tr ng-repeat="image in applicationImage">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="uppercase text-left">
                        <a href="{{ image.imageSrc }}">{{ image.name }}</a>
                      </td>
                    </tr>
                    <tr ng-if = "applicationImage == ''">
                      <td class="text-center" colspan="2">No data available . . .</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-md-12">
              <div class="row">
                <div class="col-md-1">
                  <div class="form-group">
                    <label>PSA</label>
                  </div>
                </div>
                <div class="col-md-11">
                  <div class="form-group">
                    <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.StudentApplication.psa" ng-change="updatePsa(data.StudentApplication)">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                  <div class="form-group">
                    <label>FORM 137</label>
                  </div>
                </div>
                <div class="col-md-11">
                  <div class="form-group">
                    <input icheck type="checkbox" class="form-control" autocomplete="false" ng-change="updateForm(data.StudentApplication)" ng-model="data.StudentApplication.form_137">
                  </div>
                </div>
              </div>
            </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <button id="pageQualify" href="javascript:void(0)" ng-click="qualify(data.StudentApplication)" ng-disabled="data.StudentApplication.approve == 4 || data.StudentApplication.approve == 5" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> QUALIFY </button>
                <button id="pageUnqualify" href="javascript:void(0)" ng-click="unqualify(data.StudentApplication)" ng-disabled="data.StudentApplication.approve == 4 || data.StudentApplication.approve == 5" class="btn btn-warning  btn-min" ><i class="fa fa-close"></i> UNQUALIFY </button>
                <button id="pagePrintForm" type="button" class="btn btn-info  btn-min" ng-click="print(data.StudentApplication.id )"><i class="fa fa-print"></i> PRINT CAT </button>
            </div>
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
