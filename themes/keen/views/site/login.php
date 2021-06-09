<?php
/* @var $form app\widgets\ActiveForm */
/* @var $model app\models\LoginForm */
use app\helpers\App;
use app\widgets\Alert;
use app\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$publishedUrl = App::publishedUrl();
?>
<div class="d-flex flex-column flex-root">
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #7EBFDB;">
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <a href="#" class="text-center mb-15">
                    <img src="<?= $publishedUrl . '/media/logos/logo-5.svg' ?>" alt="logo" class="h-70px" />
                </a>
                <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg text-white">Discover Amazing
                <br />Features &amp; Possibilites</h3>
            </div>
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(<?= $publishedUrl . '/media/svg/illustrations/payment.svg' ?>)"></div>
        </div>
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <div class="d-flex flex-column-fluid flex-center">
                <div class="login-form login-signin">
                    <?= Alert::widget() ?>
                    <?php $form = ActiveForm::begin([
                        'id' => 'kt_login_signin_form',
                        'errorCssClass' => 'is-invalid',
                        'successCssClass' => 'is-valid',
                        'validationStateOn' => 'input',
                        'options' => [
                            'class' => 'form',
                            'novalidate' => 'novalidate'
                        ]
                    ]); ?>
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Welcome</h3>
                            <span class="text-muted font-weight-bold font-size-h4">New Here?
                            <a href="javascript:;" id="kt_login_signup" class="text-primary font-weight-bolder">Create an Account</a></span>
                        </div>
                        <?= $form->field($model, 'username', [
                            'template' => '
                                <label class="font-size-h6 font-weight-bolder text-dark">
                                    Username
                                </label>
                                {input}{error}
                            '
                        ])->textInput([
                            'autofocus' => true, 
                            'class' => 'form-control form-control-solid h-auto p-6 rounded-lg'
                        ]) ?>
                        <?= $form->field($model, 'password', [
                            'template' => '
                                <div class="d-flex justify-content-between mt-n5">
                                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                                    <a href="#" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">Forgot Password ?</a>
                                </div>
                                {input}{error}
                            '
                        ])->passwordInput([
                            'class' => 'form-control form-control-solid h-auto p-6 rounded-lg'
                        ]) ?>
                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="login-form login-signup">
                    <form class="form" novalidate="novalidate" id="kt_login_signup_form">
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Sign Up</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your account</p>
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="text" placeholder="Fullname" name="fullname" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="password" placeholder="Password" name="password" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="password" placeholder="Confirm password" name="cpassword" autocomplete="off" />
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <label class="checkbox mb-0">
                                <input type="checkbox" name="agree" />
                                <span></span>
                            </label>
                            <div class="pl-2">I Agree the
                            <a href="#" class="ml-1">terms and conditions</a></div>
                        </div>
                        <div class="form-group d-flex flex-wrap pb-lg-0 pb-3">
                        <button type="button" id="kt_login_signup_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit</button>
                            <button type="button" id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="login-form login-forgot">
                    <?php $form = ActiveForm::begin([
                        'id' => 'kt_login_forgot_form',
                        'errorCssClass' => 'is-invalid',
                        'successCssClass' => 'is-valid',
                        'validationStateOn' => 'input',
                        'options' => [
                            'class' => 'form',
                            'novalidate' => 'novalidate'
                        ],
                        'action' => ['reset-password']
                    ]); ?>
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Forgotten Password ?</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                        </div>
                        <?= $form->field($PSR, 'email')->textInput([
                            'class' => 'form-control form-control-solid h-auto p-6 rounded-lg font-size-h6',
                            'type' => 'email',
                            'placeholder' => 'Email',
                            'autocomplete' => 'off',
                        ])->label(false) ?>
                        <div class="form-group">
                            <div class="checkbox-list"> 
                                <label class="checkbox">
                                    <input type="checkbox" 
                                        value="1" 
                                        name="PasswordResetForm[hint]"> 
                                    <span></span>
                                    Show password hint instead.
                                </label>
                            </div>
                        </div>
                        <div class="form-group d-flex flex-wrap pb-lg-0">
                        <button type="submit" id="" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit</button>
                            <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>