/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    $('#orderButton').click(function(){
        $('#modalOrder').modal('show')
                .find('#orderContent')
                .load($(this).attr('value'));
    });
    
    
});

