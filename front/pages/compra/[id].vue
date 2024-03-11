<template>
    <body>
        <Header />
        <div class="cine">
            <h1>Selecciona el teu seient de la sessio {{ $route.params.id }}</h1>
            <div class="pantalla">
                <h2>Pantalla</h2>
            </div>
            <div class="plano-sala">
                <div v-for="(fila, index) in files" :key="index" class="fila">
                    <!-- Añadido el número/letra de la fila -->
                    <div class="fila-indicador">{{ fila[0].id[0] }}</div>
                    <div class="asientos">
                        <Seient v-for="seient in fila" :key="seient.id" :seient="seient" @toggle="toggleSeient(seient.id)">
                        </Seient>
                    </div>
                </div>
            </div>
            <div v-if="mostrarPanel" class="panel-seleccion">
                <h3>Butacas seleccionadas:</h3>
                <p>{{ butacasSeleccionadas.join(', ') }}</p>
                <button @click="comprar">Comprar</button>
            </div>
        </div>
    </body>
</template>
  
<script>
import Seient from '../components/Seient.vue';

export default {
    components: {
        Seient
    },
    data() {
        return {
            files: [
                [{ id: '1-1', seleccionat: false , ocupada: true }, { id: '1-2', seleccionat: false , ocupada: true}, { id: '1-3', seleccionat: false }, { id: '1-4', seleccionat: false }, { id: '1-5', seleccionat: false }, { id: '1-6', seleccionat: false }, { id: '1-7', seleccionat: false }, { id: '1-8', seleccionat: false }, { id: '1-9', seleccionat: false }, { id: '1-10', seleccionat: false }, { id: '1-11', seleccionat: false }, { id: '1-12', seleccionat: false }],
                [{ id: '2-1', seleccionat: false }, { id: '2-2', seleccionat: false }, { id: '2-3', seleccionat: false }, { id: '2-4', seleccionat: false }, { id: '2-5', seleccionat: false }, { id: '2-6', seleccionat: false }, { id: '2-7', seleccionat: false }, { id: '2-8', seleccionat: false }, { id: '2-9', seleccionat: false }, { id: '2-10', seleccionat: false }, { id: '2-11', seleccionat: false }, { id: '2-12', seleccionat: false }],
                [{ id: '3-1', seleccionat: false }, { id: '3-2', seleccionat: false }, { id: '3-3', seleccionat: false }, { id: '3-4', seleccionat: false }, { id: '3-5', seleccionat: false }, { id: '3-6', seleccionat: false }, { id: '3-7', seleccionat: false }, { id: '3-8', seleccionat: false }, { id: '3-9', seleccionat: false }, { id: '3-10', seleccionat: false }, { id: '3-11', seleccionat: false }, { id: '3-12', seleccionat: false }],
                [{ id: '4-1', seleccionat: false }, { id: '4-2', seleccionat: false }, { id: '4-3', seleccionat: false }, { id: '4-4', seleccionat: false }, { id: '4-5', seleccionat: false }, { id: '4-6', seleccionat: false }, { id: '4-7', seleccionat: false }, { id: '4-8', seleccionat: false }, { id: '4-9', seleccionat: false }, { id: '4-10', seleccionat: false }, { id: '4-11', seleccionat: false }, { id: '4-12', seleccionat: false }],
                [{ id: '5-1', seleccionat: false }, { id: '5-2', seleccionat: false }, { id: '5-3', seleccionat: false }, { id: '5-4', seleccionat: false }, { id: '5-5', seleccionat: false }, { id: '5-6', seleccionat: false }, { id: '5-7', seleccionat: false }, { id: '5-8', seleccionat: false }, { id: '5-9', seleccionat: false }, { id: '5-10', seleccionat: false }, { id: '5-11', seleccionat: false }, { id: '5-12', seleccionat: false }],
                [{ id: '6-1', seleccionat: false }, { id: '6-2', seleccionat: false }, { id: '6-3', seleccionat: false }, { id: '6-4', seleccionat: false }, { id: '6-5', seleccionat: false }, { id: '6-6', seleccionat: false }, { id: '6-7', seleccionat: false }, { id: '6-8', seleccionat: false }, { id: '6-9', seleccionat: false }, { id: '6-10', seleccionat: false }, { id: '6-11', seleccionat: false }, { id: '6-12', seleccionat: false }],
                [{ id: '7-1', seleccionat: false }, { id: '7-2', seleccionat: false }, { id: '7-3', seleccionat: false }, { id: '7-4', seleccionat: false }, { id: '7-5', seleccionat: false }, { id: '7-6', seleccionat: false }, { id: '7-7', seleccionat: false }, { id: '7-8', seleccionat: false }, { id: '7-9', seleccionat: false }, { id: '7-10', seleccionat: false }, { id: '7-11', seleccionat: false }, { id: '7-12', seleccionat: false }],
                [{ id: '8-1', seleccionat: false }, { id: '8-2', seleccionat: false }, { id: '8-3', seleccionat: false }, { id: '8-4', seleccionat: false }, { id: '8-5', seleccionat: false }, { id: '8-6', seleccionat: false }, { id: '8-7', seleccionat: false }, { id: '8-8', seleccionat: false }, { id: '8-9', seleccionat: false }, { id: '8-10', seleccionat: false }, { id: '8-11', seleccionat: false }, { id: '8-12', seleccionat: false }],
                [{ id: '9-1', seleccionat: false }, { id: '9-2', seleccionat: false }, { id: '9-3', seleccionat: false }, { id: '9-4', seleccionat: false }, { id: '9-5', seleccionat: false }, { id: '9-6', seleccionat: false }, { id: '9-7', seleccionat: false }, { id: '9-8', seleccionat: false }, { id: '9-9', seleccionat: false }, { id: '9-10', seleccionat: false }],

            ],
            butacasSeleccionadas: [],
            butacasOcupadas: ['1-1','1-2'],
        };
    },
    methods: {
        toggleSeient(seientId) {
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
        },
        findSeientById(seientId) {
            for (let fila of this.files) {
                for (let seient of fila) {
                    if (seient.id === seientId) {
                        return seient;
                    }
                }
            }
        }
    },
    computed: {
        mostrarPanel() {
            return this.butacasSeleccionadas.length > 0;
        }
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
    overflow: hidden;
    /* Evita el desplazamiento vertical */
}

.cine {
    text-align: center;
    padding: 20px;
    background-color: #1f1f1f;
    /* Fondo oscuro para simular el interior de una sala de cine */
    color: #ffffff;
    height: 100%;
}

.pantalla {
    width: 50%;
    height: 50px;
    background-color: #ffffff;
    color: #000000;
    margin: 0 auto 20px;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    /* Sombra para darle profundidad */
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


/* Los estilos de Seient.vue se aplicarán aquí debido al scope */
</style>
  