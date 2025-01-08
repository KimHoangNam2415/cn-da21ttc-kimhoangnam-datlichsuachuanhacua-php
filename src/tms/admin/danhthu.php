<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $totalRevenue = 0;
    $chartData = [];

    // Kiểm tra khi người dùng gửi form lọc ngày
    if (isset($_POST['filter'])) {
        $dateRange = $_POST['date_range'];
        list($fromDate, $toDate) = explode(" - ", $dateRange);

        // Lấy tổng doanh thu trong khoảng thời gian được chọn
        $sql = "SELECT SUM(tp.PackagePrice) AS TotalRevenue, DATE(tb.FromDate) AS BookingDate
                FROM tblbooking tb
                JOIN tbltourpackages tp ON tb.PackageId = tp.PackageId
                WHERE tb.status = 1
                AND tb.FromDate BETWEEN :fromDate AND :toDate
                GROUP BY DATE(tb.FromDate)
                ORDER BY BookingDate";

        $query = $dbh->prepare($sql);
        $query->bindParam(':fromDate', $fromDate, PDO::PARAM_STR);
        $query->bindParam(':toDate', $toDate, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($results as $row) {
            $chartData[] = [
                'date' => $row->BookingDate,
                'revenue' => $row->TotalRevenue
            ];
        }

        // Tính tổng doanh thu
        $totalRevenue = array_sum(array_column($chartData, 'revenue'));
    }
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <title>Quản lý trang</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            .revenue-container {
                margin: 20px auto;
                text-align: center;
            }
            .revenue-box {
                display: inline-block;
                padding: 20px;
                background: #f7f7f7;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            .revenue-title {
                font-size: 18px;
                margin-bottom: 10px;
                font-weight: bold;
            }
            .revenue-value {
                font-size: 24px;
                color: #5cb85c;
            }
            .filter-form {
                margin-bottom: 20px;
                text-align: center;
            }
            .filter-form input {
                margin: 5px;
                font-size: 14px;
                padding: 8px;
                width: 300px;
                border-radius: 5px;
                border: 1px solid #ddd;
            }
            .btn-primary {
                background-color: #007bff;
                border: none;
                padding: 10px 20px;
                font-size: 14px;
                color: #fff;
                border-radius: 5px;
                cursor: pointer;
            }
            .btn-primary:hover {
                background-color: #0056b3;
            }
            .chart-container {
                margin: 40px auto;
                max-width: 800px;
            }
        </style>
    </head>
    <body>
    <div class="page-container">
        <div class="left-content">
            <div class="mother-grid-inner">
                <?php include('includes/header.php'); ?>
                <div class="clearfix"></div>
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php" style="color: #3F84B1">Trang điều khiển</a><i class="fa fa-angle-right"></i>Cập nhật dữ liệu trang</li>
            </ol>

            <!-- Phần hiển thị tổng doanh thu -->
            <div class="revenue-container">
                <h3 style="color: #3F84B1;">Tính tổng doanh thu</h3>
                <div class="filter-form">
                    <form method="post">
                        <input type="text" id="date_range" name="date_range" placeholder="Chọn khoảng thời gian" required>
                        <button type="submit" name="filter" class="btn btn-primary">Lọc</button>
                    </form>
                </div>
                <div class="revenue-box">
                    <div class="revenue-title">Tổng Doanh Thu</div>
                    <div class="revenue-value"><?php echo number_format($totalRevenue, 3, ',', '.'); ?> VND</div>
                </div>
            </div>

            <!-- Phần biểu đồ -->
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>

            <!-- Phần cũ giữ nguyên -->
            <div class="grid-form">
                <!-- Nội dung phần cập nhật -->
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
        <?php include('includes/sidebarmenu.php'); ?>
    </div>
    <script>
        // Khởi tạo Date Range Picker
        $(function () {
            $('#date_range').daterangepicker({
                opens: 'center',
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Hủy',
                    applyLabel: 'Áp dụng',
                    format: 'YYYY-MM-DD'
                }
            });

            $('#date_range').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#date_range').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });

        // Biểu đồ doanh thu
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const chartData = <?php echo json_encode($chartData); ?>;

        const labels = chartData.map(data => data.date);
        const revenues = chartData.map(data => data.revenue);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: revenues,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                }).format(value);
                            }
                        }
                    }
                }
            }
        });
    </script>
    </body>
    </html>
<?php } ?>
