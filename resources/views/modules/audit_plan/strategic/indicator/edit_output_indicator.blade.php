<x-title-wrapper-return area="#kt_content" title="Back To Lists"
                        url="{{route('audit.plan.operational.activity.all')}}">
    Edit Output Indicator
</x-title-wrapper-return>
<div class="mt-4 px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="select_fiscal_year" class="col-form-label">Duration <span class="text-danger">(*)</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend w-50">
                                        <input type="text" class="form-control rounded-0" value="" placeholder="start year" required>
                                    </div>
                                    <div class="input-group-append w-50">
                                        <input type="text" class="form-control rounded-0" value="" placeholder="end year" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="select_strategic_outcome" class="col-form-label">Strategic Outcome
                                    :</label>
                                <select class="form-control rounded-0 select-select2" id="select_strategic_outcome"
                                        name="strategic_outcome">
                                    <option value="">Choose Outcome</option>
                                    {{-- @foreach($strategic_outcomes as $strategic_outcome)
                                        <option
                                            value="{{$strategic_outcome['id']}}">{{$strategic_outcome['outcome_no']}}</option>
                                    @endforeach --}}
                                </select>
                                <div class="mt-3">
                                    <p id="outcome_remarks_area"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select_strategic_outcome" class="col-form-label">Name English
                                    :</label>
                                    <input type="text" class="form-control rounded-0" placeholder="Name English" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select_strategic_outcome" class="col-form-label">Name Bangla
                                    :</label>
                                    <input type="text" class="form-control rounded-0" placeholder="Name Bangla" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select_strategic_outcome" class="col-form-label">Frequency English
                                    :</label>
                                    <input type="text" class="form-control rounded-0" placeholder="Frequency English" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select_strategic_outcome" class="col-form-label">Frequency Bangla
                                    :</label>
                                    <input type="text" class="form-control rounded-0" placeholder="Frequency Bangla" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select_strategic_outcome" class="col-form-label">DataSource English
                                    :</label>
                                    <input type="text" class="form-control rounded-0" placeholder="DataSource English" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select_strategic_outcome" class="col-form-label">DataSource Bangla
                                    :</label>
                                    <input type="text" class="form-control rounded-0" placeholder="DataSource Bangla" />
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="select_fiscal_year" class="col-form-label">Base Fiscal Year :</label>
                                <select class="form-control rounded-0 select-select2" id="select_fiscal_year"
                                        name="fiscal_year_id">
                                    <option value="">Base Fiscal Year</option>
                                    {{-- @foreach($fiscal_years as $fiscal_year)
                                        <option value="{{$fiscal_year['id']}}">{{$fiscal_year['description']}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select_strategic_outcome" class="col-form-label">Base Value:</label>
                                    <input type="text" class="form-control rounded-0" placeholder="Base Value" />
                            </div>
                        </div>

             <div class="col-md-4">
                            <div class="form-group">
                                <label for="status" class="col-form-label">Status:</label>
                                <input class="form-check-input form-control" type="checkbox" value="" id="status">
                            </div>
                        </div>


                        <div class="col-md-2 mt-md-12">
                            <button class="btn btn-icon btn-light-success btn-square mr-2 search_activities"
                                    onclick="Audit_Activities_Container.createAnnualActivityAreaData()"
                                    type="button"><i class="fad fa-search"></i></button>
                            <button class="btn btn-icon btn-light-danger btn-square mr-2 reset_strategic_area"
                                    onclick="Audit_Activities_Container.resetStrategicSearchFields()"
                                    type="reset"><i
                                    class="fad fa-recycle"></i></button>
                        </div>
                    </div>
                    <div class="row" id="">
                        <div class="col-md-12">
                            <h3>Create Activities</h3>
                            <hr>
                            <div class="create_activity_area">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal id="op_activity_modal" title="Create Operation Activity"
         url="{{route('audit.plan.operational.activity.store')}}" method="post">
    <form id="op_activity_form">
        <div class="form-group row">
            <label for="activity_no" class="col-3 col-form-label">Activity No</label>
            <div class="col-9">
                <input placeholder="Activity No" class="form-control" type="text" value=""
                       id="activity_no" name="activity_no"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="title_en" class="col-3 col-form-label">Title English</label>
            <div class="col-9">
                <input placeholder="Title English" class="form-control" type="text" value=""
                       id="title_en" name="title_en"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="title_bn" class="col-3 col-form-label">Title Bangla</label>
            <div class="col-9">
                <input placeholder="Title Bangla" class="form-control" type="text" value=""
                       id="title_bn" name="title_bn"/>
            </div>
        </div>

        <input type="hidden" name="output_id" class="output_id" value="">
        <input type="hidden" name="outcome_id" class="outcome_id" value="">
        <input type="hidden" name="fiscal_year_id" class="fiscal_year_id" value="">
        <input type="hidden" name="activity_parent_id" class="activity_parent_id" value="">
    </form>
</x-modal>

<x-modal id="op_activity_milestone_modal" title="Create Operation Activity Milestone"
         url="{{route('audit.plan.operational.activity.milestone.store')}}" method="post" size="lg">
    <form id="op_activity_milestone_form">
        <div class="form-group" id="milestone_add_area">
            <div class="form-group row">
                <label for="title_en" class="col-3 col-form-label">Title English</label>
                <div class="col-9">
                    <input placeholder="Title English" class="form-control" type="text" value=""
                           id="title_en" name="title_en"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="title_bn" class="col-3 col-form-label">Title Bangla</label>
                <div class="col-9">
                    <input placeholder="Title Bangla" class="form-control" type="text" value=""
                           id="title_bn" name="title_bn"/>
                </div>
            </div>
        </div>

        <input type="hidden" name="output_id" class="output_id" value="">
        <input type="hidden" name="outcome_id" class="outcome_id" value="">
        <input type="hidden" name="fiscal_year_id" class="fiscal_year_id" value="">
        <input type="hidden" name="activity_id" class="activity_id" value="">
    </form>
</x-modal>


<script>
    $('#btn_op_activity_modal_save').click(function () {
        url = $(this).data('url');
        data = $('#op_activity_form').serialize();
        method = $(this).data('method');
        submit = submitModalData(url, data, method, 'op_activity_modal')
    });

</script>


{{-- @include('scripts.script_audit_plan_operational_activity')
@include('scripts.script_generic') --}}