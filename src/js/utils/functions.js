export const css = (element, style) => {
    for (const property in style)
        element.style[property] = style[property];

    // variant 1
    // note.style.cssText += 'color:red;background-color:yellow';

    // variant 2 use this function
    // css(document.querySelector('.note'), {
    //     'background-color': 'yellow',
    //     color: 'red'
    // });
}

export const removeClassStartsWith = (node, className) => {
    [...node.classList].forEach(v => {
        if (v.startsWith(className)) {
            node.classList.remove(v)
        }
    })
}

export const setCookie = (key, value) => {
    document.cookie = "" + key + "=" + value + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
}

export const getCookie = key => {
    return document.cookie
        .split("; ")
        .find(row => row.startsWith("" + key + "="))
        ?.split("=")[1];
}