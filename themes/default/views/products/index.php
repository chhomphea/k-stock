<main class="app-container">
    <div class="card card-full">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><?=lang('list_products')?></span>
            <!-- <a href="<?=base_url('products/create')?>" class="btn btn-primary btn-sm">
                <span class="material-icons-outlined fs-6" style="vertical-align: middle;">add</span> Create
            </a> -->
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="productData" class="table table-hover align-middle mb-2 nowrap" width="100%">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" style="width: 50px;"><?=lang('image')?></th>
                            <th><?=lang('code')?></th>
                            <th><?=lang('name')?></th>
                            <th><?=lang('category')?></th>
                            <th><?=lang('unit')?></th>
                            <th><?=lang('price')?></th>
                            <th><?=lang('created_at')?></th>
                            <th><?=lang('created_by')?></th>
                            <th class="text-center"><?=lang('display')?></th>
                            <th class="text-end pe-4"><?=lang('actions')?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
window.addEventListener('load', function() {
    var table = $('#productData').DataTable({
        processing: true, 
        serverSide: true, 
        responsive: false,
        scrollX: true,
        autoWidth: false,
        scrollCollapse: true,
        dom: "<'d-flex justify-content-between align-items-center'lf>t<'d-flex justify-content-between align-items-center p-1'ip>",
        ajax: {
            url: '<?php echo site_url('products/get_products'); ?>', 
            type: 'POST',
            data: function(d) { 
                d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>"; 
            }
        },
        columns: [
            { "data": "image", "searchable": false, "orderable": false, "render": dislayImage, className: "ps-4 text-center" },
            { data: "code", className: "fw-bold text-dark font-mono small" },
            { data: "name", className: "fw-semibold small" },
            { data: "category", className: "small" },
            { data: "unit", className: "small" },
            { data: "price", className: "text-success fw-bold font-mono small" },
            { data: "created_at", className: "small text-muted" },
            { data: "created_by", className: "small" },
            { data: "active", className: "text-center", "render": Active },
            { data: "Actions", searchable: false, orderable: false, className: "text-center pe-4" }
        ],
        language: { 
            search: "", 
            searchPlaceholder: "ស្វែងរក...",
            lengthMenu: "បង្ហាញ _MENU_ ជួរ",
            info: "បង្ហាញ _START_ ដល់ _END_ នៃ _TOTAL_",
            infoEmpty: "បង្ហាញ 0 ដល់ 0 នៃ 0",
            infoFiltered: "(បានច្រោះពី _MAX_ សរុប)",
            zeroRecords: "មិនមានទិន្នន័យទេ",
            paginate: {
                first: "ដំបូង",
                last: "ចុងក្រោយ",
                next: "បន្ទាប់",
                previous: "ថយក្រោយ"
            }
        }
    });
});
</script>