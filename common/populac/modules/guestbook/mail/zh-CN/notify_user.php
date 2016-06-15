<?php

$this->title = $subject;
?>

<table>
    <tbody>

    <tr style="page-break-before: always">
        <td valign="top">
            <h1 style="font-family: sans-serif; font-weight: normal; margin: 0 0 24px 0; text-align: center;">您好！</h1>
            <p class="primary" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0 0 24px 0; text-align: center;"><b><?= Yii::$app->request->serverName ?></b>管理员已经回复了您在计生系统留言板上留言.</p>
        </td>
    </tr>


    <tr height="50">
        <td align="center" valign="top">
            <table id="email-button" style="-webkit-text-size-adjust: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #0095dd; border-radius: 4px; height: 50px; width: 310px !important;" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tbody><tr style="page-break-before: always">
                    <td id="button-content" style="font-family: sans-serif; font-weight: normal; text-align: center; margin: 0; color: #ffffff; font-size: 20px; line-height: 100%;" align="center" valign="middle">

                        <a href="<?= $link ?>" id="button-link" style="font-family:sans-serif; color: #fff; display: block; padding: 15px; text-decoration: none; width: 280px;">点击查看</a>

                    </td>
                </tr>
                </tbody></table>
        </td>
    </tr>

    <tr style="page-break-before: always">
        <td border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            <br>
            <p width="310" class="secondary" style="font-family: sans-serif; font-weight: normal; margin: 0 0 24px 0; text-align: center; color: #8A9BA8; font-size: 11px; line-height: 13px; width: 310px !important; word-wrap: break-word; word-break: break-all">或者：<a target="_blank" href="<?= $link ?>" style="color: #0095dd; text-decoration: none; width: 310px !important; display:block;"><br><font style="word-break:break-all;"><?= $link ?></font></a></p>
            <p class="secondary" style="font-family: sans-serif; font-weight: normal; margin: 0; text-align: center; color: #8A9BA8; font-size: 11px; line-height: 13px; width: 310px !important; word-wrap:break-word">这是一封自动发送的邮件，请勿回复，欲了解更多信息，请访问 <a href="<?= \Yii::$app->homeUrl ?>" style="color: #0095dd; text-decoration: none;">计生管理系统 </a></p>
        </td>
    </tr>

    </tbody>
</table>