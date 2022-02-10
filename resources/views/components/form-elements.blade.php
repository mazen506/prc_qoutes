

    @if ($errors->any())
        <div class='alert alert-danger'>
            <ul>
            @foreach ($errors->all() as $error)                
                    <li>{{ $error }} </li>
            @endforeach
            </ul>
        </div>
    @endif
    <div class="alert alert-danger clt-alert">
                        {{__('validation.required_fields')}}
    </div>

<div class='form-row'>
    <div class="col-sm-6 {{ $errors->has('name') ? 'has-error' : '' }}">
        <label for="name">{{ trans('cruds.qoute.fields.customer') }}*</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', optional($qoute)->name) }}" required>
        
        
        {{-- @if($errors->has('name'))
            <em class="invalid-feedback">
                {{ $errors->first('name') }}
            </em>
        @endif --}}
        <p class="helper-block">
            {{ trans('cruds.qoute.fields.name_helper') }}
        </p>
    </div>
    <div class="col-sm-6 {{ $errors->has('currency') ? 'has-error' : '' }}">
        <label for="currency">{{ trans('cruds.qoute.fields.currency') }}*</label>
        <select id="currency" name="currency" class="form-control">
                            <option value="0">-- {{ __('global.currency') }} --</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}" @php if (($currency->id) == (optional($qoute)->currency_id ?: Auth::user()->currency_id)) echo 'selected'; @endphp>
                                    {{ $currency['code_' . app()->getLocale()] }}
                                </option>
                            @endforeach
        </select>	
    </div>
</div>    
<div class='form-row'>
   <div class="col {{ $errors->has('note') ? 'has-error' : '' }}">
        <label for="note">{{ trans('cruds.qoute.fields.note') }}</label>
        <input type="text" id="note" name="note" class="form-control" value="{{ old('note', optional($qoute)->name) }}">
        <p class="helper-block">
            {{ trans('cruds.qoute.fields.note_helper') }}
        </p>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header">
        {{ trans('global.items') }}
    </div>

    <div class="card-body">
        <table class="table-responsive table-striped tbl-qoute-items cust-table" id="items_table">
            <thead>
                <tr>
                    <th class='align-center'></th>
                    <th class='col-item-serial'></th>
                    <th class='col-item-image'></th>
                    <th class='col-item-name'>{{ trans('cruds.item.fields.name') }}</th>
                    <th class='align-center'>{{ trans('cruds.item.fields.qty') }}</th>
                    <th class='align-center'>{{ trans('cruds.item.fields.unit') }}</th>
                    <th class='align-center'>{{ trans('cruds.item.fields.package') }}</th>
                    <th class='align-center'>{{ trans('cruds.item.fields.price') }}</th>
                    <th class='align-center'>{{ trans('global.total_price') }}</th>
                    <th class='align-center'>{{ trans('cruds.item.fields.cpm') }}</th>
                    <th class='align-center'>{{ trans('global.total_cpm') }}</th>
                    <th class='col-item-note'>{{ trans('cruds.item.fields.note') }}</th>
                    <th class='col-item-btn'></th>
                </tr>
            </thead>
            <tbody>
              
                @if (!old('item_names') && (!isset($qoute) || optional($qoute->items)->count() ==0)) 
                    <tr id="item0" style="display:none">
                        <td><input type='checkbox' name='item_chks[]' class='form-control'></td>
                        <td class='col-item-serial'>1</td>
                        <td class='col-item-image'>
                            <input type=hidden name="item_ids[]" value=0>
                            <input type=hidden name="is_edited_flags[]">
                            <input type=hidden name='user_images_str[]'>
                            <image class='item-image' src=""> 
                        </td>
                        <td class='col-item-name'>
                            <input type="text" name="item_names[]" class="form-control-plaintext lst-item-name" readonly required>
                        </td>
                        <td class='col-item-small align-center'>
                            <input type="number" name="item_qtys[]" class="form-control-plaintext align-center"  readonly required>
                        </td>
                        <td class='col-item-small align-center'>
                            <input type="hidden" name="item_units[]">
                            <label name="item_units_names[]" class='form-control-plaintext'>
                        </td>

                        <td class='col-item-small align-center'>
                            <input type="hidden" name="item_package_qtys[]" class="form-control-plaintext"  readonly required>
                            <input type="hidden" name="item_package_units[]" class="form-control-plaintext"  readonly required>
                            <label name="item_package_units_names[]" class='form-control-plaintext'>
                        </td>

                        <td class='col-item-small align-center'>
                            <input type="number" name="item_prices[]" class="form-control-plaintext align-center"  readonly required>
                        </td>



                        <td class='col-item-small align-center'>
                            <input type="text" name="item_prices_totals[]" class="form-control-plaintext align-center"  readonly>
                        </td>

                        <td class='col-item-small align-center'>
                                <input type="number" name="item_cpms[]" class="form-control-plaintext align-center" readonly required>
                        </td>	

                        <td class='col-item-small align-center'>
                            <input type="text" name="item_cpms_totals[]" class="form-control-plaintext align-center"  readonly>
                        </td>                            

                        <td class='col-item-note'>
                            <input type="text" name="item_notes[]" class="form-control-plaintext"  readonly >
                        </td>		
                        <td class='col-item-btn align-center'><img src='/storage/images/delete_icon.png' class='icon-action-sm icon-del-item'></td>							
                    </tr>
                @else
                
                @foreach (old('item_names', optional(optional($qoute)->items)->count() ? $qoute->items : ['']) as $item)
                        <tr id="item{{ $loop->index }}">
                            <td><input type='checkbox' name='item_chks[]' class='form-control'></td>
                            <td class='col-item-serial align-center'>{{ $loop->index+1 }}</td>
                            <td class='col-item-image align-center'>
                                <input type=hidden name=item_ids[] value={{ (old('item_ids.' . $loop->index) ?? $item->id) ?? '' }}>
                                <input type=hidden name="is_edited_flags[]" value=0>
                                @if (!empty($item))
                                    @php 
                                        $user_images = old('user_images_str.' . $loop->index,  optional($item)->images);
                                        $item_image = explode("|", $user_images)[0];
                                    @endphp
                                    <input type=hidden name='user_images_str[]' value={{$user_images}}>
                                    <image class='item-image' src="{{ $storage_url }}/user_images/{{$item_image}}"> 
                                @endif
                            </td>
                            <td class='col-item-name'>
                                <input type="text" name="item_names[]" class="form-control-plaintext lst-item-name" value="{{ old('item_names.' . $loop->index, optional($item)->item_name) }}" readonly required>
                            </td>

                            
                            <td class='col-item-small align-center'>
                                <input type="number" name="item_qtys[]" class="form-control-plaintext align-center" value="{{ old('item_qtys.' . $loop->index, optional($item)->qty) }}" readonly required>
                            </td>

                            
                            <td class='col-item-small align-center'>
                                <input type="hidden" name="item_units[]" value={{ old('item_units.' . $loop->index, optional($item)->unit_id) }}>
                                <label name="item_units_names[]" class='form-control-plaintext'>{{ $units->find(old('item_units.' . $loop->index, optional($item)->unit_id))->name }}</label>
                            </td>

                            <td class='col-item-small align-center'>
                                <input type="hidden" name="item_package_qtys[]" class="form-control-plaintext" value="{{ old('item_package_qtys.' . $loop->index, optional($item)->package_qty) }}" readonly required>
                                <input type="hidden" name="item_package_units[]" class="form-control-plaintext" value="{{ old('item_package_units.' . $loop->index, optional($item)->package_unit_id)  }}" readonly required>
                                <label name="item_package_units_names[]" class='form-control-plaintext'>{{ old('item_package_qtys.' . $loop->index, optional($item)->package_qty) . ' ' . $units->find(old('item_package_units.' . $loop->index, optional($item)->package_unit_id))->name }}</label>
                            </td>

                            <td class='col-item-small align-center'>
                                <input type="number" name="item_prices[]" class="form-control-plaintext align-center" value="{{ old('item_prices.' . $loop->index, optional($item)->price) }}" readonly required>
                            </td>


                            <td class=''>
                                <input type="text" name="item_prices_totals[]" class="form-control-plaintext align-center" value="{{ round(optional($item)->package_qty * optional($item)->qty*optional($item)->price,2) }}" readonly>
                            </td>

                            <td class='col-item-small align-center'>
                                <input type="text" name="item_cpms[]" class="form-control-plaintext align-center" value="{{ old('item_cpms.' . $loop->index, optional($item)->cpm) }}" readonly required>
                            </td>	

                            <td class='col-item-small align-center'>
                                <input type="number" name="item_cpms_totals[]" class="form-control-plaintext align-center" value="{{ round(optional($item)->qty*optional($item)->cpm,3) }}" readonly required>
                            </td>

                            <td class='col-item-note'>
                                <input type="text" name="item_notes[]" class="form-control-plaintext" value="{{ old('item_notes.' . $loop->index, optional($item)->note) }}" readonly>
                            </td>		
                            <td class='col-item-btn align-center'><img src='/storage/images/delete_icon.png' class='icon-action-sm icon-del-item'></td>							
                        </tr>
                     @endforeach
                @endif
                @php
                    $index = count(old('item_names', optional($qoute)->items ? $qoute->items : [''])) ?? 0;
                @endphp
                <tr id="item{{$index}}"></tr>
            </tbody>
        </table>
