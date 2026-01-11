<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>POS Admin</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Nokora:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        :root {
            --bg-body: #ffffff;      
            --bg-sidebar: #ffffff;   
            --primary: #2563eb;      
            --text-main: #1f2937; 
            --text-muted: #6b7280;
            --border-color: #f3f4f6; 
            --input-border: #e5e7eb; 
            
            --sidebar-width: 260px; 
            --header-height: 56px;
            --input-height: 35px;    /* FIXED 35px */
            --radius-sm: 4px;        
        }

        body { background-color: var(--bg-body); font-family: 'Inter', 'Nokora', sans-serif; font-size: 13px; color: var(--text-main); }

        /* --- LAYOUT --- */
        .main-header { height: var(--header-height); position: fixed; top: 0; right: 0; left: var(--sidebar-width); background: #fff; border-bottom: 1px solid var(--border-color); z-index: 1040; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; transition: all 0.3s; }
        .main-sidebar { width: var(--sidebar-width); position: fixed; top: 0; bottom: 0; left: 0; background: var(--bg-sidebar); border-right: 1px solid var(--border-color); z-index: 1050; display: flex; flex-direction: column; transition: all 0.3s; }
        .app-container { margin-top: var(--header-height); margin-left: var(--sidebar-width); padding: 0; min-height: calc(100vh - var(--header-height) - 40px); transition: all 0.3s; }

        /* Sidebar Closed State (Desktop) */
        body.sidebar-closed .main-sidebar { transform: translateX(-100%); }
        body.sidebar-closed .main-header { left: 0; }
        body.sidebar-closed .app-container { margin-left: 0; }
        body.sidebar-closed .main-footer { margin-left: 0; }

        /* --- INPUTS (35px) --- */
        .form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
        
        .form-control, .form-select, .select2-container .select2-selection--single, .input-group-text {
            height: var(--input-height) !important;
            min-height: var(--input-height) !important;
            border-radius: var(--radius-sm) !important;
            border: 1px solid var(--input-border) !important;
            font-size: 13px;
            box-shadow: none !important;
            display: flex; align-items: center;
        }
        .form-control:focus, .form-select:focus { border-color: var(--primary) !important; }

        .input-group .input-group-text { background-color: #f9fafb; color: #6b7280; border-right: 0 !important; padding: 0 10px; font-weight: 500; }
        .input-group .form-control { border-left: 0 !important; }
        .input-group:focus-within .input-group-text, .input-group:focus-within .form-control { border-color: var(--primary) !important; }

        /* Select2 Alignment */
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 33px !important; padding-left: 10px !important; color: #1f2937 !important; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 33px !important; top: 1px !important; }

        /* --- MENUS --- */
        .sidebar-brand { height: var(--header-height); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; border-bottom: 1px solid var(--border-color); font-weight: 700; font-size: 16px; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; overflow-y: auto; flex: 1; }
        .menu-header { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; padding: 20px 20px 8px; }
        
        /* Padding 10px 15px */
        .menu-link { display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; color: #4b5563; text-decoration: none; font-weight: 500; border-left: 3px solid transparent; transition: 0.1s; }
        .menu-link:hover { background: #f9fafb; color: #111; }
        .menu-link.active, .menu-item.expanded > .menu-link { background: #eff6ff; color: var(--primary); font-weight: 600; border-left-color: var(--primary); }
        .menu-icon { font-size: 20px; margin-right: 12px; color: #6b7280; }
        .menu-item.expanded .menu-icon { color: var(--primary); }
        .menu-arrow { font-size: 18px; color: #9ca3af; transition: transform 0.2s; }
        .menu-item.expanded .menu-arrow { transform: rotate(180deg); }
        
        .submenu { list-style: none; padding: 0; display: none; background: #fff; }
        .menu-item.expanded .submenu { display: block; }
        
        /* Submenu Padding 8px 20px 8px 50px */
        .submenu-link { display: flex; align-items: center; padding: 8px 20px 8px 50px; color: #4b5563; text-decoration: none; font-size: 13px; transition: 0.1s; }
        .submenu-link:hover { color: #111; background: #fafafa; }
        .submenu-link.active { color: var(--primary); font-weight: 600; background: #f0f7ff; }
        .submenu-link .material-icons-outlined { font-size: 18px; margin-right: 10px; opacity: 0.7; }
        .submenu-link.active .material-icons-outlined { opacity: 1; color: var(--primary); }

        .btn { padding: 0 16px; height: 35px; display: inline-flex; align-items: center; justify-content: center; font-weight: 500; font-size: 13px; border-radius: 4px; }
        .header-search { height: 34px; background: #f9fafb; border: 1px solid transparent; border-radius: 6px; padding-left: 35px; font-size: 13px; width: 280px; }
        .header-search:focus { background: #fff; border-color: #e5e7eb; outline: none; }
        
        .sidebar-close-btn { display: none; cursor: pointer; color: #6b7280; }
        @media (max-width: 992px) { 
            .main-sidebar { transform: translateX(-100%); } 
            .main-sidebar.active { transform: translateX(0); }
            .main-header, .app-container, .main-footer { left: 0; margin-left: 0; width: 100%; }
            .sidebar-close-btn { display: block; }
        }
    </style>
</head>
<body id="bodyMain">
    <div class="mobile-overlay" id="mobOverlay" onclick="toggleSidebarMobile()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1045;"></div>

    <aside class="main-sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center">
                <span class="material-icons-outlined fs-4 me-2 text-dark">wysiwyg</span> 
                <span>POS ADMIN</span>
            </div>
            <span class="material-icons-outlined sidebar-close-btn fs-4" onclick="toggleSidebarMobile()">close</span>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-header">Overview</li>
            <li class="menu-item">
                <a href="<?=base_url('dashboard')?>" class="menu-link">
                    <div class="d-flex align-items-center"><span class="material-icons-outlined menu-icon">dashboard</span> Dashboard</div>
                </a>
            </li>

            <li class="menu-header">Management</li>
            <li class="menu-item has-child"> 
                <a href="#" class="menu-link">
                    <div class="d-flex align-items-center"><span class="material-icons-outlined menu-icon">inventory_2</span> <?=lang('products')?></div>
                    <span class="material-icons-outlined menu-arrow">expand_more</span>
                </a>
                <ul class="submenu">
                    <li><a href="<?=base_url('products/create')?>" class="submenu-link"><span class="material-icons-outlined">add_circle</span> <?=lang('create_product')?></a></li>
                    <li><a href="<?=base_url('products')?>" class="submenu-link"><span class="material-icons-outlined">format_list_bulleted</span> <?=lang('list_products')?></a></li>
                    <li><a href="<?=base_url('categories')?>" class="submenu-link"><span class="material-icons-outlined">category</span> Categories</a></li>
                    <li><a href="<?=base_url('units')?>" class="submenu-link"><span class="material-icons-outlined">straighten</span> Units</a></li>
                </ul>
            </li>
            <li class="menu-item has-child"> 
                <a href="#" class="menu-link">
                    <div class="d-flex align-items-center"><span class="material-icons-outlined menu-icon">point_of_sale</span> <?=lang('sales')?></div>
                    <span class="material-icons-outlined menu-arrow">expand_more</span>
                </a>
                <ul class="submenu">
                    <li><a href="<?=base_url('sales/create')?>" class="submenu-link"><span class="material-icons-outlined">add_circle</span> <?=lang('add_sale')?></a></li>
                    <li><a href="<?=base_url('sales')?>" class="submenu-link"><span class="material-icons-outlined">receipt_long</span> <?=lang('list_sales')?></a></li>
                </ul>
            </li>
        </ul>
    </aside>

    <header class="main-header">
        <div class="d-flex align-items-center">
            <button class="btn p-0 me-3 text-dark border-0 bg-transparent" id="sidebarToggleBtn" onclick="handleSidebarToggle()">
                <span class="material-icons-outlined fs-3">menu</span>
            </button>
            <div class="position-relative d-none d-md-block">
                <span class="material-icons-outlined position-absolute text-muted" style="left: 10px; top: 8px; font-size:18px;">search</span>
                <input type="text" class="header-search" placeholder="Search...">
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none text-dark p-1 rounded" data-bs-toggle="dropdown">
                    <img src="https://flagcdn.com/w20/kh.png" width="20" class="rounded-1 shadow-sm">
                    <span class="ms-1 fw-bold small text-muted d-none d-sm-inline">KH</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                    <li><a class="dropdown-item" href="#">Khmer</a></li>
                    <li><a class="dropdown-item" href="#">English</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none text-dark gap-2" data-bs-toggle="dropdown">
                    <div style="width:32px; height:32px; background:#f3f4f6; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; color:#374151;">SD</div>
                    <span class="d-none d-md-block small fw-bold">Sok Dara</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>