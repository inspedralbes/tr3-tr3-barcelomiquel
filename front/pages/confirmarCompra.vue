<template>
    <div class="cine">
      <div class="resumen">
        <h1>Resumen de tu Compra</h1>
        <h2>Película: {{ nombrePelicula }}</h2>
        <h3>Butacas Seleccionadas: {{ butacas.join(', ') }}</h3>
        <h4>Total a Pagar: ${{ precioTotal }}</h4>
        <button @click="confirmarCompra">Confirmar Compra</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      butacas: Array,
      nombrePelicula: String,
      precioTotal: Number,
    },
    methods: {
      async confirmarCompra() {
        try {
          const response = await fetch('http://localhost:8000/api/entrades', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              butacas: this.butacas,
              nombrePelicula: this.nombrePelicula,
              precioTotal: this.precioTotal,
            }),
          });
          
          if (!response.ok) throw new Error('Hubo un problema con la transacción.');
  
          // Aquí puedes redirigir al usuario o mostrar un mensaje de éxito
          alert('Compra realizada con éxito.');
        } catch (error) {
          console.error('Error durante la compra:', error);
          alert('Error al realizar la compra.');
        }
      },
    },
    mounted() {
        this.butacas = JSON.parse(this.$route.query.butacas || '[]');
        this.nombrePelicula = this.$route.query.nombrePelicula;
        this.precioTotal = Number(this.$route.query.precioTotal);
    }
  };
  </script>
  
  <style>
  /* Agrega tus estilos aquí */
  </style>
  