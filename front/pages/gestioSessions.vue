<template>

    <body>
        <div class="gestioSessions">
            <Header />
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Poster</th>
                        <th>Película</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Precio Entrada</th>
                        <th>Precio Entrada VIP</th>
                        <th>VIP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sesion in sesiones" :key="sesion.id">
                        <td>{{ sesion.id }}</td>
                        <td>{{ sesion.pelicula.titol }}</td>
                        <td><!-- <img :src="movieOfTheWeek.pelicula.poster" />--></td> 
                        <td>{{ sesion.fecha }}</td>
                        <td>{{ sesion.hora }}</td>
                        <td>{{ sesion.preu_entrada }}</td>
                        <td>{{ sesion.preu_entradaVip }}</td>
                        <td>{{ sesion.VIP ? 'Sí' : 'No' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</template>

<script>

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
    color: #c5c6c7;
    height: 100%;
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
}

th {
    background-color: #f2f2f2;
}
</style>