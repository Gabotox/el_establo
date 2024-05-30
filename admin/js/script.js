// Modifica el script JavaScript en panel_admin.php

  
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
  