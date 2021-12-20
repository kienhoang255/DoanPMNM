<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['action']) && $_GET['action'] == "send") {
//    if (empty($_POST['egmail'])) { //Kiểm tra xem trường egmail có rỗng không?
//        $error = "Bạn phải nhập địa chỉ egmail";
//    } elseif (!empty($_POST['gmail']) && !filter_var($_POST['egmail'], FILTER_VALIDATE_EMAIL)) {
//        $error = "Bạn phải nhập egmail đúng định dạng";
//    } elseif (empty($_POST['content'])) { //Kiểm tra xem trường content có rỗng không?
//        $error = "Bạn phải nhập nội dung";
//    }
    if (!isset($error)) {
        include 'library.php'; // include the library file
        require 'vendor/autoload.php';
        $mail = new PHPMailer(true);                                 // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->CharSet = "UTF-8";
            $mail->SMTPDebug = 0;                                               // Enable verbose debug output
            $mail->isSMTP();                                                    // Set mailer to use SMTP
            $mail->Host = SMTP_HOST;                                            // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                             // Enable SMTP authentication
            $mail->Username = SMTP_UNAME;                                       // SMTP username
            $mail->Password = SMTP_PWORD;                                       // SMTP password
            $mail->SMTPSecure = 'ssl';                                          // Enable TLS encryption, `ssl` also accepted
            $mail->Port = SMTP_PORT;                                            // TCP port to connect to
            //Recipients
            $mail->setFrom(SMTP_UNAME, "Tên người gửi");
            $mail->addAddress($_POST['egmail'], 'Tên người nhận');        // Add a recipient | name is option
            $mail->addReplyTo(SMTP_UNAME, 'Tên người trả lời');
            $mail->isHTML(true);                                         // Set egmail format to HTML
            $mail->Subject = $_POST['title'];
            $mail->Body = $_POST['content'];
            $mail->AltBody = $_POST['content']; //None HTML
            $result = $mail->send();
            if (!$result) {
                $error = "Có lỗi xảy ra trong quá trình gửi mail";
            }
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
    ?><div class = "container">
    <div class = "error"><?= isset($error) ? $error : "Gửi egmail thành công" ?></div>
    <a href = "index.php">Quay lại form gửi mail</a>
    </div><?php }
else {
    ?>
    <form id="send-egmail-form" method="POST" action="?action=send">
        <input type="hidden" name="egmail" value="hoangtrungkien255@gmail.com" />
        <input type="hidden" name="title" value="Vừa nhận một đơn hàng" />
        <input type="hidden" name="content" value="Tiền về tiền về !!!" />
        <input type="submit" class="btn btn-primary" value="Thanh toán giỏ hàng" name="thanhtoandangnhap">
    </form>
<?php } ?>

