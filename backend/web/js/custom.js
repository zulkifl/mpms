/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    $('#modalButton').click(function () {

        $.get(
                $(this).attr('value'),
                null
                ,
                function (data) {
                    $('#modal').find('.modal-body').html(data);
                    $('#modal').modal();
                }
        );

    });
});