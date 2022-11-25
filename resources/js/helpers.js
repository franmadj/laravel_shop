const capFirstLetter = (val) => val.charAt(0).toUpperCase() + val.slice(1);
const img2xUrl = (val) => `${val.replace(/(\.[\w\d_-]+)$/i, '@2x$1')} 2x`;

export default { capFirstLetter, img2xUrl };