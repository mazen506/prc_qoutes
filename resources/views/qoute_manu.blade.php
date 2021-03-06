
<x-app-layout>
	<x-slot name="header">
        <h2 class="font-semibold">
            {{ __('global.new_qoute') }}
        </h2>
    </x-slot>

@php 
            $currency = $currencies->find($qoute->currency_id)['code_' . app()->getLocale()];
@endphp 
<div class="card card-qoute">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.qoute.title_singular') }}
    </div>

    <div class="card-body">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <form action="{{ route('qoutes.update', [$qoute->id]) }}" id="frmQoute" method="PUT" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" id="is_copy" name="is_copy">
            <x-form-elements :qoute=$qoute :units=$units :currencies=$currencies />
            <div class='form-row cust-total-container '>
                <div class='col-sm-3'>
                    <label for='total_cpm align-center'> {{ __('global.total_price')}}</label>        
                    <input type="text" id="total_price" name="total_price" class="form-control-plaintext align-center" >						
                </div>
                <div class='col-sm-3'>
                    <label for='total_cpm'> {{ __('global.total_cpm')}}</label>                    
                    <input type="text" id="total_cpm" name="total_cpm" class="form-control-plaintext align-center" >						
                </div>
            </div>

            <div class='row-buttons'>
                <button id='btn-add-item' class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    <span class="button-text">{{ __('global.add_item') }} </span>
                </button>
            </div>

            </div>  {{-- End of Card Body --}}

          </div>  {{-- End of card --}}
          <div class='row-buttons'>
                <div class="toast">
                      <div class="toast-header">
                           <strong class="mr-auto text-primary">{{ __('global.notification') }} </strong>
                          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                      </div>
                      <div class="toast-body">
                        {{__('global.qoute_link_copied')}}
                      </div>
                </div>

                <button id='btn-save-qoute' class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    <span class="button-text">{{ __('global.save') }} </span>
                </button>

                <button id='btn-copy-qoute' class="btn btn-warning">
                    <i class="fa fa-copy"></i>
                    <span class="button-text">{{ __('global.datatables.copy') }} </span>
                </button>


                <!-- <a onclick="copyToClipBoard('{{url("/qoute/" . $qoute->id )}}')" id='btn-share-qoute' class="btn btn-success">
                    <i class="fa fa-share-alt"></i>
                    <span class="button-text">{{ __('global.share') }} </span>
                </a> -->

                <a href="{{url('/qoute/' . $qoute->id . '/ac/' . $qoute->access_code)}}" target="_blank" id='btn-share-qoute' class="btn btn-success">
                        <i class="fa fa-share"></i>
                        <span class="button-text">{{ __('global.display') }} </span>
                </a>

                <a id='btn-del-qoute' href="" onclick="event.preventDefault(); delQoute()" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                    <span class="button-text"> {{__('global.delete_qoute')}} </span>
                </a>

                <a href="{{ route ('qoutes.index') }}" class="btn btn-secondary btn-close">
                    <i class="fa fa-close"></i>
                    <span class="button-text"> {{__('global.close')}} </span>
                </a>
            </div>  
        </form>

        <form id="del-qoute-form" action="{{ route('qoutes.destroy', $qoute->id) }}"
            method="POST" style="display: none;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>

        <x-item-image-viewer />

        <x-item-image-uploader :units=$units />

            </div>
</div>
</x-app-layout>

<script>

    var item_no;
    var isNew = true;
    var currItemIndex = 0;
    var frmItemDtlsSnap;
    var units;

   
    var validation = {
                rules: {
                    'item_name': "required",
                    'item_unit': {required: true,min:1},
                    'item_package_qty': "required",
                    'item_package_unit': {required:true, min:1},
                    'item_cpm': "required",
                    'item_price': "required",
                    'item_qty': "required",
                    // 'user_images[]': {required : '#user_images_str:blank'}
                },
                messages: {
                    'item_name': "{{ __('validation.required', ['attribute' => __('global.item_name') ]) }}",
                    'item_unit': "{{ __('validation.required', ['attribute' => __('global.unit') ]) }}",
                    'item_package_qty': "{{ __('validation.required', ['attribute' => __('global.quantity') ]) }}",
                    'item_package_unit': "{{ __('validation.required', ['attribute' => __('global.unit') ]) }}",
                    'item_cpm': "{{ __('validation.required', ['attribute' => __('global.cpm') ]) }}",
                    'item_price': "{{ __('validation.required', ['attribute' => __('global.price') ]) }}",
                    'item_qty': "{{ __('validation.required', ['attribute' => __('global.qty') ]) }}",
                    // 'user_images[]': "{{ __('validation.required', ['attribute' => __('global.user_images') ]) }}",
                }
            };

   
    $(document).ready(function(){

        item_no = $('#items_table tbody tr:visible').length-1;
//        console.log('Load Item_no' + item_no);

        //Units into javascript variable 
        units = {!! $units->toJson() !!};

        calQouteTotals();
    });


    function getUnitName(id){
        var unit_name='';
        $.each( units, function( index, unit ) {
            //console.log('Unit:' + id + ' ' + unit.id);
            if (unit.id == id)
            {    unit_name = unit.name;
                 return false;
            }
        });
        return unit_name;
    }

    $('#btn-copy-qoute').click(function(e){
        e.preventDefault();
        $('#is_copy').val(true);
        var $boxes = $('input[name="item_chks[]"]:unchecked');
        if ($boxes.length==0)
        {
            alert(trans('global.no_items_selected'));
            return;
        } else 
        {
            showSpinner(true);
            $boxes.each (function()
                {
                    $(this).closest('tr').remove();
                });
                
            $('input[name=_method]').val('POST');
            $('#frmQoute').attr('action','{{ route("qoutes.store") }}');
            $('#frmQoute').attr('method','POST');
            $('#frmQoute').submit();
        }
    
    });


    $("#frmQoute").validate({
                rules: {
                    'name': "required",
                    'currency': {required:true, min:1}
                },
                messages: {
                    'name': "{{ __('validation.required', ['attribute' => __('global.name') ]) }}",
                    'currency': "{{ __('validation.required', ['attribute' => __('global.currency') ]) }}"

                }
            });
    $("#frmItemDtls").validate(validation);

    function saveForm(isNew){

        console.log('Saving form ..');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});

let form_data = new FormData($('#frmQoute')[0]);
$.ajax({
    url: "{{ route("qoutes.update", [$qoute->id]) }}",
    type: 'post',
    data: form_data,
    dataType: 'json',
    processData: false,
    contentType: false,
    beforeSend: function(){
        showSpinner(true);
    },
    success: function (data) {
        showSpinner(false);
        //console.log(data);
        listItems(data);
        
        if (isNew)
            initNewItem();
        else   
        {      showFlashMessage(trans('global.save_success'));
               $('#itemDtlsModal').modal('hide');
        }
        
    },
    error: function (data) {
        showFlashMessage(trans('global.execution_error'));
        console.log(data);
        }
    });
}

function initNewItem(){
    confirm(trans('global.new_record_confirmation'), initNewItem);
    console.log('Inside Confirm Ready:' + confirm_ready + ':' + confirm_result);
    if (confirm_ready)
    {   console.log('Inside Confirm Ready:' + confirm_result);
        if (confirm_result) 
            clearModal('#itemDtlsModal');
        else 
            $('#itemDtlsModal').modal('hide');
    }


}

function listItems(data){
        //Remove All records except for 1,2

        console.log('Saving items' . data);
        $('#items_table tr:gt(1)').remove();
        
        
        $.each( data['items'], function( index, item ) {


            // Set serial
            if (index != 0)
                $('#item' + index).html($('#item0').html()).find('td:nth-child(2)').html(index+1);

            // Clear Images
            $('#item' + index).find('td:nth-child(3)').find('img:first').attr('src', '');

            // Set Values
            $('#items_table').append('<tr id="item' + (index+1) + '"></tr>');
            var item_id = document.getElementsByName('item_ids[]')[index];
            var user_images_str = document.getElementsByName('user_images_str[]')[index];
            var item_name = document.getElementsByName('item_names[]')[index];
            var item_unit = document.getElementsByName('item_units[]')[index];
            var item_unit_name = document.getElementsByName('item_units_names[]')[index];
            var item_package_qty = document.getElementsByName('item_package_qtys[]')[index];
            var item_package_unit = document.getElementsByName('item_package_units[]')[index];
            var item_package_unit_name = document.getElementsByName('item_package_units_names[]')[index];
            var item_price = document.getElementsByName('item_prices[]')[index];
            var item_qty = document.getElementsByName('item_qtys[]')[index];
            var item_total_price = document.getElementsByName('item_prices_totals[]')[index];
            var item_cpm = document.getElementsByName('item_cpms[]')[index];
            var item_total_cpm = document.getElementsByName('item_cpms_totals[]')[index];
            var item_note = document.getElementsByName('item_notes[]')[index];

            item_id.value = item.id;
            user_images_str.value = item.images;
            item_name.value = item.item_name;
            item_unit.value = item.unit_id;
            item_unit_name.innerHTML = getUnitName(item.unit_id);
            item_package_qty.value = item.package_qty;
            item_package_unit.value = item.package_unit_id;
            item_package_unit_name.innerHTML = item.package_qty + ' ' + getUnitName(item.package_unit_id);
            item_price.value = item.price;
            item_qty.value = item.qty;
            item_total_price.value = round(item.price * item.qty * item.package_qty,2);
            item_cpm.value = item.cpm;
            item_total_cpm.value = round(item.cpm * item.qty ,3);
            item_note.value = item.note;
            var item_image;
            if (item.images)
            {   item_image = item.images.split('|')[0];
                $('#item' + index).find('td:nth-child(3)').find('img:first').attr('src', window.storage_url + '/user_images/' + item_image);
            }
            item_no = index;
            });

            item_no++;
            calQouteTotals();
            //console.log('list items - item No: ' + item_no);
       
}

function calQouteTotals(){
    var prices_totals = document.getElementsByName('item_prices_totals[]');
    var cpms_totals = document.getElementsByName('item_cpms_totals[]');
    
    
    var total_price = 0;
    var total_cpm = 0;
    for (var i=0;i<prices_totals.length;i++){
    //    console.log(prices_totals[i].value);
        total_price += Number(prices_totals[i].value);
    }
     console.log('Total Price = ' + total_price);
    for (var i=0;i<cpms_totals.length;i++){
        total_cpm += Number(cpms_totals[i].value);
    }

    total_price = round(total_price,2).toLocaleString();
    $('#total_price').val(total_price + " " + "{{$currency}}" );
    $('#total_cpm').val(round(total_cpm,3));
}


$('#btn-save-qoute').click(function(e){
    e.preventDefault();
    saveForm(false);
});
/* -------------- Save Item ----------------- */




</script>
