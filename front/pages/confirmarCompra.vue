<template>

  <body>
    <Header />
    <div class="confirmar-compra">
      <div v-if="loading" class="loading">
        <img src="/public/loading.gif" alt="Carregant..." />
      </div>
      <div class="detalles-pelicula" v-if="sesion">
        <div class="poster-pelicula">
          <img :src="sesion.pelicula.poster" alt="Poster de la película" />
        </div>
        <div class="info-pelicula">
          <h2>{{ sesion.pelicula.titol }}</h2>
          <p>{{ sesion.pelicula.genere }}</p>
          <p>{{ sesion.hora }}</p>
          <p>{{ sesion.pelicula.duracio }}</p>
          <p>{{ sesion.fecha }}</p>
          <p>{{ sesion.pelicula.descripcio }}</p>
        </div>
      </div>
      <div class="ticket">
        <h2>Ticket de Compra</h2>
        <ul>
          <li v-for="butaca in store.butacasSeleccionadas" :key="butaca.id">
            {{ butaca.id }} - {{ butaca.precio }}€
          </li>
        </ul>
        <h2>Total: {{ precioTotal }}€</h2>
        <form @submit.prevent="comprar">
          <div class="form-group" v-if="!store.loguejat">
            <label for="email" class="label-email">Correu Electrónic:</label>
            <input type="email" id="email" v-model="email" required class="input-field">
          </div>
          <div class="form-group">
            <label class="label-pago">Métode de Pagament:</label>
            <div class="payment-methods">
              <div>
                <input type="radio" id="visa" value="visa" v-model="metodoPago" required>
                <label for="visa">Visa</label>
              </div>
              <div>
                <input type="radio" id="paypal" value="paypal" v-model="metodoPago" required>
                <label for="paypal">PayPal</label>
              </div>
              <div>
                <input type="radio" id="mastercard" value="mastercard" v-model="metodoPago" required>
                <label for="mastercard">Mastercard</label>
              </div>
            </div>
          </div>
          <button type="submit" class="btn-comprar">Comprar</button>
          <button class="tornar" @click="tornar">Inici</button>
        </form>
      </div>
    </div>
  </body>
</template>

<script>
import { useSesionCompraStore } from '../stores/sesionCompra.js';
import Header from '../components/Header.vue'; // Importa el componente Header si es necesario

export default {
  data() {
    return {
      sesion: null,
      email: '',
      metodoPago: '',
      loading: false,
    };
  },
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
      // Activar estado de carga
      this.loading = true;

      const asientosSeleccionados = this.store.butacasSeleccionadas.map(butaca => {
        return {
          asiento: butaca.id,
          precio: butaca.precio
        };
      });

      const data = {
        sesion_id: this.store.sesionID,
        asientos: asientosSeleccionados,
        email: this.store.loguejat ? this.store.email_usuari : this.email,
        metodo_pago: this.metodoPago, // Agrega el método de pago al objeto data
        titol_pelicula: this.sesion.pelicula.titol, // Añadido para enviar el título de la película
      };

      console.log(data); // Añadido para verificar si se envía la información correcta

      fetch(`http://galaxiafilms.daw.inspedralbes.cat/back/public/api/entradas`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify(data),
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Error al enviar datos al backend');
          }
          // Mostrar mensaje de confirmación
          alert('Entrades comprades amb èxit');

          // Redirigir a la página de inicio después de 2 segundos

          // Resetea el store de PINIA para borrar los datos almacenados
          this.store.sesionID = 0;
          this.store.butacasSeleccionadas = [];
          this.store.precioTotal = 0;

          // Desactivar estado de carga
          this.loading = false;

          this.$router.push({ path: '/' });
        })
        .catch(error => {
          console.error('Error al enviar datos al backend:', error);
          // Desactivar estado de carga en caso de error
          this.loading = false;
        });
    },
    fetchPelicula() {
      const sesionCompraStore = useSesionCompraStore();
      const sesionId = sesionCompraStore.sesionID; // Accede al ID almacenado en el store de PINIA

      fetch(`http://galaxiafilms.daw.inspedralbes.cat/back/public/api/sesiones/${sesionId}`)
        .then(response => response.json())
        .then(data => {
          console.log(data);
          this.sesion = data;
        })
        .catch(error => console.error('Error al obtener la película:', error));
    },
    tornar() {
      // Resetea el store de PINIA para borrar los datos almacenados
      this.store.sesionID = 0;
      this.store.butacasSeleccionadas = [];
      this.store.precioTotal = 0;

      // Redirige a la página de inicio
      console.log("Botón tornar clicado"); // Añadido para verificar si se ejecuta la función
      this.$router.push({ path: '/' });
    },
  },
  created() {
    this.fetchPelicula();
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

h2 {
  font-size: 2em;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
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


.detalles-pelicula {
  display: flex;
  align-items: center;
  /* Alinea verticalmente */
  justify-content: center;
  /* Alinea horizontalmente */
  padding: 20px;
}

.poster-pelicula {
  width: 300px;
  /* Ajusta según necesidad */
  margin-left: 35%;
}

.poster-pelicula img {
  width: 100%;
  /* Para asegurar que la imagen del póster llene su contenedor */
}

.info-pelicula {
  flex-grow: 1;
  /* Ocupa todo el espacio restante */
  text-align: left;
  padding: 35px;
}

.info-pelicula h2 {
  margin-top: 0;
  /* Eliminar el margen superior del título */
  margin-bottom: 10px;
  /* Espacio entre el título y los párrafos */
}

.info-pelicula p {
  margin: 0;
  /* Eliminar márgenes en los párrafos */
  margin-bottom: 5px;
  /* Espacio entre párrafos */
}

/* Estilos para el campo de correo electrónico */
.label-email {
  font-size: 1.5em;
  font-weight: bold;
}

.input-field {
  margin-top: 10px;
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 15px;
  max-width: 450px;
}

/* Estilos para los métodos de pago */
.label-pago {
  font-size: 1.5em;
  font-weight: bold;
}

.payment-methods {
  display: flex;
  flex-direction: column;
}

.payment-methods div {
  margin-bottom: 10px;
}

.payment-methods input[type="radio"] {
  margin-right: 5px;
}

.loading {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.582); /* Fondo negro con opacidad */
  display: flex;
  justify-content: center; /* Centra horizontalmente */
  align-items: center; /* Centra verticalmente */
  z-index: 9999; /* Asegura que esté por encima de otros elementos */
}

.loading img {
  width: 200px; /* Ajusta el tamaño del gif de carga según sea necesario */
}

/* Estilos para el botón de comprar */
.btn-comprar {
  background-color: #0ff807;
  color: black;
  padding: 10px 20px;
  margin-top: 20px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  font-weight: bold;
  font-size: 1rem;
}

.btn-comprar:hover {
  background-color: #159105;
}

/* Estilos para el botón de volver */
.tornar {
  background-color: #e0f807;
  color: black;
  padding: 10px 20px;
  margin: 10px 10px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  font-weight: bold;
  font-size: 1rem;
}

.tornar:hover {
  background-color: #879105;
}

/* .confirmacion {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  margin: 10px auto;
  border-radius: 5px;
  max-width: 300px;
  text-align: center;
}

.confirmacion:hover {
  background-color: #45a049;
} */
</style>
