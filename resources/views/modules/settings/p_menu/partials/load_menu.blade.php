<!--begin::Table-->
<div class="table-responsive">
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th class="text-left">Menu</th>
            <th class="text-left">Module Menu</th>
            <th class="text-left">Parent Menu</th>
            <th class="text-left">Display Order</th>
            <th class="text-left">Menu Class</th>
            <th class="text-left">Menu Icon</th>
            <th class="text-left">Menu Link</th>
            <th  class="text-left" width="10%">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($allMenu['data'] as $menu)
            <tr>
                <td>{{$menu['menu_name_en']}}</td>
                <td>{{$menu['module_menu']['module_name_en']??''}}</td>
                <td>{{$menu['parent']['menu_name_en']??''}}</td>
                <td>{{$menu['display_order']}}</td>
                <td>{{$menu['menu_class']}}</td>
                <td>{{$menu['menu_icon']}}</td>
                <td>{{$menu['menu_link']}}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button title="হালনাগাদ করুন" class="btn btn-icon btn-square btn-sm btn-light btn-hover-icon-danger btn-icon-primary"
                                data-menu-id="{{$menu['id']}}"
                                onclick="Menu_Container.editMenu($(this))">
                            <i class="fad fa-edit"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<!--end::Table-->
