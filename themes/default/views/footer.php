<footer class="main-footer" style="margin-left: var(--sidebar-width); height: 40px; background: #fff; border-top: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; font-size: 12px; margin-top: auto; color:#6b7280; transition: margin-left 0.3s;">
    <span>POS SYSTEM &copy; 2026</span>
    <span>|</span> 
    <span>Version 5.6</span>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="<?=base_url('assets/jquery/js/custom.js')?>"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    var base_url = `<?=base_url()?>`;

    // 1. GLOBAL TOGGLE FUNCTION (Accessible by onclick)
    function handleSidebarToggle() {
        if (window.innerWidth >= 992) {
            $('body').toggleClass('sidebar-closed'); 
        } else {
            $('#sidebar').toggleClass('active');
            $('#mobOverlay').toggle();
        }
    }

    function toggleSidebarMobile() {
        $('#sidebar').removeClass('active');
        $('#mobOverlay').hide();
    }

    // 2. GLOBAL UPLOAD TRIGGER (Simple & Reliable)
    function triggerUpload() {
        document.getElementById('imageInput').click();
    }

    function removeImage(e) {
        e.stopPropagation(); // Stop click from triggering upload again
        $('#imageInput').val('');
        $('#imagePreview').hide().attr('src', '');
        $('.upload-content').show();
        $('#removeImg').hide();
    }

    $(document).ready(function() {
        // 3. Menu Accordion
        $('.menu-link').on('click', function(e) {
            var $parent = $(this).parent();
            if($parent.hasClass('has-child')) {
                e.preventDefault();
                $('.menu-item.expanded').not($parent).removeClass('expanded');
                $parent.toggleClass('expanded');
            }
        });

        // 4. Auto-Active Menu
        var currentUrl = window.location.href.split('?')[0]; 
        $('.submenu-link').each(function() {
            if (this.href === currentUrl) {
                $(this).addClass('active'); 
                $(this).closest('.menu-item').addClass('expanded');
            }
        });

        // 5. Init Select2
        if ($('.select2').length > 0) {
            $('.select2').select2({ width: '100%' });
        }

        // 6. Image Preview Logic
        $('#imageInput').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    $('#imagePreview').attr('src', evt.target.result).show();
                    $('.upload-content').hide();
                    $('#removeImg').css('display', 'flex');
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
</body>
</html>