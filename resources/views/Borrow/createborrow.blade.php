@extends('layout')
@section('content')

<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa-solid fa-edit"></i>Create Borrow list</h1>
		</div>
		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><a href="/" title="Home"><i class="fa fa-home fa-lg"></i></a></li>
			<li class="breadcrumb-item">Tables</li>
			<li class="breadcrumb-item"><a href="/borrowtotal" title="Borrowlists">Borrow lists</a></li>
			<li class="breadcrumb-item">Create Borrow List</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="tile">
				@if(session('successMsg') != NULL)
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>SUCCESS!</strong> {{session('successMsg')}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				<h3 class="tile-title text-center">Add New Borrow List</h3>
				<div class="tile-body">
					<form class="form-horizontal" method="POST" action="{{route('borrow.store')}}" enctype="multipart/form-data">
						@csrf
						<div class="form-group row">
							<label class="control-label col-md-3">Date</label>
							<div class="col-md-8">
								<input class="form-control @error('date') is-invalid @enderror" type="date" value="<?php echo date('Y-m-d');?>" id="date" name="date">
								@error('date')
								<span class="invalid-feedback" role="alert">
									<strong>{{$message}}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">From</label>
							<div class="col-md-8">
								<input class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Enter name" id="name" name="name">
								@error('name')
								<span class="invalid-feedback" role="alert">
									<strong>{{$message}}</strong>
								</span>
								@enderror
							</div>
						</div>


						<div class="form-group row">
							<label class="control-label col-md-3">Amount</label>
							<div class="col-md-8">
								<input class="form-control @error('amount') is-invalid @enderror" type="number" placeholder="Enter amount" id="amount" name="amount">
								@error('amount')
								<span class="invalid-feedback" role="alert">
									<strong>{{$message}}</strong>
								</span>
								@enderror
							</div>
						</div>

						<input type="hidden" name="status" value="Pending">

						<div class="form-group row">
							<label class="control-label col-md-3">Description</label>
							<div class="col-md-8">
								<textarea class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Enter your description" id="description" name="description"></textarea>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-3 col-md-offset-3">
								<a class="btn btn-primary" href="/borrowtotal"><i class="fa fa-fw fa-lg fa-check-circle"></i>Cancel</a>
							</div>
							<div class="col-md-3 col-md-offset-3">
								<button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>
							</div>
							<div class="col-md-3"></div>
						</div>

					</form>
				</div>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
</main>
@endsection
