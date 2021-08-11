<!--begin::Aside Menu-->
<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <x-menu-module-name>Strategic Plan</x-menu-module-name>
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
        data-menu-dropdown-timeout="500">
        <ul class="menu-nav">
            <x-menu-item class="menu-item-active" href="#" icon="fal fa-tachometer-alt-average">Dashboard
            </x-menu-item>
            <hr>
            <x-menu-item class="" href="{{route('audit.followup.objection.dashboard')}}" icon="fab fa-firstdraft">
                Objections
            </x-menu-item>
            <x-menu-item class="" href="{{route('audit.followup.objection.response')}}" icon="fab fa-firstdraft">
                Objections Response
            </x-menu-item>



        </ul>
    </div>
    <!--end::Menu Container-->
</div>
<!--end::Aside Menu-->
