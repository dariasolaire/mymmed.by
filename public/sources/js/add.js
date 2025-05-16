$(document).ready(function () {

    var configHeaders = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        "dataType": "json",
        "contentType": 'application/json; charset=utf-8',
    };

    let timeout = null;
    $("#site-search-input").keyup(function (I) {
        if ($(this).val().length >= 3 || $(this).val().length == 0)  {
            $('#site-search-input').val($(this).val());

            var send = {
                queries: $(this).val(),
                page: $(this).data('page'),
                time: $(this).data('eventTime'),
            };
            clearTimeout(timeout);
            timeout = setTimeout(function () {

                $.ajax({
                    type: 'POST',
                    url: '/search-items',
                    data: send,
                    headers: configHeaders,
                    success: function (data) {
                        $('._js-search-list-items').html(data.itemsSearchHtml);
                    },
                    async: false
                });
            }, 500);
        }
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('._js-result').length && !$(event.target).is('#site-search-input')) {
            $('._js-result').html('').hide();
        }
    });

    $(document).on('change', '._js-specialization-select, [name=type]', function(e) {
        e.preventDefault();

        var send = {
            specialization: $('._js-specialization-select').val(),
            types: $('[name=type]:checked')
                .map(function() { return $(this).val(); })
                .get(),
            time:  $('#site-search-input').data('eventTime'),
        };
        $.ajax({
            type: 'POST',
            url: '/filter-events',
            data: send,
            headers: configHeaders,
            success: function (data) {
                if (data.itemsHtml) {
                    $('._js-search-list-items').html(data.itemsHtml);
                }
            },
            async: false
        });
    });


    $(document).on('click', '._js-all-theses', function (e) {
        e.preventDefault();
        $('._js-item-theses').show();
        $(this).hide();
        return false
    })

    $(document).on('click', '._js-change-day, ._js-change-room', function(e) {
        e.preventDefault();

        if ($(this).hasClass('_js-change-day')) {
            $('._js-change-day').removeClass('_active');
            $(this).addClass('_active');
        } else if ($(this).hasClass('_js-change-room')) {
            $('._js-change-room').removeClass('blue');
            $(this).addClass('blue');
        }

        var send = {
            eventId: $('._js-event-id').data('eventId'),
            day: $('._js-change-day._active').data('day'),
            room: $(this).data('room') || 1
        };

        var url = $(this).hasClass('_js-change-day') ? '/get-event-rooms' : '/get-event-video';

        $.ajax({
            type: 'POST',
            url: url,
            data: send,
            headers: configHeaders,
            success: function(data) {
                if (data.html) {
                    $('._js-rooms-day').html(data.html);
                }
            }
        });
    });
    $(document).on('click', '._js-register-event', function(e) {
        e.preventDefault();

       var send = {
            eventId: $(this).data('eventId'),
            userId: $(this).data('userId'),
        };

        var url = '/register-event';

        $.ajax({
            type: 'POST',
            url: url,
            data: send,
            headers: configHeaders,
            success: function(data) {
                $('._js-validation-alert .content ul').html(data.message);
                $('._js-validation-alert').css('display', 'block');
                $('._js-validation-alert').removeClass('hide');
                $('._js-validation-alert .success').show();

                setTimeout(function() { $('._js-validation-alert').hide(); }, 4000);
            }
        });
    });



    function updateEventTime() {

        var send = {
            eventId: $('._js-event-id').data('eventId'),
        };

        var url = '/update-event-time';

        $.ajax({
            type: 'POST',
            url: url,
            data: send,
            headers: configHeaders,
            success: function(data) {

            }
        });
    }

    if($('._js-event-id').length) {
        var eventUserCountPopup = $('._js-event-id').data('eventUserCountPopup');
        var timePopup = $('._js-event-id').data('timePopup') * 60 * 1000;
        var countPopup = $('._js-event-id').data('countPopup');


        setInterval(updateEventTime, 60000);

        if (countPopup > eventUserCountPopup) {
            setTimeout(function() {
                var pop_id = 'event';
                $('.s-popup').show();
                $('.s-popup__background').show();
                $('._js-popup.' + pop_id ).addClass('animate');
                $('._js-popup.' + pop_id ).css("display" , "inline-block");
                return false;
            }, timePopup);
        }

    }

    $(document).on('click', '._js-close-popup-event', function(e) {
        e.preventDefault();
        closePopup();
    });
    function closePopup() {
        $('.s-popup').hide();
        $('.w-popup').hide();
        $('.s-popup__background').hide();
        $('.w-popup').removeClass('animate');

        var send = {
            eventId: $('._js-event-id').data('eventId'),
        };
        var url = '/record-popup';

        $.ajax({
            type: 'POST',
            url: url,
            data: send,
            headers: configHeaders,
            success: function(data) {
                eventUserCountPopup = data.popupCount;
            }
        });
        return false;

    }

    $(document).on('click', '._js-registration-user', function(e) {
        e.preventDefault();
        $('._js-registration-block').show();
        $('._js-search-block').hide();

    });
    $(document).on('click', '._js-search-user', function(e) {
        e.preventDefault();
        $('[name=search]').val('');
        $('._js-registration-block').hide();
        $('._js-search-block').show();

    });

    $(document).on('click', '._js-ajax-registration-user', function(e) {
        e.preventDefault();
        var send = {
            userId: $(this).data('userId'),
            eventId: $(this).data('eventId'),
        };
        $(this).closest('._js-button-reg').html('<p>Зарегистрирован</p>')
        var url = '/registration-user-event';

        $.ajax({
            type: 'POST',
            url: url,
            data: send,
            headers: configHeaders,
            success: function(data) {

                $('._js-validation-alert .content ul').html(data.message);
                $('._js-validation-alert').css('display', 'block');
                $('._js-validation-alert').removeClass('hide');
                $('._js-validation-alert .success').show();

                setTimeout(function() { $('._js-validation-alert').hide(); }, 4000);
            }
        });
        return false;

    });

    $(document).on('click', '._js-b-anchor', function(e) {
        e.preventDefault();
        let buttonId = $(this).attr('button-id');
        $('html, body').animate({
            scrollTop: $('._js-section'+buttonId).offset().top
        }, 1000);
    });


    function gatherAnswers() {
        let totalQuestions = $('._js-question').length;
        let answers = [];

        for (let i = 1; i <= totalQuestions; i++) {
            let selected = $(`input[name='radio${i}']:checked`).val() || '';
            answers.push({ question: i, answer: selected });
        }
        return answers;
    }

    $(document).on('click', '._js-answer', function(e) {
        let answers = gatherAnswers();


        var send = {
            userId: $('._js-event-test').data('userId'),
            eventId: $('._js-event-test').data('eventId'),
            answers: answers
        };
        var url = '/send-user-test-answers';

        $.ajax({
            type: 'POST',
            url: url,
            data: send,
            headers: configHeaders,
            success: function(data) {


            }
        });

    });
    $(document).on('click', '._js-get-result', function(e) {

        if ($('._js-question').length == $('[type="radio"]:checked').length) {
            window.location = $(this).attr('href');

        }
        else {
            $('._js-validation-alert .content ul').html('Не на все вопросы был дан ответ');
            $('._js-validation-alert').css('display', 'block');
            $('._js-validation-alert').removeClass('hide');
            $('._js-validation-alert .success').show();

            setTimeout(function() { $('._js-validation-alert').hide(); }, 4000);

        }
        return false;

    });

    if($("#datepicker").length) {

        $.datepicker.regional['ru'] = {
            closeText: 'Закрыть',
            prevText: 'Предыдущий',
            nextText: 'Следующий',
            currentText: 'Сегодня',
            monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
            monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
            dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
            dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
            dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
            weekHeader: 'Не',
            dateFormat: 'dd.mm.yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['ru']);



        var dates = null;

        $.ajax({
            type: 'POST',
            url: "/api/events/get-dates",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "dataType": "json",
                "contentType": 'application/json; charset=utf-8',
            },
            success: function (data) {
                dates = data;
            },
            async: false
        });

        $("#datepicker").datepicker({

            beforeShowDay: function (date) {
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                var isAvailable = dates.indexOf(string) != -1;
                var today = new Date();
                var isToday = date.toDateString() === today.toDateString();
                var className = isToday ? 'ui-datepicker-today' : '';
                return [isAvailable, '', className];
            }
        });


        $("#datepicker")
            .on("change", function () {
                if ($(this).val() > $('#datepicker_value').val()) {
                    window.location.href = '/events/next?date=' + $(this).val()
                }
                else {
                    window.location.href = '/events/prev?date=' + $(this).val()
                }
            });

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };


        if (getUrlParameter('date')) {
            $( "#datepicker" ).datepicker("setDate", getUrlParameter('date'));
        }

    }

    $(document).on('click', '._js-dell-profile', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "/delete-profile",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "dataType": "json",
                "contentType": 'application/json; charset=utf-8',
            },
            success: function (data) {

            },
            async: false
        });

    })

    $(document).on('click', '._js-remove-user-association', function(e) {
        e.preventDefault();


        var send = {
            userId: $(this).data('userId'),
            associationId: $(this).data('associationId'),
        };
        var url = '/api/remove-user-association';
        $(this).closest('.w-cabinet-associations-list-item').remove();

        $.ajax({
            type: 'POST',
            url: url,
            data: send,
            headers: configHeaders,
            success: function(data) {
            }
        });

    });




})
