<x-customer-layout>
<x-slot name="header">
        <div class='customer-layout-header'>
            <div class='layout-logo'>
                <img src='https://mazmustaws.s3.us-east-2.amazonaws.com/images/{{$vendor->logo}}'>
                <label> {{$vendor['title_' . app()->getLocale() ]}} </label>
            </div>
        </div>
</x-slot>

<div class="container">
        <div class='cust-page-title align-center'>
                    <h2>{{ __('global.qoute') }}</h2>
        </div>
        <div class='form-row'>
            <div class="form-group col-md-6">
                    <label for="name" class="col-form-label">{{ __('global.qoute_name')}}</label>
                    <div>
                        <input type="text" readonly class="form-control" id="id" value="{{ $qoute->name }}">
                    </div>
            </div>
        </div>

        <div class='form-row'>
            <div class="form-group col-md-6">
                <label for="date" class="col-form-label">{{ __('global.currency')}}</label>
                <div>
                    <input type="text" readonly class="form-control" id="id" value="{{$currency}}">
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="note" class="col-form-label">{{ __('global.note')}}</label>
                <div>
                    <input type="text" readonly class="form-control" id="note" value="{{$qoute->note}}">
                </div>
            </div>
        </div>


        <div class="card">
                    <div class="card-header">
                        {{ trans('global.items') }}
                    </div>

                    <div class="card-body">
                        <table class="table-responsive table-striped tbl-qoute-items cust-table" id="items_table">
                            <thead>
                                <tr>
                                    <th class='col-item-serial'></th>
                                    <th class='col-item-image align-center'>{{ trans('cruds.item.fields.images') }}</th>
                                    <th class='col-item-name'>{{ trans('cruds.item.fields.item_name') }}</th>
                                    <th class='align-center'>{{ trans('cruds.item.fields.qty') }}</th>
                                    <th class='align-center'>{{ trans('cruds.item.fields.unit') }}</th>
                                    <th class='align-center'>{{ trans('cruds.item.fields.package') }}</th>
                                    <th class='align-center'>{{ trans('cruds.item.fields.price') }}</th>
                                    <th class='align-center'>{{ trans('global.total_price') }}</th>
                                    <th class='align-center'>{{ trans('cruds.item.fields.cpm') }}</th>
                                    <th class='align-center'>{{ trans('global.total_cpm') }}</th>
                                    <th class='col-item-note'>{{ trans('cruds.item.fields.note') }}</th>
                                </tr>
                            </thead>
                            <tbody>
    
                            @php
                                $total_price = 0;
                                $total_cpm = 0;
                            @endphp
                            @foreach ($qoute->items as $item)
                                <tr id="item{{ $loop->index }}">
                                    <td class='col-item-serial align-center'>{{ $loop->index+1 }}</td>
                                    <td class='col-item-image align-center'>
                                        @php 
                                            $item_images = $item->images;
                                            $item_image = explode("|", $item_images)[0];
                                        @endphp
                                        <input type=hidden name='item_images_str' value={{$item_images}}>
                                        <image class='item-image' src="https://mazmustaws.s3.us-east-2.amazonaws.com/images/{{$item_image}}"> 
                                    </td>
                                    <td class='col-item-name'>
                                        {{ $item->item_name }}
                                    </td>
                                    <td class='col-item-small align-center'>
                                        {{ $item->qty }}
                                    </td>
                                    <td class='col-item-small align-center'>
                                        {{ $units->find($item->unit_id)->name }}
                                    </td>
                                    <td class='col-item-small align-center'>
                                        {{ $item->package_qty . ' ' . $units->find($item->package_unit_id)->name }}
                                    </td>
                                    <td class='col-item-small align-center'>
                                        {{ $item->price+0 }}
                                    </td>	
	
                                    <td class='col-item-small align-center'>
                                        {{ number_format(round($item->qty * $item->price * $item->package_qty,2),0,'.',',') }}
                                    </td>	
                                    <td class='col-item-small align-center'>
                                        {{ $item->cpm }}
                                    </td>	

                                    <td class='col-item-small align-center'>
                                        {{ round($item->cpm * $item->qty,3) }}
                                    </td>

                                    <td class='col-item-note'>
                                        {{ $item->note }}
                                    </td>		

                                </tr>
                                @php
                                          $total_price += round($item->qty * $item->price * $item->package_qty,2);
                                          $total_cpm += round($item->cpm * $item->qty,3);
                                @endphp
                         @endforeach
                        </tbody>
                    </table>
            
                    <div class='form-row cust-total-container '>
                          <div class='col-sm-3'>
                             <label for='total_cpm align-center'> {{ __('global.total_price')}}</label>        
                             <input type="text" id="total_price" name="total_price" value="{{ number_format(round($total_price,2),2,'.',',') }}" class="form-control-plaintext align-center" >						
                           </div>
                           <div class='col-sm-3'>
                             <label for='total_cpm'> {{ __('global.total_cpm')}}</label>                    
                             <input type="text" id="total_cpm" name="total_cpm" class="form-control-plaintext align-center" value="{{$total_cpm}}">						
                           </div>
                    </div>
                 </div>

                </div>

                <div class='row-buttons'>
                    <a href="{{url('/qoute/' . $qoute->id . '/create-pdf')}}"  class="btn btn-success">
                        <i class="fa fa-download"></i>
                        <span class="button-text">{{ __('global.download') }} </span>
                    </a>
                    <a href="{{url('/qoute/' . $qoute->id . '/export-excel')}}"  class="btn btn-success">
                        <i class="fa fa-file-excel-o"></i>
                        <span class="button-text">{{ __('global.datatables.excel') }} </span>
                    </a>
                </div>


                <x-item-image-viewer />
</div>
      
<x-slot name='vendor_details'>
            <div class='vendor-details row'>
            <div class="footer-box col-md-4">
				            <div id="footer_about_me-3" class="footer-widget widget-footer-about-me about-me-widget clr">
				                <div class="footer-about-me">
                					<div class="footer-about-me-avatar clr">
											<img src="https://mazmustaws.s3.us-east-2.amazonaws.com/images/{{$vendor->logo}}" alt="">
                					</div><!-- .footer-about-me-avatar -->

									<div class="footer-about-me-text clr">
                                        <div class="footer-about-me-text clr" style="direction: ltr;">
                                            {{ $vendor['description_' . app()->getLocale() ] }}
                                        </div>
                                    </div>
				                </div>
                            </div>
             </div>
             <div class="footer-box col-md-4">
					    <div id="footer_contact_info" class="footer-widget widget-footer-contact-info clr">
                            <h4 class="widget-title">{{ __('global.contact_us')}}</h4>
                            <ul class="contact-info-widget default">
                                <li class="address">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <div class="footer-info-wrap">
                                        <span class="footer-contact-title">{{ __('global.address')}}: </span>
                                        <span class="footer-contact-text">
                                            {{ $vendor['address_' . app()->getLocale() ] }}
                                        </span>
                                    </div>
                                </li>
                                <li class="phone">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    <div class="footer-info-wrap">
                                        <span class="footer-contact-title">{{ __('global.phone')}}: </span>
                                        <span class="footer-contact-text">{{ $vendor->phone }}</span>
                                    </div>
                                </li>
                                <li class="email">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <div class="footer-info-wrap">
                                        <span class="footer-contact-title">{{__('global.email')}} :</span>
                                        <span class="footer-contact-text">
                                            <a href="mailto:{{$vendor->address}}">{{$vendor->email}}</a>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>				
                </div>
            </div>                
</x-slot>
</x-customer-layout>    


