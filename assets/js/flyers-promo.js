let currentFlyerImages = [];
let currentFlyerIndex = 0;

function loadBranchFlyersFromDB(cabangId) {
    $.ajax({
        url: 'flyers.php',
        type: 'GET',
        data: { cabang_id: cabangId },
        dataType: 'json',
        cache: false,
        success: function(images) {
            const wrapper = $('#flyerSlidesWrapper');
            
            if (wrapper.hasClass('slick-initialized')) {
                wrapper.slick('unslick');
            }
            
            wrapper.empty();
            currentFlyerImages = images || [];

            if (!currentFlyerImages || currentFlyerImages.length === 0) {
                wrapper.html('<div style="padding:60px 20px; text-align:center; font-weight:bold; color:#8A7F73;">Belum ada flyer promo untuk cabang ini.</div>');
                $('#downloadFlyerBtn').attr('href', '#');
                return;
            }

            $.each(currentFlyerImages, function(index, imgName) {
                const imgPath = window.baseUrl + imgName;
                wrapper.append('<div><img src="' + imgPath + '" alt="Flyer Promo Manna Kampus" data-index="' + index + '"></div>');
            });

            wrapper.slick({
                centerMode: true,
                centerPadding: '320px',
                slidesToShow: 1,
                infinite: false,
                speed: 400,
                prevArrow: $('#flyerPrevBtn'),
                nextArrow: $('#flyerNextBtn'),
                responsive: [
                    { breakpoint: 1200, settings: { centerPadding: '220px' } },
                    { breakpoint: 992, settings: { centerPadding: '140px' } },
                    { breakpoint: 768, settings: { centerPadding: '0px' } }
                ]
            });

            updateDownloadBtn();
            wrapper.on('afterChange', function(event, slick, currentSlide){
                updateDownloadBtn();
            });
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            $('#flyerSlidesWrapper').html('<div style="padding:60px 20px; text-align:center; color:red; font-weight:bold;">Gagal memuat data flyer.</div>');
        }
    });
}

function updateDownloadBtn() {
    setTimeout(function() {
        const activeImg = $('#flyerSlidesWrapper .slick-center img').attr('src');
        if (activeImg && activeImg !== '#') {
            $('#downloadFlyerBtn').attr('href', activeImg);
        }
    }, 200);
}

// Buka Overlay Fullscreen saat Promo Aktif Diklik
$(document).on('click', '#flyerSlidesWrapper .slick-center img', function(e) {
    e.preventDefault(); // Mencegah halaman melompat ke atas
    currentFlyerIndex = parseInt($(this).attr('data-index')) || 0;
    openOverlay(currentFlyerIndex);
});

function openOverlay(index) {
    if (currentFlyerImages.length === 0) return;
    
    currentFlyerIndex = index;
    const imgPath = window.baseUrl + currentFlyerImages[currentFlyerIndex];
    $('#mkOverlayImage').attr('src', imgPath);
    $('#mkSuperIndoOverlay').addClass('active');
    
    // Kunci scroll body
    $('body').addClass('mk-no-scroll');
}

function closeOverlay() {
    $('#mkSuperIndoOverlay').removeClass('active');
    
    // Lepas kuncian scroll body
    $('body').removeClass('mk-no-scroll');
}

// Event Listener Tombol Tutup & Klik Area Luar Overlay
$(document).on('click', '#closeOverlayBtn', function(e) {
    e.stopPropagation();
    closeOverlay();
});

$(document).on('click', '#mkSuperIndoOverlay', function(e) {
    if ($(e.target).is('#mkSuperIndoOverlay') || $(e.target).hasClass('mk-overlay-content')) {
        closeOverlay();
    }
});

// Navigasi Gambar Kiri & Kanan
$('#overlayPrevBtn').on('click', function(e) {
    e.stopPropagation();
    if (currentFlyerIndex > 0) {
        currentFlyerIndex--;
        openOverlay(currentFlyerIndex);
    }
});

$('#overlayNextBtn').on('click', function(e) {
    e.stopPropagation();
    if (currentFlyerIndex < currentFlyerImages.length - 1) {
        currentFlyerIndex++;
        openOverlay(currentFlyerIndex);
    }
});

// Tutup dengan Tombol ESC Keyboard
$(document).keyup(function(e) {
    if (e.key === "Escape") {
        closeOverlay();
    }
});

$('#branchFlyerSelect').on('change', function() {
    loadBranchFlyersFromDB($(this).val());
});

$(document).ready(function() {
    const defaultCabang = $('#branchFlyerSelect').val();
    if (defaultCabang) {
        loadBranchFlyersFromDB(defaultCabang);
    }
});

function printFlyer() {
    const activeImgSrc = $('#flyerSlidesWrapper .slick-center img').attr('src');
    if (!activeImgSrc || activeImgSrc === '#') {
        alert('Tidak ada flyer yang dapat dicetak.');
        return;
    }
    
    const win = window.open('', '_blank');
    win.document.write(`
        <html>
            <head><title>Print Flyer Promo Manna Kampus</title></head>
            <body style="margin:0; display:flex; justify-content:center; align-items:center;">
                <img src="${activeImgSrc}" style="max-width:100%; height:auto;" onload="window.print(); window.close();"/>
            </body>
        </html>
    `);
    win.document.close();
}