

let accionPagar = document.getElementById('pagara');
let modalis = document.querySelector('.modali');
let modalisS = document.querySelector('.submodali');

function abrirYCerrar() {
    modalis.style.display = "flex";
    modalisS.style.display = "flex";

    // Agregar event listener para cerrar cuando se haga clic fuera del modal
    document.addEventListener("click", function(event) {
        if (event.target !== accionPagar && event.target !== modalis && event.target !== modalisS) {
            modalis.style.display = "none";
            modalisS.style.display = "none";
        }
    });
}

accionPagar.addEventListener("click", abrirYCerrar);
