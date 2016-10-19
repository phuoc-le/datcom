<?php
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '../' . PATH_SEPARATOR . '../../' . PATH_SEPARATOR . '../../../');

include 'common/autoload.php';

if (!isset($_GET['groupCode'])) {
    if (!isset($_POST['groupCode'])) {
        $_POST['groupCode'] = 'korrin';
    }
    $groupCode = CommonFunction::getPostValue('groupCode');
} else {
    $groupCode = CommonFunction::getGetValue('groupCode');
}

?>
<!DOCTYPE html>
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
//for test, get mon day
//$page = "http://comnhaviet.net/thuc-don/danh-muc/thu-hai-577.html";
$page = "http://comnhaviet.net/";
$content = file_get_contents($page);
?>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đặt cơm</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">


    <style type="text/css">
        .sbzoff {
            display: none;
            visibility: hidden;
        }

        div.sbzoff, div.sbzon, #sbzstorage_frame {
            display: none !important;
        }

        #order_menu.table-striped > tbody > tr:nth-of-type(odd),
        #summary_menu.table-striped > tbody > tr:nth-of-type(odd) {
            background-color: rgba(131, 165, 244, 0.13);
        }

        #summary_menu tr.summary_order_menu_total {
            background-color: white !important;
        }

        .summary_order_menu_total_cell {
            font-weight: bold;
            text-align: center
        }

    </style>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>

    <script src="common/common.js?20161017"></script>
    <script src="view/js/DC.Config.js?20161017"></script>
    <script src="view/js/DC.Data.Common.js?20161017"></script>
    <script src="view/js/DC.Data.js?20161017"></script>
    <script src="view/js/RequestMessage.js?20161017"></script>

    <!-- js of page(s) -->
    <script>
        //assign group code here
        GROUP_CODE = '<?= $groupCode ?>';
    </script>
    <script src="view/js/index.js?20161017"></script>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/menu.php"
                   style="font-weight: bold; font-size: 25px;">Trang đặt cơm</a>
            </div>
        </div>
    </nav>
    <div id="comnhaviet_page" style="display: none">
        <?= $content ?>
    </div>


    <!-- do not show here -->
    <div class="col-sm-10" id="menu" style="text-align: center; display: none;">

    </div>


    <div class="col-lg-12" style="clear: both">
        <label style="text-align: left; font-size: 22px;"><?php $groups = (new Group())->findByGroupCode($groupCode);
            echo $groups[0]["name"]; ?></label>

        <form class="navbar-form navbar-right" role="search">
            <div class="input-group form-group">
                <div class="input-group-addon"><span class="fa fa-users"></span></div>

                <input type="text" class="form-control" name="groupCode"
                       placeholder="Chọn mã nhóm" value="<?= $groupCode ?>">
                <span class="input-group-btn">
         <button type="submit" name="selectGroup" value="submit" class="btn btn-primary"
                 autocomplete="off" <span class="fa fa-check"></span>&nbsp;Chọn
                    </button>
      </span>
            </div>

        </form>
    </div>
    <div style="clear: both"></div>
    <div class="row message_no_user" style="display: none;">
        <div class="col-sm-10 message">

        </div>
    </div>

    <div class="table-responsive">
        <table id="order_menu" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Thực đơn</th>
                <th style="text-align: center;" class="price_header">Giá</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div style="clear: both"></div>

    <div class="row">
        <button id="resetOrdered" type="button" class="btn btn-primary" style="margin-left: 15px">Tạo lại</button>
    </div>
    <div style="clear: both;height: 10px;"></div>
    <label for="exampleInputName2" style="font-size: 20px; font-weight: bold">Tổng hợp</label>
    <div style="clear: both"></div>

    <div class="table-responsive">
        <table id="summary_menu" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th colspan="2">Thực đơn</th>
                <th style="text-align: center" class="foodCounter">Phần cơm</th>
                <th style="text-align: center" class="foodCounter">Tổng tiền</th>
                <th style="text-align: center" class="foodCounter">Phần thêm</th>
                <th style="text-align: center" class="foodCounter">Tiền thêm</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="row">
        <button id="showSmsPopup" type="button" class="btn btn-primary"
                style="margin-left: 15px;margin-bottom: 15px;">Xem tin nhắn
        </button>
    </div>
</div>

<!-- modal of message -->
<!-- Modal -->
<div id="smsPopup" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tin nhắn</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p id="sms_content" style="margin-left: 10px;"></p>
                </div>
                <div class="row">
                    <img id="smsQrCode"
                         style="width: 300px;height: 300px;display: block; margin-left: auto; margin-right: auto;"/>
                </div>
            </div>
            <div class="modal-footer form-inline">
                <button id="btnCopyToClipboard" class="btn btn-default" onclick="copyToClipboard('#sms_content')">Copy
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>

    </div>
</div>
</body>
</html>