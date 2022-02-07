<div class="modal fade" id="itemDtlsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ __('global.item_details') }}</h4>
            </div>
            <div class="modal-body">
                   
                <form  id="frmItemDtls">
                @csrf
                    <div class="alert alert-danger clt-alert">
                        {{__('validation.required_fields')}}
                    </div>

                    {{-- Modal Body --}}
                    <div class='form-group'>
                        <label for=''>{{ trans('cruds.item.fields.name') }}</label>
                        <input type="text" id="item_name" name="item_name" value="مساطر" class="form-control col-sm-10"  required>
                        <input type="hidden" id="item_images_str" name="item_images_str" value="164146902656.jpg|1641450814.jpg">
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
                </form>

                <div class='form-row'>
                       <label class='cust-title'> {{ __('cruds.item.fields.images') }} </label>
                </div>
                <form action="{{ route('addImage') }}" class="dropzone" id="image-upload" enctype="multipart/form-data">
                @csrf
                        <div id="dropzone">
                                <div class="dz-message">
                                    إسحب الصور هنا للإضافة<br>
                                </div>
                       </div>  
                </form>                       

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
    //Dropzone.options.fileDropzone = {   
        var dropzone = new Dropzone('#image-upload', {
        url: "{{ route('addImage') }}",
        //previewTemplate: document.querySelector('#preview-template').innerHTML,
        addRemoveLinks: true,
        autoProcessQueue:false,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        maxFilesize: 4,
        // headers: {
        //     'X-CSRF-TOKEN': "{{ csrf_token() }}"
        // },
        parallelUploads: 1,
        maxFiles: 1,
        thumbnailHeight: 75,
        thumbnailWidth: 75,
       
        init: function() {
                _this = this;
                
                this.on("complete", function(file) {
                    $(".dz-remove").html("<div><span class='fa fa-trash text-danger' style='font-size: 1.5em; cursor:hand'></span></div>");
                   // _this.removeFile(file);
                });

                this.on('success',  function(file) {
                    data = JSON.parse(file.xhr.responseText);
                    buildImageStr(data);
                });

                this.on('removedfile', function(file){
                    console.log(file);
                    delImage(file);
                });

                this.on("addedfile", function(file) {
                      var reader = new FileReader();
                      if (file){
                            reader.readAsDataURL(file);
                      }
                      reader.addEventListener("load", function(event) {
                                console.log('Finished reading..');
                                var origImg = new Image();
                                origImg.src = event.target.result;
                                origImg.addEventListener("load", function(event) {
                                    comp = jic.compress(origImg, 30, "jpg"); 
                                    console.log('compressed!');
                                    var resizedFile = base64ToFile(comp.src, file);
                                    var origFileIndex = _this.files.indexOf(file);
                                    _this.files[origFileIndex] = resizedFile;
                                    _this.processQueue();
                            });
                      });
                 });  
            }
        });

        function fillDropZoneImages(){
                dropzone.removeAllFiles();
                $('.dz-preview').remove();
                if ($('#item_images_str').val())
                {
                    images = $('#item_images_str').val().split('|');
                    //console.log('Images: ' + images.length);
                    for (var i=0; i<images.length; i++) {
                                console.log('Passed Images: ' + i + ' : ' + images.length);
                                var file = { name: images[i], size: 12345 };
                                dropzone.options.addedfile.call(dropzone, file);
                                dropzone.options.thumbnail.call(dropzone, file, window.storage_url + '/images/' + file.name);
                                dropzone.emit('complete', file);
                    }
                }
        }

        function base64ToFile(dataURI, origFile) {
            var byteString, mimestring;
            if(dataURI.split(',')[0].indexOf('base64') !== -1 ) {
                    byteString = atob(dataURI.split(',')[1]);
            } else {
                    byteString = decodeURI(dataURI.split(',')[1]);
            }
            mimestring = dataURI.split(',')[0].split(':')[1].split(';')[0];
            var content = new Array();
            for (var i = 0; i < byteString.length; i++) {
                content[i] = byteString.charCodeAt(i);
            }
            var newFile = new File(
                [new Uint8Array(content)], origFile.name, {type: mimestring}
            );

            // Copy props set by the dropzone in the original file
            var origProps = [ 
                "upload", "status", "previewElement", "previewTemplate", "accepted" 
            ];
            $.each(origProps, function(i, p) {
                newFile[p] = origFile[p];
            });
            return newFile;
        }


    </script>

    <style>
        .dropzone {
            background: #e3e6ff;
            border-radius: 13px;
            max-width: 550px;
            /* margin-left: auto;
            margin-right: auto; */
            border: 2px dotted #1833FF;
            margin-top: 5px;
        }

        .dz-preview {
            width: 100px;
        /* max-height: 75px; */
        }

        .dropzone .dz-preview .dz-image {
            height: 100px;
        }

    </style>