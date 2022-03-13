<!--begin::User-->
<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
    <div class="btn btn-dropdown w-auto btn-clean d-flex align-items-center btn-square px-2 py-0 h-100">
        @if(isset($userDetails['user_role_id']) && $userDetails['user_role_id'] == 3)
            <div class="top-right-username">
                <div class="profile-name">{{ $employeeInfo['name_bng'] ?? 'User Name' }}</div>
                <div class="profile-designation mt-4">{{isset($userOffices) ? $userOffices[0]['designation'] : ''}}</div>
            </div>
            <span class="symbol symbol-lg-35 symbol-25">
                <img src="{{ asset('assets/media/users/blank.png') }}" alt="">
            </span>
        @endif
        @if(isset($userDetails['user_role_id']) && $userDetails['user_role_id'] == 1)
            <div class="top-right-username">
                <div class="profile-name">Superman</div>
            </div>
            <span class="symbol symbol-lg-35 symbol-25">
                <img src="{{ asset('assets/media/users/blank.png') }}" alt="">
            </span>
        @endif

        {{--        <div class="symbol symbol-20 symbol-lg-30 symbol-circle mr-2">--}}
        {{--            <img src="{{ asset('assets/media/users/blank.png') }}" class="img-responsive" alt="">--}}
        {{--        </div>--}}
        {{--        <span class="font-weight-normal font-size-base d-none d-md-inline mr-3 text-violate profile-name">--}}
        {{--            @if(isset($userDetails['user_role_id']) && $userDetails['user_role_id'] == 1)--}}
        {{--                {{__('Superman')}}--}}
        {{--            @elseif(isset($userDetails['user_role_id']) && $userDetails['user_role_id'] == 3)--}}
        {{--                {{ $employeeInfo['name_bng'] ?? 'User Name' }} {{isset($userOffices) ? ', ' . $userOffices[0]['designation'] : ''}}--}}
        {{--            @endif--}}
        {{--        </span>--}}
        <span><i style="font-size:11px;" class="ml-2 fa fa-chevron-down"></i></span>
    </div>
</div>
<div
    class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
    <!--begin: Head -->
    <div class="shadow">
        @if(isset($userDetails['user_role_id']) && $userDetails['user_role_id'] == 3)
            <h4 class="ant-typography px-2 bg-white py-2 border-bottom">{{ __('পদবি নির্বাচন করুন') }}</h4>
            <ul class="pl-0" role="menu">
                <li class="d-flex align-items-start overflow-hidden " role="menuitem" style="padding-left: 10px;">
                <span class="pr-3 pt-1">
                    <i class="fas fa-id-card fa-1x a2i-color-purple"></i>
                </span>
                    @if(isset($userOffices))
                        @forelse($userOffices as $office)
                            <a href="{{route('change.office', [$office['id'], $office['office_id'], $office['office_unit_id'], $office['office_unit_organogram_id']])}}"
                               class="btn-switch-designation flex-fill overflow-hidden">
                                <span>{{ $office['designation'] }}, </span>
                                {{--                                <span class="test text-truncate">{{ $office['unit_name_bn'] }}</span>--}}
                                <span class="test text-truncate">{{ $office['office_name_bn'] }}</span>
                            </a>
                        @empty
                            <a href="javascript:;" class="btn-switch-designation flex-fill overflow-hidden">
                                <span></span>
                            </a>
                        @endforelse
                    @endif
                </li>
            </ul>
        @endif
        <div class="btn-group w-100 d-flex justify-content-between" role="group"
             aria-label="User Profile Management">
            <button onclick="Generic_Container.show_user_profile()" data-toggle="popover" data-placement="bottom" data-content="{{ __('প্রোফাইল') }}"
                    class="btn btn-primary font-weight-bold text-white btn-profile btn-square">
                <i class="fa fa-user"></i><span class="ml-2">{{ __('প্রোফাইল') }} </span>
            </button>
            <button data-content="{{ __('হেল্প ডেস্ক') }}" data-toggle="popover" data-placement="bottom"
                    class="btn btn-success font-weight-bold text-white btn-square">
                <i class="fad fa-user-headset"></i><span class="ml-2">{{ __('হেল্প ডেস্ক') }}</span>
            </button>
            <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
               class="btn btn-danger font-weight-bold text-white btn-square" data-toggle="popover"
               data-placement="bottom" data-content="{{ __('লগ আউট') }}" data-original-title="" title="">
                <i class="fas fa-sign-out-alt"></i><span class="ml-2">{{ __('লগ আউট') }} </span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a>
        </div>
    </div>
    <!--end: Navigation -->
</div>
