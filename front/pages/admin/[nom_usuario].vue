<template>
  <body>
    <Header />
    <div class="admin">
      <h1>Administració</h1>
      <p>Estás en la página de administració de {{ $route.params.nom_usuario }}</p>
      <div class="buttons">
        <nuxt-link to="/gestioSessions" class="admin-link">Gestió de Sessions</nuxt-link>
        <nuxt-link to="/gestioPelicules" class="admin-link">Gestió de Pel·licules</nuxt-link>
        <nuxt-link to="/estadistiques" class="admin-link">Estadístiques</nuxt-link>
      </div>
      
    </div>
  </body>
</template>

<script>
export default {
  setup() {
    return {};
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
  overflow: hidden;
}

.admin {
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

p {
  font-size: 1.2rem;
  font-family: 'Your Epic Font', sans-serif;
}
.buttons{
  margin-top: 6%;
}

.admin-link {
  margin: auto;
  display: block;
  margin-top: 20px;
  font-size: 2rem;
  color: #000000;
  font-family: 'Your Epic Font', sans-serif;
  font-weight: bold;
  padding: 15px;
  border-radius: 8px;
  width: 40%;
  background-color: #66fcf1;
  text-decoration: none;
  transition: background-color 0.3s;
}

.admin-link:hover {
  background-color: #45a29e;
}
</style>
