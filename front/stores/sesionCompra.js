import { defineStore } from 'pinia';

export const useSesionCompraStore = defineStore('sesionCompra', () => {
    const id_sesion_actual = ref(0);
    const butacasSeleccionadas = ref([]);
    const preciosButacas = ref([]);
    const precioTotal = ref(0);
    
    return { 
        id_sesion_actual,
        butacasSeleccionadas,
        preciosButacas,
        precioTotal
    };
});