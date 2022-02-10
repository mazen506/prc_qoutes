<div class="modal fade" id="itemDtlsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" dir="rtl">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id='frmItemDtls' action="{{route('addImage')}}" name='frmItemDtls' method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">إضافة منتج</h4>
            </div>
            <div class="modal-body">
                   
           
                <div class="alert alert-danger">
                        {{__('validation.required_fields')}}
                </div>

                    {{-- Modal Body --}}
    <div class='form-group'>
        <label for='' class='col-sm-2'>{{ trans('cruds.item.fields.name') }}</label>
        <input type="text" id="item_name" name="item_name" value="مساطر" class="form-control col-sm-10"  required>
        <input type="hidden" id="user_images_str" name="user_images_str">
    </div>
    
    <div class='form-row'>
        <div class='form-group col-6'>
            <label for=''>{{ trans('cruds.item.fields.package') }}</label>
                        <select id="item_unit" name="item_unit" class="form-control col-sm-10">
                            <option value="0">-- حدد العبوة --</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>						
        </div>
        
        <div class='form-group col-3'>
            <label for=''>{{ trans('cruds.item.fields.qty') }}</label>
            <input type="number" id="item_package_qty" name="item_package_qty" value="50" class="form-control"  required>						
        </div>
        <div class='form-group col-3 col-item-package-unit'>
            <select id="item_package_unit" name="item_package_unit" class="form-control col-sm-10">
                <option value="0">العبوة</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">
                        {{ $unit->name }} 
                    </option>
                @endforeach
            </select>	
        </div>
    </div>
    
    <div class='form-row'>
        <div class='form-group col-6'>
            <label for=''>{{ trans('cruds.item.fields.price') }}</label>
            <input type="number" id="item_price" name="item_price" class="form-control" value=50  required>						
        </div>
        <div class='form-group col-6'>
            <label for=''>{{ trans('cruds.item.fields.moq') }}</label>
            <input type="number" id="item_moq" name="item_moq" class="form-control" value="500" required>						
        </div>
    </div>
    <div class='form-group'>
        <label for=''>{{ trans('cruds.item.fields.note') }}</label>
        <input type="text" id="item_note" name="item_note" class="form-control" value="سعر الشحن غير مضاف"  required>						
    </div>
    <div class='form-group'>
                <label>صور المنتج</label>
                <label class='lbl-img' for="file_user_images">
                    <img src="/storage/images/icon_upload_image.png" width=50 height=50 title="{{ __('global.add_images')}}"/>
                </label>
                <input type="file" id="file_user_images" name="user_images[]" multiple>
                <label id="file_user_images-error" class="error"></label>
    </div>                        
                
            

    <!-- Coursel -->
    <div class="container form-row">
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
     </div>
     <!-- End of Coursel-->
        
    </div>{{-- End of Modal Body --}}
    <div class="modal-footer">
         <input type=button id="btn-item-dtls-save" class="btn btn-primary" value="{{ __('global.save') }}">
         <input type=button  class="btn btn-secondary btn-close" value="{{ __('global.close') }}">
    </div>
    </form>
    
        </div>
    </div>
</div> <!-- End of Item Details Modal -->