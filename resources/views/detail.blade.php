@extends('layout')
@section('content')

<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa-solid fa-table-list"></i>My Use Lists Detail</h1>
		</div>
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><a href="/" title="Home"><i class="fa fa-home fa-lg"></i></a></li>
			<li class="breadcrumb-item">Tables</li>
			<li class="breadcrumb-item"><a href="/form" class="Uselists">My Use Lists</a></li>
			<li class="breadcrumb-item">My Use List Detail</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<div class="tile-body">
					<a href="/form" class="btn btn-info"title="Back"><i class="fa-solid fa-arrow-left"></i></a><br><br>
					<div class="table-responsive">
						<table class="table table-hover table-bordered" id="sampleTable">
							<thead>
								<tr>
									<th colspan="2" class="text-center text-warning">Date</th>
									<th colspan="3" class="text-center text-warning">{{$total->date}}</th>
								</tr>
								<tr>
									<th>No.</th>
									<th>Category</th>
									<th>Amount</th>
									<th>Description</th>
								</tr>
							</thead>
							<tbody>

								@php $i = 1; @endphp
								@foreach($form as $row)
								<tr>
									<td colspan="1">{{$i++}}</td>
									<td title="{{$row->category}}" colspan="1">{{$row->category}}</td>
									<td title="{{$row->amount}} MMK" colspan="1">{{$row->amount}} MMK</td>
									<td title="{{$row->description}}" colspan="2">{{$row->description}}</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th class="text-center text-warning" colspan="2">Total</th>
									<th class="text-center text-warning" colspan="3">{{$total->total}} MMK</th>
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
