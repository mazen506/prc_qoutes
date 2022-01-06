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
    
        <div id="dropzone">
                <form action="{{ route('dropzoneFileUpload') }}" class="dropzone" id="file-upload" enctype="multipart/form-data">
                    @csrf
                    <div class="dz-message">
                        إسحب الصور هنا للإضافة<br>
                    </div>
                </form>
        </div>

    </div>{{-- End of Modal Body --}}

            <div class="modal-footer">
                 <input type=button id="btn-item-dtls-save" class="btn btn-primary" value="{{ __('global.save') }}">
                 <input type=button  class="btn btn-secondary btn-close" value="{{ __('global.close') }}">
            </div>
        </div>
    </div>
</div> <!-- End of Item Details Modal -->


HII WORLD
<script>
    Dropzone.autoDiscover = true;

    Dropzone.options.fileDropzone = {
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        maxFilesize: 8,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        previewTemplate: document.querySelector('#preview-template').innerHTML,
        parallelUploads: 3,
        thumbnailHeight: 100,
        thumbnailWidth: 100,
        maxFilesize: 5,
        filesizeBase: 1500,
        addRemoveLinks: true,
        complete: function() {
                     $(".dz-remove").html("<div><span class='fa fa-trash text-danger' style='font-size: 1.5em'></span></div>");
        },
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
                    console.log(file);
                    delImage(file);
                },

        success: (file) => {
                    data = JSON.parse(file.xhr.responseText);
                    buildImageStr(data);
                }
        });

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

   