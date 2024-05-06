document.addEventListener('DOMContentLoaded', function() {
  let showProfilePopup = document.getElementById('showProfilePopup');

  function positionPopup(triggerButton) {
    let mypopup = document.querySelector('.profile-section1 > .dialog-widget-content');
    // Получаем координаты и размеры кнопки
    let buttonRect = triggerButton.getBoundingClientRect();  
    
    // Рассчитываем координаты для позиционирования попапа
    let top = buttonRect.bottom;
    let left = buttonRect.right - mypopup.clientWidth;

    // Позиционируем попап
    mypopup.style.top = top + "px";
    mypopup.style.left = left + "px";
    
  }

  showProfilePopup.addEventListener('click', function(event) {
    event.preventDefault();

    if (userLoggedIn.loggedIn) {
      showProfilePopup.href = "#popup-after";
      setTimeout(()=> {
        positionPopup(showProfilePopup);
      }, 0);
      
    } else {
      showProfilePopup.href = "#popup-before";
      setTimeout(()=> {
        positionPopup(showProfilePopup);
      }, 0);
    }
  }); 
});