<?php

namespace App\Http\Controllers\AuditPlan\AuditOperationalPlan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuditCalendarController extends Controller
{
    public function index()
    {
        $yearly_calendars = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_operational_plan.op_yearly_audit_calendar_lists'), ['all' => 1])->json();

        if ($yearly_calendars['status'] == 'success') {
            $yearly_calendars = $yearly_calendars['data'];
            return view('modules.audit_plan.operational.audit_calendar.audit_calendar_lists', compact('yearly_calendars'));
        } else {
            return response()->json(['status' => 'error', 'data' => $yearly_calendars]);
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show(Request $request)
    {
        Validator::make($request->all(), ['fiscal_year_id' => 'required|integer', 'yearly_audit_calendar_id' => 'required|integer',])->validate();
        $fiscal_year_id = $request->fiscal_year_id;
        $yearly_audit_calendar_id = $request->yearly_audit_calendar_id;

        $activity_calendars = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_operational_plan.op_calendar_all_lists'), ['fiscal_year_id' => $fiscal_year_id, 'yearly_calendar_id' => $yearly_audit_calendar_id])->json();
        $fiscal_year = $this->initHttpWithToken()->post(config('amms_bee_routes.settings.fiscal_year_show'), ['fiscal_year_id' => $fiscal_year_id])->json()['data'];

        if ($activity_calendars['status'] = 'success') {
            $activity_calendars = $activity_calendars['data'];
            return view('modules.audit_plan.operational.audit_calendar.view_audit_calendar', compact('activity_calendars', 'fiscal_year'));
        } else {
            return response()->json(['status' => 'error', 'data' => 'Sorry!']);
        }
    }

    public function edit(Request $request)
    {
        $fiscal_year_id = $request->fiscal_year_id;
        $yearly_audit_calendar_id = $request->yearly_audit_calendar_id;
        $fiscal_years = $this->allFiscalYears();
        $fiscal_year = $this->initHttpWithToken()->post(config('amms_bee_routes.settings.fiscal_year_show'), ['fiscal_year_id' => $fiscal_year_id])->json()['data'];
        $activity_calendars = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_operational_plan.op_calendar_all_lists'), ['fiscal_year_id' => $fiscal_year_id, 'yearly_calendar_id' => $yearly_audit_calendar_id])->json();
        $responsible_offices = $this->allResponsibleOffices();
        if ($activity_calendars['status'] = 'success') {
            $activity_calendars = $activity_calendars['data'];
            return view('modules.audit_plan.operational.audit_calendar.edit_audit_calendar', compact('fiscal_year', 'fiscal_years', 'activity_calendars', 'responsible_offices', 'fiscal_year_id'));
        } else {
            return response()->json(['status' => 'error', 'data' => 'Sorry!']);
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function showScheduleMilestoneByFiscalYear(Request $request)
    {
        Validator::make($request->all(), ['fiscal_year_id' => 'required|integer',])->validate();
        $fiscal_year_id = $request->fiscal_year_id;
        $activity_calendars = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_operational_plan.op_calendar_all_lists'), ['fiscal_year_id' => $fiscal_year_id])->json();
        if ($activity_calendars['status'] = 'success') {
            $activity_calendars = $activity_calendars['data'];
            return view('modules.audit_plan.operational.audit_calendar.partials.load_schedule_milestones', compact('activity_calendars'));
        } else {
            return response()->json(['status' => 'error', 'data' => 'Sorry!']);
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateMilestoneTargetDate(Request $request): \Illuminate\Http\JsonResponse
    {
        Validator::make($request->all(), ['yearly_audit_calendar_id' => 'required|integer', 'milestone_id' => 'required|integer', 'target_date' => 'required|date',])->validate();

        $data = ['target_date' => $request->target_date, "milestone_id" => $request->milestone_id, "yearly_audit_calendar_id" => $request->yearly_audit_calendar_id];

        $updateMilestoneDate = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_operational_plan.op_calendar_milestone_target_date_update'), $data)->json();

        if ($updateMilestoneDate['status'] = 'success') {
            return response()->json(['status' => 'success', 'data' => 'Updated!']);
        } else {
            return response()->json(['status' => 'error', 'data' => 'Sorry!']);
        }

    }

    public function createActivityResponsible(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = Validator::make($request->all(), ['activity_id' => 'required|integer', 'selected_office_ids' => 'required|array',])->validate();

        $addResponsibles = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_operational_plan.op_calendar_responsible_assign'), $data)->json();

        if ($addResponsibles['status'] == 'success') {
            return response()->json(['status' => 'success', 'data' => 'Successfully Added.']);
        } else {
            return response()->json(['status' => 'error', 'data' => $addResponsibles]);
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateActivityComment(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = Validator::make($request->all(), ['activity_id' => 'required|integer', 'comment_en' => 'nullable|string', 'comment_bn' => 'required|string',])->validate();

        $activityComment = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_operational_plan.op_calendar_comment_update'), $data)->json();

        if ($activityComment['status'] == 'success') {
            return response()->json(['status' => 'success', 'data' => $activityComment]);
        } else {
            return response()->json(['status' => 'error', 'data' => $activityComment]);
        }
    }

    public function showAuditCalendarView($fiscal_year_id)
    {
        $calendar_data = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_operational_plan.op_calendar_all_lists'), ['fiscal_year_id' => $fiscal_year_id])->json();


        if ($calendar_data['status'] = 'success') {
            $calendar_data = $calendar_data['data'];
            return view('modules.audit_plan.operational.audit_calendar.partials.load_view_calendar', compact('calendar_data',));
        } else {
            return response()->json(['status' => 'error', 'data' => 'Sorry!']);
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function showAuditCalendarPrintView(Request $request)
    {
        Validator::make($request->all(), ['fiscal_year' => 'required|integer',])->validate();
        $fiscal_year_id = $request->fiscal_year;
        $activity_calendars = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_operational_plan.op_calendar_all_lists'), ['fiscal_year_id' => $fiscal_year_id])->json();
        $fiscal_year = $this->initHttpWithToken()->post(config('amms_bee_routes.settings.fiscal_year_show'), ['fiscal_year_id' => $fiscal_year_id])->json()['data'];
        if ($activity_calendars['status'] = 'success') {
            $activity_calendars = $activity_calendars['data'];
            return view('modules.audit_plan.operational.audit_calendar.partials.load_audit_calendar_print_view', compact('activity_calendars', 'fiscal_year'));
        } else {
            return response()->json(['status' => 'error', 'data' => 'Sorry!']);
        }
    }

    public function showForwardAuditCalendarModal(Request $request)
    {
        $officer_lists = $this->officeUnitDesignationEmployeeMap($this->current_office_id());
        $audit_calendar_id = $request->audit_calendar_id;
        if ($officer_lists) {
            return view('modules.audit_plan.operational.audit_calendar.partials.forward_audit_calendar_modal', compact('officer_lists', 'audit_calendar_id'));
        } else {
            return response()->json(['status' => 'error', 'data' => $officer_lists]);
        }
    }

    public function forwardAuditCalendar(Request $request)
    {
        $designation_lists = $request->designation_to_forward;
        $designation_roles = $request->designation_role;
        $audit_calendar_master_id = $request->audit_calendar_id;
        $designations = [];

        foreach ($designation_lists as $designation_list) {
            foreach ($designation_roles as $designations_role) {
                $designation = explode('_', $designations_role);
                $designation_list_decoded = json_decode($designation_list, true);
                if ($designation[1] == $designation_list_decoded['designation_id']) {
                    $designations[] = [
                        'designation_id' => $designation_list_decoded['designation_id'],
                        'designation_en' => $designation_list_decoded['designation_en'],
                        'designation_bn' => $designation_list_decoded['designation_bn'],
                        'officer_name' => $designation_list_decoded['officer_name'],
                        'officer_id' => $designation_list_decoded['officer_id'],
                        'unit_id' => $designation_list_decoded['unit_id'],
                        'unit_name_en' => $designation_list_decoded['unit_name_en'],
                        'unit_name_bn' => $designation_list_decoded['unit_name_bn'],
                        'office_id' => $designation_list_decoded['office_id'],
                        'officer_type' => $designation[0],
                    ];
                }
            }
        }

        $data = [
            'designations' => json_encode($designations),
            'audit_calendar_master_id' => $audit_calendar_master_id,
            'sent_by' => $this->getOfficerId(),
        ];

        $move = $this->initHttpWithToken()->post(config('amms_bee_routes.audit_operational_plan.op_yearly_audit_calendar_movement_create'), $data)->json();
        dd($move);
    }
}
