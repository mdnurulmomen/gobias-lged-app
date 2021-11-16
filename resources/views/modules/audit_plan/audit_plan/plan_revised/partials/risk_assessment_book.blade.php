<h4>
    @if($risk_assessment_type == 'inherent')
        Inherent Risk
    @elseif($risk_assessment_type == 'control')
        Control Risk
    @elseif($risk_assessment_type == 'detection')
        Detection Risk
    @endif
</h4>
<table class="table" border="1" width="100%">
    <thead>
    <tr>
        <th width="10%" style="text-align: center">ক্রমিক নং</th>
        <th width="70%" style="text-align: center">
            @if($risk_assessment_type == 'inherent')
                ইনহেরেন্ট
            @elseif($risk_assessment_type == 'control')
                কন্ট্রোল
            @elseif($risk_assessment_type == 'detection')
                ডিটেকশান
            @endif
            রিস্ক ফ্যাক্টর
        </th>
        <th width="20%" style="text-align: center">রিস্কস্কোর (উচ্চ/মধ্যম/নিম্ন)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($risk_assessments as $risk_assessment)
        <tr>
            <td style="text-align: center">{{enTobn($loop->iteration)}}</td>
            <td>{{$risk_assessment['risk_assessment_title_bn']}}</td>
            <td style="text-align: center">{{enTobn($risk_assessment['risk_value'])}}</td>
        </tr>
    @endforeach
    <tr>
        <td style="text-align: center" colspan="2">মোট:</td>
        <td style="text-align: center">{{enTobn($total_number)}}</td>
    </tr>
    <tr>
        <td style="text-align: center" colspan="2">
            @if($risk_assessment_type == 'inherent')
                সামগ্রিক ইনহেরেন্ট রিস্ক
            @elseif($risk_assessment_type == 'control')
                সামগ্রিক কন্ট্রোল রিস্ক
            @elseif($risk_assessment_type == 'detection')
                সামগ্রিক ডিটেকশান রিস্ক
            @endif
        </td>
        <td style="text-align: center">
            {{enTobn(number_format($risk_rate,2))}}

            {{--@if($risk == 'high')
                (উচ্চ ঝুঁকি)
            @elseif($risk == 'medium')
                (মধ্যম ঝুঁকি)
            @elseif($risk == 'low')
                (নিম্ন ঝুঁকি)
            @endif--}}
        </td>
    </tr>
    </tbody>
</table>
