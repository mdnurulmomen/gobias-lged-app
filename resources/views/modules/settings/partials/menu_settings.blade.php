<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <x-menu-module-name>Annual Plan</x-menu-module-name>
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
         data-menu-dropdown-timeout="500">
        <ul class="menu-nav">
            <x-menu-item class="menu-item-active" href="{{route('settings.dashboard')}}"
                         icon="fal fa-tachometer-alt-average">Dashboard
            </x-menu-item>
            <hr>


            <x-parent-menu-item icon="fas fa-list" name="Strategic Plan">
                <x-menu-item class="" href="{{route('settings.strategic-plan.duration.index')}}"
                             icon="fal fa-calendar-alt">Duration
                </x-menu-item>

                <x-menu-item class="" href="{{route('settings.strategic-plan.outcome.index')}}"
                             icon="fal fa-calendar-alt">Outcome
                </x-menu-item>

                <x-menu-item class="" href="{{route('settings.strategic-plan.output.index')}}"
                             icon="fal fa-calendar-alt">Output
                </x-menu-item>

            </x-parent-menu-item>

            <x-parent-menu-item icon="fas fa-list" name="Operational Plan">
                <x-menu-item class="" href="{{route('settings.fiscal-years.index')}}"
                             icon="fal fa-calendar-alt">Fiscal Year
                </x-menu-item>
            </x-parent-menu-item>

            <x-parent-menu-item icon="fas fa-list" name="Audit Conducting">
                <x-menu-item class="x_query_menu" href="{{route('settings.audit-query.index')}}"
                             icon="fal fa-calendar-alt">Query
                </x-menu-item>
            </x-parent-menu-item>

            <x-parent-menu-item icon="fas fa-list" name="Risk Assessment">
                <x-menu-item class="x_risk_assessment" href="{{route('settings.risk-assessment.index')}}"
                             icon="fal fa-calendar-alt">Risk Assessment
                </x-menu-item>
            </x-parent-menu-item>

            <x-parent-menu-item icon="fas fa-list" name="Audit Assessment">
                <x-menu-item class="x_audit_assessment" href="{{route('settings.audit-assessment.criteria.index')}}"
                             icon="fal fa-calendar-alt">Criteria
                </x-menu-item>
            </x-parent-menu-item>

            <x-parent-menu-item icon="fas fa-list" name="Modules & Menus">
                <x-menu-item class="p_modules" href="{{url('settings/menu-actions/module')}}"
                             icon="fal fa-calendar-alt">Modules
                </x-menu-item>
                <x-menu-item class="p_modules" href="{{url('settings/menu-actions/menu')}}"
                             icon="fal fa-calendar-alt">Menus
                </x-menu-item>
                <x-menu-item class="p_modules" href="{{url('settings/menu-actions/action')}}"
                             icon="fal fa-calendar-alt">Actions
                </x-menu-item>
            </x-parent-menu-item>

            <x-parent-menu-item icon="fas fa-list" name="Permission">
                <x-menu-item class="p_modules" href="{{route('settings.roles.index')}}"
                             icon="fal fa-calendar-alt">Roles
                </x-menu-item>
                <x-menu-item class="p_modules" href="{{route('settings.role-permissions.index')}}"
                             icon="fal fa-calendar-alt">Permission Assign
                </x-menu-item>
                <x-menu-item class="p_modules" href="{{route('settings.role-permissions.employee-permission')}}"
                             icon="fal fa-calendar-alt">Employee Permission
                </x-menu-item>
            </x-parent-menu-item>
        </ul>
    </div>
</div>
