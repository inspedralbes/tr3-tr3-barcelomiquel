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
                                :class="{ 'asiento-vip': sesion?.VIP && seient.id.split('-')[0] === '6' }"
                                @toggle="toggleSeient(seient.id)" @click="setFilaActual(seient.id)">
                            </Seient>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ticket">
                <div v-if="mostrarPanel" class="panel-seleccion">
                    <h3>Butacas seleccionadas:</h3>
                    <div class="butacas-seleccionadas">
                        <div v-for="butaca in butacasSeleccionadas" :key="butaca" class="butaca-seleccionada">{{ butaca
                            }}</div>
                    </div>
                    <h3>Preu total: {{ precioTotal }}€</h3>
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
import io from 'socket.io-client';


export default {
    components: {
        Seient
    },
    data() {
        return {
            files: [
                [{ id: '1-1', seleccionat: false, ocupada: false, }, { id: '1-2', seleccionat: false, ocupada: false }, { id: '1-3', seleccionat: false, ocupada: false }, { id: '1-4', seleccionat: false, ocupada: false }, { id: '1-5', seleccionat: false, ocupada: false }, { id: '1-6', seleccionat: false, ocupada: false }, { id: '1-7', seleccionat: false, ocupada: false }, { id: '1-8', seleccionat: false, ocupada: false }, { id: '1-9', seleccionat: false, ocupada: false }, { id: '1-10', seleccionat: false, ocupada: false }, { id: '1-11', seleccionat: false, ocupada: false }, { id: '1-12', seleccionat: false, ocupada: false }],
                [{ id: '2-1', seleccionat: false, ocupada: false, }, { id: '2-2', seleccionat: false, ocupada: false }, { id: '2-3', seleccionat: false, ocupada: false }, { id: '2-4', seleccionat: false, ocupada: false }, { id: '2-5', seleccionat: false, ocupada: false }, { id: '2-6', seleccionat: false, ocupada: false }, { id: '2-7', seleccionat: false, ocupada: false }, { id: '2-8', seleccionat: false, ocupada: false }, { id: '2-9', seleccionat: false, ocupada: false }, { id: '2-10', seleccionat: false, ocupada: false }, { id: '2-11', seleccionat: false, ocupada: false }, { id: '2-12', seleccionat: false, ocupada: false }],
                [{ id: '3-1', seleccionat: false, ocupada: false }, { id: '3-2', seleccionat: false, ocupada: false }, { id: '3-3', seleccionat: false, ocupada: false }, { id: '3-4', seleccionat: false, ocupada: false }, { id: '3-5', seleccionat: false, ocupada: false }, { id: '3-6', seleccionat: false, ocupada: false }, { id: '3-7', seleccionat: false, ocupada: false }, { id: '3-8', seleccionat: false, ocupada: false }, { id: '3-9', seleccionat: false, ocupada: false }, { id: '3-10', seleccionat: false, ocupada: false }, { id: '3-11', seleccionat: false, ocupada: false }, { id: '3-12', seleccionat: false, ocupada: false }],
                [{ id: '4-1', seleccionat: false, ocupada: false }, { id: '4-2', seleccionat: false, ocupada: false }, { id: '4-3', seleccionat: false, ocupada: false }, { id: '4-4', seleccionat: false, ocupada: false }, { id: '4-5', seleccionat: false, ocupada: false }, { id: '4-6', seleccionat: false, ocupada: false }, { id: '4-7', seleccionat: false, ocupada: false }, { id: '4-8', seleccionat: false, ocupada: false }, { id: '4-9', seleccionat: false, ocupada: false }, { id: '4-10', seleccionat: false, ocupada: false }, { id: '4-11', seleccionat: false, ocupada: false }, { id: '4-12', seleccionat: false, ocupada: false }],
                [{ id: '5-1', seleccionat: false, ocupada: false }, { id: '5-2', seleccionat: false, ocupada: false }, { id: '5-3', seleccionat: false, ocupada: false }, { id: '5-4', seleccionat: false, ocupada: false }, { id: '5-5', seleccionat: false, ocupada: false }, { id: '5-6', seleccionat: false, ocupada: false }, { id: '5-7', seleccionat: false, ocupada: false }, { id: '5-8', seleccionat: false, ocupada: false }, { id: '5-9', seleccionat: false, ocupada: false }, { id: '5-10', seleccionat: false, ocupada: false }, { id: '5-11', seleccionat: false, ocupada: false }, { id: '5-12', seleccionat: false, ocupada: false }],
                [{ id: '6-1', seleccionat: false, ocupada: false, vip: false }, { id: '6-2', seleccionat: false, ocupada: false, vip: false }, { id: '6-3', seleccionat: false, ocupada: false, vip: false }, { id: '6-4', seleccionat: false, ocupada: false, vip: false }, { id: '6-5', seleccionat: false, ocupada: false, vip: false }, { id: '6-6', seleccionat: false, ocupada: false, vip: false }, { id: '6-7', seleccionat: false, ocupada: false, vip: false }, { id: '6-8', seleccionat: false, ocupada: false, vip: false }, { id: '6-9', seleccionat: false, ocupada: false, vip: false }, { id: '6-10', seleccionat: false, ocupada: false, vip: false }, { id: '6-11', seleccionat: false, ocupada: false, vip: false }, { id: '6-12', seleccionat: false, ocupada: false, vip: false }],
                [{ id: '7-1', seleccionat: false, ocupada: false }, { id: '7-2', seleccionat: false, ocupada: false }, { id: '7-3', seleccionat: false, ocupada: false }, { id: '7-4', seleccionat: false, ocupada: false }, { id: '7-5', seleccionat: false, ocupada: false }, { id: '7-6', seleccionat: false, ocupada: false }, { id: '7-7', seleccionat: false, ocupada: false }, { id: '7-8', seleccionat: false, ocupada: false }, { id: '7-9', seleccionat: false, ocupada: false }, { id: '7-10', seleccionat: false, ocupada: false }, { id: '7-11', seleccionat: false, ocupada: false }, { id: '7-12', seleccionat: false, ocupada: false }],
                [{ id: '8-1', seleccionat: false, ocupada: false }, { id: '8-2', seleccionat: false, ocupada: false }, { id: '8-3', seleccionat: false, ocupada: false }, { id: '8-4', seleccionat: false, ocupada: false }, { id: '8-5', seleccionat: false, ocupada: false }, { id: '8-6', seleccionat: false, ocupada: false }, { id: '8-7', seleccionat: false, ocupada: false }, { id: '8-8', seleccionat: false, ocupada: false }, { id: '8-9', seleccionat: false, ocupada: false }, { id: '8-10', seleccionat: false, ocupada: false }, { id: '8-11', seleccionat: false, ocupada: false }, { id: '8-12', seleccionat: false, ocupada: false }],
                [{ id: '9-1', seleccionat: false, ocupada: false }, { id: '9-2', seleccionat: false, ocupada: false }, { id: '9-3', seleccionat: false, ocupada: false }, { id: '9-4', seleccionat: false, ocupada: false }, { id: '9-5', seleccionat: false, ocupada: false }, { id: '9-6', seleccionat: false, ocupada: false }, { id: '9-7', seleccionat: false, ocupada: false }, { id: '9-8', seleccionat: false, ocupada: false }, { id: '9-9', seleccionat: false, ocupada: false }, { id: '9-10', seleccionat: false, ocupada: false }, { id: '9-11', seleccionat: false, ocupada: false }, { id: '9-12', seleccionat: false, ocupada: false }],
                [{ id: '10-1', seleccionat: false, ocupada: false }, { id: '10-2', seleccionat: false, ocupada: false }, { id: '10-3', seleccionat: false, ocupada: false }, { id: '10-4', seleccionat: false, ocupada: false }, { id: '10-5', seleccionat: false, ocupada: false }, { id: '10-6', seleccionat: false, ocupada: false }, { id: '10-7', seleccionat: false, ocupada: false }, { id: '10-8', seleccionat: false, ocupada: false }, { id: '10-9', seleccionat: false, ocupada: false }, { id: '10-10', seleccionat: false, ocupada: false }, { id: '10-11', seleccionat: false, ocupada: false }, { id: '10-12', seleccionat: false, ocupada: false }],
            ],
            butacasSeleccionadas: [],
            butacasOcupadas: [],
            sesion: null,
            precioPorButaca: 0,
            filaActual: '',
            socket: null,
        };
    },
    methods: {
        fetchPelicula() {
            const sesionCompraStore = useSesionCompraStore();
            const sesionId = sesionCompraStore.sesionID;

            fetch(`http://galaxiafilms.daw.inspedralbes.cat/back/public/api/sesiones/${sesionId}`)
                .then(response => response.json())
                .then(data => {
                    this.sesion = data;

                    // Asigna el precio por butaca según si la sesión es VIP o no
                    this.files.forEach((fila, index) => {
                        fila.forEach(seient => {
                            if (this.sesion.VIP && index === 5) {
                                // Si es la fila 6 y la sesión es VIP, asigna el precio VIP
                                seient.precio = this.sesion.preu_entradaVip;
                                seient.vip = true; // Establece vip como true para los asientos de la fila 6
                            } else {
                                // Para las demás filas o si la sesión no es VIP, asigna el precio estándar
                                seient.precio = this.sesion.preu_entrada;
                                seient.vip = false; // Asegúrate de establecer vip como false para las demás filas
                            }
                        });
                    });
                })
                .catch(error => console.error('Error al obtener la película:', error));
        },
        fetchButacasOcupadas() {
            const sesionCompraStore = useSesionCompraStore();
            const sesionId = sesionCompraStore.sesionID; // Accede al ID almacenado en el store de PINIA
            
            fetch(`http://galaxiafilms.daw.inspedralbes.cat/back/public/api/sesiones-entradas/${sesionId}`)
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
                            seient.vip = false;
                            seient.ocupada = true;
                            break; // No necesitas seguir buscando en las filas
                        }
                    }
                }
            });
        },
        setFilaActual(fila) {
            this.filaActual = fila; // Actualiza filaActual con la fila seleccionada
        },
        calcularPrecioTotal() {
            // Calcula el precio total multiplicando el precio por butaca por el número de butacas seleccionadas
            return this.precioPorButaca * this.butacasSeleccionadas.length;
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
                seient.vip = false;

                // Actualiza el array de butacas seleccionadas
                if (isSelected) {
                    this.butacasSeleccionadas.push(seientId);
                    this.butacasSeleccionadas.sort();
                    // Almacena el precio del asiento en el estado de Pinia
                    this.store.agregarButacaSeleccionada(seientId, seient.precio);
                    this.socket.emit('butacaSeleccionada', seientId);
                    this.$emit('toggle', this.id);
                } else {
                    const index = this.butacasSeleccionadas.indexOf(seientId);
                    if (index > -1) {
                        this.butacasSeleccionadas.splice(index, 1);
                        if (this.sesion.VIP && seient.id.split('-')[0] === '6') {
                            seient.vip = true;
                        }
                    }
                    // Elimina el asiento del estado de Pinia
                    this.store.eliminarButacaSeleccionada(seientId);
                    this.socket.emit('butacaSeleccionada', seientId);
                }

                // Almacena la fila actual cuando se selecciona un asiento
                this.setFilaActual(seientId.split('-')[0]);
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
                if (this.sesion.VIP && seient.id.split('-')[0] === '6') {
                    seient.vip = true;
                }
            });
            this.butacasSeleccionadas = [];
            this.store.butacasSeleccionadas = [];
            this.store.precioTotal = 0;
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
        connectToSocketIO() {
            this.socket = io(); // Conecta al servidor Socket.IO

            // Maneja eventos de Socket.IO
            this.socket.on('butacasSeleccionadas', butacas => {
                this.butacasSeleccionadas = butacas;
            });

            this.socket.on('butacaSeleccionada', butacaId => {
                this.butacasSeleccionadas.push(butacaId);
            });

            this.socket.on('butacaDeseleccionada', butacaId => {
                this.butacasSeleccionadas = this.butacasSeleccionadas.filter(id => id !== butacaId);
            });
        },
    },
    computed: {
        mostrarPanel() {
            return this.butacasSeleccionadas.length > 0;
        },
        precioTotal() {
            // Suma el precio de cada butaca seleccionada
            return this.butacasSeleccionadas.reduce((total, seientId) => {
                // Encuentra el asiento por su ID
                const seient = this.findSeientById(seientId);
                // Suma el precio del asiento actual al total
                return total + seient.precio;
            }, 0);
        },
        store() {
            return useSesionCompraStore();
        },
    },
    mounted() {
        this.fetchButacasOcupadas();
        this.fetchPelicula();

        // Conecta al servidor Socket.IO cuando se monta el componente
        this.connectToSocketIO();
    },
    beforeUnmount() {
        // Desconecta del servidor cuando el componente se desmonta
        this.socket.disconnect();
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

h3 {
    font-size: 1.5rem;
}

p {
    font-size: 1.2rem;

}

.butacas-seleccionadas {
    display: flex;
    flex-wrap: wrap;
}

.butaca-seleccionada {
    background-color: #444;
    color: #fff;
    padding: 5px 10px;
    margin: 5px;
    border-radius: 5px;
    font-weight: bold;
    font-family: 'Your Epic Font', sans-serif;
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
    background-color: #0ff807;
    color: rgb(0, 0, 0);
    font-weight: bold;
    padding: 10px 20px;
    margin: 10px 10px 0 0;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 1rem;
}

button:hover {
    background-color: #159105;
}

.borrar {
    background-color: #f30909;
    color: rgb(0, 0, 0);
    padding: 10px 20px;
    margin: 10px 10px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-weight: bold;
    font-size: 1rem;
}

.borrar:hover {
    background-color: #960505;
}

.tornar {
    background-color: #e0f807;
    color: black;
    padding: 10px 20px;
    margin: 10px 10px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-weight: bold;
    font-size: 1rem;
}

.tornar:hover {
    background-color: #879105;
}

.ticket {
    width: 25%;
    /* ajusta el ancho según tu preferencia */
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    margin-left: 50px;
    /* coloca los elementos en la parte superior */
}

/* Los estilos de Seient.vue se aplicarán aquí debido al scope */
</style>
