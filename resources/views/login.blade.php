
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Payment</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('/DataTables/datatables.min.css')}}" />
    <!-- <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" /> -->
    <!-- <script type="text/javascript" src="DataTables/datatables.min.js"></script>  -->
    <script type="text/javascript" src="{{URL::asset('/DataTables/datatables.min.js')}}"></script> 


    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}"> -->
    <!-- <script src="{{asset('js/app.js')}}"></script>  -->
    

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="{{URL::asset('/style.css')}}">



</head>
<body style="background: #f5f5f5">
	<div class="container-fluid " >
			<br>
			<br>
			<br>
			<br>
			<br>
			
		 	<div class="row justify-content-center">

		 		<div class="col-lg-4 col-md-6 col-sm-8 col-11  bg-white rounded shadow-lg">
		 			<div class="row">
		 				<div class="col-12 p-5">
		 					<center>
                    			<img src="{{asset('icon.png')}}" style="width: 100px;height: 100px;">
							</center>
		 					<!-- <h1 class="fw-bold text-center" style="font-size: 50px">Login</h1> -->
				 			<div class="mb-3">
				 				<form method="Post" accept="{{url('/adminlogin')}}">
				 				@csrf	
								<label  class="form-label" style="color: #4675A9">Email</label>
								<input type="email" name="email" style="color: darkgray" class="form-control" required="">

								<label  class="form-label mt-3" style="color: #4675A9">Password</label>	
								<input type="password" name="password" style="color: darkgray" class="form-control" required="" >
								<div class="text-end mt-3">
								<!-- <a href="{{url('signup')}}" class="mt-5" style="color: darkgray">No account Sign Up</a> -->
								<button class="btn text-white ms-3" style="background: #4675A9" type="submite" style="float: center">Login</button>
								
								</form>
								</div>
							</div>
		 				</div>
		 			</div>
		 		</div>
		 	</div>

			
	</div>


</body>
</html>