@extends('site.layouts.default')

@if(isset($account->id)&& $mode=='edit')

@section('breadcrumbs', Breadcrumbs::render('EditAccount'))

@else

@section('breadcrumbs', Breadcrumbs::render('CreateAccount'))

@endif

{{-- Content --}}
@section('content')

	<style type="text/css">
		/* hide the extra submit button generated by jsonform */
		#additionalCloudProviderFields [type="submit"]{display:none;}
	</style>

	<div class="page-header">
		<div class="row">
			<div class="col-md-9">
				<h5>@if(isset($account->id)&& $mode=='edit'){{'Edit'.' '.'Account:'}}@else{{'Create'.' '.'Account:'}}@endif</h5>
			</div>
		</div>
	</div>

	{{-- Create/Edit cloud account Form --}}
	<form id="cloudProviderCredntialsForm" class="form-horizontal" method="post" action="@if (isset($account->id)){{ URL::to('account/' . $account->id . '/edit') }}@endif" autocomplete="on">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		
		<!-- cloudProvider -->
		<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
			<label class="col-md-2 control-label" for="email">Cloud Provider <font color="red">*</font></label>
			<div class="col-md-6">
			
			<select class="form-control" name="cloudProvider" id="cloudProvider" required >
			@foreach ($providers as $key => $value)
						<option value="{{$key}}" {{{ Input::old('profileType', isset($account->profileType) && ($account->profileType == 'Security Profile') ? 'selected="selected"' : '') }}}>{{{ $key }}}</option>
					@endforeach
			</select>   
			</div>
		</div>
		<!-- ./ cloudProvider -->
		
		<!-- name -->
		<div class="form-group {{{ $errors->has('username') ? 'error' : '' }}}">
			<label class="col-md-2 control-label" for="name">Name <font color="red">*</font></label>
			<div class="col-md-6">
				<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($account->name) ? $account->name : null) }}}" required />
			</div>
		</div>

		<!-- ./ username -->
		<div id="additionalCloudProviderFields">
			
		</div>				

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<a id="acc_back_btn" href="{{ URL::to('account') }}" class="btn btn-default">Back</a>
				<button id="acc_save_btn"  type="submit" class="btn btn-primary">Save</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop

@section('scripts')
<script src="{{asset('bower_components/jsonform/deps/underscore.js')}}"></script>
<script src="{{asset('bower_components/jsonform/lib/jsonform.js')}}"></script>
<script type="text/javascript">
	(function($){
		'use strict';
		var PROVIDERS = {{ json_encode($providers) }};
		var SAVED_CREDENTIALS = {{ !empty($account -> credentials) ? $account -> credentials : 'null' }};
		$(function(){
			var $additionalCloudProviderFields = $('#additionalCloudProviderFields');
			var $cloudProvider = $('#cloudProvider');
			$cloudProvider.on('change', function(){
				var schema = PROVIDERS[$cloudProvider.val()] || {}, values = {};
				for(var credentialKey in SAVED_CREDENTIALS) {
					if(!SAVED_CREDENTIALS.hasOwnProperty(credentialKey) ){
						continue;
					}
					values['credentials['+credentialKey+']'] = SAVED_CREDENTIALS[credentialKey];
				}
				$additionalCloudProviderFields.empty().jsonForm({
			        schema: schema,
			        params: {
			        	fieldHtmlClass: 'form-control'
			        },
			        value: values
		      	});
		      	// Patch in bs3 classes
		      	$additionalCloudProviderFields
		      		.find('.control-group')
		      		.removeClass('control-group')
		      		.addClass('form-group');
		      	$additionalCloudProviderFields
		      		.find('.control-label')
		      		.addClass('col-md-2');
		      	$additionalCloudProviderFields
		      		.find('.controls')
		      		.removeClass('controls')
		      		.addClass('col-md-6');
			}).trigger('change');
			var $cloudProviderCredntialsForm = $('#cloudProviderCredntialsForm');
			$cloudProviderCredntialsForm.on('submit', function(e){

			});
		});
	})(jQuery);
</script>
@stop
