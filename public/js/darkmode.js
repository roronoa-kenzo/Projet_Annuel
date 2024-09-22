document.addEventListener('DOMContentLoaded', function () {
    let isDarkMode = false;
  
    const darkModeButton = document.getElementById('darkModeButton');
    darkModeButton.addEventListener('click', function () {
        isDarkMode = !isDarkMode;
        document.body.style.backgroundColor = isDarkMode ? '#0f0f0f' : 'white';
  
        /* Sélection des éléments*/
        const h3 = document.querySelectorAll('h3');
        const paragraphs = document.querySelectorAll('p');
        const li = document.querySelectorAll('li');
        const postContainer = document.querySelectorAll('.post-container');
        const postContainerAdmin = document.querySelectorAll('.post-container-admin');
        const postOption = document.querySelectorAll('.post-options button');
        const postTextarea = document.querySelectorAll('textarea');
        const postSelect = document.querySelectorAll('.iceberg-select select');
        const content = document.querySelectorAll('.white-content');
        const contentAdmin = document.querySelectorAll('.white-content-admin');
        const contentSec = document.querySelectorAll('.white-content-secondary');
        const a = document.querySelectorAll('a');
  
        /* Application des styles*/
        paragraphs.forEach(paragraph => {
            paragraph.style.color = isDarkMode ? 'white' : 'black';
        });
  
        h3.forEach(header => {
            header.style.color = isDarkMode ? 'white' : 'black';
        });
  
        a.forEach(link => {
            link.style.color = isDarkMode ? 'white' : 'black';
        });
  
        li.forEach(listItem => {
            listItem.style.color = isDarkMode ? 'white' : 'black';
        });
  
        postContainer.forEach(container => {
            container.style.backgroundColor = isDarkMode ? '#212020' : 'white';
        });
  
        postContainerAdmin.forEach(containerAdmin => {
            containerAdmin.style.backgroundColor = isDarkMode ? '#212020' : 'white';
        });
  
        postOption.forEach(option => {
            option.style.color = isDarkMode ? 'white' : 'black';
        });
  
        postTextarea.forEach(textarea => {
            textarea.style.color = isDarkMode ? 'white' : 'black';
            textarea.style.backgroundColor = isDarkMode ? '#333' : '#e8e8e8';
        });
  
        postSelect.forEach(select => {
            select.style.color = isDarkMode ? 'white' : 'black';
            select.style.backgroundColor = isDarkMode ? '#333' : '#e8e8e8;';
        });
  
        content.forEach(element => {
            element.style.backgroundColor = isDarkMode ? '#212020' : 'white';
            element.style.boxShadow = isDarkMode ? 'inset #0e0e0e 1px 1px 8px 3px' : 'inset gray 1px 1px 8px 3px;'; 
        });
  
        contentAdmin.forEach(element => {
            element.style.backgroundColor = isDarkMode ? '#212020' : 'white';
        });
  
        contentSec.forEach(element => {
            element.style.backgroundColor = isDarkMode ? '#212020' : 'white';
            element.style.boxShadow = isDarkMode ? 'inset #0e0e0e 1px 1px 8px 3px' : 'inset gray 1px 1px 8px 3px';  
        });
  
        darkModeButton.textContent = isDarkMode ? 'Jour' : 'Nuit';
    });
  });
  