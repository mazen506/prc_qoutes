$(document).ready(function(){


    // Delete Image 
    $(document).on('click','.btn-del-image',function(e){
    
        // Set up ajax headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
    
        //Get Image Name and create form data
        let image_name = $(this).children('input[type=hidden]:first').val();
        let form_data = new FormData();
        form_data.append( 'image_name', image_name );

        // Delete Parent element 
        $(this).parent().remove();

        // Reconstruct images
        var element_image_list = $("#image-viewer :input[type='hidden']");
        var image_list = [];
        element_image_list.each(function(){
            image_list.push({
                image_name: $(this).val()
            });
        });
        buildImageViewer(image_list);

        //Delete image from disk
        $.ajax({
            url: '/qoute/delImage',
            method: 'post',
            data: form_data,
            dataType: 'text json',
            processData: false,
            contentType: false,
            success: function (data) {
            },
            error: function (data) {
                console.log(data);
            }
        });

});

    // CREATE
    $("#btn-add-images").on('click', function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        //let file_data = $('#item_image')[0].files[0];
        //let file_data = $('#item_image').prop('files');

        let form_data = new FormData($('#frm_images')[0]);
        $.ajax({
            url: '/qoute/addImage',
            method: 'post',
            data: form_data,
            dataType: 'text json',
            processData: false,
            contentType: false,
            success: function (data) {
                buildImageViewer(data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
});

function buildImageViewer(data){
        // Remove current carousel elements 
        $('#image-viewer').empty();

        // Built the viewer
        var item_images_str = "";
        $.each( data, function( key, val ) {
            // Fill Images String
            item_images_str = item_images_str.concat( key == 0  ? '' : '|', val.image_name);

            if (key%3 === 0)       // Add carousel item
            {   if (key == 0) 
                        $('#image-viewer').append( "<div class='carousel-item active'><div class='row'>");
                else
                        $('#image-viewer').append( "<div class='carousel-item'><div class='row'>");
                }
            
            $('#image-viewer').children(':last-child').children(':first-child').append("<div class='img-wrap col-sm-4'>" + 
            "<span class='btn-del-image'>&times;<input type=hidden value='" + val.image_name + "'></span>" + 
            "<img src='/storage/item_images/" + val.image_name + "'></div>");
            let keyex = key + 1;
            
            if (keyex%3 === 0)  // Close the div                                             
            {   $('#image-viewer').append("</div></div>");
            }
          });
          
          $('#item_images').val(item_images_str);
          //$("input[name='item_images[]']")[$('#curr_item_index').val()].val()
        // Construct current carousel elements 
}