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
      max-width: 100%
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
      <div class="card-body" style="overflow-y:scroll;">
        <p class="card-title font-weight-bold" style="font-size:15px;">SCHEDULE FOR TODAY</p>

          <div class="tl-item" ng-repeat = "sched in scheds">
            <div class="tl-dot b-primary"></div>
            <div class="tl-content">
              <div class="">{{sched.course}}</div>
              <div class="tl-date text-muted mt-1">{{sched.block_section_schedule.block_section.program}} - {{sched.section}}</div>
              <div class="tl-date text-muted mt-1">{{sched.room}} - {{sched.time_start}} - {{sched.time_end}}</div>
            </div>
          </div>
          <div class="single-table" ng-show="scheds == null || scheds == ''">
            <div class="table-responsive">
              <table class="table table-hover text-center">
                <thead>
                  <tr class="table-info">
                    <th style="font-size:12px;font-weight: normal;"> No Class for today</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card" style="height:400px;">
      <div class="card-body" style="overflow-y:scroll;">
        <p class="card-title font-weight-bold" style="font-size:15px;">CLEARANCE STATUS OF STUDENTS</p>
        <div class="single-table">
          <div class="table-responsive">
            <table class="table table-hover text-center">
              <thead>
                <tr class="table-info">
                  <th class="text-left" style="font-size:12px;font-weight: normal;"> REMARKS </th>
                  <th class="text-center" style="font-size:12px;font-weight: normal;"> PENDING </th>
                  <th class="text-center" style="font-size:12px;font-weight: normal;"> INCOMPLETE </th>
                  <th class="text-center" style="font-size:12px;font-weight: normal;"> CLEARED </th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="count in counts">
                  <td class="text-left">{{count.subject}}</td>
                  <td class="text-center">{{ count.pending }}</td>
                  <td class="text-center">{{ count.inc }}</td>
                  <td class="text-center">{{ count.cleared }}</td>
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

    <div>
      <div class="card" style="height:188px;">
        <div class="card-body" style="overflow-y:scroll;">
          <div class="single-table">
            <div class="table-responsive">
              <table class="table table-hover text-center">
                <thead>
                  <tr class="table-info">
                    <th style="font-size:12px;font-weight: normal;"> MEMORANDUMS </th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="memo in memos">
                    <td><span ><a href="{{ memo.memo.memorandum_images[0].imageSrc }}">{{ memo.memo.title }}</a></span></td>
                   
                  </tr>
                
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="card" style="height:188px;">
        <div class="card-body" style="overflow-y:scroll;">
          <div class="single-table">
            <div class="table-responsive">
              <table class="table table-hover text-center">
                <thead>
                  <tr class="table-info">
                    <th style="font-size:12px;font-weight: normal;"> ANNOUNCEMENTS </th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="announcement in announcements">
                    <td><span ><a href="{{ announcement.img[0].imageSrc }}">{{ announcement.title }}</a></span></td>
                   
                  </tr>
                
                </tbody>
              </table>
            </div>
          </div>
        </div>
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

