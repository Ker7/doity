

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
            
            //$.each(json, function(adata,group) {
            //            console.log('<a href="'+group.GROUP_ID+'">');
            //    $.each(group.EVENTS, function(eventID,eventData) {
            //            console.log('<p>'+eventData.SHORT_DESC+'</p>');
            //     });
            //});
                $('#habits-block').empty();
                
            $.each(obj, function(index,habitObject){
                //$.each(habitObject, function(key,val){
                    //console.log("key : "+key+" ; value : "+val);
                    
                //});
                
                h_habit_id = habitObject.habit_id;
                h_internal = habitObject.internal;
                h_unit_name = habitObject.unit_name;
                h_active = habitObject.active;
                h_public = habitObject.public;
                h_comment = habitObject.comment;
                h_created_at = habitObject.created_at;
                h_updated_at = habitObject.updated_at;
                h_name = habitObject.get_habit.name;    //Habits table, which have names, not ID's
                
                console.log(h_unit_name+' name: '+h_name+', pub: '+h_public)
                
                
                //$('#habits-block').append(
                //    $(document.createElement('p')).text(
                //        ' Habit Name: '+h_name+
                //        ' Unit of Measure: '+h_unit_name+
                //        ' IsPublic: '+h_public ).after('<a href="#">Open</a>')
                //);
                $('#habits-block').html(
                    '<h3>Habit Name: '+h_name+
                    '</h3></ br><p>Unit of Measure: '+h_unit_name+
                    ' Is Public: '+h_public +'</p>'+
                    '<a style="display: inline-block" href="#">Open</a>'
                );
            
            });
            
            //console.log( obj.length );
            //console.log( 'id:' + obj[0].id + ', comment' + obj[0].comment + ' getHabit?:' + obj[0].get_habit.name);
            $('#ajax-box').html(adata);
        },
        error: function() {
            console.log('ajax-userfield-errora');
            //alert("No habits found! :(");
        }
    });
    return false;  // miks seda?
    
    
    //console.log(myChart.data.datasets[firstPoint._datasetIndex].data['labels'].toSource());
    //alert(firstPoint._datasetIndex + "/" + firstPoint._index);
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
