<!-- Lastmonth display! -->
@foreach ($userField->getInternalHabits as $hab)
    
    {{-- Habit ID: {{ $hab->id }}        Habit internal: {{ $hab->internal }} --}}
    Habit name: "{{ $hab->getHabit->name }}"
    Logisid: {{ count($hab->getLogs) }}<br/>
    
    <div class="doti-field-month">
        <canvas id="fieldCircle{{ $hab->id }}" width="400" height="400" ></canvas>
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
    
    var data = {
        labels: labelsForGraph,
        datasets: [
            {
                label: "{{ $userField->getField->name }}",
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
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                spanGaps: false,
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
        }
    }]
    
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
    </script>
        
    <br />
@endforeach

    