@extends('main.main')
@section('main-section')
  <div class="container-fluid " >
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-7 col-sm-8 col-12 text-white rounded shadow" style="background: #4675A9">
          <div class="row">
           
            <div class="col-12 pl-sm-5 pr-sm-5 pt-3 pb-4 pl-4 pr-4" >
              <h1 class="text-center fs-1">Add Player</h1>
                <form method="Post" accept="{{url('/add_player')}}"  enctype="multipart/form-data">
                    @csrf 

                    <label  class="form-label" >Player Name</label>
                    <input type="text" name="name"  class="form-control" required="">

                    <label  class="form-label mt-3" >Email</label>  
                    <input type="email" name="email"  class="form-control" required="" >

                    <label  class="form-label mt-3" >Password</label>  
                    <input type="password" name="password"  class="form-control" required="" >

                    <label  class="form-label mt-3">Phone</label>  
                    <input type="text" name="phone"  class="form-control" required="" >

                    <label  class="form-label mt-3">Image</label>  
                    <input type="file" name="image"  class="form-control">
                    <label  class="form-label mt-3">Level</label>  
                    <!-- <input type="text" name="level"  class="form-control" required="" > -->
                    <select  class="form-control" name="level">
                      <option>Beginner</option>
                      <option>1</option>
                      <option>1.5</option>
                      <option>2</option>
                      <option>2.5</option>
                      <option>3</option>
                      <option>3.5</option>
                      <option>4</option>
                      <option>4.5</option>
                      <option>5</option>
                    </select>
                   
                    <!-- <a href="{{url('signup')}}" class="mt-5" >No account Sign Up</a> -->
                    <button class="btn mt-3 btn-light" type="submite">Add</button>
                </form>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection(main-section)
    