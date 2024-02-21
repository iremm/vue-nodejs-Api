// include Express and MySQL modules cause I use phpmyadmin 
import express from 'express';
import mysql from 'mysql';

//ı prefer port 3000 
const app = express();
const PORT = 3000;

//db information
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    database: 'vue_laravel'
  });
  

db.connect((err) => {
  if (err) {
    throw err;
  }
  console.log('MySQL database connected');
});

app.use(express.json());


//db add transactions
app.post('/users', (req, res) => {
  const { firstname, lastname } = req.body;
  const INSERT_USER_QUERY = `INSERT INTO users (firstname, lastname) VALUES ('${firstname}', '${lastname}')`;
  db.query(INSERT_USER_QUERY, (err, result) => {
    if (err) {
      res.status(500).send(err);
    } else {
      res.status(201).send('User added successfully');
    }
  });
});

//db list transactions
app.get('/users', (req, res) => {
  const SELECT_USERS_QUERY = 'SELECT * FROM users';
  db.query(SELECT_USERS_QUERY, (err, results) => {
    if (err) {
      res.status(500).send(err);
    } else {
      res.status(200).json(results);
    }
  });
});

//db update transactions
app.put('/users/:id', (req, res) => {
  const userId = req.params.id;
  const { firstname, lastname } = req.body;
  const UPDATE_USER_QUERY = `UPDATE users SET firstname = '${firstname}', lastname = '${lastname}' WHERE id = ${userId}`;
  db.query(UPDATE_USER_QUERY, (err, result) => {
    if (err) {
      res.status(500).send(err);
    } else {
      res.status(200).send('User updated successfully');
    }
  });
});

//db delete transactions
app.delete('/users/:id', (req, res) => {
  const userId = req.params.id;
  const DELETE_USER_QUERY = `DELETE FROM users WHERE id = ${userId}`;
  db.query(DELETE_USER_QUERY, (err, result) => {
    if (err) {
      res.status(500).send(err);
    } else {
      res.status(200).send('User deleted successfully');
    }
  });
});

app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
