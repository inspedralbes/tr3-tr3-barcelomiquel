<template>

    <body>
        <Header />
        <div class="cine">
            <div class="detalles-pelicula" v-if="sesion">
                <div class="poster-pelicula">
                    <img :src="sesion.pelicula.poster" alt="Poster de la película" />
                </div>
                <div class="info-pelicula">
                    <h2>{{ sesion.pelicula.titol }}</h2>
                    <p>{{ sesion.pelicula.genere }}</p>
                    <p>{{ sesion.hora }}</p>
                    <p>{{ sesion.pelicula.duracio }}</p>
                    <p>{{ sesion.fecha }}</p>
                    <p>{{ sesion.pelicula.descripcio }}</p>
                </div>
            </div>
            <div class="contenedor-principal">
                <h1>Selecciona el teu seient de la sessio {{ $route.params.id }}</h1>
                <div class="pantalla">
                    <h2>Pantalla</h2>
                </div>
                <div class="plano-sala">
                    <div v-for="(fila, index) in files" :key="index" class="fila">
                        <div class="fila-indicador">{{ fila[0].id.split('-')[0] }}</div>
                        <div class="asientos">
                            <Seient v-for="seient in fila" :key="seient.id" :seient="seient"
                                @toggle="toggleSeient(seient.id)">
                            </Seient>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ticket">
                <div v-if="mostrarPanel" class="panel-seleccion">
                    <h3>Butacas seleccionadas:</h3>
                    <p>{{ butacasSeleccionadas.join(', ') }}</p>
                    <p>Precio total: {{ precioTotal }}€</p>
                    <button @click="comprar">Comprar</button>
                    <button class="borrar" @click="borrarSeleccion">Borrar selecció</button>
                    <button class="tornar" @click="tornar">Inici</button>
                </div>
            </div>
        </div>
    </body>
</template>

<script>
import { useSesionCompraStore } from '../stores/sesionCompra.js';
import Seient from '../components/Seient.vue';

export default {
    components: {
        Seient
    },
    data() {
        return {
            files: [
                [{ id: '1-1', seleccionat: false, ocupada: false }, { id: '1-2', seleccionat: false, ocupada: false }, { id: '1-3', seleccionat: false, ocupada: false }, { id: '1-4', seleccionat: false, ocupada: false }, { id: '1-5', seleccionat: false, ocupada: false }, { id: '1-6', seleccionat: false, ocupada: false }, { id: '1-7', seleccionat: false, ocupada: false }, { id: '1-8', seleccionat: false, ocupada: false }, { id: '1-9', seleccionat: false, ocupada: false }, { id: '1-10', seleccionat: false, ocupada: false }, { id: '1-11', seleccionat: false, ocupada: false }, { id: '1-12', seleccionat: false, ocupada: false }],
                [{ id: '2-1', seleccionat: false, ocupada: false }, { id: '2-2', seleccionat: false, ocupada: false }, { id: '2-3', seleccionat: false, ocupada: false }, { id: '2-4', seleccionat: false, ocupada: false }, { id: '2-5', seleccionat: false, ocupada: false }, { id: '2-6', seleccionat: false, ocupada: false }, { id: '2-7', seleccionat: false, ocupada: false }, { id: '2-8', seleccionat: false, ocupada: false }, { id: '2-9', seleccionat: false, ocupada: false }, { id: '2-10', seleccionat: false, ocupada: false }, { id: '2-11', seleccionat: false, ocupada: false }, { id: '2-12', seleccionat: false, ocupada: false }],
                [{ id: '3-1', seleccionat: false, ocupada: false }, { id: '3-2', seleccionat: false, ocupada: false }, { id: '3-3', seleccionat: false, ocupada: false }, { id: '3-4', seleccionat: false, ocupada: false }, { id: '3-5', seleccionat: false, ocupada: false }, { id: '3-6', seleccionat: false, ocupada: false }, { id: '3-7', seleccionat: false, ocupada: false }, { id: '3-8', seleccionat: false, ocupada: false }, { id: '3-9', seleccionat: false, ocupada: false }, { id: '3-10', seleccionat: false, ocupada: false }, { id: '3-11', seleccionat: false, ocupada: false }, { id: '3-12', seleccionat: false, ocupada: false }],
                [{ id: '4-1', seleccionat: false, ocupada: false }, { id: '4-2', seleccionat: false, ocupada: false }, { id: '4-3', seleccionat: false, ocupada: false }, { id: '4-4', seleccionat: false, ocupada: false }, { id: '4-5', seleccionat: false, ocupada: false }, { id: '4-6', seleccionat: false, ocupada: false }, { id: '4-7', seleccionat: false, ocupada: false }, { id: '4-8', seleccionat: false, ocupada: false }, { id: '4-9', seleccionat: false, ocupada: false }, { id: '4-10', seleccionat: false, ocupada: false }, { id: '4-11', seleccionat: false, ocupada: false }, { id: '4-12', seleccionat: false, ocupada: false }],
                [{ id: '5-1', seleccionat: false, ocupada: false }, { id: '5-2', seleccionat: false, ocupada: false }, { id: '5-3', seleccionat: false, ocupada: false }, { id: '5-4', seleccionat: false, ocupada: false }, { id: '5-5', seleccionat: false, ocupada: false }, { id: '5-6', seleccionat: false, ocupada: false }, { id: '5-7', seleccionat: false, ocupada: false }, { id: '5-8', seleccionat: false, ocupada: false }, { id: '5-9', seleccionat: false, ocupada: false }, { id: '5-10', seleccionat: false, ocupada: false }, { id: '5-11', seleccionat: false, ocupada: false }, { id: '5-12', seleccionat: false, ocupada: false }],
                [{ id: '6-1', seleccionat: false, ocupada: false }, { id: '6-2', seleccionat: false, ocupada: false }, { id: '6-3', seleccionat: false, ocupada: false }, { id: '6-4', seleccionat: false, ocupada: false }, { id: '6-5', seleccionat: false, ocupada: false }, { id: '6-6', seleccionat: false, ocupada: false }, { id: '6-7', seleccionat: false, ocupada: false }, { id: '6-8', seleccionat: false, ocupada: false }, { id: '6-9', seleccionat: false, ocupada: false }, { id: '6-10', seleccionat: false, ocupada: false }, { id: '6-11', seleccionat: false, ocupada: false }, { id: '6-12', seleccionat: false, ocupada: false }],
                [{ id: '7-1', seleccionat: false, ocupada: false }, { id: '7-2', seleccionat: false, ocupada: false }, { id: '7-3', seleccionat: false, ocupada: false }, { id: '7-4', seleccionat: false, ocupada: false }, { id: '7-5', seleccionat: false, ocupada: false }, { id: '7-6', seleccionat: false, ocupada: false }, { id: '7-7', seleccionat: false, ocupada: false }, { id: '7-8', seleccionat: false, ocupada: false }, { id: '7-9', seleccionat: false, ocupada: false }, { id: '7-10', seleccionat: false, ocupada: false }, { id: '7-11', seleccionat: false, ocupada: false }, { id: '7-12', seleccionat: false, ocupada: false }],
                [{ id: '8-1', seleccionat: false, ocupada: false }, { id: '8-2', seleccionat: false, ocupada: false }, { id: '8-3', seleccionat: false, ocupada: false }, { id: '8-4', seleccionat: false, ocupada: false }, { id: '8-5', seleccionat: false, ocupada: false }, { id: '8-6', seleccionat: false, ocupada: false }, { id: '8-7', seleccionat: false, ocupada: false }, { id: '8-8', seleccionat: false, ocupada: false }, { id: '8-9', seleccionat: false, ocupada: false }, { id: '8-10', seleccionat: false, ocupada: false }, { id: '8-11', seleccionat: false, ocupada: false }, { id: '8-12', seleccionat: false, ocupada: false }],
                [{ id: '9-1', seleccionat: false, ocupada: false }, { id: '9-2', seleccionat: false, ocupada: false }, { id: '9-3', seleccionat: false, ocupada: false }, { id: '9-4', seleccionat: false, ocupada: false }, { id: '9-5', seleccionat: false, ocupada: false }, { id: '9-6', seleccionat: false, ocupada: false }, { id: '9-7', seleccionat: false, ocupada: false }, { id: '9-8', seleccionat: false, ocupada: false }, { id: '9-9', seleccionat: false, ocupada: false }, { id: '9-10', seleccionat: false, ocupada: false }, { id: '9-11', seleccionat: false, ocupada: false }, { id: '9-12', seleccionat: false, ocupada: false }],
                [{ id: '10-1', seleccionat: false, ocupada: false }, { id: '10-2', seleccionat: false, ocupada: false }, { id: '10-3', seleccionat: false, ocupada: false }, { id: '10-4', seleccionat: false, ocupada: false }, { id: '10-5', seleccionat: false, ocupada: false }, { id: '10-6', seleccionat: false, ocupada: false }, { id: '10-7', seleccionat: false, ocupada: false }, { id: '10-8', seleccionat: false, ocupada: false }, { id: '10-9', seleccionat: false, ocupada: false }, { id: '10-10', seleccionat: false, ocupada: false }, { id: '10-11', seleccionat: false, ocupada: false }, { id: '10-12', seleccionat: false, ocupada: false }],
            ],
            butacasSeleccionadas: [],
            butacasOcupadas: [],
            sesion: null,
        };
    },
    methods: {
        fetchPelicula() {
            const sesionCompraStore = useSesionCompraStore();
            const sesionId = sesionCompraStore.sesionID; // Accede al ID almacenado en el store de PINIA

            fetch(`http://localhost:8000/api/sesiones/${sesionId}`)
                .then(response => response.json())
                .then(data => {
                    this.sesion = data;
                })
                .catch(error => console.error('Error al obtener la película:', error));
        },
        fetchButacasOcupadas() {
            const sesionCompraStore = useSesionCompraStore();
            const sesionId = sesionCompraStore.sesionID; // Accede al ID almacenado en el store de PINIA
            fetch(`http://localhost:8000/api/sesiones-entradas/${sesionId}`)
                .then(response => response.json())
                .then(data => {
                    this.actualizarButacasOcupadas(data.entradas);
                })
                .catch(error => console.error('Error al obtener butacas ocupadas:', error));
        },
        actualizarButacasOcupadas(entradas) {
            entradas.forEach(entrada => {
                const asiento = entrada.asiento;
                // Encuentra el asiento en el plano de la sala y márcalo como ocupado
                for (let fila of this.files) {
                    for (let seient of fila) {
                        if (seient.id === asiento) {
                            seient.ocupada = true;
                            break; // No necesitas seguir buscando en las filas
                        }
                    }
                }
            });
        },
        toggleSeient(seientId) {
            // Encuentra el asiento seleccionado por su ID
            const seient = this.findSeientById(seientId);

            // Verifica si el asiento está seleccionado o no
            const isSelected = !seient.seleccionat;

            // Verifica si el límite de asientos seleccionados no se ha alcanzado o si el asiento ya está seleccionado
            if (this.butacasSeleccionadas.length < 10 || !isSelected) {
                // Cambia el estado de selección del asiento
                seient.seleccionat = isSelected;

                // Actualiza el array de butacas seleccionadas
                if (isSelected) {
                    this.butacasSeleccionadas.push(seientId);

                    const precio = 6; // Precio fijo de 6€ por asiento
                    this.store.agregarButacaSeleccionada(seientId, precio);
                } else {
                    const index = this.butacasSeleccionadas.indexOf(seientId);
                    if (index > -1) {
                        this.butacasSeleccionadas.splice(index, 1);
                    }
                    this.store.eliminarButacaSeleccionada(seientId);
                }
            } else {
                alert("No puedes seleccionar más de 10 butacas.");
            }
        },
        findSeientById(seientId) {
            for (let fila of this.files) {
                for (let seient of fila) {
                    if (seient.id === seientId) {
                        return seient;
                    }
                }
            }
        },
        borrarSeleccion() {
            this.butacasSeleccionadas.forEach(id => {
                const seient = this.findSeientById(id);
                seient.seleccionat = false;
            });
            this.butacasSeleccionadas = [];
        },
        comprar() {
            this.$router.push({
                path: '/confirmarCompra',
            });
        },
        tornar() {
            this.store.sesionID = 0;
            this.store.butacasSeleccionadas = [];
            this.store.precioTotal = 0;

            this.$router.push({
                path: '/',
            });
        },
    },
    computed: {
        mostrarPanel() {
            return this.butacasSeleccionadas.length > 0;
        },
        precioTotal() {
            return this.butacasSeleccionadas.length * 6; // 6€ por butaca
        },
        store() {
            return useSesionCompraStore();
        },
    },
    created() {
        // Llama a la función para obtener las butacas ocupadas cuando se crea el componente
        this.fetchButacasOcupadas();
        this.fetchPelicula();
    },
};
</script>

<style scoped>
body {
    margin: 0;
    /* Elimina los márgenes predeterminados del body */
    padding: 0;
    /* Elimina el padding predeterminado del body */
    height: 100vh;
    /* Hace que el body ocupe el 100% del alto de la ventana */
}

.cine {
    text-align: center;
    padding: 20px;
    background-color: #1f1f1f;
    color: #ffffff;
    height: 100%;
    font-family: 'Your Epic Font', sans-serif;
    display: flex;
}

.detalles-pelicula {
    display: flex;
    align-items: center;
    /* Alinea verticalmente */
    justify-content: center;
    /* Alinea horizontalmente */
    padding: 20px;
    width: 30%;
}



.poster-pelicula {
    width: 300px;
    /* Ajusta según necesidad */
    margin-left: 10%;
}

.poster-pelicula img {
    width: 100%;
    /* Para asegurar que la imagen del póster llene su contenedor */
}

.info-pelicula {
    flex-grow: 1;
    /* Ocupa todo el espacio restante */
    text-align: left;
    padding: 35px;
}

.info-pelicula h2 {
    margin-top: 0;
    /* Eliminar el margen superior del título */
    margin-bottom: 10px;
    /* Espacio entre el título y los párrafos */
}

.info-pelicula p {
    margin: 0;
    /* Eliminar márgenes en los párrafos */
    margin-bottom: 5px;
    /* Espacio entre párrafos */
}

.contenedor-principal {
    width: 40%;
}

.pantalla {
    width: 96%;
    height: 50px;
    background-color: #ffffff;
    color: #000000;
    margin: 0 auto 20px;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    font-family: 'Your Epic Font', sans-serif;
}

.plano-sala {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 80px;
}

.fila {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}

.fila-indicador {
    width: 30px;
    /* Ancho fijo para todos los indicadores de fila */
    display: flex;
    justify-content: center;
    /* Centra el contenido horizontalmente */
    align-items: center;
    /* Centra el contenido verticalmente */
    margin-right: 10px;
    /* Espacio entre el indicador de la fila y los asientos */
    color: #ffffff;
    /* Color del texto */
    font-weight: bold;
    /* Hace el texto más visible */
}

.asientos {
    display: flex;
    justify-content: center;
}

.panel-seleccion {
    padding: 20px;
    background-color: #333;
    color: #fff;
    margin-top: 20px;
    border-radius: 5px;
    text-align: left;
    font-family: 'Your Epic Font', sans-serif;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    margin: 10px 10px 0 0;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background-color: #45a049;
}

.borrar {
    background-color: #af4c4c;
    color: white;
    padding: 10px 20px;
    margin: 10px 10px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.borrar:hover {
    background-color: #a04545;
}

.tornar {
    background-color: #afa84c;
    color: white;
    padding: 10px 20px;
    margin: 10px 10px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.tornar:hover {
    background-color: #a09a45;
}

.ticket {
    width: 30%;
    /* ajusta el ancho según tu preferencia */
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    /* coloca los elementos en la parte superior */
}

/* Los estilos de Seient.vue se aplicarán aquí debido al scope */
</style>
