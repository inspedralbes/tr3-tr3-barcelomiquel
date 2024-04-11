<template>
    <body>
        <Header />
        <div class="home">
            <h1>Crear Nova Pel·lícula</h1>
            <form @submit.prevent="crearPelicula" class="form">
                <label for="titol">Titol</label>
                <input v-model="nuevaPelicula.titol" type="text" name="titol" id="titol" class="input-field">
                <label for="poster">URL del Poster</label>
                <input v-model="nuevaPelicula.poster" type="text" name="poster" id="poster" class="input-field">
                <label for="descripcio">Descripció</label>
                <textarea v-model="nuevaPelicula.descripcio" name="descripcio" id="descripcio" rows="4"
                    class="input-field"></textarea>
                <label for="genere">Génere</label>
                <input v-model="nuevaPelicula.genere" type="text" name="genere" id="genere" class="input-field">
                <label for="duracio">Duració (minuts)</label>
                <input v-model="nuevaPelicula.duracio" type="text" name="duracio" id="duracio" class="input-field">
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
            nuevaPelicula: {
                titol: null,
                poster: null,
                descripcio: null,
                genere: null,
                duracio: null
            }
        }
    },
    methods: {
        crearPelicula() {
            const formData = {
                titol: this.nuevaPelicula.titol,
                poster: this.nuevaPelicula.poster,
                descripcio: this.nuevaPelicula.descripcio,
                genere: this.nuevaPelicula.genere,
                duracio: this.nuevaPelicula.duracio
            };
            console.log('Creando película:', formData);
            fetch('http://galaxiafilms.daw.inspedralbes.cat/back/public/api/peliculas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(response => {
                    if (response.ok) {
                        console.log('Película creada exitosamente');
                        this.$router.push('/gestioPelicules');
                    } else {
                        console.error('Error al crear la película:', response.statusText);
                    }
                })
                .catch(error => {
                    console.error('Error de red:', error);
                });
        }

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