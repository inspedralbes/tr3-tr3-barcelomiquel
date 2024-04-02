<template>
    <body>
        <Header />
        <div class="login">
            <h1>Iniciar Sesió</h1>
            <form @submit.prevent="login" class="form">
                <div class="form-group">
                    <label for="email">Correo Electrónic:</label>
                    <input type="email" id="email" v-model="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contrasenya:</label>
                    <input type="password" id="password" v-model="password" required>
                </div>
                <button type="submit" class="buttonLogin">Iniciar Sesió</button>
            </form>
            <p>No tiens una conta? <router-link to="/registre">Regístra't</router-link></p>
        </div>
    </body>
</template>

<script>
import { useSesionCompraStore } from '@/stores/sesionCompra';

export default {
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        login() {
            fetch('http://localhost:8000/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: this.email,
                    password: this.password
                })
            })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error al iniciar sesión');
                    }
                })
                .then(data => {
                    const store = useSesionCompraStore();
                    store.iniciarSesionExitoso();
                    store.nom_usuari = data.name;
                    store.tipus_usuari = data.tipus;
                    store.email_usuari = data.email; 
                    this.$router.push('/');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
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
    overflow: hidden;
}

.login {
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

.form {
    margin-top: 7%;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-size: 1.65rem;
    font-weight: bold;
    margin-bottom: 10px;
    font-family: 'Your Epic Font', sans-serif;
}

input {
    width: 40%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #4b5d67;
    background-color: #0b0c10;
    color: #c5c6c7;
}

button {
    width: 40%;
    padding: 10px 0;
    background-color: #66fcf1;
    color: #0b0c10;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.15s ease;
    font-weight: bold;
    font-size: 1.2em;
    font-family: 'Your Epic Font', sans-serif;
}

button:hover {
    background-color: #45a29e;
}

p {
    font-size: 1.2rem;
    font-family: 'Your Epic Font', sans-serif;
}

.router-link {
    color: #66fcf1;
    text-decoration: none;
    transition: color 0.3s ease;
}

.router-link:hover {
    color: #45a29e;
}
</style>