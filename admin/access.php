<?php


    $role = new Role();
    if(!$role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url($_SERVER['PHP_SELF']))){
        echo "<h3 style='margin:30px auto; font-weight:bold; text-align:center;'>Перегляд сторінки заборонено!</h3>";
        exit;
    }
