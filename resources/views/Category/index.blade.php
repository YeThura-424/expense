@extends('layout')
@section('content')
<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa fa-cog"></i>Category</h1>
		</div>
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><a href="/" title="Home"><i class="fa fa-home fa-lg"></i></a></li>
			<li class="breadcrumb-item">Setting</li>
			<li class="breadcrumb-item">Category</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				@if(session('successMsg') != NULL)
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>SUCCESS!</strong> {{session('successMsg')}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if(session('errorMsg') != NULL)
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>ERROR!</strong> {{session('errorMsg')}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				<div class="tile-body">
					<a href="category/create" class="btn btn-info" title="Add New"><i class="fa-solid fa-plus"></i></a><br><br>
					<div class="table-responsive">
						<table class="table table-hover table-bordered" id="sampleTable">
							<thead>
								<tr>
									<th>No.</th>
									<th>Category Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

								@php $i = 1; @endphp
								@foreach($category as $row)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$row->name}}</td>
									<td>
										<a href=" {{route('category.edit',$row->id)}} " class="btn btn-info" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>

                                        </a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection
