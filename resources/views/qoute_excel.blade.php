<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>{{ config('app.name', 'Wesalix') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/droid-arabic-kufi" type="text/css"/>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css" />
        <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
        <link href="https://unpkg.com/@coreui/coreui@2.1.16/dist/css/coreui.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
        
        
        
        
        @if(App::getLocale() == 'en')
            <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('css/custom_rtl.css') }}">
        @endif

    </head>
    <body class="font-sans antialiased">
        <div class="cust-screen">
            <table class='table'>
                    <tr>
                        <td class='layout-logo' colspan='5'><b><font color='blue' class='layout-logo'>{{$vendor['title_' . app()->getLocale() ]}}</font></b></td>
                    </tr>
                    <tr>
                        <td class='cust-page-title' colspan='5' align='center'><h2>{{ __('global.qoute') }}</h2></td>
                    </tr>
                    <tr>
                            <td>{{ __('global.qoute_name')}}</td>
                            <td>{{ $qoute->name }}</td>
                    </tr>
                    <tr>
                            <td>{{ __('global.currency')}}</td>
                            <td>{{$currency}}</td>
                    </tr>
                    <tr>
                            <td>{{ __('global.note')}}</td>
                            <td>{{$qoute->note}}</td>
                    </tr>
            </table>

            <div class='row'>
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
                             
                         @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </body>
</html>                    
            

