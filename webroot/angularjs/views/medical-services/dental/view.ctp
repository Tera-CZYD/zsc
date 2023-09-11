<?php if (hasAccess('dental/view', $currentUser)) : ?>
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">VIEW DENTAL INFORMATION</div>
          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-7">
              <div class="table-responsive">
                <table class="table table-striped">

                  <tr>
                    <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                    <td class="italic">{{ data.Dental.code }}</td>
                  </tr>
                  <tr>
                  <th class="text-right" style="width:15%"> PATIENT NAME : </th>
                  <td class="italic" ng-show="data.Dental.classification == 'Student'">{{ data.Dental.student_name }}</td>
                  <td class="italic" ng-show="data.Dental.classification == 'Employee'">{{ data.Dental.employee_name }}</td>
                </tr>
                  <tr>
                    <th class="text-right"> AGE : </th>
                    <td class="italic">{{ data.Dental.age }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> DATE : </th>
                    <td class="italic">{{ data.Dental.date }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> PROGRAM : </th>
                    <td class="italic">{{ data.CollegeProgram.name }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> YEAR : </th>
                    <td class="italic">{{ data.Dental.year }}</td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-md-5">

              <h5> Medical History <i class="required">*</i></h5>
              <div class="col-md-6 mx-3">
              
                <ul>
                  <li ng-if="data.Dental.exam">A recent physical exam</li>
                  <li ng-if="data.Dental.sin">Sinusitis</li>
                  <li ng-if="data.Dental.hea">Any heart problem</li>
                  <li ng-if="data.Dental.dia">Diabetes</li>
                  <li ng-if="data.Dental.high">High Blood Pressure</li>
                  <li ng-if="data.Dental.epi">Epilepsy</li>
                  <li ng-if="data.Dental.low">Low Blood Pressure</li>
                  <li ng-if="data.Dental.mal">Malignancies</li>
                  <li ng-if="data.Dental.cir">Circulatory Problems</li>
                  <li ng-if="data.Dental.rheu">Rheumatic Fever</li>
                  <li ng-if="data.Dental.nerv">Nervous Problems</li>
                  <li ng-if="data.Dental.thy">Thyroid</li>
                  <li ng-if="data.Dental.rad">Radiation Treatments</li>
                  <li ng-if="data.Dental.tb">Tuberculosis</li>
                  <li ng-if="data.Dental.ex">Excessive Breathing</li>
                  <li ng-if="data.Dental.hep">Hepatitis</li>
                  <li ng-if="data.Dental.ane">Anemia</li>
                  <li ng-if="data.Dental.ven">Venerial Disease</li>
                </ul>
              </div>
           
            </div>
            <div class="col-md-12">
              <div class="clearfix"></div>
              <hr>
            </div>
            <div class="col-md-12">
            <div class="text-right">
          
              
            <?php if (hasAccess('dental/appr', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="appr(data.Dental)" ng-disabled=" data.Dental.status == 3 || data.Dental.status == 1 || data.Dental.status == 2" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <?php endif ?>
              
              <?php if (hasAccess('dental/disappr', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="disappr(data.Dental)" ng-disabled="data.Dental.status == 1 || data.Dental.status == 2 || data.Dental.status == 4" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> DISAPPROVE </button>
              <?php endif ?>
           
              <?php if (hasAccess('dental/treat', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="treat(data.Dental)" ng-disabled=" data.Dental.status == 0 || data.Dental.status == 1 || data.Dental.status == 2 || data.Dental.status == 4" class="btn btn-warning  btn-min" ><i class="fa fa-check"></i> TREAT </button>
              <?php endif ?>
              <br>
              <?php if (hasAccess('dental/refer', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="refer(data.Dental)" ng-disabled=" data.Dental.status == 0 ||  data.Dental.status == 1 || data.Dental.status == 2 || data.Dental.status == 4" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> REFER </button>
              <?php endif ?>
              <?php if (hasAccess('dental/edit', $currentUser)): ?>
              <a href="#/medical-services/dental/edit/{{ data.Dental.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('dental/print', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.Dental.id )"><i class="fa fa-print"></i> PRINT DENTAL FORM </button>
              <?php endif ?>
              <?php if (hasAccess('dental/delete', $currentUser)): ?>
              <button class="btn btn-danger btn-min" ng-click="remove(data.Dental)"><i class="fa fa-trash"></i> DELETE </button>
              <?php endif ?>
          
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
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