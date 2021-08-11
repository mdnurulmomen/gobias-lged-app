<script>
    $("#add").click(function () {
        var treeList = $("a");
        console.log('treeList', treeList);
    });

    var auditPaperList = [];
    var activePdf = '';
    var arrayCollection = [
        {
            "id": "0",
            "content_id": "content_0_1",
            "parent": "#",
            "text": "Cover",
            "content": "<p style='text-align:center'><br></p><p style='text-align:center'><br></p><p style='text-align:center'><br></p><p style='text-align:center'><img src='data:image/png;base64,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' data-filename='logo.png' style='width:120px'></p><p style='text-align:center'><br></p><h1 style='text-align:center'><span style='color:#222' arial=''>Audit Plan</span><span style='color:#222' arial=''>(নিরীক্ষা পরিকল্পনা)</span></h1><h1 style='text-align:center'><span style='color:#222' arial=''><br></span></h1><h1 style='text-align:center'><span style='color:#222' arial=''><br></span></h1><h3 style='text-align:center'><span arial=''><font color='#222222'>সিভিল অডিট অধিদপ্তর&nbsp;&nbsp;</font></span></h3><h3 style='text-align:center'><span arial=''><font color='#222222'><br></font></span></h3><h3 style='text-align:center'><span arial=''><font color='#222222'><br></font></span></h3><h3 style='text-align:center'><span arial=''><font color='#222222'>মঞ্জুরী নং-২৮</font></span></h3><h3 style='text-align:center'><span arial=''><font color='#222222'>শ্রম ও কর্মসংস্থান&nbsp; মন্ত্রণালয় এবং এর নিয়ন্ত্রনাধীন প্রতিষ্ঠানসমূহের<br></font></span></h3><h3 style='text-align:center'><span arial=''><font color='#222222'><br></font></span></h3><h3 style='text-align:center'><span arial=''><font color='#222222'><br></font></span></h3><h5 style='text-align:center'><span arial=''><font color='#222222'>অর্থবছরঃ ২০১৮-২০১৯&nbsp;</font></span></h5><h5 style='text-align:center'><span arial=''><font color='#222222'><br></font></span></h5><h5 style='text-align:center'><span arial=''><font color='#222222'><br></font></span></h5><h5 style='text-align:center'><span arial=''<font color='#222222'>&nbsp; &nbsp;সিভিল অডিট অধিদপ্তর&nbsp;&nbsp;<br></font></span></h5><p style='text-align:center'><br></p>"
        },
        {"id": "1", "content_id": "content_1_0", "parent": "#", "text": "1. Preliminary Information", "content": ""},
        {"id": "2", "content_id": "content_1_1", "parent": "1", "text": "1.1 Name of the Entity", "content": ""},
        {
            "id": "3",
            "content_id": "content_1_2",
            "parent": "1",
            "text": "1.2 Financial Period to be covered (MM/YY to MM/YY)",
            "content": ""
        },
        {
            "id": "4",
            "content_id": "content_1_3",
            "parent": "1",
            "text": "1.3 Period of Audit",
            "content": ""
        },
        {
            "id": "5",
            "content_id": "content_1_4",
            "parent": "1",
            "text": "1.4 Name of the members of the Audit Engagement Team in terms of Seniority(Team Leader at Sl No 1)",
            "content": ""
        },
        {
            "id": "6",
            "content_id": "content_1_5",
            "parent": "1",
            "text": "1.5 Document No of Audit Strategy",
            "content": ""
        },
        {
            "id": "7",
            "content_id": "content_1_6",
            "parent": "1",
            "text": "1.6 Total Number of Working Days",
            "content": ""
        },
        {"id": "8", "content_id": "content_2_0", "parent": "#", "text": "2. Knowledge of the Entity", "content": ""},
        {
            "id": "9",
            "content_id": "content_2_1",
            "parent": "8",
            "text": "2.1 Important Characteristics of the Entity",
            "content": ""
        },
        {"id": "10", "content_id": "content_2_2", "parent": "8", "text": "2.2 Revision/ Addition", "content": ""},
        {
            "id": "11",
            "content_id": "content_2_3",
            "parent": "8",
            "text": "2.3 Financial Performance/Parameters",
            "content": ""
        },
        {"id": "12", "content_id": "content_2_4", "parent": "8", "text": "2.4 Inherent Risk Assessment", "content": ""},
        {"id": "13", "content_id": "content_2_5", "parent": "8", "text": "2.5 Control Risk Assessment", "content": ""},
        {"id": "14", "content_id": "content_2_6", "parent": "8", "text": "2.6 Detection Risk", "content": ""},
        {
            "id": "15",
            "content_id": "content_2_7_1",
            "parent": "8",
            "text": "2.7(i) Overall Materiality Benchmark ",
            "content": ""
        },
        {
            "id": "16",
            "content_id": "content_2_7_2",
            "parent": "8",
            "text": "2.7(ii) Overall Materiality in Bangladesh Taka",
            "content": ""
        },
        {
            "id": "17",
            "content_id": "content_2_8",
            "parent": "8",
            "text": "2.8 Complex Transaction Areas (Attach Additional Sheet, if necessary)",
            "content": ""
        },
        {
            "id": "18",
            "content_id": "content_3_0",
            "parent": "#",
            "text": "3. Main Audit Areas (Attach Additional Sheet, if necessary)",
            "content": ""
        },
        {
            "id": "19",
            "content_id": "content_4_0",
            "parent": "#",
            "text": "4. Procedure Details (EMH: Estimated Man Hours; AMH: Actual Man Hours)",
            "content": ""
        },
        {
            "id": "20",
            "content_id": "content_5_0",
            "parent": "#",
            "text": "5. Documents consulted before preparation of the Audit Plan",
            "content": ""
        },
    ];


    $('#createPlanJsTree').jstree({
        "core": {
            "check_callback": true,
            'data': arrayCollection
        },
        "plugins": ["dnd", "checkbox", "search"]
    });

    for (let i = 0; i < arrayCollection.length; i++) {
        var arrayData = {"id": arrayCollection[i].id, "title": arrayCollection[i].text, "content": ""}
        auditPaperList.push(arrayData);
        var dataHtml = '<div class="pdf-screen"><p class="pageTileNumber">' + arrayCollection[i].text + '</p><div id="pdfContent_' + arrayCollection[i].content_id + '">' + arrayCollection[i].content + '</div></div>';
        $("#writing-screen-wrapper").append(dataHtml);
    }

    $('#createPlanJsTree').on("select_node.jstree", function (e, data) {
        activePdf = data.node.id;

        arrayCollection.map(function (value, index) {
            if (value.id == activePdf) {
                var content = value.content;
                $("#pdfContent_" + value.content_id).html(content);
                $('.note-editable').html(content);
            } else {
                $('.summernote').summernote('reset');
            }
        });
    });

    function checkIdAndSetContent(content) {
        arrayCollection.map(function (value, index) {
            if (value.id == activePdf) {
                value.content = content;
                $("#pdfContent_" + value.content_id).html(content);
            }
        });
    }

    $('.summernote').summernote({
        height: 600,

        callbacks: {
            onChange: function (contents, arrayCollection) {
                if ($("#createPlanJsTree").jstree("get_selected").length == '0') {

                } else {
                    checkIdAndSetContent(contents);
                }
            }
        }
    });

    Split(['#split-0', '#split-1', '#split-2'], {
        minSize: 150,
        snapOffset: 10,
        gutterSize: 5,
    });

</script>
