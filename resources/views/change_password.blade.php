@extends('main.main')
@section('main-section')
  <div class="container-fluid " >
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-7 col-sm-8 col-12 text-white rounded shadow" style="background: #4675A9">
          <div class="row">
            <div class="col-12 pl-sm-5 pr-sm-5 pt-3 pb-4 pl-4 pr-4" >
              @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
              @endif
              <h1 class="text-center fs-4 p-3">Change Password</h1>
             
                <form method="Post" accept="{{url('/profile')}}">
                    @csrf 

                    <label  class="form-label" >Old Password</label>
                    <input type="password" name="old_password"  class="form-control" required="">

                    <label  class="form-label mt-3">New Password</label>  
                    <input type="password" name="new_password"   class="form-control" required="" >
                  
                    <button class="btn mt-3 btn-light" type="submite">Change</button>
                </form>
            
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection(main-section)
    