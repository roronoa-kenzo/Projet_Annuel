document.getElementById("textButton").addEventListener("click", function() {
    document.getElementById("textContent").style.display = "block";
    document.getElementById("imageVideoContent").style.display = "none";
    document.getElementById("linkContent").style.display = "none";
  });

  document.getElementById("imageVideoButton").addEventListener("click", function() {
    document.getElementById("textContent").style.display = "none";
    document.getElementById("imageVideoContent").style.display = "block";
    document.getElementById("linkContent").style.display = "none";
  });

  document.getElementById("linkButton").addEventListener("click", function() {
    document.getElementById("textContent").style.display = "none";
    document.getElementById("imageVideoContent").style.display = "none";
    document.getElementById("linkContent").style.display = "block";
  });

  document.querySelectorAll('.like-button').forEach(button => {
    button.addEventListener('click', function () {
        if (this.classList.contains('liked')) {
            this.classList.remove('liked');
            this.classList.add('unliked');
        } else {
            this.classList.remove('unliked');
            this.classList.add('liked');
        }
    });
});
