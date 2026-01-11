<main class="app-container">
    <?php echo form_open("sales/create", ['id' => 'saleForm']); ?>
    
    <div class="card shadow-none border-0 rounded-0 h-100">
        
        <div class="card-header bg-white py-2 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <span class="material-icons-outlined fs-5 align-middle me-1 text-dark">point_of_sale</span>
                <span class="fw-bold text-dark text-uppercase">SALES ENTRY</span> 
            </div>
            <div class="text-muted fw-bold small"><?= date('d-M-Y') ?></div>
        </div>
        
        <div class="card-body p-3 d-flex flex-column" style="min-height: calc(100vh - 150px);">
            
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase text-muted mb-1">Date <span class="text-danger">*</span></label>
                    <div class="input-group input-group-sm">
                        <?php 
                            $dateVal = isset($date) ? date('Y-m-d\TH:i', strtotime($date)) : date('Y-m-d\TH:i');
                        ?>
                        <input type="datetime-local" name="date" value="<?= $dateVal ?>" class="form-control fw-bold" id="date" required style="font-size: 12px;">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase text-muted mb-1">Reference</label>
                    <?php echo form_input('reference_no', (isset($reference_no) ? $reference_no : ''), 'class="form-control form-control-sm" id="reference_no" placeholder=""'); ?>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase text-muted mb-1">Customer <span class="text-danger">*</span></label>
                    <?php 
                        $custArr = array(); 
                        if(isset($customers)){ foreach ($customers as $c) { $custArr[$c->id] = $c->name; } }
                        echo form_dropdown('customer_id', $custArr, (isset($customer_id) ? $customer_id : ''), 'class="form-select form-select-sm select2" id="customer_id" style="width:100%" required'); 
                    ?>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase text-muted mb-1">Store <span class="text-danger">*</span></label>
                    <?php 
                        $whArr = array(); 
                        if(isset($branches)){ foreach ($branches as $w) { $whArr[$w->id] = $w->branch_kh; } }
                        echo form_dropdown('warehouse_id', $whArr, (isset($warehouse_id) ? $warehouse_id : ''), 'class="form-select form-select-sm select2" id="warehouse_id" style="width:100%" required'); 
                    ?>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                            <span class="material-icons-outlined fs-6">qr_code_scanner</span>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" id="add_item" placeholder="Scan barcode or type product name..." style="font-size: 13px;">
                        <button class="btn btn-primary px-3" type="button" id="add_item_btn">
                            <span class="material-icons-outlined fs-6">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mt-3 flex-grow-1">
                <div class="col-12">
                    <div class="table-responsive" id="table-scroll-container">
                        <table id="posTable" class="table table-sm table-bordered align-middle mb-0" style="font-size: 12px;">
                            <thead class="bg-light">
                                <tr class="text-uppercase text-muted" style="font-size: 11px;">
                                    <th style="width: 50%;" class="fw-bold py-2 ps-2">Product</th>
                                    <th style="width: 10%;" class="fw-bold py-2 text-center">Unit</th>
                                    <th style="width: 15%;" class="fw-bold py-2 text-center">Price</th>
                                    <th style="width: 10%;" class="fw-bold py-2 text-center">Qty</th>
                                    <th style="width: 10%;" class="fw-bold py-2 text-end pe-2">Subtotal</th>
                                    <th style="width: 5%;" class="text-center py-2"><i class="material-icons-outlined" style="font-size: 14px; opacity:0.5">delete</i></th>
                                </tr>
                            </thead>
                            <tbody id="posTableBody">
                                </tbody>
                        </table>
                        
                        <div id="empty-msg" class="text-center p-4 text-muted bg-light mt-0 rounded-bottom border border-top-0">
                            <span class="material-icons-outlined fs-2 opacity-25">shopping_cart</span>
                            <p class="small mb-0 mt-1">Cart is empty.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-auto pt-2 border-top align-items-center bg-white sticky-bottom" style="z-index: 10;">
                
                <div class="col-md-5 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm fw-bold px-3 shadow-sm d-flex align-items-center">
                        <span class="material-icons-outlined fs-6 me-1">save</span> SAVE
                    </button>
                    <button type="button" class="btn btn-light btn-sm border fw-bold text-danger px-3 shadow-sm" onclick="clearLS()">
                        RESET
                    </button>
                </div>

                <div class="col-md-7">
                    <div class="d-flex justify-content-end align-items-center h-100">
                        
                        <div class="d-flex align-items-center me-3">
                            <label for="order_discount" class="text-muted fw-bold me-2 mb-0" style="font-size: 11px;">DISCOUNT</label>
                            <div class="input-group input-group-sm" style="width: 120px;">
                                <input type="number" name="order_discount" id="order_discount" class="form-control text-center fw-bold form-control-sm" value="0" placeholder="0">
                                <select class="input-group-text bg-light border-start-0 text-dark fw-bold px-1" id="order_discount_type" name="order_discount_type" style="width: 40px; cursor: pointer; font-size: 11px;">
                                    <option value="amount">$</option>
                                    <option value="percentage">%</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end ps-3 border-start">
                            <div class="text-primary fw-bolder" id="total_display" style="font-size: 28px; line-height: 1; letter-spacing: -0.5px;">$0.00</div>
                        </div>

                        <input type="hidden" name="total_price" id="total_price_input" value="0">
                        <input type="hidden" name="grand_total" id="grand_total_input" value="0">
                    </div>
                </div>

            </div>

        </div>
    </div>
    <?php echo form_close(); ?>
</main>

<style>
    /* FIX 2: FORCE SELECT2 DROPDOWNS TO BE ON TOP */
    .select2-container { z-index: 1060 !important; }
    .select2-dropdown { z-index: 1070 !important; }
    
    /* Small Table Inputs */
    .table-input {
        height: 28px !important;
        font-size: 12px !important;
        font-weight: 500;
        border: 1px solid transparent; 
        background-color: transparent;
        border-radius: 2px;
        padding: 0 5px;
        width: 100%;
        text-align: center;
        transition: all 0.2s ease;
    }

    .table-input:hover { background-color: #f9fafb; border-color: #e5e7eb; }
    .table-input:focus { border-color: #3b82f6; background-color: #fff; outline: none; box-shadow: none; }

    /* Compact Form Controls */
    .form-control-sm, .form-select-sm, 
    .select2-container--default .select2-selection--single {
        height: 30px !important;
        font-size: 12px !important;
        line-height: 1.5;
        border-radius: 0.2rem;
    }

    /* Select2 Alignment */
    .select2-container .select2-selection--single { display: flex; align-items: center; border-color: #ced4da; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 30px !important; padding-left: 8px; font-size: 12px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 28px !important; }

    /* Footer Inputs */
    #order_discount { border-right: 0; }
    #order_discount_type { background-color: #f8f9fa; border-left: 0; }
    
    .table-sm td, .table-sm th { padding: 4px 6px !important; vertical-align: middle !important; }
    .ui-autocomplete { z-index: 9999 !important; font-size: 12px; }
</style>

<script>
    $(document).ready(function() {
        if($('.select2').length > 0) { 
            // FIX 3: Ensure select2 is initialized properly
            $('.select2').not('#order_discount_type').select2({ width: '100%', dropdownParent: $('body') }); 
        }

        $("#add_item").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= site_url('sales/suggestions') ?>",
                    dataType: "json",
                    data: { term: request.term },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return { label: item.text, value: item.text, id: item.id, price: item.price, unit: item.unit };
                        }));
                    }
                });
            },
            minLength: 1, autoFocus: true,
            select: function(event, ui) { event.preventDefault(); addItem(ui.item); $(this).val(''); }
        });

        renderTable();

        $('#order_discount, #order_discount_type').on('change keyup', function() {
            renderTable();
        });

        $('#saleForm').on('submit', function() {
            let items = JSON.parse(localStorage.getItem('slitems')) || [];
            if (items.length === 0) { alert("Please add at least one product."); return false; }
        });
    });

    function addItem(item) {
        let items = JSON.parse(localStorage.getItem('slitems')) || [];
        let existing = items.find(x => x.id == item.id);
        if (existing) { existing.qty = parseFloat(existing.qty) + 1; } 
        else { items.push({ id: item.id, name: item.label, price: parseFloat(item.price), unit: item.unit, qty: 1 }); }
        localStorage.setItem('slitems', JSON.stringify(items));
        renderTable();
    }

    function renderTable() {
        let items = JSON.parse(localStorage.getItem('slitems')) || [];
        let html = ''; let total_sub = 0;
        
        if (items.length === 0) {
            $('#posTableBody').html(''); 
            $('#empty-msg').show(); 
            $('#total_display').text('$0.00'); 
            $('#total_price_input').val(0); 
            $('#grand_total_input').val(0); 
            return;
        }
        
        $('#empty-msg').hide();
        
        items.forEach((it, i) => {
            let qty = parseFloat(it.qty) || 0; 
            let price = parseFloat(it.price) || 0;
            let sub = qty * price;
            total_sub += sub;
            
            html += `<tr style="background: #fff;">
                <td class="text-start ps-2 align-middle">
                    <span class="fw-bold text-dark" style="font-size: 12px;">${it.name}</span>
                    <input type="hidden" name="product_id[]" value="${it.id}">
                    <input type="hidden" name="product_code[]" value="${it.code || ''}">
                    <input type="hidden" name="product_name[]" value="${it.name}">
                </td>
                <td class="text-center align-middle"><span class="badge bg-light text-dark border fw-normal" style="padding: 2px 6px; font-size: 10px;">${it.unit}</span></td>
                <td class="text-center align-middle"><input type="number" step="any" name="unit_price[]" class="table-input" value="${price}" onchange="updateItem(${i}, 'price', this.value)"></td>
                <td class="text-center align-middle"><input type="number" name="quantity[]" class="table-input fw-bold text-primary" value="${qty}" onchange="updateItem(${i}, 'qty', this.value)"></td>
                <td class="text-end pe-2 fw-bold text-dark align-middle" style="font-size: 12px;">$${sub.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                <td class="text-center align-middle"><button type="button" class="btn btn-sm text-danger p-0" onclick="removeItem(${i})"><i class="material-icons-outlined" style="font-size:16px">close</i></button></td>
            </tr>`;
        });
        
        $('#posTableBody').html(html);
        
        let od_val = parseFloat($('#order_discount').val()) || 0;
        let od_type = $('#order_discount_type').val(); 
        let order_disc_amt = (od_type === 'percentage') ? (total_sub * (od_val / 100)) : od_val;
        let grand_total = total_sub - order_disc_amt;
        
        $('#total_display').text('$' + grand_total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        $('#total_price_input').val(total_sub.toFixed(2));
        $('#grand_total_input').val(grand_total.toFixed(2));
    }

    function updateItem(i, f, v) { let items = JSON.parse(localStorage.getItem('slitems')); items[i][f] = v; localStorage.setItem('slitems', JSON.stringify(items)); renderTable(); }
    function removeItem(i) { let items = JSON.parse(localStorage.getItem('slitems')); items.splice(i, 1); localStorage.setItem('slitems', JSON.stringify(items)); renderTable(); }
    function clearLS() { if (confirm("Are you sure you want to clear the cart?")) { localStorage.removeItem('slitems'); renderTable(); } }
</script>