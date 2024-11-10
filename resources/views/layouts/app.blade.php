@include('inc.function')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:description" content="บุคคล.com​ โปรแกรม​คิดเงินเดือน​ ตัวช่วยบริหารงาน​ HR">
    <meta property="og:image" content="{{ asset('assets/pr/images/logo/12.png') }}">

    <title>{{ setTitle($page_name, $page_name_th, $page_name_v1, $page_name_v2) }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.png') }}" />

    <!-- Plugin styles -->
    <link rel="stylesheet" href="{{ asset('vendors/bundle.css') }}" type="text/css">

    <!-- App styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" type="text/css">

    <!-- Admin styles -->
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome-free-5.15.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-admin.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/media-screen.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/reset-pass-admin.css') }}" type="text/css">
    <!-- WYSIWYG Editor css -->
    <link href="{{ asset('vendors/wysiwyag/richtext.css') }}" rel="stylesheet" />

    @include('inc.styles')
    @include('inc.gtag')
    @yield('css-content')

</head>

<body class="<?php
                if ($pagescale === '2') {
                    echo 'navigation-toggle-one';
                }
                ?>
">
    @include('inc.gtag01')


    {{-- navigation-toggle-one --}}
    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <!-- end::preloader -->

    <!-- begin::header -->
    <div class="header d-print-none">
        @include('inc.navbar')
    </div>
    <!-- end::header -->

    <!-- begin::main -->
    <div id="main">

        <!-- begin::navigation -->
        @include('inc.navigation')
        <!-- end::navigation -->

        <!-- begin::main-content -->
        <main class="main-content">

            <!-- begin::page-header -->
            @include('inc.breadcrumb')
            <!-- end::page-header -->

            @yield('content')

            <!-- begin::footer -->
            @include('inc.footer')
            <!-- end::footer -->

        </main>
        <!-- end::main-content -->

    </div>
    <span class="float d-none" id="menu-share">
        <i class="fa fa-angle-double-right my-float d-print-none"></i>
    </span>
    <div class="float-ul">
        <ul>
            <li title="เพจเฟสบุ๊คของเรา">
                <span class="A_pointer">
                    <i class="fas fa-info my-float" title="กลับด้านบน"></i>
                </span>
            </li>
        </ul>
    </div>
    @include('modal.change-password-admin')
    <!-- end::main -->

    <!-- begin::global scripts -->
    <script src="{{ asset('vendors/bundle.js') }}"></script>
    <!-- begin::custom scripts -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/view-upload-photo.js') }}"></script>
    <script src="{{ asset('assets/js/app-token.js') }}"></script>
    <script src="{{ asset('assets/js/app-btn.js') }}"></script>
    <script src="{{ asset('assets/js/app-loading.js') }}"></script>
    <script src="{{ asset('assets/js/app-service.js') }}"></script>
    <!-- WYSIWYG Editor js -->
    <script src="{{ asset('vendors/wysiwyag/jquery.richtext.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js-external/reset-pass-admin.js') }}"></script>
    <!-- begin::admin scripts -->
    <script type="text/javascript">
        var APP_BASE_URL = @json(url('/'));
        var companyData = @json($company_data);
        var userData = @json($user_data);
        //------------------------------------------
        var user_role = {}

        user_role.isAdmin = @json($user_data->isAdmin());
        user_role.isSubAdmin = @json($user_data->isSubAdmin());
        user_role.isChief = @json($user_data->isUser() && $user_data->isPositionChief() ? true : false);
        user_role.isStaff = @json($user_data->isUser() && $user_data->isPositionStaff() ? true : false);
        user_role.isGroupProbation = @json($user_data->isUser() && $user_data->isPositionStaff() && $user_data->isGroupProbation() ? true : false);
        user_role.isApplicant = @json($user_data->isApplicant() ? true : false);
        //------------------------------------------
    </script>
    <script type="text/javascript">
        const key_logout = 'hrpro_signout';

        function markAsRead(e, id) {
            e.preventDefault();
            e.stopPropagation();
            // let lis =  $('.notify_header li');
            let countNotify = parseInt($('#countNotify').text()) - 1
            let li = $(`li[data-id="${id}"]`);

            $.ajax({
                type: "post",
                url: "/backend/notify/markAsRead",
                data: {
                    ids: id
                },
                success: function(response) {
                    if (response.success) {
                        if (li) {
                            $(li).remove();
                            if (countNotify > 0) {
                                $('#countNotify').empty().text(countNotify)
                            } else {
                                $('#countNotify').empty().text('ไม่พบข้อมูล')
                                $('#mark_all_read').addClass('d-none')
                            }
                        }
                    } else {
                        toastr.warning(response.message);
                    }
                }
            });
        }

        function markAsReadAll() {
            let setLoading = `<li class="ml-3 mt-2 mb-2 text-muted">
                กำลังโหลดข้อมูล...
            </li>`
            $('#notify_header').empty().append(setLoading)

            let allNotifyId = $('#mark_all_read').data('notifykeyarr')
            // console.log(allNotifyId);
            if (allNotifyId != "") {
                $.ajax({
                    type: "post",
                    url: "/backend/notify/markAsRead",
                    data: {
                        ids: allNotifyId
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#notify_header').empty()
                            $('#countNotify').empty().text('ไม่พบข้อมูล')
                            $('#mark_all_read').addClass('d-none')
                        } else {
                            toastr.warning(response.message);
                        }
                    }
                });
            } else {
                toastr.warning('ไม่พบข้อมูลรายการที่ยังไม่ได้อ่าน');
            }
        }

        function handleLogout(e) {
            let url = '/backend/auth/ajax_logout';
            $.ajax({
                    url: url,
                    method: "POST",
                })
                .done(function() {
                    console.log("success");
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function(response) {
                    window.localStorage.setItem(key_logout, Date.now().toString())

                    setTimeout(function() {
                        //console.log(userData);
                        if (parseInt(userData.user_level) <= 1) {
                            console.log();
                            // window.location = APP_BASE_URL + '/login';
                            window.location = response.data + 'login';

                        } else {
                            // window.location = APP_BASE_URL + "/emp-login/" + userData.sys_customer_code;
                            window.location = response.data + "emp-login/" + userData.sys_customer_code;
                            // window.location = "https://smethaidev.com'/emp-login/" + userData.sys_customer_code;
                        }
                    }, 100)
                });
        }

        $(document).ready(function() {

            if (window) {
                window.localStorage.removeItem(key_logout);
            }

            function syncSignout(e) {
                console.log(e.key);
                if (e.key === key_logout) {
                    // Log user out
                    window.location = APP_BASE_URL + '/login';
                }
            }

            window.addEventListener('storage', syncSignout)

            $("#modal-change-password-admin").on('hidden.bs.modal', function() {
                $(this).find('#frm-change-password-admin')[0].reset();
                $('#reset-pass-letter').removeClass().addClass('reset-pass-invalid')
                $('#reset-pass-capital').removeClass().addClass('reset-pass-invalid')
                $('#reset-pass-number').removeClass().addClass('reset-pass-invalid')
                $('#reset-pass-whitespace').removeClass().addClass('reset-pass-invalid')
                $('#reset-pass-length').removeClass().addClass('reset-pass-invalid')
                document.getElementById("reset-pass-message").style.display = "none";
            });

            // $('#alert-btn').click(function(e) {
            //     let setLoading = `<li class="ml-3 mt-2 mb-2 text-muted">
            //             กำลังโหลดข้อมูล...
            //         </li>`
            //     $('#notify_header').empty().append(setLoading)

            //     $.ajax({
            //         type: "get",
            //         url: "/backend/notify/filter",
            //         data:{
            //             limit:'all'
            //         },
            //         success: function(response) {

            //             if (response.success) {
            //                 // console.log(response);
            //                 let notify_body = ``
            //                 let notifyKeyArr = []
            //                 $('#countNotify').text(response.data.length)

            //                 if(response.data.length > 0){
            //                     response.data.forEach(function(item, index) {

            //                         notifyKeyArr.push(item.id)

            //                         let formtype = ''
            //                         let obj = JSON.parse(item.data)
            //                         let name = "";
            //                         let description = "";
            //                         switch (item.ref_type) {
            //                             case '1':
            //                                 //ใบขอทำงานล่วงเวลา
            //                                 formtype = "ใบขอทำงานล่วงเวลา (OT)"
            //                                 break;
            //                             case '2':
            //                                 //ใบขอทำงานพิเศษ
            //                                 formtype = "ใบขอทำงานพิเศษ (JOB)";
            //                                 name = obj.job_form_name || "";
            //                                 description = obj.job_form_description || "ไม่ระบุ";
            //                                 break;
            //                             case '3':
            //                                 //ใบเตือน
            //                                 formtype = "ใบเตือน"
            //                                 break;
            //                             case '4':
            //                                 //ใบปรับเงินเดือน
            //                                 formtype = "ใบปรับเงินเดือน"
            //                                 break;
            //                             case '5':
            //                                 //ใบลา
            //                                 formtype = "ใบลา"
            //                                 break;

            //                             default:
            //                                 //ไม่พบรูปแบบเอกสาร
            //                                 formtype = "ไม่พบรูปแบบเอกสาร"
            //                                 break;
            //                         }


            //                         // console.log(obj);
            //                         notify_body += `
            //                     <li data-id="${item.id}">
            //                         <a href="#" class="list-group-item d-flex hide-show-toggler notify-bg">
            //                             <div class="flex-grow-1">
            //                                 <p class="mb-0 line-height-20 d-flex justify-content-between">
            //                                     <span title="ประเภทเอกสาร" class="font-weight-700">${formtype}</span>
            //                                     <i title="ทำเครื่องหมาย อ่านแล้ว" data-toggle="tooltip" onclick="markAsRead(event ,'${item.id}')" class="hide-show-toggler-item fas fa-genderless font-size-16"></i>
            //                                 </p>
            //                                 <div class="small">
            //                                     ${name}
            //                                 </div>
            //                                 <span class="text-muted small" title="รายละเอียด">
            //                                     รายละเอียด : ${description}
            //                                 </span>
            //                                 <div class="text-muted small text-right" title="วันที่แจ้งเตือน">${item.date_time}</div>
            //                             </div>
            //                         </a>
            //                     </li>
            //                     `
            //                         $('#notify_header').empty().append(notify_body)

            //                     })
            //                     $('#mark_all_read').data('notifykeyarr',notifyKeyArr)
            //                     $('#mark_all_read').removeClass('d-none')
            //                 }else{
            //                     $('#notify_header').empty()
            //                     $('#countNotify').empty().text('ไม่พบข้อมูล')
            //                     $('#mark_all_read').addClass('d-none')
            //                 }
            //             }
            //         }
            //     });
            // });
            $('#alert-btn').click(function(e) {
                //

                $('#notify_header').empty().append(LOADER)
                $.ajax({
                    type: "get",
                    url: "/backend/notify/filter",
                    data: {
                        limit: 'all'
                    },
                    success: function(response) {
                        if (response.success) {
                            let notify_body = ``
                            let notifyKeyArr = response.data.notifyKeyArr
                            $('#countNotify').text(response.data.notify.length)
                            if (response.data.notify.length > 0) {
                                response.data.notify.forEach(function(item, index) {
                                    let formtype = item.formtype
                                    let obj = item.data
                                    let name = item.name;
                                    let description = item.description;
                                    notify_body += `
                                            <li data-id="${item.id}">
                                                 <a href="#" class="list-group-item d-flex hide-show-toggler notify-bg">
                                                     <div class="flex-grow-1">
                                                         <p class="mb-0 line-height-20 d-flex justify-content-between">
                                                             <span title="ประเภทเอกสาร" class="font-weight-700">${formtype}</span>
                                                             <i title="ทำเครื่องหมาย อ่านแล้ว" data-toggle="tooltip" onclick="markAsRead(event ,'${item.id}')" class="hide-show-toggler-item fas fa-genderless font-size-16"></i>
                                                         </p>
                                                
                                    `           

                                    if (name != '') {
                                        notify_body += ` 
                                        <div class="small">                   
                                        ${name}                
                                        </div>`
                                    }
                                    if (description != null) {
                                        notify_body += ` 
                                        <span class="text-muted small" title="รายละเอียด">
                                                             รายละเอียด : ${description}
                                                         </span>`
                                    }
                                    notify_body += ` 
                                          
                                    <div class="text-muted small text-right" title="วันที่แจ้งเตือน">${item.date_time}</div>
                                                     </div>
                                                 </a>
                                             </li>
                                                    </div>
                                                 </a>
                                             </li>`
                                 $('#notify_header').empty().append(notify_body)

                                


                                });
                                $('#mark_all_read').data('notifykeyarr',notifyKeyArr)
                                    $('#mark_all_read').removeClass('d-none')
                            } else {
                                $('#notify_header').empty()
                                $('#countNotify').empty().text('ไม่พบข้อมูล')
                                $('#mark_all_read').addClass('d-none')
                            }
                        }
                    }
                });
            });
            $(".navigation-sub-menu-li").each(function(idx, e) {
                $(e).click(function(event) {
                    // console.log(e);
                    event.preventDefault();
                    event.stopPropagation();
                    let href = $(e).data('href');
                    if (window) {
                        window.location = href;
                    }
                })
            })
        });
    </script>
    @include('inc.scripts')
    @yield('js-content')
</body>

</html>