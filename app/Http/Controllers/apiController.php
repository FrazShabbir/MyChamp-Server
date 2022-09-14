<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\host;
use App\Models\tournament;
use App\Models\notification;
use App\Models\tournament_players;
use App\Models\TournamentInvite;
use App\Models\Group;
use App\Models\GroupPlayer;
use Mail;
use Illuminate\Support\Facades\DB;

class apiController extends Controller
{
    public function register(Request $Request)
    {
        $response = array();
        try {
            DB::beginTransaction();
            $player_name = host::where('email', $Request->email)->where('type', $Request->type)->get()->toarray();
            //$player_name = host::where('phone',$Request->phone)->orWhere('email',$Request->email)->get()->toarray();
            //return $player_name;

            if (empty($player_name)) {
                $player = new host();
                $player->type = $Request['type'];
                $player->name = $Request['name'];
                $player->level = $Request['level'];
                $player->email = $Request['email'];
                $player->password = $Request['password'];
                $player->phone =$Request['phone'];
                $player->status ='0';
                if (!empty($Request['image'])) {
                    $file = $Request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time(). "." . $extension;
                    $file->move('uploads/images/', $filename);
                    $player->image = $filename;
                } else {
                    $player->image = "icon.png";
                }
                // $player->image = 'icon.png';
                $Result = $player->save();
                if ($Result) {
                    // send email
                    $otp = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
                    $player->otp = $otp;
                    $player->save();
                    $email = $Request->email;
                    $mail = Mail::raw('Your account activation OTP is  '.$player->otp.'.', function ($message) use ($email) {
                        $message->to($email)
                      ->subject('Your OTP ');
                    });

                    $response['success'] = 1;
                    $response["message"]= "Registration successfull and otp sent to your email for account activation.";
                    DB::commit();
                    return json_encode($response);
                } else {
                    $response['success'] = 0;
                    $response["message"]= "Registration Faild.";
                    DB::rollBack();
                    return json_encode($response);
                }
            } else {
                $response['success'] = 0;
                $response["message"]= "User With This Email and type  Already Exist";
                DB::rollBack();
                return json_encode($response);
            }
        } catch (\Throwable $th) {
            DB::commit();
            //throw $th;
        }
    }

public function confirmOtp(Request $request)
{
    $response = array();
    $email = $request->email;
    $otp = $request->otp;
    $type = $request->type;
    $player = host::where('email', $email)->where('type', $type)->first();
    if ($player) {
        if ($player->otp == $otp) {
            $player->status = '1';
            $player->save();
            $response['success'] = 1;
            $response["message"]= "OTP Confirmed";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "OTP Not Match";
            return json_encode($response);
        }
    } else {
        $response['success'] = 0;
        $response["message"]= "User Not Found";
        return json_encode($response);
    }
}


public function resendOtp(Request $request)
{
    $response = array();
    $email = $request->email;
    $type = $request->type;
    $player = host::where('email', $email)->where('type', $type)->first();
    if ($player) {
        $otp = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
        $player->otp = $otp;
        $player->save();
        $email = $request->email;
        $mail = Mail::raw('Your account activation OTP is  '.$player->otp.'.', function ($message) use ($email) {
            $message->to($email)
          ->subject('Your OTP ');
        });
        $response['success'] = 1;
        $response["message"]= "OTP Resend";
        return json_encode($response);
    } else {
        $response['success'] = 0;
        $response["message"]= "User Not Found";
        return json_encode($response);
    }
}

    public function player_login(Request $Request)
    {
        $response = array();
        $player = host::where('email', $Request->email)
                     ->where('password', $Request->password)
                     ->where('type', $Request->type)
                     ->get()->toarray();
        if ($player) {
            foreach ($player as $row) {
                $host["id"] = $row['id'];
                $host["type"] = $row['type'];
                $host["name"] = $row['name'];
                $host["email"] = $row['email'];
                $host["password"] = $row['password'];
                $host["phone"] = $row['phone'];
                $host["image"] = $row['image'];
                $host["level"] = $row['level'];
                $host["status"] = $row['status'];
                $host["created_at"] = $row['created_at'];
                $host["updated_at"] = $row['updated_at'];
            }
            if ($host['status'] != '0') {
                $response["host"] = array();
                array_push($response["host"], $host);
                $response['success'] = 1;
                $response["message"]= "You are successfully login";
                return json_encode($response);
            } else {
                $response['success'] = 0;
                $response["message"]= "You are disable";
                return json_encode($response);
            }
        } else {
            $response['success'] = 0;
            $response["message"]= "Please enter correct email and password";
            return json_encode($response);
        }
    }


    public function player_profile($id)
    {
        $response = array();
        $player = host::with('tournaments')->where('id', $id)->get();
        $count = count($player);


        if ($count != 0) {
            $response["host"] = array();

            foreach ($player as $row) {
                $host["id"] = $row['id'];
                $host["type"] = $row['type'];
                $host["name"] = $row['name'];
                $host["email"] = $row['email'];
                $host["password"] = $row['password'];
                $host["phone"] = $row['phone'];
                $host["image"] = $row['image'];
                $host["level"] = $row['level'];
                $host["status"] = $row['status'];
                $host["created_at"] = $row['created_at'];
                $host["updated_at"] = $row['updated_at'];
                array_push($response["host"], $host);
            }
            $invites = TournamentInvite::where('player_id', $id)->where('status', 2)->get();
            $pending_response = tournament_players::with('tournament')->where('player_id', $id)->where('host_approval', 2)->get();
            $tournaments = tournament::with('player')->where('host_id', $id)->get();
            $added_tournaments =tournament_players::with('tournament')->where('player_id', $id)->where('host_approval', 1)->get();
            $rejected_by_host =tournament_players::with('tournament')->where('player_id', $id)->where('host_approval', 0)->get();
            $notifications = notification::with('sender')->with('receiver')->where('receiver_id', $id)->get();
            $groups = Group::with('annoucements')->where('host_id', $id)->get();

            $member = tournament_players::where('player_id', $id)->get();

            $response["groups"] = $groups;
            $response["invites"] = $invites;
            $response["tournaments"] = $tournaments;
            $response["invites_response_pending"] = $pending_response;
            $response["added_tournaments"] = $added_tournaments;
            $response["rejected_by_host"] = $rejected_by_host;
            
            // $response["entered_tournaments"] = $member;
            $response["notifications"] = $notifications;
            $response['success'] = 1;
            $response["message"]= "All user's  data fetched Successfully";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "Data cannot be exist";
            return json_encode($response);
        }
    }

    public function update_player(Request $Request, $id)
    {
        $response = array();
        $player = host::find($id);
        $player->type = $Request['type'];
        $player->name = $Request['name'];
        $player->level = $Request['level'];
        $player->email = $Request['email'];
        $player->password = $Request['password'];
        $player->phone =$Request['phone'];
        $player->status = $player->status;
        $image_type = $Request['image'];
        if (!empty($Request['image'])) {
            $file = $Request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). "." . $extension;
            $file->move('uploads/images/', $filename);
            $player->image = $filename;
        } else {
            $player->image = $player->image;
        }
        $Result = $player->save();
        if ($Result) {
            $response['success'] = 1;
            $response["message"]= "Successfully updated";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "Update Faild";
            return json_encode($response);
        }
    }

    public function changePlayerStatus(Request $request, $id)
    {
        $response = array();
        $player = host::find($id);
        if(!$player){
            $response['success'] = 0;
            $response["message"]= "User Not Found";
            return json_encode($response);
        }
        $player->status = $request['status'];
        $Result = $player->save();
        if ($Result) {
            $response['success'] = 1;
            $response["message"]= "Player Status Changed Successfully";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "Operation Faild";
            return json_encode($response);
        }
    }

public function player_invite($id)
{
    $response = array();
    $player = host::where('id', $id)->first();
    $invites = TournamentInvite::with('tournament')->where('player_id', $id)->where('status', 2)->get();
    $response["invites"] = $invites;
    $response["player"] = $player;
    $response['success'] = 1;
    $response["message"]= "All user's  data fetched Successfully";
    return json_encode($response);
}


    public function insert_tournament(Request $Request)
    {
        $response = array();
        $host = host::find($Request['host_id']);
        if ($host) {
            $tournament = new tournament();
            $tournament->name = $Request['name'];  // Title
            $tournament->venue = $Request['venue']; // vanue
            $tournament->country = $Request['country'];// country
            $tournament->state = $Request['state'];//state
            $tournament->date = $Request['date']; //start_date
            $tournament->start_time = $Request['start_time']; //start_time
            $tournament->end_date = $Request['end_date'];//end_date
            $tournament->end_time = $Request['end_time']; //end_time
            $tournament->repeat = $Request['repeat'];// repeat
            $tournament->category = $Request['category'];//category
            $tournament->format = $Request['format'];//format
            $tournament->description = $Request['description']; //additional information
            $tournament->host_id = $Request['host_id']; //host_id
            $host = host::find($tournament->host_id);
            $tournament->status = '0';
            $tournament->host_name = $host->name;
            $Result = $tournament->save();
            if ($Result) {
                $response['success'] = 1;
                $response["message"]= "Tournament add successfull";
                return json_encode($response);
            } else {
                $response['success'] = 0;
                $response["message"]= "Tournament adding Faild";
                return json_encode($response);
            }
        } else {
            $response['success'] = 0;
            $response["message"]= "No host Found";
            return json_encode($response);
        }
    }
    public function edit_tournament($id)
    {
        $response = array();
        $tournament = tournament::find($id);
        if ($tournament) {
            $response["tournament"] =$tournament;
            $response['success'] = 1;
            $response["message"]= "Tournament fetched successfull";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "Tournament Not Found";
            return json_encode($response);
        }
    }
    public function show_tournament($id)
    {
        $response = array();
        $tournament = tournament::with('player')->find($id);
        $tournament_host = host::find($tournament->host_id);
        $all_groups = Group::where('host_id', $tournament_host->id)->get();

        $pending_invites = TournamentInvite::where('tournament_id', $id)->where('status', 2)->get();
        $accepted_invites =  tournament_players::where('tournament_id', $id)->where('host_approval', 1)->get();
        $rejected_invites = TournamentInvite::where('tournament_id', $id)->where('status', 0)->get();

        if ($tournament) {
            $response["pending_invites"] =$pending_invites;
            $response["accepted_invites"] =$accepted_invites;
            $response["rejected_invites"] =$rejected_invites;
            $response["groups"] =$all_groups;
            // $response["host_response"] =$host_response;
            $response["tournament"] =$tournament;
            $response['success'] = 1;
            $response["message"]= "Tournament fetched successfull";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "Tournament Not Found";
            return json_encode($response);
        }
    }

    public function inviteGroup($id, $group)
    {
        $response = array();
        $tournament = tournament::find($id);
        if (!$tournament) {
            $response['success'] = 0;
            $response["message"]= "Tournament Not Found";
            return json_encode($response);
        }
        $find_group = Group::find($group);
        if (!$find_group) {
            $response['success'] = 0;
            $response["message"]= "Group Not Found";
            return json_encode($response);
        }
        $players = GroupPlayer::where('group_id', $find_group->id)->get();
        if ($players) {
            foreach ($players as $player) {
                $alreadyInvite = TournamentInvite::where('tournament_id', $tournament->id)->where('player_id', $player->player_id)->first();
                if (!$alreadyInvite) {
                    $invite = new TournamentInvite();
                    $invite->tournament_id = $tournament->id;
                    $invite->player_id = $player->player_id;
                    $invite->status = 2;
                    $invite->save();
                }
                // $invite = new TournamentInvite();
                // $invite->tournament_id = $tournament->id;
                // $invite->player_id = $player->player_id;
                // $invite->status = 2;
                // $invite->save();
            }
            $response['success'] = 1;
            $response["message"]= "Group Invited";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "No player in this group";
            return json_encode($response);
        }
    }

public function hostResponse(Request $request, $id)
{
    $reponse = [];
    $tournament_player = tournament_players::find($id);
    // return  $tournament_player;
    if ($tournament_player) {
        $tournament = tournament::find($tournament_player->tournament_id);

        if ($request->host_approval==1) {
            $tournament_player->host_approval = 1;
            $tournament_player->save();

            $notification = new notification();
            $notification->title = "My Champ";
            $notification->receiver_name = $tournament_player->name;
            $notification->receiver_id = $tournament_player->player_id;
            $notification->sender_id = $tournament->host_id;
            $notification->body = "Host of the tournament ".$tournament->name .' Approved your request';
            $notification->date = date("Y-m-d");
            $notification->save();


            $response['success'] = 1;
            $response["message"]= "Host Approval Successfull";
            return json_encode($response);
        } elseif ($request->host_approval==0) {
            $tournament_player->host_approval = 0;
            $tournament_player->save();
            // $tournament_player->delete();

            // $tournament_invite = TournamentInvite::where('tournament_id', $tournament->id)->where('player_id', $tournament_player->player_id)->first();
            // $tournament_invite->delete();

            $notification = new notification();
            $notification->title = "My Champ";
            $notification->receiver_name = $tournament_player->name;
            $notification->receiver_id = $tournament_player->player_id;
            $notification->sender_id = $tournament->host_id;

            $notification->body = "Host of the tournament ".$tournament->name .' Rejected your request';
            $notification->date = date("Y-m-d");
            $notification->save();

            $response['success'] = 1;
            $response["message"]= "Host Rejection Successfull";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "Invalid Status";
        }


        return json_encode($response);
    } else {
        $response['success'] = 0;
        $response["message"]= "No Player Found";
        return json_encode($response);
    }
}

    public function update_tournament(Request $request, $id)
    {
        $tournament = tournament::find($id);

        if ($tournament) {
            $response = [];
            $tournament->name = $request->name ?? $tournament->name ;  // Title
            $tournament->venue = $request->venue ?? $tournament->venue; // vanue
            $tournament->country = $request->country??$tournament->country;// country
            $tournament->state = $request->state?? $tournament->state ;//state
            $tournament->date = $request->date?? $tournament->date; //start_date
            $tournament->start_time = $request->start_time?? $tournament->start_time; //start_time
            $tournament->end_date = $request->end_date??$tournament->end_date;//end_date
            $tournament->end_time = $request->end_time??$tournament->end_time; //end_time
            $tournament->repeat = $request->repeat??$tournament->repeat;// repeat
            $tournament->category = $request->category??$tournament->category;//category
            $tournament->format = $request->format??$tournament->format;//format
            $tournament->description = $request->description??$tournament->description; //additional information
            $tournament->host_id = $request->host_id?? $tournament->host_id; //host_id
            $host = host::find($tournament->host_id);
            $tournament->host_name = $host->name ?? $tournament->host_name;
            $tournament->status = $request->status?? $tournament->status;

            $tournament->save();
            $response['tournament'] = $tournament;
            $response['success'] = 1;
            $response["message"]= "Tournament fetched Successfully";
        } else {
            $response['success'] = 0;
            $response["message"]= "Tournament Not Found";
        }
        return json_encode($response);
    }


    public function delete_tournament($id)
    {
        $response = [];
        $tournament = tournament::find($id);
        if ($tournament) {
            $players = tournament_players::where('tournament_id', $tournament->id)->get();
            foreach ($players as $player) {
                $player->delete();
            }
            $Result = $tournament->delete();
            if ($Result) {
                $response['success'] = 1;
                $response["message"]= "Tournament and Relevent Data delete successfull";
                return json_encode($response);
            } else {
                $response['success'] = 0;
                $response["message"]= "Tournament delete Failed";
                return json_encode($response);
            }
        } else {
            $response['success'] = 0;
            $response["message"]= "No tournament Found";
            return json_encode($response);
        }
    }
public function delete_tournament_player(Request $request, $id)
{
    $response = array();
    $tournament = tournament::find($id);
    if ($tournament) {
        $player = tournament_players::where('tournament_id', $tournament->id)->where('player_id', $request->player_id)->first();
        if ($player) {
            $player->delete();
            $response['success'] = 1;
            $response["message"]= "Player Delete from the tournament";
        } else {
            $response['success'] = 0;
            $response["message"]= "Player Not found in this tournament";
        }
    } else {
        $response['success'] = 0;
        $response["message"]= "No tournament Found";
    }
    return json_encode($response);
}

    public function host_tournament($id)
    {
        $response = array();
        $tournament = tournament::select('*')
                    ->where('host_id', '=', $id)
                    ->get();
        $count = count($tournament);

        if ($count != 0) {
            $response["data"] = array();

            foreach ($tournament as $row) {
                $data["id"] = $row['id'];
                $data["host_id"] = $row['host_id'];
                $data["host_name"] = $row['host_name'];
                $data["name"] = $row['name'];
                $data["description"] = $row['description'];
                $data["country"] = $row['country'];
                $data["state"] = $row['state'];
                $data["date"] = $row['date'];
                $data["start_time"] = $row['start_time'];
                $data["end_date"] = $row['end_date'];
                $data["end_time"] = $row['end_time'];
                $data["venue"] = $row['venue'];
                $data["repeat"] = $row['repeat'];
                $data["category"] = $row['category'];
                $data["format"] = $row['format'];
                $data["status"] = $row['status'];
                $data["created_at"] = $row['created_at'];
                $data["updated_at"] = $row['updated_at'];
                array_push($response["data"], $data);
            }

            $response['success'] = 1;
            $response["message"]= "All Tournaments fetched Successfully";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "No Data Found";
            return json_encode($response);
        }
    }


    public function tournaments()
    {
        $response = array();
        $tournament = tournament::all();
        $count = count($tournament);

        if ($count != 0) {
            $response["data"] = array();

            foreach ($tournament as $row) {
                $data["id"] = $row['id'];
                $data["host_id"] = $row['host_id'];
                $data["host_name"] = $row['host_name'];
                $data["name"] = $row['name'];
                $data["description"] = $row['description'];
                $data["country"] = $row['country'];
                $data["state"] = $row['state'];
                $data["date"] = $row['date'];
                $data["start_time"] = $row['start_time'];
                $data["end_date"] = $row['end_date'];
                $data["end_time"] = $row['end_time'];
                $data["venue"] = $row['venue'];
                $data["repeat"] = $row['repeat'];
                $data["category"] = $row['category'];
                $data["format"] = $row['format'];
                $data["status"] = $row['status'];
                $data["created_at"] = $row['created_at'];
                $data["updated_at"] = $row['updated_at'];
                array_push($response["data"], $data);
            }

            $response['success'] = 1;
            $response["message"]= "All users fetch Successfully";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "Data cannot be exist";
            return json_encode($response);
        }
    }



    public function insert_tournament_players(Request $Request)
    {
        $response = array();
        $tournament = tournament::find($Request->tournament_id);
        $player = host::find($Request->player_id);

        if ($tournament and $player) {
            $tournament_player = tournament_players::where('tournament_id', $Request->tournament_id)
            ->where('player_id', $Request->player_id)->get();
            $count = count($tournament_player);
            $alreadyInvite = TournamentInvite::where('tournament_id', $Request->tournament_id)->where('player_id', $Request->player_id)->first();
            if ($alreadyInvite) {
                $response['success'] = 0;
                $response["message"]= "Player already invited";
                return json_encode($response);
            }
            if ($count == 0) {
                $host = host::find($Request['player_id']);
                $player_invite = TournamentInvite::create([
                    'tournament_id' => $Request->tournament_id,
                    'player_id' => $Request->player_id,
                    'status' => '2',

                ]);
                // $player = new tournament_players();
                // $player->name = $host->name;
                // $player->tournament_id = $Request['tournament_id'];
                // $player->player_id = $Request['player_id'];
                // $player->email = $host->email;
                // // $player->password = $host->password;
                // $player->phone = $host->phone;
                // $player->image = $host->image;
                // $player->level = $host->level;
                $Result = $player_invite;

                if ($Result) {
                    $notification = new notification();
                    $notification->title = "My Champ";
                    $notification->receiver_name = $host->name;
                    $notification->receiver_id = $Request['player_id'];
                    $notification->sender_id = $tournament->host_id;
                    $notification->body = "You have invited for new tournament for more details please check My Champ app.";
                    $notification->date = date("Y-m-d");
                    $notification->save();
                    if ($notification) {
                        $this->notification($notification);
                    }
                    $response['success'] = 1;
                    $response["message"]= "Player Invited to tournament successfully";
                    return json_encode($response);
                } else {
                    $response['success'] = 0;
                    $response["message"]= "Failed to invite the player";
                    return json_encode($response);
                }
            } else {
                $response['success'] = 0;
                $response["message"]= "Player is already in this tournament";
                return json_encode($response);
            }
        } else {
            $response['success'] = 0;
            $response["message"]= "Tournament  or Player not found";
            return json_encode($response);
        }
    }

 public function inviteResponse(Request $request)
 {
     // invite id
     // player id // logged in user id
     // tournament id
     // status

     $response = array();
     $invite = TournamentInvite::find($request->invite_id);


     if ($invite and $invite->status=='2') {
         $player = host::find($invite->player_id);
         $tournament = tournament::find($invite->tournament_id);
         if ($request->status=='1') {
             $invite->status = $request->status;
             $invite->save();
             $tournament_player = new tournament_players();
             $tournament_player->name = $player->name;
             $tournament_player->tournament_id = $tournament->id;
             $tournament_player->player_id = $player->id;
             $tournament_player->email = $player->email;
             // $tournament_player->password = $player->password;
             $tournament_player->phone = $player->phone;
             $tournament_player->image = $player->image;
             $tournament_player->level = $player->level;
             $tournament_player->save();
             if ($tournament_player) {
                 $tournament_owner = host::find($tournament->host_id);
                 $notification = new notification();
                 $notification->title = "My Champ";
                 $notification->receiver_name = $player->name;
                 $notification->receiver_id = $tournament_owner->id;
                 $notification->sender_id = $player->id;

                 $notification->body = "Player Accepted your invitation for tournament ".$tournament->name;
                 $notification->date = date("Y-m-d");
                 $notification->save();
                 if ($notification) {
                     $this->notification($notification);
                 }
                 $response['success'] = 1;
                 $response["message"]= "Player Added to tournament successfully";
                 return json_encode($response);
             } else {
                 $response['success'] = 0;
                 $response["message"]= "Failed to add player to tournament";
                 return json_encode($response);
             }
         } elseif ($request->status=='0') {
             $invite->status = $request->status;
             $invite->save();
             $invite->delete();

             $tournament_owner = host::find($tournament->host_id);

             $notification = new notification();
             $notification->title = "My Champ";
             $notification->receiver_name = $player->name;
             $notification->receiver_id = $tournament_owner->id;
             $notification->sender_id = $player->id;

             $notification->body = "Player Rejected your invitation for tournament ".$tournament->name;
             $notification->date = date("Y-m-d");
             $notification->save();
             if ($notification) {
                 $this->notification($notification);
             }

             $response['success'] = 1;
             $response["message"]= "Player Declined the tournament";
             return json_encode($response);
         } else {
             $response['success'] = 0;
             $response["message"]= "Invilid status";
             return json_encode($response);
         }
     } else {
         $response['success'] = 0;
         $response["message"]= "Invite not found";
         return json_encode($response);
     }
 }




    public function player_tournaments(Request $Request)
    {
        $response = array();
        // $tournament_players = tournament_players::join("tournament", function ($join) {
        //     $join->on("tournament.id", "=", "tournament_id");
        // })->where('player_id', $Request['player_id'])->get();
        // $count = count($tournament_players);

        $tournament_players = tournament_players::select('*')
                    ->where('player_id', '=', $Request['player_id'])
                    ->get();
        $date = $Request['date'];
        $index = 0;
        $response["data"] = array();
        foreach ($tournament_players as $player) {
            if ($date == "date") {
                $tournament_id = $player->tournament_id;
                $tournament = tournament::select('*')
                                ->where('id', '=', $tournament_id)
                                ->get();
            } else {
                $tournament_id = $player->tournament_id;
                $tournament = tournament::where('date', $date)
                                    ->where('id', $tournament_id)
                                    ->get()->toarray();
            }

            foreach ($tournament as $row) {
                $data["id"] = $row['id'];
                $data["name"] = $row['name'];
                $data["host_id"] = $row['host_id'];
                $data["description"] = $row['description'];
                $data["start_time"] = $row['start_time'];
                $data["end_time"] = $row['end_time'];
                $data["date"] = $row['date'];
                $data["venue"] = $row['venue'];
                $data["host_name"] = $row['host_name'];
                $data["status"] = $row['status'];
                $data["created_at"] = $row['created_at'];
                $data["updated_at"] = $row['updated_at'];
                array_push($response["data"], $data);
            }
            if ($index == count($tournament_players)-1) {
                $response['success'] = 1;
                $response["message"]= "Player tournaments fetch Successfully";
                return json_encode($response);
            }
            $index++;
        }
    }



    public function player_add_tournaments(Request $Request)
    {
        $response = array();
        $tournament_players = tournament_players::select('*')
                    ->where('player_id', '=', $Request['player_id'])
                    ->get();
        $index = 0;
        $response["data"] = array();
        foreach ($tournament_players as $player) {
            $tournament_id = $player->tournament_id;
            $tournament = tournament::select('*')
                            ->where('id', '=', $tournament_id)
                            ->get();

            foreach ($tournament as $row) {
                $data["id"] = $row['id'];
                $data["name"] = $row['name'];
                $data["host_id"] = $row['host_id'];
                $data["description"] = $row['description'];
                $data["start_time"] = $row['start_time'];
                $data["end_time"] = $row['end_time'];
                $data["date"] = $row['date'];
                $data["venue"] = $row['venue'];
                $data["host_name"] = $row['host_name'];
                $data["status"] = $row['status'];
                $data["created_at"] = $row['created_at'];
                $data["updated_at"] = $row['updated_at'];
                array_push($response["data"], $data);
            }
            if ($index == count($tournament_players)-1) {
                $response['success'] = 1;
                $response["message"]= "Player tournaments fetch Successfully";
                return json_encode($response);
            }
            $index++;
        }
    }


    public function tournaments_players($id)
    {
        $response = array();
        $player = tournament_players::join("host", function ($join) {
            $join->on("host.id", "=", "player_id");
        })->where('tournament_id', $id)->get();

        $count = count($player);
        if ($count != 0) {
            $response["data"] = array();
            foreach ($player as $row) {
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
                array_push($response["data"], $data);
            }
            $response['success'] = 1;
            $response["message"]= "All players fetch Successfully";
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response["message"]= "NO DATA FOUND";
            return json_encode($response);
        }
    }



    public function free_players($id)
    {
        $response = array();
        $response["data"] = array();

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
                array_push($response['data'], $data);
            }
            if ($i == count($host)-1) {
                $response['success'] = 1;
                $response["message"]= "All players fetch Successfully";
                return json_encode($response);
            }
            $i++;
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
