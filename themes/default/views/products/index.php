<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<div class="page-content">
    <div class="breadcrumb-area">
        <h5>Product Management</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted" style="font-size:0.75rem;">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="font-size:0.75rem;">Products</li>
            </ol>
        </nav>
    </div>

    <div class="card card-highlight">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark" style="font-size:0.8rem;">
                <span class="material-icons-outlined align-middle me-1" style="color: var(--theme-color);">add_circle</span> 
                CREATE PRODUCT
            </h6>
            <button class="btn btn-light" style="padding: 2px 6px; height: 24px;" type="button" data-bs-toggle="collapse" data-bs-target="#createFormBody">
                <span class="material-icons-outlined" style="font-size:1rem !important;">expand_less</span>
            </button>
        </div>
        
        <div class="collapse show" id="createFormBody">
            <div class="card-body">
                <form id="productForm">
                    <div class="row g-0">
                        <div class="col-md-9 pe-md-4 border-end d-flex flex-column">
                            <div class="row g-2 mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control font-mono" name="code" placeholder="P-001">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Product name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Category</label>
                                    <select class="form-select select2-basic" name="category" id="categorySelect">
                                        <option selected disabled>Select...</option>
                                        <option value="1">Standard</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-auto pt-3 border-top d-flex gap-2">
                                <button type="submit" class="btn btn-save btn-touch">
                                    <span class="material-icons-outlined me-1">save</span> Save Product
                                </button>
                                <button type="button" class="btn btn-light btn-touch px-4">
                                    <span class="material-icons-outlined me-1">close</span> Cancel
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 ps-md-4 d-flex flex-column">
                             <label class="form-label w-100 text-start">Image</label>
                            <div class="image-upload-wrapper" style="height: 100px;">
                                <i class="material-icons-outlined text-muted">cloud_upload</i>
                            </div>
                        </div>
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
                <table id="branchData" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th style="max-width:45px;"><?php echo lang("image"); ?></th>
                            <th><?php echo lang('code'); ?></th>
                            <th><?php echo lang('name'); ?></th>
                            <th><?php echo lang('category'); ?></th>
                            <th><?php echo lang('unit'); ?></th>
                            <th><?php echo lang('price'); ?></th>
                            <th><?php echo lang('created_at'); ?></th>
                            <th><?php echo lang('created_by'); ?></th>
                            <th><?php echo lang('display'); ?></th>
                            <th class="text-end" style="width:75px;"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="10" class="dataTables_empty text-center p-4">
                                <?php echo lang('loading_data_from_server'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#branchData').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        autoWidth: false,
        "dom": '<"d-flex justify-content-between align-items-center px-3 py-2"f>t<"d-flex justify-content-between align-items-center px-3 py-3"ip>',
        
        'ajax': {
            url: '<?php echo site_url('products/get_products'); ?>',
            type: 'POST',
            data: function(d) {
                d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
            },
            error: function(xhr, error, thrown) {
                console.error('AJAX error:', error, thrown, xhr.status, xhr.responseText);
                alert('Failed to load data. Please check the console for details.');
            }
        },
        "columns": [
            { "data": "image", "searchable": false, "orderable": false, "render": dislayImage },
            { "data": "code" },
            { "data": "name", "className": "fw-semibold" }, // Added bold class to name
            { "data": "category" },
            { "data": "unit" },
            { "data": "price", "className": "font-mono fw-bold" }, // Added font-mono to price
            { "data": "created_at" },
            { "data": "created_by", "searchable": false },
            { "data": "active", "render": Active, "className": "text-center" },
            { "data": "Actions", "searchable": false, "orderable": false, "className": "text-end" }
        ],
        "order": [[1, 'asc']],
        "language": {
            "emptyTable": "<?php echo lang('no_data_available'); ?>",
            "loadingRecords": "<?php echo lang('loading_data_from_server'); ?>",
            "search": "", 
            "searchPlaceholder": "Search products...",
            "paginate": {
                "previous": "<span class='material-icons-outlined' style='font-size:1rem !important'>chevron_left</span>",
                "next": "<span class='material-icons-outlined' style='font-size:1rem !important'>chevron_right</span>"
            },
            "zeroRecords": `<div class="text-center p-4"><span class="material-icons-outlined text-muted" style="font-size:48px;">inventory_2</span><p class="mb-0 mt-2 text-muted" style="font-size:0.8rem;">No data found.</p></div>`
        }
    });
    $(window).on('resize', function() {
        table.columns.adjust();
    });
});
</script>