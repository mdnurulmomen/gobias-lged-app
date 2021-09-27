<?php

namespace App\Http\Controllers\AuditPlan\Plan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanEditorController extends Controller
{

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loadAuditTeamModal(Request $request)
    {
        $data = Validator::make($request->all(), [
            'activity_id' => 'required|integer',
            'annual_plan_id' => 'required|integer',
            'fiscal_year_id' => 'required|integer',
            'audit_plan_id' => 'required|integer',
        ])->validate();

        $activity_id = $request->activity_id;
        $annual_plan_id = $request->annual_plan_id;
        $fiscal_year_id = $request->fiscal_year_id;
        $audit_plan_id = $request->audit_plan_id;
        $own_office = $this->current_office()['office_name_bn'];
        $officer_lists = $this->cagDoptorOfficeUnitDesignationEmployees($this->current_office_id());

        //for all team data
        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);
        $teamResponseData = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.get_audit_plan_wise_team'), $data)->json();

        $nominated_offices = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_annual_plan_revised.ap_nominated_offices'), $data)->json();
        $nominated_offices_list = json_decode($nominated_offices['data']['nominated_offices'],true);
        $all_teams = isSuccess($teamResponseData)?$teamResponseData['data']:[];

//        dd($nominated_offices_list);

        return view('modules.modal.load_team_modal', compact('activity_id',
            'annual_plan_id', 'fiscal_year_id', 'audit_plan_id',
            'officer_lists', 'own_office','all_teams','nominated_offices_list'));
    }

    public function loadAuditTeamSchedule(Request $request)
    {
        $data = Validator::make($request->all(), [
            'annual_plan_id' => 'required|integer',
        ])->validate();

        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);
        $nominated_offices = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_annual_plan_revised.ap_nominated_offices'), $data)->json();
        $nominated_offices = $nominated_offices['data'];
        $team_layer_id = $request->team_layer_id;
        return view('modules.audit_plan.audit_plan.plan_revised.partials.load_team_schedule',
            compact('team_layer_id', 'nominated_offices'));
    }
}
