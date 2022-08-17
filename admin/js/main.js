(function( $ ) {
 
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.ttbn-color-picker').wpColorPicker();
    });
     
})( jQuery );


jQuery(document).ready(function($){
    $('#is-breaking-news').change(function() {
        if(this.checked) {
            $('.breaking_news_data_wrap').show();
        }
        else{
            $('.breaking_news_data_wrap').hide();
        } 
    });


    $('#set-expiration-date').change(function() {
        if(this.checked) {
            $('.expiration-data-wrap').show();
        }
        else{
            $('.expiration-data-wrap').hide();
        } 
    });


    $('#expiration-date').datepicker({
        dateFormat : 'dd-mm-yy'
    });

    $('#expiration-time').timepicker({
       timeFormat: 'HH:mm',
       interval: 1,       
       dynamic: false,
       dropdown: true,
       scrollbar: true
    });
})