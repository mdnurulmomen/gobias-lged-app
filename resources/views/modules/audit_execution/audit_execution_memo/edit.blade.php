<link rel="stylesheet" href="{{asset('assets/css/mFiler-font.css')}}" referrerpolicy="origin">
<link rel="stylesheet" href="{{asset('assets/css/mFiler.css')}}" referrerpolicy="origin">

<form id="memo_create_form" enctype="multipart/form-data" autocomplete="off">
    <div class="row p-4">
        <div class="col-md-8">
            <div class="d-flex justify-content-start">
                <h5 class="mt-5">{{$cost_center_name_bn}} (অর্থবছর : ২০২১-২০২২)</h5>
            </div>
        </div>

        <div class="col-md-4">
            <div class="d-flex justify-content-end">
                <a
                    onclick="Audit_Query_Schedule_Container.memo($(this))"
                    data-schedule-id="{{$schedule_id}}"
                    data-audit-plan-id="{{$audit_plan_id}}"
                    data-cost-center-id="{{$cost_center_id}}"
                    data-cost-center-name-bn="{{$cost_center_name_bn}}"
                    data-audit-year-start="{{$audit_year_start}}"
                    data-audit-year-end="{{$audit_year_end}}"
                    data-team-leader-name-bn="{{$team_leader_name}}"
                    data-team-leader-designation-name-bn="{{$team_leader_designation_name}}"
                    data-scope-sub-team-leader="{{$scope_sub_team_leader}}"
                    data-sub-team-leader-name-bn="{{$sub_team_leader_name}}"
                    data-sub-team-leader-designation-name-bn="{{$sub_team_leader_designation_name}}"
                    class="btn btn-sm btn-outline-warning btn_back btn-square mr-3">
                    <i class="fad fa-arrow-alt-left"></i> ফেরত যান
                </a>
                <a id="memo_submit" class="btn btn-success btn-sm btn-bold btn-square"
                   href="javascript:;">
                    <i class="far fa-save mr-1"></i> Update
                </a>
            </div>
        </div>
    </div>

    <div class="card card-custom card-stretch">
        <div class="card-body">
            <div class="row">
                <input type="hidden" value="{{$memoInfo['memo']['id']}}" name="memo_id">
                <input type="hidden" value="{{$schedule_id}}" name="schedule_id">

                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body p-4">
                                <label class="col-form-label">শিরোনাম<span class="text-danger">*</span></label>
                                <textarea class="form-control mb-1" name="memo_title_bn" placeholder="শিরোনাম লিখুন"
                                          cols="30" rows="2">{{$memoInfo['memo']['memo_title_bn']}}</textarea>

                                <label class="col-form-label">বিবরণ<span class="text-danger">*</span></label>
                                <textarea id="kt-tinymce-1" name="memo_description_bn"
                                          class="kt-tinymce-1">{{$memoInfo['memo']['memo_description_bn']}}</textarea>

                                <label class="col-form-label">অনিয়মের কারণ</label>
                                <textarea class="form-control mb-1" name="irregularity_cause" placeholder="অনিয়মের কারণ"
                                          cols="30" rows="2">{{$memoInfo['memo']['irregularity_cause']}}</textarea>


                                <label class="col-form-label">অডিটি প্রতিষ্ঠানের জবাব</label>
                                <textarea class="form-control mb-1" name="response_of_rpu"
                                          placeholder="অডিটি প্রতিষ্ঠানের জবাব" cols="30"
                                          rows="2">{{$memoInfo['memo']['response_of_rpu']}}</textarea>


                                {{--<label class="col-form-label">নিরীক্ষা মন্তব্য</label>
                                    <textarea class="form-control mb-1" name="audit_conclusion" placeholder="নিরীক্ষা মন্তব্য" cols="30" rows="2"></textarea>

                                    <label class="col-form-label">নিরীক্ষার সুপারিশ</label>
                                    <textarea class="form-control mb-1" name="audit_recommendation" placeholder="নিরীক্ষার সুপারিশ" cols="30" rows="2"></textarea>
                                --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card mb-4">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input class="form-control bangla-number-input amount_number_format mb-1"
                                               value="{{$memoInfo['memo']['jorito_ortho_poriman']}}"
                                               name="jorito_ortho_poriman" placeholder="জড়িত অর্থ (টাকা)" type="text">
                                    </div>
                                    {{--<div class="col-md-6">
                                        <input class="form-control bangla-number-input amount_number_format mb-1"
                                               name="onishponno_jorito_ortho_poriman" placeholder="অনিষ্পন্ন জড়িত অর্থ (টাকা)" type="text">
                                    </div>--}}
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">নিরীক্ষা বছর শুরু</span>
                                            </div>
                                            <input class="form-control" name="audit_year_start"
                                                   value="{{$memoInfo['memo']['audit_year_start']}}"
                                                   placeholder="নিরীক্ষাধীন অর্থ বছর শুরু" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">নিরীক্ষা বছর শেষ</span>
                                            </div>
                                            <input class="form-control" name="audit_year_end"
                                                   value="{{$memoInfo['memo']['audit_year_end']}}"
                                                   placeholder="নিরীক্ষাধীন অর্থ বছর শেষ" type="text" readonly>
                                        </div>
                                    </div>
                                </div>

                                <select class="form-control select-select2" name="memo_irregularity_type">
                                    <option value="0" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 0?'selected':''}}>আপত্তি
                                        অনিয়মের ধরন বাছাই করুন
                                    </option>
                                    <option value="1" {{$memoInfo['memo']['memo_irregularity_type'] == 1?'selected':''}}>আত্মসাত,
                                        চুরি, প্রতারণা ও জালিয়াতিমূলক
                                    </option>
                                    <option value="2" {{$memoInfo['memo']['memo_irregularity_type'] == 2?'selected':''}}>সরকারের
                                        আর্থিক ক্ষতি
                                    </option>
                                    <option value="3" {{$memoInfo['memo']['memo_irregularity_type'] == 3?'selected':''}}>বিধি ও
                                        পদ্ধতিগত অনিয়ম
                                    </option>
                                    <option value="4" {{$memoInfo['memo']['memo_irregularity_type'] == 4?'selected':''}}>বিশেষ ধরনের
                                        আপত্তি
                                    </option>
                                </select>

                                <select class="form-control select-select2" name="memo_irregularity_sub_type">
                                    <option value="0" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 0?'selected':''}}>আপ
                                        অনিয়মের সাব-ধরন বাছাই করুন
                                    </option>
                                    <option value="1" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 1?'selected':''}}>
                                        ভ্যাট-আইটিসহ সরকারি প্রাপ্য আদায় না করা
                                    </option>
                                    <option value="2" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 2?'selected':''}}>কম আদায়
                                        করা
                                    </option>
                                    <option value="3" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 3?'selected':''}}>আদায়
                                        করা সত্ত্বেও কোষাগারে জমা না করা
                                    </option>
                                    <option value="4" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 4?'selected':''}}>বাজার
                                        দর অপেক্ষা উচ্চমূল্যে ক্রয় কার্য সম্পাদন
                                    </option>
                                    <option value="5" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 5?'selected':''}}>
                                        রেসপন্সিভ সর্বনিম্ন দরদাতার স্থলে উচ্চ দরদাতার নিকট থেকে কার্য/পণ্য/সেবা ক্রয়
                                    </option>
                                    <option value="6" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 6?'selected':''}}>প্রকল্প
                                        শেষে অব্যয়িত অর্থ ফেরত না দেওয়া
                                    </option>
                                    <option value="7" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 7?'selected':''}}>ভুল
                                        বেতন নির্ধারণীর মাধ্যমে অতিরিক্ত বেতন উত্তোলন
                                    </option>
                                    <option value="8" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 8?'selected':''}}>
                                        প্রাপ্যতাবিহীন ভাতা উত্তোলন
                                    </option>
                                    <option value="9" {{$memoInfo['memo']['memo_irregularity_sub_type'] == 9?'selected':''}}>জাতীয়
                                        অন্যান্য সরকারী অর্থের ক্ষতি সংক্রান্ত আপত্তি।
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body p-4">

                                <label class="col-form-label">পরিশিষ্ট সংযুক্তি</label>
                                <input name="porisishtos[]" type="file" class="mFilerInit form-control rounded-0"
                                       multiple>

                                <div class="jFiler jFiler-theme-default">
                                    <div class="jFiler-items jFiler-row">
                                        <ul class="jFiler-items-list jFiler-items-default">
                                            @foreach($memoInfo['porisishto_list'] as $porisishto)
                                                <li class="jFiler-item" id="attachment{{$porisishto['id']}}" style="">
                                                    <div class="jFiler-item-container">
                                                        <div class="jFiler-item-inner">
                                                            <div class="jFiler-item-icon pull-left">
                                                                <i class="icon-jfi-file-o jfi-file-type-application jfi-file-ext-docx"></i>
                                                            </div>
                                                            <div class="jFiler-item-info pull-left">
                                                                <a target="_blank" download href="{{$porisishto['file_path']}}"  title="{{$porisishto['file_user_define_name']}}"
                                                                   class="jFiler-item-title d-inline-block text-dark‌‌">
                                                                    {{$porisishto['file_user_define_name']}}
                                                                </a>
                                                                <div class="jFiler-item-others">
                                                                    @if($porisishto['file_size'])
                                                                        <span>size: {{readableFileSize($porisishto['file_size'])}}</span>
                                                                    @endif
                                                                    <span>type: {{$porisishto['file_extension']}}</span>
                                                                    <span class="jFiler-item-status"></span>
                                                                </div>
                                                                <div class="jFiler-item-assets">
                                                                    <ul class="list-inline">
                                                                        <li>
                                                                            <a href="javascript:;" class="icon-jfi-trash" data-memo-attachment-id="{{$porisishto['id']}}"
                                                                            onclick="Audit_Memo_Edit_Container.deleteMemoAttachment($(this))"></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>



                                <label class="col-form-label">প্রমানক সংযুক্তি</label>
                                <input name="pramanoks[]" type="file" class="mFilerInit form-control rounded-0"
                                       multiple>

                                <div class="jFiler jFiler-theme-default">
                                    <div class="jFiler-items jFiler-row">
                                        <ul class="jFiler-items-list jFiler-items-default">
                                            @foreach($memoInfo['pramanok_list'] as $pramanok)
                                                <li class="jFiler-item" id="attachment{{$pramanok['id']}}" style="">
                                                    <div class="jFiler-item-container">
                                                        <div class="jFiler-item-inner">
                                                            <div class="jFiler-item-icon pull-left">
                                                                <i class="icon-jfi-file-o jfi-file-type-application jfi-file-ext-docx"></i>
                                                            </div>
                                                            <div class="jFiler-item-info pull-left">
                                                                <a target="_blank" download href="{{$pramanok['file_path']}}"  title="{{$pramanok['file_user_define_name']}}"
                                                                   class="jFiler-item-title d-inline-block text-dark‌‌">
                                                                    {{$pramanok['file_user_define_name']}}
                                                                </a>
                                                                <div class="jFiler-item-others">
                                                                    @if($pramanok['file_size'])
                                                                        <span>size: {{readableFileSize($pramanok['file_size'])}}</span>
                                                                    @endif
                                                                    <span>type: {{$pramanok['file_extension']}}</span>
                                                                    <span class="jFiler-item-status"></span>
                                                                </div>
                                                                <div class="jFiler-item-assets">
                                                                    <ul class="list-inline">
                                                                        <li>
                                                                            <a href="javascript:;" class="icon-jfi-trash" data-memo-attachment-id="{{$pramanok['id']}}"
                                                                               onclick="Audit_Memo_Edit_Container.deleteMemoAttachment($(this))"></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                {{--<label class="col-form-label">মেমো সংযুক্তি <span class="text-primary">(ঐচ্ছিক)</span></label>
                                <input name="memos[]" type="file" class="mFilerInit form-control rounded-0" multiple>--}}
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body p-4">
                                <label class="col-form-label">দলনেতা</label>
                                <input type="text" class="form-control mb-1" name="rpu_acceptor_officer_name_bn"
                                       placeholder="দলনেতা" readonly
                                       value="{{$team_leader_name.' ('.$team_leader_designation_name.')'}}">

                                <label class="col-form-label">উপদলনেতা</label>
                                <input type="text" class="form-control mb-1" name="rpu_acceptor_designation_name_bn"
                                       placeholder="উপদলনেতা" readonly
                                       value="{{$scope_sub_team_leader == 1?$sub_team_leader_name.' ('.$sub_team_leader_designation_name.')':''}}">
                            </div>
                        </div>

                        <div class="card mb-4 d-none">
                            <div class="card-body p-4">
                                <label class="col-form-label">প্রতিষ্ঠান প্রধানের নাম</label>
                                <input type="text" class="form-control mb-1" name="rpu_acceptor_officer_name_bn"
                                       placeholder="প্রতিষ্ঠান প্রধানের নাম">

                                <label class="col-form-label">প্রতিষ্ঠান প্রধানের পদবী</label>
                                <input type="text" class="form-control mb-1" name="rpu_acceptor_designation_name_bn"
                                       placeholder="প্রতিষ্ঠান প্রধানের পদবী">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="{{asset('assets/js/mFiler.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/global/tinymce.min.js')}}" referrerpolicy="origin"></script>
<script>
    $(document).ready(function () {
        $('.mFilerInit').filer({
            showThumbs: true,
            addMore: true,
            allowDuplicates: false
        });
    });

    tinymce.init({
        selector: '.kt-tinymce-1',
        menubar: false,
        min_height: 400,
        height: 400,
        max_height: 400,
        branding: false,
        content_style: "body {font-family: solaimanlipi;font-size: 13pt;}",
        fontsize_formats: "8pt 10pt 12pt 13pt 14pt 18pt 24pt 36pt",
        font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Times New Roman=times new roman,times; Verdana=verdana,geneva; Solaimanlipi=solaimanlipi",
        toolbar: ['styleselect fontselect fontsizeselect | blockquote subscript superscript',
            'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify | table',
            'bullist numlist | outdent indent | advlist | autolink | lists charmap | print preview |  code'],
        plugins: 'advlist paste autolink link image lists charmap print preview code table',
        context_menu: 'link image table',
        setup: function (editor) {
        },
    });

    var Audit_Memo_Edit_Container = {
        deleteMemoAttachment: function (elem) {
            swal.fire({
                title: 'আপনি কি মুছে ফেলতে চান?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'হ্যাঁ',
                cancelButtonText: 'না'
            }).then(function(result) {
                if (result.value) {
                    url = '{{route('audit.execution.memo.delete-memo-attachment')}}';
                    memo_attachment_id = elem.attr('data-memo-attachment-id');
                    data = {memo_attachment_id};
                    ajaxCallAsyncCallbackAPI(url, data, 'post', function (response) {
                        if (response.status === 'error') {
                            toastr.error(response.data)
                        } else {
                            $("#attachment"+memo_attachment_id).hide();
                            toastr.success(response.data);
                        }
                    })
                }
            });
        },
    }

    //for submit form
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#memo_submit').on('click', function (e) {
            e.preventDefault();

            from_data = new FormData(document.getElementById("memo_create_form"));
            from_data.append('memo_description_bn', tinymce.get("kt-tinymce-1").getContent())

            $.ajax({
                data: from_data,
                url: "{{route('audit.execution.memo.update')}}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (responseData) {
                    if (responseData.status === 'success') {
                        toastr.success(responseData.data);
                        $('.btn_back').click();
                    } else {
                        if (responseData.statusCode === '422') {
                            var errors = responseData.msg;
                            $.each(errors, function (k, v) {
                                if (v !== '') {
                                    toastr.error(v);
                                }
                            });
                        } else {
                            toastr.error(responseData.data);
                        }
                    }
                },
                error: function (data) {
                    if (data.responseJSON.errors) {
                        $.each(data.responseJSON.errors, function (k, v) {
                            if (isArray(v)) {
                                $.each(v, function (n, m) {
                                    toastr.error(m)
                                    console.log(m, n, v);
                                })
                            } else {
                                if (v !== '') {
                                    toastr.error(v);
                                }
                            }
                        });
                    }
                }
            });
        });
    });
</script>
