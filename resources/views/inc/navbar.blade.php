
<div>
  <ul class="navbar-nav">
    <li class="nav-item navigation-toggler">
      <a href="#" class="nav-link" title="Hide navigation">
        <i data-feather="arrow-left"></i>
      </a>
    </li>
    <li class="nav-item remove-navigation-toggler d-none">
      <a href="#" class="nav-link" title="Hide navigation">
        <i data-feather="arrow-right"></i>
      </a>
    </li>
    <li class="nav-item navigation-toggler mobile-toggler">
      <a href="#" class="nav-link" title="Show navigation">
        <i data-feather="menu"></i>
      </a>
    </li>
  </ul>
</div>

<div>
  <ul class="navbar-nav">

    <li class="nav-item pointer">
      <a href="{{ $company_data['helper'] != '1' ? url('/profile') : '#'}}" class="nav-link" title="โปรไฟล์">
        @php
          if ($user_data->isAdmin()) {
            $status = 'ผู้ดูแลระบบ';
          }else if($user_data->isSubAdmin()) {
            $status = 'ฝ่ายบุคคล';
          }else if($user_data->isUser() && $user_data->isPositionChief()) {
            $status = 'ระดับหัวหน้า';
          }else if($user_data->isUser() && $user_data->isPositionStaff()) {
            $status = 'ระดับพนักงาน';
          }        
          /*
          switch ($user_data->user_level) {
            case '1':
              $status = 'ผู้ดูแลระบบ';
              break;
            case '2':
              $status = 'ฝ่ายบุคคล';
              break;
            case '3':
              $status = 'หัวหน้า';
              break;
            case '4':
              $status = 'พนักงาน';
              break;
            case '5':
              $status = 'ผู้เกี่ยวข้อง';
              break;
            default:
              $status = 'ทดลองงาน';
              break;
          }
          */
          if ($user_data->isAdmin()) {
              $username = 'ผู้ดูแลระบบ';
          }else {
            if ($user_data->is_expat != '1') {
              $username = $user_data->title_name.' '.$user_data->name;
            }else {
              $username = $user_data->title_name_en.' '.$user_data->name_en;
            }
          }
        @endphp
        <span class="bg-success" style="width: 10px;height: 10px; border-radius: 50%; margin-right: 4px;" title="{{ $status }}"></span>
        <span>{{ $username }}</span> <span class="small mt-1 ml-1" style="{{ $user_data->user_level == '1' ? 'display:none': "" }}">{{ '('.$status.')' }}</span>
      </a>
    </li>
    @if ($user_data->isAdmin() || $user_data->isSubAdmin())    
    <li id="nav_icon_documents" class="nav-item {{ $company_data['helper'] == '1' ? 'd-none' : "" }}">
      <a href="{{ url('/documents') }}" class="nav-link" title="คู่มือการใช้งาน">
        <i data-feather="book"></i>
      </a>
    </li>
    {{-- 
    <li id="nav_icon_company_profile_form" class="nav-item {{ $company_data['helper'] == '1' ? 'd-none' : "" }}">
      <a href="{{ url('/company-profile-form') }}" class="nav-link" title="ข้อมูลบริษัท">
        <i data-feather="briefcase"></i>
      </a>
    </li>
     --}}
     {{-- 
    <li id="nav_icon_document_number" class="nav-item {{ $company_data['helper'] == '1' ? 'd-none' : "" }}">
      <a href="{{ url('/document-number') }}" class="nav-link" title="เลขที่เอกสาร">
        <i data-feather="file-text"></i>
      </a>
    </li>
     --}}
    @endif
    
    <li id="nav_icon_message_square" class="nav-item dropdown">
      <a href="{{ url('/topic/news') }}" class="nav-link {{ $user_data->countNews() != "0" ? "nav-link-notify" : ""}} " title="ประกาศข่าวสาร">
        <i data-feather="volume-1"></i>
      </a>
    </li>
    <li id="nav_icon_alert" class="nav-item dropdown {{ $company_data['helper'] == '1' ? 'd-none' : "" }}">
      <a href="#" id="alert-btn" class="nav-link {{ $user_data->countNotify() != "0" ? "nav-link-notify" : ""}} " title="แจ้งเตือน" data-toggle="dropdown">
        <i data-feather="bell"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
        <div class="p-4 text-center d-flex justify-content-between bg-primary" data-backround-image="">
          <h6 class="mb-0">แจ้งเตือน</h6>
          <span class="font-size-11 opacity-7 text-dark">
            <a target="" href="">
            @php
              //echo $user_data->countNotify();  
            @endphp 
            <span id="countNotify"></span>
            แจ้งเตือนที่ยังไม่ได้อ่าน
            </a>
          </span>
        </div>
         
        <div>
          <ul class="list-group list-group-flush" id="notify_header">
            <li class="ml-3 mt-2 mb-2 text-muted">
              กำลังโหลดข้อมูล...
            </li>
          </ul>
        </div>
        <div class="p-2 text-right">
          <ul class="list-inline small">
            <li class="list-inline-item">
              <a href="#" class="d-none" id="mark_all_read" data-notifykeyarr="" onclick="markAsReadAll()">อ่านแล้วทั้งหมด</a>
            </li>
          </ul>
        </div>
      </div>
    </li>
    <li id="nav_icon_fullscreen" class="nav-item dropdown">
      <a href="#" class="nav-link" title="ขยายหน้าจอ" data-toggle="fullscreen">
        <i class="maximize" data-feather="maximize"></i>
        <i class="minimize" data-feather="minimize"></i>
      </a>
    </li>
    <li id="nav_icon_log_out" class="nav-item dropdown">
      <a  data-href="{{ route('backend.auth.ajax_logout') }}" href="#" onclick="handleLogout(this,1)" class="nav-link" title="ออกจากระบบ">
        <i data-feather="log-out"></i>
      </a>
    </li>
  </ul>

  <ul class="navbar-nav d-flex align-items-center">
    <li class="nav-item header-toggler">
      <a href="#" class="nav-link">
        <i data-feather="arrow-down"></i>
      </a>
    </li>
  </ul>

</div>