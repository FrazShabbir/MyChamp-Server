@extends('main.main')
@section('main-section')
  <div class="container-fluid " >
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-7 col-sm-8 col-12 text-white rounded shadow" style="background: #4675A9">
          <div class="row">
           
            <div class="col-12 pl-sm-5 pr-sm-5 pt-3 pb-4 pl-4 pr-4" >
              <h1 class="text-center fs-3 ">Update Tournament</h1>
                <form method="Post" action="{{route('tournament.update',$tournament->id)}}"  enctype="multipart/form-data">
                    @csrf 
{{@method_field('PUT')}}
                    <label  class="form-label" >Tournament Name</label>
                    <input type="text" name="name"  class="form-control" required="" value="{{$tournament->name}}">

                    <label  class="form-label mt-3" >Description</label>
                    <input type="text" name="description"  class="form-control" required="" value="{{$tournament->description}}">


                    <label  class="form-label mt-3" >Start Date</label>  
                    <input type="date" name="date"  class="form-control" required="" value="{{$tournament->date}}" >

                    <label  class="form-label mt-3" >End Date</label>  
                    <input type="date" name="end_date"  class="form-control" required="" value="{{$tournament->end_date}}" >


                    <label  class="form-label mt-3" >Start Time</label>  
                    <input type="time" name="start_time"  class="form-control" required="" value="{{$tournament->start_time}}" >
                    
                    <label  class="form-label mt-3" >End Time</label>  
                    <input type="time" name="end_time"  class="form-control" required="" value="{{$tournament->end_time}}" >


                   


                    <label  class="form-label mt-3">Host Name</label>  
                    <select class="form-control" name="host_id">
                      <option disabled="" selected="">Select Host</option>
                      @foreach($host as $row)
                        <option value="{{$row->id}}" {{$tournament->host_id==$row->id?'selected':''}}>{{$row->name}}</option>
                      @endforeach
                    </select>

                    
                    <label  class="form-label mt-3">Venue</label>  
                    <input type="text" name="venue"  class="form-control" required="" value="{{$tournament->venue}}" >

                    <label  class="form-label mt-3">Country</label>  
                    <input type="text" name="country"  class="form-control" required="" value="{{$tournament->country}}" >

                    <label  class="form-label mt-3">State</label>  
                    <input type="text" name="state"  class="form-control" required="" value="{{$tournament->state}}" >

                    <label  class="form-label mt-3">Repeat</label>  
                    <input type="text" name="repeat"  class="form-control" required="" value="{{$tournament->repeat}}" >
                    <label  class="form-label mt-3">Category</label>  
                    <input type="text" name="category"  class="form-control" required="" value="{{$tournament->category}}" >

                    <label  class="form-label mt-3">Format</label>  
                    <input type="text" name="format"  class="form-control" required="" value="{{$tournament->format}}" >

                    <label  class="form-label mt-3">Status</label>  
                    <select class="form-control" name="status">
                      <option disabled="" selected="">Select Status</option>
                   
                      <option value="1" {{$tournament->status==1?'selected':''}}>Active</option>
                      <option value="0" {{$tournament->status==0?'selected':''}}>Declined</option>
                    
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
    