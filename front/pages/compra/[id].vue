<template>

    <body>
        <Header />
        <div class="cine">
            <h1>Selecciona el teu seient de la sessio {{ $route.params.id }}</h1>
            <div class="detalles-pelicula" v-if="sessionData">
                <img :src="sessionData.pelicula.poster" alt="Póster de la película" class="poster-pelicula">
                <div class="info-pelicula">
                    <h2>{{ sessionData.pelicula.titul }}</h2>
                    <p>Género: {{ sessionData.pelicula.genere }}</p>
                    <p>Fecha: {{ sessionData.pelicula.fecha }}</p>
                    <p>Hora: {{ sessionData.pelicula.hora }}</p>
                    <p>Descripción: {{ sessionData.pelicula.descripcio }}</p>
                </div>
            </div>
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
            <div v-if="mostrarPanel" class="panel-seleccion">
                <h3>Butacas seleccionadas:</h3>
                <p>{{ butacasSeleccionadas.join(', ') }}</p>
                <p>Precio total: {{ precioTotal }}€</p> <!-- Muestra el precio total aquí -->
                <button @click="comprar">Comprar</button>
                <button class="borrar" @click="borrarSeleccion">Borrar selección</button>
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
                [{ id: '1-1', seleccionat: false, ocupada: true }, { id: '1-2', seleccionat: false, ocupada: true }, { id: '1-3', seleccionat: false, ocupada: false }, { id: '1-4', seleccionat: false, ocupada: false }, { id: '1-5', seleccionat: false, ocupada: false }, { id: '1-6', seleccionat: false, ocupada: false }, { id: '1-7', seleccionat: false, ocupada: false }, { id: '1-8', seleccionat: false, ocupada: false }, { id: '1-9', seleccionat: false, ocupada: false }, { id: '1-10', seleccionat: false, ocupada: false }, { id: '1-11', seleccionat: false, ocupada: false }, { id: '1-12', seleccionat: false, ocupada: false }],
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
            butacasOcupadas: ['1-1', '1-2'],
            sessionData: null,
        };
    },
    methods: {
        fetchSessionData() {
            const store = useSesionCompraStore(); // Utiliza la tienda Pinia
            const sessionId = store.id_sesion_actual; // Obtiene el ID de sesión actual de la tienda
            console.log('sessionId:', sessionId); // Agregar esta línea para depurar
            
            // Ahora utiliza este sessionId para hacer el fetch
            fetch(`http://localhost:8000/api/sesiones/${sessionId}`)
                .then(response => response.json())
                .then(data => {
                    this.sessionData = data; // Almacena los datos de la sesión en sessionData
                })
                .catch(error => console.error('Error al obtener datos de la sesión:', error));
        },
        fetchButacasOcupadas() {
            fetch(`http://localhost:8000/api/entradas/${this.$route.params.id}`)
                .then(response => response.json())
                .then(data => {
                    this.actualizarButacasOcupadas(data.butacasOcupadas);
                })
                .catch(error => console.error('Error al obtener butacas ocupadas:', error));
        },
        actualizarButacasOcupadas(butacasOcupadas) {
            this.files.forEach(fila => {
                fila.forEach(asiento => {
                    if (butacasOcupadas.includes(asiento.id)) {
                        asiento.ocupada = true;
                    }
                });
            });
        },
        toggleSeient(seientId) {
            if (this.butacasSeleccionadas.length < 10 || this.findSeientById(seientId).seleccionat) {
                console.log(seientId);
                const seient = this.findSeientById(seientId);
                seient.seleccionat = !seient.seleccionat;
                if (seient.seleccionat) {
                    this.butacasSeleccionadas.push(seientId);
                } else {
                    const index = this.butacasSeleccionadas.indexOf(seientId);
                    if (index > -1) {
                        this.butacasSeleccionadas.splice(index, 1);
                    }
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
                path: '/confirmarCompra', // La ruta es derivada del nombre del archivo en la carpeta pages
                query: {
                    butacas: JSON.stringify(this.butacasSeleccionadas),
                    nombrePelicula: 'El nombre de tu película', // Ajusta según sea necesario
                    precioTotal: this.precioTotal
                }
            });
        }

    },
    computed: {
        mostrarPanel() {
            return this.butacasSeleccionadas.length > 0;
        },
        precioTotal() {
            return this.butacasSeleccionadas.length * 6; // 6€ por butaca
        }
    },
    created() {
        this.fetchSessionData(); // Llamada al método para obtener los datos de la sesión al crear el componente
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
    /* Fondo oscuro para simular el interior de una sala de cine */
    color: #ffffff;
    height: 100%;
    font-family: 'Your Epic Font', sans-serif;
}

.pantalla {
    width: 40%;
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
    margin: 10px 0;
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
    margin: 10px 0;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.borrar:hover {
    background-color: #a04545;
}

.detalles-pelicula {
    display: flex;
    align-items: center;
    padding: 20px;
}

.poster-pelicula {
    width: 150px;
    /* Ajusta según necesidad */
    margin-right: 20px;
}

.info-pelicula h2 {
    margin: 0;
    padding: 0;
}

.info-pelicula p {
    margin: 5px 0;
}

/* Los estilos de Seient.vue se aplicarán aquí debido al scope */
</style>
