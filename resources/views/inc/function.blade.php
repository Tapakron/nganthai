{{-- Functions --}}
@php


if (!function_exists('setTitle')){
    function setTitle($page_name, $page_name_th, $page_name_v1, $page_name_v2) {
        if ($page_name_th != '' && $page_name_v1 == '' && $page_name_v2 == '') {
            echo $page_name_th;
        }else if ($page_name_th != '' && $page_name_v1 != '' && $page_name_v2 == '') {
            echo $page_name_v1;
        }else{
            echo $page_name_v2;
        }
    }
}

if (!function_exists('set_breadcrumb')) {
    function set_breadcrumb($page_name, $page_name_th, $category_name, $category_name_th, $page_name_th_url, $page_name_v1, $page_name_v1_url, $page_name_v2, $page_name_v2_url) {
        
        //For Eng
        $category = ucfirst($category_name);
        
        $removeUnderscore = str_replace('_', ' ', $page_name);

        $removeDash = str_replace('-', ' ', $removeUnderscore);

        $page = ucwords($removeDash);

        //------------------------------------------------------------

        //For TH
        $category_th = $category_name_th;
        
        $removeUnderscore_th = str_replace('_', ' ', $page_name_th);

        $removeDash_th = str_replace('-', ' ', $removeUnderscore_th);

        $page_th = $removeDash_th;

        //------------------------------------------------------------
        $company_breadcrumb = '
            <li class="breadcrumb-item"><a title="คลิก!" href="/dashboard-main">'. $category_th .'</a></li>
        ';
        if ($page_name == 'masters') {
            if ($page_name_v1_url == '/employee-group-day-work' || $page_name_v1_url == '/employee-group-time-work' || $page_name_v1_url == '/employee-absence-work' || $page_name_v1_url == '/employee-retire') {
                $page_name_th_url1 = $page_name_th_url.'/02';
            }else if ($page_name_v1_url == '/revenue-master' || $page_name_v1_url == '/deduction-master' || $page_name_v1_url == '/fund' || $page_name_v1_url == '/holiday') {
                $page_name_th_url1 = $page_name_th_url.'/03';
            }else if ($page_name_v1_url == '/date-salary' || $page_name_v1_url == '/month-salary' || $page_name_v1_url == '/minimum-wage') {
                $page_name_th_url1 = $page_name_th_url.'/04';
            }else{
                $page_name_th_url1 = $page_name_th_url;
            }
        }else{
            $page_name_th_url1 = $page_name_th_url;
        }
        if ($page_name_v1 == '' && $page_name_v2 == '') {
            $company_breadcrumb .= '<li class="breadcrumb-item active" aria-current="page"><a class="text-primary" title="คลิก!" href="'. $page_name_th_url1 .'">'. $page_th .'</a></li>';
        }else{
            if ($page_name_v1 != '' && $page_name_v2 == '') {
                $company_breadcrumb .= '
                <li class="breadcrumb-item"><a title="คลิก!" href="'. $page_name_th_url1 .'">'. $page_th .'</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a class="text-primary" title="คลิก!" href="'. $page_name_v1_url .'">'. $page_name_v1 .'</a></li>
                ';
            }else{
                $company_breadcrumb .= '
                <li class="breadcrumb-item"><a title="คลิก!" href="'. $page_name_th_url1 .'">'. $page_th .'</a></li>
                <li class="breadcrumb-item"><a title="คลิก!" href="'. $page_name_v1_url .'">'. $page_name_v1 .'</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a class="text-primary" title="คลิก!" href="'. $page_name_v2_url .'">'. $page_name_v2 .'</a></li>
                ';
            }
        }
        if($category_name == 'company'){
            echo $company_breadcrumb;
        }
    }
}

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function scrollspy($offset) {
    echo 'data-target="#navSection" data-spy="scroll" data-offset="'. $offset . '"';
}

@endphp