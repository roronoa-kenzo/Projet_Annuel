document.addEventListener('DOMContentLoaded', function () {
  let isDarkMode = false;

  const darkModeButton = document.getElementById('darkModeButton');
  darkModeButton.addEventListener('click', function () {
      isDarkMode = !isDarkMode;
      document.body.style.backgroundColor = isDarkMode ? '#0f0f0f' : 'white';

      // Sélection des éléments
      const h3 = document.querySelectorAll('h3');
      const paragraphs = document.querySelectorAll('p');
      const li = document.querySelectorAll('li');
      const postContainer = document.querySelectorAll('.post-container');
      const postOption = document.querySelectorAll('.post-options button');  // Les boutons doivent aussi changer
      const postTextarea = document.querySelectorAll('.post-textarea');
      const postSelect = document.querySelectorAll('.iceberg-select select');
      const content = document.querySelectorAll('.white-content');
      const contentSec = document.querySelectorAll('.white-content-secondary');

      // Application des styles
      paragraphs.forEach(paragraph => {
          paragraph.style.color = isDarkMode ? 'white' : 'black';
      });

      h3.forEach(header => {
          header.style.color = isDarkMode ? 'white' : 'black';
      });

      li.forEach(listItem => {
          listItem.style.color = isDarkMode ? 'white' : 'black';
      });

      postContainer.forEach(container => {
          container.style.backgroundColor = isDarkMode ? '#212020' : 'white';
      });

      postOption.forEach(option => {
          option.style.color = isDarkMode ? 'white' : 'black';
      });

      postTextarea.forEach(textarea => {
          textarea.style.color = isDarkMode ? 'white' : 'black';
          textarea.style.backgroundColor = isDarkMode ? '#333' : 'white';  // Ajoute la couleur de fond des textareas
      });

      postSelect.forEach(select => {
          select.style.color = isDarkMode ? 'white' : 'black';
          select.style.backgroundColor = isDarkMode ? '#333' : 'white';  // Ajoute la couleur de fond des selects
      });

      content.forEach(element => {
          element.style.backgroundColor = isDarkMode ? '#212020' : 'white';
      });

      contentSec.forEach(element => {
          element.style.backgroundColor = isDarkMode ? '#212020' : 'white';
      });

      darkModeButton.textContent = isDarkMode ? 'Jour' : 'Nuit';
  });
});
