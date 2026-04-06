const express = require('express');
const app = express();
const port = 3000;

const data = require('./data-provider');

// static folder
app.use(express.static('static'));


// ===================== ROUTES =====================

// "/" → all paintings
app.get('/', (req, res) => {
  res.json(data.getAll());
});

// "/:id" → single painting
app.get('/:id', (req, res) => {
  const painting = data.getById(req.params.id);
  if (!painting) {
    return res.status(404).json({ error: 'Not found' });
  }
  res.json(painting);
});

// "/gallery/:id"
app.get('/gallery/:id', (req, res) => {
  res.json(data.getByGallery(req.params.id));
});

// "/artist/:id"
app.get('/artist/:id', (req, res) => {
  res.json(data.getByArtist(req.params.id));
});

// "/year/min/max"
app.get('/year/:min/:max', (req, res) => {
  const min = parseInt(req.params.min);
  const max = parseInt(req.params.max);
  res.json(data.getByYearRange(min, max));
});


// ==================================================

app.listen(3000, '0.0.0.0', () => {
  console.log(`Server running on http://localhost:${port}`);
});