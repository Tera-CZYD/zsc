<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">CONSULTATION INFORMATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.Consultation.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> PATIENT NAME : </th>
                  <td class="italic">{{ data.Consultation.student_name }}</td>
               
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.Consultation.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> AGE : </th>
                  <td class="italic">{{ data.Consultation.age }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SEX : </th>
                  <td class="italic">{{ data.Consultation.sex }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ADDRESS : </th>
                  <td class="italic">{{ data.Consultation.address }}</td>
                </tr>
                <tr>
                  <th class="text-right"> HEIGHT : </th>
                  <td class="italic">{{ data.Consultation.height }}</td>
                </tr>
                <tr>
                  <th class="text-right"> WEIGHT : </th>
                  <td class="italic">{{ data.Consultation.weight }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr class="bg-info">
                  <th colspan="5">SUB INFORMATION</th>
                </tr>
                <tr>
                  <th class="w30px text-center">#</th>
                  <th class="text-center">DATE</th>
                  <th class="text-center">CHIEF COMPLAINTS</th>
                  <th class="text-center">TREATMENTS</th>
                  <th class="text-center">REMARKS</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="datax in data.ConsultationSub">
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td class="text-center">{{ datax.date | date: 'MM/dd/yyyy'}}</td>
                  <td class="text-center">{{ datax.chief_complaints }}</td>
                  <td class="text-center">{{ datax.treatments }}</td>
                  <td class="text-center">{{ datax.remarks }}</td>
                </tr>
              </tbody>
              <tbody ng-if="data.ConsultationSub == ''">
                <td colspan="6" class="text-center">No data available</td>
              </tbody>
            </table>
          </div>


          <div class="col-md-12">
            <div class="pull-right">
             
              <a href="#/medical-services/consultation/student-edit/{{ data.Consultation.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
  
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.Consultation.id )"><i class="fa fa-print"></i> PRINT CONSULTATION </button>
 
              <button class="btn btn-danger btn-min" ng-click="remove(data.Consultation)"><i class="fa fa-trash"></i> DELETE </button>
          
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