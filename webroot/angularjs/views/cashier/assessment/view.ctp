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
  handleAccess('pageView', 'assessment/view', currentUser);
  handleAccess('pageDelete', 'assessment/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW ASSESSMENT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.Assessment.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.Assessment.program }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="italic">{{ data.Assessment.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> EMAIL : </th>
                  <td class="italic">{{ data.Assessment.email }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONTACT NO. : </th>
                  <td class="italic">{{ data.Assessment.contact_no }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>

            <div class="form-group">
              <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <th class="bg-info" colspan="6">MISCELLANEOUS</th>
                </thead>
                <thead>
                  <tr>
                    <th class="text-center">NAME</th>
                    <th class="text-center">AMOUNT</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="uppercase w200px">TUITION</td>
                    <td class="uppercase">{{ data.AssessmentSub[0].tuition_fee }}</td>
                  </tr>
                  <tr>
                    <td class="uppercase w200px">ATHLETICS FEE</td>
                    <td class="uppercase">{{ data.AssessmentSub[0].athletics_fee }}</td>
                  </tr>
                  <tr>
                    <td class="uppercase w200px">CULTURAL FEE</td>
                    <td class="uppercase">{{ data.AssessmentSub[0].cultural_fee }}</td>
                  </tr>
                  <tr>
                    <td class="uppercase w200px">DEVELOPMENT FEE</td>
                    <td class="uppercase">{{ data.AssessmentSub[0].development_fee }}</td>
                  </tr>
                  <tr>
                    <td class="uppercase w200px">GUIDANCE</td>
                    <td class="uppercase">{{ data.AssessmentSub[0].guidance_fee }}</td>
                  </tr>
                  <tr>
                    <td class="uppercase w200px">LABORATORY FEE</td>
                    <td class="uppercase">{{ data.AssessmentSub[0].laboratory_fee }}</td>
                  </tr>
                  <tr>
                    <td class="uppercase w200px">LIBRARY FEE</td>
                    <td class="uppercase">{{ data.AssessmentSub[0].library_fee }}</td>
                  </tr>
                  <tr>
                    <td class="uppercase w200px">MEDICAL/DENTAL FEE</td>
                    <td class="uppercase">{{ data.AssessmentSub[0].medical_dental_fee }}</td>
                  </tr>
                  <tr>
                    <td class="uppercase w200px">COMPUTER FEE</td>
                    <td class="uppercase">{{ data.AssessmentSub[0].computer_fee }}</td>
                  </tr>
                  <tr>
                    <td class="uppercase w200px">JEEP FEE</td>
                    <td class="uppercase">{{ data.AssessmentSub[0].jeep_fee }}</td>
                  </tr>
                </tbody>
                <tfoot ng-if="data.AssessmentSub != ''">
                  <tr>
                    <th class="text-left">TOTAL</th>
                    <th class="text-left">{{ data.AssessmentSub[0].total | number : 2 }}</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            </div>

          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <button id="pageApprove" href="javascript:void(0)" ng-click="approve(data.Assessment)" ng-disabled="data.Assessment.approve == 1" class="btn btn-warning  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.Assessment)"><i class="fa fa-trash"></i> DELETE </button>
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
