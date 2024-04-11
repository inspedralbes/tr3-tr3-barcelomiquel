import express from 'express';
import http from 'http';
import { Server } from 'socket.io';

const app = express();
const server = http.createServer(app);
const io = new Server(server);

// Array para almacenar las butacas seleccionadas
let butacasSeleccionadas = [];

io.on('connection', socket => {
  console.log('Nuevo usuario conectado');

  // Emitir las butacas seleccionadas al cliente que se conecta
  socket.emit('butacasSeleccionadas', butacasSeleccionadas);

  // Manejar el evento de selección de butacas
  socket.on('butacaSeleccionada', butacaId => {
    console.log('Butaca seleccionada:', butacaId);
    // Agregar la butaca seleccionada al array
    butacasSeleccionadas.push(butacaId);
    // Emitir el evento a todos los clientes para actualizar sus vistas
    io.emit('butacaSeleccionada', butacaId);
  });

  // Manejar el evento de deselección de butacas
  socket.on('butacaDeseleccionada', butacaId => {
    console.log('Butaca deseleccionada:', butacaId);
    // Remover la butaca deseleccionada del array
    butacasSeleccionadas = butacasSeleccionadas.filter(id => id !== butacaId);
    // Emitir el evento a todos los clientes para actualizar sus vistas
    io.emit('butacaDeseleccionada', butacaId);
  });

  socket.on('disconnect', () => {
    console.log('Usuario desconectado');
  });
});

const PORT = process.env.PORT || 3000;

server.listen(PORT, () => console.log(`Servidor escuchando en el puerto ${PORT}`));

export { io }; // Exporta la instancia de Socket.IO
