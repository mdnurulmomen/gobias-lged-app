<x-title-wrapper>Audit Activities</x-title-wrapper>
<div class="col-lg-12">
    <!--begin::Advance Table Widget 4-->
    <div class="card card-custom card-stretch gutter-b">
        <!--begin::Header-->
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Stats</span>
            </h3>
            <div class="card-toolbar">
                <x-toolbar-button class="btn btn-success btn-sm btn-bold btn-square btn_create_audit_activity"
                                  href="{{route('audit.plan.operational.activity.create')}}">
                    <i class="far fa-plus mr-1"></i> Create Annual Audit Activity
                </x-toolbar-button>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-0 pb-3">
            <!--begin::Table-->
            <div class="table-responsive datatable datatable-default datatable-bordered datatable-loaded">

                <table class="datatable-bordered datatable-head-custom datatable-table"
                       id="kt_datatable"
                       style="display: block;">

                    <thead class="datatable-head">
                    <tr class="datatable-row" style="left: 0px;">
                        <th class="datatable-cell datatable-cell-sort">
                            Fiscal Year
                        </th>

                        <th class="datatable-cell datatable-cell-sort">
                            Strategic Outcome Count
                        </th>

                        <th class="datatable-cell datatable-cell-sort">
                            Strategic Output Count
                        </th>

                        <th class="datatable-cell datatable-cell-sort">
                            Activities Count
                        </th>

                        <th class="datatable-cell datatable-cell-sort">
                            Milestone Count
                        </th>

                        <th class="datatable-cell datatable-cell-sort">
                            <i class="fas fa-eye"></i></th>

                        <th class="datatable-cell datatable-cell-sort">
                            <i class="fas fa-trash-alt"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody style="" class="datatable-body">
                    <tr data-row="0" class="datatable-row" style="left: 0px;">
                        <td class="datatable-cell text-center"><span>2021-2022</span></td>
                        <td class="datatable-cell text-center"><span>2</span></td>
                        <td class="datatable-cell text-center"><span>2</span></td>
                        <td class="datatable-cell text-center"><span>32</span></td>
                        <td class="datatable-cell text-center"><span>66</span></td>

                        <td class="datatable-cell text-center">
                            <a href="javascript:;"
                               data-url="{{route('audit.plan.operational.activity.single')}}"
                               class="mr-1 btn btn-icon btn-square btn-sm btn-light btn-hover-icon-danger btn-icon-primary btn_view_audit_annual_activity">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td class="datatable-cell text-center">
                            <a href="javascript:;"
                               data-url="{{route('audit.plan.operational.activity.edit')}}"
                               class="mr-1 btn btn-icon btn-square btn-sm btn-light btn-hover-icon-danger btn-icon-primary btn_edit_audit_annual_activity">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <!--end::Table-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Advance Table Widget 4-->
</div>

@include('scripts.script_audit_plan_operational_activity')
