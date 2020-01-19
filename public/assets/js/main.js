// Add random image in the admin-header
const adminHeaderImage = document.getElementById('admin-header-image');

const headerImagesAdmin = [
  'sideAlbums.jpg',
  'foundIt.jpg',
  'setup.jpg',
  'headPhones.jpg',
  'playing.jpg'
]
let randomImg = Math.floor(Math.random() * headerImagesAdmin.length);
let imgName = headerImagesAdmin[randomImg];

if (window.innerWidth > 1024) {
  adminHeaderImage.style.backgroundImage = `url("../../../public/assets/images/${imgName}")`;
}