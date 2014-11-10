@extends('site.layouts.default')

{{-- Content --}}
@section('content')

<div class="page-header">
	<div class="row">
		<div class="col-md-9">
			<h5> {{{ Lang::get('account/account.securityGroups') }}}</h5>
		</div>
	</div>
</div>

<div id="ec2Products">
</div>

<?php
print_r(ec2Products);
?>
@stop


{{-- Scripts --}}
@section('scripts')
    <script src="{{asset('assets/js/xervmon/utils.js')}}"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		console.log('<?php json_encode($ec2Products) ?>')
		//$('#securityGroups').append(convertJsonToTableSecurityGroups(response));
		
	});
	</script>
@stop