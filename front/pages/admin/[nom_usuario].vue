<template>
  <body>
    <Header />
    <div class="admin">
      <h1>Admin</h1>
      <p>Estás en la página de administración de {{ $route.params.nom_usuario }}</p>
  </div>
  </body>
</template>

<script>
export default {
  setup () {
      return {}
  }
}
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

.admin {
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

p {
font-size: 1.2rem;
font-family: 'Your Epic Font', sans-serif;
}
</style>
