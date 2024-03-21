<template>

  <body>
    <Header />
    <div class="confirmar-compra">
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
        <button @click="comprar">Comprar</button>
        <button class="tornar" @click="tornar">Inici</button>
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
      const asientosSeleccionados = this.store.butacasSeleccionadas.map(butaca => {
        return {
          asiento: butaca.id,
          precio: butaca.precio
        };
      });

      const data = {
        sesion_id: this.store.sesionID,
        asientos: asientosSeleccionados
      };

      console.log(data); // Añadido para verificar si se envía la información correcta

      fetch(`http://localhost:8000/api/entradas`, {
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
          setTimeout(() => {
            this.$router.push({ path: '/' });
          }, 2000);
        })
        .catch(error => console.error('Error al enviar datos al backend:', error));
    },
    fetchPelicula() {
      const sesionCompraStore = useSesionCompraStore();
      const sesionId = sesionCompraStore.sesionID; // Accede al ID almacenado en el store de PINIA

      fetch(`http://localhost:8000/api/sesiones/${sesionId}`)
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

.tornar {
  background-color: #afa84c;
  color: white;
  padding: 10px 20px;
  margin: 10px 10px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

.tornar:hover {
  background-color: #a09a45;
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
