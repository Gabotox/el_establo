let txtUsuario = document.getElementById('usuario');
txtUsuario.addEventListener("blur", function () {
    existeUsuario(txtUsuario.value);
}, false);

let txtEmail = document.getElementById('correo');
txtEmail.addEventListener("blur", function () {
    existeEmail(txtEmail.value);
}, false);
function existeUsuario(usuario) {
    let url = 'ValidacionForm.php';
    let formData = new FormData(); 
    formData.append("action", "existeUsuario");
    formData.append("usuario", usuario);

    fetch(url, {
        method: 'POST',
        body: formData
    }).then(Response => Response.json())
      .then(data => {
        if (data.ok) {
            document.getElementById('usuario').value = '';
            document.getElementById('validausuario').innerHTML = 'Usuario no disponible';
        } else {
            document.getElementById('validausuario').innerHTML = '';
        }
    });
}

function existeEmail(email) {
    let url = 'ValidacionForm.php';
    let formData = new FormData(); // Aquí corregido
    formData.append("action", "existeEmail");
    formData.append("email", email);

    fetch(url, {
        method: 'POST',
        body: formData
    }).then(Response => Response.json())
      .then(data => {
        if (data.ok) {
            document.getElementById('correo').value = '';
            document.getElementById('validaCorreo').innerHTML = 'Email no disponible';
        } else {
            document.getElementById('validaCorreo').innerHTML = '';
        }
    });
}
