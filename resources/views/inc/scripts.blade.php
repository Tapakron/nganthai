@switch($page_name)
	@case('dashboard-main')
		<script src="{{ asset('vendors/dataTable/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('vendors/dataTable/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('vendors/dataTable/dataTables.responsive.min.js') }}"></script>
	@break
	
	@default
		{{-- <script>console.log('No custom Script available.')</script> --}}
@endswitch
<!--Local Script-->