<style type="text/css">
  

  @media (min-width:992px) {
      .page-container {
          max-width: 1140px;
          margin: 0 auto
      }

      .page-sidenav {
          display: block !important
      }
  }

  .padding {
      padding: 2rem
  }

  .w-32 {
      width: 32px !important;
      height: 32px !important;
      font-size: .85em
  }

  .tl-item .avatar {
      z-index: 2
  }

  .circle {
      border-radius: 500px
  }

  .gd-warning {
      color: #fff;
      border: none;
      background: #f4c414 linear-gradient(45deg, #f4c414, #f45414)
  }

  .timeline {
      position: relative;
      border-color: rgba(160, 175, 185, .15);
      padding: 0;
      margin: 0
  }

  .p-4 {
      padding: 1.5rem !important
  }

  .block,
  .card {
      background: #fff;
      border-width: 0;
      border-radius: .25rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
      margin-bottom: 1.5rem
  }

  .mb-4,
  .my-4 {
      margin-bottom: 1.5rem !important
  }

  .tl-item {
      border-radius: 3px;
      position: relative;
      display: -ms-flexbox;
      display: flex
  }

  .tl-item>* {
      padding: 10px
  }

  .tl-item .avatar {
      z-index: 2
  }

  .tl-item:last-child .tl-dot:after {
      display: none
  }

  .tl-item.active .tl-dot:before {
      border-color: #448bff;
      box-shadow: 0 0 0 4px rgba(68, 139, 255, .2)
  }

  .tl-item:last-child .tl-dot:after {
      display: none
  }

  .tl-item.active .tl-dot:before {
      border-color: #448bff;
      box-shadow: 0 0 0 4px rgba(68, 139, 255, .2)
  }

  .tl-dot {
      position: relative;
      border-color: rgba(160, 175, 185, .15)
  }

  .tl-dot:after,
  .tl-dot:before {
      content: '';
      position: absolute;
      border-color: inherit;
      border-width: 2px;
      border-style: solid;
      border-radius: 50%;
      width: 10px;
      height: 10px;
      top: 15px;
      left: 50%;
      transform: translateX(-50%)
  }

  .tl-dot:after {
      width: 0;
      height: auto;
      top: 25px;
      bottom: -15px;
      border-right-width: 0;
      border-top-width: 0;
      border-bottom-width: 0;
      border-radius: 0
  }

  tl-item.active .tl-dot:before {
      border-color: #448bff;
      box-shadow: 0 0 0 4px rgba(68, 139, 255, .2)
  }

  .tl-dot {
      position: relative;
      border-color: rgba(160, 175, 185, .15)
  }

  .tl-dot:after,
  .tl-dot:before {
      content: '';
      position: absolute;
      border-color: inherit;
      border-width: 2px;
      border-style: solid;
      border-radius: 50%;
      width: 10px;
      height: 10px;
      top: 15px;
      left: 50%;
      transform: translateX(-50%)
  }

  .tl-dot:after {
      width: 0;
      height: auto;
      top: 25px;
      bottom: -15px;
      border-right-width: 0;
      border-top-width: 0;
      border-bottom-width: 0;
      border-radius: 0
  }

  .tl-content p:last-child {
      margin-bottom: 0
  }

  .tl-date {
      font-size: .85em;
      margin-top: 2px;
      min-width: 100px;
      max-width: 200px
  }

  .avatar {
      position: relative;
      line-height: 1;
      border-radius: 500px;
      white-space: nowrap;
      font-weight: 700;
      border-radius: 100%;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-pack: center;
      justify-content: center;
      -ms-flex-align: center;
      align-items: center;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      border-radius: 500px;
      box-shadow: 0 5px 10px 0 rgba(50, 50, 50, .15)
  }

  .b-warning {
      border-color: #f4c414!important;
  }

  .b-primary {
      border-color: #448bff!important;
  }

  .b-danger {
      border-color: #f54394!important;
  }
</style>

<div class="row">
  <div class="col-md-4">
    <div class="card" style="height:400px;">
      <div class="card-body">
        <p class="card-title font-weight-bold" style="font-size:15px;">Enrolled Subject Statistics</p>
        <div class="single-table">
          <div class="table-responsive">
            <table class="table table-hover text-center">
              <thead>
                <tr class="table-secondary">
                  <th class="text-left" style="font-size:12px;font-weight: normal;"> REMARKS </th>
                  <th class="text-center" style="font-size:12px;font-weight: normal;"> TOTAL </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-left">Enrolled Subjects</td>
                  <td class="text-center">{{ total_sub }}</td>
                </tr>
                <tr>
                  <td class="text-left">Passed</td>
                  <td class="text-center">{{ passed }}</td>
                </tr>
                <tr>
                  <td class="text-left">Failed</td>
                  <td class="text-center">{{ failed }}</td>
                </tr>
                <tr>
                  <td class="text-left">Credited</td>
                  <td class="text-center">{{ credited }}</td>
                </tr>
                <tr>
                  <td class="text-left">Incomplete</td>
                  <td class="text-center">{{ incomplete }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card" style="height:400px;">
      <div class="card-body">
        <div id="container" style="height:350px;"></div>
        <div class="clearfix"></div>
      </div>
    </div>
    
  </div>
  <div class="col-md-4">
    <div class="card" style="height:400px;">
      <div class="card-body" style="overflow-y:scroll;">
        <p class="card-title font-weight-bold" style="font-size:15px;">Schedule For Today</p>

          <div class="tl-item" ng-repeat = "sched in scheds">
            <div class="tl-dot b-primary"></div>
            <div class="tl-content">
              <div class="">{{sched.course}}</div>
              <div class="tl-date text-muted mt-1">{{sched.faculty_name}}</div>
              <div class="tl-date text-muted mt-1">{{sched.room}} - {{sched.time_start}} - {{sched.time_end}}</div>

            </div>
          </div>
          <div class="single-table" ng-show="scheds == null || scheds == ''">
            <div class="table-responsive">
              <table class="table table-hover text-center">
                <thead>
                  <tr class="table-info">
                    <th style="font-size:12px;font-weight: normal;"> No Class for today </th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>  
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-lg-6"ng-show="student_subjects != null && student_subjects != '' ">
    <div class="card">
      <div class="card-body">
        <p class="card-title" style="font-size:15px;">FAILED SUBJECTS</p>
        <span class="card-text text-danger">*This is to inform you that you have failed on the following subjects.</span>
        <div class="single-table">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="bg-info">
                  <th class="text-center text-light"> SUBJECT </th>
                  <th class="text-center text-light"> FACULTY NAME </th>
                  <th class="text-center text-light"> FINAL GRADE </th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="data in student_subjects">
                  <td class="text-center">{{ data.course }}</td>
                  <td class="text-center">{{ data.faculty_name }}</td>
                  <td class="text-center text-danger font-weight-bold">{{ data.final_grade }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-6" ng-show="clearance != null && clearance != '' ">
    <div class="card">
      <div class="card-body">
        <p class="card-title" style="font-size:15px;">INCOMPLETE CLEARANCE REQUIREMENTS</p>
        <span class="card-text text-danger">*This is to inform you that you have incomplete requirements on the following Faculty.</span>
        <div class="single-table">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="bg-info">
                  <th class="text-center text-light"> FACULTY NAME </th>
                  <th class="text-center text-light"> SUBJECT / POSITION </th>
                  <th class="text-center text-light"> REMARKS </th>
                  <th class="text-center text-light"> STATUS </th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat=" data in clearance">
                  <td class="text-center">{{ data.faculty_name }}</td>
                  <td class="text-center">{{ data.course_code }}</td>
                  <td class="text-center">{{ data.clearance_remarks }}</td>
                  <td class="text-center text-danger font-weight-bold"> {{ data.clearance_status == 1 ? 'CLEARED' : ( data.clearance_status == 2 ? 'INC' : 'PENDING') }}  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  .img-list {
    margin-bottom: 20px;
    height: 250px;
    width: 100%;
    overflow-x: auto;
  }
  #img-container {
    height: 100%;
    position: relative;
    white-space:nowrap;
  }

  #img-container img {
    height: 100%;
    display: inline-block;
    vertical-align:top; /*to remove unwanted whitespace */
    position: relative;
  }

</style>

<div class="modal fade" id="view-image-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <img src="{{ imageSrc }}" width="100%" height="100%" style="border-radius : 2px; margin-bottom : 10px">
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-group btn-group-sm pull-right btn-min">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"> CANCEL</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="medicalInterviewModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"> Request Medical Interview </h5>
      </div>
      <div class="modal-body">
        <form id="medical_interview">  
          
          <div class="col-md-12">
            <div class="form-group">
              <label> PURPOSE <i class="required">*</i></label>
              <textarea class="form-control" autocomplete="off" ng-model="tmpData.purpose" data-validation-engine="validate[required]"></textarea>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="requestMedicalInterview(tmpData)"><i class="fa fa-save"></i> SUBMIT </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="notifModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"> For Interview Schedule </h5>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <img src="{{ base }}/assets/img/come_back_later.png" width="100%">
        </div>
        <div class="col-md-12">
          <p>You have requested a medical interview. Wait for a interview schedule to be sent by Admission Office.</p>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="notifPendingPaymentModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"> You have a pending payment in apartelle/dormitory </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <img src="{{ base }}/assets/img/come_back_later.png" width="100%">
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-group btn-group-sm pull-right btn-min">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"> CANCEL</button>
        </div>
      </div>
    </div>
  </div>
</div>
