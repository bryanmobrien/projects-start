const fs = require('fs');
const path = require('path');

const filePath = path.join(__dirname, 'paintings.json');
const paintings = JSON.parse(fs.readFileSync(filePath));

function getAll() {
  return paintings;
}

function getById(id) {
  return paintings.find(p => p.paintingID == id);
}

function getByGallery(galleryId) {
  return paintings.filter(p => p.gallery.galleryID == galleryId);
}

function getByArtist(artistId) {
  return paintings.filter(p => p.artist.artistID == artistId);
}

function getByYearRange(min, max) {
  return paintings.filter(p => {
    return p.yearOfWork >= min && p.yearOfWork <= max;
  });
}

module.exports = {
  getAll,
  getById,
  getByGallery,
  getByArtist,
  getByYearRange
};