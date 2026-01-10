<main class="app-container">
    <div class="card card-full">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><?=lang('list_sales')?></span>
            <!-- <a href="<?=base_url('sales/create')?>" class="btn btn-primary btn-sm">
                <span class="material-icons-outlined fs-6" style="vertical-align: middle;">add</span> <?=lang('add_sale')?>
            </a> -->
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="salesData" class="table table-hover align-middle mb-2 nowrap" width="100%">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4"><?=lang('date')?></th>
                            <th><?=lang('customer')?></th>
                            <th><?=lang('branch')?></th>
                            <th><?=lang('total_items')?></th>
                            <th><?=lang('grand_total')?></th>
                            <th><?=lang('paid')?></th>
                            <th class="text-center"><?=lang('payment_status')?></th>
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
    var table = $('#salesData').DataTable({
        processing: true, 
        serverSide: true, 
        responsive: false,
        scrollX: true,
        autoWidth: false,
        scrollCollapse: true,
        order: [[0, "desc"]], // Sort by date descending
        dom: "<'d-flex justify-content-between align-items-center'lf>t<'d-flex justify-content-between align-items-center p-1'ip>",
        ajax: {
            url: '<?php echo site_url('sales/get_sales'); ?>', 
            type: 'POST',
            data: function(d) { 
                d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>"; 
            }
        },
        columns: [
            { data: "date", className: "ps-4 small fw-bold" },
            { data: "customer", className: "fw-semibold small" },
            { data: "branch_name", className: "small" },
            { data: "total_items", className: "text-center small" },
            { 
                data: "grand_total", 
                className: "text-dark fw-bold font-mono small",
                render: function(data) { return parseFloat(data).toFixed(2); } 
            },
            { 
                data: "paid_amount", 
                className: "text-success fw-bold font-mono small",
                render: function(data) { return parseFloat(data).toFixed(2); }
            },
            { 
                data: "payment_status", 
                className: "text-center",
                render: function(data) {
                    let badge = 'bg-secondary';
                    if(data == 'paid') badge = 'bg-success';
                    if(data == 'partial') badge = 'bg-warning';
                    if(data == 'pending') badge = 'bg-danger';
                    return `<span class="badge ${badge} uppercase" style="font-size:10px;">${data}</span>`;
                }
            },
            { data: "Actions", searchable: false, orderable: false, className: "text-end pe-4" }
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