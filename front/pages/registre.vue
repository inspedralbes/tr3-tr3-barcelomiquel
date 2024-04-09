<template>

    <body>
        <Header />
        <div v-if="loading" class="loading"> 
            <img src="/public/loading.gif" alt="Carregant..." />
        </div>
        <div class="registro">
            <h1>Regístra't</h1>
            <form @submit.prevent="registro" class="form">
                <div class="form-group">
                    <label for="name">Nom:</label>
                    <input type="name" id="name" v-model="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Correu Electrónic:</label>
                    <input type="email" id="email" v-model="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contrasenya:</label>
                    <input type="password" id="password" v-model="password" required>
                </div>
                <button type="submit" class="buttonRegistro">Registra't</button>
            </form>
            <p>Ja tens conta? <router-link to="/login">Inicia Sesión</router-link></p>
        </div>
    </body>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            loading: false // Agrega la variable loading
        };
    },
    methods: {
        registro() {
            // Activar el estado de carga
            this.loading = true;

            // Realizar una solicitud HTTP a la API de registro en Laravel
            fetch('http://localhost:8000/api/registro', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: this.name,
                    email: this.email,
                    password: this.password
                })
            })
                .then(response => {
                    if (response.ok) {
                        // Redirigir al usuario a la página de inicio después del registro exitoso
                        this.$router.push('/login');
                    } else {
                        // Manejar errores en caso de que el registro falle
                        console.error('Error al registrar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Desactivar el estado de carga después de que la petición haya finalizado
                    this.loading = false;
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

.registro {
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

.loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.582); 
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading img {
    width: 200px;
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
