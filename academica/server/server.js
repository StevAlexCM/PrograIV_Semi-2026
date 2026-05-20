import { createServer } from 'http';
import { Server } from 'socket.io';

const httpServer = createServer();
const io = new Server(httpServer, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

io.on('connection', (socket) => {
    console.log('Un usuario se ha conectado');

    socket.on('mensajeRecibido', (data) => {
        console.log(data);
        io.emit('mensajeEnviar', data);
    });
});

httpServer.listen(3000, () => {
    console.log('Escuchando en el puerto 3000');
});
