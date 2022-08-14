@extends('main.main')
@section('main-section')
    <div class="row">
      <div class="col-12">
        <form method="post" action="{{url('/insert_tournament_players',$id)}}">  
          @csrf
          @if(!empty($player))
          <td>
            <button class="btn text-white mb-3" type="submit" style="background: #4675A9">Add</button>
          </td>
          @endif        
         <table id="example" class="table table-responsive-lg table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Id</th>
                    <th>Player Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Image</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($player as $row)
                <tr>
                   <td>
                      <input type="checkbox" name="id[]" value="{{$row['id']}}"></input>
                    </td>
                    <td>{{$row['id']}}</td>
                    <td>{{$row['name']}}</td>
                    <td>{{$row['email']}}</td>
                    <td>{{$row['phone']}}</td>
                    <td>
                      <img src="{{asset('uploads/images/'.$row['image'])}}" width="90" height="90">
                    </td>
                    <td>{{$row['level']}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        </form>
        <script type="text/javascript">
                $(document).ready(function() {
                  $('#example').dataTable();
                });
        </script>
    </div>
@endsection(main-section)