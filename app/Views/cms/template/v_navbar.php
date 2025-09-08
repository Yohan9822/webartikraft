<?php

$breadcrumbs = $breadcrumb ?? [];
$withbc = count($breadcrumbs) > 0;

?>
<style>
    .badge-notif {
        position: absolute;
        top: -24%;
        bottom: 38%;
        left: 50%;
        font-size: 8.8px;
        padding: 5px;
        border-radius: 5rem;
        background-color: rgba(237, 41, 57);
        color: #fff;
        text-align: center;
    }

    .dps {
        width: 100%;
        background-color: rgba(255, 255, 255);
        padding-inline: 5px;
        padding-block: 6px;
        border-radius: 5px;
        margin-top: 10px;
    }

    .dps .dropdown-content.company {
        left: 0;
    }
</style>
<nav class="navbar sc-sm"></nav>
<nav class="navbar sc-lg">
    <i class="bx bx-chevron-right side-toggle slide"></i>
    <div class="nav-item dflex align-center justify-between p-x">
        <div class="row bc">
            <h5 class="fw-semibold fs-5"><?= $section ?? 'Section Title' ?></h5>
            <!-- <span class="fw-normal fs-7 text-dark">Welcome Back</span> -->
            <div class="breadcrumb">
                <?php foreach ($breadcrumbs as $bread) : ?>
                    <span class="breadcrumb-item"><?= $bread ?></span>
                <?php
                endforeach; ?>
            </div>
        </div>
        <div class="dflex align-center m-item-3 right" style="<?= (!empty($withBreadcrumb) ? 'padding-block: 10px;width:100% !important;' : '') ?>">
            <a href="javascript:void(0);" class="nav-icon">
                <div class="dropdown" style="position: relative;">
                    <div class="dflex align-center w-100">
                        <i class="bx bx-building margin-r-2"></i>
                        <span class="fw-semibold fs-7 text-dark"><?= getSession('companyname') ?></span>
                    </div>
                    <style>
                        .dropdown-content.company .dropdown-item {
                            align-items: start !important;
                        }
                    </style>
                    <div class="dropdown-content company" style="width: 250px">
                        <div class="notif" style="max-height: 250px; overflow: auto;" id="list-company"></div>
                    </div>
                </div>
            </a>
            <!-- <a href="javascript:void(0);" class="nav-icon">
                <div class="dropdown" style="position: relative;">
                    <i class="bx bx-bell text-secondary fs-4"></i>
                    <span class="badge-notif">0</span>
                    <style>
                        .dropdown-content.bell .dropdown-item {
                            align-items: start !important;
                        }
                    </style>
                    <div class="dropdown-content bell" style="width: 350px">
                        <div class="dropdown-header" style="padding: 10px; padding-bottom: 4px; padding-top: 4px; border-bottom: 1px solid rgba(108, 108, 108, 0.15)">
                            <span class="fw-semibold fs-7">Notifications</span>
                        </div>
                        <div class="notif" style="max-height: 250px; overflow: auto;" id="list-notifikasi">

                        </div>
                        <div class="dropdown-footer dflex align-center" style="justify-content: center !important; width: 100%; padding-top: 8px; border-top: 1px solid rgba(108, 108, 108, 0.15)">
                            <span class="fw-normal text-primary fs-7set" type="global" notif="" onclick="read_notif(this)">Read All Notification</span>
                        </div>
                    </div>
                </div>
            </a> -->
            <a href="<?= getURL('cms/auth/logout') ?>" class="nav-icon" aria-label="Log Out" data-microtip-position="bottom" role="tooltip">
                <i class="bx bx-power-off text-danger fs-4"></i>
            </a>
        </div>
    </div>
</nav>