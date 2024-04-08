@extends('layout')
@section('content')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Upload Excel</h5>
				<a href="{{asset('image/Borrow upload Format.xlsx')}}" download>Sample Form</a>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="{{route('borrowimport')}}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="control-label col-md-3">File</label>
						<div class="col-md-8">
							<input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file" required>
							@error('file')
							<span class="invalid-feedback" role="alert">
								<strong>{{$message}}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="row">
						<div class="col-md-5"></div>
						<div class="col-md-5 col-md-offset-3">
							<button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Apply</button>
						</div>
						<div class="col-md-2"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa-solid fa-table-list"></i>Borrow Lists</h1>
		</div>
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><a href="/" title="Home"><i class="fa fa-home fa-lg"></i></a></li>
			<li class="breadcrumb-item">Tables</li>
			<li class="breadcrumb-item">Borrow lists</li>
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
				<div class="tile-body">
					<div class="row">
						<div class="col-md-1">
							<a href="borrow/create" class="btn btn-info" title="Add New"><i class="fa-solid fa-plus"></i></a>
						</div>
						<div class="col-md-1">
							<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" title="File Upload"><i class="fa-solid fa-file-arrow-up"></i></button>
						</div>
						<div class="col-md-10"></div>
					</div><br><br>
					<div class="table-responsive">
						<table class="table table-hover table-bordered" id="sampleTable">
							<thead>
								<tr>
									<th>No.</th>
									<th>From</th>
									<th>Remaing</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

								@php $i = 1; @endphp
								@foreach($borrowtotal as $row)
								@if($row->donetotal == 0)
								@else
								<tr>
									<td>{{$i++}}</td>
									<td title="{{$row->name}}">{{$row->name}}</td>
									<td title="{{$row->donetotal}} MMK">{{$row->donetotal}} MMK</td>
									<td>
										<a href=" {{route('borrowtotal.show',$row->id)}} " class="btn btn-info" title="Detail">
											<i class="fa-solid fa-eye"></i>
                                        </a>
									</td>
								</tr>
								@endif
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
