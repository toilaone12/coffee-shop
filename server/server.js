const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8080 });

wss.on('connection', function connection(ws) {
  console.log('Websocket đã kết nối');

  ws.on('message', function incoming(message) {
    console.log('Received: %s', message);
    // Gửi lại tin nhắn đến tất cả client khác
    wss.clients.forEach(function each(client) {
      if (client !== ws && client.readyState === WebSocket.OPEN) {
        client.send(message);
      }
    });
  });

  ws.on('close', function() {
    console.log('Websocket đã ngắt kết nối');
  });
});

console.log('WebSocket server đã khởi động trên cổng 8080');
