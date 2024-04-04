<template>

    <body>
        <div class="gestioSessions">
            <Header />
            <h1>Gestió de Sessions</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pel·lícula</th>
                        <th>Poster</th>
                        <th>Descripció</th>
                        <th>Genere</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Durada</th>
                        <th>Preu Entrada</th>
                        <th>Preu Entrada VIP</th>
                        <th>VIP</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sesion in sesiones" :key="sesion.id">
                        <td>{{ sesion.id }}</td>
                        <td>{{ sesion.pelicula.titol }}</td>
                        <td class="imatge"><img :src="sesion.pelicula.poster" :alt="`Póster de ${sesion.pelicula.titol}`" /></td>
                        <td>{{ sesion.pelicula.descripcio }}</td>
                        <td>{{ sesion.pelicula.genere }}</td>
                        <td>{{ sesion.fecha }}</td>
                        <td>{{ sesion.hora }}</td>
                        <td>{{ sesion.pelicula.duracio }}</td>
                        <td class="preu">{{ sesion.preu_entrada }}</td>
                        <td class="preuVip">{{ sesion.preu_entradaVip }}</td>
                        <td>{{ sesion.VIP ? 'Sí' : 'No' }}</td>
                        <td>
                            <div class="link-container">
                                <nuxt-link :to="'/editar/' + sesion.id" @click="guardarSesionID(sesion.id)" class="editar">Editar</nuxt-link>
                                <nuxt-link to="/gestioSessions" @click="eliminar(sesion.id)" class="eliminar">Eliminar</nuxt-link>
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
            sesiones: [],
        };
    },
    mounted() {
        this.fetchSesiones();
    },
    methods: {
        fetchSesiones() {
            fetch('http://localhost:8000/api/sesiones')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    this.sesiones = data;
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        },
        guardarSesionID(sesionID_Editar) {
            const sesionCompraStore = useSesionCompraStore();
            sesionCompraStore.setSesionID_Editar(sesionID_Editar);
        },
    },
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

.preu{
    width: 30px;
}

.preuVip{
    width: 100px;
}

img {
    width: 100px;
    height: 150px;
}

.link-container {
    display: flex;
    justify-content: space-between; /* Esto distribuirá los elementos horizontalmente */
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
    width: 30%;
    background-color: #f30909;
    text-decoration: none;
    transition: background-color 0.3s;
}

.eliminar:hover {
    background-color: #960505;
}
</style>