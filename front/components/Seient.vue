<template>
    <div class="seient" :class="{ 'seient-seleccionat': seient.seleccionat }" @click="toggleSeient">
      <!-- {{ seient.id }} -->
    </div>
  </template>
  
  <script>
  export default {
    props: {
      seient: Object,
    },
    methods: {
      toggleSeient() {
        this.$emit('toggle', this.seient.id);
      }
    }
  }
  </script>
  
  <style scoped>
  .seient {
    width: 35px;
    height: 35px;
    background-color: #ccc;
    border-radius: 5px; /* Redondeamos las esquinas para un look más moderno */
    border: 1px solid #888;
    margin: 0 7px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Transición suave al seleccionar */
  }
  
  .seient-seleccionat {
    background-color: #4CAF50; /* Un verde más suave para los asientos seleccionados */
  }
  </style>
  