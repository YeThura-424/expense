@extends('layout')
@section('content')

<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa fa-edit"></i>Edit Category</h1>
		</div>
		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><a href="/" title="Home"><i class="fa fa-home fa-lg"></i></a></li>
			<li class="breadcrumb-item">Setting</li>
			<li class="breadcrumb-item"><a href="/category" title="Category">Category</a></li>
			<li class="breadcrumb-item">Edit Category</li>
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
				<h3 class="tile-title text-center">Edit Category Name</h3>
				<div class="tile-body">
					<form class="form-horizontal" method="POST" action="{{route('category.update',$category->id)}}" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row">
							<label class="control-label col-md-3">Category Name</label>
							<div class="col-md-8">
								<input class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Enter Category name" value="{{$category->name}}" id="name" name="name">
								@error('name')
								<span class="invalid-feedback" role="alert">
									<strong>{{$message}}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-3 col-md-offset-3">
								<a class="btn btn-primary" href="/category"><i class="fa fa-fw fa-lg fa-check-circle"></i>Cancel</a>
							</div>
							<div class="col-md-3 col-md-offset-3">
								<button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
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
