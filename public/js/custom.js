//Translation function
function trans(key, replace = {}) {

        let translation = key.split('.').reduce((t, i) => t[i] || null, window.translations);
        
        for (var placeholder in replace) {
                translation = translation.replace(`:${placeholder}`, replace[placeholder]);
            }
        
        return translation;
    }

$('.modal .close, .btn-close').click(function(){
    $(this).closest('.modal').modal('hide');
});

   
//Delete Image
function delImage(file)
{
        // Set up ajax headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
    
        let form_data = new FormData();
        image_name = file.name;
        form_data.append( 'image_name', image_name );

        // Reconstruct images
        var image_list = $('#user_images_str').val().split('|');
        for(var i=0; i<image_list.length; i++) {
            if (image_list[i] === image_name)
                image_list.splice(i,1);
        }

        $('#user_images_str').val('');
        

        //Delete image from disk
        $.ajax({
            url: '/qoutes/delImage',
            method: 'post',
            data: form_data,
            dataType: 'text json',
            processData: false,
            contentType: false,
            beforeSend: function() {
                showSpinner(true);
            },
            success: function (data) {
                showSpinner(false);

                //Reconstruct ImageStr
                user_images_str = image_list.join('|');
                $('#user_images_str').val(user_images_str);

                // var fileRef;
                // return (fileRef = file.previewElement) != null ?
                // fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            error: function (data) {
                showFlashMessage(trans('global.execution_error'));
            }
        });
};


function copyToClipBoard(txt) {
    navigator.clipboard.writeText(txt).then(
        v => alert(trans('global.qoute_link_copied')),
        e => alert("Fail\n" + e));
    //$('.toast').toast('show');
}

/************************ Upload logo image  ***********************/
    $('#frmProfile').submit(function(e) {
        e.preventDefault();
        if (!$('#frmProfile').valid())
            return;
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        let form_data = new FormData($('#frmProfile')[0]);
        $.ajax({
            url: '/profile/update',
            method: 'post',
            data: form_data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function(){
                showSpinner(true);
            },
            success: function (data) {
                showFlashMessage(trans('global.save_success'));
            },
            error: function (data) {
                console.log(data);
                showFlashMessage(trans('global.execution_error'));
            }
        });
    });


    $("#file-profile-logo").on('change', function(e) {

        var file = e.originalEvent.srcElement.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            $('#img-profile-logo').attr('src',reader.result);
        }
        reader.readAsDataURL(file);
    });


    $('#btn-item-dtls-save').click(function(e){
        //Display Errors
        console.log('Saving..');
        if (!$("#frmItemDtls").valid())
        {   $('#itemDtlsModal .modal-body').scrollTop(0); 
            $('#itemDtlsModal .clt-alert').css('display','block');
            return;
        }
        else
            $('#itemDtlsModal .clt-alert').css('display','none');
            
    
        //Save Record
        if (isNew) //New
        {
            if (item_no>=1) {
                $('#item' + (item_no)).html($('#item0').html()).find('td:nth-child(1)').html(item_no+1);
                //Fill Row items from modal
                $('#items_table').append('<tr id="item' + (item_no+1) + '"></tr>');
            } else { //display the first row
                $('#item0').css("display","table-row");
            }   
            currItemIndex = item_no;
            saveRecord(currItemIndex);
            item_no++;
        }
        else //Edited
        {
            //Check if item details form changed
            if ($('#frmItemDtls').serialize() != frmItemDtlsSnap) //Changed
            {   console.log('Yes,, it is changed Man!!');
                var is_edited_flag = document.getElementsByName('is_edited_flags[]')[currItemIndex];
                is_edited_flag.value = 1;
                console.log('Current Index: ' + currItemIndex);
                saveRecord(currItemIndex);
                
            }
            else
            {   $('#itemDtlsModal').modal('hide'); 
                console.log('Unchanged!!');
            }
        }
        
    });
    

    /**************** Upload Item Images ******************/ 
    $("#file_user_images").on('change', function(e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        //let file_data = $('#item_image')[0].files[0];
        //let file_data = $('#item_image').prop('files');

        let form_data = new FormData($('#frmItemDtls')[0]);
        $.ajax({
            url: '/qoutes/addImage',
            method: 'post',
            data: form_data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function(){
                showSpinner(true);
            },
            success: function (data) {
                buildImageStr(data);
                showSpinner(false);
            },
            error: function (data) {
                showFlashMessage(trans('global.execution_error'));
            }
        });
    });


function showFlashMessage(message)
{
    showSpinner(false);
    $('#itemDtlsModalFlash .modal-body').html(message);
    $('#itemDtlsModalFlash').modal('show');
    setTimeout(function () {
       $('#itemDtlsModalFlash').modal('hide');
    }, 1000);
}

function buildImageStr(data){
    let user_images_str = $('#user_images_str').val();
    //$.each( data, function( key, val ) {
        // Fill Images String
        user_images_str = user_images_str.concat( user_images_str == ''  ? '' : '|', data.image_name);
    //});
    $('#user_images_str').val(user_images_str);
    console.log('Image String:' + user_images_str);
    //buildImageViewer(user_images_str);
}


function showSpinner(value){
    if (value) // show
        $('#cust-spinner').show();
    else
        $('#cust-spinner').hide();
}

function buildImageViewer(data){
        // Remove current carousel elements 
        $('#image-viewer').empty();

        data = data.split('|');

        // $.each( data, function( key, val ) {
        //     if (key%3 === 0)       // Add carousel item
        //     {   if (key == 0) 
        //                 $('#image-viewer').append( "<div class='carousel-item active'><div class='row'>");
        //         else
        //                 $('#image-viewer').append( "<div class='carousel-item'><div class='row'>");
        //         }
            
        //     $('#image-viewer').children(':last-child').children(':first-child').append("<div class='img-wrap col-sm-4'>" + 
        //     "<span class='btn-del-image'>&times;<input type=hidden value='" + data[key] + "'></span>" + 
        //     "<img src='/storage/user_images/" + data[key] + "'></div>");
        //     let keyex = key + 1;
            
        //     if (keyex%3 === 0)  // Close the div                                             
        //     {   $('#image-viewer').append("</div></div>");
        //     }
        //   });

        if (data == '') 
        {
            $('.carousel-control-prev, .carousel-control-next').css('display','none');
            return;
        }

        $.each( data, function( key, val ) {
               console.log('Passed Here!! :' + data);
               if (key == 0) 
                        $('#image-viewer').append( "<div class='carousel-item active img-wrap'>");
                else
                        $('#image-viewer').append( "<div class='carousel-item img-wrap'>");
            
            $('#image-viewer').children(':last-child').append("<span class='btn-del-image'><img src='/storage/user_images/delete_icon.png'><input type=hidden value='" + data[key] + "'></span>" + 
            "<img src='" + window.storage_url + "user_images/" + data[key] + "'></div>");
          });

          //Display the last image
          $('.carousel-control-prev, .carousel-control-next').css('display','flex');
          $('#itemDtlsModal').carousel(data.length-1);
}


function clearModal(item){
    $(item + ' input:text').val('');
    $(item + ' :input[type=hidden]').val('');
    $(item + ' :input[type=number]').val('');
    $(item + ' select').val('0');
    $(item + ' #image-viewer').empty();
    $('.carousel-control-prev, .carousel-control-next').css('display','none');
    $('#itemDtlsModal .modal-body').scrollTop(0); 
    $('#item_name').focus();
    $('#file_user_images').val('');
    if (dropzone)
    {   //console.log('passed clearing;');
        dropzone.removeAllFiles();
        $('.dz-preview').remove();

    }
    
}


/***************** Add Item ******************/
$('#btn-add-item').click(function(e){
        e.preventDefault();
        if (!$('#frmQoute').valid())
        {
            $(window).scrollTop(0); 
            $('#frmQoute .clt-alert').css('display','block');
            return;
        }
        else
            $('#frmQoute .clt-alert').css('display','none');

        //Initiate Modal
        isNew = true;
        clearModal('#itemDtlsModal');
        $('#itemDtlsModal').modal('show');
    });


    $( "#itemDtlsModal" ).on('shown', function(){
        $('#itemDtlsModal .clt-error').css('display','none');
    });


    $("#btn-toggle-visibility").click(function(e){
    $display_type = $('#item2').css("display");
    if ($display_type == 'block')
    {    $('#item2').css("display","none");
         console.log('Display:none');
    }
    else
    {
        $('#item2').css("display","block");        
        console.log('Display:block');
    }
    });

   


/********************* Image Viewer ***********************/    

$('.item-image').click(function(){
    $('#item-images-viewer').empty();
    var user_images = $(this).prev().val().split("|");

    if (user_images.length>0)
    {
        $('#itemImagesModal').modal('show');
        for(var key = 0 ; key<user_images.length; key++)
        {   
            if (key == 0) 
                    $('#item-images-viewer').append( "<div class='carousel-item active'>");
            else
                    $('#item-images-viewer').append( "<div class='carousel-item'>");

            $('#item-images-viewer').children(':last-child').append("<img src='" + window.storage_url + "/user_images/" + user_images[key] + "'>"); 
            $('#item-images-viewer').append("</div>");
        }
    }
    }); // End of Item Image function 

//Edit Item
$(document).on('click','.lst-item-name',function(){
    isNew = false;
    currItemIndex = $(this).closest('tr').index();
    fillItemModal(currItemIndex);
    // Get current form stamp
    frmItemDtlsSnap = $('#frmItemDtls').serialize();
    $('#itemDtlsModal').modal('show');
});


/**************** Delete Item ****************/

$(document).on('click','.icon-del-item',function(e){
    if (item_no == 1){ //One record
        alert(trans('global.qoute_must_have_one_item'));
        return;
    }
    console.log('Delete function passed!!');
    
    if (confirm(trans('global.delete_confirmation'), e))
        {
            showSpinner(true);
            let row = $(this).closest('tr');
            //Get Item id
            var item_id = $(row).find('input[name^=item_ids]').val();
            $(row).remove();
       
            $('#items_table tbody tr').each(function(index) {
                $(this).attr('id','item' + index)
                $(this).children('td:nth-child(1)').html(index+1);
            });
            item_no--;
            // Delete from database ajax
            if (item_id)
                saveForm(false);
        }
        
    });

// function delQouteItem(itemId)    {
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     let form_data = new FormData($('#frmQoute')[0]);
    
//     $.ajax({
//         url: "/qoutes/del_item/" + itemId,
//         type: 'post',
//         data: form_data,
//         dataType: 'json',
//         processData: false,
//         contentType: false,
//         beforeSend: function(){
//             showSpinner(true);
//         },
//         success: function (data) {
//             showFlashMessage('itemDeleteSuccess');
//         },
//         error: function (data) {
//             showFlashMessage('itemDeleteError');
//         }
// });
// }


function saveRecord(item){
    console.log('Item: ' + item);
    showSpinner(true);
// Get item fields
    var item_id = document.getElementsByName('item_ids[]')[item];
    var user_images_str = document.getElementsByName('user_images_str[]')[item];
    var item_name = document.getElementsByName('item_names[]')[item];
    var item_unit = document.getElementsByName('item_units[]')[item];
    var item_unit_name = document.getElementsByName('item_units_names[]')[item];
    var item_package_qty = document.getElementsByName('item_package_qtys[]')[item];
    var item_package_unit = document.getElementsByName('item_package_units[]')[item];
    var item_package_unit_name = document.getElementsByName('item_package_units_names[]')[item];
    var item_price = document.getElementsByName('item_prices[]')[item];
    var item_qty = document.getElementsByName('item_qtys[]')[item];
    var item_cpm = document.getElementsByName('item_cpms[]')[item];
    var item_note = document.getElementsByName('item_notes[]')[item];


    // fill item fields
    if (isNew) //New
        item_id.value = 0; // New Record

    user_images_str.value = $("#user_images_str").val();
    item_name.value = $("#item_name").val();
    item_unit.value = $("#item_unit").val();
    item_unit_name.innerHTML = $("#item_unit :selected").text().trim();
    item_package_qty.value = $("#item_package_qty").val();
    item_package_unit.value = $("#item_package_unit").val();
    item_package_unit_name.innerHTML = $("#item_package_qty").val() + ' ' + $("#item_package_unit :selected").text().trim();
    item_price.value = $("#item_price").val();
    item_qty.value = $("#item_qty").val();
    item_cpm.value = $("#item_cpm").val();
    item_note.value = $("#item_note").val();

    //set item image
    var item_image = user_images_str.value.split('|')[0];
    
    $('#item' + item).find('td:nth-child(3)').find('img:first').attr('src', window.storage_url  + '/user_images/' + item_image);

    
    if (!units) //New
        $('#frmQoute').submit();
    else
        saveForm(isNew);
}



function fillItemModal(item){



var item_id = document.getElementsByName('item_ids[]')[item];
var user_images_str = document.getElementsByName('user_images_str[]')[item];
var item_name = document.getElementsByName('item_names[]')[item];
var item_unit = document.getElementsByName('item_units[]')[item];
var item_package_qty = document.getElementsByName('item_package_qtys[]')[item];
var item_package_unit = document.getElementsByName('item_package_units[]')[item];
var item_price = document.getElementsByName('item_prices[]')[item];
var item_cpm = document.getElementsByName('item_cpms[]')[item];
var item_qty = document.getElementsByName('item_qtys[]')[item];
var item_note = document.getElementsByName('item_notes[]')[item];


//alert(item_names.length)
$("#item_name").val(item_name.value);
$('#item_unit').val(item_unit.value);
$('#item_package_qty').val(item_package_qty.value);
$('#item_package_unit').val(item_package_unit.value);
$('#item_price').val(item_price.value);
$('#item_cpm').val(item_cpm.value);
$('#item_qty').val(item_qty.value);
$('#item_note').val(item_note.value);
$('#user_images_str').val(user_images_str.value);

console.log('Filling Images..');
fillDropZoneImages();
calItemModalTotals();
//fill Images
//buildImageViewer(user_images_str.value);


}


function previewImages(user_images){
    $('#item-images-viewer').empty();
    var user_images = user_images.split("|");

    for(var key = 0; key<user_images.length; key++)
    {   if (key == 0) 
                $('#items-image-viewer').append( "<div class='carousel-item active'>");
        else
                $('#items-image-viewer').append( "<div class='carousel-item'>");

        $('#items-image-viewer').append("<img src='" + window.storage_url + "/user_images/" + val.image_name + "'>"); 
        $('#items-image-viewer').append("<div>");
    };
}

function delQoute(){
    if (confirm(trans('global.delete_confirmation'),delQoute))
    {
            $('#del-qoute-form').submit();
    }
}

/* ---- End of item form functions -------- */

/*------ List Delete ------*/
$('.lst-del-btn').click(function(e){
    e.preventDefault();
    if (confirm(trans('global.delete_confirmation'),e))
    {
        $(this).closest('form').submit();
    }
});


// Calculate pricing
        $('#item_qty, #item_price, #item_cpm').change(function(){
            calItemModalTotals()
        });

        function calItemModalTotals() {
            $price= $('#item_price').val();
            $package = $('#item_package_qty').val();
            $cpm = $('#item_cpm').val();
            $qty = $('#item_qty').val();

            $total_price= round($price * $qty * $package,2);
            $total_cpm = round($cpm * $qty,3);
            $('#item_total_price').val($total_price.toLocaleString());
            $('#item_total_cpm').val($total_cpm);
        }

        function round(number, decimals) {
                decimals = Math.pow(10,decimals);
                number = Math.round(number*decimals)/decimals;
                //console.log('Number Decimals' + number + ' ' + decimals);
                return number;
        }



/* ---- Confirmation Dialog --------*/

var confirm_result = false;
var confirm_ready = false;
var confirm_init = true;
function confirm(message, e){
    if (!confirm_init) {
        confirm_init = true;
        confirm_ready=true;
        return confirm_result;
    }
    confirm_ready = false;
    $('#dialog').text(message);
    $("#dialog").dialog({
            title: trans('global.confirmation_box'),
            modal:true,
            buttons: [
                    {
                        text:trans('global.yes'),
                        icon: 'ui-icon-check',
                        class: 'btn btn-primary',
                        click: function(){
                            $(this).dialog('close');
                            confirm_result = true;
                            confirm_init= false;
                            if (e instanceof $.Event)
                                $(e.target).trigger(e);
                            else
                                e(); //Call function
                            
                        }
                    },
                    {
                        text: trans('global.no'),
                        icon: 'ui-icon-close',
                        class: 'btn btn-secondary',
                        click: function(){
                            $(this).dialog('close');
                            confirm_result= false;
                            confirm_init= false;
                            if (e instanceof $.Event)
                                $(e.target).trigger(e);
                            else
                                e();
                        }
                    }
            ],
            classes:{
              
                }

            });
        $("#dialog").dialog('moveToTop');

            return confirm_result;
}
   
/*----------------------------------*/

