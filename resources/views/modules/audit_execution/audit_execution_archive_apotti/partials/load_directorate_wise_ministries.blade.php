<select name="ministry_id" id="ministry_id" class="form-control rounded-0">
    <option value="">--বাছাই করুন--</option>
    @foreach($all_ministries as $ministry)
        <option value="{{$ministry['directorate_ministry']['id']}}">{{$ministry['directorate_ministry']['name_bng']}}</option>
    @endforeach
</select>