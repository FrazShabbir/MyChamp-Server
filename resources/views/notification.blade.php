@extends('main.main')
@section('main-section')
     <div class="row ">
      
        <div class="col-12">
        <table id="example" class="table table-responsive-sm table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Receiver Name</th>
                    <th>Title</th>
                    <th>Discription</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              @foreach($notification as $row)
                <tr>
                    <td>{{$row->id}}</td>   
                    <td>{{$row->receiver_name}}</td>   
                    <td>{{$row->title}}</td>
                    <td>{{$row->body}}</td>
                    <td>{{$row->created_at}}</td>
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
                              <h6>Are you sure you want to delete notification?</h6>
                              <p style="font-size: 12px;">This action cannot be undone, proceed?</p>
                               <form method="post" action="{{url('delete_notification')}}">
                                @csrf
                                <input type="hidden" id="input" name="id">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                <button type="submit"  class="btn btn-danger btn-sm ">Change</button>

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
        </script>

    </div>
@endsection(main-section)
    