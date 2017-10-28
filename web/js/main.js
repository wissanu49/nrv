
$(function(){
    $('#creategarbage').click(function(){
        $('#modal').modal('show')
                .find('#createContent')
                .load($(this).attr('value'))
    });    
});

