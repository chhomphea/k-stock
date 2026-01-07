<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<div class="page-content">
    <div class="breadcrumb-area">
        <h5><?=lang('products')?></h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted" style="font-size:0.75rem;"><?=lang('dashboard')?></a></li>
                <li class="breadcrumb-item active" aria-current="page" style="font-size:0.75rem;"><?=lang('products')?></li>
            </ol>
        </nav>
    </div>
    <div class="card card-highlight">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark" style="font-size:0.8rem;">
                <span class="material-icons-outlined align-middle me-1" style="color: var(--theme-color);">add_circle</span> 
                <?=lang('create_product')?>
            </h6>
        </div>
        
        <div class="collapse show" id="createFormBody">
            <div class="card-body">
                <?php echo form_open_multipart(isset($product->id) ? "products/edit/".$product->id : "products/create"); ?>
                    <div class="row g-0">
                        <div class="col-md-6 pe-md-3 d-flex flex-column">
                            <div class="form-group mb-3">
                                <?= lang('code', 'code'); ?> <span class="text-danger">*</span>
                                <?= form_input('code',$product->code, 'class="form-control font-mono" id="code" placeholder="P-001"'); ?>
                            </div>
                            <div class="form-group mb-3">
                                <?= lang('name', 'name'); ?> <span class="text-danger">*</span>
                                <?= form_input('name', $product->name, 'class="form-control" id="name" placeholder="Product name"'); ?>
                            </div>
                            <div class="form-group mb-3">
                                <?= lang('category', 'categorySelect'); ?>
                                <?php 
                                    $catArr[''] = lang('please_select');
                                    foreach ($categories as $key => $cate) {
                                        $catArr[$cate->id] = $cate->name;
                                    }
                                ?>
                                <?= form_dropdown('category', $catArr, $product->category_id, 'class="form-select select2-basic" id="categorySelect" style="width:100%;"'); ?>
                            </div>
                            <div class="form-group mb-3">
                                <?= lang('unit', 'unit'); ?>
                                <?php 
                                    $unitArr[''] = lang('please_select');
                                    foreach ($units as $key => $u) {
                                        $unitArr[$u->id] = $u->name;
                                    }
                                ?>
                                <?= form_dropdown('unit', $unitArr, $product->unit_id, 'class="form-select w-100 select2-basic" id="unit" style="width:100%;"'); ?>
                            </div>
                            <div class="form-group mb-3">
                                <?= lang('cost', 'cost'); ?> <span class="text-danger">*</span>
                                <?= form_input('cost', $product->cost, 'class="form-control" id="cost" placeholder="Product cost"'); ?>
                            </div>
                            <div class="form-group mb-3">
                                <?= lang('price', 'price'); ?> <span class="text-danger">*</span>
                                <?= form_input('price', $product->price, 'class="form-control" id="price" placeholder="Product price"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col-md-3 ps-md-0 d-flex flex-column">
                            <label class="form-label w-100 text-start"><?=lang('image')?></label>
                            <div class="image-upload-wrapper" id="imageWrapper">
                                <div class="upload-placeholder text-center" id="uploadPlaceholder" style="display: <?=$product?'none':''?>">
                                    <i class="material-icons-outlined text-muted" style="font-size: 1.5rem;">cloud_upload</i>
                                    <span class="d-block text-muted mt-1" style="font-size:0.65rem;">Click to Upload</span>
                                </div>
                                <img id="imagePreview" src="<?=base_url('assets/uploads/').$product->image?>" alt="Preview" style="display: <?=$product?'':'none'?>">
                                <input type="file" id="imageInput" name="userfile" accept="image/*" style="display: none;">
                            </div>
                            <div class="text-center text-muted mb-1" style="font-size: 0.65rem;">PNG, JPG – Max 2MB</div>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top d-flex gap-2">
                        <button type="submit" class="btn btn-save btn-touch" id="btnSave">
                            <span class="material-icons-outlined me-1">save</span> <span class="btn-text"><?=lang('save')?></span>
                        </button>
                        <button type="button" class="btn btn-light btn-touch px-4">
                            <span class="material-icons-outlined me-1">close</span> Cancel
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-white border-bottom-0 pt-3 pb-2">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-dark" style="font-size:0.8rem;"><?=lang('list_products')?></h6>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="productData" class="table table-hover align-middle mb-0" style="width:100%">
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
                            <th class="text-end" style="width:40px;"><?php echo lang('actions'); ?></th>
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
    var table = $('#productData').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        autoWidth: false,
        "dom": '<"d-flex justify-content-between align-items-center px-3 py-2"lf>t<"d-flex justify-content-between align-items-center px-3 py-3"ip>',
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
            { "data": "name", "className": "fw-semibold" },
            { "data": "category" },
            { "data": "unit" },
            { "data": "price", "className": "font-mono fw-bold" },
            { "data": "created_at" },
            { "data": "created_by", "searchable": false },
            { "data": "active", "render": Active, "className": "text-center" },
            { "data": "Actions", "searchable": false, "orderable": false, "className": "text-center align-middle" }
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