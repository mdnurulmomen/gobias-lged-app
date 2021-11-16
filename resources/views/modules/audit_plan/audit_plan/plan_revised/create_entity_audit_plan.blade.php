@extends('layouts.full_width')
@section('styles')
    <style>
        .tox-tinymce {
            height: 78vh !important;
            font-size: 11px !important;
        }

        .tox-notification.tox-notification--in.tox-notification--warning {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <script src="{{asset('assets/plugins/global/tinymce.min.js')}}" referrerpolicy="origin"></script>
    <div class="row m-0 page-title-wrapper d-md-flex align-items-md-center">
        <div class="col-md-6">
            <div class="title py-2">
                <h4 class="mb-0 font-weight-bold">
                    <a href="{{route('audit.plan.audit.index')}}">
                        <i title="Back To Audit Plan" class="fad fa-backward mr-3"></i>
                    </a>
                    Create Audit Plan
                </h4>
            </div>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-sm btn-square btn-primary btn-hover-primary"
                    data-parent-office-id="{{$parent_office_id}}"
                    onclick="Create_Entity_Plan_Container.showTeamCreateModal($(this));">
                <i class="fas fa-users"></i> Team
            </button>

            <button class="btn btn-sm btn-square btn-warning btn-hover-warning"
                    data-parent-office-id="{{$parent_office_id}}"
                    onclick="Create_Entity_Plan_Container.riskAssessment($(this));">
                <i class="fas fa-ballot-check"></i> Risk Assessment
            </button>

            <button class="btn btn-sm btn-square btn-info btn-hover-info"
                    onclick="Create_Entity_Plan_Container.previewAuditPlan()">
                <i class="fas fa-eye"></i> Preview
            </button>

            <button class="btn btn-sm btn-square btn-success btn-hover-success draft_entity_audit_plan"
                    data-activity-id="{{$activity_id}}"
                    data-annual-plan-id="{{$annual_plan_id}}"
                    onclick="Create_Entity_Plan_Container.draftEntityPlan($(this))">
                <i class="fas fa-save"></i> Save
            </button>
        </div>
    </div>

    <div class="split" id="splitWrapper">
        <div id="split-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="p-5">
                        <div class="input-group mb-5">
                        </div>
                        <div class="mt-5">
                            {{--<h3>Audit list</h3>--}}
                        </div>
                        <!---JS tree start---->
                        <div id="createPlanJsTree" class="mt-5">
                        </div>
                        <!---JS tree end---->
                        <div class="form-group mt-5">
                            {{--<input class="form-control rounded-0" type="text" name="" id="searchPlaneField"
                                   placeholder="Search"/>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="split-1">
            <textarea id="kt-tinymce-1" name="kt-tinymce-1" class="kt-tinymce-1"></textarea>
        </div>
        <div id="split-2" class="d-none">
            <div id="writing-screen-wrapper" style="font-family:SolaimanLipi,serif !important;">
            </div>
        </div>
    </div>

    <div class="load-office-wise-employee"></div>
    <div class="load-audit-schedule"></div>

@endsection
@section('scripts')
    @if($audit_plan['audit_type'] == 'compliance')
        @include('scripts.audit_plan.create.script_create_entity_compliance_audit_plan')
    @elseif($audit_plan['audit_type'] == 'planning')
        @include('scripts.audit_plan.create.script_create_entity_compliance_audit_plan')
    @endif

    <script>
        var Create_Entity_Plan_Container = {
            showTeamCreateModal: function (elem) {
                url = '{{route('audit.plan.audit.editor.load-audit-team-modal')}}';
                annual_plan_id = '{{$annual_plan_id}}';
                activity_id = '{{$activity_id}}';
                fiscal_year_id = '{{$fiscal_year_id}}';
                parent_office_id = elem.data('parent-office-id');
                audit_plan_id = $(".draft_entity_audit_plan").data('audit-plan-id');
                data = {annual_plan_id, activity_id, fiscal_year_id, audit_plan_id,parent_office_id};
                KTApp.block('.content', {
                    opacity: 0.1,
                    state: 'primary' // a bootstrap color
                });
                ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                    KTApp.unblock('.content');
                    if (response.status === 'error') {
                        toastr.error('No data found');
                    } else {
                        $(".load-office-wise-employee").html(response)
                        $('#officeEmployeeModal').modal('show');
                    }
                })

            },

            draftEntityPlan: function (elem) {
                url = '{{route('audit.plan.audit.revised.plan.save-draft-entity-audit-plan')}}';

                plan_description = JSON.stringify(templateArray);
                activity_id = elem.data('activity-id');
                annual_plan_id = elem.data('annual-plan-id');
                audit_plan_id = elem.data('audit-plan-id');

                data = {plan_description, activity_id, annual_plan_id, audit_plan_id};
                ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                    if (response.status === 'success') {
                        if (!audit_plan_id) {
                            $('.draft_entity_audit_plan').attr('data-audit-plan-id', response.data);
                        }
                        toastr.success('Audit Plan Saved Successfully');
                    } else {
                        toastr.error('Not Saved');
                        console.log(response)
                    }
                })
            },


            previewAuditPlan: function () {
                $('.draft_entity_audit_plan').click();
                plan = templateArray;
                data = {plan};
                url = '{{route('audit.plan.audit.revised.plan.preview-audit-plan')}}';

                KTApp.block('#kt_content', {
                    opacity: 0.1,
                    state: 'primary' // a bootstrap color
                });

                ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                    KTApp.unblock('#kt_content');
                    if (response.status === 'error') {
                        toastr.error('No data found');
                    } else {
                        $(".offcanvas-title").text('অডিট প্ল্যান');
                        quick_panel = $("#kt_quick_panel");
                        quick_panel.addClass('offcanvas-on');
                        quick_panel.css('opacity', 1);
                        quick_panel.css('width', '40%');
                        quick_panel.removeClass('d-none');
                        $("html").addClass("side-panel-overlay");
                        $(".offcanvas-wrapper").html(response);
                    }
                });
            },

            generatePDF: function () {
                //$('.draft_entity_audit_plan').click();
                url = '{{route('audit.plan.audit.revised.plan.generate-audit-plan-pdf')}}';
                plan = templateArray;
                data = {plan};

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function (response) {
                        var blob = new Blob([response]);
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "audit_plan.pdf";
                        link.click();
                    },
                    error: function (blob) {
                        toastr.error('Failed to generate PDF.')
                        console.log(blob);
                    }
                });
            },

            riskAssessment: function (elem) {
                quick_panel = $("#kt_quick_panel");
                $('.offcanvas-wrapper').html('');
                quick_panel.addClass('offcanvas-on');
                quick_panel.css('opacity', 1);
                quick_panel.css('width', '800px');
                $('.offcanvas-footer').hide();
                quick_panel.removeClass('d-none');
                $("html").addClass("side-panel-overlay");
                $('.offcanvas-title').html('Risk Assessment');

                url = '{{route('audit.plan.audit.editor.load-risk-assessment-list')}}';
                annual_plan_id = '{{$annual_plan_id}}';
                activity_id = '{{$activity_id}}';
                fiscal_year_id = '{{$fiscal_year_id}}';
                parent_office_id = elem.data('parent-office-id');
                audit_plan_id = $(".draft_entity_audit_plan").data('audit-plan-id');
                data = {annual_plan_id, activity_id, fiscal_year_id, audit_plan_id,parent_office_id};
                KTApp.block('.content', {
                    opacity: 0.1,
                    state: 'primary' // a bootstrap color
                });
                ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                    KTApp.unblock('.content');
                    if (response.status === 'error') {
                        toastr.error('No data found');
                    } else {
                        $(".offcanvas-wrapper").html(response);
                    }
                })

            },
        };

        $('.draft_entity_audit_plan').click();
    </script>
@endsection
