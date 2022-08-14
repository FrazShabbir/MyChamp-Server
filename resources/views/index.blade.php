@extends('main.main')
@section('main-section')
<style type="text/css">
  body{
background:#eee;    
}

.card-box {
    position: relative;
    color: #fff;
    padding: 20px 10px 40px;
    margin: 20px 0px;
}
.card-box:hover {
    text-decoration: none;
    color: #f1f1f1;
}
.card-box:hover .icon i {
    font-size: 100px;
    transition: 1s;
    -webkit-transition: 1s;
}
.card-box .inner {
    padding: 5px 10px 0 10px;
}
.card-box h3 {
    font-size: 27px;
    font-weight: bold;
    margin: 0 0 8px 0;
    white-space: nowrap;
    padding: 0;
    text-align: left;
}
.card-box p {
    font-size: 15px;
}
.card-box .icon {
    position: absolute;
    top: auto;
    bottom: 5px;
    right: 5px;
    z-index: 0;
    font-size: 72px;
    color: rgba(0, 0, 0, 0.15);
}
.card-box .card-box-footer {
    position: absolute;
    left: 0px;
    bottom: 0px;
    text-align: center;
    padding: 3px 0;
    color: rgba(255, 255, 255, 0.8);
    background: rgba(0, 0, 0, 0.1);
    width: 100%;
    text-decoration: none;
}
.card-box:hover .card-box-footer {
    background: rgba(0, 0, 0, 0.3);
}
.bg-blue {
    background-color: #4675A9 !important;
}
.bg-green {
    background-color: #00a65a !important;
}
.bg-orange {
    background-color: #a96519 !important;
}
.bg-red {
    background-color: #39534f !important;
}

</style>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
  <div class="row">
    <div class="col-lg-12">
        <h1>Dashboard <small>Overview</small></h1>
      
    </div>
</div>
    <div class="row">
        <div class="col-lg-6 col-sm-6">
            <div class="card-box bg-blue">
                <div class="inner">
                    <h3>{{$host_count}}</h3>
                    <p class="text-white"> Total Hosts </p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{url('/hosts')}}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
          <div class="col-lg-6 col-sm-6">
            <div class="card-box bg-red">
                <div class="inner">
                    <h3>{{$player_count}}</h3>
                    <p class="text-white"> Total Players </p>
                </div>
                <div class="icon">
                    <i class="fa fa-users" aria-hidden="true"></i>
                </div>
                <a href="{{url('/players')}}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="card-box bg-green">
                <div class="inner">
                    <h3> {{$accepted_count}} </h3>
                    <p class="text-white"> Accepted  Tournaments  </p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-person-circle-check" aria-hidden="true"></i>
                </div>
                <a href="{{url('/tournament')}}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="card-box bg-orange">
                <div class="inner">
                    <h3> {{$declined_count}} </h3>
                    <p class="text-white"> Declined  Tournaments </p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-plane-slash" aria-hidden="true"></i>
                </div>
                <a href="{{url('/tournament')}}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
      
    </div>
   
</div>
@endsection(main-section)
