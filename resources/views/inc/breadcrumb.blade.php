<div class="page-header">
  <div class="container-fluid d-sm-flex justify-content-between">
    {{-- <h4 class="breadcrumb-text-color">{{ setTitle($page_name, $page_name_th, $page_name_v1, $page_name_v2) }}</h4> --}}
    <div class="d-flex">
      <h4 class="breadcrumb-text-color">{{ setTitle($page_name, $page_name_th, $page_name_v1, $page_name_v2) }}</h4>
      @if ($page_name == "dashboard-main" && $page_name_th == "แดชบอร์ด")
        <div class="btn-binding-account" style="width: 3px;background-color: #1565c0; height: 100%;border-radius: 15px;display: inline-block;margin-left: 15px;margin-right: 15px;"></div>
        <img class="btn-binding-account job-posting a-pointer" src="{{ asset('assets/logo/logo-website-01.png') }}" alt="logo" style="zoom: .5;" title="ผูกบัญชีกับงานไทย"> 
      @endif
    </div>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        {{ set_breadcrumb($page_name, $page_name_th, $category_name, $category_name_th, $page_name_th_url, $page_name_v1, $page_name_v1_url, $page_name_v2, $page_name_v2_url) }}
      </ol>
    </nav>
  </div>
</div>