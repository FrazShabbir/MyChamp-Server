@extends('main.main')
@section('main-section')
  <div class="container-fluid " >
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-7 col-sm-8 col-12 text-white rounded shadow" style="background: #4675A9">
          <div class="row">
           
            <div class="col-12 pl-sm-5 pr-sm-5 pt-3 pb-4 pl-4 pr-4" >
              <h1 class="text-center fs-1">Edit Host</h1>
                <form method="Post" accept="{{url('/edite_host', $host->id)}}" enctype="multipart/form-data">
                    @csrf 

                    <label  class="form-label" >Host Name</label>
                    <input type="text" name="name" value="{{$host->name}}"  class="form-control" required="">

                    <label  class="form-label mt-3" >Email</label>  
                    <input type="email" name="email" value="{{$host->email}}"  class="form-control" required="" >

                    <label  class="form-label mt-3" >Password</label>  
                    <input type="password" name="password" value="{{$host->password}}"  class="form-control" required="" >

                    <label  class="form-label mt-3">Phone</label>  
                    <input type="text" name="phone" value="{{$host->phone}}"  class="form-control" required="" >
                    <div>
                    <label  class="form-label mt-3">
                      image<img src="{{asset('uploads/images/'.$host->image)}}" width="90" height="90">
                    </label>  
                    <input type="file" name="image"  class="form-control" >
                    
                    </div>
                    <label  class="form-label mt-3">level</label>  
                    <!-- <input type="text" name="level" value="{{$host->level}}"  class="form-control" required="" > -->
                    <select  class="form-control" name="level">
                      <!-- <option selected="">{{$host->level}}</option> -->
                      <option @if ($host->level == "Beginner") selected @endif>Beginner</option>
                      <option @if ($host->level == "1") selected @endif>1</option>
                      <option @if ($host->level == "1.5") selected @endif>1.5</option>
                      <option @if ($host->level == "2") selected @endif>2</option>
                      <option @if ($host->level == "2.5") selected @endif>2.5</option>
                      <option @if ($host->level == "3") selected @endif>3</option>
                      <option @if ($host->level == "3.5") selected @endif>3.5</option>
                      <option @if ($host->level == "4") selected @endif>4</option>
                      <option @if ($host->level == "4.5") selected @endif>4.5</option>
                      <option @if ($host->level == "5") selected @endif>5</option>
                    </select>
                   
                    <!-- <a href="{{url('signup')}}" class="mt-5" >No account Sign Up</a> -->
                    <button class="btn mt-3 btn-light" type="submite">Update</button>
                </form>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection(main-section)
    