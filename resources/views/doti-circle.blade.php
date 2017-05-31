<div class="doti-main-circle">
    <canvas id="fieldCircle" width="400" height="400" ></canvas>
</div>
<script>
    console.log( "jQ!" );
    $( document ).ready(function() {
    console.log( "ready!" );
    function hexToRgb(hex) {
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        var r = parseInt(result[1], 16);
        var g = parseInt(result[2], 16);
        var b = parseInt(result[3], 16);
        var a = 128;
        var str = "rgba("+r+","+g+","+b+","+a+")";
        return result ? str : null;
    }
    function makeTransparent(str){
        return str.replace(/[^,]+(?=\))/, '0.7');
    }
    var ctx = document.getElementById("fieldCircle");
    //var atv = var c1 = hexToRgb("#FF6384");
    //console.log(atv);
    
    //var idForField = [1, 2, 3, 4, 5, 6, 7, 8];
    //var nameForField = ["Sotsialiseeriumine", "Finants", "Muusika", "Programmeerimine", "Tervis", "Töö", "Vaimsus", "Tühjus"];
    //var dataForField = [100,26,100,30,100,49,100,50];
    //var colorArray = ["#FF6384","#4BC0C0","#9476AB","#E7E9ED","#36A2EB","#D4BA6A","#420029","#E7E9ED"];
    
    var idForField = [
        @foreach ($userFields as $kei => $userField)
            {{ $userField->id }} {{ (($kei+1) == count($userFields) ) ? "" : "," }}
        @endforeach
    ];
    var nameForField = [
        @foreach ($userFields as $kei => $userField)
            {!! '"'.$userField->getField->name.'"' !!} {{ (($kei+1) == count($userFields) ) ? "" : "," }}
        @endforeach
    ];
    var dataForField = [
        @foreach ($userFields as $kei => $userField)
            {{ mt_rand(20,80) }} {{ (($kei+1) == count($userFields) ) ? "" : "," }}
        @endforeach
    ];
    var colorArray = [
        @foreach ($userFields as $kei => $userField)
            {!! '"'.$userField->getField->color.'"' !!} {{ (($kei+1) == count($userFields) ) ? "" : "," }}
        @endforeach
    ];
    
    var highLightColorArray = [];   //Transplate
    for (i = 0; i < colorArray.length; i++) {
        highLightColorArray.push(makeTransparent(hexToRgb(colorArray[i])));
    }
    
    myChart = new Chart(ctx, {
        type: "polarArea",
        data: {
            labels: nameForField,
            ids: idForField,
            datasets: [{
                label: "S", // for legend
                data: dataForField,
                backgroundColor: colorArray,
                hoverBackgroundColor: highLightColorArray,
                borderWidth: 0
            }]
            },
        options: {
            hover: {
                mode: 'single',
                animationDuration: 400                
            },
            animation: {
                duration: 400,
                easing: 'linear'
            },
            tooltips: {
                bodyFontFamily: "Lato",//Lucida Sans Unicode, Lucida Grande, sans-serif",
                bodyFontSize: 14,
                yPadding: 10
            },
            title: {
                text: "Tere"
            },
            legend: {
                display: false,
                fullWidth: false,
                labels: {
                    boxWidth: 12
                }
            },
            elements: {
                arc: {
                    borderColor: "#000000"
                }
            },
            scale: {
                display: true,
                lineArc: true,   //Default is True!
                drawBorder: true,
                drawOnChartArea: true,
                ticks: {
                    display: false,
                    min: 0,
                    stepSize: 25,
                    max: 100
                }
            }
        }
    });
        
    
        /*
        console.log(hexToRgb("#FF6384").replace(/[^,]+(?=\))/, '64'));
        console.log(hexToRgb("#4BC0C0"));
        console.log(makeTransparent(hexToRgb("#9576AB")));
        console.log(hexToRgb("#E7E9ED"));
        console.log(hexToRgb("#36A2EB"));
        console.log(hexToRgb("#D4BA6A"));
        console.log(hexToRgb("#420029"));
        console.log(hexToRgb("#E7E9ED"));
        
        console.log(colorArray.toString());
        console.log(newHigh.toString());
        */
    });
</script>