<?php

use app\helpers\App;
use app\helpers\Url;
?>
<div class="topbar-item ml-4">
    <div class="btn btn-icon btn-light-primary h-40px w-40px p-0" id="kt_quick_user_toggle">
        <img src="<?= Url::image(App::identity('photo'), ['w' => 40]) ?>" class="h-30px align-self-end" alt="" />
    </div>
    <!--
        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
        <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">Sean</span>
        <span class="symbol symbol-35 symbol-light-success">
        <span class="symbol-label font-size-h5 font-weight-bold">S</span>
        </span>
        </div>
    -->
</div>