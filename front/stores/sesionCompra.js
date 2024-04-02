import { defineStore } from 'pinia';

export const useSesionCompraStore = defineStore('sesionCompra', () => {
    const sesionID = ref(0);
    const butacasSeleccionadas = ref([]);
    const precioTotal = ref(0);
    const loguejat = ref(false);
    const tipus_usuari = ref("");
    const nom_usuari = ref("");
    const email_usuari = ref("");

    function agregarButacaSeleccionada(idAsiento, precio) {
        butacasSeleccionadas.value.push({ id: idAsiento, precio: precio });
        actualizarPrecioTotal();
    }

    function eliminarButacaSeleccionada(idAsiento) {
        const index = butacasSeleccionadas.value.findIndex(asiento => asiento.id === idAsiento);
        if (index !== -1) {
            butacasSeleccionadas.value.splice(index, 1);
            actualizarPrecioTotal();
        }
    }

    function actualizarPrecioTotal() {
        precioTotal.value = butacasSeleccionadas.value.reduce((total, asiento) => total + asiento.precio, 0);
    }

    function setSesionID(id) {
        sesionID.value = id;
    }

    function iniciarSesionExitoso() {
        loguejat.value = true;
    }



    return { 
        sesionID,
        setSesionID,
        butacasSeleccionadas,
        precioTotal,
        agregarButacaSeleccionada,
        eliminarButacaSeleccionada,
        iniciarSesionExitoso,
        loguejat,
        tipus_usuari,
        nom_usuari,
        email_usuari,
    };
});
