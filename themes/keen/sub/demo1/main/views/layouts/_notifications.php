<?php

use app\helpers\App;
use app\helpers\Html;
use app\models\Notification;

$this->registerCss(<<< CSS
    .notification-badge {
        position: absolute;
        top: 10px;
    }
CSS);
?>

<div class="dropdown mr-1">
    <!--begin::Toggle-->
    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
        <div class="btn btn-icon btn-clean btn-dropdown btn-lg pulse pulse-primary">
            <span class="svg-icon svg-icon-xl svg-icon-primary">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
                        <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
            <span class="pulse-ring"></span>
            
        </div>
        <label class="badge badge-danger badge-pill notification-badge">
            <?= count(Notification::unread()) ?>
        </label>
    </div>
    <!--end::Toggle-->
    <!--begin::Dropdown-->
    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
        <form>
            <!--begin::Header-->
            <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url(<?= App::publishedUrl('/media/misc/bg-3.jpg') ?>)">
                <!--begin::Title-->
                <h4 class="d-flex flex-center rounded-top">
                    <span class="text-white">Message Center</span>
                    <span class="btn btn-success btn-sm font-weight-bold ml-2">
                        <?= count(Notification::unread()) ?>
                    </span>
                </h4>
                <!--end::Title-->
                <!--begin::Tabs-->
                <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8 font-size-lg" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#topbar_notifications_notifications">Reminders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#topbar_notifications_logs">Logs</a>
                    </li>
                </ul>
                <!--end::Tabs-->
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="tab-content">
                
                <!--begin::Tabpane-->
                <div class="tab-pane active p-8" id="topbar_notifications_events" role="tabpanel">
                    <!--begin::Scroll-->
                    <div class="scroll pr-7 mr-n7" data-scroll="true" data-height="300" data-mobile-height="200">
                        <?= Html::foreach(Notification::unread(), function($notification) {
                            return <<< HTML
                                <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-6">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40 symbol-light-primary mr-5">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Color-profile.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path d="M12,10.9996338 C12.8356605,10.3719448 13.8743941,10 15,10 C17.7614237,10 20,12.2385763 20,15 C20,17.7614237 17.7614237,20 15,20 C13.8743941,20 12.8356605,19.6280552 12,19.0003662 C11.1643395,19.6280552 10.1256059,20 9,20 C6.23857625,20 4,17.7614237 4,15 C4,12.2385763 6.23857625,10 9,10 C10.1256059,10 11.1643395,10.3719448 12,10.9996338 Z M13.3336047,12.504354 C13.757474,13.2388026 14,14.0910788 14,15 C14,15.9088933 13.7574889,16.761145 13.3336438,17.4955783 C13.8188886,17.8206693 14.3938466,18 15,18 C16.6568542,18 18,16.6568542 18,15 C18,13.3431458 16.6568542,12 15,12 C14.3930587,12 13.8175971,12.18044 13.3336047,12.504354 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                            <circle fill="#000000" cx="12" cy="9" r="5" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column font-weight-bold">
                                            <a href="{$notification->viewUrl}" class="text-dark text-hover-primary mb-1 font-size-lg">
                                                {$notification->label}
                                            </a>
                                            <span class="text-muted">
                                                {$notification->message}
                                            </span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                            HTML;
                        }) ?>
                        
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Tabpane-->

                <!--begin::Tabpane-->
                <div class="tab-pane show p-8" id="topbar_notifications_notifications" role="tabpanel">
                    <!--begin::Scroll-->
                    <div class="scroll pr-7 mr-n7" data-scroll="true" data-height="300" data-mobile-height="200">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-35 flex-shrink-0 mr-3">
                                <img alt="Pic" src="https://via.placeholder.com/150" />
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap flex-row-fluid">
                                <!--begin::Text-->
                                <div class="d-flex flex-column pr-5 flex-grow-1">
                                    <a href="#" class="text-dark text-hover-primary mb-1 font-weight-bold font-size-lg">Marcus Smart</a>
                                    <span class="text-muted font-weight-bold">UI/UX, Art Director</span>
                                </div>
                                <!--end::Text-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center py-2">
                                    <!--begin::Label-->
                                    <span class="text-success font-weight-bolder font-size-sm pr-6">+65%</span>
                                    <!--end::Label-->
                                    <!--begin::Btn-->
                                    <a href="#" class="btn btn-icon btn-light btn-sm">
                                        <span class="svg-icon svg-icon-md svg-icon-success">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-right.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </a>
                                    <!--end::Btn-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-35 symbol-light-info flex-shrink-0 mr-3">
                                <span class="symbol-label font-weight-bolder font-size-lg">AH</span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap flex-row-fluid">
                                <!--begin::Text-->
                                <div class="d-flex flex-column pr-5 flex-grow-1">
                                    <a href="#" class="text-dark text-hover-primary mb-1 font-weight-bold font-size-lg">Andreas Hawks</a>
                                    <span class="text-muted font-weight-bold">Python Developer</span>
                                </div>
                                <!--end::Text-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center py-2">
                                    <!--begin::Label-->
                                    <span class="text-success font-weight-bolder font-size-sm pr-6">+23%</span>
                                    <!--end::Label-->
                                    <!--begin::Btn-->
                                    <a href="#" class="btn btn-icon btn-light btn-sm">
                                        <span class="svg-icon svg-icon-md svg-icon-success">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-right.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </a>
                                    <!--end::Btn-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-35 symbol-light-success flex-shrink-0 mr-3">
                                <span class="symbol-label font-weight-bolder font-size-lg">SC</span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap flex-row-fluid">
                                <!--begin::Text-->
                                <div class="d-flex flex-column pr-5 flex-grow-1">
                                    <a href="#" class="text-dark text-hover-primary mb-1 font-weight-bold font-size-lg">Sarah Connor</a>
                                    <span class="text-muted font-weight-bold">HTML, CSS. jQuery</span>
                                </div>
                                <!--end::Text-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center py-2">
                                    <!--begin::Label-->
                                    <span class="text-danger font-weight-bolder font-size-sm pr-6">-34%</span>
                                    <!--end::Label-->
                                    <!--begin::Btn-->
                                    <a href="#" class="btn btn-icon btn-light btn-sm">
                                        <span class="svg-icon svg-icon-md svg-icon-success">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-right.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </a>
                                    <!--end::Btn-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-35 flex-shrink-0 mr-3">
                                <img alt="Pic" src="https://via.placeholder.com/150" />
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap flex-row-fluid">
                                <!--begin::Text-->
                                <div class="d-flex flex-column pr-5 flex-grow-1">
                                    <a href="#" class="text-dark text-hover-primary mb-1 font-weight-bold font-size-lg">Amanda Harden</a>
                                    <span class="text-muted font-weight-bold">UI/UX, Art Director</span>
                                </div>
                                <!--end::Text-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center py-2">
                                    <!--begin::Label-->
                                    <span class="text-success font-weight-bolder font-size-sm pr-6">+72%</span>
                                    <!--end::Label-->
                                    <!--begin::Btn-->
                                    <a href="#" class="btn btn-icon btn-light btn-sm">
                                        <span class="svg-icon svg-icon-md svg-icon-success">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-right.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </a>
                                    <!--end::Btn-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-35 symbol-light-danger flex-shrink-0 mr-3">
                                <span class="symbol-label font-weight-bolder font-size-lg">SR</span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap flex-row-fluid">
                                <!--begin::Text-->
                                <div class="d-flex flex-column pr-5 flex-grow-1">
                                    <a href="#" class="text-dark text-hover-primary mb-1 font-weight-bold font-size-lg">Sean Robbins</a>
                                    <span class="text-muted font-weight-bold">UI/UX, Art Director</span>
                                </div>
                                <!--end::Text-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center py-2">
                                    <!--begin::Label-->
                                    <span class="text-success font-weight-bolder font-size-sm pr-6">+65%</span>
                                    <!--end::Label-->
                                    <!--begin::Btn-->
                                    <a href="#" class="btn btn-icon btn-light btn-sm">
                                        <span class="svg-icon svg-icon-md svg-icon-success">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-right.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </a>
                                    <!--end::Btn-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-35 symbol-light-success flex-shrink-0 mr-3">
                                <span class="symbol-label font-weight-bolder font-size-lg">SC</span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap flex-row-fluid">
                                <!--begin::Text-->
                                <div class="d-flex flex-column pr-5 flex-grow-1">
                                    <a href="#" class="text-dark text-hover-primary mb-1 font-weight-bold font-size-lg">Ana Stone</a>
                                    <span class="text-muted font-weight-bold">Figma, PSD</span>
                                </div>
                                <!--end::Text-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center py-2">
                                    <!--begin::Label-->
                                    <span class="text-info font-weight-bolder font-size-sm pr-6">+34%</span>
                                    <!--end::Label-->
                                    <!--begin::Btn-->
                                    <a href="#" class="btn btn-icon btn-light btn-sm">
                                        <span class="svg-icon svg-icon-md svg-icon-success">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-right.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </a>
                                    <!--end::Btn-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-35 symbol-light-primary flex-shrink-0 mr-3">
                                <span class="symbol-label font-weight-bolder font-size-lg">JT</span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap flex-row-fluid">
                                <!--begin::Text-->
                                <div class="d-flex flex-column pr-5 flex-grow-1">
                                    <a href="#" class="text-dark text-hover-primary mb-1 font-weight-bold font-size-lg">Jason Tatum</a>
                                    <span class="text-muted font-weight-bold">ASP.NET Developer</span>
                                </div>
                                <!--end::Text-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center py-2">
                                    <!--begin::Label-->
                                    <span class="text-success font-weight-bolder font-size-sm pr-6">+139%</span>
                                    <!--end::Label-->
                                    <!--begin::Btn-->
                                    <a href="#" class="btn btn-icon btn-light btn-sm">
                                        <span class="svg-icon svg-icon-md svg-icon-success">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-right.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </a>
                                    <!--end::Btn-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Action-->
                    <div class="d-flex flex-center pt-7">
                        <a href="#" class="btn btn-light-primary font-weight-bold text-center">See All</a>
                    </div>
                    <!--end::Action-->
                </div>
                <!--end::Tabpane-->
                <!--begin::Tabpane-->
                <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                    <!--begin::Nav-->
                    <div class="d-flex flex-center font-weight-bold text-center text-muted min-h-250px">All caught up!
                    <br />No new messages.</div>
                    <!--end::Nav-->
                </div>
                <!--end::Tabpane-->
            </div>
            <!--end::Content-->
        </form>
    </div>
    <!--end::Dropdown-->
</div>