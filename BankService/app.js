const express = require('express');
const bodyParser = require('body-parser');
const app = express();
app.use(bodyParser.json()); // for parsing application/json

// Database
var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '12345678',
  database : 'bank',
  port     : '3306',
  multipleStatements: true
});
connection.connect();

// REST
// Validasi nasabah
app.get("/api/validate_customer/:id", (req, res) => {
    connection.query('SELECT * FROM customer WHERE id='+req.params.id, function (error, results, fields) {
        if (error) throw error;
        // If not found, return false
        if (typeof results[0] == 'undefined') res.json({result:false, reason:"id not found"})
        // if found, return true
        else res.json({result:true})
    });
})

app.post("/api/create_tx", (req, res) => {
    connection.query('SELECT * FROM customer WHERE id='+req.body.sender_id, function (error, results, fields) {
      if (error) throw error;
      // If not found, return false
      if (typeof results[0] == 'undefined') res.json({result:false, reason:"sender_id not found"})
      // if found, return true
      else {
        if (req.body.amount <= results[0].balance) {
          connection.query('UPDATE customer SET balance = balance -'+req.body.amount+' WHERE id='+req.body.sender_id+'; UPDATE customer SET balance = balance +'+req.body.amount+' WHERE id='+req.body.receiver_id+'; INSERT INTO tx VALUES('+req.body.sender_id+','+req.body.receiver_id+', NOW(),'+ req.body.amount+');' , function (error, results, fields){
            if (error) throw error;
            res.json({result:true})
            console.log(res);
          })
        } else {
          res.json({result:false, reason:"insufficient balance"})
        }
      }
    })
})

app.listen(3000, () => console.log("Listening at port 3000..."));

