<?php

$asideClass = [];
if (!empty($collapsed)) $asideClass[] = 'show-lg';

?>
<style>
    img[alt="side-avatar"] {
        margin-right: 0px !important;
        margin-bottom: 0px !important;
        width: 85px !important;
        height: 100% !important;
        border: 1px solid rgba(108, 108, 108, 0.35);
        border-radius: 5rem;
        padding: 2px;
    }
</style>
<aside class="<?= implode(' ', $asideClass) ?>">
    <div class="sidebar">
        <div class="project-logo">
            <div class="dflex align-center justify-center" style="width: 100%;">
                <div class="text-center" style="display:flex;flex-direction:column;align-items: center;">
                    <div style="width:max-content;height: max-content;position:relative;">
                        <img src="<?= base_url('public/cms/images/avatar/avatars.png') ?>" class="side-avatar" alt="side-avatar" loading="lazy">
                    </div>
                    <div class="side-name">
                        <span class="fw-semibold"><?= getSession('name') ?></span>
                    </div>
                    <div class="side-role">
                        <span class="fw-normal fs-7set text-dark"><?= getSession('groupname') ?></span>
                    </div>
                </div>
            </div>
            <i class='bx bx-chevron-left side-toggle shrink lg'></i>
        </div>
        <div class="sidebar-nav">
            <?= App\Libraries\MenuRenderer\MenuRenderer::init(getSession('groupid'))->render() ?>
        </div>
        <a href="<?= base_url('logout') ?>" class=" btn btn-primary dflex align-center w-100 btn-logout" style="display: none;">
            <i class="bx bx-log-out margin-r-3"></i>
            <span class="fw-normal fs-7">Log Out</span>
        </a>
    </div>
</aside>