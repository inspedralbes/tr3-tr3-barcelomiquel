import express from 'express';
import cors from 'cors';
import { createServer } from 'node:http';
import { Server } from 'socket.io';

const app = express();
app.use(cors());


const server = createServer(app);

const io = new Server(server, {
    cors: {
        origin: '*',
        methods: ['GET', 'POST'],
    }
});

io.on('connection', (socket) => {
    console.log('Usuario conectado');
    
    const sesionId = socket.handshake.query.sesionId;
    console.log(`Usuario conectado a la sesión: ${sesionId}`);

    socket.emit('usuarioConectado', sesionId);

    socket.on('disconnect', () => {
        console.log('Usuario desconectado');
    });

    // Escuchar evento de selección/deselección de butacas
    socket.on('toggleButaca', (seientId) => {
        // Emitir evento a todos los clientes excepto al que lo envió
        socket.broadcast.emit('updateButaca', { seientId, sesionId });
    });

    // Escuchar evento de borrado de selecciones de butacas
    socket.on('borrarButacasSeleccionadas', () => {
        // Emitir evento a todos los clientes excepto al que lo envió
        socket.broadcast.emit('borrarButacas', sesionId);
    });
});

server.listen(3121, () => {
    console.log('Servidor en ejecución en http://localhost:3121');
});