

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
        $("div").find("[data-row-fieldid='" + t3 + "']").slideToggle(20);
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
        url: "ajax-get-userfield-habits",
        data: {userfield_id:    t3},
        success: function(adata) {
            console.log('ajax-userfield-successa');
            var obj = jQuery.parseJSON( adata );

                $('#habits-block').empty();
                
            $.each(obj, function(index,habitObject){
                
                h_habit_id = habitObject.habit_id;
                h_internal = habitObject.internal;
                h_unit_name = habitObject.unit_name;
                h_active = habitObject.active;
                h_public = habitObject.public;
                h_comment = habitObject.comment;
                h_created_at = habitObject.created_at;
                h_updated_at = habitObject.updated_at;
                h_name = habitObject.get_habit.name;    //Habits table, which have names, not ID's
                
                h_tags = habitObject.get_tags;
                h_tags_string = h_tags
                
                console.log(h_unit_name+' name: '+h_name+', pub: '+h_public)
                
                $('#habits-block').html(
                    '<div style="background-color: #ddd; overflow: auto;" >'+
                    '<h3> :: '+habitObject.get_habit.name+
                    '</h3></ br> <p style="display: inline-block; float: left;">'+
                    'Unit of Measure: '+habitObject.unit_name+
                    ' Is Public: '+habitObject.public +' </p>'+
                    '<a style="display: inline-block; float: left;" href="#">-open-</a>'+
                    '</div>'
                );
            
            });

            $('#ajax-box').html(adata);
        },
        error: function() {
            console.log('ajax-userfield-errora');
        }
    });
    return false;  // miks seda?

});

$(document).ready(function() {
    
    $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
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
