document.addEventListener('DOMContentLoaded', function () {
    let isDarkMode = false;
  
    const darkModeButton = document.getElementById('darkModeButton');
    darkModeButton.addEventListener('click', function () {
      isDarkMode = !isDarkMode;
      document.body.style.backgroundColor = isDarkMode ? '#0f0f0f' : 'white';
  
      const paragraphs = document.querySelectorAll('p');
      const content = document.querySelectorAll('.white-content');
      const contentSec = document.querySelectorAll('.white-content-secondary');
  
      content.forEach(element => {
        element.style.backgroundColor = isDarkMode ? '#212020' : 'white';
      });
  
      contentSec.forEach(element => {
        element.style.backgroundColor = isDarkMode ? '#212020' : 'white';
      });
  
      paragraphs.forEach(paragraph => {
        paragraph.style.color = isDarkMode ? 'white' : 'black';
      });
  
      darkModeButton.textContent = isDarkMode ? 'Jour' : 'Nuit';
    });
  });
  