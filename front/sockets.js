import { io } from "socket.io-client";

const URL = "http://localhost:3121";

export function initializeSocket() {
    return io(URL);
}
