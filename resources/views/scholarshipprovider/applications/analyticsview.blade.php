@extends('layouts.scholarshipprovider')
@section('content')

<ul class="nav nav-pills mb-3 bg-dark" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-banner-tab" data-toggle="pill" href="#pills-banner" role="tab" aria-controls="pills-banner" aria-selected="true">Gender</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-email-tab" data-toggle="pill" href="#pills-email" role="tab" aria-controls="pills-email" aria-selected="false">Crisis Wise</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-article-tab" data-toggle="pill" href="#pills-article" role="tab" aria-controls="pills-article" aria-selected="false">State Wise</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-social-tab" data-toggle="pill" href="#pills-social" role="tab" aria-controls="pills-social" aria-selected="false">Annual Income Wise</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-offline-tab" data-toggle="pill" href="#pills-offline" role="tab" aria-controls="pills-offline" aria-selected="false">Percentage Wise</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" id="pills-online-tab" data-toggle="pill" href="#pills-online" role="tab" aria-controls="pills-online" aria-selected="false">Course Level Wise</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-onground-tab" data-toggle="pill" href="#pills-onground" role="tab" aria-controls="pills-contact" aria-selected="false">Family Occupation Wise</a>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-banner" role="tabpanel" aria-labelledby="pills-banner-tab">
  
  <div class="photo-gallery">
    <div class="container">
      <div class="row photos">
        <div class="col-md-12">
           <div id="chart_div" style="width:800px; height:500px"></div>

        </div>
        
        
      </div>
    </div>
    
  </div>


  </div>
  <div class="tab-pane fade" id="pills-email" role="tabpanel" aria-labelledby="pills-email-tab">
    
   <div id="donuchart" style="width: 900px; height: 500px;"></div>
    
  </div>
  <div class="tab-pane fade" id="pills-article" role="tabpanel" aria-labelledby="pills-article-tab">
    State Wise
    <!-- Add the following HTML code to your Blade file -->

<div id="indianMap" style="width: 100%; height: 500px;"></div>
   
  </div>
  <div class="tab-pane fade" id="pills-social" role="tabpanel" aria-labelledby="pills-social-tab">
    
    <div id="incomechart" style="width: 900px; height: 500px;"></div></div>
  
  <div class="tab-pane fade" id="pills-offline" role="tabpanel" aria-labelledby="pills-offline-tab">
    <div class="row">
      <div class="col-md-6">
        <div id="percentagechart" style="width: 900px; height: 500px;"></div>
      </div>
      <div class="col-md-6">
        <div id="percentage" style="width: 900px; height: 500px;"></div>
      </div>
    </div>
  </div>
   <div class="tab-pane fade" id="pills-online" role="tabpanel" aria-labelledby="pills-online-tab">

     
{{--

     @foreach($course_scholarships as $course_scholarship )
       {{$course_scholarship->course_id}}
       @if(App\StudentCourses::where('id',$course_scholarship->course_id)->exists())

                            <?php
                            $result=App\StudentCourses::where('id',$course_scholarship->course_id)->first();
                            echo $result->course_name;
                           ?>
                        @endif
        
     @endforeach
     --}}
     <div class="col-md-6">
        <div id="coursetypechart" style="width: 900px; height: 500px;"></div>
      </div>
      <div class="col-md-6">
        <div id="coursenamechart" style="width: 900px; height: 500px;"></div>
      </div>
   </div>
    <div class="tab-pane fade" id="pills-onground" role="tabpanel" aria-labelledby="pills-onground-tab">
      <div class="col-md-6">
        <!-- Add the following HTML code to your Blade file -->
<div id="occupationChart" style="width: 500px; height: 300px;"></div>

      </div>
     </div>
</div>

    
   
  
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Crisis', 'Answer'],
          ['Male', {{$mprofiles}}],
          ['Female',{{$fprofiles}}],
          ['Others',{{$other}}],
          
        ]);

        var options = {
          title: 'Application Distribution:Gender Wise ',
          
          width:1000,
          height:500,
        };

        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var crisis = data.getValue(selectedItem.row, 0);
            
            if(crisis=='Male')
            {
              
              
              window.open("{{URL::to('/f1view',$s_id)}}");
            }

            else if(crisis=='Female')
            {
              
              window.open("{{URL::to('/f2view',$s_id)}}");
            }
            else
            {
              window.open("{{URL::to('/f3view',$s_id)}}");
            }
            
            
          }
        }
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);

        google.visualization.events.addListener(chart, 'select', selectHandler);

        
        
      }
     
</script>
<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Crisis', 'Answer'],
          ['Single Parent', {{$sp}}],
          ['Differently Abled',{{$handicapped}}],
          ['Orphan',{{$orphan}}],
          
        ]);

        var options = {
          title: 'Application Distribution: Crisis Wise',
          pieHole: 0.4,
          width:900,
          height:500,
        };

        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var crisis = data.getValue(selectedItem.row, 0);
            
            if(crisis=='Single Parent')
            {
              
              
              window.open("{{URL::to('/f4view',$s_id)}}");
            }
            else if(crisis=='Differently Abled')
            {
              
              window.open("{{URL::to('/f5view',$s_id)}}");
            }
            else
            {
              
              window.open("{{URL::to('/f6view',$s_id)}}");
            }
            
            
          }
        }
        var chart = new google.visualization.PieChart(document.getElementById('donuchart'));
        chart.draw(data, options);

        google.visualization.events.addListener(chart, 'select', selectHandler);

        
        
      }
</script>

<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Crisis', 'Answer'],
          ['Below Rs 50 Thousand', {{$bw50}}],
          ['Between 50 Thousand - Rs 2 Lakh',{{$bw502}}],
          ['Between 2 Lakh- Rs 5 Lakh',{{$bw205}}],
          ['Above Rs 5 Lakh',{{$bw5}}],
          
        ]);

        var options = {
          title: 'Application Distribution:Annual Income Wise Annually',
          
          width:1000,
          height:500,
        };

        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var crisis = data.getValue(selectedItem.row, 0);
            
            if(crisis=='Below Rs 50 Thousand')
            {
              
              
              
              window.open("{{URL::to('/f7view',$s_id)}}");
            }

            else if(crisis=='Between 50 Thousand - Rs 1 Lakh')
            {
              
              window.open("{{URL::to('/f8view',$s_id)}}");
            }
            else if(crisis=='Between 1 Lakh- Rs 3 Lakh')
            {
              
              window.open("{{URL::to('/f9view',$s_id)}}");
            }
            else if(crisis=='Between 3 Lakh- Rs 5 Lakh')
            {
              
              window.open("{{URL::to('/f10view',$s_id)}}");
            }
            else if(crisis=='Above Rs 5 Lakh')
            {
              
              window.open("{{URL::to('/f11view',$s_id)}}");
            }
            
            
            
          }
        }
        var chart = new google.visualization.PieChart(document.getElementById('incomechart'));
        chart.draw(data, options);

        google.visualization.events.addListener(chart, 'select', selectHandler);

        
        
      }
</script>
<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Percentage', 'Answer'],
          
          ['Between 81-100%',{{$ab80}}],
          ['Between 61-80%',{{$ab60}}],
          ['Between 41-60%',{{$ab40}}],
          ['Below 40%',{{$bw40}}],
          
        ]);

        var options = {
          title: 'Application Distribution:Previous Exam Percentage',
          
          width:700,
          height:500,
        };

        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var crisis = data.getValue(selectedItem.row, 0);
            
            if(crisis=='Above 90%')
            {
              
              
              
              window.open("{{URL::to('/f12view',$s_id)}}");
            }

            else if(crisis=='Between 80-90%')
            {
              
              window.open("{{URL::to('/f13view',$s_id)}}");
            }
            else if(crisis=='Between 70-80%')
            {
              
              window.open("{{URL::to('/f14view',$s_id)}}");
            }
            else if(crisis=='Between 60-70%')
            {
              
              window.open("{{URL::to('/f15view',$s_id)}}");
            }
            else if(crisis=='Below 60%')
            {
              
               window.open("{{URL::to('/f16view',$s_id)}}");
            }
            
            
            
          }
        }
        var chart = new google.visualization.PieChart(document.getElementById('percentagechart'));
        chart.draw(data, options);

        google.visualization.events.addListener(chart, 'select', selectHandler);

        
        
      }
</script>

<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Percentage', 'Answer'],
       
          ['Between 81-100%',{{$ssc80}}],
          ['Between 61-80%',{{$ssc60}}],
          ['Between 41-60%',{{$awssc406}}],
          ['Below 40%',{{$bwssc40}}],
          
        ]);

        var options = {
          title: 'Application Distribution:Class 10 Percentage',
          
          width:700,
          height:500,
        };

        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var crisis = data.getValue(selectedItem.row, 0);
           
            if(crisis=='Above 90%')
            {
              
              
             
              window.open("{{URL::to('/f17view',$s_id)}}");
            }

            else if(crisis=='Between 80-90%')
            {
              
              window.open("{{URL::to('/f18view',$s_id)}}");
            }
            else if(crisis=='Between 70-80%')
            {
              
              window.open("{{URL::to('/f19view',$s_id)}}");
            }
            else if(crisis=='Between 60-70%')
            {
              
              window.open("{{URL::to('/f20view',$s_id)}}");
            }
            else if(crisis=='Below 60%')
            {
              
               window.open("{{URL::to('/f21view',$s_id)}}");
            }
            else{
              
            }
            
            
          }
        }
        var chart = new google.visualization.PieChart(document.getElementById('percentage'));
        chart.draw(data, options);

        google.visualization.events.addListener(chart, 'select', selectHandler);

        
        
      }
</script>
<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Course Type', 'Count'],
      @foreach($courseTypeData as $courseTypeName => $count)
        ['{{ $courseTypeName }}', {{ $count }}],
      @endforeach
    ]);

    var options = {
      title: 'Application Distribution: Course Type Wise',
      width: 700,
      height: 500
    };

    function selectHandler() {
      var selectedItem = chart.getSelection()[0];
      if (selectedItem) {
        var courseType = data.getValue(selectedItem.row, 0);
        // Add your logic for handling the selected course type here
      }
    }

    var chart = new google.visualization.PieChart(document.getElementById('coursetypechart'));
    chart.draw(data, options);

    google.visualization.events.addListener(chart, 'select', selectHandler);
  }
</script>

<div id="coursetypechart"></div>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Course Name');
        data.addColumn('number', 'Application Count');

        data.addRows([
            @foreach($courseNameCounts as $courseNameCount)
                ['{{ $courseNameCount->course_name }}', {{ $courseNameCount->count }}],
            @endforeach
        ]);

        var options = {
            title: 'Application Distribution: Course Name Wise',
            width: 700,
            height: 500
        };

        var chart = new google.visualization.PieChart(document.getElementById('coursenamechart'));
        chart.draw(data, options);
    }
</script>

<div id="coursenamechart"></div>
// Add the following JavaScript code to your Blade file
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {packages: ['corechart']});
  google.charts.setOnLoadCallback(drawOccupationChart);

  function drawOccupationChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Occupation');
    data.addColumn('number', 'Count');
    data.addRows([
      @foreach($occupationCounts as $occupationCount)
        ['{{ $occupationCount->father_occupation }}', {{ $occupationCount->count }}],
      @endforeach
    ]);

    var options = {
      title: 'Occupation Distribution',
      width: 500,
      height: 300
    };

    var chart = new google.visualization.PieChart(document.getElementById('occupationChart'));
    chart.draw(data, options);
  }
</script>

<!-- Add the following HTML code to your Blade file -->
<div id="indianMap" style="width: 100%; height: 500px;"></div>

<!-- Add the following JavaScript code to your Blade file -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {
    'packages': ['geochart'],
    'mapsApiKey': 'YOUR_API_KEY'
  });
  google.charts.setOnLoadCallback(drawIndianMap);

  function drawIndianMap() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'State');
    data.addColumn('number', 'Count');
    data.addRows([
      @foreach($stateCounts as $stateCount)
        ['{{ $stateCount->permanent_state }}', {{ $stateCount->count }}],
      @endforeach
    ]);

    var options = {
      region: 'IN',
      displayMode: 'regions',
      resolution: 'provinces',
      width: '100%',
      height: 500,
      colorAxis: { colors: ['#FF0000', '#00FF00'] },
      legend: 'none',
      tooltip: { textStyle: { color: '#FFFFFF' } },
      datalessRegionColor: '#808080',
      defaultColor: '#808080',
      enableRegionInteractivity: true,
      magnifyingGlass: { enable: true, zoomFactor: 7.5 },
    };

    var chart = new google.visualization.GeoChart(document.getElementById('indianMap'));

    google.visualization.events.addListener(chart, 'ready', function() {
      var chartElements = chart.getChartLayoutInterface().getChartElements();
      chartElements.forEach(function(element, index) {
        var stateName = data.getValue(index, 0);
        var count = data.getValue(index, 1);

        var stateLabel = document.createElement('div');
        stateLabel.className = 'state-label';
        stateLabel.textContent = stateName;

        var countLabel = document.createElement('div');
        countLabel.className = 'count-label';
        countLabel.textContent = count;

        var marker = document.createElement('div');
        marker.className = 'marker';
        marker.appendChild(stateLabel);
        marker.appendChild(countLabel);

        document.getElementById('indianMap').appendChild(marker);
      });
    });

    chart.draw(data, options);
  }
</script>

<style>
  .state-label {
    font-weight: bold;
  }

  .count-label {
    margin-top: 5px;
  }

  .marker {
    position: absolute;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    pointer-events: none;
  }
</style>

@parent
@endsection