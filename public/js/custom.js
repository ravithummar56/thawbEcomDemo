var baseUrl = $('#baseUrl').val() + '/admin';
$(document).ready(function() {
    setTimeout(function() {
        $('#remove_msg').html("");
        // location.reload();
    }, 3000);
});
$(document).ready(function() {
    $("#m_datetimepicker_5").datetimepicker({
        format: "dd-mm-yyyy HH:ii P",
        showMeridian: !0,
        todayHighlight: !0,
        autoclose: !0,
        pickerPosition: "bottom-right"
    })
});


//selet2 bind
$("#m_select2_1,#m_select2_2,#m_select2_3,#m_select_products,#m_select_catagorys,#m_select_tags,#products").select2({});