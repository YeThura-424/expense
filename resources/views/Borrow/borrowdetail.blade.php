@extends('layout')
@section('content')

<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa-solid fa-table-list"></i>Borrow Detail</h1>
		</div>
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><a href="/" title="Home"><i class="fa fa-home fa-lg"></i></a></li>
			<li class="breadcrumb-item">Tables</li>
			<li class="breadcrumb-item"><a href="/borrowtotal" title="Borrowlists">Borrow lists</a></li>
			<li class="breadcrumb-item">Borrow Detail</li>
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
					<a href="/borrowtotal" class="btn btn-info" title="Back"><i class="fa-solid fa-arrow-left"></i></a><br><br>
					<div class="table-responsive">
						<table class="table table-hover table-bordered" id="sampleTable">
							<thead>
								<tr>
									<th>No.</th>
									<th>Date</th>
									<th>From</th>
									<th>Amount</th>
									<th>Status</th>
									<th>Description</th>
									<th>Done Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

								@php $i = 1; @endphp
								@foreach($borrow as $row)
								<tr>
									<td>{{$i++}}</td>
									<td title="{{$row->date}}">{{$row->date}}</td>
									<td title="{{$row->name}}">{{$row->name}}</td>
									<td title="{{$row->amount}} MMK">{{$row->amount}} MMK</td>
									<td title="{{$row->status}}">{{$row->status}}</td>
									<td title="{{$row->description}}">{{$row->description}}</td>
									<td title="{{$row->donedate}}">{{$row->donedate}}</td>
									@if($row->status == "Done")
									<td></td>
									@else
									<td>
										<form action="{{ route('borrow.update',$row->id) }}" method="POST" enctype="multipart/form-data">
										@csrf
										@method('PUT')
										<input type="hidden" name="status" value="Done">
										    <button class="btn btn-info" title="Done" type="submit">Done</button>
                                        </form>
									</td>
									@endif
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th class="text-center text-success" colspan="2">Total</th>
									<th class="text-center text-success" colspan="2">{{$borrowtotal->total}} MMK</th>
									<th class="text-center text-danger" colspan="2">Remaing</th>
									<th class="text-center text-danger" colspan="2">{{$borrowtotal->donetotal}} MMK</th>
								</tr>	
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection
