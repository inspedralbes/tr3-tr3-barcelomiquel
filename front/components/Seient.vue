<template>
  <div class="seient" :class="{ 'seient-seleccionat': seient.seleccionat, 'seient-ocupat': seient.ocupada }"
    @click="toggleSeient">
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
      if (!this.seient.ocupada) {
        this.$emit('toggle', this.seient.id);
      }
    }
  }
}
</script>

<style scoped>
.seient {
  width: 35px;
  height: 35px;
  background-color: #ccc;
  border-radius: 5px;
  border: 1px solid #888;
  margin: 0 7px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.seient-seleccionat {
  background-color: #4CAF50;
}

.seient-ocupat {
  background-color: #FF4136;
  /* Rojo para indicar asiento ocupado */
  cursor: not-allowed;
  /* Cambia el cursor para indicar que no es seleccionable */
}

/* Asegúrate de deshabilitar la interacción con el asiento ocupado */
.seient-ocupat:hover {
  background-color: #FF4136;
  /* Mantén el color incluso al pasar el mouse */
}
</style>