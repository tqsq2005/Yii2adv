/*
 * Copyright (c) 2016. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

/**
 * Created by Administrator on 16-3-7.
 */
$(function() {
    //get the click of modal button to create / update item
    //we get the button by class not by ID because you can only have one id on a page and you can
    //have multiple classes therefore you can have multiple open modal buttons on a page all with or without
    //the same link.
    //we use on so the dom element can be called again if they are nested(嵌套的), otherwise when we load the content once
    //it kills the dom element and wont let you load anther modal on click without a page refresh
    $(document).on('click', '.showModalButton', function(){
        //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content.
        var sModalHeaderCloser = '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times-circle text-primary"></i></span></button>';
        //var sModalFooterCloase = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
                .load($(this).attr('value'));
            //dynamically(动态的) set the header for the modal
            document.getElementById('modalHeader').innerHTML = sModalHeaderCloser + '<h4 class="text-primary">' + $(this).attr('title') + '</h4>';
        } else {
            //if modal isn't open; open it and load content
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
            //dynamically set the header for the modal
            document.getElementById('modalHeader').innerHTML = sModalHeaderCloser + '<h4 class="text-primary">' + $(this).attr('title') + '</h4>';
        }
    });
});
