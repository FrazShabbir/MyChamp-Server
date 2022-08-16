<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupPlayer;
use App\Models\Group;
use App\Models\host;

class GroupAPIController extends Controller
{
    public function createGroup(Request $request)
    {
        // return 'Hello';
        $response  =[];
        $host = host::where('id', $request->host_id)->where('type', 'host')->first();
        if ($host) {
            $group = Group::create([
                'host_id' => $request->host_id,
                'name' => $request->name,
            ]);

            $response['success'] = 1;
            $response['message'] = "Your group has been created successfully";
            $response['group'] = $group;
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response['message'] = "You are not a host";
            return json_encode($response);
        }
    }
    public function editGroup(Request $request,$id){
        $response  =[];
        $group = Group::where('id', $id)->first();
        if ($group and $group->host_id == $request->host_id) {
            $group->name = $request->name;
            $group->save();
            $response['success'] = 1;
            $response['message'] = "Your group has been updated successfully";
            $response['group'] = $group;
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response['message'] = "Group not found Or Invalid Action";
            return json_encode($response);
        }

    }
    public function groupsOfHost($id)
    {
        $response  =[];
        $host = host::where('id', $id)->where('type', 'host')->first();
        if ($host) {
            $groups = Group::where('host_id', $id)->get();
            $response['success'] = 1;
            $response['message'] = "Your groups has been listed successfully";
            $response['groups'] = $groups;
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response['message'] = "You are not a host";
            return json_encode($response);
        }
    }

    public function addPlayerToGroup(Request $request)
    {
        $response  =[];
        $host = host::where('id', $request->host_id)->where('type', 'host')->first();
        $group = Group::where('id', $request->group_id)->first();
        $player =  host::where('id', $request->player_id)->where('type', 'player')->first();
        if (!$player) {
            $response['message'] = "Player Not Found";
        }
        if (!$group) {
            $response['message'] = "Group Not Found";
        }
        if (!$host) {
            $response['message'] = "Host Not Found";
        }

        if ($host && $group && $player) {
            if ($group->host_id==$host->id) {
                $alreadyMember = GroupPlayer::where('group_id', $group->id)->where('player_id', $player->id)->first();
                if ($alreadyMember) {
                    $response['success'] = 0;
                    $response['message'] = "Player Already Added";
                    return json_encode($response);
                } else {
                    GroupPlayer::create([
                    'group_id' => $request->group_id,
                    'player_id' => $request->player_id,
                ]);
                    $response['success'] = 1;
                    $response['message'] = "Player has been added successfully";
                    return json_encode($response);
                }
            } else {
                $response['success'] = 0;
                $response['message'] = "You are owner of this group";
                return json_encode($response);
            }
        } else {
            $response['success'] = 0;
            return json_encode($response);
        }
    }
    public function removePlayerToGroup(Request $request)
    {
        $response  =[];
        $host = host::where('id', $request->host_id)->where('type', 'host')->first();
        $group = Group::where('id', $request->group_id)->first();
        $player =  host::where('id', $request->player_id)->where('type', 'player')->first();
        if (!$player) {
            $response['message'] = "Player Not Found";
        }
        if (!$group) {
            $response['message'] = "Group Not Found";
        }
        if (!$host) {
            $response['message'] = "Host Not Found";
        }

        if ($host && $group && $player) {
            if ($group->host_id==$host->id) {
                $alreadyMember = GroupPlayer::where('group_id', $group->id)->where('player_id', $player->id)->first();
                if ($alreadyMember) {
                    $alreadyMember->delete();
                    $response['success'] = 1;
                    $response['message'] = "Player has been removed successfully";
                    return json_encode($response);
                } else {
                    $response['success'] = 0;
                    $response['message'] = "Player Not Found";
                    return json_encode($response);
                }
            } else {
                $response['success'] = 0;
                $response['message'] = "You are owner of this group";
                return json_encode($response);
            }
        } else {
            $response['success'] = 0;
            return json_encode($response);
        }
    }

    public function listPlayerInGroup($id)
    {
        $group = Group::with('host')->where('id', $id)->first();
        $players = GroupPlayer::with('player')->where('group_id', $id)->get();
        $response  =[];
        if ($group) {
            $response['success'] = 1;
            $response['message'] = "Players in group";
            $response['group'] = $group;
            $response['players'] = $players;
            return json_encode($response);
        } else {
            $response['success'] = 0;
            $response['message'] = "Group Not Found";
            return json_encode($response);
        }
    }
    public function deleteGroup(Request $request)
    {
        $response  =[];
        $host = host::where('id', $request->host_id)->where('type', 'host')->first();
        if (!$host) {
            $response['message'] = "Host Not Found";
        }
        $group = Group::where('id', $request->group_id)->first();
        if (!$group) {
            $response['message'] = "Group Not Found";
        }
        if(!$host and !$group){
            $response['message'] = "Group and Host Not Found";
          
        }

        if ($group && $host) {
            if ($host->id == $group->host_id) {
                $members = GroupPlayer::where('group_id', $group->id)->get();
                foreach ($members as $member) {
                    $member->delete();
                }
                $group->delete();
                $response['success'] = 1;
                $response['message'] = "Group and its Player Data has been deleted successfully";
                return json_encode($response);
            } else {
                $response['success'] = 0;
                $response['message'] = "You are not owner of this group";
                return json_encode($response);
            }
        } else {
            $response['success'] = 0;
            return json_encode($response);
        }
    }
}
