<x-title-wrapper>Memo Lists</x-title-wrapper>

<div class="col-md-12">
    <div class="d-flex justify-content-end">
        <a class="btn btn-primary btn-sm btn-bold btn-square"
           onclick="Memo_List_Container.sentMemoListToRpu()"
           href="javascript:;">
            <i class="far fa-share mr-1"></i> Sent To RPU
        </a>

        <a class="btn btn-success btn-sm btn-bold btn-square"
           data-schedule-id="{{$schedule_id}}"
           onclick="Memo_List_Container.createMemo($(this))"
           href="javascript:;">
            <i class="far fa-plus mr-1"></i> Create Memo
        </a>
    </div>
</div>


<div class="px-3" id="load_memo_lists"></div>

<script>
    var Memo_List_Container = {
        loadMemoList: function (page = 1, per_page = 10) {
            audit_plan_id = '{{$audit_plan_id}}';
            cost_center_id = '{{$cost_center_id}}';
            let url = '{{route('audit.execution.memo.list')}}';
            let data = {audit_plan_id,cost_center_id,page, per_page};
            ajaxCallAsyncCallbackAPI(url, data, 'POST', function (response) {
                if (response.status === 'error') {
                    toastr.error(response.data)
                } else {
                    $('#load_memo_lists').html(response);
                }
            });
        },

        createMemo: function (elem) {
            schedule_id = elem.data('schedule-id');
            data = {schedule_id};
            let url = '{{route('audit.execution.memo.create')}}'
            ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                if (response.status === 'error') {
                    toastr.error(response.data)
                } else {
                    $('#kt_content').html(response)
                }
            });
        },

        editMemo: function (elem) {
            memo_id = elem.data('memo-id');
            data = {memo_id};
            let url = '{{route('audit.execution.memo.edit')}}'
            ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                if (response.status === 'error') {
                    toastr.error(response.data)
                } else {
                    $('#kt_content').html(response)
                }
            });
        },

        sentMemoListToRpu: function () {
            memos = [];
            $(".select-memo").each(function (i, value) {
                if ($(this).is(':checked') && !$(this).is(':disabled')) {
                    memos.push($(this).val());
                }
            });

            console.log(memos);

            if (!memos) {
                toastr.warning('Please Select Query');
                return;
            }

            url = '{{route('audit.execution.memo.sent-to-rpu')}}';
            data = {memos};

            KTApp.block('#kt_content', {
                opacity: 0.1,
                state: 'primary' // a bootstrap color
            });

            ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                KTApp.unblock('#kt_content');
                if (response.status === 'error') {
                    toastr.warning(response.data)
                } else {
                    toastr.success(response.data)
                }
            })
        },
    };

    $(function () {
        Memo_List_Container.loadMemoList();
    });
</script>
