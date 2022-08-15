@extends('main.main')
@section('main-section')
  <div class="container-fluid " >
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-7 col-sm-8 col-12 text-white rounded shadow" style="background: #4675A9">
          <div class="row">
           
            <div class="col-12 pl-sm-5 pr-sm-5 pt-3 pb-4 pl-4 pr-4" >
              <h1 class="text-center fs-3 ">Add Tournament</h1>
                <form method="Post" accept="{{url('/add_tournament')}}"  enctype="multipart/form-data">
                    @csrf 

                    <label  class="form-label" >Tournament Name</label>
                    <input type="text" name="name"  class="form-control" required="">

                    <label  class="form-label mt-3" >Description</label>
                    <input type="text" name="description"  class="form-control" required="">


                    <label  class="form-label mt-3" >Start Date</label>  
                    <input type="date" name="date"  class="form-control" required="" >

                    <label  class="form-label mt-3" >End Date</label>  
                    <input type="date" name="end_date"  class="form-control" required="" >


                    <label  class="form-label mt-3" >Start Time</label>  
                    <input type="time" name="start_time"  class="form-control" required="" >
                    
                    <label  class="form-label mt-3" >End Time</label>  
                    <input type="time" name="end_time"  class="form-control" required="" >


                   


                    <label  class="form-label mt-3">Host Name</label>  
                    <select class="form-control" name="host_id">
                      <option disabled="" selected="">Select Host</option>
                      @foreach($host as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                      @endforeach
                    </select>

                    
                    <label  class="form-label mt-3">Venue</label>  
                    <input type="text" name="venue"  class="form-control" required="" >

                    <label  class="form-label mt-3">Country</label>  
                    <input type="text" name="country"  class="form-control" required="" >

                    <label  class="form-label mt-3">State</label>  
                    <input type="text" name="state"  class="form-control" required="" >

                    <label  class="form-label mt-3">Repeat</label>  
                    <input type="text" name="repeat"  class="form-control" required="" >
                    <label  class="form-label mt-3">Category</label>  
                    <input type="text" name="category"  class="form-control" required="" >

                    <label  class="form-label mt-3">Format</label>  
                    <input type="text" name="format"  class="form-control" required="" >



                    <!-- <a href="{{url('signup')}}" class="mt-5" >No account Sign Up</a> -->
                    <button class="btn mt-3 btn-light" type="submite">Add</button>
                </form>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection(main-section)
    