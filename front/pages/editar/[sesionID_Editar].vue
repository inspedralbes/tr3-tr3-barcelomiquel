<template>
    <div>
        <Header />
        <h1>Editar Sessió</h1>
        <form @submit.prevent="guardarCambios">
            <label for="pelicula">Pel·lícula</label>
            <select v-model="sesion.pelicula_id" name="pelicula" id="pelicula">
                <option v-for="pelicula in peliculas" :key="pelicula.id" :value="pelicula.id">{{ pelicula.nombre }}</option>
            </select>
            <label for="data">Data</label>
            <input v-model="sesion.fecha" type="date" name="data" id="data">
            <label for="hora">Hora</label>
            <input v-model="sesion.hora" type="time" name="hora" id="hora">
            <label for="durada">Durada</label>
            <input v-model="sesion.durada" type="number" name="durada" id="durada">
            <label for="preu_entrada">Preu Entrada</label>
            <input v-model="sesion.preu_entrada" type="number" name="preu_entrada" id="preu_entrada">
            <label for="preu_entradaVip">Preu Entrada VIP</label>
            <input v-model="sesion.preu_entradaVip" type="number" name="preu_entradaVip" id="preu_entradaVip">
            <label for="vip">VIP</label>
            <input v-model="sesion.VIP" type="checkbox" name="vip" id="vip">
            <button type="submit">Guardar</button>
        </form>
    </div>
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

            fetch(`http://localhost:8000/api/sesiones/${sesionID_Editar}`)
                .then(response => response.json())
                .then(data => {
                    this.sesion = data;
                })
                .catch(error => console.error('Error al obtener la película:', error));
        },
        async guardarCambios() {
            try {
                const response = await fetch(`http://localhost:8000/api/sesiones/${this.sesionID}`, {
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
                }
            } catch (error) {
                console.error('Error de red:', error);
            }
        }
    },
    mounted() {
        this.mostrarInformacion();
    }
}
</script>

<style scoped>

</style>