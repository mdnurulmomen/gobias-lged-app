<table class="table table-striped">
    <thead class="thead-light">
    <tr class="datatable-row" style="left: 0px;">
        <th class="datatable-cell datatable-cell-sort">
            Start Year
        </th>
        <th class="datatable-cell datatable-cell-sort">
            End Year
        </th>

        <th class="datatable-cell datatable-cell-sort text-center" colspan="2">
            Action
        </th>

    </tr>
    </thead>
    <tbody style="" class="datatable-body">
    @forelse($plan_durations as $plan_duration)
        <tr data-row="{{$loop->iteration}}" class="datatable-row" style="left: 0px;">
            <td class="datatable-cell"><span>{{$plan_duration['start_year']}}</span></td>
            <td class="datatable-cell"><span>{{$plan_duration['end_year']}}</span></td>
            <td class="datatable-cell text-right" width="5%">
                <a href="javascript:;"
                   data-duration-id="{{$plan_duration['id']}}"
                   data-duration-start="{{$plan_duration['start_year']}}"
                   data-duration-end="{{$plan_duration['end_year']}}"
                   data-duration-remarks="{{$plan_duration['remarks']}}"
                   data-url="{{route('settings.strategic-plan.duration.update', ['duration' => $plan_duration['id']])}}"
                   data-method="PUT"
                   class="mr-1 btn btn-icon btn-square btn-sm btn-light btn-hover-icon-danger btn-icon-primary btn_edit_plan_duration">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
            <td class="datatable-cell text-left" width="5%">
                <a href="javascript:;"
                   data-duration-id="{{$plan_duration['id']}}"
                   data-url="{{route('settings.strategic-plan.duration.destroy', ['duration' => $plan_duration['id']])}}"
                   class="btn btn-icon btn-outline-danger btn-xs border-0 mr-2 delete_plan_duration">
                    <i class="fal fa-trash-alt"></i>
                </a>
            </td>
        </tr>
    @empty
        <tr data-row="0" class="datatable-row" style="left: 0px;">
            <td colspan="4" class="datatable-cell text-center"><span>Nothing Found</span></td>
        </tr>
    @endforelse
    </tbody>
</table>

<script>
    $('.btn_edit_plan_duration').click(function () {
        $('#plan_duration_modal_title').text('Update ' + $(this).data('duration-start') + ' - ' + $(this).data('duration-start'));
        $('#btn_plan_duration_modal_save').text('Update');
        $('#btn_plan_duration_modal_save').data('url', $(this).data('url'));
        $('#btn_plan_duration_modal_save').data('method', $(this).data('method'));
        $('#plan_duration_id').val($(this).data('duration-id'));
        $('#end_plan_duration').val($(this).data('duration-end'));
        $('#start_plan_duration').val($(this).data('duration-start'));
        $('#remarks').val($(this).data('duration-remarks'));
        $('#plan_duration_modal').modal('show');
    });

    $('.delete_plan_duration').click(function () {
        url = $(this).data('url');
        submitModalData(url, {}, 'delete', 'plan_duration_modal');
    });
</script>
