@extends('main.main')
@section('main-section')
   	<div class="row">
    	<div class="col-12">
        <a href="{{url('/add_host')}}">
        </a>
        <table id="example" class="table table-responsive-lg table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Userame</th>
                    <!-- <th>Last Name</th> -->
                    <th>Email</th>
                    <th>Phone</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ali Usama</td>
                    <!-- <td></td> -->
                    <td>Aliusam@gmail</td>
                    <td>0302745528</td>
 
                   
                    <td> 
                      <a href="" data-id="<?= '2' ?>" data-toggle="modal" data-target="#exampleModal1" class="btn btn-success btn-sm toggle_btn_a1">
                          Accepted  
                      </a>
                    </td>  
                </tr>

                <tr>
                    <td>1</td>
                    <td>Ali Usama</td>
                    <!-- <td></td> -->
                    <td>Aliusam@gmail</td>
                    <td>0302745528</td>
 
                   
                    <td> 
                      <a href="" data-id="<?= '2' ?>" data-toggle="modal" data-target="#exampleModal1" class="btn btn-danger btn-sm toggle_btn_a1">
                          Declined 
                      </a>
                    </td>  
                </tr>
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                         

                          <div class="modal-body">
                              <h5  style="">Are you sure?</h5>
                              <p style="font-size: 12px;">This action cannot be undone, proceed?</p>
                               <form method="post" action="delete_agent">
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
                               <form method="post" action="user_status">
                                @csrf
                                <input type="hidden" id="input1" name="user_id">
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
    