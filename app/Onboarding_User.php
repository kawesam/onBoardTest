<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Onboarding_User extends Model
{
    //
    protected $table = 'onboarding_users';

    protected $fillable = ['user_id','onboarding_percentage','count_applications','count_accepted_applications'];


}
