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