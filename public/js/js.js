

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

function myCallAjax(urlmeth, urlparam, fdata, sfunc, efunc) {
    $.ajax({
        type: urlmeth,
        url: urlparam,
        data: fdata,
        success: sfunc,
        error: efunc
    });
}

//Get units with ajax
function updateHabitUnit(vaal) {
    $('#form-track-unit-name').empty();
    myCallAjax("GET", "ajax-tracker-get-userfield-habit-unit", {fieldhabit_id:    vaal}, function(adata) {
console.log('ajax-tracker-get-userfield-habit-unit-success');
        $('#form-track-unit-name').html( adata );
    }, function() {
console.log('ajax-tracker-get-userfield-habit-unit-error');
    });
}

//Get tags with ajax
function updateHabitTags(vaal) {
    $('#form-track-tags').empty();
    myCallAjax("GET", "ajax-tracker-get-userfield-habit-tags", {fieldhabit_id:    vaal}, function(adata) {
console.log('ajax-tracker-get-userfield-habit-tags-success');
        $('#form-track-tags').html( adata );
    }, function() {
console.log('ajax-tracker-get-userfield-habit-tags-error');
    });
}

// HAbit show more click.
$(document).on("click", ".habit-show-more", function(event){
    event.preventDefault();
    $(this).next('.habit-more').slideToggle();
});

// Tracking habits
//$('#form-track-fields').change(function(){
//    //event.preventDefault();
//    console.log('muutus');
//});

$('#form-track-fields').on('change', function() {
    //alert( 'fieldChange' );
    myCallAjax("GET", "ajax-tracker-get-userfield-habits", {userfield_id:    this.value}, function(adata) {
console.log('ajax-tracker-get-userfield-habits-success');
        $('#form-track-habits').html( adata );
//console.log(adata);
//console.log( $('#form-track-habits').val() );
        updateHabitUnit( $('#form-track-habits').val() );
        updateHabitTags( $('#form-track-habits').val() );
//console.log( '3val::' + $('#form-track-habits').val() );
    }, function() {
console.log('ajax-tracker-get-userfield-habits-error');
    });
});

$('#form-reflect-field').on('change', function() {
    //alert( 'fieldChange' );
    myCallAjax("GET", "ajax-reflector-get-userfield-habits", {userfield_id:    this.value}, function(adata) {
console.log('ajax-reflector-get-userfield-habits-success');
        $('#form-reflect-habits').html( adata );
//console.log(adata);
//console.log( $('#form-track-habits').val() );
        //updateHabitUnit( $('#form_reflect_habits').val() );
        //updateHabitTags( $('#form_reflect_habits').val() );
//console.log( '3val::' + $('#form-track-habits').val() );
    }, function() {
console.log('ajax-reflector-get-userfield-habits-error');
    });
});

$('#form-track-habits').on('change', function() {
console.log( '1val::' + $('#form-track-habits').val() );
console.log( '2val::' + this.value );
    updateHabitUnit(this.value);
    updateHabitTags(this.value);
})

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

    myCallAjax("GET", "ajax-get-userfield-habits", {userfield_id:    t3}, function(adata) {
            console.log('ajax-userfield-success');
            $('#habits-block').empty();
            $('#habits-block').html(adata);
        }, function() {
            console.log('ajax-userfield-error');
        });
    
    //$.ajax({
    //    type: "GET",
    //    url: "ajax-get-userfield-habits",
    //    data: {userfield_id:    t3},
    //    success: function(adata) {
    //        console.log('ajax-userfield-success');
    //        $('#habits-block').empty();
    //        $('#habits-block').html(adata);
    //    },
    //    error: function() {
    //        console.log('ajax-userfield-error');
    //    }
    //});
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

    //$('#colorForField').colorPicker({
    //    onSubmit : function(hsb, hex, rgb, el) {
    //        $(el).val('#' + hex);
    //        $(el).ColorPickerHide();
    //        borderColor = $('#colorForField').val();
    //        $('#news').css('border-color', borderColor);
    //    },
    //    onBeforeShow : function() {
    //        $(this).ColorPickerSetColor(this.value);
    //    }
    //}).bind('keyup', function() {
    //
    //    $(this).ColorPickerSetColor(this.value);
    //
    //});
    
    //$.fn.extend({
    //    ColorPicker: ColorPicker.init,
    //    ColorPickerHide: ColorPicker.hidePicker,
    //    ColorPickerShow: ColorPicker.showPicker,
    //    ColorPickerSetColor: ColorPicker.setColor
    //});
    //$('#colorForField').colorPicker({
    //    color: '#000',
    //    onShow: function (colpkr) {
    //        $(colpkr).fadeIn(500);
    //        return false;
    //    },
    //    onHide: function (colpkr) {
    //        $(colpkr).fadeOut(500);
    //        return false;
    //    },
    //    onChange: function (hsb, hex, rgb) {
    //        $('#colorSelector').css('backgroundColor', '#' + hex);
    //    }
    //});
    //            $('#<%=txtReserveType.ClientID %>')
    
    //if hours sum element exist, calculate the sum!
    //console.log($( ".decimal-sum" ).length)
        //console.log('123');
    if ( $( ".decimal-sum" ).length ) {
        var sum = 0;
    
        //$(".decimal-sum").value(sum);
        //console.log("123"+$('.decimal-fields').count());
        $('.decimal-fields').each(function() {
            //console.log($(this).text());
            
            //sum += $(this).text();
            sum += parseFloat($(this).text().replace(/([^0-9\.])/g, ''));
            
            //sum += Number($(this).val());
        });
        $( ".decimal-sum" ).text(sum);
    //console.log(sum)
        
   }
});
