<x-title-wrapper>Annual Audit Calender</x-title-wrapper>
<div class="mt-4 px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="example-preview">
                                <ul class="nav nav-tabs custom-tabs mb-0" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active rounded-0" id="activity" data-toggle="tab"
                                           href="#set_activity">
                                            <span class="nav-text">Schedule Milestones</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="calender" data-toggle="tab" href="#set_calendar"
                                           aria-controls="profile">
                                            <span class="nav-text">Calender View</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="print" data-toggle="tab" href="#print_view"
                                           aria-controls="contact">
                                            <span class="nav-text">Print View</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="operational_calendar_tab">
                                    <div class="tab-pane border border-top-0 p-3 fade show active" id="set_activity"
                                         role="tabpanel" aria-labelledby="activity-tab">
                                        @include('modules.audit_plan.operational.audit_calendar.tab_pan.schedule_milestones', ['fiscal_years' => $fiscal_years, 'responsible_offices' => $responsible_offices])
                                    </div>

                                    <div class="tab-pane fade border border-top-0 p-3" id="set_calendar" role="tabpanel"
                                         aria-labelledby="calender-tab">
                                        @include('modules.audit_plan.operational.audit_calendar.tab_pan.view_calender', ['data' => 'dynamic data array'])
                                    </div>

                                    <div class="tab-pane fade border border-top-0 p-3" id="print_view" role="tabpanel"
                                         aria-labelledby="print_view-tab">
                                        @include('modules.audit_plan.operational.audit_calendar.tab_pan.print_view', ['data' => 'dynamic data array'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
