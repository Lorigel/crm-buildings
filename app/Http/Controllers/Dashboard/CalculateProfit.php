<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

/**
 * Author: Lorigela Karaj
 * Email: lorigela@gmail.com
 */
class CalculateProfit extends Controller
{
    protected $contract;

    public function __construct($contract)
    {
        $this->contract = $contract;
    }

    public function calculate()
    {
        $general_contractor_percentage = $this->generalContractorPercentage();
        $agent_profit = $this->calculateAgentProfit();
        
        return [
            'general_contractor_percentage' => $general_contractor_percentage,
            'agent_percentage' => $this->getAgentPercentage(),
            'agent_profit' => $agent_profit
        ];
    }

    protected function generalContractorPercentage()
    {
        $general_contractor = User::find($this->contract->general_contractor);
        return $general_contractor->profit;
    }

    protected function calculateAgentProfit()
    {
        $percentage = $this->getAgentPercentage();
        $total_profit = round(((6 * $this->contract->amount ) / 100), 2);
        $agent_profit = round((($percentage * $total_profit) / 100), 2);

        return $agent_profit;
    }

    protected function getAgentPercentage()
    {
        $agent = User::find($this->contract->user_id);
        if($agent->hasRole('master') || $agent->hasRole('admin') || $agent->hasRole('supervisor')){
            return 100;
        }
        if($agent->hasRole('manager')){
            return 90;
        }
        if($agent->hasRole('cordinator')){
            return 80;
        }
        if($agent->hasRole('senior')){
            return 70;
        }
        if($agent->hasRole('junior')){
            return 60;
        }

    }
}
