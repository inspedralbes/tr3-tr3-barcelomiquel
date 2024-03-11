<template>
  <body>
    <Header />
    <div class="home">
      <h1>galaxia films</h1>
      <h2>Pel·licula de la semana</h2>
      <div class="movie-of-the-week" v-if="movieOfTheWeek">
        <div class="movie-card">
          <img :src="movieOfTheWeek.pelicula.poster" alt="Pòster de la pel·lícula de la semana" />
          <h2>{{ movieOfTheWeek.pelicula.titol }}</h2>
          <p>{{ movieOfTheWeek.pelicula.genere }}</p>
          <p>{{ movieOfTheWeek.fecha }}</p>
          <nuxt-link :to="'compra/'+movieOfTheWeek.pelicula_id" class="buttonTicket">Reservar Entrada</nuxt-link>
        </div>
      </div>
      <h2>Todas las películas</h2>
      <div class="movie-list">
        <div class="movie-card" v-for="sesion in sesiones" :key="sesion.id">
          <img :src="sesion.pelicula.poster" :alt="`Póster de ${sesion.pelicula.titol}`" />
          <h2>{{ sesion.pelicula.titol }}</h2>
          <p>{{ sesion.pelicula.genere }}</p>
          <p>{{ sesion.fecha }}</p>
          <p>{{ sesion.hora }}</p>
          <nuxt-link :to="'compra/'+sesion.pelicula_id" class="buttonTicket">Reservar Entrada</nuxt-link>
        </div>
      </div>
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
  computed: {
    movieOfTheWeek() {
      const today = new Date();
      const startOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
      const endOfWeek = new Date(startOfWeek.getTime() + 6 * 24 * 60 * 60 * 1000);
      return this.sesiones.find(sesion => {
        const sesionDate = new Date(sesion.fecha);
        return sesionDate >= startOfWeek && sesionDate <= endOfWeek;
      });
    },
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

.home {
  text-align: center;
  padding: 20px;
  background-color: #1a1a1d;
  color: #c5c6c7;
  height: 100%;
}

h1 {
  font-variant: small-caps;
  font-size: 4rem;
  font-family: 'Your Epic Font', sans-serif;
}

.movie-list {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  padding: 20px;
}

@media screen and (max-width: 768px) {
  .movie-list {
    grid-template-columns: 1fr 1fr; /* 2 columnas para pantallas más pequeñas */
  }
}

@media screen and (max-width: 480px) {
  .movie-list {
    grid-template-columns: 1fr; /* 1 columna para pantallas muy pequeñas */
  }
}

.movie-group {
  display: flex;
  justify-content: center;
  flex: 1;
  max-width: calc(300px * 3);
  /* Ajusta este valor según el ancho de tus tarjetas */
  margin: 0 auto;
  /* Centra los grupos más pequeños */
}

.movie-card {
  margin: 20px;
  padding: 20px;
  border: 1px solid #4b5d67;
  /* Borde sutil */
  border-radius: 15px;
  /* Bordes más redondeados */
  width: 300px;
  /* Ancho mayor para mejor visualización */
  background-color: #0b0c10;
  /* Fondo oscuro para la tarjeta */
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  /* Sombra más pronunciada para profundidad */
  transition: transform 0.3s ease;
  /* Suave transformación al pasar el mouse */
}

.movie-card:hover {
  transform: translateY(-5px);
  /* Ligero movimiento hacia arriba al pasar el mouse */
}

.movie-of-the-week {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

.movie-card img {
  width: 100%;
  height: auto;
  border-radius: 15px;
  margin-bottom: 15px;
  /* Espacio después del póster */
}

h2{
  font-size: 2rem;
  font-family: 'Your Epic Font', sans-serif;
}

p{
  font-size: 1.2rem;
  font-family: 'Your Epic Font', sans-serif;

}

.movie-card h2,
.movie-card p {
  margin: 10px 0;
}

.buttonTicket {
  display: inline-block;
  width: 100%;
  padding: 10px 0;
  background-color: #66fcf1;
  color: #0b0c10;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  text-decoration: none; /* Importante para quitar la subrayado del enlace */
  font-weight: bold;
  font-family: 'Your Epic Font', sans-serif;
}

.buttonTicket:hover {
  background-color: #45a29e;
}

.movie-card nuxt-link {
  display: block;
  width: 100%;
  padding: 10px 0;
  background-color: #66fcf1;
  /* Color distintivo para el botón */
  color: #0b0c10;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  /* Transición suave al cambiar el color */
}

.movie-card nuxt-link:hover {
  background-color: #45a29e;
  /* Color más oscuro al pasar el mouse */
}


</style>