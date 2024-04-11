<template>

  <body>
    <Header />
    <div class="grafics-container">
      <div class="chart-container">
        <h2 class="chart-title">Ocupació per sesió</h2>
        <canvas ref="ocupacionChart" class="chart"></canvas>
      </div>

      <div class="chart-container">
        <h2 class="chart-title">Preu total per sesió</h2>
        <canvas ref="precioTotalChart" class="chart"></canvas>
      </div>
    </div>
  </body>
</template>

<script>
import Chart from 'chart.js/auto';

export default {
  async mounted() {
    try {
      const response = await fetch('http://galaxiafilms.daw.inspedralbes.cat/back/public/api/todas-entradas');
      const data = await response.json();

      // Procesar los datos para los gráficos
      const sesiones = data.map(sesion => ({
        id: sesion.id,
        ocupacion: sesion.total_asientos,
        precioTotal: sesion.total_precio
      }));

      // Extraer los datos necesarios para los gráficos
      const labels = sesiones.map(sesion => `Sesión ${sesion.id}`);
      const ocupacionData = sesiones.map(sesion => sesion.ocupacion);
      const precioTotalData = sesiones.map(sesion => sesion.precioTotal);

      // Configurar el gráfico de ocupación
      new Chart(this.$refs.ocupacionChart, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Ocupación por sesión',
            data: ocupacionData,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      // Configurar el gráfico de precio total
      new Chart(this.$refs.precioTotalChart, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Precio total por sesión',
            data: precioTotalData,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    } catch (error) {
      console.error('Error al obtener los datos:', error);
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
  height: 100%;
  /* Hace que el body ocupe el 100% del alto de la ventana */
  overflow: hidden;
}

.grafics-container {
  text-align: center;
  padding: 20px;
  background-color: #1a1a1d;
  color: #c5c6c7;
  height: 100vh;
}

h2{
  font-size: 4rem;
  font-family: 'Your Epic Font', sans-serif;

}

.chart-container {
  max-width: 600px;
  margin: 20px auto;
  display: block;
}

.chart-title {
  font-size: 1.5rem;
  margin-bottom: 10px;
  color: #c5c6c7;
}

.chart {
  background-color: #0b0c10;
  border: 1px solid #4b5d67;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  margin-bottom: 20px;
}

.chart canvas {
  border-radius: 10px;
}
</style>
