<div class="row">
    <div class="col-md-{{ $view_grid }} {{$office_id ? 'd-none' : ''}}">
        <div class="form-group">
            <label for="layer_id">কাস্টম অফিস লেয়ার </label>
            <select id="layer_id" class="form-control rounded-0 select-select2"
                    name="layer_id">
                <option value="" selected="selected">--বাছাই করুন--</option>
                @foreach($custom_layers as $layer)
                    <option value="{{$layer['id']}}">{{$layer['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div style="display: none" class="col-md-{{ $view_grid }} {{$office_id ? 'd-none' : ''}}">
        <div class="form-group">
            <label for="office_layer_id">মন্ত্রণালয়/বিভাগ</label>
            <select name="office_layer" id="office_layer_id" class="form-control rounded-0 select-select2">
                <option value="0">--বাছাই করুন--</option>

            </select>
        </div>
    </div>
    <div id="custom_layer_div" style="display: none;" class="col-md-{{ $view_grid }} {{$office_id ? 'd-none' : ''}}">
        <div class="form-group">
            <label for="custom_layer_id">কাস্টম অফিস লেয়ার </label>
            <select id="custom_layer_id" class="form-control rounded-0 select-select2"
                    name="custom_layer_id">
                <option value="0">--বাছাই করুন--</option>

            </select>
        </div>
    </div>
    <div id="office_origin_div" style="display: none;" class="col-md-{{ $view_grid }} {{$office_id ? 'd-none' : ''}}">
        <div class="form-group">
            <label for="office_origin_id">দপ্তর / অধিদপ্তরের ধরন</label>
            <select name="office_origin" id="office_origin_id"
                    class="form-control rounded-0 select-select2">
                <option value="0">--বাছাই করুন--</option>

            </select>
        </div>
    </div>
    <div id="office_div" style="display: none;" class="col-md-{{ $view_grid }}">
        <div class="form-group">
            <label for="office_id">অফিস</label>
            <select id="office_id" class="form-control rounded-0 select-select2"
                    name="office_id" {{$office_id ? 'disabled' : ''}}>
                @if($office_id)
                    <option value="{{$office_id}}">{{Auth::user()->current_designation->office_name_bn}}</option>
                @else
                    <option value="0">--বাছাই করুন--</option>
                @endif
            </select>
        </div>
    </div>
    <div id="office_unit_div" style="display: none;" class="col-md-{{ $view_grid }}">
        <div class="form-group">
            <label for="office_unit_id">অফিস শাখা</label>
            <select id="office_unit_id" class="form-control rounded-0 select-select2" name="office_unit_id">
                <option value="0">--বাছাই করুন--</option>

            </select>
        </div>
    </div>

</div>

<script !src="">

    $("select#office_ministry_id").change(function () {
        var ministry_id = $(this).children("option:selected").val();
        loadLayer(ministry_id);
    });

    $("select#layer_id").change(function () {
        var layer_id = $(this).children("option:selected").val();
        if (layer_id == 1 || layer_id == 2) {
            $('#office_div').show();
            $('#custom_layer_div').hide();
            $('#office_origin_div').hide();
            $('#office_unit_div').hide();
            loadOfficeByLayer(layer_id);
            // loadOffice(custom_layer_id);
        } else if (layer_id == 3) {
            $('#custom_layer_div').show();
            $('#office_div').hide();
            $('#office_origin_div').hide();
            $('#office_unit_div').hide();
            loadOfficeCustomLayer(layer_id);
        } else if (layer_id == '') {
            $('#custom_layer_div').hide();
            $('#office_div').hide();
            $('#office_origin_div').hide();
            $('#office_unit_div').hide();
        } else {
            loadOfficeOrigin(layer_id);
            $('#office_div').hide();
            $('#office_origin_div').show();
            $('#custom_layer_div').hide();
            $('#office_unit_div').hide();
        }
    });

    function loadLayer(ministry_id) {
        var url = 'load_layer_ministry_wise';
        var data = {ministry_id};
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#office_layer_id").html(responseDate);
        });
    }

    function loadOfficeCustomLayer(office_layer_id) {
        var url = 'load_custom_layer_level_wise';
        var data = {office_layer_id};
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#custom_layer_id").html(responseDate);
        });
    }

    $("select#custom_layer_id").change(function () {
        var custom_layer_id = $(this).children("option:selected").val();
        loadOfficeCustomLayerWise(custom_layer_id);
    });

    function loadOfficeCustomLayerWise(custom_layer_id) {
        var url = 'load_office_custom_layer_wise';
        var data = {custom_layer_id};
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#office_div").show();
            $("#office_id").html(responseDate);
        });
    }

    $("select#office_layer_id").change(function () {
        var office_layer_id = $(this).children("option:selected").val();
        $('#office_layer').val(office_layer_id);
        loadOfficeOrigin(office_layer_id);
    });

    function loadOfficeOrigin(office_layer_id) {
        var url = 'load_office_origin_layer_level_wise';
        var data = {office_layer_id};
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#office_origin_id").html(responseDate);
        });
    }

    $("select#office_origin_id").change(function () {
        var office_origin_id = $(this).children("option:selected").val();
        $('#office_unit_div').hide();
        loadOffice(office_origin_id);
    });

    function loadOfficeByLayer(office_layer_id) {
        var url = 'load_office_layer_wise';
        var data = {office_layer_id};
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#office_id").html(responseDate);
        });
    }

    function loadOffice(office_origin_id) {
        var url = 'load_office_origin_wise';
        var data = {office_origin_id};
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#office_div").show();
            $("#office_id").html(responseDate);
        });
    }

    function loadOfficeUnit(office_id) {
        var url = 'load_unit_office_wise';
        var data = {office_id};
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#office_unit_div").show();
            $("#office_unit_id").html(responseDate);
        });
    }

    @if($office_id)
    $(document).ready(function () {
        $("#office_div").show();
        @if($only_office != 'true' && $is_unit_show == 'true')
        loadOfficeUnit({{$office_id}})
        @endif
    });
    @endif

    @if($is_unit_show == 'true')
    $("select#office_id").change(function () {
        var office_id = $(this).children("option:selected").val();
        loadOfficeUnit(office_id);
    });
    @endif
</script>
