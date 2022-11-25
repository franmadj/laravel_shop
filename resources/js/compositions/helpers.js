import { message } from "laravel-mix/src/Log";

const capFirstLetter = (val) => val.charAt(0).toUpperCase() + val.slice(1);
const img2xUrl = (val) => `${val.replace(/(\.[\w\d_-]+)$/i, '@2x$1')} 2x`;
const slugify = (str) => {
    str = str.replace(/^\s+|\s+$/g, '');

    // Make the string lowercase
    str = str.toLowerCase();

    // Remove accents, swap ñ for n, etc
    var from = "ÁÄÂÀÃÅČÇĆĎÉĚËÈÊẼĔȆÍÌÎÏŇÑÓÖÒÔÕØŘŔŠŤÚŮÜÙÛÝŸŽáäâàãåčçćďéěëèêẽĕȇíìîïňñóöòôõøðřŕšťúůüùûýÿžþÞĐđßÆa·/_,:;";
    var to = "AAAAAACCCDEEEEEEEEIIIINNOOOOOORRSTUUUUUYYZaaaaaacccdeeeeeeeeiiiinnooooooorrstuuuuuyyzbBDdBAa------";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    // Remove invalid chars
    str = str.replace(/[^a-z0-9 -]/g, '')
        // Collapse whitespace and replace by -
        .replace(/\s+/g, '-')
        // Collapse dashes
        .replace(/-+/g, '-');

    return str;
}

const getFileFromUrl = async(url, name, defaultType = 'image/jpeg') => {
    const response = await fetch(url);
    const data = await response.blob();
    return new File([data], name, {
        type: data.type || defaultType,
    });

}

const makeTextErrors = (error) => {
    if (error.response) {
        let data = error.response.data
        if ("The given data was invalid." == data.message) {
            message = '';
            for (const [key, value] of Object.entries(data.errors)) {
                console.log(`${key}: ${value}`);
                message += `<p>${value}</p>`
            }
            return message;


        }
    }
    return error
}

const testJSON = (text) => {
    if (typeof text !== "string") {
        return false;
    }
    try {
        JSON.parse(text);
        return true;
    } catch (error) {
        return false;
    }
}


export default { capFirstLetter, img2xUrl, slugify, getFileFromUrl, makeTextErrors, testJSON };