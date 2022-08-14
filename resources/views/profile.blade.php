@extends('main.main')
@section('main-section')
  <div class="container-fluid " >
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-7 col-sm-8 col-12 text-white rounded shadow" style="background: #4675A9">
          <div class="row">
            <div class="col-12 pl-sm-5 pr-sm-5 pt-3 pb-4 pl-4 pr-4" >
              <h1 class="text-center fs-3">Edit Profile</h1>
             
                <form method="Post" accept="{{url('/profile')}}">
                    @csrf 

                    <label  class="form-label" >Name</label>
                    <input type="text" name="username" value="{{$admin->username}}"  class="form-control" required="">

                    <label  class="form-label mt-3">Email</label>  
                    <input type="email" name="email" value="{{$admin->email}}"  class="form-control" required="" >
                  
                    <button class="btn mt-3 btn-light" type="submite">Update</button>
                </form>
            
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection(main-section)
    