@extends('main.main')
@section('main-section')
    <div class="row">
        <div class="col-12">
            <a href="{{ route('tournament.edit',$tournament->id)}}">
                <button class="btn text-white mb-4" style="background: #4675A9">Edit Tournament</button>
            </a>
            <a href="{{ url('/tournament_players', $tournament->id)}}">
                <button class="btn text-white mb-4" style="background: #4675A9">Tournament Players</button>
            </a>
            <table id="example" class="table table-responsive-lg table-bordered">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>

                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <th>Id</th>
                        <td>{{ $tournament->id ?? '- -' }}</td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td>{{ $tournament->name ?? '- -' }}</td>

                    </tr>
                    <tr>

                        <th>Description</th>
                        <td>{{ $tournament->description ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ $tournament->date ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>End date</th>
                        <td>{{ $tournament->end_time ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>Start Time</th>
                        <td>{{ $tournament->start_time ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>End Time</th>
                        <td>{{ $tournament->end_time ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>Venue</th>
                        <td>{{ $tournament->venue ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>Host Name</th>
                        <td>{{ $tournament->host_name ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td>{{ $tournament->country ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>{{ $tournament->state ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>Repeat</th>
                        <td>{{ $tournament->repeat ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $tournament->category ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>Format</th>
                        <td>{{ $tournament->format ?? '- -' }}</td>
                    </tr>
                    <tr>
                        <th>status</th>
                        @if ($tournament->status == 1)
                            <td>Accepted</td>
                        @else
                            <td>Declined</td>
                        @endif
                    </tr>




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
