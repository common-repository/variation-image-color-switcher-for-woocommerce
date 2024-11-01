(function ($) {
    $(document).on('change', '.variation-radios input', function () {
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
            $('select[name="' + $(this).attr('name') + '"]').val($(this).val()).trigger('change');
        } else {
            $box.prop("checked", false);
            $('select[name="' + $(this).attr('name') + '"]').val('').trigger('change');
        }
    });

    //flatesome popup support
    $(document).on('change', '.product-lightbox-inner .variation-radios input', function () {
        digger();
    });
    $(".variations_form").on("woocommerce_variation_has_changed", function () {
        digger();
    });
    // Disable click on variation that have no stock
    function digger() {
        $('.variation-radios input').prop("disabled", true);
        $('.variations select').each(function () {
            $(this).find('option').each(function () {
                var isDisabled = $(this).prop('disabled');
                var disb = $(this).val();
                //alert(isDisabled + disb );
                $('.variation-radios input[value="' + disb + '"]').prop("disabled", isDisabled);

            });

        });

    }
    $("form.variations_form a.reset_variations").click(function (e) {
        e.preventDefault();
        $("form.variations_form.cart")[0].reset()
    });

})(jQuery);