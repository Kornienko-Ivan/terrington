// (function ($) {
//     $(document).ready(function () {
//         function updateActiveCardPosition() {
//             let rowSize = 4; // Количество карточек в ряду на десктопе
//             let cardHeight = $('.filter-card').outerHeight(true); // Высота карточки с margin
//             let activeCard = $('.filter-card.active-card');
//
//             activeCard.each(function () {
//                 let index = $(this).index(); // Позиция карточки в списке
//                 let rowIndex = Math.floor(index / rowSize); // В каком ряду карточка
//
//                 // Если карточка в первом ряду, стандартный bottom (-82px)
//                 // Если ниже, увеличиваем отступ вниз
//                 let newBottom = -82 + (rowIndex * cardHeight);
//                 $(this).css('--before-bottom', `${newBottom}px`);
//             });
//         }
//
//         updateActiveCardPosition();
//         $(window).resize(updateActiveCardPosition); // Обновляем при изменении экрана
//
//         // Отслеживание добавления/удаления класса active-card
//         const observer = new MutationObserver(function (mutationsList) {
//             mutationsList.forEach((mutation) => {
//                 if (mutation.attributeName === "class") {
//                     updateActiveCardPosition();
//                 }
//             });
//         });
//
//         // Подключаем наблюдатель ко всем карточкам
//         $('.filter-card').each(function () {
//             observer.observe(this, { attributes: true });
//         });
//     });
// })(jQuery);
