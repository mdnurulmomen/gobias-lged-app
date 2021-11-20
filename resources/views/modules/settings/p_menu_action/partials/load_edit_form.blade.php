<form autocomplete="off" id="menu_action_update_form">
    <input type="hidden" name="menu_action_id" value="{{$menuActionInfo['id']}}">
    <input type="hidden" name="type" value="{{$type}}" id="pageType">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_en">Name En<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="title_en" name="title_en"
                       value="{{$menuActionInfo['title_en']}}"
                       placeholder="Enter name en">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_bn">Name Bn<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="title_bn" name="title_bn"
                       value="{{$menuActionInfo['title_bn']}}"
                       placeholder="Enter name bn">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="parent_id">Parent</label>
                <select class="form-control select-select2" id="parent_id" name="parent_id">
                    <option value="">Select</option>
                    @foreach($menuActionList as $menuAction)
                        <option value="{{$menuAction['id']}}" {{$menuActionInfo['parent_id'] == $menuAction['id']?'selected':''}}>
                            {{$menuAction['title_bn']}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="link">Module Link</label>
                <input class="form-control" type="text" id="link" name="link"
                       value="{{$menuActionInfo['link']}}"
                       placeholder="Enter link">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="controller">Module Controller</label>
                <input class="form-control" type="text" id="controller" name="controller"
                       value="{{$menuActionInfo['controller']}}"
                       placeholder="Enter controller">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="method_name">Method</label>
                <input class="form-control" type="text" id="method_name" name="method_name"
                       value="{{$menuActionInfo['method']}}" placeholder="Enter method">
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="class">Class</label>
                <input class="form-control" type="text" id="class" name="class"
                       value="{{$menuActionInfo['class']}}"
                       placeholder="Enter class">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="icon">Icon</label>
                <input class="form-control" type="text" id="icon" name="icon"
                       value="{{$menuActionInfo['icon']}}"
                       placeholder="Enter icon">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="display_order">Display Order<span class="text-danger">*</span></label>
                <input class="form-control integer_type_positive" type="text" id="display_order" name="display_order"
                       value="{{$menuActionInfo['display_order']}}"
                       placeholder="Enter display order">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="is_other_module">Other Module</label>
                <select class="form-control select-select2" id="is_other_module" name="is_other_module">
                    <option value="1" {{$menuActionInfo['is_other_module'] == 1?'selected':''}}>Yes</option>
                    <option value="0" {{$menuActionInfo['is_other_module'] == 0?'selected':''}}>No</option>
                </select>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="javascript:;" role="button" onclick="Menu_Action_Container.updateMenuAction()"
           class="btn btn-primary btn-sm btn-square btn-forward">
            <i class="fa fa-save"></i>
            Update
        </a>
    </div>
</form>