<footer>
            <div id="liveTime" class="live-clock"></div>
            <div>© 2025 HELPYOU Software. All rights reserved.</div>
        </footer>
    </div> <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-body p-0 position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2 bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="" id="modalImage" class="img-fluid w-100 rounded" alt="Preview">
                </div>
            </div>
        </div>
    </div>
    <script src="<?=base_url('assets/jquery/js/datatable.js')?>"></script>
    <script src="<?=base_url('assets/jquery/js/bootstrap.bundle.min.js')?>"></script>
    <script src="<?=base_url('assets/jquery/js/custom.js')?>"></script>
    <script>
        $(window).on('load', function() {
            setTimeout(function() {
                $('#pageLoader').addClass('fade-out');
                setTimeout(function(){ $('#pageLoader').remove(); }, 200);
            }, 300);
        });
        var base_url = "<?=base_url()?>";
        $(document).ready(function() {
            $('.select2-basic').select2({ minimumResultsForSearch: 10, width: '100%' });
            $('#categorySelect').on('select2:select', function (e) {
                if(e.params.data.id === 'create_new') { $(this).val(null).trigger('change'); alert("Logic to open 'Create Category' modal goes here!"); }
            });
            $(document).on('click', '.product-img', function() {
                var src = $(this).attr('data-full');
                $('#modalImage').attr('src', src);
                new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
            });
            $('#menu-toggle').click(function(e) { e.stopPropagation(); toggleSidebar(); });
            $('#sidebar-overlay, #sidebar-close').click(function() { $('#sidebar').removeClass('active'); $('#sidebar-overlay').removeClass('active'); });
            function toggleSidebar() {
                var width = $(window).width();
                if(width <= 992) { $('#sidebar').toggleClass('active'); $('#sidebar-overlay').toggleClass('active'); } 
                else {
                    var marginLeft = $('.main-content').css('margin-left');
                    if (marginLeft === '0px') { $('.main-content').css('margin-left', '300px'); $('#sidebar').css('margin-left', '0'); } 
                    else { $('.main-content').css('margin-left', '0px'); $('#sidebar').css('margin-left', '-300px'); }
                }
            }
            $('#imageWrapper').on('click', function() { $('#imageInput').trigger('click'); });
            $('#imageInput').on('click', function(e) { e.stopPropagation(); });
            $('#imageInput').on('change', function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) { $('#imagePreview').attr('src', e.target.result).show(); $('#uploadPlaceholder').hide(); }
                    reader.readAsDataURL(this.files[0]);
                }
            });
            function updateTime() {
                const now = new Date();
                const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
                document.getElementById('liveTime').textContent = now.toLocaleString('en-US', options).replace(',', '');
            }
            setInterval(updateTime, 1000); updateTime();

            $('#addUnitBtn').click(function() {
                var newRow = `<tr><td><select class="form-select border-0 bg-transparent p-0"><option>Can</option><option>Box</option></select></td><td><input type="number" class="form-control border-0 bg-transparent p-0" value="1"></td><td><input type="number" class="form-control border-0 bg-transparent p-0" placeholder="0.00"></td><td><input type="number" class="form-control border-0 bg-transparent p-0 fw-bold" placeholder="0.00"></td><td class="text-center"><button type="button" class="btn-danger-soft rounded border-0 p-1 d-flex align-items-center justify-content-center delete-row" style="width:24px; height:24px;"><span class="material-icons-outlined" style="font-size:14px !important;">delete</span></button></td></tr>`;
                $('#unitTable tbody').append(newRow);
            });
            $('#unitTable').on('click', '.delete-row', function() { $(this).closest('tr').remove(); });

            // $('#productForm').on('submit', function(e) {
            //     e.preventDefault(); 
            //     var $btn = $('#btnSave');
            //     var originalText = $btn.find('.btn-text').text();
            //     var icon = $btn.find('.material-icons-outlined');
                
            //     $btn.prop('disabled', true);
            //     icon.hide();
            //     $btn.find('.btn-text').html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...');
            // });
        });
    </script>
</body>
</html>