console.log("BeeQuized Server JS");

// Require necessary modules
const express = require("express");
const https = require("https");
const socketIo = require("socket.io");
const fs = require("fs"); // Node.js filesystem module
const path = require("path");

// Create an Express application
const app = express();

// Load SSL certificate and key
const privateKey = fs.readFileSync(__dirname + '/private.key', 'utf8');
const certificate = fs.readFileSync(__dirname + '/certificate.crt', 'utf8');
const credentials = { key: privateKey, cert: certificate };

// Create an HTTPS server instance with Express
const server = https.createServer(credentials, app);

// Create a Socket.IO instance attached to the HTTP server
const io = socketIo(server);

// Serve static files from the public directory
app.use(express.static(path.join(__dirname, '../public')));

// Socket.IO event listeners
io.on("connection", function (socket) {
    console.log("New Client Connected", socket.id);

    // Event listener for when quiz master starts a question
    socket.on("startQuestion", (questionId) => {
        // Broadcast the question ID to all connected clients
        io.emit("startQuestion", questionId);
    });

    // Handle disconnection
    socket.on("disconnect", () => {
        console.log("Client Disconnected", socket.id);
    });
});

// Define the port to listen on
const port = 3000;

// Start the server and listen on the defined port
server.listen(port, '0.0.0.0', () => {
    console.log(`Server running at https://0.0.0.0:${port}`);
});
