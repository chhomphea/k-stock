<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>POS Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Nokora:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <style>
        /* --- VARIABLES --- */
        :root {
            --bg-body: #fdfdfd; --bg-card: #ffffff; --sidebar-bg: #ffffff;
            --primary: #3b82f6; --primary-light: #eff6ff;
            --text-main: #334155; --text-dark: #000000; --text-muted: #94a3b8;
            --border-color: #f1f5f9; --input-border: #d1d5db;
            --sidebar-width: 270px; --header-height: 60px;
            --input-height: 36px; --radius-md: 3px; --font-size: 13px;
        }
        ::-webkit-scrollbar {
            width: 1px;  /* Width for vertical scrollbars */
            height:1px; /* Height for horizontal scrollbars (tables) */
        }

        ::-webkit-scrollbar-track {
            background: transparent; 
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; /* Soft grey color */
            border-radius: 3px;   /* Rounded edges */
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; /* Darker grey when you grab it */
        }

        /* Firefox Support */
        * {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }
        @media (min-width: 1600px) { :root { --sidebar-width: 300px; } }
        @media (max-width: 1366px) { :root { --sidebar-width: 240px; } }
        @media (max-width: 992px)  { :root { --sidebar-width: 0px; } }
        html, body { height: 100%; margin: 0; padding: 0; }
        body { background-color: var(--bg-body); font-family: 'Inter', 'Nokora', sans-serif; font-size: var(--font-size); color: var(--text-main); overflow-x: hidden; display: flex; flex-direction: column; }
        .loader-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: #ffffff; z-index: 9999; display: flex; align-items: center; justify-content: center; transition: opacity 0.4s ease, visibility 0.4s ease; }
        .loader-overlay.hidden { opacity: 0; visibility: hidden; }
        .spinner { width: 40px; height: 40px; border: 3px solid rgba(59, 130, 246, 0.2); border-radius: 50%; border-top-color: var(--primary); animation: spin 0.8s linear infinite; }
        
        .main-sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; top: 0; left: 0; background: var(--sidebar-bg); border-right: 1px solid var(--border-color); z-index: 1050; display: flex; flex-direction: column; transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), width 0.3s ease; }
        body.sidebar-closed .main-sidebar { transform: translateX(-100%); }
        .main-sidebar.active { width: 280px !important; transform: translateX(0); }
        .main-header { position: fixed; top: 0; right: 0; left: var(--sidebar-width); height: var(--header-height); background: #fff; border-bottom: 1px solid var(--border-color); z-index: 1040; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; transition: left 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); }
        body.sidebar-closed .main-header { left: 0; }
        .app-container { margin-top: var(--header-height); margin-left: var(--sidebar-width); padding: 0; min-height: calc(100vh - var(--header-height) - 50px); background: var(--bg-body); transition: margin-left 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); display: flex; flex-direction: column; }
        body.sidebar-closed .app-container { margin-left: 0; }
        .main-footer { margin-left: var(--sidebar-width); height: 50px; background: #fff; border-top: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; gap: 10px; padding: 0 20px; font-size: 13px; color: var(--text-muted); transition: margin-left 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); margin-top: auto; }
        body.sidebar-closed .main-footer { margin-left: 0; }
        
        .sidebar-brand { height: var(--header-height); display: flex; align-items: center; gap: 12px; padding: 0 20px; border-bottom: 1px solid var(--border-color); background: #fff; }
        .brand-icon { width: 32px; height: 32px; background: #000; color: #fff; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .brand-text { font-weight: 800; font-size: 16px; color: #000; letter-spacing: -0.2px; white-space: nowrap; }
        
        .sidebar-menu { list-style: none; padding: 0; margin: 0; overflow-y: auto; flex: 1; padding-top: 10px; }
        .menu-header { font-size: 11px; font-weight: 800; color: #000; opacity: 0.5; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 20px 6px; }
        /* Cleaned up menu link padding */
        .menu-link { display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; color: #000; text-decoration: none; border-radius: 0; font-weight: 500; font-size: 14px; transition: all 0.2s; cursor: pointer; border-left: 1px solid transparent; }
        .menu-link:hover { background-color: #f8fafc; }
        .menu-item.expanded .menu-link, .menu-link.active { background-color: #f1f5f9; font-weight: 700; border-left-color: #000; }
        .menu-icon { font-size: 20px; margin-right: 12px; opacity: 0.8; }
        .submenu { list-style: none; padding: 0; margin: 0; display: none; background: #ffffff; }
        .menu-item.expanded .submenu { display: block; }
        .menu-item.expanded .menu-arrow { transform: rotate(180deg); }
        .submenu-link { display: flex; align-items: center; padding: 10px 20px 10px 52px; font-size: 13.5px; color: #000; text-decoration: none; border-left: 3px solid transparent; opacity: 0.7; }
        .submenu-link:hover, .submenu-link.active { opacity: 1; background-color: #fafafa; font-weight: 700; }
        .submenu-link.active { background-color: #f1f5f9; }
        .submenu-link::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background-color: #000; margin-right: 14px; opacity: 0.5; }
        .submenu-link.active::before { transform: scale(1.2); opacity: 1; }

        .header-btn { padding: 6px 0; color: #000; text-decoration: none; display: flex; align-items: center; gap: 8px; font-weight: 500; font-size: 13.5px; border: none; background: transparent; }
        .user-avatar-text { width: 32px; height: 32px; background: var(--primary-light); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; }

        .card-full { border: none; box-shadow: none; border-radius: 0; background: var(--bg-card); flex-grow: 1; margin: 0; }
        .card-header { background: #fff; border-bottom: 1px solid var(--border-color); padding: 15px 20px; font-size: 15px; font-weight: 700; color: #000; border-radius: 0 !important; }
        .card-body { padding: 20px; }
        .form-label { font-size: 12.5px; font-weight: 700; color: #000; margin-bottom: 6px; }
        .label-kh { font-weight: 400; color: #000; font-family: 'Nokora', sans-serif; font-size: 12px; margin-left: 6px; }
        
        /* Inputs & Selects */
        .form-control, .form-select { height: var(--input-height); padding: 6px 12px; font-size: 13px; border-radius: var(--radius-md); border: 1px solid var(--input-border); background-color: #fff; color: #000; transition: all 0.2s; }
        .form-control:focus, .form-select:focus { border-color: var(--input-border); box-shadow: none; outline: none; }
        .input-group-text { height: var(--input-height); padding: 6px 12px; font-size: 13px; background: #fff; border: 1px solid var(--input-border); color: #000; border-radius: var(--radius-md); border-right: none; }
        .input-group .form-control { border-left: 0; }
        /* Select2 */
        .select2-container .select2-selection--single { height: var(--input-height) !important; border-radius: var(--radius-md) !important; border: 1px solid var(--input-border) !important; background-color: #fff !important; padding: 0 !important; display: flex !important; align-items: center !important; }
        .select2-container--default.select2-container--open .select2-selection--single { border-color: var(--input-border) !important; box-shadow: none !important; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: normal !important; padding-left: 12px !important; color: #000 !important; font-size: 13px; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 100% !important; top: 0 !important; }
        /* Image Upload */
        .image-upload-container { display: flex; flex-direction: column; align-items: center; height: 100%; }
        .image-upload-wrapper { width: 4cm; height: 5cm; border-radius: var(--radius-md); border: 1px dashed var(--input-border); background: #fafafa; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; transition: 0.2s; }
        .image-upload-wrapper:hover { background: #fff; border-color: #000; }
        .btn-remove-img { position: absolute; top: 8px; right: 8px; background: #fff; border: 1px solid var(--border-color); border-radius: 50%; width: 28px; height: 28px; display: none; align-items: center; justify-content: center; color: #ef4444; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

        .btn { font-size: 13px; border-radius: var(--radius-md); padding: 7px 14px; font-weight: 500; }
        .btn-primary { background-color: var(--primary); border: 1px solid var(--primary); }
        .btn-save-new { background-color: #334155; border: 1px solid #334155; color: #fff; }
        .btn-save-new:hover { background-color: #1e293b; color: #fff; }
        .btn-danger-custom { background-color: #ef4444; border: 1px solid #ef4444; color: #fff; }
        .btn-danger-custom:hover { background-color: #dc2626; }
        .dropdown-menu { border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: 0 10px 30px rgba(0,0,0,0.04); padding: 8px; }
        .dropdown-item { border-radius: 4px; padding: 8px 16px; font-size: 13px; }
        
        .action-btn { width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; border: 1px solid var(--border-color); background: #fff; color: var(--text-main); transition: all 0.2s; }
        .action-btn:hover { border-color: var(--primary); color: var(--primary); background: #eff6ff; }
        .action-btn .material-icons-outlined { font-size: 18px; }
        .action-btn.dropdown-toggle::after { display: none; }

        /* --- TABLE FIXES FOR MOBILE --- */
        table.dataTable.no-footer { border-bottom: 1px solid #f1f5f9; }
        table.dataTable thead th { border-bottom: 1px solid #f1f5f9 !important; font-weight: 600; font-size: 12.5px; color: #64748b; background-color: #f8fafc; white-space: nowrap; }
        table.dataTable tbody td { border-bottom: 1px solid #f1f5f9; font-size: 13px; vertical-align: middle; white-space: nowrap; padding: 4px !important;}
        
        /* Ensure DataTables scroll body handles overflow */
        div.dataTables_wrapper div.dataTables_scrollBody { overflow-x: auto !important; -webkit-overflow-scrolling: touch; }
        .dataTables_scrollHeadInner { width: 100% !important; }
        .dataTables_scrollHeadInner table { width: 100% !important; margin-bottom: 0 !important; }
        .dataTables_scrollBody table { margin-top: 0 !important; width: 100% !important; }
        
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter { padding: 5px 7px !important; color: var(--text-muted); display: flex; align-items: center; }
        .dataTables_length select { border: 1px solid var(--input-border) !important; border-radius: var(--radius-md) !important; padding: 4px 30px 4px 10px !important; font-size: 13px !important; color: var(--text-main) !important; margin: 0 8px !important; min-width: 75px !important; background-color: #fff !important; appearance: none !important; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important; background-repeat: no-repeat !important; background-position: right 0.6rem center !important; background-size: 10px 10px !important; }
        .dataTables_filter input { border: 1px solid #e2e8f0; border-radius: var(--radius-md); padding: 5px 10px; font-size: 13px; height: 32px; }
        .dataTables_filter input:focus { outline: none; border-color: var(--primary); }
        .dataTables_paginate .page-item .page-link { border: 1px solid transparent; border-radius: 4px; color: var(--text-main); padding: 4px 10px; font-size: 12.5px; margin: 0 2px; box-shadow: none !important; }
        .dataTables_paginate .page-item.active .page-link { background-color: var(--primary); color: #fff; border-color: var(--primary); }
        .dataTables_paginate .page-item.disabled .page-link { color: #cbd5e1; background: transparent; }

        @media (max-width: 991.98px) {
            .main-sidebar { transform: translateX(-100%); }
            .sidebar-brand { display: none !important; }
            .sidebar-menu { padding-top: 20px; }
            .main-header { left: 0; width: 100%; padding: 0 16px; }
            .app-container { margin-left: 0; padding: 16px; border-top: 1px solid var(--border-color); background: #fdfdfd; }
            .main-footer { margin-left: 0; padding-left: 16px; padding-right: 16px; }
            .mobile-overlay.show { display: block; }
            .card-body { padding: 15px; }
            /* Force Smaller Font on Mobile */
            table.dataTable thead th { font-size: 11px !important; padding: 8px 10px !important; }
            table.dataTable tbody td { font-size: 11.5px !important;}
        }
        /* --- ADD THIS TO YOUR CSS --- */
            .mobile-overlay {
                position: fixed; 
                top: 0; 
                left: 0; 
                width: 100%; 
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5); /* Dimmed background */
                z-index: 1045; /* Below sidebar (1050) but above header (1040) */
                display: none;
                transition: opacity 0.3s;
            }

            /* Ensure the sidebar close button is only visible on mobile */
            .mobile-close-btn { display: none; }

            @media (max-width: 991.98px) {
                /* Existing code... */
                .mobile-overlay.show { display: block; }
                
                /* Show close button on mobile inside sidebar */
                .mobile-close-btn { 
                    display: flex; 
                    justify-content: flex-end; 
                    padding: 10px 15px;
                }
            }
            /* --- TOAST NOTIFICATION --- */
            .toast-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999; /* Ensure it stays on top of everything */
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .custom-toast {
                background: #fff;
                min-width: 300px;
                padding: 16px;
                border-radius: 4px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                border-left: 4px solid #10b981; /* Green success border */
                display: flex;
                align-items: center;
                animation: slideIn 0.3s ease-out forwards;
            }

            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
    </style>
</head>
<body id="bodyMain">
    <div id="pageLoader" class="loader-overlay">
        <div class="spinner"></div>
    </div>
    <input type="file" id="imageInput" accept="image/*" style="display: none;">
    <div class="mobile-overlay" id="mobOverlay" onclick="toggleSidebarMobile()"></div>
    <div class="toast-container" id="toastContainer"></div>
    <aside class="main-sidebar" id="sidebar">
        <a href="#" class="text-decoration-none">
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <span class="material-icons-outlined fs-6">inventory_2</span>
                </div>
                <span class="brand-text">POS ADMIN</span>
            </div>
        </a>
        <ul class="sidebar-menu">
            <li class="menu-header">Overview</li>
             <li class="menu-item">
                <a href="<?=base_url('dashboard')?>" class="menu-link">
                    <div class="d-flex align-items-center">
                        <span class="material-icons-outlined menu-icon">dashboard</span>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu-header">Management</li>
            <li class="menu-item has-child"> 
                <a class="menu-link" href="#">
                    <div class="d-flex align-items-center">
                        <span class="material-icons-outlined menu-icon">settings</span>
                        <span><?=lang('products')?></span>
                    </div>
                    <span class="material-icons-outlined menu-arrow">expand_more</span>
                </a>
                <ul class="submenu"> 
                    <li><a href="<?=base_url('products/create')?>" class="submenu-link"><?=lang('create_product')?></a></li>
                    <li><a href="<?=base_url('products')?>" class="submenu-link"><?=lang('list_products')?></a></li>
                    <li><a href="<?=base_url('categories')?>" class="submenu-link">Categories</a></li>
                    <li><a href="<?=base_url('units')?>" class="submenu-link">Units</a></li>
                </ul>
            </li>
            <li class="menu-item has-child">
                <a class="menu-link" href="#">
                    <div class="d-flex align-items-center">
                        <span class="material-icons-outlined menu-icon">shopping_cart</span>
                        <span><?=lang('sales')?></span>
                    </div>
                    <span class="material-icons-outlined menu-arrow">expand_more</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="<?=base_url('sales/create')?>" class="submenu-link"><?=lang('add_sale')?></a>
                    </li>
                    <li>
                        <a href="<?=base_url('sales')?>" class="submenu-link"><?=lang('list_sales')?></a>
                    </li>
                    <li><a href="<?=base_url('purchases')?>" class="submenu-link">Purchases</a></li>
                </ul>
            </li>
        </ul>
    </aside>
    <header class="main-header">
        <div class="d-flex align-items-center">
            <button class="btn p-0 me-3 text-dark d-flex align-items-center" onclick="handleSidebarToggle()">
                <span class="material-icons-outlined fs-2">menu</span>
            </button>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
                <button class="header-btn" data-bs-toggle="dropdown">
                    <img src="https://flagcdn.com/w20/kh.png" width="18" class="border rounded-1"> 
                    <span class="d-none d-sm-inline">KH</span>
                    <span class="material-icons-outlined fs-5 text-muted ms-1">expand_more</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border shadow-sm mt-2">
                    <li><a class="dropdown-item" href="#">Khmer</a></li>
                    <li><a class="dropdown-item" href="#">English</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <a href="#" class="header-btn" data-bs-toggle="dropdown">
                    <div class="user-avatar-text">SD</div>
                    <span class="me-1 d-none d-md-block" style="color:var(--text-main);">Sok Dara</span>
                    <span class="material-icons-outlined fs-5 text-muted ms-1">expand_more</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border shadow-sm mt-2" style="min-width: 200px;">
                    <li class="px-3 py-2 mb-1 border-bottom bg-light">
                        <div class="fw-bold text-dark">Sok Dara</div>
                        <small class="text-muted">Administrator</small>
                    </li>
                    <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>