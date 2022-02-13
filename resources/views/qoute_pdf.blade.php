<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
            <meta charset="utf-8"/>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>{{ config('app.name', 'Wesalix') }}</title>
        
        
        <link rel="stylesheet" href="{{ public_path('css/coreui.min.css') }}">
        <link rel="stylesheet" href="{{ public_path('css/font-awesome.css') }}">
        
        <!-- Styles -->
        @if(App::getLocale() == 'en')
            <link rel="stylesheet" href="{{ public_path('css/custom.css') }}">
            <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}">
        @else
            <link rel="stylesheet" href="{{ public_path('css/custom_rtl.css') }}">
            <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}"> 
        @endif



    <style>

    @font-face {    
    font-family: 'DroidArabicKufiRegular';
    src: url(data:font/truetype;charset=utf-8;base64,{{base64_encode(@file_get_contents('fonts/DroidKufi-Regular.ttf'))}}) format('truetype');
    font-weight: normal;
    font-style: normal;
    }

    @font-face {
    font-family: 'FontAwesome';
    src: url(data:font/truetype;charset=utf-8;base64,{{base64_encode(@file_get_contents('fonts/fontawesome-webfont.ttf'))}}) format('truetype');
    font-weight: normal;
    font-style: normal;
    }

    ul.contact-info-widget.default {
    padding-left: 0px;
    padding-right: 0px;
}
  
        .col-md-6 {
            display: inline-block;
            width: 45% !important;
        }
        .col-sm-3 {
            width:25%;
        }

        .footer-box {
            display: inline-block;
            width: 40% !important;
            vertical-align: middle;
            margin: auto;

        }

        table thead, table tfoot {
            display: table-row-group !important;
        }   

        table tr {
            page-break-inside: avoid !important;
        }
     

    </style>
        
    </head>

    <body class="font-sans antialiased">
        <div class="cust-screen">

            <!-- Page Heading -->
            <header class="bg-white">
                <div class="cust-header">
                <div class='customer-layout-header'>
                    <div class='layout-logo'>
                    <img src='data:image/jpeg;base64,{{base64_encode(@file_get_contents("storage/user_images/$vendor->logo"))}}'>
                    <label> {{$vendor['title_' . app()->getLocale() ]}} </label>
                </div>
        </div>
                </div>
            </header>

            <!-- Page Content -->
            <main>
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
                    <input type="text" readonly class="form-control" id="id" value="{{ $currency }}">
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
                        <table class="table-responsive-sm table-striped tbl-qoute-items cust-table" id="items_table">
                            
                                <tr>
                                    <th class='col-item-serial'></th>
                                    <th class='align-center'>{{ trans('cruds.item.fields.image') }}</th>
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
                            
    
                            @php
                                $total_price = 0;
                                $total_cpm = 0;
                            @endphp
                            @foreach ($qoute->items as $item)
                                <tr id="item{{ $loop->index }}">
                                    <td class='col-item-serial align-center'>{{ $loop->index+1 }}</td>
                                    <td>
                                            @php
                                                $item_image = explode("|", $item->images)[0];
                                            @endphp
                                            <img class='item-image' src='data:image/jpeg;base64,{{base64_encode(@file_get_contents("storage/user_images/$item_image"))}}'>
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
                                        {{ round($item->qty * $item->price * $item->package_qty,2) }}
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
                        
                    </table>
                    <div class='form-row cust-total-container'>
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

                
</div>

            </main>

            <footer>
            <div class='vendor-details row'>
            <div class="footer-box">
				            <div id="footer_about_me-3" class="footer-widget widget-footer-about-me about-me-widget clr">
				                <div class="footer-about-me">
                					<div class="footer-about-me-avatar clr">
											<img src='data:image/jpeg;base64,{{base64_encode(@file_get_contents("storage/user_images/$vendor->logo"))}}'>
                					</div><!-- .footer-about-me-avatar -->

									<div class="footer-about-me-text clr">
                                        <div class="footer-about-me-text clr" style="direction: ltr;">
                                            {{ $vendor['description_' . app()->getLocale() ] }}
                                        </div>
                                    </div>
				                </div>
                            </div>
             </div>
             <div class="footer-box">
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

            </footer>

        </div>
    </body>
  

</html>

