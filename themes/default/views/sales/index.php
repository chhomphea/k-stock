<main class="app-container">
    <div class="card shadow-none border-0 rounded-0 h-100">
        
        <div class="card-header bg-white py-2 border-bottom" style="border-color: #f3f4f6;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="material-icons-outlined fs-5 align-middle me-1 text-dark">point_of_sale</span>
                    <span class="fw-bold text-dark" style="font-size: 14px;">SALES LIST</span> 
                    <span class="label-kh ms-1 text-muted" style="font-size: 12px;">(បញ្ជីការលក់)</span>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive h-100">
                <table id="salesData" class="table table-hover table-sm align-middle mb-0 nowrap" width="100%">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3 py-2 text-muted small text-uppercase fw-bold"><?=lang('date')?></th>
                            <th class="py-2 text-muted small text-uppercase fw-bold"><?=lang('customer')?></th>
                            <th class="py-2 text-muted small text-uppercase fw-bold"><?=lang('branch')?></th>
                            <th class="text-center py-2 text-muted small text-uppercase fw-bold"><?=lang('total_items')?></th>
                            <th class="py-2 text-muted small text-uppercase fw-bold"><?=lang('grand_total')?></th>
                            <th class="py-2 text-muted small text-uppercase fw-bold"><?=lang('paid')?></th>
                            <th class="text-center py-2 text-muted small text-uppercase fw-bold"><?=lang('payment_status')?></th>
                            <th class="text-end pe-3 py-2 text-muted small text-uppercase fw-bold"><?=lang('actions')?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<style>
    #salesData { font-size: 12.5px; }
    #salesData thead th { border-bottom: 1px solid #f3f4f6; background-color: #f9fafb; }
    #salesData tbody td { border-bottom: 1px solid #f8fafc; padding: 6px 10px; color: #334155; }
    
    .dt-toolbar { padding: 8px 12px; border-bottom: 1px solid #f3f4f6; background: #fff; }
    
    .dataTables_filter input { 
        height: 30px; border-radius: 3px; border: 1px solid #e5e7eb; 
        padding-left: 8px; font-size: 12px; outline: none; box-shadow: none; width: 200px; 
    }
    .dataTables_filter input:focus { border-color: #2563eb; }
    
    .dataTables_length select { 
        height: 30px; border-radius: 3px; border: 1px solid #e5e7eb; 
        padding: 0 25px 0 8px; font-size: 12px; outline: none; 
    }
    
    .dataTables_paginate { padding: 10px 15px; font-size: 11px; }
    .page-link { color: #64748b; border: 1px solid transparent; border-radius: 3px; margin: 0 1px; padding: 4px 8px; }
    .page-item.active .page-link { background-color: #2563eb; border-color: #2563eb; color: #fff; }
    .dataTables_info { padding: 12px 15px; font-size: 11px; color: #94a3b8; }
</style>

<script type="text/javascript">
window.addEventListener('load', function() {
    var table = $('#salesData').DataTable({
        processing: true, 
        serverSide: true, 
        responsive: false,
        scrollX: true,
        autoWidth: false,
        order: [[0, "desc"]], // Keep sort by date
        // Use the Product List DOM layout
        dom: "<'dt-toolbar d-flex justify-content-between align-items-center'lf>t<'d-flex justify-content-between align-items-center bg-white border-top'ip>",
        ajax: {
            url: '<?php echo site_url('sales/get_sales'); ?>', 
            type: 'POST',
            data: function(d) { 
                d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>"; 
            }
        },
        columns: [
            { data: "date", className: "ps-3 fw-bold text-dark font-mono" },
            { data: "customer", className: "fw-semibold text-dark" },
            { data: "branch_name", className: "text-muted" },
            { data: "total_items", className: "text-center text-muted" },
            { 
                data: "grand_total", 
                className: "text-primary fw-bold font-mono",
                render: function(data) { return parseFloat(data).toFixed(2); } 
            },
            { 
                data: "paid_amount", 
                className: "text-success fw-bold font-mono",
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
                    return `<span class="badge ${badge} uppercase" style="font-size:10px; padding: 4px 8px;">${data}</span>`;
                }
            },
            { data: "Actions", searchable: false, orderable: false, className: "text-end pe-3" }
        ],
        language: { 
            search: "", 
            searchPlaceholder: "Search...", 
            lengthMenu: "_MENU_", 
            infoEmpty: "0 records", 
            paginate: { first: "«", last: "»", next: "›", previous: "‹" } 
        },
        initComplete: function() {
            // Style the length menu dropdown matches Product List
            $('.dataTables_length select').removeClass('form-select').css({'display': 'inline-block', 'width': 'auto'});
        }
    });
});
</script>