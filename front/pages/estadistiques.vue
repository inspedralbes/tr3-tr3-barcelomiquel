<template>
    <div class="container">
      <div class="chart-container">
        <h1>Cantidad de Entradas por Sesión</h1>
        <Chart :data="entradasData" :options="chartOptions" />
      </div>
      <div class="chart-container">
        <h1>Ingresos por Sesión</h1>
        <Chart :data="ingresosData" :options="chartOptions" />
      </div>
    </div>
  </template>
  
  <script>
  import Chart from 'vue-chartjs';
  
  export default {
    components: {
      Chart
    },
    data() {
      return {
        entradasData: [],
        ingresosData: [],
        chartOptions: {
          // Opciones del gráfico
        }
      };
    },
    mounted() {
      this.fetchData();
    },
    methods: {
      async fetchData() {
        try {
          const response = await fetch('http://localhost:8000/api/todas-entradas');
          const data = await response.json();
          this.handleData(data);
  
          // Recuperar datos ficticios para demostración
          const datosFicticios = data; // Asumiendo que datosFicticios es una variable que contiene datos ficticios
          this.entradasData = datosFicticios.map(sesion => sesion.total_asientos);
          this.ingresosData = datosFicticios.map(sesion => sesion.total_precio);
        } catch (error) {
          console.error('Error fetching data:', error);
        }
      },
      handleData(data) {
        // Manejar los datos recibidos de la API
      }
    }
  };
  </script>
  
  <style scoped>
  .container {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
  }
  
  .chart-container {
    width: 45%;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 20px;
    box-sizing: border-box;
    background-color: #f9f9f9;
  }
  </style>
  