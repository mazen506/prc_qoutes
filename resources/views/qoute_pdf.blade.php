<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
            <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
    src: url(data:font/truetype;charset=utf-8;base64,{{base64_encode(@file_get_contents(public_path('fonts/DroidKufi-Regular.ttf')))}}) format('truetype');
    font-weight: normal;
    font-style: normal;
    }

    @font-face {
    font-family: 'FontAwesome';
    src: url(data:font/truetype;charset=utf-8;base64,{{base64_encode(@file_get_contents(public_path('fonts/fontawesome-webfont.ttf')))}}) format('truetype');
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
                    <img src='data:image/jpeg;base64,{{base64_encode(@file_get_contents(url("https://mazmustaws.s3.us-east-2.amazonaws.com/images/$vendor->logo")))}}'>
                    <label> {{$vendor['title_' . app()->getLocale() ]}} </label>
                </div>
        </div>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                     <!-- Ajax loader -->
                     <div id='cust-spinner'>
                            <img src="{{ public_path('/storage/images/spinner.gif') }}">
                     </div>
                     <div id="dialog" title="Basic dialog"></div>
                   
                     <div class="container">
        <div class='row cust-page-title align-center'>
                    <h2>{{ __('global.qoute') }}</h2>
        </div>
        <div class='form-row'>
            <div class="form-group col-md-6">
                    <label for="name" class="col-form-label">{{ __('global.qoute_name')}}</label>
                    <div>
                        <input type="text" readonly class="form-control-plaintext" id="id" value="{{ $qoute->name }}">
                    </div>
            </div>
        </div>

        <div class='form-row'>
            <div class="form-group col-md-6">
                <label for="date" class="col-form-label">{{ __('global.create_date')}}</label>
                <div>
                    <input type="text" readonly class="form-control-plaintext" id="id" value="{{$qoute->created_at->format('d.m.Y')}}">
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="note" class="col-form-label">{{ __('global.note')}}</label>
                <div>
                    <input type="text" readonly class="form-control-plaintext" id="note" value="{{$qoute->note}}">
                </div>
            </div>
        </div>


        <div class="card">
                    <div class="card-header">
                        {{ trans('global.items') }}
                    </div>

                    <div class="card-body">
                        <table class="table-responsive-sm table-striped tbl-qoute-items cust-table" id="items_table">
                            <thead>
                                <tr>
                                    <th class='col-item-serial'>{{ __('global.serial')}}</th>
                                    <th class='col-item-name'>{{ trans('cruds.item.fields.item_name') }}</th>
                                    <th class='align-center'>{{ trans('cruds.item.fields.unit') }}</th>
                                    <th class='align-center'>{{ trans('cruds.item.fields.cpm') }}</th>
                                    <th class='align-center'>{{ trans('cruds.item.fields.qty') }}</th>
                                    <th class='align-center'>{{ trans('cruds.item.fields.price') }}</th>
                                    <th class='col-item-note'>{{ trans('cruds.item.fields.note') }}</th>
                                </tr>
                            </thead>
                            <tbody>
    
                            @foreach ($qoute->items as $item)
                                <tr id="item{{ $loop->index }}">
                                    <td class='col-item-serial align-center'>{{ $loop->index+1 }}</td>

                                    <td class='col-item-name'>
                                        {{ $item->item_name }}
                                    </td>
                                    <td class='col-item-small align-center'>
                                        {{ $units->find($item->unit_id)->name }}
                                    </td>
                                    <td class='col-item-small align-center'>
                                        {{ $item->cpm }}
                                    </td>	
                                    <td class='col-item-small align-center'>
                                        {{ $item->package_qty . ' ' . $units->find($item->package_unit_id)->name }}
                                    </td>
                                    <td class='col-item-small align-center'>
                                        {{ $item->price+0 . ' ' . $currency }}
                                    </td>

                                    <td class='col-item-note'>
                                        {{ $item->note }}
                                    </td>		
                                </tr>
                         @endforeach
                        </tbody>
                    </table>
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
											<img src='data:image/jpeg;base64,{{base64_encode(@file_get_contents(url("https://mazmustaws.s3.us-east-2.amazonaws.com/images/$vendor->logo")))}}'>
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
