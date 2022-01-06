<div class="modal fade" id="itemDtlsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ __('global.item_details') }}</h4>
            </div>
            <div class="modal-body">
                   
           
                <div class="alert alert-danger clt-alert">
                        {{__('validation.required_fields')}}
                </div>

                    {{-- Modal Body --}}
    <div class='form-group'>
        <label for='' class='col-sm-2'>{{ trans('cruds.item.fields.name') }}</label>
        <input type="text" id="item_name" name="item_name" value="مساطر" class="form-control col-sm-10"  required>
        <input type="hidden" id="item_images_str" name="item_images_str" value="8lg9RWSkKOHjLQoZK4FQtQo6e3s8fakoCbB9xH6R.png">
    </div>
    
    <div class='form-row'>
        <div class='form-group col-6'>
            <label for=''>{{ trans('cruds.item.fields.package') }}</label>
                        <select id="item_unit" name="item_unit" class="form-control col-sm-10">
                            <option value="0">-- {{ __('global.unit') }} --</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" @php if (($unit->id) == 1) echo 'selected'; @endphp>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>						
        </div>
        
        <div class='form-group col-3'>
            <label for=''>{{ trans('cruds.item.fields.package') }}</label>
            <input type="number" id="item_package_qty" name="item_package_qty" class="form-control"  required>						
        </div>
        <div class='form-group col-3 col-item-package-unit'>
            <select id="item_package_unit" name="item_package_unit" class="form-control col-sm-10">
                <option value="0">{{ __('global.unit') }}</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" @php if (($unit->id) == 2) echo 'selected'; @endphp>
                        {{ $unit->name }} 
                    </option>
                @endforeach
            </select>	
        </div>
    </div>
    
    <div class='form-row'>
        <div class='form-group col-4'>
            <label for=''>{{ trans('cruds.item.fields.price') }}</label>
            <input type="number" id="item_price" name="item_price" class="form-control"   required>						
        </div>
        <div class='form-group col-4'>
            <label for=''>{{ trans('cruds.item.fields.cpm') }}</label>
            <input type="number" id="item_cpm" name="item_cpm" class="form-control"  required>						
        </div>
        <div class='form-group col-4'>
            <label for=''>{{ trans('cruds.item.fields.qty') }}</label>
            <input type="number" id="item_qty" name="item_qty" class="form-control" value=0  required>						
        </div>
    </div>
    <div class='form-group'>
        <label for=''>{{ trans('cruds.item.fields.note') }}</label>
        <input type="text" id="item_note" name="item_note" class="form-control" value="" >						
    </div>
    <div class='form-row cust-total-container '>
        <div class='col-sm-4'>
                <label for='item_total_cpm'> {{ __('global.total_price')}}</label>        
                <input type="text" id="item_total_price" name="item_total_price" class="form-control-plaintext align-center" >						
        </div>
        <div class='col-sm-4'>
                <label for='item_total_cpm'> {{ __('global.total_cpm')}}</label>                    
                <input type="text" id="item_total_cpm" name="item_total_cpm" class="form-control-plaintext align-center" >						
        </div>
    </div>
    
    <div class='dropzone-container'>
            <div id="preview-template" style="display: none;">
                <div class="col h-100 mb-5">
                    <div class="dz-preview dz-file-preview">
                        <div class="d-flex justify-content-end dz-close-icon">
                            <small class="fa fa-times" data-dz-remove></small>
                    </div>
                    <div class="dz-details media">
                        <div class="dz-img">
                            <img class="img-fluid" data-dz-thumbnail>
                        </div>
                        <div class="media-body">
                            <h6 class="dz-filename">
                                <span class="dz-title" data-dz-name></span>
                            </h6>
                            <div class="dz-size" data-dz-size></div>
                        </div>
                    </div>
                    <div class="dz-progress progress" style="height: 4px;">
                        <div class="dz-upload progress-bar bg-success" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dz-success-mark">
                            <span class="fa fa-check-circle"></span>
                        </div>
                        <div class="dz-error-mark">
                            <span class="fa fa-times-circle"></span>
                        </div>
                        <div class="dz-error-message">
                            <small data-dz-errormessage></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="dropzone">
            <form action="{{ route('dropzoneFileUpload') }}" class="dropzone" id="file-upload" enctype="multipart/form-data">
                @csrf
                <div class="dz-message">
                    إسحب الصور هنا للإضافة<br>
                </div>
            </form>
        </div>

    </div>

    
    
    <!-- <div class='form-group'>
                <label>{{ __('global.item_images') }}</label>
                <label class='lbl-img' for="file_item_images">
                    <img src="/storage/images/icon_upload_image.png" width=50 height=50 title="{{ __('global.add_images')}}"/>
                </label>
                <input type="file" id="file_item_images" name="item_images[]" multiple>
                <label id="file_item_images-error" class="error"></label>
    </div>                         -->
                
            

    <!-- Coursel -->
    <!-- <div class="container form-row">
                  <div class="col-md-12">
                    <div class="carousel slide multi-item-carousel" id="theCarousel">
                      <div class="carousel-inner" id="image-viewer">

                      </div>
                      <a class="left carousel-control-prev" href="#theCarousel" data-slide="prev">
                            <span class="carousel-control-prev-icon fas fa-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control-next" href="#theCarousel" data-slide="next">
                            <span class="carousel-control-next-icon  fas fa-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                      </a>
                    </div>
                  </div>
     </div> -->
     <!-- End of Coursel-->
    

    </div>{{-- End of Modal Body --}}
    <div class="modal-footer">
         <input type=button id="btn-item-dtls-save" class="btn btn-primary" value="{{ __('global.save') }}">
         <input type=button  class="btn btn-secondary btn-close" value="{{ __('global.close') }}">
    </div>
    
        </div>
    </div>


</div> <!-- End of Item Details Modal -->



<script>
    Dropzone.autoDiscover = false;


    //     Dropzone.options.myGreatDropzone = { // camelized version of the `id`
    // paramName: "file", // The name that will be used to transfer the file
    // maxFilesize: 2, // MB
    // accept: function(file, done) {
    //     if (file.name == "justinbieber.jpg") {
    //         done("Naha, you don't.");
    //     }
    //     else { done(); }
    // },
    // init: function () { 
    //             this.on("success", function (file) {
    //             var responsetext = JSON.parse(file.xhr.responseText);
    //             console.log(responsetext);});
    // };

        var dropzone = new Dropzone('#file-upload', {
            // previewTemplate: document.querySelector('#preview-template').innerHTML,
            parallelUploads: 3,
            thumbnailHeight: 100,
            thumbnailWidth: 100,
            maxFilesize: 5,
            filesizeBase: 1500,
            addRemoveLinks: true,
            thumbnail: function (file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function () {
                    file.previewElement.classList.add("dz-image-preview");
                    }, 1);
                }
            },
            removedfile: function(file) {
                    data = JSON.parse(file.xhr.response);
                    delImage(data.image_name);
                },

            success: (file) => {
                    data = JSON.parse(file.xhr.responseText);
                    buildImageStr(data);
                }
        });

        // dropzone.on("success", function(file, response) {
        //         console.log(response);
        //         if(response.success == 0){ // Error
        //               alert(response.error);
        //         }
        //     });
        
        // var minSteps = 6,
        //     maxSteps = 60,
        //     timeBetweenSteps = 100,
        //     bytesPerStep = 100000;

        // dropzone.uploadFiles = function (files) {
        //     var self = this;

        //     for (var i = 0; i < files.length; i++) {

        //         var file = files[i];
        //         totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

        //         for (var step = 0; step < totalSteps; step++) {
        //             var duration = timeBetweenSteps * (step + 1);
        //             setTimeout(function (file, totalSteps, step) {
        //                 return function () {
        //                     file.upload = {
        //                         progress: 100 * (step + 1) / totalSteps,
        //                         total: file.size,
        //                         bytesSent: (step + 1) * file.size / totalSteps
        //                     };

        //                     self.emit('uploadprogress', file, file.upload.progress, file.upload
        //                         .bytesSent);
        //                     if (file.upload.progress == 100) {
        //                         file.status = Dropzone.SUCCESS;
        //                         //self.emit("success", file, file, null);
        //                         self.emit("complete", file);
        //                         self.processQueue();
        //                     }
        //                 };
        //             }(file, totalSteps, step), duration);
        //         }
        //     }
        // }

    </script>

    <style>
        .dropzone {
            background: #e3e6ff;
            border-radius: 13px;
            max-width: 550px;
            margin-left: auto;
            margin-right: auto;
            border: 2px dotted #1833FF;
            margin-top: 50px;
        }

    </style>

   