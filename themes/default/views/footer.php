<footer class="main-footer">
    <span>POS SYSTEM &copy; 2026</span>
    <span>|</span> 
    <span>Version 5.6</span>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="<?=base_url('assets/jquery/js/custom.js')?>"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
    var base_url = `<?=base_url()?>`;

    // ... (Your existing window load code stays here) ...
    window.addEventListener('load', function() {
        setTimeout(function() {
            var loader = document.getElementById('pageLoader');
            if (loader) {
                loader.classList.add('hidden');
                setTimeout(function() { loader.style.display = 'none'; }, 400);
            }
        }, 300); 
    });

    $(document).ready(function() {
        // 1. Sidebar Active State
        var currentUrl = window.location.href.split('?')[0];
        $('.sidebar-menu a').each(function() {
            var linkUrl = this.href.split('?')[0];
            if (currentUrl === linkUrl) {
                $(this).addClass('active');
                $(this).closest('.submenu-link').addClass('active'); // Highlight submenu item
                var parentLi = $(this).closest('.menu-item.has-child');
                if (parentLi.length > 0) {
                    parentLi.addClass('expanded');
                }
            }
        });

        // 2. FIXED: Sidebar Menu Click Event (This was missing)
        $('.sidebar-menu .has-child > .menu-link').on('click', function(e) {
            e.preventDefault(); // Stop # link from jumping
            var $parentLi = $(this).closest('.menu-item');

            // Check if we are closing or opening
            if ($parentLi.hasClass('expanded')) {
                $parentLi.removeClass('expanded');
            } else {
                // Optional: Close other open menus so only one stays open (Accordion style)
                $('.menu-item.expanded').removeClass('expanded'); 
                $parentLi.addClass('expanded');
            }
        });
        if ($('.select2-basic').length > 0) {
            $('.select2-basic').select2({ width: '100%', minimumResultsForSearch: Infinity }); 
        }

        // 4. Image Upload Logic
        const fileInput = $('#imageInput');
        const uploadBox = $('#uploadBox');
        if (uploadBox.length) {
            uploadBox.on('click', function(e) {
                if (e.target.id === 'imageInput' || $(e.target).closest('#removeImg').length > 0) return;
                fileInput.trigger('click');
            });
            fileInput.on('click', function(e) { e.stopPropagation(); });
            fileInput.on('change', function() {
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
            $('#removeImg').on('click', function(e) {
                e.stopPropagation(); e.preventDefault();
                fileInput.val('');
                $('#imagePreview').hide().attr('src', '');
                $('.upload-content').show();
                $(this).hide();
            });
        }
    });
    function handleSidebarToggle() {
        if (window.innerWidth >= 992) {
            $('body').toggleClass('sidebar-closed'); 
        } else {
            toggleSidebarMobile(); 
        }
    }
    
    function toggleSidebarMobile() {
        var sidebar = $('#sidebar');
        sidebar.toggleClass('active');
        $('#mobOverlay').toggleClass('show');
    }
    $(document).ready(function() {
        <?php if ($error) { ?>
            showToast('error', '<?= lang("error"); ?>', '<?= addslashes($error); ?>');
        <?php } if ($warning) { ?>
            showToast('warning', '<?= lang("warning"); ?>', '<?= addslashes($warning); ?>');
        <?php } if ($message) { ?>
            showToast('success', '<?= lang("Success"); ?>', '<?= addslashes($message); ?>');
        <?php } ?>
    });
    function showToast(type, title, message) {
        let icon = 'check_circle';
        let colorClass = 'text-success';
        let borderClass = 'border-success';

        if (type === 'error') {
            icon = 'cancel';
            colorClass = 'text-danger';
            borderClass = 'border-danger';
        } else if (type === 'warning') {
            icon = 'warning';
            colorClass = 'text-warning';
            borderClass = 'border-warning';
        }

        const toastHTML = `
            <div class="custom-toast ${borderClass}">
                <span class="material-icons-outlined ${colorClass} fs-3 me-3">${icon}</span>
                <div>
                    <div class="fw-bold" style="font-size:13px">${title}</div>
                    <small class="text-muted" style="font-size:11px">${message}</small>
                </div>
            </div>`;

        $('#toastContainer').append(toastHTML);

        // Auto-remove after 4 seconds
        setTimeout(() => {
            $('.custom-toast').first().fadeOut(300, function() {
                $(this).remove();
            });
        }, 4000);
    }
</script>
</body>
</html>