$(document).ready(function () {
    $('.toggle-password').on('click', function () {
        const targetId = $(this).attr('data-target');
        const $targetInput = $('#' + targetId);

        if ($targetInput.length === 0) return;

        if ($targetInput.attr('type') === 'password') {
            $targetInput.attr('type', 'text');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            $targetInput.attr('type', 'password');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });

    const $featuresToggle = $('#featuresToggle');
    const $featuresList = $('#featuresList');
    const $toggleArrow = $('#toggleArrow');
    const $toggleText = $('#toggleText');
    
    if ($featuresToggle.length && $featuresList.length) {
        $featuresToggle.on('click', function () {
            $featuresList.toggleClass('active-dropdown');
            
            if ($featuresList.hasClass('active-dropdown')) {
                $toggleArrow.removeClass('fa-chevron-down').addClass('fa-chevron-up');
                $toggleText.text("Hide what's included");
            } else {
                $toggleArrow.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                $toggleText.text("See what's included");
            }
        });
    }
});