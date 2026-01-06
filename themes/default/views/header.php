<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product List | Stock Manager</title>
        <link href="<?=base_url('assets/jquery/css/bootstrap.min.css')?>" rel="stylesheet">
        <link rel="stylesheet" href="<?=base_url('assets/css/font.css')?>">
        <link rel="stylesheet" href="<?=base_url('assets/css/style.css')?>">
        <link rel="stylesheet" href="<?=base_url('assets/css/select2.css')?>">
        <link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700&family=Inter:wght@300;400;600&family=Roboto+Mono:wght@400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?=base_url('assets/jquery/css/datatable.css')?>">
        <script src="<?=base_url('assets/jquery/js/jquery.min.js')?>"></script>
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
                    <span>STOCK MANAGER</span>
                </div>
                <span class="material-icons-outlined mobile-close-btn" id="sidebar-close">close</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" class="nav-link"><div class="icon-wrapper"><span class="material-icons-outlined">dashboard</span><span>Dashboard</span></div></a></li>
                <li>
                    <a href="#prodSubmenu" class="nav-link active" data-bs-toggle="collapse" role="button" aria-expanded="true">
                        <div class="icon-wrapper"><span class="material-icons-outlined">grid_view</span><span>Products</span></div>
                        <span class="material-icons-outlined menu-arrow">chevron_right</span>
                    </a>
                    <ul class="sidebar-submenu collapse show" id="prodSubmenu">
                        <li><a href="#" class="active"><span class="material-icons-outlined sub-icon">format_list_bulleted</span>Product List</a></li>
                        <li><a href="#"><span class="material-icons-outlined sub-icon">add</span>Create Product</a></li>
                        <li><a href="#"><span class="material-icons-outlined sub-icon">category</span>Categories</a></li>
                    </ul>
                </li>
                <li><a href="#" class="nav-link"><div class="icon-wrapper"><span class="material-icons-outlined">shopping_cart</span><span>Sales</span></div><span class="material-icons-outlined menu-arrow">chevron_right</span></a></li>
                <li><a href="#" class="nav-link"><div class="icon-wrapper"><span class="material-icons-outlined">settings</span><span>Settings</span></div></a></li>
            </ul>
        </div>
        <div class="main-content" id="main-content">
            <nav class="topbar">
                <div class="d-flex align-items-center"><button class="material-icons-outlined toggle-btn me-3" id="menu-toggle">menu</button></div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown"><a href="#" class="text-decoration-none text-muted fw-bold dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">EN</a><ul class="dropdown-menu"><li><a class="dropdown-item" href="#">Khmer</a></li></ul></div>
                    <div class="border-start mx-1" style="height: 16px;"></div>
                    <div class="dropdown"><a href="#" class="text-decoration-none text-dark dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown"><img src="https://placehold.co/100x100/093967/ffffff?text=A" class="rounded-circle border" width="28" height="28" alt="user"><span class="fw-bold" style="font-size:0.8rem;">Admin</span></a><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="#">Profile</a></li><li><hr class="dropdown-divider"></li><li><a class="dropdown-item text-danger" href="#">Logout</a></li></ul></div>
                </div>
            </nav>