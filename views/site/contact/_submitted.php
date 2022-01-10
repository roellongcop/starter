<?php

use app\helpers\Html;
$code = Yii::getAlias(Yii::$app->mailer->fileTransportPath);
?>
<div class="alert alert-success">
    Thank you for contacting us. We will respond to you as soon as possible.
</div>
<p>
    Note that if you turn on the Yii debugger, you should be able
    to view the mail message on the mail panel of the debugger.
    <?= Html::if(Yii::$app->mailer->useFileTransport, '
        Because the application is in development mode, the email is not sent but saved as
        a file under <code>{$code}</code>.
        Please configure the <code>useFileTransport</code> property of the <code>mail</code>
        application component to be false to enable email sending.
    ') ?>
</p>