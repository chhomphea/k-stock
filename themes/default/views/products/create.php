<main class="app-container">
    <?php 
    $attrib = array('id' => 'createForm', 'style' => 'height: 100%;');
    // Using CodeIgniter form helper to open form
    echo form_open_multipart(isset($product->id) ? "products/edit/".$product->id : "products/create", $attrib); 
    ?>
        <div class="card card-full">
            <div class="card-header">
                <span>General Information</span>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-8 col-12">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <?= lang('code', 'code'); ?> <span class="label-kh">(កូដ)</span> <span class="text-danger">*</span>
                                </label>
                                <?php echo form_input('code', (isset($product->code) ? $product->code : ''), 'class="form-control" id="code" placeholder="P-2026-001"'); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <?= lang('name', 'name'); ?> <span class="label-kh">(ឈ្មោះ)</span> <span class="text-danger">*</span>
                                </label>
                                <?php echo form_input('name', (isset($product->name) ? $product->name : ''), 'class="form-control" id="name" placeholder="Product Name"'); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <?= lang('category', 'categorySelect'); ?> <span class="label-kh">(ប្រភេទ)</span> <span class="text-danger">*</span>
                                </label>
                                <?php 
                                    $catArr = array();
                                    foreach ($categories as $cate) { 
                                        $catArr[$cate->id] = $cate->name; 
                                    } 
                                    echo form_dropdown('category', $catArr, (isset($product->category_id) ? $product->category_id : ''), 'class="form-select select2-basic" id="categorySelect" style="width:100%"'); 
                                ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <?= lang('unit', 'unit'); ?> <span class="label-kh">(ខ្នាត)</span> <span class="text-danger">*</span>
                                </label>
                                <?php 
                                    $unitArr = array();
                                    foreach ($units as $u) { 
                                        $unitArr[$u->id] = $u->name; 
                                    } 
                                    echo form_dropdown('unit', $unitArr, (isset($product->unit_id) ? $product->unit_id : ''), 'class="form-select select2-basic" id="unit" style="width:100%"'); 
                                ?>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label">
                                    <?= lang('cost', 'cost'); ?> <span class="label-kh">(ថ្លៃដើម)</span> <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <?php echo form_input('cost', (isset($product->cost) ? $product->cost : '0.00'), 'class="form-control" id="cost"'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    <?= lang('price', 'price'); ?> <span class="label-kh">(តម្លៃលក់)</span> <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <?php echo form_input('price', (isset($product->price) ? $product->price : '0.00'), 'class="form-control fw-bold text-primary" id="price"'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    <?= lang('alert_quantity', 'alert_quantity'); ?> <span class="label-kh">(បរិមាណ)</span>
                                </label>
                                <?php echo form_input('alert_quantity', (isset($product->alert_quantity) ? $product->alert_quantity : '10'), 'class="form-control" id="alert_quantity"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12 image-upload-container">
                        <div style="width: 150px;">
                            <label class="form-label text-center d-block">
                                <?= lang('image', 'image'); ?> <span class="label-kh">(រូបភាព)</span>
                            </label>
                            
                            <div class="image-upload-wrapper" id="uploadBox">
                                <?php 
                                    // Logic to determine if image exists
                                    $hasImage = isset($product->image) && !empty($product->image);
                                    $imgSrc = $hasImage ? base_url('assets/uploads/').$product->image : '';
                                ?>

                                <button type="button" class="btn-remove-img" id="removeImg" style="<?= $hasImage ? 'display:flex' : 'display:none' ?>">
                                    <span class="material-icons-outlined fs-5">close</span>
                                </button>
                                
                                <div class="upload-content text-center" style="<?= $hasImage ? 'display:none' : '' ?>">
                                    <div class="mb-2 text-primary">
                                        <span class="material-icons-outlined" style="font-size: 32px;">cloud_upload</span>
                                    </div>
                                    <div class="text-dark fw-bold small">Click to Upload</div>
                                    <div class="text-muted" style="font-size:11px">4x4 cm</div>
                                </div>

                                <img src="<?= $imgSrc ?>" id="imagePreview" style="<?= $hasImage ? 'display:block' : 'display:none' ?>; width:100%; height:100%; object-fit:cover; border-radius:inherit; position:absolute;">
                                
                                <input type="file" id="imageInput" name="userfile" accept="image/*" style="display:none;">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-start gap-2 action-buttons">
                            <button type="submit" class="btn btn-primary" id="btnSave">
                               <span class="material-icons-outlined fs-6 me-1" style="vertical-align: middle;">save</span> <?=lang('save')?>
                            </button>
                            
                            <button type="button" class="btn btn-save-new" onclick="triggerSaveNew()"> <span class="material-icons-outlined fs-6 me-1" style="vertical-align: middle;">add_circle</span> Save & New
                            </button>
                            
                            <a href="<?= base_url('products') ?>" class="btn btn-danger-custom">
                               <span class="material-icons-outlined fs-6 me-1" style="vertical-align: middle;">close</span> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php echo form_close(); ?>
</main>