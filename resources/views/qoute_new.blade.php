
<x-app-layout>
	<x-slot name="header">
        <h2 class="font-semibold">
            {{ __('global.new_qoute') }}
        </h2>
    </x-slot>

<div class="card card-qoute">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.qoute.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route('qoutes.store') }}" id="frmQoute" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            @php 
                    if (!isset($qoute))
                         $qoute = null;
            @endphp                         
            <x-form-elements :qoute=$qoute :units=$units :currencies=$currencies />

            <div class='row'>
                <input type='button' id='btn-add-item' class="btn btn-primary btn-lg" value="{{__('global.add_item')}}">
                <input type='submit' class="btn btn-success btn-lg" value="{{__('global.save')}}">
                <input class="btn btn-secondary btn-lg btn-close" type="button" onclick='listItems()' value="{{ trans('global.close') }}">
            </div>
        </form>

        <x-item-image-viewer />

        <x-item-image-uploader :units=$units  />


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
                    // 'user_images[]': "required"
                },
                messages: {
                    'item_name': "{{ __('validation.required', ['attribute' => __('global.item_name') ]) }}",
                    'item_unit': "{{ __('validation.required', ['attribute' => __('global.unit') ]) }}",
                    'item_package_qty': "{{ __('validation.required', ['attribute' => __('global.quantity') ]) }}",
                    'item_package_unit': "{{ __('validation.required', ['attribute' => __('global.unit') ]) }}",
                    'item_cpm': "{{ __('validation.required', ['attribute' => __('global.cpm') ]) }}",
                    'item_price': "{{ __('validation.required', ['attribute' => __('global.price') ]) }}",
                    // 'user_images[]': "{{ __('validation.required', ['attribute' => __('global.user_images') ]) }}",
                }
            };

   
    $(document).ready(function(){
        item_no = $('#items_table tbody tr:visible').length-1;
    });



    $("#frmQoute").validate({
                rules: {
                    'name': "required",
                    'currency': {required:true, min:1}
                },
                messages: {
                    'name': "{{ __('validation.required', ['attribute' => __('global.name') ]) }}",
                    'currency': "{{ __('validation.required', ['attribute' => __('global.currency') ]) }}",
                }
            });
    $("#frmItemDtls").validate(validation);
</script>
