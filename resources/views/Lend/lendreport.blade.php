@extends('layout')
@section('content')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Report Filter</h5>
			</div>
			<div class="modal-body">
				<p class="text-danger text-center">'From Date' must be less than 'To Date'!</p>
				<form class="form-horizontal" method="GET" action="{{route('lendreport')}}">
					@csrf
					<div class="form-group row">
						<label class="control-label col-md-3">From Date</label>
						<div class="col-md-8">
							<input class="form-control @error('fromdate') is-invalid @enderror" type="date" value="<?php echo $from;?>" id="fromdate" name="fromdate" required>
							@error('fromdate')
							<span class="invalid-feedback" role="alert">
								<strong>{{$message}}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3">To Date</label>
						<div class="col-md-8">
							<input class="form-control @error('todate') is-invalid @enderror" type="date" value="<?php echo $to;?>" id="todate" name="todate" required>
							@error('todate')
							<span class="invalid-feedback" role="alert">
								<strong>{{$message}}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3">Name</label>
						<div class="col-md-8">
							<select class="form-control" name="name" placeholder="Choose Name">
								@if($status == 'get')
								<option value="choose">None</option>
								@foreach($name as $name)
								<option value="{{$name->name}}" @if($con1 == $name->name) {{"selected"}} @endif>{{$name->name}}</option>
								@endforeach
								@else
								<option value="choose">None</option>
								@foreach($name as $name)
								<option value="{{$name->name}}">{{$name->name}}</option>
								@endforeach
								@endif
							</select>
							<div class="text-danger form-control-feedback">
								{{$errors->first('category') }}
							</div>
							<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
							<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
							<script type="text/javascript">
								$(document).ready(function () {
									$('select').selectize({
										sortField: 'text'
									});
								});
							</script>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3">Status</label>
						<div class="col-md-8">
							<select class="form-control" name="status">
								@if ($status == 'get')
									@if ($con2 == 'Pending')
									<option value="choose">None</option>
									<option value="Pending" selected>Pending</option>
									<option value="Done">Done</option>
									@elseif($con2 == 'Done')
									<option value="choose">None</option>
									<option value="Pending">Pending</option>
									<option value="Done" selected>Done</option>
									@else
									<option value="choose">None</option>
									<option value="Pending">Pending</option>
									<option value="Done">Done</option>
									@endif
								@else
								<option value="choose">None</option>
								<option value="Pending">Pending</option>
								<option value="Done">Done</option>
								@endif
							</select>
							<div class="text-danger form-control-feedback">
								{{$errors->first('status') }}
							</div>
						</div>
					</div>

					<input type="hidden" name="data" value="get">
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
			<h1><i class="fa fa-file-text"></i>Lend Detail Report</h1>
		</div>
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><a href="/" title="Home"><i class="fa fa-home fa-lg"></i></a></li>
			<li class="breadcrumb-item">Report</li>
			<li class="breadcrumb-item">Lend Detail Report</li>
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
					<div class="row">
						<div class="col-md-1">
							@if($status == "get")
							<form class="form-horizontal" method="GET" action="{{route('lendexport')}}">
								@csrf
								<input type="hidden" name="from" value="{{$from}}">
								<input type="hidden" name="to" value="{{$to}}">
								<input type="hidden" name="name" value="{{$con1}}">
								<input type="hidden" name="status" value="{{$con2}}">
								<button class="btn btn-success" type="submit" alt="Export to Excel" title="Export to Excel"><i class="fa-solid fa-file-excel" aria-hidden="true"></i></button>
							</form>
							@endif
						</div>
						<div class="col-md-1">
							@if($status == "get")
							<form class="form-horizontal" method="GET" action="{{route('lendpdfexport')}}">
								@csrf
								<input type="hidden" name="from" value="{{$from}}">
								<input type="hidden" name="to" value="{{$to}}">
								<input type="hidden" name="name" value="{{$con1}}">
								<input type="hidden" name="status" value="{{$con2}}">
								<button class="btn btn-danger" type="submit" alt="Export to PDF" title="Export to PDF"><i class="fa-solid fa-file-pdf" aria-hidden="true"></i></button>
							</form>
							@endif
						</div>
						<div class="col-md-9"></div>
						<div class="col-md-1">
							<button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Report Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
						</div>
					</div><br><br>
					@if($status == "get")
					<table class="table">
						<thead>
							<tr>
								<th colspan="7" class="text-center text-success">Lend Details From {{$from}} To {{$to}}</th>
							</tr>
							<tr>
								<th>No.</th>
								<th>Date</th>
								<th>To</th>
								<th>Amount</th>
								<th>Status</th>
								<th>Description</th>
								<th>Done Date</th>
							</tr>
						</thead>
						<tbody>
							@php $i = 1; @endphp
							@foreach($total as $row)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$row->date}}</td>
								<td>{{$row->name}}</td>
								<td>{{$row->amount}} MMK</td>
								<td>{{$row->status}}</td>
								<td>{{$row->description}}</td>
								<td>{{$row->donedate}}</td>
							</tr>

							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th class="text-warning" colspan="7">Displayed top 100 records only, To get all record please export to excel.</th>
							</tr>
						</tfoot>
					</table>
					@else
					<table class="table">
						<thead>
							<tr>
								<th colspan="2" class="text-center text-success">Please Select Filter Criteria....</th>
							</tr>
						</thead>
						<tbody>
							<tr>
							</tr>
						</tbody>
					</table>
					@endif
				</div>
			</div>
		</div>
	</div>
</main>
@endsection
