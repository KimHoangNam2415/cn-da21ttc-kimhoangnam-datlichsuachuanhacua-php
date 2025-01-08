<?php
include('includes/config.php'); // Nạp file cấu hình cơ sở dữ liệu

if (isset($_POST['export_excel'])) {
    // Đặt tên file xuất ra
    $filename = "DanhSachNguoiDung_" . date('Ymd') . ".csv";

    // Gửi header để trình duyệt hiểu là file CSV với encoding UTF-8
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Ghi BOM để Excel nhận diện UTF-8
    echo "\xEF\xBB\xBF"; // BOM cho UTF-8

    // Truy vấn dữ liệu từ cơ sở dữ liệu
    $sql = "SELECT * FROM tblusers";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    // Ghi tiêu đề cột
    echo "STT,Họ và Tên,Số Điện Thoại,Email,Ngày Đăng Ký,Ngày Cập Nhật\n";
    
    // Đổ dữ liệu vào file CSV
    $cnt = 1;
    foreach ($results as $row) {
        echo $cnt . "," .
            '"' . $row->FullName . '",' . // Đặt trong dấu ngoặc kép để tránh lỗi định dạng
            '"' . $row->MobileNumber . '",' .
            '"' . $row->EmailId . '",' .
            '"' . $row->RegDate . '",' .
            '"' . $row->UpdationDate . '"' . "\n";
        $cnt++;
    }

    exit; // Kết thúc script
}
?>
