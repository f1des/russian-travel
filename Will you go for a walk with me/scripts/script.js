window.addEventListener('DOMContentLoaded', function init () {
  window.removeEventListener('DOMContentLoaded', init);  
 

  //Печатающий текст
  function animateTypingText(text, targetElementId) {
    const targetElement = document.getElementById(targetElementId);
  
    if (!targetElement) {
      console.error('Элемент с идентификатором ' + targetElementId + ' не найден на странице.');
      return;
    }
  
    targetElement.innerHTML = '';
  
    let i = 0;
    function typeWriter1() {
      if (i < text.length && i < 15) {
        targetElement.innerHTML += text.charAt(i);
        i++;
        setTimeout(typeWriter1, 100);
      } else {
        setTimeout(typeWriter2, 1500);
      }
    }
  
    function typeWriter2() {
      let j = 0;
      let secondText = 'Ты пойдешь со мной на свидание?';
      targetElement.innerHTML = '';
      function typeWriter() {
        if (j < secondText.length) {
          targetElement.innerHTML += secondText.charAt(j);
          j++;
          setTimeout(typeWriter, 100);
        }
      }
      setTimeout(typeWriter, 0);
    }
  
    setTimeout(typeWriter1, 0); // Запускаем первую часть анимации
  }
  
  animateTypingText('Привеееет, Юля!', 'typingText');

  //Анимация кнопки, не весь функционал задействован
  let animateButton = function(e) {

    e.preventDefault;
    //reset animation
    e.target.classList.remove('animate');
    
    e.target.classList.add('animate');
    setTimeout(function(){
      e.target.classList.remove('animate');
    },700);
  };

  let bubblyButtons = document.getElementsByClassName("bubbly-button");

  for (let i = 0; i < bubblyButtons.length; i++) {
    bubblyButtons[i].addEventListener('click', animateButton, false);
  }

  // Попап
  document.querySelectorAll('.button').forEach(function(button) {
    button.addEventListener('click', function() {
      let buttonId = this.getAttribute('id');
      document.getElementById('modal-container').setAttribute('class', buttonId);
      document.body.classList.add('modal-active');
    });
  });

  document.getElementById('modal-container').addEventListener('click', function() {
    this.classList.add('out');
    document.body.classList.remove('modal-active');
  });

})

let clicked = false;

function handleMouseOver() {
  if (clicked) {
    moveButton();
  }
}

function handleClick() {
  clicked = true;
  moveButton();
}

function moveButton() {
  const button = document.getElementById('disagreeButton');
  const { offsetWidth, offsetHeight } = button;

  const x = Math.random() * (window.innerWidth - offsetWidth - 85);
  const y = Math.random() * (window.innerHeight - offsetHeight - 48);

  button.style.left = `${x}px`;
  button.style.top = `${y}px`;
}



