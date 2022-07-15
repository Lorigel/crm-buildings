<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Contract;
/**
 * Author: Lorigela Karaj
 */
class Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'total' => $this->countContracts(),
            'not_approved' => $this->countContracts('cancelled'),
            'open' => $this->countContracts(null, ['cancelled', 'pending', 'finished']),
            'finished' => $this->countContracts('finished')
        ]);
    }

    protected function countContracts($status = null, $statuses = null)
    {
        $user = Auth::user();
        $contracts = Contract::orderByDesc('created_at');
        
        if($user->canApproveContract()){
            $contracts = $contracts;
        }
        elseif($user->hasRole('technic')){
            $contracts = $contracts->where('technic', $user->id)->whereNotNull('verified_at');
        }
        elseif($user->hasRole('company')){
            $contracts = $contracts->where('company', $user->id)->whereNotNull('verified_at');
        }
        elseif($user->hasRole('general-contractor')){
            $contracts = $contracts->where('general_contractor', $user->id)->whereNotNull('verified_at');
        }
        else{
            $contracts = $contracts->whereNotNull('verified_at')->whereHas('user', function($query) use($user)
            {
                $query->where('assigned_to', $user->id);
            })->orWhere('user_id', $user->id);
        }

        if($status){
            $contracts = $contracts->where('status', $status);
        }

        if($statuses){
            $contracts = $contracts->whereNotIn('status', $statuses);
        }
        return $contracts->count();
    }
}
