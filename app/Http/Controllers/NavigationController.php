<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Onboarding_User;
use Illuminate\Support\Facades\DB;


class NavigationController extends Controller
{
    //
    public function selectJob(Request $request)
    {
        //increase the step to 40%
        $user = self::getUser();

        if($user){
            $user->onboarding_percentage = 40;
            $user ->save();
        }
        return view('jobs');
    }

    public function selectExperience(Request $request){
        //increase the step to 50%
        $user = self::getUser();

        if($user){
            $user->onboarding_percentage = 50;
            $user ->save();
        }
        return view('experience');
    }

    public function isFreelancer(Request $request){
        $user = self::getUser();
        if($user){
            $user->onboarding_percentage = 70;
            $user ->save();
        }
        return view('freelancer');
    }

    public function successCompletion(Request $request){

       $user = self::getUser();
        if($user){
            $user->onboarding_percentage = 90;
            $user ->save();
        }
        return view('completion');

    }

    //add 1% as users wait for approval
    public function approveAccount(){
        $user = self::getUser();
        if($user){
            $user->onboarding_percentage = 99;
            $user->save();
        }
        return view('approval');

    }

    //show the graph
    public function showOnboardingReport(){
        $now = Carbon::now();
        //$users_step_report = Onboarding_User::all();
        $query = Onboarding_User::query()
            ->select(DB::raw('COUNT(IF(onboarding_percentage = 0, 1, NULL)) as account_create'), DB::raw('COUNT(IF(onboarding_percentage = 20, 1, NULL))as activation'),
                DB::raw('COUNT(IF(onboarding_percentage = 40, 1, NULL)) as profile'), DB::raw('COUNT(IF(onboarding_percentage = 50, 1, NULL)) as jobs'),
                DB::raw('COUNT(IF(onboarding_percentage = 70, 1, NULL)) as experience'), DB::raw('COUNT(IF(onboarding_percentage = 90, 1, NULL)) as freelancer'),
                DB::raw('COUNT(IF(onboarding_percentage = 99, 1, NULL)) as waitingApp'),DB::raw('COUNT(IF(onboarding_percentage = 99, 1, NULL)) as approval'),
                DB::raw('WEEK(updated_at) as week'))
            ->groupBy('week')
            ->get()->toArray();

        if($query){
            $data['accounts'] = array_pluck($query,'account_create');
            $data['activations'] = array_pluck($query,'activation');
            $data['profiles']  = array_pluck($query,'profile');
            $data['jobs']  = array_pluck($query,'jobs');
            $data['experiences'] = array_pluck($query,'experience');
            $data ['freelancers'] = array_pluck($query,'freelancer');
            $data['waitingApps'] = array_pluck($query,'waitingApp');
            $data['approvals'] = array_pluck($query,'approval');
            $data ['weeks'] = array_pluck($query,'week');
        }else{
            $data['accounts'] = [0];
            $data['activations'] = [0];
            $data['profiles']  = [0];
            $data['jobs']  = [0];
            $data['experiences'] = [0];
            $data['freelancers'] = [0];
            $data['waitingApps'] = [0];
            $data['approvals'] = [0];
            $data['weeks'] = [0];
        }

        return json_encode($data);
    }

    public function showReports(){
        $reports = self::showOnboardingReport();

        return view('reports',compact('reports'));
    }

    //function to return teh logged in user onboarding
    public function getUser(){
        $user = Auth::id();
        $onboard_user = Onboarding_User::where('user_id', $user)->first();
        return $onboard_user;
    }
}
