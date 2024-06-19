const express = require('express')
const app = express();
const server = require('http').createServer(app);
const WebSocket = require('ws');

const wss = new WebSocket.Server({ server:server});

wss.on('connection', function connection(ws) {

    console.log("New Client Connected", ws.id);

    ws.on("newQuizMaster", (quizMasterName) => {
        // Broadcast the new quiz master name to all connected clients
        io.emit("newQuizMaster", quizMasterName);
    });

     // Handle disconnection
    ws.on("disconnect", () => {
        console.log("Client Disconnected", socket.id);
    });


});

app.get("/", function (request, result) {
    result.send("Hello BeeQuized Participant!")
});

// start the server
var port = 3000;
server.listen(port, function(){
    console.log("Listening to port " + port);
});