
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>My Champ</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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
    <!-- <link rel="stylesheet" href="style.css"> -->

    <link rel="stylesheet" href="{{URL::asset('/style.css')}}">



</head>

<body>
     <?php  

        if (isset($player->id)) {
            $player_id = $player->id;
        }else{
            $player_id = '0';
        }

        if (isset($host->id)) {
            $host_id = $host->id;
        }else{
            $host_id = '0';
        }

        if (isset($id)) {
            $id = $id;
        }else{
            $id = '0';
        }

        


    ?>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" style="background: #4675A9">
            <div class="sidebar-header shadow">
                <!-- <a href="{{url('dashbord')}}"> -->
                    <!-- <img src="{{asset('icon.png')}}" style="width: 100%"> -->
                <!-- </a> -->
                <a href="{{url('dashbord')}}">
                    <h4 class="p-4 text-center" >My Champ</h4>
                </a>
            </div>
            <ul class="list-unstyled components">
                
                <li <?php if (Request::url() == url('/dashbord')) { ?> style = "background: white;color: gray" <?php } ?> >
                    <a href="{{url('dashbord')}}">Dashboard</a>
                </li>
                
                <li <?php if (Request::url() == url('/players') or Request::url() == url('/add_player')or Request::url() == url('/edite_player', [$player_id]) ) { ?> style = "background: white;color: gray"  
                    <?php } ?>>
                    
                    <a href="{{url('/players')}}">Players</a>
                </li>
            

                <li <?php if (Request::url() == url('/hosts') or Request::url() == url('/add_host')or Request::url() == url('/edite_host', [$host_id])  ) { ?> style = "background: white;color: gray"  
                    <?php } ?>>
                    
                    <a href="{{url('/hosts')}}">Host's</a>
                </li>
                
                <li <?php if (Request::url() == url('/tournament')or Request::url() == url('/add_tournament') ) { ?> style = "background: white;color: gray" <?php } ?>>
                    <a href="{{url('tournament')}}">Tournament </a>
                </li>

                <li <?php if (Request::url() == url('/tournament_players', [$id])or Request::url() == url('/add_tournament_players' , [$id]) ) { ?> style = "background: white;color: gray" <?php } ?> >
                    <a href="{{url('tournament_players', '0')}}">Tournament Players</a>
                </li>

               
                
                <li <?php if ( Request::url() == url('/fetch_notification')   ) { ?> style = "background: white;color: gray" <?php } ?> >
                    <a href="{{url('/fetch_notification')}}">Notification</a>
                </li>
               
            </ul>

        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn text-white" style="background: #4675A9">
                        <i class="fas fa-align-left"></i>
                        <!-- <span>Toggle Sidebar</span> -->
                    </button>
                    <button class="btn text-white d-inline-block d-lg-none ml-auto" style="background: #4675A9" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto mr-4">
                       <!--  <li class="nav-item">
                            <a class="nav-link" style="color: #4675A9" href="#" style="color: #0B839B"><i class="fa-solid fa-bell"></i></a>                  
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color: #4675A9" href="#" style="color: #0B839B"><i class="fa-solid fa-message"></i></a>
                        </li> -->
                        </ul>
                        <div class="dropdown mr-4">
                          <button class="btn text-white mt-lg-0 mt-md-3 mt-sm-3 mt-3" style="background: #4675A9" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                            Hi <?php echo session()->get('name');?>
                          </button>
                          <div class="dropdown-menu mt-2" style="font-size: 12px;"  aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{url('/profile')}}">Profile</a>
                            <a class="dropdown-item" href="{{url('/change_password')}}">Change Password</a>

                            <a class="dropdown-item" href="{{url('/logout')}}">Logout</a>
                          </div>
                        </div>
                    </div>
                </div>
            </nav>

        