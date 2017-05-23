

var myChart;

$('#modal-save').on('click', function() {
   console.log('hit!');
});

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}



$( "#fieldCircle" ).click(function(evt){
    var activePoints = myChart.getElementAtEvent(evt);
    
    var firstPoint = activePoints[0];
    if (firstPoint !== undefined)
    
        t1 = myChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];   // Field väärtus
        t2 = myChart.data.labels[firstPoint._index];                                    // Fieldi nimi
        t3 = myChart.data.ids[firstPoint._index];                                       // Fieldi ID

    /* Leia Fieldi rida, mis on peidetult html'is.
     *
     * Kui sama field on  juba nähtaval, siis ei tee midagi...
     */
    if ($("div").find("[data-row-fieldid='" + t3 + "']").css('display') == "none") {
        $(".home-field-row:visible").each(function(){
            $(this).slideToggle();
        });
        $("div").find("[data-row-fieldid='" + t3 + "']").slideToggle(200);
    }

    // Teeme veidi AJAX'it kah
    // Ajax tooken! Seda mingi hetk polnud vaja..? Error 500 korral pidi aitama.
    //$.ajaxSetup({
    //    headers: {
    //        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //    }
    //});
    $.ajax({
        type: "GET",
        url: "userfield",    //"./home", sama asi, ei muutnud midagi
        //data: {selectedPhoneNumber:$('input#phoneNumber').val()},
        //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {userfield_id:    t3},
        success: function(adata) {
            //alert("Ajax SUCCESS?"+adata);
            //console.log(adata.toString());
            console.log('ajax-userfield-success');
            $('#ajax-box').html(adata);
        },
        error: function() {
            console.log('ajax-userfield-error');
            //alert("No habits found! :(");
        }
    });
    return false;  // miks seda?
    
    
    //console.log(myChart.data.datasets[firstPoint._datasetIndex].data['labels'].toSource());
    //alert(firstPoint._datasetIndex + "/" + firstPoint._index);
});

$(document).ready(function() {
    var borderColor;

    $('#colorForField').ColorPicker({
        onSubmit : function(hsb, hex, rgb, el) {
            $(el).val('#' + hex);
            $(el).ColorPickerHide();
            borderColor = $('#colorForField').val();
            $('#news').css('border-color', borderColor);
        },
        onBeforeShow : function() {
            $(this).ColorPickerSetColor(this.value);
        }
    }).bind('keyup', function() {

        $(this).ColorPickerSetColor(this.value);

    });
});
