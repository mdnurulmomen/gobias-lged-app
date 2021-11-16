<?php

namespace App\Http\Controllers\AuditPlan\Plan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RevisedPlanController extends Controller
{
    public function index()
    {
        $fiscal_years = $this->allFiscalYears();
        return view('modules.audit_plan.audit_plan.plan_revised.audit_plan', compact('fiscal_years'));
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function showAuditablePlanLists(Request $request)
    {
        $data = Validator::make($request->all(), [
            'fiscal_year_id' => 'required|integer',
            'per_page' => 'required|integer',
            'page' => 'required|integer',
        ])->validate();
        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);
        $all_entities = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.ap_entity_lists'), $data)->json();
        if (isSuccess($all_entities)) {
            $all_entities = $all_entities['data'];
            return view('modules.audit_plan.audit_plan.plan_revised.partials.load_plan_lists',
                compact('all_entities'));
        } else {
            return response()->json(['status' => 'error', 'data' => $all_entities]);
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createAuditPlan(Request $request)
    {
        $data = Validator::make($request->all(), [
            'activity_id' => 'required|integer',
            'annual_plan_id' => 'required|integer',
            'fiscal_year_id' => 'required|integer',
        ])->validate();

        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);

        if ($this->current_office_id() == 19){
            $directorate_address_footer = 'অডিট কমপ্লেক্স,১ম তলা,সেগুনবাগিচা,ঢাকা-1000।';
            $directorate_address_top = 'অডিট কমপ্লেক্স,১ম তলা <br> সেগুনবাগিচা,ঢাকা-1000।';
            $directorate_website = 'www.dgcivil-cagbd.org';
        }
        elseif ($this->current_office_id() == 32){
            $directorate_address_footer = 'অডিট কমপ্লেক্স (নিচ তলা ও ২য় তলা),সেগুনবাগিচা,ঢাকা-1000।';
            $directorate_address_top = 'অডিট কমপ্লেক্স (নিচ তলা ও ২য় তলা) <br> সেগুনবাগিচা,ঢাকা-1000।';
            $directorate_website = 'www.worksaudit.org.bd';
        }
        else{
            $directorate_address_footer = 'অডিট কমপ্লেক্স (৭ম-৮ম তলা),সেগুনবাগিচা,ঢাকা-1000।';
            $directorate_address_top = 'অডিট কমপ্লেক্স (৭ম-৮ম তলা) <br> সেগুনবাগিচা,ঢাকা-1000।';
            $directorate_website = 'www.cad.org.bd';
        }


        $audit_plan = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.ap_entity_plan_create_draft'), $data)->json();
        if (isSuccess($audit_plan)) {
            $audit_plan = $audit_plan['data'];
            //$parent_office_data = $this->initRPUHttp()->post(config('cag_rpu_api.get-office-other-info'), ['office_id' => $audit_plan['annual_plan']['parent_office_id']])->json();
            $parent_office_data = []; //isSuccess($parent_office_data) ? $parent_office_data['data'] : [];
            $parent_office_content = (is_array($parent_office_data) && !empty($parent_office_data)) ? json_encode($parent_office_data['content_list']) : json_encode([]);
            $activity_id = $request->activity_id;
            $fiscal_year_id = $request->fiscal_year_id;
            $annual_plan_id = $request->annual_plan_id;
            $parent_office_id = $audit_plan['annual_plan']['parent_office_id'];
            $content = $audit_plan['plan_description'];
            $cover_info = [
                'directorate_address_footer' => $directorate_address_footer,
                'directorate_address_top' => $directorate_address_top,
                'directorate_website' => $directorate_website,
                'created_by' => $this->getEmployeeInfo()['name_bng'].',<br>'.$this->current_office()['designation'],
                'directorate_name' => $this->current_office()['office_name_bn'],
                'party_name' => $audit_plan['annual_plan']['controlling_office_bn'],
                'entity_name' => $audit_plan['annual_plan']['parent_office_name_bn'],
                'entity_office_type' => $audit_plan['annual_plan']['office_type'],
                'fiscal_year' => enTobn($audit_plan['annual_plan']['fiscal_year']['start']) . ' - ' . enTobn($audit_plan['annual_plan']['fiscal_year']['end']).' অর্থ বছর।',
            ];
            //dd($cover_info);
            return view('modules.audit_plan.audit_plan.plan_revised.create_entity_audit_plan', compact('activity_id', 'annual_plan_id', 'audit_plan',
                'parent_office_id', 'content', 'cover_info', 'fiscal_year_id', 'parent_office_content'));
        } else {
            return ['status' => 'error', 'data' => $audit_plan];
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateAuditPlan(Request $request)
    {
        $data = Validator::make($request->all(), [
            'audit_plan_id' => 'required|integer',
            'fiscal_year_id' => 'required|integer',
            'annual_plan_id' => 'required|integer',
        ])->validate();

        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);

        $audit_plan = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.ap_entity_plan_edit_draft'), $data)->json();

        if (isSuccess($audit_plan)) {
            $audit_plan = $audit_plan['data'];
            $parent_office_id = $audit_plan['annual_plan']['parent_office_id'];
            $content = json_decode(gzuncompress(getDecryptedData($audit_plan['plan_description'])));
            $activity_id = $audit_plan['activity_id'];
            $annual_plan_id = $audit_plan['annual_plan_id'];
            $fiscal_year_id = $request->fiscal_year_id;
            return view('modules.audit_plan.audit_plan.plan_revised.edit_entity_audit_plan', compact('activity_id', 'annual_plan_id',
                'audit_plan', 'content', 'fiscal_year_id','parent_office_id'));
        } else {
            return ['status' => 'error', 'data' => $audit_plan];
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveDraftEntityAuditPlan(Request $request): \Illuminate\Http\JsonResponse
    {
        Validator::make($request->all(), [
            'activity_id' => 'required|integer',
            'annual_plan_id' => 'required|integer',
            'audit_plan_id' => 'sometimes|integer',
            'plan_description' => 'required',
        ])->validate();

        if ($request->has('audit_plan_id') && $request->audit_plan_id > 0) {
            $data['audit_plan_id'] = $request->audit_plan_id;
        }
        $data['activity_id'] = $request->activity_id;
        $data['annual_plan_id'] = $request->annual_plan_id;
        $data['plan_description'] = makeEncryptedData(gzcompress(json_encode($request->plan_description)));
        $data['status'] = 'approved';
        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);
        $save_draft = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.ap_entity_plan_make_draft'), $data)->json();
        if (isSuccess($save_draft)) {
            return response()->json(['status' => 'success', 'data' => $save_draft['data']]);
        } else {
            return response()->json(['status' => 'error', 'data' => $save_draft]);
        }
    }

    public function printAuditPlan(Request $request)
    {
        $plans = $request->plan;
        $cover = $plans[0];
        array_shift($plans);
        $index = $plans[0];
        array_shift($plans);
        return view('modules.audit_plan.audit_plan.plan_revised.partials.audit_plan_book_print', compact('plans', 'cover', 'index'));
    }

    public function generatePlanPDF(Request $request)
    {
        $plans = $request->plan;
        $cover = $plans[0];
        array_shift($plans);

        $formThree = $plans[26];
        $porishisto = $plans[28];
        unset($plans[26],$plans[28]);

        //dd($plans);
        $pdf = \PDF::loadView('modules.audit_plan.audit_plan.plan_revised.partials.audit_plan_book',
            compact('plans', 'cover','formThree','porishisto'));

        /*$pdf = \PDF::loadView('modules.audit_plan.audit_plan.plan_revised.partials.audit_plan_book',
            ['plans' => $plans, 'cover' => $cover], [], ['orientation' => 'L', 'format' => 'A4']);*/
        return $pdf->stream('document.pdf');
    }


    public function storeAuditTeam(Request $request)
    {
        $data = Validator::make($request->all(), [
            'activity_id' => 'required|integer',
            'fiscal_year_id' => 'required|integer',
            'annual_plan_id' => 'required|integer',
            'audit_plan_id' => 'required|integer',
            'audit_year_start' => 'required',
            'audit_year_end' => 'required',
            'teams' => 'required',
        ])->validate();

        $teams = json_encode_unicode($request->teams);
        $data['teams'] = json_encode(['teams' => json_decode($teams)], JSON_UNESCAPED_UNICODE);
        $data['approve_status'] = 'approved';
        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);

        $responseData = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.store_audit_team'), $data)->json();

        if (isSuccess($responseData)) {
            return response()->json(['status' => 'success', 'data' => $responseData['data']]);
        } else {
            return ['status' => 'error', 'data' => $responseData];
        }
    }

    public function updateAuditTeam(Request $request)
    {
        $data = Validator::make($request->all(), [
            'activity_id' => 'required|integer',
            'fiscal_year_id' => 'required|integer',
            'annual_plan_id' => 'required|integer',
            'audit_plan_id' => 'required|integer',
            'audit_year_start' => 'required',
            'audit_year_end' => 'required',
            'teams' => 'required',
        ])->validate();

//        dd($data);

        $teams = json_encode_unicode($request->teams);
        $data['teams'] = json_encode(['teams' => json_decode($teams)], JSON_UNESCAPED_UNICODE);
        $data['approve_status'] = 'approved';
        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);

        $responseData = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.update_audit_team'), $data)->json();

        if (isSuccess($responseData)) {
            return response()->json(['status' => 'success', 'data' => $responseData['data']]);
        } else {
            return ['status' => 'error', 'data' => $responseData];
        }
    }

    public function storeAuditTeamSchedule(Request $request)
    {
        $data = Validator::make($request->all(), [
            'audit_plan_id' => 'required|integer',
            'team_schedules' => 'required|json',
        ])->validate();
        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);

        $responseData = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.store_audit_team_schedule'), $data)->json();
        if (isSuccess($responseData)) {
            return response()->json(['status' => 'success', 'data' => $responseData['data']]);
        } else {
            return ['status' => 'error', 'data' => $responseData];
        }
    }

    public function updateAuditTeamSchedule(Request $request)
    {
        $data = Validator::make($request->all(), [
            'audit_plan_id' => 'required|integer',
            'team_schedules' => 'required|json',
        ])->validate();
        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);

        $responseData = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.update_audit_team_schedule'), $data)->json();
        if (isSuccess($responseData)) {
            return response()->json(['status' => 'success', 'data' => $responseData['data']]);
        } else {
            return ['status' => 'error', 'data' => $responseData];
        }
    }

    public function getSubTeam(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = Validator::make($request->all(), [
            'team_id' => 'required|integer',
        ])->validate();

        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);

        $sub_team = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.get_sub_team'), $data)->json();
        if (isSuccess($sub_team)) {
            return response()->json(['status' => 'error', 'data' => $sub_team['data']]);
        } else {
            return response()->json(['status' => 'error', 'data' => $sub_team]);
        }
    }

    public function getTeamInfo(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = Validator::make($request->all(), [
            'team_id' => 'required|integer',
        ])->validate();

        $data['cdesk'] = json_encode($this->current_desk(), JSON_UNESCAPED_UNICODE);

        $team_info = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_entity_plan.get_team_info'), $data)->json();
        //dd($team_info);
        if (isSuccess($team_info)) {
            return response()->json(['status' => 'error', 'data' => $team_info['data']]);
        } else {
            return response()->json(['status' => 'error', 'data' => $team_info]);
        }
    }

}
