<main class="app-container">
    <div class="card card-full">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><?=lang('list_products')?></span>
            <a href="<?=base_url('products/create')?>" class="btn btn-primary btn-sm">
                <span class="material-icons-outlined fs-6" style="vertical-align: middle;">add</span> Create
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="productData" class="table table-hover table-sm align-middle mb-0" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 40px;"><?=lang('image')?></th>
                            <th><?=lang('code')?></th>
                            <th><?=lang('name')?></th>
                            <th><?=lang('category')?></th>
                            <th><?=lang('unit')?></th>
                            <th><?=lang('price')?></th>
                            <th><?=lang('created_at')?></th>
                            <th><?=lang('created_by')?></th>
                            <th><?=lang('display')?></th>
                            <th class="text-end pe-3"><?=lang('actions')?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
// We use window.addEventListener('load') to wait until the ENTIRE page (including the footer) is loaded
window.addEventListener('load', function() {
    
    // Now jQuery is ready, so we can use $
    var table = $('#productData').DataTable({
        processing: true, 
        serverSide: true, 
        responsive: true, 
        autoWidth: false,
        dom: "<'d-flex justify-content-between align-items-center p-0'lf>t<'d-flex justify-content-between align-items-center p-1'ip>",
        ajax: {
            url: '<?php echo site_url('products/get_products'); ?>', 
            type: 'POST',
            data: function(d) { 
                d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>"; 
            }
        },
        columns: [
            { "data": "image", "searchable": false, "orderable": false, "render": dislayImage },
            { data: "code", className: "fw-bold text-dark font-mono small" },
            { data: "name", className: "fw-semibold small" },
            { data: "category", className: "small" },
            { data: "unit", className: "small" },
            { data: "price", className: "text-success fw-bold font-mono small" },
            { data: "created_at", className: "small text-muted" },
            { data: "created_by", className: "small" },
            { data: "active", className: "text-center", "render": Active },
            { data: "Actions", searchable: false, orderable: false, className: "text-center pe-3" }
        ],
        language: { 
            search: "", 
            searchPlaceholder: "Search..." 
        }
    });

});

// Helper functions must be OUTSIDE the event listener so HTML can find them if needed, 
// but since DataTables calls them internally, they are fine here or inside.
// Kept outside for safety.

function dislayImage(data, type, row) {
    if (data) {
        return '<img src="'+data+'" style="width:32px; height:32px; object-fit:cover; border-radius:4px; border:1px solid #f1f5f9;">';
    }
    return '<span class="material-icons-outlined text-muted fs-4">image</span>';
}

function Active(data, type, row) {
    return data == 1 
        ? '<span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>' 
        : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactive</span>';
}
</script>