<template>
    <body>
        <div>
            <Header />
            <div class="profile-container">
                <h1>Perfil de {{ nom_usuario }}</h1>
                <div class="purchased-entries">
                    <h2>Entradas Compradas</h2>
                    <ul>
                        <li v-for="(entry, index) in purchasedEntries" :key="index">
                            {{ entry }}
                        </li>
                    </ul>
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
                const response = await fetch('/api/entradas');
                if (response.ok) {
                    const data = await response.json();
                    this.purchasedEntries = data.entradas;
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
    height: 100vh;
    /* Hace que el body ocupe el 100% del alto de la ventana */
}

.profile-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.purchased-entries {
    margin-top: 20px;
}

.purchased-entries h2 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    padding: 5px 0;
    border-bottom: 1px solid #ccc;
}

li:last-child {
    border-bottom: none;
}
</style>
