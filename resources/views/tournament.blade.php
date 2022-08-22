@extends('main.main')
@section('main-section')
    <div class="row">
        <div class="col-12">
            <a href="{{ url('/add_tournament') }}">
                <button class="btn text-white mb-4" style="background: #4675A9">Add Tournament</button>
            </a>
        
                <table id="example" class="table table-responsive-lg table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>End date</th>
                            <th>Start Time</th>
                            <th>Venue</th>
                            <th>Host Name</th>
                        
                            {{-- <th>status</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tournament as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->description }}</td>
                                <td>{{ $row->date }}</td>
                                <td>{{ $row->start_time }}</td>
                                <td>{{ $row->end_time }}</td>
                                <td>{{ $row->venue }}</td>
                                <td>{{ $row->host_name }}</td>
                       
                                {{-- @if ($row->status == 1)
                                    <td>
                                        <!-- <button class="btn btn-sm btn-success">Accepted</button> -->
                                        <a href="" data-id="<?= $row['id'] ?>" data-toggle="modal"
                                            data-target="#exampleModal"
                                            class="btn btn-success   
                             btn-sm  toggle_btn_a">
                                            Accepted
                                        </a>
                                    </td>
                                @else
                                    <td>
                                        <a href="" data-id="<?= $row['id'] ?>" data-toggle="modal"
                                            data-target="#exampleModal"
                                            class="btn btn-danger   
                             btn-sm  toggle_btn_a">
                                            Declined
                                        </a>
                                    </td>
                                @endif --}}
                                <td>
                                    {{-- <a href="{{ url('/tournament_players', $row->id) }}" class="btn text-white btn-sm"
                                        style="background: #4675A9">
                                        view
                                    </a> --}}
                                    <a href="{{url('/tournament', $row->id) }}" class="btn text-white btn-sm"
                                      style="background: #4675A9">
                                      view Tournament
                                  </a>
                                </td>

                            </tr>
                        @endforeach
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">


                                    <div class="modal-body">
                                        <h6>Are you sure you want to change this status?</h6>
                                        <p style="font-size: 12px;">This action cannot be undone, proceed?</p>
                                        <form method="post" action="tournament_accepted">
                                            @csrf
                                            <input type="hidden" id="input" name="id">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger btn-sm ">Change</button>

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
