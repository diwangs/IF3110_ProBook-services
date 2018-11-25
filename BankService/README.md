# How to use
0. Install mysql
1. Create a database called 'bank'
2. Import from bank.sql
3. Install nodejs
4. ```npm install```
5. run: ```node app.js```


# REST
## ID validation
#### Request
```
http://localhost:3000/api/validate_customer/<id>
```
#### Response
```
{
    "result"        : "true"
}
```

## Create transaction
#### Request
```
{
    "sender_id"    : "<number>",
    "receiver_id"  : "<number>",
    "amount"        : number
}
```
#### Response
```
{
    "result"        : "true",
}
```
```
{
    "result"        : "false",
    "reason"        : "some problem happened"
}
```