@extends('main.main')
@section('main-section')
   	<div class="row">
    	<div class="col-12">
        @if($id != '0')
        <a href="{{url('/add_tournament_players', $id)}}">
          <button class="btn text-white mb-4" style="background: #4675A9">Add Players</button>
        </a>
        @endif
         <table id="example" class="table table-responsive-lg table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Player Name</th>
                    <th>Tournament Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Image</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tournament_players as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>{{$row->name}}</td>
                @foreach($tournament as $row1)
                    @if($row->tournament_id == $row1->id)
                    <td>{{$row1->name}}</td>
                    @endif
                @endforeach
                    <td>{{$row->email}}</td>
                    <td>{{$row->phone}}</td>
                    <td>
                      <img src="{{asset('uploads/images/'.$row->image)}}" width="90" height="90">
                    </td>
                    <td>{{$row->level}}</td>
  
                  
                    <td>
                  
                      <a href="" data-id="<?= $row['id'] ?>" data-toggle="modal" data-target="#exampleModal" class="btn btn-danger btn-sm toggle_btn_a">
                               <i class="fa-solid fa-trash"></i>
                      </a>

                    </td>
                </tr>
                @endforeach

                 
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                         

                          <div class="modal-body">
                              <h6>Are you sure you want to delete this player?</h6>
                              <p style="font-size: 12px;">This action cannot be undone, proceed?</p>
                               <form method="post" action="{{url('delete_tournament_players')}}">
                                @csrf
                                <input type="hidden" id="input" name="id">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                <button type="submit"  class="btn btn-danger btn-sm ">function</button>

                              </form>
                          </div>
                           
                        </div>
                      </div>
                  </div>

                  <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-body">
                              <h5  style="">Are you sure?</h5>
                              <p style="font-size: 12px;">This action cannot be undone, proceed?</p>
                               <form method="post" action="aproved">
                                @csrf
                                <input type="hidden" id="input1" name="id">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                <button type="submit"  class="btn btn-danger btn-sm ">function</button>

                              </form>
                          </div>
                           
                        </div>
                      </div>
                  </div>

            </tbody>
        </table>
        <script type="text/javascript">
                $(document).ready(function() {
                  $('#example').dataTable();
                });

                $(".toggle_btn_a").on("click", function(e) {
                     var id = $(this).data("id");
                    $("#input").val(id);
               
                });


                 $(".toggle_btn_a1").on("click", function(e) {
                     var id = $(this).data("id");
                    $("#input1").val(id);
                    // alert(id);
                });
        </script>

                

  	</div>
@endsection(main-section)
    