var http = require("http");

var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'bank'
});

connection.connect();

connection.query('SELECT * FROM customer WHERE id=0', function (error, results, fields) {
    if (error) throw error;
    console.log(results[0]);
});
connection.end();

// REST

server = http.createServer((req, res) => {
    console.log(req)
    res.end(`{"result":"true"}`)
})

server.listen(3000);

