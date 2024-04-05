<template>

    <body>
        <div class="home">
            <Header />
            <h1>Editar Sessió</h1>
            <form @submit.prevent="guardarCambios" class="form">
                <label for="pelicula">Pel·lícula</label>
                <select v-model="sesion.pelicula_id" name="pelicula" id="pelicula" class="input-field">
                    <option v-for="pelicula in peliculas" :key="pelicula.id" :value="pelicula.id">{{ pelicula.titol }}
                    </option>
                </select>
                <label for="data">Data</label>
                <input v-model="sesion.fecha" type="date" name="data" id="data" class="input-field">
                <label for="hora">Hora</label>
                <input v-model="sesion.hora" type="time" name="hora" id="hora" class="input-field">
                <label for="preu_entrada">Preu Entrada</label>
                <input v-model="sesion.preu_entrada" type="number" name="preu_entrada" id="preu_entrada"
                    class="input-field">
                <label for="preu_entradaVip">Preu Entrada VIP</label>
                <input v-model="sesion.preu_entradaVip" type="number" name="preu_entradaVip" id="preu_entradaVip"
                    class="input-field">
                <label for="vip">VIP</label>
                <input v-model="sesion.VIP" type="checkbox" name="vip" id="vip">
                <button type="submit" class="buttonTicket">Guardar</button>
            </form>
        </div>
    </body>
</template>

<script>
import Header from '~/components/Header.vue';
export default {
    components: {
        Header
    },
    data() {
        return {
            sesion: {},
            peliculas: [],
        }
    },
    methods: {
        mostrarInformacion() {
            const sesionCompraStore = useSesionCompraStore();
            const sesionID_Editar = sesionCompraStore.sesionID_Editar;

            // Obtener la sesión
            fetch(`http://localhost:8000/api/sesiones/${sesionID_Editar}`)
                .then(response => response.json())
                .then(data => {
                    this.sesion = data;
                })
                .catch(error => console.error('Error al obtener la sesión:', error));

            // Obtener todas las películas
            fetch(`http://localhost:8000/api/peliculas`)
                .then(response => response.json())
                .then(data => {
                    this.peliculas = data;
                })
                .catch(error => console.error('Error al obtener las películas:', error));
        },
        guardarCambios() {
            const sesionCompraStore = useSesionCompraStore();
            const sesionID_Editar = sesionCompraStore.sesionID_Editar;

            fetch(`http://localhost:8000/api/sesiones/${sesionID_Editar}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(this.sesion)
            });
            if (response.ok) {
                console.log('Datos actualizados exitosamente');
                // Redireccionar a la página de detalles de sesión
                this.$router.push(`/sesiones/${this.sesionID}`);
            } else {
                console.error('Error al actualizar la sesión:', response.statusText);
            } console.error('Error de red:', error);
        }
    },
    mounted() {
        this.mostrarInformacion();
    }
}
</script>

<style scoped>
body {
    margin: 0;
    /* Elimina los márgenes predeterminados del body */
    padding: 0;
    /* Elimina el padding predeterminado del body */
    height: 100%;
    /* Hace que el body ocupe el 100% del alto de la ventana */
    overflow: hidden;
}

.home {
    text-align: center;
    padding: 20px;
    background-color: #1a1a1d;
    color: #c5c6c7;
    height: 100vh;
    font-family: 'Your Epic Font', sans-serif;
}

h1 {
    font-variant: small-caps;
    font-size: 4rem;
    font-family: 'Your Epic Font', sans-serif;
}

.form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.input-field {
    width: 300px;
    margin-bottom: 10px;
    padding: 8px;
    border: 1px solid #4b5d67;
    border-radius: 5px;
    background-color: #0b0c10;
    color: #c5c6c7;
}

.buttonTicket {
    width: 300px;
    padding: 10px 0;
    background-color: #66fcf1;
    color: #0b0c10;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: bold;
    font-family: 'Your Epic Font', sans-serif;
}

.buttonTicket:hover {
    background-color: #45a29e;
}
</style>