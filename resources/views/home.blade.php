@extends('layout')
@section('content')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
      @if(session('errorMsg') != NULL)
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>ERROR!</strong> {{session('errorMsg')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="/" title="Home"><i class="fa fa-home fa-lg"></i></a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <a href="/form">
        <div class="widget-small primary coloured-icon"><i class="text-danger fa-solid fa-clipboard-list fa-3x"></i>
          <div class="info">
            <h4>Uselist Total</h4>
            <p class="text-danger"><b>{{$form}} MMK</b></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-lg-3">
      <a href="/income">
        <div class="widget-small info coloured-icon"><i class="text-success fa-solid fa-hand-holding-dollar fa-3x"></i>
          <div class="info">
            <h4>Income Total</h4>
            <p class="text-success"><b>{{$income}} MMK</b></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-lg-3">
      <a href="/lendtotal">
        <div class="widget-small warning coloured-icon"><i class="text-primary fa-solid fa-money-bill-transfer fa-3x"></i>
          <div class="info">
            <h4>Lend Remain</h4>
            <p class="text-primary"><b>{{$lendtotal}} MMK</b></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-lg-3">
      <a href="/borrowtotal">
        <div class="widget-small danger coloured-icon"><i class="text-warning fa-solid fa-money-bill-transfer fa-3x"></i>
          <div class="info">
            <h4>Borrow Remain</h4>
            <p class="text-warning"><b>{{$borrowtotal}} MMK</b></p>
          </div>
        </div>
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Monthly Income</h3>
        <table class="table">
          <thead>
            <tr>
              <th>No.</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            @php $i = 1; @endphp
            @foreach($incomes as $row)
            <tr>
              <td>{{$i++}}</td>
              <td>{{$row->date}}</td>
              <td>{{$row->amount}} MMK</td>
              <td>{{$row->description}}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td class="text-center" colspan="2">Monthly Total Income</td>
              <td class="text-center text-success" colspan="2">{{$intotal}} MMK</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Today Uselists Detail</h3>
        <table class="table">
          <thead>
            <tr>
              <th>No.</th>
              <th>Category</th>
              <th>Amount</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            @php $i = 1;@endphp
            @foreach($total as $row)
            <tr>
              <td>{{$i++}}</td>
              <td>{{$row->category}}</td>
              <td>{{$row->amount}} MMK</td>
              <td>{{$row->description}}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td class="text-center" colspan="3">Monthly Total Usage</td>
              <td class="text-center text-warning" colspan="1">{{$mtotal}} MMK</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</main>
@endsection3