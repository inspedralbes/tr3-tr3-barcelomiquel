<template>

  <body>
    <Header />
    <div class="cine">
      <div v-if="sessionDetails">
        <img :src="sessionDetails.pelicula.poster" alt="Póster de la película" class="poster" />
        <h2>{{ sessionDetails.pelicula.titol }}</h2>
        <h3>Sesión: {{ sessionDetails.sessionId }}</h3>
      </div>
      <div class="resumen">
        <h1>Resumen de tu Compra</h1>
        <h2>Película: {{ nombrePelicula }}</h2>
        <h3>Butacas Seleccionadas:</h3>
        <ul>
          <li v-for="butaca in localButacas" :key="butaca">{{ butaca }}</li>
        </ul>
        <h4>Total a Pagar: ${{ precioTotal }}</h4>
        <button @click="confirmarCompra">Confirmar Compra</button>
      </div>
    </div>
  </body>
</template>

<script>
import { useSesionCompraStore } from '../stores/sesionCompra.js';
export default {
  data() {
    return {
      localButacas: [],
      sessionDetails: null,
      nombrePelicula: '',
      precioTotal: 0,
    };
  },
  async mounted() {
    // Combina la lógica de los dos métodos mounted aquí
    this.localButacas = JSON.parse(this.$route.query.butacas || '[]');
    this.nombrePelicula = this.$route.query.nombrePelicula;
    this.precioTotal = Number(this.$route.query.precioTotal);
    await this.fetchSessionDetails();
  },
  methods: {
    async fetchSessionDetails() {
      try {
        const id = this.$route.params.id; // Obtener el ID de la ruta
        const response = await fetch(`http://localhost:8000/api/sesiones/${id}`);
        if (!response.ok) throw new Error('Error al obtener los detalles de la sesión');
        const data = await response.json();
        this.sessionDetails = data;
        console.log(this.sessionDetails); // Imprime para depurar
        this.nombrePelicula = data.pelicula.titol;
      } catch (error) {
        console.error('Error al obtener los detalles de la sesión:', error);
      }
    },
    async confirmarCompra() {
      try {
        const response = await fetch('http://localhost:8000/api/entrades', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            butacas: this.localButacas,
            nombrePelicula: this.nombrePelicula,
            precioTotal: this.precioTotal,
          }),
        });
        if (!response.ok) throw new Error('Hubo un problema con la transacción.');
        alert('Compra realizada con éxito.');
      } catch (error) {
        console.error('Error durante la compra:', error);
        alert('Error al realizar la compra.');
      }
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
  height: 100vh;
  /* Hace que el body ocupe el 100% del alto de la ventana */
}

.cine {
  text-align: center;
  padding: 20px;
  background-color: #1f1f1f;
  color: #ffffff;
  height: 100%;
  font-family: 'Your Epic Font', sans-serif;
}

.resumen {
  background-color: #333;
  color: #fff;
  margin: 20px auto;
  padding: 20px;
  border-radius: 5px;
  max-width: 600px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
}

.resumen ul {
  list-style-type: none;
  /* Elimina los puntos de la lista */
  padding: 0;
  /* Elimina el padding por defecto */
  margin: 0;
  /* Elimina el margen por defecto */
}

.poster {
  max-width: 200px;
  /* Ajusta según sea necesario */
  margin: 20px auto;
  /* Centra el póster */
  display: block;
  border-radius: 10px;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  margin: 10px 0;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

button:hover {
  background-color: #45a049;
}
</style>
