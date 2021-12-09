<x-app-layout>
	<x-slot name="header">
		<div class="max-w-6xl mx-auto px-2 sm:px-9 lg:px-12">
			<div class="flex justify-between h-16">
       			
					<div class="flex-shrink-0 flex items-center">
						<h2 class="font-semibold text-xl text-gray-800 leading-tight">
            				{{ __('global.qoutes_list') }}
        				</h2>
					</div>

					<div class='btn-action flex items-center'>
						<a href="{{ url('qoutes/create') }}">
							<img src='/storage/images/icon_add.png' class='icon-action-bg'>
							<label>{{__('global.add')}}</label>
						</a>
					</div>	

			</div>
		</div>
    </x-slot>
		<div class="toast">
                    <div class="toast-header">
						<strong class="mr-auto text-primary">{{ __('global.notification') }} </strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body">
                    	{{__('global.qoute_link_copied')}}
                    </div>
        </div>
		<div>
		<table cellpadding=5 cellspacing=0 border=1 class="table-responsive table-striped tbl-qoute-items cust-table">
			<thead class="thead-dark">
				<tr>
					<th scope="col" class='align-center'>{{ __('global.serial')}}</th>
					<th scope="col">{{ __('global.name') }}</th>
					<th scope="col" class='align-center'>{{ __('global.date') }}</th>
					<th scope="col" class='align-center'></th>
				</tr>
			</thead>
		@foreach ($qoutes as $qoute)
				<tr>
						<th scope="row" class='align-center'>{{ $qoute->id }}</th>
						<td><a href=''>{{ $qoute->name }}</a></td>
						<td class='align-center'>{{ $qoute->created_at->format('d.m.Y') }}</td>
						<td class='align-center'>
						
                           
								<a onclick="copyToClipBoard('{{url("/qoute/" . $qoute->id )}}')" class='icon-action-sm'>
										<i class="fa fa-share-alt"></i>
								</a>
								<a href="{{ route('qoutes.edit', $qoute->id) }}" class='icon-action-sm'>
										<i class="fa fa-edit"></i>
								</a>
								<form action="{{ route('qoutes.destroy', $qoute->id) }}" method="POST" 
									class='icon-action-sm'
									style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button  class="lst-del-btn icon-action-sm">
    											<i class="fa fa-trash" ></i> 
										</button>
                                </form>
						</td>
				</tr>
		@endforeach
		</table>
	</div>
</x-app-layout>