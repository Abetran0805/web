<?php

$ketnoi['host'] = 'localhost'; //Tên server, nếu dùng hosting free thì cần thay đổi
$ketnoi['database'] = 'db_shoes'; //Đây là tên của Database
$ketnoi['username'] = 'root'; //Tên sử dụng Database
$ketnoi['password'] = ''; //Mật khẩu của tên sử dụng Database
@mysqli_connect(
    "{$ketnoi['localhost']}",
    "{$ketnoi['username']}",
    "{$ketnoi['password']}"
)
    or
    die("Không thể kết nối database");
