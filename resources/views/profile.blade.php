<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold">
            {{ __('global.profile') }}
        </h2>
    </x-slot>
    <div>
    @if ($errors->any())
        <div class='alert alert-danger'>
            <ul>
            @foreach ($errors->all() as $error)                
                    <li>{{ $error }} </li>
            @endforeach
            </ul>
        </div>
    @endif
    </div>
    <div class='form-row profile-form'>
            <form name='frmProfile' id='frmProfile' action="{{ route('profile.update') }}" method='post'>
                @csrf
                @METHOD('PUT')

                
                    <div class='form-group col-md-10'>
                        <label for="title_{{ app()->getLocale() }}">{{ __('global.name') }}</label>
                        <input name="title_{{ app()->getLocale() }}" type='text' class='form-control' value="{{ old('title_'. app()->getLocale(),  $user['title_' . app()->getLocale()]) }}">
                    </div>

                    <div class='form-group col-md-10'>
                        <label for="address_{{ app()->getLocale() }}">{{ __('global.address') }}</label>
                        <input name="address_{{ app()->getLocale() }}" type='text' class='form-control' value="{{ old('address_'. app()->getLocale(),  $user['address_' . app()->getLocale()]) }}">
                    </div>

                
                    <div class='form-group col-md-5'>
                        <label for="phone">{{ __('global.phone') }}</label>
                        <input name="phone" type='text' class='form-control' value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class='form-group col-md-5'>
                        <label for="currency_id">{{ __('global.currency') }}</label>
                        <select name='currency_id' class='form-control'>
                                <option value=0>--- {{ __('global.currency')}} ---</option>
                            @foreach ($currencies as $currency)
                                <option value="{{$currency->id}}" @if ($user->currency_id == $currency->id) selected @endif>  {{ $currency['name_' . app()->getLocale()] }}</option>
                            @endforeach
                        </select>
                    </div>
                

                <div class='form-group col-md-5'>
                    <label for='profile-logo-file'>{{ __("global.logo") }}</label>
                    <div class='logo-container'>
                        <img src='/storage/images/camera.png' class='logo-container-camera'>
                        <img src="/storage/item_images/{{$user->logo ?? 'img-place-holder.png' }}" id='img-profile-logo'>
                    </div>
                </div>

                <div class='form-group'>
                    <input type='file' name='file-profile-logo' id='file-profile-logo' style='visibility:hidden'>
                </div>

                <div class='form-group col-md-10'>
                <label for="description_{{ app()->getLocale() }}">{{ __('global.description') }}</label>
                        <textarea name="description_{{ app()->getLocale() }}" class='form-control'> {{ old('description_'. app()->getLocale(),  $user['description_' . app()->getLocale()]) }} </textarea>
                </div>

                <div class='form-group col-md-10'>
                    <input type='submit' value="{{ __('global.save') }}" class='btn btn-lg btn-primary'>
                    <a class='btn btn-lg btn-secondary' href="{{ url('/qoutes') }}">{{ __('global.close')}}</a>
            </div>
            </form>
    </div>
</x-app-layout>    

<script>
        $("#frmProfile").validate({
                rules: {
                    'name': "required",
                    'currency_id': {required: true, min:1},
                    'phone' : {required: true, digits: true},
                    'address' : 'required',
                    'description' : 'required'
                    //'file-profile-logo': "required",
                },
                messages: {
                    'name': "{{ __('validation.required', ['attribute' => __('global.name') ]) }}",
                    'currency_id': "{{ __('validation.required', ['attribute' => __('global.currency') ]) }}",
                    'phone': "{{ __('validation.required', ['attribute' => __('global.phone') ]) }}",
                    'address': "{{ __('validation.required', ['attribute' => __('global.address') ]) }}",
                    'description': "{{ __('validation.required', ['attribute' => __('global.description') ]) }}",
                    //'file-profile-logo': "{{ __('validation.required', ['attribute' => __('global.logo') ]) }}",
                }
            });

        $('.logo-container').click(function(){
            $('#file-profile-logo').trigger('click');
        });
</script>