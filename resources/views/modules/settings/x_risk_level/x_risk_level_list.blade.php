<x-title-wrapper>Risk Level</x-title-wrapper>
<div class="card sna-card-border d-flex flex-wrap flex-row">
    <div class="col-xl-12 text-right">
        <button type="button" class="font-weight-bolder font-size-sm mr-3 btn btn-success btn-sm btn-bold btn-square btn_create_risk_level">
            <i class="far fa-plus mr-1"></i> Create Risk Level
        </button>
    </div>
</div>

<div class="card sna-card-border mt-2">
    <div class="table-responsive load-table-data" data-href="{{ route('settings.risk-levels.list') }}">
    </div>
</div>

<script>
     $(function () {
        loadData();
        
        $('.btn_create_risk_level').click(function () {
            
            url = "{{ route('settings.risk-levels.create') }}";
            
            data = {};
    
            KTApp.block('#kt_wrapper', {
                opacity: 0.1,
                state: 'primary' // a bootstrap color
            });
    
            ajaxCallAsyncCallbackAPI(url, data, 'GET', function (response) {
                KTApp.unblock('#kt_wrapper');
                if (response.status === 'error') {
                    toastr.error('Server Error');
                } else {
                    $(".offcanvas-title").text('Auditability Level Score');
                    quick_panel = $("#kt_quick_panel");
                    quick_panel.addClass('offcanvas-on');
                    quick_panel.css('opacity', 1);
                    quick_panel.css('width', '50%');
                    quick_panel.removeClass('d-none');
                    $("html").addClass("side-panel-overlay");
                    $(".offcanvas-wrapper").html(response);
                    // loadData();
                }
            });
        });
    });

    function loadData() {
        url = $(".load-table-data").data('href');
        var data = {};
        ajaxCallAsyncCallbackAPI(url, data, 'GET', function (resp) {
            if (resp.status === 'error') {
                toastr.error('no');
                console.log(resp.data)
            } else {
                $(".load-table-data").html(resp);
            }
        });
    }
</script>

@include('scripts.script_generic')
