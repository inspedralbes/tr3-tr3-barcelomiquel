<template>
  <header class="site-header">
    <nuxt-link to="/" class="logo-and-title" @click="inici()">
      <img src="../public/logoCIne.jpg" alt="Logo Galaxia Films" class="logo-cine">
      <h2>galaxia films</h2>
    </nuxt-link>
    <div>
      <nuxt-link v-if="!loguejat" to="/login" class="login-button">Login/Registre</nuxt-link>
      <nuxt-link  v-if="loguejat" :to="`/${nom_usuari}`" class="login-button">{{ nom_usuari }}</nuxt-link>
      <nuxt-link  v-if="loguejat && admin" :to="`admin/${nom_usuari}`" class="login-button">Admin</nuxt-link>
      <nuxt-link  v-if="loguejat" to="/" @click="logout" class="login-button">Logout</nuxt-link>
    </div>

  </header>
</template>

<script>
import { useSesionCompraStore } from '@/stores/sesionCompra';

export default {
  name: 'Header',
  computed: {
    loguejat() {
      return useSesionCompraStore().loguejat;
    },
    nom_usuari() {
      return useSesionCompraStore().nom_usuari;
    },
    admin() {
      return useSesionCompraStore().tipus_usuari === 'admin';
    },
  },
  methods: {
    logout() {
      // Realiza una petición fetch para llamar a la ruta de logout en tu backend
      fetch('http://galaxiafilms.daw.inspedralbes.cat/back/public/api/logout', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`, // Agrega el token de autenticación
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        }
      })
      .then(response => {
        if (response.ok) {
          // Si la respuesta es exitosa, revoca el token del usuario
          localStorage.removeItem('token');

          // Restablece los datos relevantes en tu store Pinia
          const store = useSesionCompraStore();
          store.loguejat = false;
          store.tipus_usuari = '';
          store.nom_usuari = '';
          store.email_usuari = '';
          store.butacasSeleccionadas = [];
          store.sesionID = '';
          store.precioTotal = 0;
          store.sesionID_Editar = '';

          // Redirige al usuario a la página de inicio
          this.$router.push('/');
        } else {
          throw new Error('Error al realizar el logout');
        }
      })
      .catch(error => console.error('Error al realizar el logout:', error));
    },
    inici(){
      const store = useSesionCompraStore();
      store.butacasSeleccionadas = [];
      store.sesionID = "";
      store.precioTotal = 0;
      store.sesionID_Editar = "";
    }
  }
};
</script>

<style scoped>
.site-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 20px;
  background-color: #141418;
  /* Un poco más oscuro que el fondo principal */
  color: #c5c6c7;
}

.logo-and-title {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: inherit;
}

.logo-cine {
  height: 50px;
  margin-right: 15px;
  /* Ajusta según sea necesario */
}

h2 {
  font-variant: small-caps;
  font-size: 2rem;
  font-family: 'Your Epic Font', sans-serif;
  margin: 0;
}

div{
  margin-right: 2%;
}

.login-button,
.logout-button {
  margin-right: 5%;
  padding: 10px 20px;
  background-color: #66fcf1;
  color: #0b0c10;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
  font-family: 'Your Epic Font', sans-serif;
  font-weight: bold;
  text-decoration: none; /* Quitar subrayado */
}

.login-button:hover,
.logout-button:hover {
  background-color: #45a29e;
}
</style>
