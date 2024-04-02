<template>
    <body>
        <div>
            <Header />
            <div class="home">
                <h1>Perfil de {{ nom_usuario }}</h1>
                <div class="purchased-entries">
                    <h2>Entradas Compradas</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Asiento</th>
                                <th>Precio</th>
                                <th>Título de la Película</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(entry, index) in purchasedEntries" :key="index">
                                <td>{{ entry.asiento }}</td>
                                <td>{{ entry.precio }}</td>
                                <td>{{ entry.titol_pelicula }}</td>
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

                const response = await fetch(`http://localhost:8000/api/entradas/${email}`);
                if (response.ok) {
                    const data = await response.json();
                    this.purchasedEntries = data;
                } else {
                    console.error('Error al obtener las entradas');
                }
            } catch (error) {
                console.error('Error:', error);
            }
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

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th,
td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
    color: #000;
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