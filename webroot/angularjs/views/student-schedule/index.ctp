<style>
  .codyhouse {
    text-align: center;
    margin: 40px 0;
  }

  html, body, div, span, applet, object, iframe,
  h1, h2, h3, h4, h5, h6, p, blockquote, pre,
  a, abbr, acronym, address, big, cite, code,
  del, dfn, em, img, ins, kbd, q, s, samp,
  small, strike, strong, sub, sup, tt, var,
  b, u, i, center,
  dl, dt, dd, ol, ul, li,
  fieldset, form, label, legend,
  table, caption, tbody, tfoot, thead, tr, th, td,
  article, aside, canvas, details, embed, 
  figure, figcaption, , hgroup, 
   output, ruby, section, summary,
  time, mark, audio, video {
    margin: 0;
    padding: 0;
    border: 0;
    vertical-align: baseline;
  }
  /* HTML5 display-role reset for older browsers */
  article, aside, details, figcaption, figure, 
   hgroup, section, main {
    display: block;
  }
  body {
    line-height: 1;
  }
  ol, ul {
    list-style: none;
  }
  blockquote, q {
    quotes: none;
  }
  blockquote:before, blockquote:after,
  q:before, q:after {
    content: '';
    content: none;
  }
  table {
    border-collapse: collapse;
    border-spacing: 0;
  }

  /* style css */
  /* -------------------------------- 

  Primary style

  -------------------------------- */
  *, *::after, *::before {
    box-sizing: border-box;
  }

  body {
  /*    font-size: 1.6rem;*/
  /*    font-family: "Source Sans Pro", sans-serif;*/
    color: #222222;
    background-color: white;
  }

  a {
    color: #A2B9B2;
    text-decoration: none;
  }

  /* -------------------------------- 

  Main Components 

  -------------------------------- */
  .cd-schedule {
    position: relative;
  }

  .cd-schedule::before {
    /* never visible - this is used in js to check the current MQ */
    content: 'mobile';
    display: none;
  }

  @media only screen and (min-width: 800px) {
    .cd-schedule {
      width: 90%;
      max-width: 1400px;
      margin: 2em auto;
    }
    .cd-schedule::after {
      clear: both;
      content: "";
      display: block;
    }
    .cd-schedule::before {
      content: 'desktop';
    }
  }

  .cd-schedule .timeline {
    display: none;
  }

  @media only screen and (min-width: 800px) {
    .cd-schedule .timeline {
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      padding-top: 50px;
    }
    .cd-schedule .timeline li {
      position: relative;
      height: 50px;
    }
    .cd-schedule .timeline li::after {
      /* this is used to create the table horizontal lines */
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 1px;
      background: #EAEAEA;
    }
    .cd-schedule .timeline li:last-of-type::after {
      display: none;
    }
    .cd-schedule .timeline li span {
      display: none;
    }
  }

  @media only screen and (min-width: 1000px) {
    .cd-schedule .timeline li::after {
      width: calc(100% - 60px);
      left: 60px;
    }
    .cd-schedule .timeline li span {
      display: inline-block;
      -webkit-transform: translateY(-50%);
          -ms-transform: translateY(-50%);
              transform: translateY(-50%);
    }
    .cd-schedule .timeline li:nth-of-type(2n) span {
      display: none;
    }
  }

  .cd-schedule .events {
    position: relative;
    z-index: 1;
  }

  .cd-schedule .events .events-group {
    margin-bottom: 30px;
  }

  .cd-schedule .events .top-info {
    width: 100%;
    padding: 0 5%;
    background-color: #BDC4CB;
    color: #2A3F54;
  }

  .cd-schedule .events .top-info > span {
    display: inline-block;
    line-height: 1.2;
    margin-bottom: 10px;
    font-weight: bold;
  }

  .cd-schedule .events .events-group > ul {
    position: relative;
    padding: 0 5%;
    /* force its children to stay on one line */
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    overflow-x: scroll;
    -webkit-overflow-scrolling: touch;
  }

  .cd-schedule .events .events-group > ul::after {
    /* never visible - used to add a right padding to .events-group > ul */
    display: inline-block;
    content: '-';
    width: 1px;
    height: 100%;
    opacity: 0;
    color: transparent;
  }

  .cd-schedule .events .single-event {
    -ms-flex-negative: 0;
        flex-shrink: 0;
    float: left;
    width: 70%;
    max-width: 300px;
    box-shadow: inset 0 -3px 0 rgba(0, 0, 0, 0.2);
    margin-right: 20px;
    -webkit-transition: opacity .2s, background .2s;
    transition: opacity .2s, background .2s;
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;

  }

  .cd-schedule .events .single-event:last-of-type {
    margin-right: 5%;
  }

  .cd-schedule .events .single-event a {

    height: 100%;
    padding: .8em;
    text-align: center; /* Center the content horizontally */
    height: 100%; /* Ensure the anchor takes the full height */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  @media only screen and (min-width: 550px) {
    .cd-schedule .events .single-event {
      width: 40%;
    }
  }

  @media only screen and (min-width: 800px) {
    .cd-schedule .events {
      float: left;
      width: 100%;
    }
    .cd-schedule .events .events-group {
      width: 20%;
      float: left;
      border: 1px solid #EAEAEA;
      /* reset style */
      margin-bottom: 0;
    }
    .cd-schedule .events .events-group:not(:first-of-type) {
      border-left-width: 0;
    }
    .cd-schedule .events .top-info {
      /* vertically center its content */
      display: table;
      height: 50px;
      border-bottom: 1px solid #EAEAEA;
      /* reset style */
      padding: 0;
    }
    .cd-schedule .events .top-info > span {
      /* vertically center inside its parent */
      display: table-cell;
      vertical-align: middle;
      padding: 0 .5em;
      text-align: center;
      /* reset style */
      font-weight: normal;
      margin-bottom: 0;
    }
    .cd-schedule .events .events-group > ul {
      height: 1100px;
      /* reset style */
      display: block;
      overflow: visible;
      padding: 0;
    }
    .cd-schedule .events .events-group > ul::after {
      clear: both;
      content: "";
      display: block;
    }
    .cd-schedule .events .events-group > ul::after {
      /* reset style */
      display: none;
    }
    .cd-schedule .events .single-event {
      position: absolute;
      z-index: 3;
      /* top position and height will be set using js */
      width: calc(100% + 2px);
      left: -1px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1), inset 0 -3px 0 rgba(0, 0, 0, 0.2);
      /* reset style */
      -ms-flex-negative: 1;
          flex-shrink: 1;
      height: auto;
      max-width: none;
      margin-right: 0;
    }
    .cd-schedule .events .single-event a {
      padding: 2em;
    }
    .cd-schedule .events .single-event:last-of-type {
      /* reset style */
      margin-right: 0;
    }
    .cd-schedule .events .single-event.selected-event {
      /* the .selected-event class is added when an user select the event */
      visibility: hidden;
    }
  }

  @media only screen and (min-width: 1000px) {
    .cd-schedule .events {
      /* 60px is the .timeline element width */
      width: calc(100% - 60px);
      margin-left: 60px;
    }
  }

  .cd-schedule.loading .events .single-event {
    /* the class .loading is added by default to the .cd-schedule element
       it is removed as soon as the single events are placed in the schedule plan (using javascript) */
    opacity: 0;
  }

  .cd-schedule .event-name,
  .cd-schedule .event-date {
    display: block;
    color: white;
    font-weight: bold;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
        color: #2A3F54 !important;
  }

  .cd-schedule .event-name {
    opacity: .9;
    margin-bottom: 1em;
    font-size: 13px;
    font-style: normal;
  }

  @media only screen and (min-width: 800px) {
    .cd-schedule .event-name {
  /*      font-size: 2rem;*/
    }
  }

  .cd-schedule .event-date {
    /* they are not included in the the HTML but added using JavScript */
  /*    font-size: 1.4rem;*/
    opacity: .7;
    font-size: 11px;
    font-weight: normal;
    margin-bottom: .2em;
    font-style: italic;
  }

</style>

<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">

        <div style="overflow-y:scroll;">
          <div class="cd-schedule loading">
            <div class="timeline">
              <ul>
                <li><span>07:00</span></li>
                <li><span>07:30</span></li>
                <li><span>8:00</span></li>
                <li><span>8:30</span></li>
                <li><span>09:00</span></li>
                <li><span>09:30</span></li>
                <li><span>10:00</span></li>
                <li><span>10:30</span></li>
                <li><span>11:00</span></li>
                <li><span>11:30</span></li>
                <li><span>12:00</span></li>
                <li><span>12:30</span></li>
                <li><span>1:00</span></li>
                <li><span>1:30</span></li>
                <li><span>2:00</span></li>
                <li><span>2:30</span></li>
                <li><span>3:00</span></li>
                <li><span>3:30</span></li>
                <li><span>4:00</span></li>
                <li><span>4:30</span></li>
                <li><span>5:00</span></li>
                <li><span>5:30</span></li>
                <li><span>6:00</span></li>
              </ul>
            </div> <!-- .timeline -->

            <div class="events">
              <ul class="wrap">
                <li class="events-group" ng-repeat="data in datas">
                  <div class="top-info"><span>{{days[$index]}}</span></div>
                  <ul>
                    <div ng-repeat="sched in data">
                      <li class="single-event" data-start="{{sched.time_start}}" data-end="{{sched.time_end}}" style="background-color: {{sched.color}};">
                        <a href="#" style="pointer-events: none;">
                          <em class="event-name">{{sched.course}}</em>
                          <span class="event-date">{{sched.faculty_name}}</span>
                          <span class="event-date">{{sched.room}}</span>
                        </a>
                      </li>
                    </div>
                    
                  </ul>
                </li>

              </ul>
            </div>

          </div> <!-- .cd-schedule -->
        </div>

        
      </div>
    </div>
  </div>
</div>