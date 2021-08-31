<x-title-wrapper>Add Settings</x-title-wrapper>

@include('modules.audit_plan.strategic.settings.partial.style_common')

<div class="col-lg-12">
    <!--begin::Advance Table Widget 4-->
    <div class="card card-custom card-stretch gutter-b">
        <!--begin::Body-->
        <div class="card-body">
            <form id="sp_file_form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label">
                                Plan For <span class="text-danger">(*)</span>
                            </label>
                            <select class="form-control" name="fiscal_year">
                                @foreach($plan_durations as $plan_duration)
                                    <option value="{{'FY '.$plan_duration['start_year'].' - '.'FY '.$plan_duration['end_year']}}">
                                        {{'FY '.$plan_duration['start_year'].' - '.'FY '.$plan_duration['end_year']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div id="appendSection">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Add Section
                            <span class="fa fa-plus-circle btn_section_add"></span>
                        </legend>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-label">Key<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="keys[]" placeholder="Enter key">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="info_section_data_bn" class="input-label">Value</label>
                                    <textarea class="summernote form-control" name="values[]"></textarea>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </div>

                <a id="submit_form" class="btn btn-success btn-sm btn-bold btn-square btn_create_milestone">
                    <i class="fas fa-save"></i> Save
                </a>
            </form>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Advance Table Widget 4-->
</div>
<script type="text/javascript">

    //for office submit form
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit_form').on('click', function(e){
            e.preventDefault();

            $.ajax({
                data: new FormData(document.getElementById("sp_file_form")),
                url: "{{route('audit.plan.strategy.sp_file_store')}}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (responseData) {
                    if (responseData.status === 'success') {
                        toastr.success(responseData.data);
                    }
                    else {
                        if (responseData.statusCode === '422') {
                            var errors = responseData.msg;
                            $.each(errors, function (k, v) {
                                if (v !== '') {
                                    toastr.error(v);
                                }
                            });
                        }
                        else {
                            toastr.error(responseData.data);
                        }
                    }
                },
                error: function (responseData) {
                    toastr.error(responseData.msg);
                }
            });
        });
    });
</script>

@include('modules.audit_plan.strategic.settings.partial.script_common')
