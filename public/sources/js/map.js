import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// координаты центра карты
let cords = [53.936072, 27.598794]
// координаты центра карты для window < 768

if ($(window).width() < 992) {
    /*console.log('map-center-tablet')*/
    cords = [53.936072, 27.598794];
}
if ($(window).width() < 768) {
    /*console.log('map-center-mobile')*/
    cords = [53.935421, 27.612963];
}

ymaps.ready(function () {
    // Создание экземпляра карты и его привязка к созданному контейнеру.
    var myMap = new ymaps.Map('map', {
        center: cords, // координаты центра карты вынес наверх
        zoom: 14,
        behaviors: ['zoomControl', 'typeSelector', 'fullscreenControl']
    }, {
        searchControlProvider: 'yandex#search'
    });

    myMap.behaviors.disable('scrollZoom');
    myMap.behaviors.enable('drag');

    // Создание макета балуна на основе Twitter Bootstrap.
    MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
        '<div class="popover">' +
        '<a class="close" href="#">&times;</a>' +
        '<div class="popover-inner">' +
        '$[[options.contentLayout]]' +
        '</div>' +
        '<div class="arrow"></div>' +
        '</div>', {
            /**
             * Строит экземпляр макета на основе шаблона и добавляет его в родительский HTML-элемент.
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#build
             * @function
             * @name build
             */
            build: function () {
                this.constructor.superclass.build.call(this);

                this._$element = $('.popover', this.getParentElement());

                this.applyElementOffset();

                this._$element.find('.close')
                    .on('click', $.proxy(this.onCloseClick, this));
            },

            /**
             * Удаляет содержимое макета из DOM.
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#clear
             * @function
             * @name clear
             */
            clear: function () {
                this._$element.find('.close')
                    .off('click');

                this.constructor.superclass.clear.call(this);
            },

            /**
             * Сдвигаем балун, чтобы "хвостик" указывал на точку привязки.
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
             * @function
             * @name applyElementOffset
             */
            applyElementOffset: function () {
                this._$element.css({
                    left: -(this._$element[0].offsetWidth / 2),
                    top: -(this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight)
                });
            },

            /**
             * Закрывает балун при клике на крестик, кидая событие "userclose" на макете.
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
             * @function
             * @name onCloseClick
             */
            onCloseClick: function (e) {
                e.preventDefault();

                this.events.fire('userclose');
            },

            /**
             * Проверяем наличие элемента (в ИЕ и Опере его еще может не быть).
             * @function
             * @private
             * @name _isElement
             * @param {jQuery} [element] Элемент.
             * @returns {Boolean} Флаг наличия.
             */
            _isElement: function (element) {
                return element && element[0] && element.find('.arrow')[0];
            }
        }),


        MyBalloonLayout2 = ymaps.templateLayoutFactory.createClass(
            '<div class="popover _parking">' +
            '<a class="close" href="#">&times;</a>' +
            '<div class="popover-inner">' +
            '$[[options.contentLayout]]' +
            '</div>' +
            '<div class="arrow"></div>' +
            '</div>', {
                /**
                 * Строит экземпляр макета на основе шаблона и добавляет его в родительский HTML-элемент.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#build
                 * @function
                 * @name build
                 */
                build: function () {
                    this.constructor.superclass.build.call(this);

                    this._$element = $('.popover', this.getParentElement());

                    this.applyElementOffset();

                    this._$element.find('.close')
                        .on('click', $.proxy(this.onCloseClick, this));
                },

                /**
                 * Удаляет содержимое макета из DOM.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#clear
                 * @function
                 * @name clear
                 */
                clear: function () {
                    this._$element.find('.close')
                        .off('click');

                    this.constructor.superclass.clear.call(this);
                },

                /**
                 * Сдвигаем балун, чтобы "хвостик" указывал на точку привязки.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
                 * @function
                 * @name applyElementOffset
                 */
                applyElementOffset: function () {
                    this._$element.css({
                        left: -(this._$element[0].offsetWidth / 2),
                        top: -(this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight)
                    });
                },

                /**
                 * Закрывает балун при клике на крестик, кидая событие "userclose" на макете.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
                 * @function
                 * @name onCloseClick
                 */
                onCloseClick: function (e) {
                    e.preventDefault();

                    this.events.fire('userclose');
                },

                /**
                 * Проверяем наличие элемента (в ИЕ и Опере его еще может не быть).
                 * @function
                 * @private
                 * @name _isElement
                 * @param {jQuery} [element] Элемент.
                 * @returns {Boolean} Флаг наличия.
                 */
                _isElement: function (element) {
                    return element && element[0] && element.find('.arrow')[0];
                }
            }),

        // Создание вложенного макета содержимого балуна.
        MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div class="w-baloon">' +
            '<div class="wrapper">' +
            '<div class="w-baloon-name">' +
            '$[properties.balloonName]' +
            '</div>' +
            '</div>' +
            '</div>'

        ),

        // Создание метки с пользовательским макетом балуна.
        myPlacemark = window.myPlacemark = new ymaps.Placemark([53.935421, 27.612963], {
            balloonName: 'г. Минск, ул. Кнорина, 17',
        }, {
            balloonShadow: false,
            balloonLayout: MyBalloonLayout,
            balloonContentLayout: MyBalloonContentLayout,
            balloonPanelMaxMapArea: 0,
            hideIconOnBalloonOpen: false,

            iconLayout: 'default#image',
            iconImageHref: '/assets/i/map_marker.png',
            iconImageSize: [91, 112],
            iconImageOffset: [-46, -99]
        });
    myMap.geoObjects.add(myPlacemark);



});
