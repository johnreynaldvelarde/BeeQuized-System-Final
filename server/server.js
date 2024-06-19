
console.log("BeeQuized Server JS")

// use express
var express = require("express");

// create instance of express
var app = express();

// use http with instance of express
var http = require("http").createServer(app);

// create socket instance with http
var io = require("socket.io")(http);



// add listener for new connection
io.on("connection", function (socket){

    // this is socket for each user
    console.log("New Client Connected", socket.id);

    /*
    socket.on("newQuizMaster", (quizMasterName) => {
        // Broadcast the new quiz master name to all connected clients
        io.emit("newQuizMaster", quizMasterName);
    });
    
    socket.on("newQuestion", (questions) => {
        // broadcast the new questions to all connected clients
        io.emit("newQuestion", questions);
    });
    */
    
    // Handle quiz master starting a question
    socket.on("startQuestion", (questionId) => {
        // Broadcast the question ID to all participants
        io.emit("startQuestion", questionId);
    });

    // Handle setting team score
    socket.on("updateTeamScore", (score) => {
        // Broadcast the updated scores to all clients
        io.emit("updateTeamScore", score);
    });

     // Handle disconnection
     socket.on("disconnect", () => {
        console.log("Client Disconnected", socket.id);
    });
});


app.get("/", function (request, result) {
    result.send("Hello BeeQuized Participant!")
});

// start the server
var port = 3000;

app.listen(port, '0.0.0.0', () => {
    console.log(`Server running at http://0.0.0.0:${port}`);
});

http.listen(port, function(){
    console.log("Listening to port " + port);
});

/*

console.log("BeeQuized Server JS");

// Require necessary modules
const express = require("express");
const https = require("https");
const socketIo = require("socket.io");
const fs = require("fs"); // Node.js filesystem module

// Create an Express application
const app = express();

// Load SSL certificate and key
const privateKey = fs.readFileSync(__dirname + '/private.key', 'utf8');
const certificate = fs.readFileSync(__dirname + '/certificate.crt', 'utf8');
const credentials = { key: privateKey, cert: certificate };

// Create an HTTP server instance with Express
//const server = http.createServer(app);

// Create an HTTPS server instance with Express
const server = https.createServer(credentials, app);

// Create a Socket.IO instance attached to the HTTP server
const io = socketIo(server);

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

// Define a route for the home page
app.get("/", function (request, response) {
    response.send("Hello BeeQuized Participant!");
});

// Define the port to listen on
const port = 3000;

// Start the server and listen on the defined port
server.listen(port, '0.0.0.0', () => {
    console.log(`Server running at https://0.0.0.0:${port}`);
});

*/