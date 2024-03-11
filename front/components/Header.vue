<template>
    <header class="site-header">
        <a href="/" class="logo-and-title">
            <img src="../public/logoCIne.jpg" alt="Logo Galaxia Films" class="logo-cine">
            <h2>galaxia films</h2>
        </a>
        <button class="login-button">Login/Registro</button>
    </header>
</template>

<script>
export default {
    name: 'Header',
};
</script>

<style scoped>
.site-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    background-color: #141418; /* Un poco más oscuro que el fondo principal */
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
    margin-right: 15px; /* Ajusta según sea necesario */
}

h2 {
    font-variant: small-caps;
    font-size: 2rem;
    font-family: 'Your Epic Font', sans-serif;
    margin: 0;
}

.login-button {
    padding: 10px 20px;
    background-color: #66fcf1;
    color: #0b0c10;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-family: 'Your Epic Font', sans-serif;
    font-weight: bold;
}

.login-button:hover {
    background-color: #45a29e;
}
</style>
