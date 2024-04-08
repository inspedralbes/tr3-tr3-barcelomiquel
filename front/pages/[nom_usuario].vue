<template>
    <body>
        <div>
            <Header />
            <div class="home">
                <h1>Perfil de {{ nom_usuario }}</h1>
                <div class="purchased-entries">
                    <h2>Entrades Comprades</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Seient</th>
                                <th>Preu</th>
                                <th>Títol de la Pel·lícula</th>
                                <th>Metóde de pagament</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(entry, index) in purchasedEntries" :key="index">
                                <td>{{ entry.asiento }}</td>
                                <td>{{ entry.precio }}</td>
                                <td>
                                    <nuxt-link :to="`/compra/${entry.sesion_id}`" @click="PantallaButacas(entry.sesion_id)" class="titol_pelicula">{{ entry.titol_pelicula }}</nuxt-link>
                                </td>
                                <td>{{ entry.metodo_pago}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</template>

<script>
import { useSesionCompraStore } from '@/stores/sesionCompra';
import Header from '@/components/Header.vue';

export default {
    name: 'Perfil',
    components: {
        Header
    },
    data() {
        return {
            purchasedEntries: []
        };
    },
    computed: {
        nom_usuario() {
            return this.$route.params.nom_usuario;
        }
    },
    mounted() {
        this.fetchPurchasedEntries();
    },
    methods: {
        async fetchPurchasedEntries() {
            try {
                const sesionCompraStore = useSesionCompraStore();
                const email = sesionCompraStore.email_usuari;

                const response = await fetch(`http://cinema.pre.daw.inspedralbes.cat/back/public/api/entradas/${email}`);
                if (response.ok) {
                    const data = await response.json();
                    console.log(data);
                    this.purchasedEntries = data;
                } else {
                    console.error('Error al obtener las entradas');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        },
        PantallaButacas(sesion_id) {
            const sesionCompraStore = useSesionCompraStore();
            sesionCompraStore.sesionID = sesion_id;
        }
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

.home {
    text-align: center;
    padding: 20px;
    background-color: #1a1a1d;
    color: #c5c6c7;
    height: 100vh;
}

h1 {
    font-variant: small-caps;
    font-size: 4rem;
    font-family: 'Your Epic Font', sans-serif;
}

.purchased-entries {
    margin-top: 20px;
}

.purchased-entries h2 {
    font-size: 2rem;
    font-family: 'Your Epic Font', sans-serif;
}

.titol_pelicula{
    color: black
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th,
td {
    font-family: 'Your Epic Font', sans-serif;
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
    color: #000;
    font-family: 'Your Epic Font', sans-serif;
}

th {
    background-color: #ccc;
    font-size: 1.15em;
}

tr{
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #c0c0c0;
}

tr:hover {
    background-color: #91cef1;
}
</style>
