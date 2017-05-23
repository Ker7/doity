<!-- Lastmonth display! -->

{{-- Habit ID: {{ $hab->id }}        Habit internal: {{ $hab->internal }} 
Habit name: "{{ $hab->getHabit->name }}"
Logisid: {{ count($hab->getLogs) }}<br/>--}}

<div class="doti-field-month" style="width:400px; margin-left: 20px;">
    <canvas id="fieldCircle{{ $hab->id }}" ></canvas>
</div>
    
<script>
    
var ctx = document.getElementById("fieldCircle{{ $hab->id }}");

var labelsForGraph = [
    @foreach($hab->getLogs as $kei => $log)
        "{{ $log->date_log }}" {{ (($kei+1) == count($hab->getLogs) ) ? "" : "," }}
    @endforeach
];
var valuesForGraph = [
    @foreach($hab->getLogs as $kei => $log)
        "{{ (int)$log->value_decimal }}" {{ (($kei+1) == count($hab->getLogs) ) ? "" : "," }}
    @endforeach
];

// TEST Hover asjade stiilimiseks
var valueHover = [
    @foreach($hab->getLogs as $kei => $log)
        "red" {{ (($kei+1) == count($hab->getLogs) ) ? "" : "," }}
    @endforeach
];

var data = {
    labels: labelsForGraph,
    datasets: [
        {
            label: "{{ $userField->getField->name }} :: {{ $userField->id }}",
            data: valuesForGraph,
            fill: false,
            lineTension: 0.1,
            backgroundColor: "{{ $userField->getField->color }}",//"rgba(75,192,192,0.4)",
            borderColor: "{{ $userField->getField->color }}",//"rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "{{ $userField->getField->color }}",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#7a418a",//"rgba(75,192,192,1)",
            pointHoverBorderColor: "#c6b2cc",//"rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            spanGaps: false,
            
            borderWidth: 3, //Graafiku joone paksus
            hoverRadius: 10,
            hoverBackgroundColor: "red",
        }
    ]
};

var options = [
{
    scales: {
        xAxes: [{
            type: 'linear',
            position: 'bottom'
        }]
    },
    legend: {
        display: true,
        labels: {
            fontColor: 'rgb(255, 99, 132)'
        }
    }
}]

var myLineChart = new Chart(ctx, {
    type: 'line',
    data: data,
    options: options
});
</script>
    
<br />

