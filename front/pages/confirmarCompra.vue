<template>
  <body>
    <Header />
    <div class="confirmar-compra">
      <div class="ticket">
        <h2>Ticket de Compra</h2>
        <ul>
          <li v-for="butaca in store.butacasSeleccionadas" :key="butaca.id">
            {{ butaca.id }} - {{ butaca.precio }}€
          </li>
        </ul>
        <h2>Total: {{ precioTotal }}€</h2>
        <button @click="comprar">Comprar</button>
      </div>
    </div>
  </body>
</template>

<script>
import { useSesionCompraStore } from '../stores/sesionCompra.js';
import Header from '../components/Header.vue'; // Importa el componente Header si es necesario

export default {
  components: {
    Header
  },
  computed: {
    store() {
      return useSesionCompraStore();
    },
    precioTotal() {
      return this.store.butacasSeleccionadas.reduce((total, butaca) => total + butaca.precio, 0);
    }
  },
  methods: {
    comprar() {
      // Coloca aquí la lógica para realizar la compra, por ejemplo, redirigir a una página de confirmación
      this.$router.push({ path: '/compraConfirmada' });
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

.confirmar-compra {
  text-align: center;
  padding: 20px;
  background-color: #1f1f1f;
  color: #ffffff;
  height: 100%;
  font-family: 'Your Epic Font', sans-serif;
}

.ticket {
  background-color: #333;
  color: #fff;
  padding: 20px;
  border-radius: 5px;
  margin: 20px auto;
  max-width: 500px;
}

ul {
  list-style-type: none;
  padding: 0;
}

li{
  font-size: 1em;
  margin: 10px 0;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  margin-top: 20px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

button:hover {
  background-color: #45a049;
}
</style>
