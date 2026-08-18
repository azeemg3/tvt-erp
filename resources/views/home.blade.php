@extends('layouts.app')
@section('content')
	<div class="content-wrapper">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2 align-items-center">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">{{ __('main.dashboard') }}</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<section class="content module-hub">
			<div class="container-fluid">
				<p class="text-muted mb-3">Welcome, {{ Auth::user()->name }}. Open a module you are authorized to use.</p>
				<x-module-grid
					:tiles="$moduleTiles"
					variant="hub"
					empty-title="No modules assigned"
					empty-message="Your account does not have access to any module yet. Please contact your administrator."
				/>
			</div>
		</section>
	</div>
@endsection
