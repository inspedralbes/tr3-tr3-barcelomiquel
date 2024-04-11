<template>
    <body>
        <Header />
        <div class="gestioSessions">
            <h1>Gestió de Sessions</h1>
            <div class="div_crear">
                <nuxt-link to="/crearPelicula" class="crear">Crear Pel·licula</nuxt-link>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pel·lícula</th>
                        <th>Poster</th>
                        <th>Descripció</th>
                        <th>Genere</th>
                        <th>Durada</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="pelicula in peliculas" :key="pelicula.id">
                        <td>{{ pelicula.id }}</td>
                        <td>{{ pelicula.titol }}</td>
                        <td class="imatge"><img :src="pelicula.poster" :alt="`Pòster de ${pelicula.titol}`" /></td>
                        <td class="descripcio">{{ pelicula.descripcio }}</td>
                        <td>{{ pelicula.genere }}</td>
                        <td>{{ pelicula.duracio }}</td>
                        <td class="boton">
                            <div class="link-container">
                                <nuxt-link to="/gestioPelicules" @click="eliminar(pelicula.id)"
                                    class="eliminar">Eliminar</nuxt-link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</template>

<script>
import { useSesionCompraStore } from '@/stores/sesionCompra';
export default {
    data() {
        return {
            peliculas: [],
        };
    },
    mounted() {
        this.fetchPeliculas(); // Llama a fetchSesiones() cuando se monta el componente
        this.startInterval(); // Inicia el intervalo de actualización
    },
    methods: {
        fetchPeliculas() {
            fetch('http://galaxiafilms.daw.inspedralbes.cat/back/public/api/peliculas')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    this.peliculas = data;
                })
        },
        eliminar(peliculaID) {
            fetch(`http://galaxiafilms.daw.inspedralbes.cat/back/public/api/peliculas/${peliculaID}`, {
                method: 'DELETE'
            })
                .then(response => {
                    if (response.ok) {
                        this.fetchPeliculas();
                    }
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        },
        startInterval() {
            this.interval = setInterval(() => {
                this.fetchPeliculas();
            }, 3000); // 3000 milisegundos = 3 segundos
        },
        stopInterval() {
            // Detener el intervalo
            clearInterval(this.interval);
        },
    },
    beforeDestroy() {
        // Asegurarse de detener el intervalo cuando se destruye el componente
        this.stopInterval();
    }
};
</script>

<style scoped>
body {
    margin: 0;
    /* Elimina los márgenes predeterminados del body */
    padding: 0;
    /* Elimina el padding predeterminado del body */
    height: 100%;
    /* Hace que el body ocupe el 100% del alto de la ventana */
}

.gestioSessions {
    text-align: center;
    padding: 20px;
    background-color: #1a1a1d;
    height: 100%;
    font-family: 'Your Epic Font', sans-serif;
}

h1 {
    font-variant: small-caps;
    font-size: 3rem;
    color: #c5c6c7;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    color: #c5c6c7;
    font-family: 'Your Epic Font', sans-serif;
}

th {
    color: black;
    background-color: #f2f2f2;
}

.imatge {
    width: 100px;
}

.descripcio {
    max-width: 300px;
    /* overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap; */
}

.boton{
    width: 100px;
}

img {
    width: 100px;
    height: 150px;
}

.link-container {
    display: flex;
    justify-content: center;
}

.div_crear {
    margin-bottom: 3%;
}

.crear {
    margin: auto;
    display: block;
    font-size: 1rem;
    color: #000000;
    font-family: 'Your Epic Font', sans-serif;
    font-weight: bold;
    padding: 15px;
    border-radius: 8px;
    width: 30%;
    background-color: #0ff807;
    text-decoration: none;
    transition: background-color 0.3s;
}

.crear:hover {
    background-color: #159105;
}

.editar {
    display: block;
    font-size: 1rem;
    color: #000000;
    font-family: 'Your Epic Font', sans-serif;
    font-weight: bold;
    padding: 15px;
    border-radius: 8px;
    width: 30%;
    background-color: #e0f807;
    text-decoration: none;
    transition: background-color 0.3s;
}

.editar:hover {
    background-color: #879105;
}

.eliminar {
    display: block;
    font-size: 1rem;
    color: #000000;
    font-family: 'Your Epic Font', sans-serif;
    font-weight: bold;
    padding: 15px; 
    border-radius: 8px;
    width: 100px; 
    background-color: #f30909;
    text-decoration: none;
    transition: background-color 0.3s;
    text-align: center; 
}

.eliminar:hover {
    background-color: #960505;
}
</style>