<div class="mt-5 table-responsive">
    <table class="table table-bordered" width="100%">
        <thead>
        <tr>
            <th width="5%">
                <input type="checkbox" id="checkAllApottis">
            </th>
            <th style="text-align: center" width="10%">অনুচ্ছেদ নং</th>
            <th style="text-align: left" width="75%">শিরোনাম</th>
            <th style="text-align: right" width="10%">জড়িত টাকা</th>
        </tr>
        </thead>
        <tbody>
        @foreach($apottiData['auditMapApottis'] as $apotti)
            <tr>
                <td><input type="checkbox" checked class="apotti" value="{{$apotti['apotti_map_list']['id']}}" name="apotti"></td>
                <td style="text-align: center">{{enTobn($apotti['apotti_map_list']['onucched_no'])}}.</td>
                <td style="text-align: left;margin-left: 5px">{{$apotti['apotti_map_list']['apotti_title']}}</td>
                <td style="text-align: right">{{enTobn(number_format($apotti['apotti_map_list']['total_jorito_ortho_poriman'],0))}}/-</td>
            </tr>
        @endforeach

        @foreach($apottiData['auditApottis'] as $apotti)
            <tr>
                <td><input type="checkbox"  class="apotti" value="{{$apotti['id']}}" name="apotti"></td>
                <td style="text-align: center">{{enTobn($apotti['onucched_no'])}}.</td>
                <td style="text-align: left;margin-left: 5px">{{$apotti['apotti_title']}}</td>
                <td style="text-align: right">{{enTobn(number_format($apotti['total_jorito_ortho_poriman'],0))}}/-</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <button class="btn btn-primary" onclick="Audit_Apotti_Container.setAuditApotti()">সংরক্ষণ করুন</button>
</div>


<script>
    $("#checkAllApottis").click(function(){
        $("input[name='apotti']").not(this).prop('checked', this.checked);
    });

    var Audit_Apotti_Container = {
        setAuditApotti: function () {
            var all_apottis = [];
            $.each($("input[name='apotti']"), function(){
                all_apottis.push($(this).val());
            });
            $("#auditAllApottis").val(all_apottis);

            var apottis = [];
            $.each($("input[name='apotti']:checked"), function(){
                apottis.push($(this).val());
            });

            $("#auditApottis").val(apottis);
            $('.air_report_save').click();

            if (apottis.length > 0) {
                Audit_Apotti_Container.setAuditApottiSummary(apottis);
                Audit_Apotti_Container.setAuditApottiDetails(apottis);
                toastr.success('সফলভাবে আপত্তিসমূহ সংরক্ষণ করা হয়েছে');
            }
        },

        setAuditApottiSummary: function (apottis) {
            url = '{{route('audit.report.air.get-audit-apotti')}}';
            apotti_view_scope = 'summary';
            let data = {apotti_view_scope,apottis};
            ajaxCallAsyncCallbackAPI(url, data, 'POST', function (response) {
                if (response.status === 'error') {
                    toastr.error(response.data);
                } else {
                    $('.audit_apotti_summary').html(response);
                    Insert_AIR_Data_Container.setJsonContentFromPlanBook();
                }
            });
        },

        setAuditApottiDetails: function (apottis) {
            url = '{{route('audit.report.air.get-audit-apotti')}}';
            apotti_view_scope = 'details';
            let data = {apotti_view_scope,apottis};
            ajaxCallAsyncCallbackAPI(url, data, 'POST', function (response) {
                if (response.status === 'error') {
                    toastr.error(response.data);
                } else {
                    $('.audit_apotti_details').html(response);
                    Insert_AIR_Data_Container.setJsonContentFromPlanBook();
                }
            });
        },
    }

</script>
