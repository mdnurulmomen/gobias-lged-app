<?php

namespace App\Http\Controllers\QualityControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuditQacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index($qac_type)
    {
        //dd($qac_type);
        if($qac_type=='qac-1'){
            $qac_type_name_bn = 'কিউএসি ১';
        }elseif ($qac_type=='qac-2'){
            $qac_type_name_bn = 'কিউএসি ২';
        }elseif ($qac_type=='cqat'){
            $qac_type_name_bn = 'সিকিউএটি';
        }else{
            $qac_type_name_bn = '';
        }

        $fiscal_years = $this->allFiscalYears();
        return view('modules.audit_quality_control.qac',compact('fiscal_years',
            'qac_type','qac_type_name_bn'));
    }

    public function loadApottiQacList(Request $request){
        $data = Validator::make($request->all(), [
            'fiscal_year_id' => 'required|integer',
            'qac_type' => 'required',
        ])->validate();

        $data['cdesk'] = $this->current_desk_json();
        $apotti_list = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_conduct_query.apotti.list'), $data)->json();

//        dd($apotti_list);
        $qac_type =  $request->qac_type;

        if (isSuccess($apotti_list)) {
            $apotti_list = $apotti_list['data'];
            return view('modules.audit_quality_control.qac_apotti_list',
                compact('apotti_list','qac_type'));
        } else {
            return response()->json(['status' => 'error', 'data' => $apotti_list]);
        }
    }

    public function loadAirWiseApottiList(Request $request){
        $qac_type = $request->qac_type;
        $requestData['qac_type'] = $qac_type;
        $requestData['air_id'] = $request->air_id;
        $requestData['cdesk'] =$this->current_desk_json();
        $responseData = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_report.air.get_air_wise_audit_apotti_list'), $requestData)->json();
        $responseData = isSuccess($responseData)?$responseData['data']:[];
        $current_designation_id = $this->current_designation_id();
        return view('modules.audit_quality_control.qac_apotti_list',compact('responseData',
            'qac_type','current_designation_id'));
    }

    public function qacCommittee($qac_type){
        $fiscal_years = $this->allFiscalYears();
//        dd($qac_type);
        return view('modules.audit_quality_control.qac_committee.qac_committee',compact('fiscal_years',
            'qac_type'));
    }

    public function getQacCommitteeList(Request $request){
//        dd($request->all());
        $fiscal_year_id = $request->fiscal_year_id;
        $qac_type = $request->qac_type;
        $data['fiscal_year_id'] = $fiscal_year_id;
        $data['qac_type'] = $qac_type;
        $data['cdesk'] =$this->current_desk_json();
        $response = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_quality_control.qac.get_qac_committee_list'), $data)->json();
//        dd($response);
        if (isSuccess($response)) {
            $committee_list = $response['data'];
            return view('modules.audit_quality_control.qac_committee.get_qac_committee',compact('committee_list','fiscal_year_id','qac_type'));
        } else {
            return response()->json(['status' => 'error', 'data' => $response['data']]);
        }
    }

    public function createQacCommittee(){
        $officer_lists = $this->cagDoptorOfficeUnitDesignationEmployees($this->current_office_id());
        return view('modules.audit_quality_control.qac_committee.create_qac_committee',compact('officer_lists'));
    }

    public function storeQacCommittee(Request $request){
        $data = Validator::make($request->all(), [
            'fiscal_year_id' => 'required|integer',
            'qac_type' => 'required',
            'member_info' => 'required',
            'title' => 'required',
        ])->validate();

        $data['cdesk'] =$this->current_desk_json();

        $response = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_quality_control.qac.store_qac_committee'), $data)->json();

        if (isSuccess($response)) {
            $response = $response['data'];
            return response()->json(['status' => 'success', 'data' => $response]);
        } else {
            return response()->json(['status' => 'error', 'data' => $response]);
        }
    }

    public function selectQacCommitteeForm(Request $request){
        $data = Validator::make($request->all(), [
            'fiscal_year_id' => 'required|integer',
            'air_report_id' => 'required|integer',
            'qac_type' => 'required|string',
        ])->validate();

        $data['cdesk'] =$this->current_desk_json();

        $response = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_quality_control.qac.get_qac_committee_list'), $data)->json();

//        dd($response);

        if (isSuccess($response)) {
            $committee_list = $response['data'];
            $fiscal_year_id = $request->fiscal_year_id;
            $air_report_id = $request->air_report_id;
            $qac_type = $request->qac_type;
            return view('modules.audit_quality_control.qac_committee.select_committee_form',compact('committee_list','fiscal_year_id','qac_type','air_report_id'));
        } else {
            return response()->json(['status' => 'error', 'data' => $response['data']]);
        }

//        return view('modules.audit_quality_control.select_committee_form',compact('data',));

    }

    public function getQacCommitteeWiseMembers(Request $request){

        $data = Validator::make($request->all(), [
            'qac_committee_id' => 'required|integer',
        ])->validate();

        $data['cdesk'] =$this->current_desk_json();

        $response = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_quality_control.qac.get_qac_committee_wise_member'), $data)->json();

//        dd($response);

        if (isSuccess($response)) {
            $member_list = $response['data'];
            return view('modules.audit_quality_control.qac_committee.committee_wise_member_table',compact('member_list'));
        } else {
            return response()->json(['status' => 'error', 'data' => $response['data']]);
        }
    }

    public function submitAirWiseCommittee(Request $request){
//        dd($request->all());
        $data = Validator::make($request->all(), [
            'fiscal_year_id' => 'required|integer',
            'qac_type' => 'required',
            'air_report_id' => 'required',
            'qac_committee_id' => 'required',
        ])->validate();

        $data['cdesk'] =$this->current_desk_json();

        $response = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_quality_control.qac.store_air_wise_committee'), $data)->json();

        if (isSuccess($response)) {
            $response = $response['data'];
            return response()->json(['status' => 'success', 'data' => $response]);
        } else {
            return response()->json(['status' => 'error', 'data' => $response]);
        }
    }

    public function createQacReport(Request $request){
//        dd($request->all());
        $qac_type = $request->qac_type;
        $air_id = $request->air_id;
        $scope = $request->scope;
        $requestData['qac_type'] = $qac_type;
        $requestData['air_id'] = $air_id;

        $requestData['cdesk'] =$this->current_desk_json();

        $responseData = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_report.air.get_air_wise_audit_apotti_list'), $requestData)->json();
        $committee = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_quality_control.qac.get_air_wise_committee'), $requestData)->json();

        $responseData = isSuccess($responseData)?$responseData['data']:[];
        $committeeData = isSuccess($committee)?$committee['data']:[];

        $directorateName = $this->current_office()['office_name_bn'];
        if ($this->current_office_id() == 14){
            $directorateAddress = 'অডিট কমপ্লেক্স (৩য় তলা) <br> সেগুনবাগিচা,ঢাকা-১০০০।';
            $directorateWebsite = 'www.worksaudit.org.bd';
        }
        elseif ($this->current_office_id() == 3){
            $directorateAddress = 'অডিট কমপ্লেক্স (২য় তলা) <br> সেগুনবাগিচা,ঢাকা-১০০০।';
            $directorateWebsite = 'www.dgcivil-cagbd.org';
        }
        else{
            $directorateAddress = 'অডিট কমপ্লেক্স (৮ম তলা) <br> সেগুনবাগিচা,ঢাকা-১০০০।';
            $directorateWebsite = 'www.cad.org.bd';
        }

//        dd($responseData);

        if($request->scope == 'pdf'){
//            return view('modules.audit_quality_control.qac_apotti_report',compact('responseData',
//                'qac_type','committeeData'));
            $pdf = \PDF::loadView('modules.audit_quality_control.qac_apotti_report', ['responseData' => $responseData,'committeeData'=> $committeeData,'qac_type' => $qac_type,'scope' => $scope,'directorateName' => $directorateName,'directorateAddress' => $directorateAddress,'directorateWebsite' => $directorateWebsite], [], ['orientation' => 'L', 'format' => 'A4']);
            return $pdf->stream('qac_report.pdf');
        }else{
//            dd($responseData);
            return view('modules.audit_quality_control.qac_apotti_report',compact('responseData',
                'qac_type','committeeData','air_id','scope','directorateName','directorateAddress','directorateWebsite'));
        }


    }

    public function exportQacReport(Request $request)
    {
        $qac_type = $request->qac_type;
        $requestData['qac_type'] = $qac_type;
        $requestData['air_id'] = $request->air_id;

        $requestData['cdesk'] =$this->current_desk_json();

        $responseData = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_report.air.get_air_wise_audit_apotti_list'), $requestData)->json();
        $committee = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_quality_control.qac.get_air_wise_committee'), $requestData)->json();

        $responseData = isSuccess($responseData)?$responseData['data']:[];
        $committeeData = isSuccess($committee)?$committee['data']:[];
//        dd($responseData);
        $current_designation_id = $this->current_designation_id();
        return view('modules.audit_quality_control.qac_apotti_report',compact('responseData',
            'qac_type','current_designation_id','committeeData'));

        if (isSuccess($plan_infos)) {
            $plan_infos = $plan_infos['data'];
            $pdf = \PDF::loadView('modules.audit_plan.annual.annual_plan_revised.partials.annual_plan_book', ['plan_infos' => $plan_infos,'directorate_address'=> $directorate_address], [], ['orientation' => 'L', 'format' => 'A4']);
            return $pdf->stream('annual_plan.pdf');
        } else {
            return response()->json(['status' => 'error', 'data' => $plan_infos]);
        }
    }

    public function qacApotti(Request $request){
        $data = Validator::make($request->all(), [
            'apotti_id' => 'required|integer',
            'qac_type' => 'required',
        ])->validate();

        $apotti_id = $request->apotti_id;
        $qac_type = $request->qac_type;
        $air_report_id = $request->air_report_id;
        $is_delete = $request->is_delete;

        $data['cdesk'] = $this->current_desk_json();
        $qac_apotti_status = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_quality_control.qac.get_qac_apotti_status'), $data)->json();
        //dd($qac_apotti_status);
        if (isSuccess($qac_apotti_status)) {
            $qac_apotti_status = $qac_apotti_status['data'];
            return view('modules.audit_quality_control.qac_apotti_form',compact('apotti_id','qac_apotti_status','qac_type','air_report_id','is_delete'));

        } else {
            return response()->json(['status' => 'error', 'data' => $qac_apotti_status]);
        }
    }

    public function qacApottiSubmit(Request $request){
//        dd($request->all());

        Validator::make($request->all(), [
            'apotti_id' => 'required|integer',
            'apotti_type' => 'required',
        ])->validate();

        $data = [
            'cdesk' => $this->current_desk_json(),
            'apotti_type' => $request->apotti_type,
            'qac_type' => $request->qac_type,
            'is_same_porishisto' => $request->is_same_porishisto ?? 0,
            'is_rules_and_regulation' => $request->is_rules_and_regulation ?? 0,
            'is_imperfection' => $request->is_imperfection ?? 0,
            'is_risk_analysis' => $request->is_risk_analysis ?? 0,
            'is_broadsheet_response' => empty($request->is_broadsheet_response)?0:$request->is_broadsheet_response,
            'apotti_id' => $request->apotti_id,
            'comment' => $request->comment,
        ];

//        dd($data);

        $apotti_submit = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_quality_control.qac.qac_apotti_submit'), $data)->json();

//        dd($apotti_submit);

        if (isSuccess($apotti_submit)) {
            $apotti_submit = $apotti_submit['data'];
            return response()->json(['status' => 'success', 'data' => $apotti_submit]);
        } else {
            return response()->json(['status' => 'error', 'data' => $apotti_submit]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
