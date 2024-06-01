// Modifica el script JavaScript en panel_admin.php

<<<<<<< HEAD

function cargarContenido(url) {

  var xhr = new XMLHttpRequest();

  xhr.open('GET', url, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.getElementById('panel').innerHTML = xhr.responseText;
    }
  };
  xhr.send();
}

function toggleSubMenu() {
  var submenu = document.getElementById('submenu');
  submenu.classList.toggle('open');
}





=======
  
  function cargarContenido(url) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        document.getElementById('panel').innerHTML = xhr.responseText;
      }
    };
    xhr.send();
  }
  
  function toggleSubMenu() {
    var submenu = document.getElementById('submenu');
    submenu.classList.toggle('open');
  }
  
>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0
