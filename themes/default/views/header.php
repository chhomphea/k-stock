<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMS-HELP</title>
    <link rel="shortcut icon" href="<?=base_url('assets/') ?>uploads/icon/icon.jpg"/>
    <link href="<?=base_url('assets/jquery/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/css/font.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/css/style.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/css/select2.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/jquery/css/datatable.css')?>" rel="stylesheet">
    <script src="<?=base_url('assets/jquery/js/jquery.min.js')?>"></script>
    <script src="<?=base_url('assets/jquery/js/select2.js')?>"></script>
</head>

<body>

    <div id="pageLoader" class="loader-overlay">
        <div class="spinner-border" style="color: var(--theme-color); width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="mt-3 text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">
            LOADING...
        </div>
    </div>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center">
                <div class="text-white rounded p-1 me-2 d-flex align-items-center justify-content-center" style="width:24px; height:24px; background-color: var(--theme-color);">
                    <span class="material-icons-outlined" style="font-size:16px !important; color:#fff !important;">inventory_2</span>
                </div>
                <span>ប្រព័ន្ធគ្រប់គ្រងស្តុក</span>
            </div>
            <span class="material-icons-outlined mobile-close-btn" id="sidebar-close">close</span>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="<?=base_url()?>" class="nav-link">
                    <div class="icon-wrapper">
                        <span class="material-icons-outlined">dashboard</span>
                        <span><?=lang('dashboard')?></span>
                    </div>
                </a>
            </li>

            <li>
                <a href="#prodSubmenu" class="nav-link active" data-bs-toggle="collapse" role="button" aria-expanded="true">
                    <div class="icon-wrapper">
                        <span class="material-icons-outlined">grid_view</span>
                        <span><?=lang('products')?></span>
                    </div>
                    <span class="material-icons-outlined menu-arrow">chevron_right</span>
                </a>
                <ul class="sidebar-submenu collapse show" id="prodSubmenu">
                    <li>
                        <a href="<?=base_url('products')?>" class="active">
                            <span class="material-icons-outlined sub-icon">format_list_bulleted</span>
                            <?=lang('list_products')?>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="material-icons-outlined sub-icon">add</span>
                            <?=lang('create_product')?>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="material-icons-outlined sub-icon">category</span>
                            <?=lang('categories')?>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#saleSubmenu" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false">
                    <div class="icon-wrapper">
                        <span class="material-icons-outlined">shopping_cart</span>
                        <span><?=lang('sales')?></span>
                    </div>
                    <span class="material-icons-outlined menu-arrow">chevron_right</span>
                </a>
                
                <ul class="sidebar-submenu collapse" id="saleSubmenu">
                    <li>
                        <a href="<?=base_url('sales')?>">
                            <span class="material-icons-outlined sub-icon">format_list_bulleted</span>
                            <?=lang('list_sales')?>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="material-icons-outlined sub-icon">add</span>
                            <?=lang('create_sale')?>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" class="nav-link">
                    <div class="icon-wrapper">
                        <span class="material-icons-outlined">settings</span>
                        <span><?=lang('settings')?></span>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content" id="main-content">
        
        <nav class="topbar">
            <div class="d-flex align-items-center">
                <button class="material-icons-outlined toggle-btn me-3" id="menu-toggle">menu</button>
            </div>

            <div class="d-flex align-items-center gap-3">
                
                <div class="dropdown">
                    <a href="#" class="text-decoration-none text-muted fw-bold dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                        <?=!$this->input->cookie('spos_language')!='' ? lang('english') : lang($this->input->cookie('spos_language', true))?>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item <?=$this->input->cookie('spos_language')=='khmer'?'active':''?>" href="<?= site_url('auth/language/khmer') ?>">
                                ខ្មែរ
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?=($this->input->cookie('spos_language')!='khmer')?'active':''?>" href="<?= site_url('auth/language/english') ?>">
                                English
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="border-start mx-1" style="height: 16px;"></div>

                <div class="dropdown">
                    <a href="#" class="text-decoration-none text-dark dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                        <img src="<?=base_url('assets/uploads/icon/icon.jpg')?>" class="rounded-circle border" width="28" height="28" alt="user">
                        <span class="fw-bold" style="font-size:0.8rem;"><?=$this->session->userdata('first_name');?> <?=$this->session->userdata('last_name');?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                    </ul>
                </div>

            </div>
        </nav>