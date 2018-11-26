const express = require('express');
const bodyParser = require('body-parser');
const app = express();
app.use(bodyParser.json()); // for parsing application/json

// Database
var mysql      = require('mysql');
// var connection = mysql.createConnection({
//   host     : 'localhost',
//   user     : 'root',
//   password : '',
//   database : 'bank'
// });
// connection.connect();

// REST
// Validasi nasabah
app.get("/api/validate_customer/:id", (req, res) => {
    connection.query('SELECT * FROM customer WHERE id='+req.params.id, function (error, results, fields) {
        if (error) throw error;
        // If not found, return false
        if (typeof results[0] == 'undefined') res.json({result:false})
        // if found, return true
        else res.json({result:true})
    });
})

app.post("/api/create_tx", (req, res) => {
    connection.query('SELECT * FROM tx WHERE receiver_id='+req.body.receiver_id+', sender_id='+req.body.sender_id+', amount>='+req.body.amount, function (error, results, fields) {
      if (error) throw error;
      //If not found, return false
      if (typeof results[0] == 'undefined') res.json({result:false})
       // if found, update the balance on sender and receiver, return true
      else {
        res.json({result:true})
      }
    }); 
    // Untuk mengakses properti 'a', gunakan req.body.a
    console.log(req.body.a);
    // Teruskan hey Dandy dan Faldi
    res.send(req.body.a)
})

app.listen(3000, () => console.log("Listening at port 3000..."));

