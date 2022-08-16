<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\host;
use App\Models\tournament;
use App\Models\tournament_players;
use App\Models\notification;
use Illuminate\Support\Facades\File;

class indexController extends Controller
{
    // Show dashbord
    public function dashbord()
    {
        if (session()->get('name')) {
            $player = host::select('*')
                    ->where('type', '=', "player")
                    ->get();
            $host = host::select('*')
                    ->where('type', '=', "host")
                    ->get();
            $accepted = tournament::select('*')
                    ->where('status', '=', '1')
                    ->get();
            $declined = tournament::select('*')
                    ->where('status', '=', '0')
                    ->get();
            $host_count = count($host);
            $player_count = count($player);
            $accepted_count = count($accepted);
            $declined_count = count($declined);

            $data = compact('host_count', 'player_count', 'accepted_count', 'declined_count');
            return view('index')->with($data);
        } else {
            return redirect('/');
        }
    }

    // player session start

    // Show player Table

    public function players()
    {
        if (session()->get('name')) {
            $player = host::select('*')
                    ->where('type', '=', "player")
                    ->get();
            $data = compact('player');
            return view('players')->with($data);
        } else {
            return redirect('/');
        }
    }

    // add player form

    public function add_player()
    {
        if (session()->get('name')) {
            return view('add_player');
        } else {
            return redirect('/');
        }
    }




    public function delete_notification(Request $Request)
    {
        if (session()->get('name')) {
            $id = $Request['id'];
            $notification = notification::find($id);
            $notification->delete();
            toastr()->success('Notification is successfully deleted!');
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }



    public function delete_tournament_players(Request $Request)
    {
        if (session()->get('name')) {
            $id = $Request['id'];
            $tournament_players = tournament_players::find($id);
            $tournament_players->delete();
            toastr()->success('Player is successfully deleted!');
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }




    // insert player

    public function insert_player(Request $Request)
    {
        if (session()->get('name')) {
            $player_name = host::where('email', $Request->email)->where('phone', $Request->phone)->get()->toarray();
            if (empty($player_name)) {
                $player = new host();
                $player->type = "player";
                $player->name = $Request['name'];
                $player->level = $Request['level'];
                $player->email = $Request['email'];
                $player->password = $Request['password'];
                $player->phone =$Request['phone'];
                $player->status ='1';
                if (!empty($Request['image'])) {
                    $file = $Request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time(). "." . $extension;
                    $file->move('uploads/images/', $filename);
                    $player->image = $filename;
                } else {
                    $player->image = "icon.png";
                }
                $player->save();
                toastr()->success('Player successfully inserted');
                return redirect('/players');
            } else {
                toastr()->error('Email is already exixt!');
                return redirect()->back();
            }
        } else {
            return redirect('/');
        }
    }

    // show edite player function

    public function edite_player($id)
    {
        if (session()->get('name')) {
            $player = host::find($id);
            $data = compact('player');
            return view('edite_player')->with($data);
        } else {
            return redirect('/');
        }
    }

    // Update player function

    public function update_player(Request $Request, $id)
    {
        if (session()->get('name')) {
            $host = host::find($id);
            $host->type = "player";
            $host->name = $Request['name'];
            $host->level = $Request['level'];
            $host->email = $Request['email'];
            $host->password = $Request['password'];
            $host->phone =$Request['phone'];
            $host->status =$host->status;
            if (!empty($Request['image'])) {
                $file = $Request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time(). "." . $extension;

                $discription = 'uploads/images/'.$host->image;
                if (File::exists($discription)) {
                    File::delete($discription);
                }
                $file->move('uploads/images/', $filename);
                $host->image = $filename;
            } else {
                $host->image = $host->image;
            }

            $host->save();
            toastr()->success('Player successfully updated');
            return redirect('/players');
        } else {
            return redirect('/');
        }
    }

    //End player session Functions

    // start hostb session functions



    // show host table function

    public function hosts()
    {
        if (session()->get('name')) {
            $host = host::select('*')
                    ->where('type', '=', "host")
                    ->get();
            $data = compact('host');
            return view('hosts')->with($data);
        } else {
            return redirect('/');
        }
    }

    // show add form function

    public function add_host()
    {
        if (session()->get('name')) {
            return view('add_host');
        } else {
            return redirect('/');
        }
    }

    // insert host  function

    public function insert_host(Request $Request)
    {
        if (session()->get('name')) {
            $host_name = host::where('email', $Request->email)->where('phone', $Request->phone)->get()->toarray();
            $count = count($host_name);
            if ($count == 0) {
                $host = new host();
                $host->type = "host";
                $host->name = $Request['name'];
                $host->level = $Request['level'];
                $host->email = $Request['email'];
                $host->password = $Request['password'];
                $host->phone =$Request['phone'];
                $host->status ='1';
                if (!empty($Request['image'])) {
                    $file = $Request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time(). "." . $extension;
                    $file->move('uploads/images/', $filename);
                    $host->image = $filename;
                } else {
                    $host->image = "icon.png";
                }
                $host->save();
                toastr()->success('Host successfully inserted');
                return redirect('/hosts');
            } else {
                toastr()->error('Email is already exixt!');
                return redirect()->back();
            }
        } else {
            return redirect('/');
        }
    }

    // show edite host form function

    public function edite_host($id)
    {
        if (session()->get('name')) {
            $host = host::find($id);
            $data = compact('host');
            return view('edite_host')->with($data);
        } else {
            return redirect('/');
        }
    }

    // Update host function

    public function update_host(Request $Request, $id)
    {
        if (session()->get('name')) {
            $host = host::find($id);
            $host->type = "host";
            $host->name = $Request['name'];
            $host->level = $Request['level'];
            $host->email = $Request['email'];
            $host->password = $Request['password'];
            $host->phone =$Request['phone'];
            $host->status =$host->status;
            if (!empty($Request['image'])) {
                $file = $Request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time(). "." . $extension;

                $discription = 'uploads/images/'.$host->image;
                if (File::exists($discription)) {
                    File::delete($discription);
                }
                $file->move('uploads/images/', $filename);
                $host->image = $filename;
            } else {
                $host->image = $host->image;
            }
            $host->save();
            toastr()->success('Host successfully updated!');
            return redirect('/hosts');
        } else {
            return redirect('/');
        }
    }

    // end Host session

    // aproved host and player

    public function aproved(Request $Request)
    {
        if (session()->get('name')) {
            $id = $Request['id'];
            $host = host::find($id);

            $host->type = $host->type;
            $host->name = $host->name;
            $host->level = $host->level;
            $host->email = $host->email;
            $host->password = $host->password;
            $host->phone = $host->phone;
            if ($host->status == 0) {
                $host->status = 1;
            } else {
                $host->status = 0;
            }

            $host->image = $host->image;

            $host->save();
            toastr()->success('Your are successfully change the status');
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }

    // delete host and player

    public function delete_host(Request $Request)
    {
        if (session()->get('name')) {
            $id = $Request['id'];
            $host = host::find($id);
            $discription = 'uploads/images/'.$host->image;
            if (File::exists($discription)) {
                File::delete($discription);
            }
            $host->delete();
            toastr()->success('Player is successfully deleted!');
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }


    public function tournament()
    {
        if (session()->get('name')) {
            $tournament = tournament::all();
            $data = compact('tournament');
            return view('tournament')->with($data);
        } else {
            return redirect('/');
        }
    }

    public function add_tournament()
    {
        if (session()->get('name')) {
            $host = host::select('*')
                    ->where('type', '=', "host")
                    ->get();
            $data = compact('host');
            return view('add_tournament')->with($data);
        } else {
            return redirect('/');
        }
    }


    public function insert_tournament(Request $Request)
    {
        if (session()->get('name')) {
            $tournament = new tournament();
            $tournament->name = $Request['name'];
            $tournament->description = $Request['description'];
            $tournament->host_id = $Request['host_id'];
            $host = host::find($tournament->host_id);
            $tournament->date = $Request['date'];
            $tournament->start_time = $Request['start_time'];
            $tournament->end_time = $Request['end_time'];
            $tournament->venue = $Request['venue'];
            $tournament->status = '1';
            $tournament->host_name = $host->name;

            $tournament->end_date = $Request['end_date'];
            $tournament->country = $Request['country'];
            $tournament->state = $Request['date'];
            $tournament->repeat = $Request['repeat'];
            $tournament->format = $Request['format'];
            $tournament->category = $Request['category'];




            $tournament->save();
            toastr()->success('Add tournament successfully!');
            return redirect('/tournament');
        } else {
            return redirect('/');
        }
    }



    public function asign_players()
    {
        if (session()->get('name')) {
            return view('asign_players');
        } else {
            return redirect('/');
        }
    }


    public function fetch_notification()
    {
        if (session()->get('name')) {
            $notification = notification::all();
            $data = compact('notification');
            return view('notification')->with($data);
        } else {
            return redirect('/');
        }
    }


    public function tournament_accepted(Request $Request)
    {
        if (session()->get('name')) {
            $id = $Request['id'];
            $tournament = tournament::find($id);
            // $tournament = new tournament;
            $tournament->name = $tournament->name;
            $tournament->description = $tournament->description;
            $tournament->host_id = $tournament->host_id;
            // $host = host::find($tournament->host_id);
            $tournament->date = $tournament->date;
            $tournament->start_time = $tournament->start_time;
            $tournament->end_time = $tournament->end_time;
            $tournament->venue = $tournament->venue;
            if ($tournament->status == 0) {
                $tournament->status = 1;
            } else {
                $tournament->status = 0;
            }
            // $tournament->status = '1';
            $tournament->host_name = $tournament->host_name;
            toastr()->success('Your successfully change tournament status');

            $tournament->save();
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }

    public function show_tournament($id)
    {
        // dd('j');
        if (session()->get('name')) {
            $tournament = tournament::findOrFail($id);

         
            return view('show_tournament')
            ->with('tournament', $tournament);
           
            
        } else {
            return redirect('/');
        }
    }

    public function edit_tournament($id)
    {
        // dd('j');
        if (session()->get('name')) {
            $tournament = tournament::findOrFail($id);
            $host = host::select('*')
            ->where('type', '=', "host")
            ->get();
         
            return view('edit_tournament')
            ->with('tournament', $tournament)
            ->with('host', $host);
           
            
        } else {
            return redirect('/');
        }
    }

    public function update_tournament(Request $request, $id){
        if (session()->get('name')) {
            $tournament = tournament::findOrFail($id);
            $tournament->name = $request->name;
            $tournament->description = $request->description;
            $tournament->host_id = $request->host_id;
            $host = host::find($tournament->host_id);
            $tournament->date = $request->date;
            $tournament->start_time = $request->start_time;
            $tournament->end_time = $request->end_time;
            $tournament->venue = $request->venue;
            $tournament->status = $request->status;
            $tournament->host_name = $host->name;
            $tournament->end_date = $request->end_date;
            $tournament->country = $request->country;
            $tournament->state = $request->date;
            $tournament->repeat = $request->repeat;
            $tournament->format = $request->format;
            $tournament->category = $request->category;
            $tournament->save();
            toastr()->success('Your successfully update tournament');
            return redirect('/tournament');
        } else {
            return redirect('/');
        }

    }

    public function destroy_tournament($id)
    {
        // dd('He');
        if (session()->get('name')) {
            $tournament = tournament::findOrFail($id);
            $tournament->delete();
            toastr()->success('Your successfully delete tournament');
            return redirect('/tournament');
        } else {
            return redirect('/');
        }
    }
    
    


    public function tournament_players($id)
    {
        if (session()->get('name')) {
            if ($id != '0') {
                $tournament = tournament::all();
                $tournament_players = tournament_players::select('*')
                        ->where('tournament_id', '=', $id)
                        ->get();
                $data = compact('tournament_players', 'id', 'tournament');
                return view('tournament_players')->with($data);
            } else {
                $tournament = tournament::all();
                $tournament_players = tournament_players::all();
                $data = compact('tournament_players', 'id', 'tournament');
                return view('tournament_players')->with($data);
            }
        } else {
            return redirect('/');
        }
    }


    public function add_tournament_players($id)
    {
        if (session()->get('name')) {
            $player = array();
            $host = host::select('*')
                    ->where('type', '=', 'player')
                    ->get();
            $i = 0;
            foreach ($host as $row) {
                $tournament_players = tournament_players::select('*')
                    ->where('tournament_id', '=', $id)
                    ->where('player_id', '=', $row->id)
                    ->get();
                $count = count($tournament_players);
                if ($count < 1) {
                    $data["id"] = $row['id'];
                    $data["type"] = $row['type'];
                    $data["name"] = $row['name'];
                    $data["email"] = $row['email'];
                    $data["password"] = $row['password'];
                    $data["phone"] = $row['phone'];
                    $data["image"] = $row['image'];
                    $data["level"] = $row['level'];
                    $data["status"] = $row['status'];
                    $data["created_at"] = $row['created_at'];
                    $data["updated_at"] = $row['updated_at'];
                    array_push($player, $data);
                }
                if ($i == count($host)-1) {
                    $data1 = compact('player', 'id', 'tournament_players');
                    return view('add_tournament_player')->with($data1);
                }
                $i++;
            }
        } else {
            return redirect('/');
        }
    }

    public function insert_tournament_players(Request $Request, $tournament_id)
    {
        if (session()->get('name')) {
            $id = $Request['id'];
            if (!empty($id)) {
                for ($i=0; $i < count($id); $i++) {
                    $ide =  $id[$i];
                    $host = host::find($ide);
                    // echo "<pre>";
                    // print_r($host->toarray());

                    $player = new tournament_players();
                    $player->name = $host->name;
                    $player->tournament_id = $tournament_id;
                    $player->player_id = $ide;
                    $player->email = $host->email;
                    // $player->password = $host->password;
                    $player->phone = $host->phone;
                    $player->image = $host->image;
                    $player->level = $host->level;
                    $player->save();
                    if ($player) {
                        $notification = new notification();
                        $notification->title = "My Champ";
                        $notification->receiver_name = $host->name;
                        $notification->receiver_id = $ide;
                        $notification->body = "You have invited for new tournament for more details please check My Champ app.";
                        $notification->date = date("Y-m-d");
                        $notification->save();
                        if ($notification) {
                            $this->notification($notification);
                        }
                    }
                }
                toastr()->success('Add players in tournament successfully!');
            }

            return redirect()->back();
        } else {
            return redirect('/');
        }
    }


    public function notification($notification)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        // Put your Server Key here
        $apiKey = "AAAAoQM481c:APA91bGrOX20Oi9sSDUFkiF0pK_JSFJbyShI2ycp7-kBcoDCKQgCFop_B6-UYZpCS6NBUdnMW7gTusJZzWdb8dd9XLl8oMNmzzLaL2QKCHmVmyOMWNl43U447HAGA_zpkKOuFasUUxsN";

        // Compile headers in one variable
        $headers = array(
            'Authorization:key=' . $apiKey,
            'Content-Type:application/json'
        );

        // Create the api body
        $apiBody = [
            'data' => $notification,
            'time_to_live' => 10800, // optional - In Seconds
            'to' => '/topics/champ'
            //'registration_ids' = ID ARRAY
            // 'to' => 'cc3y906oCS0:APA91bHhifJikCe-6q_5EXTdkAu57Oy1bqkSExZYkBvL6iKCq2hq3nrqKWymoxfTJRnzMSqiUkrWh4uuzzEt3yF5KZTV6tLQPOe9MCepimPDGTkrO8lyDy79O5sv046-etzqCGmKsKT4'
        ];

        // Initialize curl with the prepared headers and body
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));
        curl_setopt(
            $ch,
            CURLOPT_SSL_VERIFYPEER,
            false
        );

        // Execute call and save result
        $result = curl_exec($ch);
        // print($result);
        // Close curl after call
        curl_close($ch);

        // return $result;
        return redirect()->back();
    }
}
