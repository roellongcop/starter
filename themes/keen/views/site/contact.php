<?php
/* @var $form yii\bootstrap\KeenActiveForm */
/* @var $model app\models\LoginForm */
use app\helpers\App;
use app\widgets\ActiveForm;
use app\widgets\Alert;
use app\widgets\KeenActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;

$publishedUrl = App::publishedUrl();
?>

<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #7EBFDB;">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <!--begin::Aside header-->
                <a href="#" class="text-center mb-15">
                    <img src="<?= $publishedUrl . '/media/logos/logo-5.svg' ?>" alt="logo" class="h-70px" />
                </a>
                <!--end::Aside header-->
                <!--begin::Aside title-->
                <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg text-white">Discover Amazing
                <br />Features &amp; Possibilites</h3>
                <!--end::Aside title-->
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom-->
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(<?= $publishedUrl . '/media/svg/illustrations/payment.svg' ?>)"></div>
            <!--end::Aside Bottom-->
        </div>

        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
                <div class="site-contact">
                    <h1><?= Html::encode($this->title) ?></h1>

                    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                        <div class="alert alert-success">
                            Thank you for contacting us. We will respond to you as soon as possible.
                        </div>

                        <p>
                            Note that if you turn on the Yii debugger, you should be able
                            to view the mail message on the mail panel of the debugger.
                            <?php if (Yii::$app->mailer->useFileTransport): ?>
                                Because the application is in development mode, the email is not sent but saved as
                                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                                application component to be false to enable email sending.
                            <?php endif; ?>
                        </p>

                    <?php else: ?>

                        <p>
                            If you have business inquiries or other questions, please fill out the following form to contact us.
                            Thank you.
                        </p>


                        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'email') ?>

                            <?= $form->field($model, 'subject') ?>

                            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                            ]) ?>

                            <div class="form-group">
                                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>


                    <?php endif; ?>
                </div>
            </div>
            <!--end::Content body-->
            <!--begin::Content footer-->
            <!-- <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
                <a href="#" class="text-primary font-weight-bolder font-size-h5">Terms</a>
                <a href="#" class="text-primary ml-10 font-weight-bolder font-size-h5">Plans</a>
                <a href="#" class="text-primary ml-10 font-weight-bolder font-size-h5">Contact Us</a>
            </div> -->
            <!--end::Content footer-->
        </div>

         <!--end::Content-->
    </div>
    <!--end::Login-->
</div>