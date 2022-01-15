<x-title-wrapper>Data Collection Office Order List</x-title-wrapper>

<div class="table-search-header-wrapper pt-3 pb-3">
    <div class="col-xl-12">
        <form>
            <div class="m-0 form-group row">
                <label for="select_fiscal_year_annual_plan" class="col-sm-1 col-form-label font-size-1-1">অর্থ বছর</label>
                <div class="col-sm-11">
                    <select class="form-control select-select2" name="fiscal_year" id="select_fiscal_year_annual_plan">
                        <option value="">--সিলেক্ট--</option>
                        @foreach($fiscal_years as $fiscal_year)
                            <option
                                value="{{$fiscal_year['id']}}" {{now()->year == $fiscal_year['end']?'selected':''}}>{{$fiscal_year['description']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom card-stretch">
    <div class="card-body p-0">
        <div class="load-office-orders"></div>
    </div>
</div>


<script>
    $(function () {
        Office_Order_Container_Dc.loadOfficeOrderList();
    });

    $('#select_fiscal_year_annual_plan').change(function () {
        Office_Order_Container_Dc.loadOfficeOrderList();
    });

    var Office_Order_Container_Dc = {
        loadOfficeOrderList: function (page = 1, per_page = 200) {
            let fiscal_year_id = $('#select_fiscal_year_annual_plan').val();
            if (fiscal_year_id) {
                let url = '{{route('audit.plan.audit.office-orders-dc.load-office-order-list')}}';
                let data = {fiscal_year_id, page, per_page};
                ajaxCallAsyncCallbackAPI(url, data, 'POST', function (response) {
                    if (response.status === 'error') {
                        toastr.error(response.data);
                    } else {
                        $('.load-office-orders').html(response);
                    }
                });
            }
            else {
                $('.load-office-orders').html('');
            }
        },

        loadOfficeOrderCreateForm: function (element) {
            url = '{{route('audit.plan.audit.office-orders-dc.load-office-order-create')}}';
            audit_plan_id = element.data('audit-plan-id');
            annual_plan_id = element.data('annual-plan-id');

            data = {audit_plan_id,annual_plan_id};

            KTApp.block('#kt_content', {
                opacity: 0.1,
                state: 'primary' // a bootstrap color
            });

            ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                KTApp.unblock('#kt_content');
                if (response.status === 'error') {
                    toastr.error('No data found');
                }
                else {
                    $(".offcanvas-title").text('অফিস আদেশ');
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

        showOfficeOrder: function (elem) {
            url = '{{route('audit.plan.audit.office-orders-dc.show-office-order')}}';
            audit_plan_id = elem.data('audit-plan-id');
            annual_plan_id = elem.data('annual-plan-id');
            data = {audit_plan_id,annual_plan_id}
            ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                if (response.status === 'error') {
                    toastr.error(response.data)
                } else {
                    $('#kt_content').html(response)
                }
            });
        },

        loadOfficeOrderApprovalAuthority: function (element) {
            url = '{{route('audit.plan.audit.office-orders-dc.load-office-order-approval-authority')}}';
            ap_office_order_id = element.data('ap-office-order-id');
            audit_plan_id = element.data('audit-plan-id');
            annual_plan_id = element.data('annual-plan-id');
            data = {ap_office_order_id,audit_plan_id,annual_plan_id};

            KTApp.block('#kt_content', {
                opacity: 0.1,
                state: 'primary' // a bootstrap color
            });

            ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                KTApp.unblock('#kt_content');
                if (response.status === 'error') {
                    toastr.error('No data found');
                } else {
                    $(".offcanvas-title").text('অনুমোদনকারী বাছাই করুন');
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

        saveOfficeOrderApprovalAuthority: function () {
            url = '{{route('audit.plan.audit.office-orders-dc.store-office-order-approval-authority')}}';
            data = $('#approval_authority_form').serialize();
            ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                if (response.status === 'success') {
                    toastr.success('সফলভাবে প্রেরণ করা হয়েছে');
                    $('#kt_quick_panel_close').click();
                    $('.dc-office-order a').click();
                    // Office_Order_Container_Dc.loadOfficeOrderList();
                }
                else {
                    if (response.statusCode === '422') {
                        var errors = response.msg;
                        $.each(errors, function (k, v) {
                            if (v !== '') {
                                toastr.error(v);
                            }
                        });
                    }
                    else {
                        toastr.error(response.data.message);
                    }
                }
            })
        },

        approveOfficeOrder: function (element) {
            url = '{{route('audit.plan.audit.office-orders-dc.approve-office-order')}}';
            fiscal_year_id = $('#select_fiscal_year_annual_plan').val();
            ap_office_order_id = element.data('ap-office-order-id');
            audit_plan_id = element.data('audit-plan-id');
            annual_plan_id = element.data('annual-plan-id');
            approved_status = 'approved';
            data = {ap_office_order_id,audit_plan_id,annual_plan_id,approved_status,fiscal_year_id};

            ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                if (response.status === 'success') {
                    toastr.success('Successfully Approved!');
                    Office_Order_Container_Dc.loadOfficeOrderList();
                }
                else {
                    if (response.statusCode === '422') {
                        var errors = response.msg;
                        $.each(errors, function (k, v) {
                            if (v !== '') {
                                toastr.error(v);
                            }
                        });
                    }
                    else {
                        toastr.error(response.data.message);
                    }
                }
            });
        },
    }
</script>
