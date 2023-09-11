<div class="row">
<div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">MEDICAL CERTIFICATE INFORMATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.MedicalCertificate.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> PATIENT NAME : </th>
                  <td class="italic">{{ data.MedicalCertificate.student_name }}</td>

                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.MedicalCertificate.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th> 
                  <td class="italic">{{ data.Course.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.YearLevelTerm.description }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.MedicalCertificate.description }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">

            

              <a href="#/medical-services/medical-certificate/edit/{{ data.MedicalCertificate.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.MedicalCertificate.id )"><i class="fa fa-print"></i> PRINT MEDICAL CERTIFICATE </button>
          
              <button class="btn btn-danger btn-min" ng-click="remove(data.MedicalCertificate)"><i class="fa fa-trash"></i> DELETE </button>
         
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