@switch($page_name)
	@case('dashboard-main')
		<link rel="stylesheet" href="{{ asset('vendors/dataTable/dataTables.min.css') }}" type="text/css">
	@break
	
	@default
		{{-- <script>console.log('No custom Style available.')</script> --}}
@endswitch
<!--Local Style-->