document.addEventListener('DOMContentLoaded', function() {
    const searchBar = document.getElementById('searchBar');
    const searchInput = searchBar.querySelector('input[type="text"]');
    const suggestions = searchBar.querySelector('.suggestions');
  
    searchInput.addEventListener('click', function() {
      suggestions.style.display = 'block';
    });
  
    document.addEventListener('click', function(event) {
      if (!searchBar.contains(event.target)) {
        suggestions.style.display = 'none';
      }
    });
  
    suggestions.querySelectorAll('p').forEach(function(item) {
      item.addEventListener('click', function() {
        console.log('Recherche de ' + item.textContent.trim());
      });
    });
  });
  