@php
// dd($user_data->user_level );
// dd($user_data->gender);
//$user_data = Auth::user();
//dd($company_data['sys_customer_code']);
// dd($user_data->user_level );
if ($user_data->isAdmin() || $user_data->isSubAdmin()) {
$doccount = $user_data->adminDocumentCouting();
}else if($user_data->isUser() && $user_data->isPositionChief()) {
$doccount = $user_data->chiefDocumentCounting();
}else{
$doccount = null;
}
// dd($company_data['helper']);

// dd($user_data->getDeduct());
// dd($user_data->getTypeworks()['status'])

// dd($user_data->getCompanyProfile());
@endphp
<!--<span class="badge badge-danger">5</span>-->
<div class="navigation"><!--style="z-index: 9999;"-->
    <div class="navigation-menu-tab"><!-- bg-custom-->
        {{--- เปิด tag รูปภาพ ----}}
        <div>
            <div class="navigation-menu-tab-header" data-toggle="tooltip" title="" data-placement="right">
                <a href="#" class="nav-link" data-toggle="dropdown" aria-expanded="false">
                    @php
                    if ($user_data->gender != null) {
                    if ($user_data->gender == 'm') {
                    $empty_img = url('/').'/assets/svgs/human-01.svg';
                    }else {
                    $empty_img = url('/').'/assets/svgs/human-02.svg';
                    }
                    }else {
                    $empty_img = url('/').'/assets/svgs/human-01.svg';
                    }
                    @endphp
                    <figure class="avatar">
                        @if ($user_data->emp_img != null)
                        <img src="@php echo url('/')."/company/".$user_data->sys_customer_code."/emp/images/".$user_data->emp_img @endphp" class="rounded-circle" alt="image" onerror="this.onerror=null;this.src='@php echo $empty_img; @endphp';">
                        @else
                        <img src="@php echo $empty_img; @endphp" class="rounded-circle" alt="image">
                        @endif
                    </figure>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                    <div class="p-3 text-center bg-primary-gradient"><!--data-backround-image="https://via.placeholder.com/1000X563"-->
                        <figure class="avatar avatar-xl mb-3">
                            @if ($user_data->emp_img != null)
                            <img src="@php echo url('/')."/company/".$user_data->sys_customer_code."/emp/images/".$user_data->emp_img @endphp" class="rounded-circle" alt="image" onerror="this.onerror=null;this.src='@php echo $empty_img; @endphp';">
                            @else
                            <img src="@php echo $empty_img; @endphp" class="rounded-circle" alt="image">
                            @endif
                        </figure>
                        <div class="small">{{ $company_data['name']}} ({{ $company_data['name_en']}})</div>
                        <div class="small mb-2">รหัสบริษัท {{ $company_data['sys_customer_code']}}</div>
                        @if ($user_data->user_level != '1')
                        <div class="font-size-12">
                            <div>
                                @if ($user_data->is_expat != '1')
                                @php
                                echo $user_data->title_name.' '.$user_data->name;
                                @endphp
                                @else
                                @php
                                echo $user_data->title_name_en.' '.$user_data->name_en;
                                @endphp
                                @endif
                            </div>
                            <div>
                                {{--
                                    @switch($user_data->user_level)
                                        @case('2')
                                            ระดับ : ฝ่ายบุคคล
                                            @break
                                        @case('3')
                                            ระดับ : หัวหน้า
                                            @break
                                        @case('4')
                                            ระดับ : พนักงาน
                                            @break
                                        @case('5')
                                            ระดับ : ผู้เกี่ยวข้อง
                                            @break
                                        @default
                                            ระดับ : ทดลองงาน
                                    @endswitch
                                    --}}
                                @php
                                if ($user_data->isAdmin()) {
                                echo 'ผู้ดูแลระบบ';
                                }else if($user_data->isSubAdmin()) {
                                echo 'ฝ่ายบุคคล';
                                }else if($user_data->isUser() && $user_data->isPositionChief()) {
                                echo 'ระดับหัวหน้า';
                                }else if($user_data->isUser() && $user_data->isPositionStaff()) {
                                echo 'ระดับพนักงาน';
                                }
                                @endphp
                            </div>
                        </div>
                        @else
                        <div class="font-size-12">
                            <div>
                                ระดับ : Admin
                            </div>
                            <button class="btn btn-sm btn-google mt-2" data-toggle="modal" data-target="#modal-change-password-admin">
                                เปลี่ยนรหัสผ่าน
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="dropdown-menu-body">
                        <div class="list-group list-group-flush">
                            {{-- <a href="#" class="list-group-item">โปรไฟล์</a> --}}
                            <!--
                                <a href="#" class="list-group-item d-flex">
                                    Followers <span class="text-muted ml-auto">214</span>
                                </a>
                                <a href="#" class="list-group-item d-flex">
                                    Inbox <span class="text-muted ml-auto">18</span>
                                </a>
                                <a href="#" class="list-group-item" data-sidebar-target="#settings">Billing</a>
                                <a href="#" class="list-group-item" data-sidebar-target="#settings">Need help?</a>
                            -->
                            <a data-href="{{ route('backend.auth.ajax_logout') }}" href="#" onclick="handleLogout(this,1)" class="list-group-item text-danger" data-sidebar-target="#settings">ออกจากระบบ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--- ปิด tag รูปภาพ ----}}
        {{--- เปิด tab menu ด้านซ้ายใต้รูปภาพ ----}}
        <div class="flex-grow-1">
            <ul class="{{ $company_data['helper'] == '1' ? 'd-none' : "" }}">
                @if ($user_data->isAdmin())
                    {{--  
                    <li>
                        <div class="icon-badge-container {{ !$user_data->getCompanyProfile() ? "active" : "" }}">
                            <a href="{{ url('/company-profile-form') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="ข้อมูลบริษัท<br><small>(รายละเอียดทั่วไปของบริษัท)</small>" data-nav-target="#level-1" class="{{ $side_bar_page_name === "company_profile" ? "active" : "" }}">
                                <i data-feather="book" class=""></i>
                                <span class="icon-badge"></span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="icon-badge-container {{ !$user_data->getTypeworks()['status'] ? "active" : "" }}">
                            <a href="{{ url('/typeworks') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="โครงสร้างตำแหน่ง<br><small>(การจัดโครงสร้างตำแหน่งภายในบริษัท)</small>" data-nav-target="#level-1" class="{{ $side_bar_page_name === "typeworks" ? "active" : "" }}">
                                <i data-feather="users"></i>
                                <span class="icon-badge"></span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="icon-badge-container {{ !$user_data->getGroupDayOfWork() ? "active" : "" }}">
                            <a href="{{ url('/employee-group-day-work') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="กลุ่มวันทำงาน<br><small>(รูปแบบจำนวนวันทำงาน)</small>" data-nav-target="#level-1" class="{{ $side_bar_page_name === "employee-group-day-work" ? "active" : "" }}">
                                <i data-feather="calendar"></i>
                                <span class="icon-badge"></span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="icon-badge-container {{ !$user_data->getRevenue() ? "active" : "" }}">
                            <a href="{{ url('/revenue-master') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="รายได้<br><small>(รายรับของพนักงานที่ได้จากบริษัท)</small>" data-nav-target="#level-1" class="{{ $side_bar_page_name === "revenue-master" ? "active" : "" }}">
                                <i data-feather="file-plus"></i>
                                <span class="icon-badge"></span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="icon-badge-container {{ !$user_data->getDeduct() ? "active" : "" }}">
                            <a href="{{ url('/deduction-master') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="รายหัก<br><small>(รายจ่ายของพนักงานให้บริษัท)</small>" data-nav-target="#level-1" class="{{ $side_bar_page_name === "deduction-master" ? "active" : "" }}">
                                <i data-feather="file-minus"></i>
                                <span class="icon-badge"></span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="icon-badge-container {{ !$user_data->getPaymentPeriodType()['status'] ? "active" : "" }}">
                            <a href="{{ url('/masters/04') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="วิธีการจ่าย<br><small>(วิธีการจ่ายเงินให้กับพนักงาน)</small>" data-nav-target="#level-1" class="{{ $side_bar_page_name === "masters_04" ? "active" : "" }}">
                                <i data-feather="dollar-sign" stroke="currentColor" stroke-width="1"></i>
                                <span class="icon-badge"></span>
                            </a>
                        </div>
                    </li>
                    --}}
                    <li class="">
                        <a id="li_menu_organizations" data-href="{{ route('emp-profile-view') }}" href="{{route('app.reportsFrontend.organization.chart')}}" data-toggle="tooltip" data-placement="right" title="แผนผังองกรค์">
                        {{-- <i data-feather="share-2"></i> --}}
                        <i data-feather="git-pull-request"></i>
                        </a>
                    </li>                
                    <li class="">
                        <a id="li_menu_import_profile" data-href="{{ route('emp-profile-view') }}" href="{{route('emp-profile-view')}}" data-toggle="tooltip" data-placement="right" title="นำเข้าข้อมูลพนักงาน">
                            <i data-feather="download"></i>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ url('/petition') }}" data-toggle="tooltip" data-placement="right" title="ยื่นคำร้องขอ">
                            <i data-feather="edit-3" stroke-width="1"></i>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ url('/rating-program') }}" data-toggle="tooltip" data-placement="right" title="ให้คะแนนโปรแกรม" class="{{ $page_name === "rating-program" ? "active" : "" }}">
                            <i data-feather="star"></i>
                        </a>
                    </li>
                @elseif($user_data->isSubAdmin())
                    <li class="{{ array_search("01", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_company_profile_form" href="{{ url('/company-profile-form') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="ข้อมูลบริษัท<br><small>(รายละเอียดทั่วไปของบริษัท)</small>" data-nav-target="#level-2" class="{{ $side_bar_page_name === "company_profile" ? "active" : "" }}">
                            <i data-feather="book"></i>
                        </a>
                    </li>
                    <li class="{{ array_search("02", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_typeworks" href="{{ url('/typeworks') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="โครงสร้างตำแหน่ง<br><small>(การจัดโครงสร้างตำแหน่งภายในบริษัท)</small>" data-nav-target="#level-2" class="{{ $side_bar_page_name === "typeworks" ? "active" : "" }}">
                            <i data-feather="share-2"></i>
                        </a>
                    </li>
                    <li class="{{ array_search("03", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_employee_group_day_work" href="{{ url('/employee-group-day-work') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="กลุ่มวันทำงาน<br><small>(รูปแบบจำนวนวันทำงาน)</small>" data-nav-target="#level-2" class="{{ $side_bar_page_name === "employee-group-day-work" ? "active" : "" }}">
                            <i data-feather="calendar"></i>
                        </a>
                    </li>
                    <li class="{{ array_search("04", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_revenue_master" href="{{ url('/revenue-master') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="รายได้<br><small>(รายรับของพนักงานที่ได้จากบริษัท)</small>" data-nav-target="#level-2" class="{{ $side_bar_page_name === "revenue-master" ? "active" : "" }}">
                            <i data-feather="file-plus"></i>
                        </a>
                    </li>
                    <li class="{{ array_search("05", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_deduction_master" href="{{ url('/deduction-master') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="รายหัก<br><small>(รายจ่ายของพนักงานให้บริษัท)</small>" data-nav-target="#level-2" class="{{ $side_bar_page_name === "deduction-master" ? "active" : "" }}">
                            <i data-feather="file-minus"></i>
                        </a>
                    </li>
                    <li class="{{ array_search("06", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_leave" href="{{ url('/masters/04') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="วิธีการจ่าย<br><small>(วิธีการจ่ายเงินให้กับพนักงาน)</small>" data-nav-target="#level-2" class="{{ $side_bar_page_name === "masters_04" ? "active" : "" }}">
                            <i data-feather="dollar-sign"></i>
                        </a>
                    </li>             

                    




                    <li class="{{ array_search("07", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_leave" href="{{ url('/leave-approve') }}" data-toggle="tooltip" data-placement="right" title="ใบลา" data-nav-target="#level-2" class="{{ $page_name === "leave" ? "active" : "" }}">
                            <i data-feather="file-text"></i>
                        </a>
                        <span class='{{ !empty($doccount['count_leave_form']) ? "iconNotify" : "" }}'></span>
                    </li>
                    <li class="{{ array_search("08", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_ot" href="{{ url('/ot-approve') }}" data-toggle="tooltip" data-placement="right" title="โอที" data-nav-target="#level-2" class="{{ $page_name === "ot" ? "active" : "" }}">
                            <i data-feather="clock"></i>
                        </a>
                        <span class='{{ !empty($doccount['count_overtime_form']) ? "iconNotify" : "" }}'></span>
                    </li>
                    <li class="{{ array_search("09", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_job" href="{{ url('/job-approve') }}" data-toggle="tooltip" data-placement="right" title="Jobพิเศษ" data-nav-target="#level-2" class="{{ $page_name === "job" ? "active" : "" }}">
                            <i data-feather="briefcase"></i>
                        </a>
                        <span class='{{ !empty($doccount['count_job_form']) ? "iconNotify" : "" }}'></span>
                    </li>
                    <li class="{{ array_search("10", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_warning" href="{{ url('/warning-approve') }}" data-toggle="tooltip" data-placement="right" title="ใบเตือน" data-nav-target="#level-2" class="{{ $page_name === "warning" ? "active" : "" }}">
                            <i data-feather="message-square"></i>
                        </a>
                        <span class='{{ !empty($doccount['count_warning_form']) ? "iconNotify" : "" }}'></span>
                    </li>
                    <li class="{{ array_search("11", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_upsalary" href="{{ url('/upsalary-approve') }}" data-toggle="tooltip" data-placement="right" title="ปรับเงินเดือน" data-nav-target="#level-2" class="{{ $page_name === "upsalary" ? "active" : "" }}">
                            <i data-feather="corner-left-up"></i>
                        </a>
                        <span class='{{ !empty($doccount['count_upsalary_form']) ? "iconNotify" : "" }}'></span>
                    </li>
                    <li class="{{ array_search("12", $user_data->getShortcutsetting()) !== false ? "" : "d-none" }}">
                        <a id="li_menu_subadmin_vacancies" href="{{ url('/probationary-period') }}" data-toggle="tooltip" data-placement="right" title="ตำแหน่งงาน" data-nav-target="#level-2" class="{{ $page_name === "vacancies" ? "active" : "" }}">
                            <i data-feather="users"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/shortcut/setting') }}" title="ตั้งค่าเมนูลัด">
                            <i data-feather="plus-circle" stroke="#ffffff" stroke-width="2"></i>
                        </a>
                    </li>
                @elseif($user_data->isUser() && $user_data->isPositionChief())
                    <li>
                        <a id="li_menu_chief_leave" href="{{ url('/leave') }}" data-toggle="tooltip" data-placement="right" title="ใบลา" data-nav-target="#level-3" class="{{ $page_name === "leave" ? "active" : "" }}">
                            <i data-feather="file-text"></i>
                        </a>
                        <span class='{{ !empty($doccount['count_leave_form']) ? "iconNotify" : "" }}'></span>
                    </li>
                    <li>
                        <a id="li_menu_chief_ot" href="{{ url('/ot') }}" data-toggle="tooltip" data-placement="right" title="โอที" data-nav-target="#level-3" class="{{ $page_name === "ot" ? "active" : "" }}">
                            <i data-feather="clock"></i>
                        </a>
                    </li>
                    <li>
                        <a id="li_menu_chief_job" href="{{ url('/job') }}" data-toggle="tooltip" data-placement="right" title="Jobพิเศษ" data-nav-target="#level-3" class="{{ $page_name === "job" ? "active" : "" }}">
                            <i data-feather="briefcase"></i>
                        </a>
                    </li>
                    <li>
                        <a id="li_menu_chief_warning" href="{{ url('/warning') }}" data-toggle="tooltip" data-placement="right" title="ใบเตือน" data-nav-target="#level-3" class="{{ $page_name === "warning" ? "active" : "" }}">
                            <i data-feather="message-square"></i>
                        </a>
                    </li>
                    <li>
                        <a id="li_menu_chief_vacancies" href="{{ url('/vacancies') }}" data-toggle="tooltip" data-placement="right" title="ตำแหน่งงาน" data-nav-target="#level-3" class="{{ $page_name === "vacancies" ? "active" : "" }}">
                            <i data-feather="users"></i>
                        </a>
                    </li>
                @elseif($user_data->isUser() && $user_data->isPositionStaff())
                    {{--
                    <li>
                        <a href="#" data-toggle="tooltip" data-placement="right" title="พนักงาน" data-nav-target="#level-4" class="active">
                            <i class="fas fa-user-friends font-size-18"></i>
                        </a>
                    </li>
                    --}}
                    <li>
                        <a id="li_menu_emp_leave" href="{{ url('/leave') }}" data-toggle="tooltip" data-placement="right" title="ใบลา" data-nav-target="#level-4" class="{{ $page_name === "leave" ? "active" : "" }}">
                            <i data-feather="file-text"></i>
                        </a>
                    </li>
                    <li>
                        <a id="li_menu_emp_ot" href="{{ url('/ot') }}" data-toggle="tooltip" data-placement="right" title="โอที" data-nav-target="#level-4" class="{{ $page_name === "ot" ? "active" : "" }}">
                            <i data-feather="clock"></i>
                        </a>
                    </li>
                    <li>
                        <a id="li_menu_emp_job" href="{{ url('/job') }}" data-toggle="tooltip" data-placement="right" title="Jobพิเศษ" data-nav-target="#level-4" class="{{ $page_name === "job" ? "active" : "" }}">
                            <i data-feather="briefcase"></i>
                        </a>
                    </li>
                    <li>
                        <a id="li_menu_emp_warning" href="{{ url('/warning') }}" data-toggle="tooltip" data-placement="right" title="ใบเตือน" data-nav-target="#level-4" class="{{ $page_name === "warning" ? "active" : "" }}">
                            <i data-feather="message-square"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <div>
            <ul>
                @if ($company_data['helper'] != '1')
                {{-- @if ($user_data->isAdmin() || $user_data->isSubAdmin()) --}}
                @if ($user_data->isSubAdmin())
                <!-- emp-profile-view -->
                <li class="">
                    <a id="li_menu_organizations" data-href="{{ route('emp-profile-view') }}" href="{{route('app.reportsFrontend.organization.chart')}}" data-toggle="tooltip" data-placement="right" title="แผนผังองกรค์">
                    {{-- <i data-feather="share-2"></i> --}}
                    <i data-feather="git-pull-request"></i>
                    </a>
                </li>                
                <li class="">
                    <a id="li_menu_import_profile" data-href="{{ route('emp-profile-view') }}" href="{{route('emp-profile-view')}}" data-toggle="tooltip" data-placement="right" title="นำเข้าข้อมูลพนักงาน">
                        <i data-feather="download"></i>
                    </a>
                </li>
                {{-- 
                <li class="">
                    <a id="li_menu_qr_code" data-href="{{ route('app.view.time_stamp.qr_code') }}" href="{{route('app.view.time_stamp.qr_code')}}" data-toggle="tooltip" data-placement="right" title="QR Code">
                        <i data-feather="grid"></i>
                    </a>
                </li>
                 --}}
                @endif
                {{-- <li class="{{ !empty($company_data['is_scoring_system']) ? "d-none" : "" }}"></li> --}}
                @if ($user_data->isAdmin())
                {{-- 
                <li class="">
                    <a href="{{ url('/petition') }}" data-toggle="tooltip" data-placement="right" title="ยื่นคำร้องขอ">
                        <i data-feather="edit-3" stroke-width="1"></i>
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('/rating-program') }}" data-toggle="tooltip" data-placement="right" title="ให้คะแนนโปรแกรม" class="{{ $page_name === "rating-program" ? "active" : "" }}">
                        <i data-feather="star"></i>
                    </a>
                </li>
                 --}}
                @endif
                @if ($user_data->user_level <= "2" ) <!-- 
                    <li>
                        <a href="#" data-toggle="tooltip" data-placement="right" title="ตั้งค่า" data-nav-target="#settings" class="{{ $dropdown_name === "settings" ? "active" : "" }}">
                            <i data-feather="settings"></i>
                        </a>
                    </li>
                    -->
                    @endif
                    @endif
                    <!--
                    <li>
                        <a data-href="{{ route('backend.auth.ajax_logout') }}" href="#" onclick="handleLogout(this,1)" data-toggle="tooltip" data-placement="right" {{-- {{ route('backend.auth.logout') }} --}} title="ออกจากระบบ">
                            <i data-feather="log-out"></i>
                        </a>
                    </li>
                    -->
            </ul>
        </div>
        {{--- ปิด tab menu ด้านซ้ายใต้รูปภาพ ----}}
    </div>
    <div class="navigation-menu-body">
        <!--- ชื่อโปรแกรม ---->
        <div>
            <div id="navigation-logo">
                <a href="#">
                    <h4>บริหารข้อมูลบุคคล</h4>
                </a>
            </div>
        </div>
        {{--- ชื่อโปรแกรม ----}}
        {{--- เปิด tab menu ย่อย ----}}
        <div class="navigation-menu-group">
            <div class="{{ $user_data->isAdmin() && $dropdown_name != "settings" ? "open" : "" }}" id="level-1">
                {{-- ผู้ดูแลระบบ --}}
                <ul>
                    <li>
                        <a class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 {{ $page_name === "dashboard-main" ? "active" : "" }}" href="{{ url('/dashboard-main') }}">
                            <i class="fas fa-layer-group" style="width: 15px;"></i>
                            <span class="pl-2">แดชบอร์ด</span>
                        </a>
                    </li>
                    <li class="{{ $dropdown_name === "D01" ? "open" : "" }}">
                        <a href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="fas fa-address-card" style="width: 15px;"></i>
                            <span class="pl-2">ยื่นขอ/รออนุมัติ</span>
                        </a>
                        <ul id="d01" style="{{ $dropdown_name === "D01" || $page_name === "evaluation" && $dropdown_name === "D01" ? "display: block" : "display: none" }}">
                            <li>
                                <a class="{{ $page_name === "leave" ? "active" : "" }}" href="{{ url('/leave') }}">
                                    ใบลา
                                    @if (!empty($doccount['count_leave_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/leave-approve')}}" title="{{ $doccount['count_leave_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_leave_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="{{ $page_name === "ot" ? "active" : "" }}" href="{{ url('/ot') }}">
                                    โอที
                                    @if (!empty($doccount['count_overtime_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/ot-approve')}}" title="{{ $doccount['count_overtime_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_overtime_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="{{ $page_name === "job" ? "active" : "" }}" href="{{ url('job') }}">
                                    Job
                                    @if (!empty($doccount['count_job_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/job-approve')}}" title="{{ $doccount['count_job_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_job_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="{{ $page_name === "warning" ? "active" : "" }}" href="{{ url('warning') }}">
                                    ใบเตือน
                                    @if (!empty($doccount['count_warning_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/warning-approve')}}" title="{{ $doccount['count_warning_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_warning_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="{{ $page_name === "request_documents" ? "active" : "" }}" href="{{ url('/request/documents') }}">
                                    ยื่นคำร้อง
                                    @if (!empty($doccount['count_req_documents_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/equest/documents/approve')}}" title="{{ $doccount['count_req_documents_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_req_documents_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ $dropdown_name === "D02" ? "open" : "" }}">
                        <a href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="fas fa-laptop" style="width: 15px;"></i>
                            <span class="pl-2">ข้อมูลงาน</span>
                        </a>
                        <ul id="d02" style="{{ $dropdown_name === "D02" || $page_name === "evaluation" && $dropdown_name === "D02" ? "display: block" : "display: none" }}">
                            <li>
                                <a class="{{ $page_name === "evaluation" ? "active" : "" }}" href="{{ url('evaluation') }}">ประเมิน</a>
                            </li>
                            <li>
                                <a class="{{ $page_name === "upsalary" ? "active" : "" }}" href="{{ url('upsalary') }}">
                                    ปรับเงินเดือน
                                    @if (!empty($doccount['count_upsalary_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/upsalary-approve')}}" title="{{ $doccount['count_upsalary_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_upsalary_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>


                            <li>
                                <a class="{{ $page_name === "payroll" ? "active" : "" }}" href="{{ url('payroll') }}">คำนวณเงินเดือน</a>
                            </li>
                            
                            <li>
                                <a class="{{ $page_name === "balance" ? "active" : "" }}" href="{{ url('balance') }}">รายได้/รายหัก</a>
                            <li>
                             {{--    
                                <a class="{{ $page_name === "vacancies" ? "active" : "" }}" href="{{ url('vacancies') }}">ตำแหน่งงาน</a>
                            </li>                            
                                <a class="{{ $page_name === "payroll" ? "active" : "" }}" href="{{ url('payroll') }}">คำนวณเงินเดือน</a>
                            </li> 
                            --}}
                            <li>
                                <a class="{{ $page_name === "report" ? "active" : "" }}" href="{{ url('report') }}">รายงาน</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ $dropdown_name === "D03" ? "open" : "" }}">
                        <a href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="fas fa-building" style="width: 15px;"></i>
                            <span class="pl-2">ข้อมูลบริษัท</span>
                        </a>
                        <ul style="{{ $dropdown_name === "D03" ? "display: block" : "display: none" }}">
                            <li>
                                <a class="{{ $page_name === "masters" ? "active" : "" }}" href="{{ url('/masters') }}">มาสเตอร์</a>
                            </li>
                            <li>
                                <a class="{{ $page_name === "employee" ? "active" : "" }}" href="{{ url('/employee') }}">ทะเบียนประวัติ</a>
                            </li>
                        </ul>
                    </li>
                    {{--  
                    <li>
                        <a class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 {{ $page_name === "payroll" ? "active" : "" }}" href="{{ url('/payroll') }}">
                            <i class="fas fa-calculator" style="width: 15px;"></i>
                            <span class="pl-2">คำนวณเงินเดือน</span>
                        </a>
                    </li>
                    --}}
                </ul>
            </div>
            <div class="{{ $user_data->isSubAdmin() && $dropdown_name != "settings" ? "open" : "" }}" id="level-2">
                {{-- ฝ่ายบุคคล --}}
                <ul>
                    <li>
                        <a class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 {{ $page_name === "dashboard-main" ? "active" : "" }}" href="{{ url('/dashboard-main') }}">
                            <i class="fas fa-layer-group" style="width: 15px;"></i>
                            <span class="pl-2">แดชบอร์ด</span>
                        </a>
                    </li>
                    
                    <li class="{{ $dropdown_name === "D01" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_subadmin_01" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="fas fa-address-card" style="width: 15px;"></i>
                            <span class="pl-2">ยื่นขอ/รออนุมัติ</span>
                        </a>
                        <ul id="block_menu_subadmin_01" style="{{ $dropdown_name === "D01" ? "display: block" : "display: none" }}">
                            <li>
                                <a id="menu_subadmin_leave" class="{{ $page_name === "leave" ? "active" : "" }}" href="{{ url('/leave') }}">
                                    ใบลา
                                    @if (!empty($doccount['count_leave_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/leave-approve')}}" title="{{ $doccount['count_leave_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_leave_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a id="menu_subadmin_ot" class="{{ $page_name === "ot" ? "active" : "" }}" href="{{ url('/ot') }}">
                                    โอที
                                    @if (!empty($doccount['count_overtime_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/ot-approve')}}" title="{{ $doccount['count_overtime_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_overtime_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a id="menu_subadmin_job" class="{{ $page_name === "job" ? "active" : "" }}" href="{{ url('job') }}">
                                    Job
                                    @if (!empty($doccount['count_job_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/job-approve')}}" title="{{ $doccount['count_job_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_job_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a id="menu_subadmin_warning" class="{{ $page_name === "warning" ? "active" : "" }}" href="{{ url('warning') }}">
                                    ใบเตือน
                                    @if (!empty($doccount['count_warning_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/warning-approve')}}" title="{{ $doccount['count_warning_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_warning_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a id="menu_subadmin_request_documents" class="{{ $page_name === "request_documents" ? "active" : "" }}" href="{{ url('/request/documents') }}">
                                    ยื่นคำร้อง
                                    @if (!empty($doccount['count_req_documents_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/equest/documents/approve')}}" title="{{ $doccount['count_req_documents_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_req_documents_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ $dropdown_name === "D02" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_subadmin_02" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="fas fa-laptop" style="width: 15px;"></i>
                            <span class="pl-2">ข้อมูลงาน</span>
                        </a>
                        <ul id="block_menu_subadmin_02" style="{{ $dropdown_name === "D02" ? "display: block" : "display: none" }}">
                            <li>
                                <a id="menu_subadmin_upsalary" class="{{ $page_name === "upsalary" ? "active" : "" }}" href="{{ url('upsalary') }}">
                                    ปรับเงินเดือน
                                    @if (!empty($doccount['count_upsalary_form']))
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/upsalary-approve')}}" title="{{ $doccount['count_upsalary_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_upsalary_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li><a id="menu_subadmin_balance" class="{{ $page_name === "balance" ? "active" : "" }}" href="{{ url('balance') }}">รายได้/รายหัก</a></li>
                            {{-- <li><a id="menu_subadmin_vacancies" class="{{ $page_name === "vacancies" ? "active" : "" }}" href="{{ url('vacancies') }}">ตำแหน่งงาน</a></li> --}}
                            <li><a id="menu_subadmin_payroll" class="{{ $page_name === "payroll" ? "active" : "" }}" href="{{ url('payroll') }}">คำนวณเงินเดือน</a></li>
                            <li><a id="menu_subadmin_report" class="{{ $page_name === "report" ? "active" : "" }}" href="{{ url('report') }}">รายงาน</a></li>
                        </ul>
                    </li>
                
                    <li class="{{ $dropdown_name === "D03" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_subadmin_03" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="fas fa-building" style="width: 15px;"></i>
                            <span class="pl-2">ข้อมูลบริษัท</span>
                        </a>
                        <ul id="block_menu_subadmin_03" style="{{ $dropdown_name === "D03" ? "display: block" : "display: none" }}">
                            <li><a id="menu_subadmin_masters" class="{{ $page_name === "masters" ? "active" : "" }}" href="{{ url('/masters') }}">มาสเตอร์</a></li>
                            <li><a id="menu_subadmin_employee" class="{{ $page_name === "employee" ? "active" : "" }}" href="{{ url('/employee') }}">ทะเบียนประวัติ</a></li>
                        </ul>
                    </li>
                    {{-- <li>
                        <a class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 {{ $page_name === "payroll" ? "active" : "" }}" href="{{ url('/payroll') }}">
                            <i class="fas fa-calculator" style="width: 15px;"></i>
                            <span class="pl-2">คำนวณเงินเดือน</span>
                        </a>
                    </li> --}}
                    <li class="{{ $dropdown_name === "D04" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_subadmin_04" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="far fa-address-card" style="width: 15px;"></i>
                            <span class="pl-2">บัญชีของฉัน</span>
                        </a>
                        <ul id="block_menu_subadmin_02" style="{{ $dropdown_name === "D04" ? "display: block" : "display: none" }}">
                            <li><a id="menu_subadmin_profile" class="{{ $page_name === "profile" ? "active" : "" }}" href="{{ url('profile') }}">โปรไฟล์</a></li>
                            <li><a id="menu_subadmin_income" class="{{ $page_name === "income" ? "active" : "" }}" href="{{ url('income') }}">รายได้</a></li>
                            <li><a id="menu_subadmin_welfare" class="{{ $page_name === "welfare" ? "active" : "" }}" href="{{ url('welfare') }}">สิทธิ</a></li>
                            <li><a id="menu_subadmin_evaluation" class="{{ $page_name === "evaluation" ? "active" : "" }}" href="{{ url('evaluation') }}">ประเมิน</a></li>
                        </ul>
                    </li>
                </ul>
                
            </div>
            <div class="{{ $user_data->isUser() && $user_data->isPositionChief() ? "open" : "" }}" id="level-3">
                {{-- หัวหน้า --}}
                <ul>
                    <li>
                        <a  id="icon_menu_dashboard_emp_3"class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 {{ $page_name === "dashboard-emp-3" ? "active" : "" }}" href="{{ url('/dashboard-emp-3') }}">
                            <i class="fas fa-layer-group" style="width: 15px;"></i>
                            <span class="pl-2">แดชบอร์ด</span>
                        </a>
                    </li>
                    <li class="{{ $dropdown_name === "D01" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_chief_01" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="fas fa-address-card" style="width: 15px;"></i>
                            <span class="pl-2">ยื่นขอ/รออนุมัติ</span>
                        </a>
                        <ul id="block_menu_chief_01" style="{{ $dropdown_name === "D01" ? "display: block" : "display: none" }}">
                            <li>
                                <a id="menu_chief_leave" class="{{ $page_name === "leave" ? "active" : "" }}" href="{{ url('/leave') }}">ใบลา
                                    @if (!empty($doccount['count_leave_form']) && $doccount['count_leave_form'] != '0')
                                    <span class="badge badge-danger navigation-sub-menu-li" data-href="{{url('/leave-approve')}}" title="{{ $doccount['count_leave_form'].' เอกสารที่รออนุมัติ' }}">
                                        {{ $doccount['count_leave_form'] }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li><a id="menu_chief_ot" class="{{ $page_name === "ot" ? "active" : "" }}" href="{{ url('/ot') }}">โอที</a></li>
                            <li><a id="menu_chief_job" class="{{ $page_name === "job" ? "active" : "" }}" href="{{ url('job') }}">Job</a></li>
                            <li><a id="menu_chief_warning" class="{{ $page_name === "warning" ? "active" : "" }}" href="{{ url('warning') }}">ใบเตือน</a></li>
                            <li><a id="menu_chief_request_documents" class="{{ $page_name === "request_documents" ? "active" : "" }}" href="{{ url('/request/documents') }}">ยื่นคำร้อง</a></li>
                            {{-- <li><a id="menu_chief_vacancies" class="{{ $page_name === "vacancies" ? "active" : "" }}" href="{{ url('vacancies') }}">ตำแหน่งงาน</a></li> --}}
                        </ul>
                    </li>
                    <li class="{{ $dropdown_name === "D02" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_chief_02" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="fas fa-laptop" style="width: 15px;"></i>
                            <span class="pl-2">ข้อมูลงาน</span>
                        </a>
                        <ul id="block_menu_chief_02" style="{{ $dropdown_name === "D02" ? "display: block" : "display: none" }}">
                            <li><a id="menu_chief_report" class="{{ $page_name === "report" ? "active" : "" }}" href="{{ url('report') }}">รายงาน</a></li>
                        </ul>
                    </li>
                    <li class="{{ $dropdown_name === "D04" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_chief_04" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="far fa-address-card" style="width: 15px;"></i>
                            <span class="pl-2">บัญชีของฉัน</span>
                        </a>
                        <ul id="block_menu_chief_04" style="{{ $dropdown_name === "D04" ? "display: block" : "display: none" }}">
                            <li><a id="menu_chief_profile" class="{{ $page_name === "profile" ? "active" : "" }}" href="{{ url('profile') }}">โปรไฟล์</a></li>
                            <li><a id="menu_chief_income" class="{{ $page_name === "income" ? "active" : "" }}" href="{{ url('income') }}">รายได้</a></li>
                            <li><a id="menu_chief_welfare" class="{{ $page_name === "welfare" ? "active" : "" }}" href="{{ url('welfare') }}">สิทธิ</a></li>
                            <li><a id="menu_chief_evaluation" class="{{ $page_name === "evaluation" ? "active" : "" }}" href="{{ url('evaluation') }}">ประเมิน</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="{{ $user_data->isUser() && $user_data->isPositionStaff() && $user_data->isGroupProbation() == false ? "open" : "" }}" id="level-4">
                {{-- พนักงาน --}}
                <ul>
                    <li>
                        <a id="icon_menu_dashboard_emp_4" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 {{ $page_name === "dashboard-emp-4" ? "active" : "" }}" href="{{ url('/dashboard-emp-4') }}">
                            <i class="fas fa-layer-group" style="width: 15px;"></i>
                            <span class="pl-2">แดชบอร์ด</span>
                        </a>
                    </li>
                    <li class="{{ $dropdown_name === "D01" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_emp_01" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 ">
                            <i class="fas fa-address-card" style="width: 15px;"></i>
                            <span class="pl-2">ยื่นขอ/รออนุมัติ</span>
                        </a>
                        <ul id="block_menu_emp_01" style="{{ $dropdown_name === "D01" ? "display: block" : "display: none" }}">
                            <li><a id="menu_emp_leave" class="{{ $page_name === "leave" ? "active" : "" }}" href="{{ url('/leave') }}">ใบลา{{-- <span class="badge badge-danger">5</span> --}}</a> </li>
                            <li><a id="menu_emp_ot" class="{{ $page_name === "ot" ? "active" : "" }}" href="{{ url('/ot') }}">โอที</a></li>
                            <li><a id="menu_emp_job" class="{{ $page_name === "job" ? "active" : "" }}" href="{{ url('job') }}">Job</a></li>
                            <li><a id="menu_emp_warning" class="{{ $page_name === "warning" ? "active" : "" }}" href="{{ url('warning') }}">ใบเตือน</a></li>
                            <li><a id="menu_emp_request_documents" class="{{ $page_name === "request_documents" ? "active" : "" }}" href="{{ url('/request/documents') }}">ยื่นคำร้อง</a></li>

                            {{-- <li><a id="menu_emp_report" class="{{ $page_name === "report" ? "active" : "" }}" href="{{ url('report') }}">รายงาน</a></li> --}}
                        </ul>
                    </li>
                    <li class="{{ $dropdown_name === "D02" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_emp_02" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 ">
                            <i class="fas fa-laptop" style="width: 15px;"></i>
                            <span class="pl-2">ข้อมูลงาน</span>
                        </a>
                        <ul id="block_menu_emp_02" style="{{ $dropdown_name === "D02" ? "display: block" : "display: none" }}">
                            <li><a id="menu_emp_report" class="{{ $page_name === "report" ? "active" : "" }}" href="{{ url('report') }}">รายงาน</a></li>
                        </ul>
                    </li>
                    <li class="{{ $dropdown_name === "D04" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_emp_04" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="far fa-address-card" style="width: 15px;"></i>
                            <span class="pl-2">บัญชีของฉัน</span>
                        </a>
                        <ul id="block_menu_emp_04" style="{{ $dropdown_name === "D04" ? "display: block" : "display: none" }}">
                            <li><a id="menu_emp_profile" class="{{ $page_name === "profile" ? "active" : "" }}" href="{{ url('profile') }}">โปรไฟล์</a></li>
                            <li><a id="menu_emp_income" class="{{ $page_name === "income" ? "active" : "" }}" href="{{ url('income') }}">รายได้</a></li>
                            <li><a id="menu_emp_welfare" class="{{ $page_name === "welfare" ? "active" : "" }}" href="{{ url('welfare') }}">สิทธิ</a></li>
                            <li><a id="menu_emp_evaluation" class="{{ $page_name === "evaluation" ? "active" : "" }}" href="{{ url('evaluation') }}">ประเมิน</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="{{ $user_data->isUser() && $user_data->isPositionStaff() && $user_data->isGroupProbation() ? "open" : "" }}" id="level-5">
                {{-- ทดลองงาน --}}
                <ul>
                    <li>
                        <a class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 {{ $page_name === "dashboard-emp-4" ? "active" : "" }}" href="{{ url('/dashboard-emp-4') }}">
                            <i class="fas fa-layer-group" style="width: 15px;"></i>
                            <span class="pl-2">แดชบอร์ด</span>
                        </a>
                    </li>
                    <li class="{{ $dropdown_name === "D01" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_emp_probation_01" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 ">
                            <i class="fas fa-address-card" style="width: 15px;"></i>
                            <span class="pl-2">ยื่นขอ/รออนุมัติ</span>
                        </a>
                        <ul id="block_menu_emp_probation_01" style="{{ $dropdown_name === "D01" ? "display: block" : "display: none" }}">
                            <li><a id="menu_emp_probation_leave" class="{{ $page_name === "leave" ? "active" : "" }}" href="{{ url('/leave') }}">ใบลา{{-- <span class="badge badge-danger">5</span> --}}</a> </li>
                            <li><a id="menu_emp_probation_ot" class="{{ $page_name === "ot" ? "active" : "" }}" href="{{ url('/ot') }}">โอที</a></li>
                            <li><a id="menu_emp_probation_job" class="{{ $page_name === "job" ? "active" : "" }}" href="{{ url('job') }}">Job</a></li>
                            <li><a id="menu_emp_probation_warning" class="{{ $page_name === "warning" ? "active" : "" }}" href="{{ url('warning') }}">ใบเตือน</a></li>
                            {{-- <li><a id="menu_emp_probation_report" class="{{ $page_name === "report" ? "active" : "" }}" href="{{ url('report') }}">รายงาน</a></li> --}}
                        </ul>
                    </li>
                    <li class="{{ $dropdown_name === "D02" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_emp_probation_02" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 ">
                            <i class="fas fa-laptop" style="width: 15px;"></i>
                            <span class="pl-2">ข้อมูลงาน</span>
                        </a>
                        <ul id="block_menu_emp_probation_02" style="{{ $dropdown_name === "D02" ? "display: block" : "display: none" }}">
                            <li><a id="menu_emp_probation_report" class="{{ $page_name === "report" ? "active" : "" }}" href="{{ url('report') }}">รายงาน</a></li>
                        </ul>
                    </li>
                    <li class="{{ $dropdown_name === "D04" ? "open" : "" }}">
                        <!--open-->
                        <a id="icon_menu_emp_probation_04" href="#" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0">
                            <i class="far fa-address-card" style="width: 15px;"></i>
                            <span class="pl-2">บัญชีของฉัน</span>
                        </a>
                        <ul id="block_menu_emp_probation_04" style="{{ $dropdown_name === "D04" ? "display: block" : "display: none" }}">
                            <li><a id="menu_emp_probation_profile" class="{{ $page_name === "profile" ? "active" : "" }}" href="{{ url('profile') }}">โปรไฟล์</a></li>
                            <li><a id="menu_emp_probation_income" class="{{ $page_name === "income" ? "active" : "" }}" href="{{ url('income') }}">รายได้</a></li>
                            <li><a id="menu_emp_probation_welfare" class="{{ $page_name === "welfare" ? "active" : "" }}" href="{{ url('welfare') }}">สิทธิ</a></li>
                            {{-- <li><a id="menu_emp_evaluation" class="{{ $page_name === "evaluation" ? "active" : "" }}" href="{{ url('evaluation') }}">ประเมิน</a>
                    </li> --}}
                </ul>
                </li>
                </ul>
            </div>
            <div class="{{ $user_data->isApplicant() ? "open" : "" }}" id="level-6">
                {{-- ผู้สมัครงาน --}}
                <ul>
                    <li class="">
                        <!--open-->
                        <a href="" class="navigation-divider font-size-15 font-weight-bold text-primary mb-0" data-toggle="tooltip" data-placement="right" data-html="true" title="- ข้อมูลตำแหน่งงานและรายละเอียดการสมัครงาน">
                            <i class="far fa-file-alt" style="width: 15px;"></i>
                            แบบฟอร์มสมัครงาน
                        </a>
                    </li>
                </ul>
            </div>
            <div class="{{ $dropdown_name === "settings" ? "open" : "" }}" id="settings">
                <ul>
                    <li>
                        <a class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 {{ $page_name === "setup-wizard" ? "active" : "" }}" href="{{ url('/setup-wizard') }}">ตั้งค่าเบื้องต้น</a>
                    </li>
                    {{--
                    <li>
                        <a class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 {{ $page_name === "manage-users" ? "active" : "" }}"
                    href="{{ url('/manage-users') }}">จัดการข้อมูลผู้ใช้</a>
                    </li>
                    <li>
                        <a class="navigation-divider font-size-15 font-weight-bold text-primary mb-0 {{ $page_name === "page-access-rights" ? "active" : "" }}" href="{{ url('/page-access-rights') }}">สิทธิการเข้าถึง</a>
                    </li>
                    <li>
                        <a href="#">ตั้งค่าการแจ้งเตือน</a>
                        <ul>
                            <li><a href="#">404</a></li>
                        </ul>
                    </li>
                    --}}
                </ul>
            </div>
        </div>
        {{--- เปิด tab menu ย่อย ----}}
    </div>
</div>