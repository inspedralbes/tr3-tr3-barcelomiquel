<template>
    <body>
        <Header />
        <div class="home">
            <h1>Crear Nova Sesió</h1>
            <form @submit.prevent="crearSesion" class="form">
                <label for="pelicula">Película</label>
                <select v-model="nuevaSesion.pelicula_id" name="pelicula" id="pelicula" class="input-field">
                    <option v-for="pelicula in peliculas" :key="pelicula.id" :value="pelicula.id">{{ pelicula.titol }}</option>
                </select>
                <label for="data">Fecha</label>
                <input v-model="nuevaSesion.fecha" type="date" name="data" id="data" class="input-field">
                <label for="hora">Hora</label>
                <input v-model="nuevaSesion.hora" type="time" name="hora" id="hora" class="input-field">
                <label for="preu_entrada">Precio de Entrada</label>
                <input v-model="nuevaSesion.preu_entrada" type="number" name="preu_entrada" id="preu_entrada" class="input-field">
                <label for="preu_entradaVip">Precio de Entrada VIP</label>
                <input v-model="nuevaSesion.preu_entradaVip" type="number" name="preu_entradaVip" id="preu_entradaVip" class="input-field">
                <label for="vip">VIP</label>
                <input v-model="nuevaSesion.VIP" type="checkbox" name="vip" id="vip">
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
            nuevaSesion: {
                pelicula_id: null,
                fecha: null,
                hora: null,
                preu_entrada: null,
                preu_entradaVip: null,
                VIP: false
            },
            peliculas: [],
        }
    },
    methods: {
        cargarPeliculas() {
            fetch(`http://localhost:8000/api/peliculas`)
                .then(response => response.json())
                .then(data => {
                    this.peliculas = data;
                })
                .catch(error => console.error('Error al obtener las películas:', error));
        },
        crearSesion() {
            const formData = {
                pelicula_id: this.nuevaSesion.pelicula_id,
                fecha: this.nuevaSesion.fecha,
                hora: this.nuevaSesion.hora,
                preu_entrada: this.nuevaSesion.preu_entrada,
                preu_entradaVip: this.nuevaSesion.preu_entradaVip,
                VIP: this.nuevaSesion.VIP
            };

            fetch(`http://localhost:8000/api/sesiones`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            }).then(response => {
                if (response.ok) {
                    console.log('Sesión creada exitosamente');
                    // Redireccionar a la página de gestión de sesiones
                    this.$router.push(`/gestioSessions`);
                } else {
                    console.error('Error al crear la sesión:', response.statusText);
                }
            }).catch(error => {
                console.error('Error de red:', error);
            });
        }
    },
    mounted() {
        this.cargarPeliculas();
    },
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