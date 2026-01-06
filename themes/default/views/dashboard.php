
<div class="page-content">
    <div class="breadcrumb-area">
        <h5>Product Management</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0"><li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted" style="font-size:0.75rem;">Dashboard</a></li><li class="breadcrumb-item active" aria-current="page" style="font-size:0.75rem;">Products</li></ol>
        </nav>
    </div>

    <div class="card card-highlight">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark" style="font-size:0.8rem;">
                <span class="material-icons-outlined align-middle me-1" style="color: var(--theme-color);">add_circle</span> 
                CREATE PRODUCT
            </h6>
        </div>
        
        <div class="collapse show" id="createFormBody">
            <div class="card-body">
                <form id="productForm">
                    <div class="row g-0">
                        <div class="col-md-9 pe-md-4 border-end d-flex flex-column">
                            <div class="row g-2 mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control font-mono" placeholder="P-001">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Product name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Category</label>
                                    <select class="form-select select2-basic" id="categorySelect">
                                        <option selected disabled>Select...</option>
                                        <option value="create_new" class="fw-bold text-primary">+ Create New Category</option>
                                        <option value="1">Beverages</option>
                                        <option value="2">Food</option>
                                        <option value="3">Electronics</option>
                                        <option value="4">Household</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <span class="form-section-title mb-0 border-0">Units & Pricing</span>
                                <button type="button" class="btn btn-primary btn-add-unit" id="addUnitBtn" style="padding: 2px 8px; font-size: 0.7rem;">
                                    <span class="material-icons-outlined" style="font-size:14px !important;">add</span> Add Unit
                                </button>
                            </div>
                            
                            <div class="table-responsive border rounded mb-3">
                                <table class="table mb-0 unit-table" id="unitTable">
                                    <thead>
                                        <tr>
                                            <th width="30%">Unit Name</th>
                                            <th width="15%">Factor (Qty)</th>
                                            <th width="20%">Cost ($)</th>
                                            <th width="20%">Price ($)</th>
                                            <th width="5%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-select border-0 bg-transparent p-0">
                                                    <option selected>Can</option>
                                                    <option>Box</option>
                                                    <option>Pack</option>
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control border-0 bg-transparent p-0" value="1" readonly></td>
                                            <td><input type="number" class="form-control border-0 bg-transparent p-0" placeholder="0.00"></td>
                                            <td><input type="number" class="form-control border-0 bg-transparent p-0 fw-bold" placeholder="0.00"></td>
                                            <td class="text-center">
                                                <span class="material-icons-outlined text-muted" style="font-size:16px !important; cursor:not-allowed;">delete</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-3 ps-md-4 d-flex flex-column">
                            <label class="form-label w-100 text-start">Image</label>
                            <div class="image-upload-wrapper" id="imageWrapper">
                                <div class="upload-placeholder text-center" id="uploadPlaceholder">
                                    <i class="material-icons-outlined text-muted" style="font-size: 1.5rem;">cloud_upload</i>
                                    <span class="d-block text-muted mt-1" style="font-size:0.65rem;">Click to Upload</span>
                                </div>
                                <img id="imagePreview" src="#" alt="Preview" style="display:none;">
                                <input type="file" id="imageInput" accept="image/*" style="display: none;">
                            </div>
                            <div class="text-center text-muted mb-3" style="font-size: 0.65rem;">PNG, JPG – Max 2MB</div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select w-100 select2-basic">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-top d-flex gap-2">
                        <button type="submit" class="btn btn-save btn-touch" id="btnSave">
                            <span class="material-icons-outlined me-1">save</span> <span class="btn-text">Save Product</span>
                        </button>
                        <button type="button" class="btn btn-light btn-touch px-4">
                            <span class="material-icons-outlined me-1">close</span> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white border-bottom-0 pt-3 pb-2">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-dark" style="font-size:0.8rem;">PRODUCT LIST</h6>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="productsTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 20px;"><input type="checkbox" class="form-check-input mt-0" style="width:14px; height:14px;"></th>
                            <th style="width: 50px;">Img</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price (Base)</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" class="form-check-input mt-0" style="width:14px; height:14px;"></td>
                            <td><img src="https://placehold.co/400x400/093967/ffffff?text=HELP" class="product-img" data-bs-toggle="tooltip" title="Click to preview"></td>
                            <td class="font-mono text-muted">P-001</td>
                            <td class="fw-semibold">Coca Cola</td>
                            <td><span class="badge badge-subtle">Beverages</span></td>
                            <td class="font-mono fw-bold">$0.50</td>
                            <td><span class="badge badge-status-active">Active</span></td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="action-btn" data-bs-toggle="dropdown"><span class="material-icons-outlined">more_vert</span></button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 