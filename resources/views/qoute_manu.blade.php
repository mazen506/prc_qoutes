@extends('layout')
@section('content') 

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.qoute.title_singular') }}
    </div>

    <div class="card-body">
        <form action="" id="frm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="curr_row_index" value=0>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.qoute.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($qoute) ? $qoute->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.qoute.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                <label for="note">{{ trans('cruds.qoute.fields.note') }}</label>
                <input type="text" id="note" name="note" class="form-control" value="{{ old('note', isset($qoute) ? $qoute->note : '') }}">
                @if($errors->has('note'))
                    <em class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.qoute.fields.note_helper') }}
                </p>
            </div>

            <div class="card">
                <div class="card-header">
					{{ trans('global.items') }}
                </div>


	
				<div class="card-body">
				
				<table class="table-responsive-md table tbl-qoute-items" id="items_table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ trans('cruds.item.fields.name') }}</th>
								<th>{{ trans('cruds.item.fields.package') }}</th>
                                <th>{{ trans('cruds.item.fields.qty') }}</th>
								<th>{{ trans('cruds.item.fields.price') }}</th>
								<th>{{ trans('cruds.item.fields.moq') }}</th>
								<th>{{ trans('cruds.item.fields.note') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $index => $item)
                                <tr id="item{{ $index }}">
                                    <td>
                                        @if (!empty($item))
                                         @php 
                                            $item_image = explode("|", $item->images)[0];
                                         @endphp
										 <span class='item-images-str'>{{$item->images}}</span>
                                         <image class='item-image' src="/storage/item_images/{{$item_image}}"> 
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" name="item_names[]" class="form-control" value="{{ $item->name ?? '1' }}" readonly required>
                                    </td>
									<td>
                                        <input type="hidden" name="packages[]">
                                        <label name="package_names[]" class='form-control'>
                                    </td>
                                    <td>
                                        <input type="number" name="quantities[]" class="form-control" value="{{ $item->qty ?? '1' }}" readonly required>
                                    </td>
									<td>
                                        <input type="number" name="prices[]" class="form-control" value="{{ $item->price ?? '1' }}" readonly required>
                                    </td>
                                    <td>
                                        <input type="number" name="moqs[]" class="form-control" value="{{ $item->moq ?? '1' }}" readonly required>
                                    </td>	
                                    <td>
                                        <input type="text" name="notes[]" class="form-control" value="{{ $item->note ?? '1' }}" readonly required>
                                    </td>									
                                </tr>
                            @endforeach
                            <tr id="item{{ $index }}"></tr>
                        </tbody>
				</table>
				
				<button type="button" id='btn-add-item' class="btn btn-primary btn-lg">إضافة منتج +</button>
		
				
				{{--
                    <div class="row">
                        <div class="col-md-12">
                            <button id="add_row" class="btn btn-default pull-left">{{ trans('global.add_row') }}</button>
                            <button id='delete_row' class="pull-right btn btn-danger">{{ trans('global.delete_row') }}</button>
                        </div>
                    </div>
				--}}
				
                </div>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>

        <!-- Images Carousel -->
        <div class="modal fade" id="itemImagesModal" tabindex="-2" role="dialog" aria-labelledby="itemImagesModalLabel" dir="rtl">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="itemImagesModalLabel">صور المنتج</h4>
                    </div>
                    <div class="modal-body">
                        <div id="itemImageViewerCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" id="item-images-viewer">

                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="sr-only">السابق</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="sr-only">التالي</span>
                            </a>
                          </div>
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>   
        <!-- End of Images Carousel -->
        <!-- Item Details Modal -->
        <div class="modal fade" id="itemDtlsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" dir="rtl">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">إضافة منتج</h4>
                    </div>
                    <div class="modal-body">
                            
                            {{-- Modal Body --}}
                            <div class='form-group'>
                <label for='' class='col-sm-2'>{{ trans('cruds.item.fields.name') }}</label>
                <input type="text" id="item_name" value="مساطر" class="form-control col-sm-10"  required>
                <input type="hidden" id="item_images">
            </div>
            
            <div class='form-row'>
                <div class='form-group col-6'>
                    <label for=''>{{ trans('cruds.item.fields.package') }}</label>
                                <select id="item_package" class="form-control col-sm-10">
                                    <option value="">-- حدد العبوة --</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}">
                                            {{ $package->name }} 
                                        </option>
                                    @endforeach
                                </select>						
                </div>
                
                <div class='form-group col-6'>
                    <label for=''>{{ trans('cruds.item.fields.qty') }}</label>
                    <input type="number" id="item_quantity" value="50" class="form-control"  required>						
                </div>
            </div>
            
            <div class='form-row'>
                <div class='form-group col-6'>
                    <label for=''>{{ trans('cruds.item.fields.price') }}</label>
                    <input type="number" id="item_price" class="form-control" value=50  required>						
                </div>
                <div class='form-group col-6'>
                    <label for=''>{{ trans('cruds.item.fields.moq') }}</label>
                    <input type="number" id="item_moq" class="form-control" value="500" required>						
                </div>
            </div>

            <div class='form-group'>
                    <form id='frm_images' action="{{route('addImage')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="btn-add-images">
                            <img src="/storage/item_images/icon_upload_image.png" width=50 height=50/>
                          </label>
                        <input type="file" id="btn-add-images1" name="item_images[]" required multiple>
                        <input type="button" id="btn-add-images" value="إضافة صور..">
                    </form>

                    <!-- Coursel -->

                    <div class="container">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="carousel slide multi-item-carousel" id="theCarousel">
                              <div class="carousel-inner" id="image-viewer">

                              </div>
                              <a class="left carousel-control-prev" href="#theCarousel" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                              </a>
                              <a class="right carousel-control-next" href="#theCarousel" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>

                    <!-- End of Coursel-->
               </div>
            
                    <div class='form-group'>
                        <label for=''>{{ trans('cruds.item.fields.note') }}</label>
                        <input type="text" id="item_note" class="form-control" value="سعر الشحن غير مضاف"  required>						
                    </div>
            
                                {{-- End of Modal Body --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="add_row" data-dismiss="modal" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div> <!-- End of Item Details Modal -->


    </div>
</div>
@endsection 

@section('scripts')
<script>


  $(document).ready(function(){

    //$("#btn_add_image").click(function(e){
        //$('#frm_images').submit();
    //});

    //Image Viewer

    $('#btn-add-item').click(function(){
        $('#itemDtlsModal').modal('toggle');
        let row_number = $('#items_table tr:visible').length;
        $('#curr_row_index').val(row_number);
    });
    
    $("#add_row").click(function(e){
      let row_number = {{ count(old('items', [''])) }};
      e.preventDefault();
	  if (row_number>1) {
		let new_row_number = row_number - 1;
		$('#item' + row_number).html($('#item' + new_row_number).html()).find('td:first-child');
		//Fill Row items from modal
		$('#items_table').append('<tr id="item' + (row_number + 1) + '"></tr>');
		row_number++;
	  } else { //display the first row
		    $('#item0').css("display","contents");
	  }
      
	  
	  var item_name = document.getElementsByName('item_names[]')[row_number-1];
	  var item_package = document.getElementsByName('packages[]')[row_number-1];
      var item_package_name = document.getElementsByName('package_names[]')[row_number-1];
	  var item_qty = document.getElementsByName('quantities[]')[row_number-1];
	  var item_price = document.getElementsByName('prices[]')[row_number-1];
	  var item_moq = document.getElementsByName('moqs[]')[row_number-1];
	  var item_note = document.getElementsByName('notes[]')[row_number-1];


	  //alert(item_names.length)
	  item_name.value = $("#item_name").val();
	  item_package.value = $("#item_package").val();
      item_package_name.innerHTML = $("#item_package :selected").text().trim();
	  item_qty.value = $("#item_quantity").val();
	  item_price.value = $("#item_price").val();
	  item_moq.value = $("#item_moq").val();
	  item_note.value = $("#item_note").val();
	  
    });


    $("#delete_row").click(function(e){
      e.preventDefault();
      if(row_number > 1){
        $("#item" + (row_number - 1)).html('');
        row_number--;
      }
    }); // End of Delete Item function 


	$('.item-image').click(function(){
        $('#item-images-viewer').empty();
        var item_images = $(this).prev().text().split("|");
		if (item_images.length>0)
		{
			
			$('#itemImagesModal').modal('toggle');
        	for(var key = 0 ; key<item_images.length; key++)
        	{   
				if (key == 0) 
            	        $('#item-images-viewer').append( "<div class='carousel-item active'>");
            	else
                	    $('#item-images-viewer').append( "<div class='carousel-item'>");

            	$('#item-images-viewer').children(':last-child').append("<img src='/storage/item_images/" + item_images[key] + "'>"); 
            	$('#item-images-viewer').append("</div>");
        	}
		}
  	}); // End of Item Image function 


  });


</script>
@endsection
