import $ from "jquery";
window.$ = $;

(function ($) {

    $.fn.zValid = function (options) {

        var settings = $.extend({
            form: $(this),
            url: $(this).attr('action'),
            type: $(this).attr('method'),
        }, options);

        this.submit(function () {
            $('._js-agree').removeClass('_error');
            $('.checkout__delivery-item').removeClass('_error');

            $('._js-validation-alert .content ul').html('');
            $('._js-validation-alert .icon').hide();
            $('._js-validation-alert').css('display', 'none');

            var
                oldForm = settings.form[0],
                formData = new FormData(oldForm)
            ;

            $.ajax({
                type: settings.type,
                url: settings.url,
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {

                    if (data.url) {
                        window.location.href = data.url
                        return false
                    }

                    $('._js-registration-block').hide();
                    $('._js-result-search').html('');
                    if (data.html) {
                        $('._js-result-search').html(data.html)
                        return false
                    }
                    else {
                        $('._js-registration-block').show();
                    }

                    settings.form.find('input, textarea').removeClass('_error');
                    $('.select__default').removeClass('_error');

                    $('._js-validation-alert .content ul').html(data.message);
                    $('._js-validation-alert').css('display', 'block');
                    $('._js-validation-alert').removeClass('hide');
                    $('._js-validation-alert .success').show();

                    setTimeout(function() { $('._js-validation-alert').hide(); }, 4000);

                    if ('success' in settings) {
                        settings.success();
                    }


                },
                error: function (v) {
                    settings.form.find('input, textarea').removeClass('_error');
                    // $('.border').css('border-color', 'transparent');
                    if (v.status == '401') {
                        var string_error = v.responseJSON.message;
                        if ('errorValidate' in settings) {
                            settings.errorValidate(v);
                        }

                        $('._js-validation-alert .content ul').html(string_error);
                        $('._js-validation-alert').css('display', 'block');
                        $('._js-validation-alert').removeClass('hide');
                        $('._js-validation-alert .error').show();

                        setTimeout(function () {
                            $('._js-validation-alert').hide();
                        }, 4000);


                    }
                    else if (v.status == '422') {
                        var string_error = '';
                        var key; // Declare key outside the loop
                        for (key in v.responseJSON.errors) {
                            settings.form.find('[name="' + key + '"]').addClass('_error');
                            settings.form.find('[data-name="' + key + '"]').addClass('_error');
                            string_error += '<li>' + v.responseJSON.errors[key] + '</li>';

                            if (key == 'i_agree') {
                                $('._js-agree').addClass('_error');
                            }
                            if (key == 'delivery') {
                                $('.checkout__delivery-item').addClass('_error');
                            }
                        }

                        if ('errorValidate' in settings) {
                            settings.errorValidate(v);
                        }

                        $('html, body').animate({
                            scrollTop: $("._error").parent().offset().top - 94
                        }, 1000);

                        $('._js-validation-alert .content ul').html(string_error);
                        $('._js-validation-alert').css('display', 'block');
                        $('._js-validation-alert').removeClass('hide');
                        $('._js-validation-alert .error').show();

                        setTimeout(function () {
                            $('._js-validation-alert').hide();
                        }, 4000);
                    }



                },

                async: false
            });

            return false;
        });

    };
})(jQuery);
