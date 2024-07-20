<?php

namespace App;

use App\Models\Policy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Policycheck
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function pv($policyName) {
        $userId = Session::get('userId');
        $thePolicy = Policy::where('policyName', $policyName)->first();

        $isPolicy = DB::SELECT("SELECT * FROM policy_users WHERE user_id=? AND policy_id=?", [$userId, $thePolicy->id]);

        if(count($isPolicy) == 0) {
            return false;
        }
        else {
            return true;
        }
    }
}
