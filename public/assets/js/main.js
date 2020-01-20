// Add random image in the admin-header
const adminHeaderImage = document.getElementById('admin-header-image');
let imagePath = document.getElementById('imagePath');

const headerImagesAdmin = [
  'sideAlbums.jpg',
  'foundIt.jpg',
  'setup.jpg',
  'headPhones.jpg',
  'playing.jpg'
]

if (imagePath != null) {
  imagePath = imagePath.innerHTML;
}

let imageLink = (imagePath == null) ? '../../../public/assets/images/' : imagePath;
let randomImg = Math.floor(Math.random() * headerImagesAdmin.length);
let imgName = headerImagesAdmin[randomImg];

if (window.innerWidth > 1024) {
  adminHeaderImage.style.backgroundImage = `url("${imageLink}${imgName}")`;
}